<?php

namespace App\Http\Controllers;

use Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return view('pages.admin.home');
        }

        if ($user->hasRole('dosen')) { // you can pass an id or slug
            return redirect('/dosen');
        }
        
        if ($user->hasRole('student')) { // you can pass an id or slug
            return redirect('/student');
        }
        
        return view('pages.user.home');
    }
}
