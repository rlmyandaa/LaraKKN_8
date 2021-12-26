<?php

namespace Modules\Student\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProkerProposeController extends Controller
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

    public function propose()
    {
        if (self::check_assign()) {
            return view('student::pages.proker.propose.proker-propose');
        } else {
            echo "<script type='text/javascript'>
            alert('Anda belum terhubung dengan kelompok, masukkan token terlebih dahulu.');
        </script>";
            return view('student::pages.group.group-assign');
        }
    }
    public function propose_upload(Request $request)
    {
        $validation = $request->validate([
            'file'  =>  'required|file|mimes:pdf|max:1024'
        ]);


        $user = Auth::user();
        $user_id = $user['id'];
        $check = DB::table('app-faculty_student')->where('student_id', $user_id)->value('group_uid');
        $gname = DB::table('app-faculty_student-group')->where('unique_id', $check)->value('group_name');

        $date = Carbon::now()->addHours(7)->toDateTimeString();
        $dateF = str_replace(':', '_', $date);

        $file = $validation['file'];
        $fileName = $gname . '-' . $request->proker_name . '-(' . $dateF . ')-' . $file->getClientOriginalName();

        $path = $file->storeAs('Proker/Proposed-Pending', $fileName);
        $visibility = Storage::getVisibility($path);
        $rn = Str::random(35);
        while (DB::table('app-proker-propose_pending')->where('proker_uid', $rn)->exists()) {
            $rn = Str::random(35);
        }
        DB::table('app-proker-propose_pending')->insert([
            'group_uid' => $check,
            'proker_name' => $request->proker_name,
            'proker_category' => $request->proker_category,
            'proker_detail' => $request->proker_detail,
            'proker_filename' => $fileName,
            'proker_uid' => $rn,
            'proker_submit_date' => $date
        ]);
        $pending = DB::table('app-faculty_student-group')->where('unique_id', $check)->value('proker_pending_count');
        DB::table('app-faculty_student-group')->where('unique_id', $check)->update([
            'proker_pending_count' => $pending + 1
        ]);

        $msg = 1;
        return view('student::pages.proker.propose.proker-propose', ['msg' => $msg]);
    }
    public function getFormatProker()
    {
        $path = 'Proker/FORMAT_PROKER.PDF';

        return response()->file(Storage::path($path));
    }
}
