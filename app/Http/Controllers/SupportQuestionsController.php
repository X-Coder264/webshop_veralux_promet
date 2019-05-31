<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use ReCaptcha\ReCaptcha;
use Illuminate\Http\Request;
use App\Mail\SupportQuestion;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SupportQuestionsController extends Controller
{
    public function store(Request $request)
    {
        if (false === $this->captchaCheck($request)) {
            return redirect()->back()
                ->withErrors('Google Captcha je neispravna.')
                ->withInput();
        }

        $data = $request->all();

        $rules = [
            'sender_name' => 'required',
            'sender_email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ];

        $messages = [
            'sender_name.required' => 'Obavezno morate unijeti vaše ime.',
            'sender_email.required' => 'Obavezno morate unijeti vašu email adresu.',
            'sender_email.email' => 'Unešena email adresa nije ispravna.',
            'subject.required' => 'Naslov poruke je obavezan.',
            'message.required' => 'Tekst poruke je obavezno polje.',
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Mail::to('prodaja@veraluxpromet.hr')->send(new SupportQuestion($request->all()));

        return back()->with('success', 'Vaš upit je uspješno poslan.');
    }

    public function captchaCheck(Request $request): bool
    {
        $response = $request->input('g-recaptcha-response');
        $remoteIp = $request->ip();
        $secret = config('services.recaptcha.secret');

        $recaptcha = new ReCaptcha($secret);
        $resp = $recaptcha->verify($response, $remoteIp);

        if ($resp->isSuccess()) {
            return true;
        }

        return false;
    }
}
