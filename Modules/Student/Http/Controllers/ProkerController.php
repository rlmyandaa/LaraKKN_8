<?php

namespace Modules\Student\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ProkerController extends Controller
{

    private function check_assign(): bool
    {
        $user = Auth::user();
        $user_id = $user['id'];
        $data = DB::table('app-faculty_student')->where('student_id', $user_id)->value('group_uid');
        if ($data === NULL) {

            return false;
        } else {
            return true;
        }
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $user_id = $user['id'];
        $data = DB::table('app-faculty_student')->where('student_id', $user_id)->value('group_uid');
        if ($data === NULL) {
            echo "<script type='text/javascript'>
                alert('Anda belum terhubung dengan kelompok, masukkan token terlebih dahulu.');
            </script>";
            return view('student::pages.group.group-assign');
        } else {
            return view('student::pages.proker.proker-index');
        }
    }


    public function list()
    {
        if (self::check_assign()) {
            $user = Auth::user();
            $user_id = $user['id'];
            $check = DB::table('app-faculty_student')->where('student_id', $user_id)->value('group_uid');

            $ls_pending = DB::table('app-proker-propose_pending')->where('group_uid', $check)->get();
            $ls_acc = DB::table('app-proker-list')->where('group_uid', $check)->get();
            $ls_reject = DB::table('app-proker-propose_reject')->where('group_uid', $check)->get();
            return view('student::pages.proker.list.proker-list', compact('ls_pending', 'ls_acc', 'ls_reject'));
        } else {
            echo "<script type='text/javascript'>
            alert('Anda belum terhubung dengan kelompok, masukkan token terlebih dahulu.');
        </script>";
            return view('student::pages.group.group-assign');
        }
    }
    public function list_pending_remove($id)
    {
        $fileName = DB::table('app-proker-propose_pending')->where('proker_uid', $id)->value('proker_filename');
        DB::table('app-proker-propose_pending')->where('proker_uid', $id)->delete();
        $path = 'Proker/Proposed-Pending/' . $fileName;
        Storage::delete($path);
        return redirect()->route('student.proker-list');
    }


    public function daily_report()
    {
    }


    public function final_report()
    {
    }


    public function getFilePending($id)
    {
        $path = 'Proker/Proposed-Pending/' . $id;
        return response()->file(Storage::path($path));
    }
    public function getFileAcc($id)
    {
        $path = 'Proker/Accepted/' . $id;

        return response()->file(Storage::path($path));
    }
    public function getFileReject($id)
    {
        $path = 'Proker/Rejected/' . $id;

        return response()->file(Storage::path($path));
    }
}
