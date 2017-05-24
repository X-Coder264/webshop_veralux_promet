<?php

namespace App\Http\Controllers;

class AdminCPController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    /*public function showView($name = null)
    {
        if (view()->exists('admin/' . $name)) {
            return view('admin/' . $name);
        } else {
            return view('errors.404');
        }
    }*/
}
