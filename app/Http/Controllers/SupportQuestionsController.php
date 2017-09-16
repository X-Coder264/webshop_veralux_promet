<?php

namespace App\Http\Controllers;

use App\Mail\SupportQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use ReCaptcha\ReCaptcha;

class SupportQuestionsController extends Controller
{
    public function store(Request $request)
    {
        if ($this->captchaCheck($request) === false) {
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

        return back()->with('success', "Vaš upit je uspješno poslan.");
    }

    /**
     * Robot - captcha check.
     *
     * @param  Request  $request
     * @return boolean
     */
    public function captchaCheck(Request $request)
    {
        $response = $request->input('g-recaptcha-response');
        $remoteIp = $_SERVER['REMOTE_ADDR'];
        $secret = env('RE_CAP_SECRET');

        $recaptcha = new ReCaptcha($secret);
        $resp = $recaptcha->verify($response, $remoteIp);
        if ($resp->isSuccess()) {
            return true;
        } else {
            return false;
        }
    }
}