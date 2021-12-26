<?php

namespace Modules\Student\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use phpDocumentor\Reflection\Types\Boolean;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Str;


class FinalReportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Private Function
    |--------------------------------------------------------------------------
    */
    private function checkFR($id): bool
    {
        $check = DB::table('app-final_report')->where('group_uid', $id)->count();
        if ($check == 0) {
            return false;
        } else {
            return true;
        }
    }

    private function checkFR_rev($id): int
    {
        $stat = DB::table('app-final_report')->where('group_uid', $id)->orderBy('fr_rev_count', 'DESC')->first();
        if ($stat->fr_rev_stat === NULL) {
            $stat = 0;
            return $stat->fr_rev_stat;
        } else {
            return $stat->fr_rev_stat;
        }
    }

    private function getProkerCount($id): int
    {
        $count = DB::table('app-proker-list')->where('group_uid', $id)->count();
        if ($count === NULL) {
            $count = 0;
            return $count;
        } else {
            return $count;
        }
    }

    private function getDailyReportCount($id): int
    {
        $count = DB::table('app-daily_report')->where('group_uid', $id)->count();
        return $count;
    }

    private function getLastDailyReport($id)
    {
        $check = DB::table('app-daily_report')->orderBy('report_date', 'DESC')->first();
        $date = [];
        if ($check === NULL) {
            $date = 0;
        } else {
            $date = $check->report_date;
        }
        return $date;
    }

    private function getFrStat($id)
    {
        $check = DB::table('app-faculty_student-group')->where('unique_id', $id)->value('fr_acc_stat');
        return $check;
    }

    private function getKknStat($id)
    {
        $check = DB::table('app-faculty_student-group')->where('unique_id', $id)->value('kkn_finished_stat');
        return $check;
    }
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

    /*
    |--------------------------------------------------------------------------
    | Public Function
    |--------------------------------------------------------------------------
    */
    public function status()
    {
        if (self::check_assign()) {
            $user = Auth::user();
            $user_id = $user['id'];
            $gid = DB::table('app-faculty_student')->where('student_id', $user_id)->value('group_uid');

            $fr_stat = 0;
            $rev_stat = 0;
            if (self::checkFR($gid)) {
                $fr_stat = 1;
                $rev_stat = self::checkFR_rev($gid);
            }


            $prokerCount = self::getProkerCount($gid);
            $dailyReportCount = self::getDailyReportCount($gid);
            $dailyReportLast = self::getLastDailyReport($gid);

            $kkn_finish_stat = self::getKknStat($gid);

            return view('student::pages.proker.final_report.final_report-status', compact('rev_stat', 'prokerCount', 'dailyReportCount', 'dailyReportLast', 'kkn_finish_stat'));
        } else {
            echo "<script type='text/javascript'>
            alert('Anda belum terhubung dengan kelompok, masukkan token terlebih dahulu.');
        </script>";
            return view('student::pages.group.group-assign');
        }
    }


    public function submission()
    {
        return view('student::pages.proker.final_report.upload_form.final_report-submission');
    }


    public function submission_upload(Request $request)
    {
        $validation = $request->validate([
            'file'  =>  'required|file|mimes:pdf|max:5120'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];
        $check = DB::table('app-faculty_student')->where('student_id', $user_id)->value('group_uid');
        $gname = DB::table('app-faculty_student-group')->where('unique_id', $check)->value('group_name');


        $dateS = Carbon::now()->addHours(7)->toDateTimeString();
        $dateF = str_replace(':', '_', $dateS);


        $file = $validation['file'];
        $fileName = $gname . '-FinalReport' . '-REV-0_(' . $dateF . ')-' . $file->getClientOriginalName();

        $path = $file->storeAs('FinalReport/' . $gname, $fileName);
        $visibility = Storage::getVisibility($path);
        $rn = Str::random(35);
        while (DB::table('app-final_report')->where('fr_uid', $rn)->exists()) {
            $rn = Str::random(35);
        }

        DB::table('app-final_report')->insert([
            'group_uid' => $check,
            'fr_rev_stat' => 1,
            'fr_filename' => $fileName,
            'fr_submitted_date' => $dateS,
            'fr_uid' => $rn,
            'fr_rev_count' => 0
        ]);

        $msg = 1;
        return redirect('/student/proker/final-report')->with('message', 'Laporan Akhir di Submit');
        //return view('student::pages.proker.final_report.upload_form.final_report-submission', ['msg' => $msg]);
    }

    public function revision()
    {
        if (self::check_assign()) {
            $user = Auth::user();
            $user_id = $user['id'];
            $check = DB::table('app-faculty_student')->where('student_id', $user_id)->value('group_uid');
            $data = DB::table('app-final_report')->where('group_uid', $check)->orderBy('fr_rev_count', 'DESC')->get();
            //dd($data);
            return view('student::pages.proker.final_report.revisi.final_report-revisi-index', ['data' => $data]);
        } else {
            echo "<script type='text/javascript'>
            alert('Anda belum terhubung dengan kelompok, masukkan token terlebih dahulu.');
        </script>";
            return view('student::pages.group.group-assign');
        }
    }

    public function revision_detail($id)
    {
        $data = DB::table('app-final_report')->where('fr_uid', $id)->first();

        $gname = DB::table('app-faculty_student-group')->where('unique_id', $data->group_uid)->value('group_name');
        //dd($data);
        $revData = DB::table('app-final_report')->where('group_uid', $data->group_uid)->where('fr_rev_count', $data->fr_rev_count+1)->first();
        //dd($revData);
        return view('student::pages.proker.final_report.revisi.final_report-revisi-detail', compact('data', 'gname', 'revData'));
    }

    public function revision_submit(Request $request)
    {
        $validation = $request->validate([
            'file'  =>  'required|file|mimes:pdf|max:5120'
        ]);

        $user = Auth::user();
        $user_id = $user['id'];
        $check = DB::table('app-faculty_student')->where('student_id', $user_id)->value('group_uid');
        $gname = DB::table('app-faculty_student-group')->where('unique_id', $check)->value('group_name');

        $data = DB::table('app-final_report')->where('fr_uid', $request->fr_uid)->first();

        $dateS = Carbon::now()->addHours(7)->toDateTimeString();
        $dateF = str_replace(':', '_', $dateS);

        $file = $validation['file'];
        $fileName = $gname . '-FinalReport' . '-REV-' . (($data->fr_rev_count) + 1) . '_(' . $dateF . ')-' . $file->getClientOriginalName();

        $path = $file->storeAs('FinalReport/' . $gname, $fileName);
        $visibility = Storage::getVisibility($path);
        $rn = Str::random(35);
        while (DB::table('app-final_report')->where('fr_uid', $rn)->exists()) {
            $rn = Str::random(35);
        }

        DB::table('app-final_report')->insert([
            'group_uid' => $check,
            'fr_rev_stat' => 2,
            'fr_filename' => $fileName,
            'fr_submitted_date' => $dateS,
            'fr_uid' => $rn,
            'fr_rev_count' => ($data->fr_rev_count) + 1,
            'fr_student_rev_comment' => $request->rev_comment
        ]);
        DB::table('app-final_report')->where('fr_uid', $request->fr_uid)->update([
            'fr_revised' => 1
        ]);

        
        return redirect()->route('student.proker-final_report')->with('message', 'Revisi Diajukan');
    }


    public function getFile($id)
    {

        $user = Auth::user();
        $user_id = $user['id'];
        $check = DB::table('app-faculty_student')->where('student_id', $user_id)->value('group_uid');
        $gname = DB::table('app-faculty_student-group')->where('unique_id', $check)->value('group_name');

        $fileName = $id;
        $path = ('FinalReport/') . $gname . ('/') . $fileName;
        return response()->file(Storage::path($path));
    }



    public function final_submission()
    {
        if (self::check_assign()) {
            $user = Auth::user();
            $user_id = $user['id'];
            $gid = DB::table('app-faculty_student')->where('student_id', $user_id)->value('group_uid');


            $groupName = DB::table('app-faculty_student-group')->where('unique_id', $gid)->value('group_name');
            $groupLocation = DB::table('app-faculty_student-group')->where('unique_id', $gid)->value('village_name');

            $mentor_id = DB::table('app-faculty_student-group')->where('unique_id', $gid)->value('group_mentor_id');
            $mentor = DB::table('app-faculty_dosen')->where('dosen_id', $mentor_id)->value('name');

            $member_data = [];
            if ($gid === NULL) {
                $member_data = [];
            } else {
                $member_data = DB::table('app-faculty_student')->where('group_uid', $gid)->orderBy('name', 'asc')->get();
            }
            $proker_data = DB::table('app-proker-list')->where('group_uid', $gid)->get();
            $proker_count = DB::table('app-faculty_student-group')->where('unique_id', $gid)->value('proker_acc_count');
            $dailyReportCount = self::getDailyReportCount($gid);
            $dailyReportLast = self::getLastDailyReport($gid);

            $fr_stat = self::getFrStat($gid);
            $kkn_finish_stat = self::getKknStat($gid);

            return view('student::pages.proker.final_report.final_submission.final_report-final_submission', compact('member_data', 'mentor', 'groupName', 'groupLocation', 'proker_data', 'proker_count', 'dailyReportCount', 'dailyReportLast', 'fr_stat', 'kkn_finish_stat'));
        } else {
            echo "<script type='text/javascript'>
            alert('Anda belum terhubung dengan kelompok, masukkan token terlebih dahulu.');
        </script>";
            return view('student::pages.group.group-assign');
        }
    }


    

    public function final_submission_submit(Request $request)
    {
        if ($request->agree == 1) {
            $user = Auth::user();
            $user_id = $user['id'];
            $gid = DB::table('app-faculty_student')->where('student_id', $user_id)->value('group_uid');
            $fr_stat = self::getFrStat($gid);
            if ($fr_stat == 1) {
                DB::table('app-faculty_student-group')->update([
                    'kkn_finished_stat' => 1
                ]);
                return redirect()->route('student.proker-final_report-final_submission');
            } else {
                echo "<script type='text/javascript'>
                alert('Laporan Belum ACC/Selesai.');
            </script>";
                return redirect()->route('student.proker-final_report-final_submission');
            }
        } else {
            echo "<script type='text/javascript'>
                alert('Mohon dicentang tombol pernyataan.');
            </script>";
            return redirect()->route('student.proker-final_report-final_submission');
        }
    }
}
