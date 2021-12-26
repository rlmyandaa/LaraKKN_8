<?php

namespace Modules\Student\Http\Controllers;

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

        $data = DB::table('app-faculty_student')->where('student_id', $user_id)->get();
        /**echo "<script type='text/javascript'>alert('$data');</script>";*/
        return view('student::pages.profile.profile', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
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
        DB::table('app-faculty_student')->insert([
            'student_id' => $user_id,
            'name' => $request->nama,
            'nim' => $request->nim,
            'gender' => $request->gender,
            'year_in' => $request->angkatan,
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
        return redirect("/student/profile");
    }

    public function edit()
    {
        $user = Auth::user();
        $user_id = $user['id'];
        $data = DB::table('app-faculty_student')->where('student_id', $user_id)->get();
        return view('student::pages.profile.profile-edit', ['data' => $data]);
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
        DB::table('app-faculty_student')->where('student_id', $user_id)->update([
            'name' => $request->nama,
            'nim' => $request->nim,
            'gender' => $request->gender,
            'year_in' => $request->angkatan,
            'faculty' => $request->faculty,
            'major' => $request->jurusan,
            'phone' => $request->telepon,
            'email' => $request->email,
            'address' => $request->alamat
        ]);

        return redirect("/student/profile");
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
