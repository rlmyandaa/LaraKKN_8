<?php

namespace Modules\Dosen\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Storage;

class DailyReportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Private Function
    |--------------------------------------------------------------------------
    */
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
        $dailyReportCount = array();
        $dailyReportLast = array();
        foreach ($data as $d) {
            $temp_uid = $d->unique_id;
            $reportCount = self::getDailyReportCount($temp_uid);
            $reportLast = self::getLastDailyReport($temp_uid);
            array_push($dailyReportCount, $reportCount);
            array_push($dailyReportLast, $reportLast);
        }
     

        return view('dosen::pages.management.dailyreport.dailyreport-index', compact('data', 'dailyReportCount', 'dailyReportLast'));
    }

    public function group_detail($id)
    {
        $daily_data = DB::table('app-daily_report')->where('group_uid', $id)->get();
        $gname = DB::table('app-faculty_student-group')->where('unique_id', $id)->value('group_name');
        return view('dosen::pages.management.dailyreport.detail.dailyreport-detail', compact('daily_data', 'gname'));
    }

    public function daily_detail($id)
    {
        $data = DB::table('app-daily_report')->where('report_uid', $id)->get();
        $gid = DB::table('app-daily_report')->where('report_uid', $id)->value('group_uid');
        $gname = DB::table('app-faculty_student-group')->where('unique_id', $gid)->value('group_name');
        $sid = DB::table('app-daily_report')->where('report_uid', $id)->value('student_id');
        $student = DB::table('app-faculty_student')->where('nim', $sid)->value('name');
        $dateReport =  $gid = DB::table('app-daily_report')->where('report_uid', $id)->value('report_date');

        $fileCount = DB::table('app-daily_report')->where('report_uid', $id)->value('report_filecount');
        $folderPath = DB::table('app-daily_report')->where('report_uid', $id)->value('report_folderpath');
        $filePath = [];
        $fileList = Storage::files($folderPath);
        $files = array();
        #check if folder is empty/file not found
        ###
        if (!empty($fileList)) {
            for ($i = 0; $i < $fileCount; $i++) {
                $temp = $fileList[$i];
                $fileList[$i] = str_replace($folderPath . ('/'), "", $temp);
                array_push($filePath, encrypt($temp));
            }
            $incI = 0;

            for ($i = 0; $i < $fileCount; $i++) {
                $files[$i][0] = $filePath[$i];
                $files[$i][1] = $fileList[$i];
                $incI++;
            }
        } else {
            $files[0][0] = "Files not exist.";
            $files[0][1] = "Files not exist.";
        }
        return view('dosen::pages.management.dailyreport.detail.dailyreport-daily_detail', compact('data', 'gname', 'student', 'files', 'fileCount', 'dateReport'));
    }

    public function getFile($id)
    {
        try {
            $path = decrypt($id);
        } catch (DecryptException $e) {
            abort(404, 'Files not found on server.');
        }
        return response()->file(Storage::path($path));
    }
}
