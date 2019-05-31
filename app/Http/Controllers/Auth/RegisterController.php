<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\User;
use ReCaptcha\ReCaptcha;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Jrean\UserVerification\Facades\UserVerification;
use Jrean\UserVerification\Exceptions\UserNotFoundException;
use Jrean\UserVerification\Exceptions\TokenMismatchException;
use Jrean\UserVerification\Exceptions\UserIsVerifiedException;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, VerifiesUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectAfterVerification = '/login';

    public function __construct()
    {
        $this->middleware('guest', ['except' => ['getVerification', 'getVerificationError']]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => 'required|max:255',
            'company' => 'sometimes|required_with:company_id,max:255',
            'company_id' => 'sometimes|required_with:company,max:255',
            'post' => 'required|max:255',
            'place' => 'required|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'g-recaptcha-response'  => 'required',
        ];

        $messages = [
            'name.required' => 'Ime je obavezno polje.',
            'name.max' => 'Ime smije sadržavati maksimalno 255 znakova.',
            'company.required_with' => 'Ukoliko ste unijeli OIB tvrtke, potrebno je unijeti i naziv.',
            'company.max' => 'Naziv tvrtke smije sadržavati maksimalno 255 znakova.',
            'company_id.max' => 'OIB tvrtke smije sadržavati maksimalno 255 znakova.',
            'company_id.required_with' => 'Ukoliko ste unijeli naziv tvrtke, potrebno je unijeti i OIB tvrtke.',
            'post.required' => 'Poštanski broj je obavezno polje.',
            'post.max' => 'Poštanski broj smije sadržavati maksimalno 255 znakova.',
            'place.required' => 'Mjesto je obavezno polje.',
            'place.max' => 'Mjesto smije sadržavati maksimalno 255 znakova.',
            'address.required' => 'Adresa je obavezno polje.',
            'address.max' => 'Adresa smije sadržavati maksimalno 255 znakova.',
            'phone.required' => 'Kontakt broj je obavezno polje.',
            'phone.max' => 'Kontakt broj smije sadržavati maksimalno 255 znakova.',
            'email.required' => 'E-mail je obavezno polje.',
            'email.email' => 'E-mail mora sadržavati strukturu oblika primjer@mail.com.',
            'email.max' => 'E-mail smije sadržavati maksimalno 255 znakova.',
            'email.unique' => 'E-mail adresa već postoji u sustavu.',
            'password.required' => 'Lozinka je obavezno polje.',
            'password.min' => 'Lozinka mora sadržavati minimalno 6 znakova.',
            'password.confirmed' => 'Lozinke se ne podudaraju.',
            'g-recaptcha-response.required' => 'Google Captcha je obavezna.',
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * Robot - captcha check.
     *
     * @return boolean
     */
    public function captchaCheck(Request $request)
    {
        $response = $request->input('g-recaptcha-response');
        $remoteIp = $request->ip();
        $secret = config('services.recaptcha.secret');

        $recaptcha = new ReCaptcha($secret);
        $resp = $recaptcha->verify($response, $remoteIp);
        if ($resp->isSuccess()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'], ['rounds' => 15]),
            'postal' => $data['post'],
            'city' => $data['place'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'company' => $data['company'] ?? '',
            'company_id' => $data['company_id'] ?? '',
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @return \Illuminate\Http\Response | \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        if (false === $this->captchaCheck($request)) {
            return redirect()->back()
                ->withErrors('Google Captcha je neispravna.')
                ->withInput();
        }

        event(new Registered($user = $this->create($request->all())));

        // the first user to register is gonna be an admin by default
        if (1 === $user->id) {
            $user->admin = true;
            $user->save();
        }

        UserVerification::generate($user);
        UserVerification::send($user, 'Aktivacija korisničkog računa', 'info@veraluxpromet.hr', 'Veralux-Promet d.o.o.');

        return redirect(
            $this->redirectPath()
        )->with(
            'warning',
            'Poslana je aktivacijska poveznica na ' . $user->email .
            '. Kliknite na dobivenu poveznicu kako biste aktivirali Vaš korisnički račun.'
        );
    }

    /**
     * Handle the user verification.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\Response
     */
    public function getVerification(Request $request, $token)
    {
        if (! $this->validateRequest($request)) {
            return redirect($this->redirectIfVerificationFails());
        }

        try {
            UserVerification::process($request->input('email'), $token, $this->userTable());
        } catch (UserNotFoundException $e) {
            return redirect($this->redirectIfVerificationFails());
        } catch (UserIsVerifiedException $e) {
            return redirect($this->redirectIfVerified());
        } catch (TokenMismatchException $e) {
            return redirect($this->redirectIfVerificationFails());
        }

        return redirect($this->redirectAfterVerification())->with(
            'success',
            'Vaš korisnički račun uspješno je aktiviran. Prijavite se u sustav.'
        );
    }
}
