<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelLocalization;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('switchLang');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function switchLang(String $lang = 'ar')
    {
        $currentLocale = session()->has('locale') ? session('locale') : app()->getLocale();
        if (in_array($lang, LaravelLocalization::getSupportedLanguagesKeys())) {
            session()->put('locale', $lang);
        }

        $desiredUrl = str_replace("/$currentLocale", '', url()->previous());

        return redirect($desiredUrl)->withInput();
    }
}
