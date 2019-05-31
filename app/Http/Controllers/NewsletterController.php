<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Newsletter\NewsletterFacade as Newsletter;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $email = $request->input('email');
        if (! Newsletter::hasMember($email)) {
            Newsletter::subscribe($email);
        }
        echo Newsletter::lastActionSucceeded();
    }
}
