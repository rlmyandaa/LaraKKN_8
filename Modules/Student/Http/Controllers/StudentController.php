<?php

namespace Modules\Student\Http\Controllers;

use Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class StudentController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('student')) { // you can pass an id or slug
            if ($user['profile'] == 0) {
                return view('student::pages.profile.create-profile');
            }
            return view('student::index');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
