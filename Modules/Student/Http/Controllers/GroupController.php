<?php

namespace Modules\Student\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use PDO;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $user_id = $user['id'];
        $check = DB::table('app-faculty_student')->where('student_id', $user_id)->value('group_uid');
        if ($check === NULL || $check === '') {
            echo "<script type='text/javascript'>
                alert('Anda belum terhubung dengan kelompok, masukkan token terlebih dahulu.');
            </script>";
            return view('student::pages.group.group-assign');
        } else {
            $mentor_id = DB::table('app-faculty_student-group')->where('unique_id', $check)->value('group_mentor_id');
            $dosen = DB::table('app-faculty_dosen')->where('dosen_id', $mentor_id)->get();
            $data = DB::table('app-faculty_student-group')->where('unique_id', $check)->get();

            $member_data = DB::table('app-faculty_student')->where('group_uid', $check)->orderBy('name', 'asc')->get();

            return view('student::pages.group.group', compact('data', 'dosen', 'member_data'));
        }
    }

    public function token_update(Request $request)
    {
        $token = $request->token;
        $gid = DB::table('app-faculty_student-group')->where('token', $token)->value('unique_id');
        if ($gid == NULL) {
            echo "<script type='text/javascript'>
                alert('Token Tidak Ditemukan.');
            </script>";
        } else {
            echo "<script type='text/javascript'>
                alert('Token  Ditemukan.');
            </script>";
        }


        $user = Auth::user();
        $user_id = $user['id'];
        DB::table('app-faculty_student')->where('student_id', $user_id)->update([
            'group_uid' => $gid
        ]);
        $member = DB::table('app-faculty_student-group')->where('token', $token)->value('member_registered');
        $member = $member + 1;
       
        DB::table('app-faculty_student-group')->where('token', $token)->update([
            'member_registered' => $member
        ]);
        return redirect('/student/group');
    }
}
