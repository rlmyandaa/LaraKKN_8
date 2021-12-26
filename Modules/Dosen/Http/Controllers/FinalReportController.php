<?php

namespace Modules\Dosen\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use DateTime;
use Illuminate\Support\Facades\Storage;

use function PHPSTORM_META\map;

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
        $stat = DB::table('app-final_report')->where('group_uid', $id)->orderBy('fr_submitted_date', 'DESC')->first();
        $stat = $stat->fr_rev_stat;
        if ($stat === NULL) {
            $stat = 0;
            return $stat;
        } else {
            return $stat;
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

    private function submitRev($id, $request): int
    {
        if ($request->rev_comment === NULL || $request->rev_comment == '') {
            echo "<script type='text/javascript'>
                alert('Mohon isikan kolom komentar jika akan memberikan revisi.');
            </script>";
            $g = 0;
            return $g;
        } else {
            $check = DB::table('app-final_report')->where('fr_uid', $id)->first();
            DB::table('app-final_report')->update([
                'fr_rev_stat' => 4,
                'fr_dosen_rev_comment' => $request->rev_comment
            ]);
            $g = 1;
            return $g;
        }
    }

    private function submitAcc($id, $request)
    {
        $check = DB::table('app-final_report')->where('fr_uid', $id)->first();
        DB::table('app-final_report')->where('fr_uid', $id)->update([
            'fr_rev_stat' => 5,
            'fr_acc_stat' => 1
        ]);
        $gid = $check->group_uid;
        DB::table('app-faculty_student-group')->update([
            'fr_acc_stat' => 1
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Public Function
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $user = Auth::user();
        $user_id = $user['id'];
        $mentor_id = DB::table('app-faculty_dosen')->where('dosen_id', $user_id)->value('dosen_id');
        $data = DB::table('app-faculty_student-group')->where('group_mentor_id', $mentor_id)->get();
        $lr_stat = array();

        foreach ($data as $d) {
            $tmp = array();
            $temp = DB::table('app-final_report')->where('group_uid', $d->unique_id)->orderBy('fr_rev_count', 'DESC')->first();
            if (empty($temp)) {
                array_push($lr_stat, 0);
            } else {
                $result = (array) $temp;
                foreach ($result as $s) {
                    array_push($tmp, $s);
                }
                $i = $tmp[2];
                array_push($lr_stat, $i);
            }
        }
        return view('dosen::pages.management.finalreport.finalreport-index', compact('data', 'lr_stat'));
    }

    public function group($id)
    {
        $gid = $id;
        $gname = DB::table('app-faculty_student-group')->where('unique_id', $gid)->value('group_name');

        $fr_stat = 0;
        $rev_stat = 0;
        if (self::checkFR($gid)) {
            $fr_stat = 1;
            $rev_stat = self::checkFR_rev($gid);
        }


        $prokerCount = self::getProkerCount($gid);
        $dailyReportCount = self::getDailyReportCount($gid);
        $dailyReportLast = self::getLastDailyReport($gid);

        return view('dosen::pages.management.finalreport.group.finalreport-group-index', compact('gid', 'rev_stat', 'prokerCount', 'dailyReportCount', 'dailyReportLast', 'gname'));
    }

    public function group_review($id)
    {
        $gid = $id;
        $gname = DB::table('app-faculty_student-group')->where('unique_id', $id)->value('group_name');
        $data = DB::table('app-final_report')->where('group_uid', $id)->orderBy('fr_rev_count', 'DESC')->get();
        return view('dosen::pages.management.finalreport.group.review.finalreport-group-review_list', compact('gid', 'data', 'gname'));
    }

    public function group_review_detail($id)
    {
        $data = DB::table('app-final_report')->where('fr_uid', $id)->first();
        $gid = $data->group_uid;
        $fileName = encrypt($data->fr_filename);
        $gname = DB::table('app-faculty_student-group')->where('unique_id', $gid)->value('group_name');
        $revData = DB::table('app-final_report')->where('group_uid', $data->group_uid)->where('fr_rev_count', $data->fr_rev_count+1)->first();
        //dd($data);
        return view('dosen::pages.management.finalreport.group.review.finalreport-group-review_detail', compact('gid', 'data', 'gname', 'fileName', 'revData'));
    }


    public function group_review_submit(Request $request)
    {
        $uid = $request->fr_uid;
        $gid = DB::table('app-final_report')->where('fr_uid', $uid)->value('group_uid');
        switch ($request->input('action')) {
            case 'accept':
                self::submitAcc($uid, $request);
                return redirect()->route('dosen.management-finalreport-group-review', ['id' => $gid])->with('message', 'Bimbingan Revisi Laporan Selesai');
                break;

            case 'revisi':
                if (self::submitRev($uid, $request) == 0) {
                    return redirect()->route('dosen.management-finalreport-group-review-detail', ['id' => $uid])->with('error', "Mohon isikan kolom komentar jika akan memberikan revisi.");
                } else {
                    return redirect()->route('dosen.management-finalreport-group-review', ['id' => $gid])->with('message', "Revisi Diberikan");
                }
                break;
        }
    }

    public function group_getFile($id)
    {

        $gid = DB::table('app-final_report')->where('fr_uid', $id)->value('group_uid');
        $gname = DB::table('app-faculty_student-group')->where('unique_id', $gid)->value('group_name');
        $fileName = DB::table('app-final_report')->where('fr_uid', $id)->value('fr_filename');
        $path = ('FinalReport/') . $gname . ('/') . $fileName;
        return response()->file(Storage::path($path));
    }
}
