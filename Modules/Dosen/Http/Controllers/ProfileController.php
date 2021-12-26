<?php

namespace Modules\Dosen\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $user_id = $user['id'];

        $data = DB::table('app-faculty_dosen')->where('dosen_id', $user_id)->get();
        /**echo "<script type='text/javascript'>alert('$data');</script>";*/
        return view('dosen::pages.profile.profile', ['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $user_id = $user['id'];
        $user_mail = $user['email'];
        DB::table('app-faculty_dosen')->insert([
            'dosen_id' => $user_id,
            'name' => $request->nama,
            'nip' => $request->nip,
            'gender' => $request->gender,
            'faculty' => $request->faculty,
            'major' => $request->jurusan,
            'phone' => $request->telepon,
            'email' => $user_mail,
            'address' => $request->alamat
        ]);
        $profile = 1;
        DB::table('users')->where('id', $user_id)->update([
            'profile' => $profile
        ]);
        return redirect("/dosen/profile");
    }



    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit()
    {
        $user = Auth::user();
        $user_id = $user['id'];
        $data = DB::table('app-faculty_dosen')->where('dosen_id', $user_id)->get();
        return view('dosen::pages.profile.profile-edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $user_id = $user['id'];
        DB::table('app-faculty_dosen')->where('dosen_id', $user_id)->update([
            'name' => $request->nama,
            'nip' => $request->nip,
            'gender' => $request->gender,
            'faculty' => $request->faculty,
            'major' => $request->jurusan,
            'phone' => $request->telepon,
            'email' => $request->email,
            'address' => $request->alamat
        ]);

        return redirect("/dosen/profile");
    }


}
