<?php

namespace Modules\Dosen\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Auth;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $user_id = $user['id'];
        $mentor_id = DB::table('app-faculty_dosen')->where('dosen_id', $user_id)->value('dosen_id');
        $data=DB::table('app-faculty_student-group')->where('group_mentor_id', $mentor_id)->get();
        return view('dosen::pages.student.student',['data' => $data]);
    }

    public function add()
    {
        return view('dosen::pages.student.student-add_group');
    }
    
    public function store(Request $request)
    {
        $user = Auth::user();
        $user_id = $user['id'];
        $rn=Str::random(35);
        DB::table('app-faculty_student-group')->insert([
            'group_name' => $request->group_name,
            'village_name' => $request->group_location,
            'member_count' => $request->member_count,
            'group_mentor_id' => $user_id,
            'unique_id' => $rn
        ]);
        return redirect("/dosen/student");
    }
    public function delete($id)
    {
        DB::table('app-faculty_student-group')->where('id',$id)->delete();
        return redirect('/dosen/student');
    }


    public function token($id)
    {
        $data=DB::table('app-faculty_student-group')->where('unique_id', $id)->get();
        return view('dosen::pages.student.student-add_token',['data' => $data]);
    }
    public function token_update(Request $request)
    {
        $check=DB::table('app-faculty_student-group')->where('token', $request->token)->value('id');
        if ($check != 0) {
            echo "<script type='text/javascript'>alert('Token Sudah Terpakai di Kelompok Lain');</script>";
            $data=DB::table('app-faculty_student-group')->where('id', $request->id)->get();
            return view('dosen::pages.student.student-add_token',['data' => $data]);
        }
        
        DB::table('app-faculty_student-group')->where('id', $request->id)->update([
            'token' => $request->token,
            'token_registered' => 1
        ]);
        return redirect("/dosen/student");
    }


    public function detail($id)
    {
        $mentor_id = DB::table('app-faculty_student-group')->where('unique_id', $id)->value('group_mentor_id');
        $dosen = DB::table('app-faculty_dosen')->where('dosen_id', $mentor_id)->get();
        $data = DB::table('app-faculty_student-group')->where('unique_id', $id)->get();
        /**echo "<script type='text/javascript'>alert('$mentor_id');</script>";*/
        $member_data = DB::table('app-faculty_student')->where('group_uid', $id)->orderBy('name', 'asc')->get();
        
        return view('dosen::pages.student.detail.group-detail', compact('data', 'dosen','member_data'));


    }

    public function detail_edit($id)
    {
        $data = DB::table('app-faculty_student-group')->where('unique_id', $id)->get();
        /**echo "<script type='text/javascript'>alert('$data');</script>";*/
        return view('dosen::pages.student.detail.group-detail-edit', ['data' => $data]);
    }

    public function detail_update(Request $request)
    {
        $uid=$request->unique_id;
        DB::table('app-faculty_student-group')->where('unique_id', $request->unique_id)->update([
            'group_name' => $request->group_name,
            'village_name' => $request->village_name,
            'member_count' => $request->member_count,
            'village_center_address' => $request->village_center_address,
            'village_head_name' => $request->village_head_name,
            'village_head_phone' => $request->village_head_phone,
            'babinsa_name' => $request->babinsa_name,
            'babinsa_phone' => $request->babinsa_phone
        ]);
        return redirect("/dosen/student/detail/{$uid}");
    }
}
