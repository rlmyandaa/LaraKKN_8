<?php

namespace Modules\Dosen\Http\Controllers;

use Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class DosenController extends Controller
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
        if ($user->hasRole('dosen')) { // you can pass an id or slug
            if ($user['profile'] == 0) {
                return view('dosen::pages.profile.create-profile');
            }
            return view('dosen::index');
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
