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
use DateTime;
use Validator;
use Illuminate\Contracts\Encryption\DecryptException;


class DailyReportController extends Controller
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
        if (self::check_assign()) {
            $user = Auth::user();
            $user_id = $user['id'];
            $check = DB::table('app-faculty_student')->where('student_id', $user_id)->value('group_uid');

            $daily_data = DB::table('app-daily_report')->where('group_uid', $check)->get();

            return view('student::pages.proker.daily_report.daily_report-index', ['daily_data' => $daily_data]);
        }
        else {
            echo "<script type='text/javascript'>
            alert('Anda belum terhubung dengan kelompok, masukkan token terlebih dahulu.');
        </script>";
            return view('student::pages.group.group-assign');
        }
    }
    public function add()
    {
        return view('student::pages.proker.daily_report.daily_report-create');
    }

    public function upload(Request $request)
    {
        $input_data = $request->all();

        $validator = Validator::make(
            $input_data,
            [
                'files.*' => 'required|mimes:jpg,jpeg,png,bmp|max:15000'
            ]
        );


        if ($validator->fails()) {
            $msg = 2;
            return view('student::pages.proker.daily_report.daily_report-create', ['msg' => $msg]);
        } else {

            $dateReport = $request->report_date;
            $dateReportFormatted = DateTime::createFromFormat('Y-m-d', $dateReport)->format('Y-m-d');

            $dateSubmitted = Carbon::now()->addHours(7)->toDateString();
            $dateSubmittedFormatted = DateTime::createFromFormat('Y-m-d', $dateSubmitted)->format('Y-m-d');

            $dateNow = Carbon::now()->addHours(7);

            $user = Auth::user();
            $user_id = $user['id'];
            $student_nim = DB::table('app-faculty_student')->where('student_id', $user_id)->value('nim');
            $group_uid = DB::table('app-faculty_student')->where('student_id', $user_id)->value('group_uid');
            $gname = DB::table('app-faculty_student-group')->where('unique_id', $group_uid)->value('group_name');

            $paths = [];
            $files = $request->file('files');
            $fileCount = 0;

            $dateNow = str_replace(':', '-', $dateNow);


            $folderPath = ('Daily Report/') . $gname . ('/') . $dateReportFormatted . ('_') . $dateNow;
            foreach ($files as $file) {

                $fileCount = $fileCount + 1;
                // Generate a file name with extension
                $fileName = $gname . '-' . $dateReportFormatted . '-docFile_' . $fileCount . ('.') . $file->getClientOriginalExtension();
                // Save the file
                $paths[] = $file->storeAs($folderPath, $fileName);
            }

            $rn = Str::random(35);
            while (DB::table('app-daily_report')->where('report_uid', $rn)->exists()) {
                $rn = Str::random(35);
            }

            DB::table('app-daily_report')->insert([
                'group_uid' => $group_uid,
                'student_id' => $student_nim,
                'report_detail' => $request->report_detail,
                'report_date' => $dateReportFormatted,
                'report_date_submitted' => $dateSubmittedFormatted,
                'report_folderpath' => $folderPath,
                'report_filecount' => $fileCount,
                'report_uid' => $rn
            ]);

            $msg = 1;
            return view('student::pages.proker.daily_report.daily_report-create', ['msg' => $msg]);
        }
    }

    public function detail($id)
    {
        $data = DB::table('app-daily_report')->where('report_uid', $id)->get();
        $gid = DB::table('app-daily_report')->where('report_uid', $id)->value('group_uid');
        $gname = DB::table('app-faculty_student-group')->where('unique_id', $gid)->value('group_name');
        $sid = DB::table('app-daily_report')->where('report_uid', $id)->value('student_id');
        $student = DB::table('app-faculty_student')->where('nim', $sid)->value('name');
        $dateReportFormatted =  $gid = DB::table('app-daily_report')->where('report_uid', $id)->value('report_date');
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
        return view('student::pages.proker.daily_report.daily_report-detail', compact('data', 'gname', 'student', 'files', 'fileCount'));
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

    public function delete($id)
    {
        $path = DB::table('app-daily_report')->where('report_uid', $id)->value('report_folderpath');
        DB::table('app-daily_report')->where('report_uid', $id)->delete();
        Storage::deleteDirectory($path);
        return redirect()->route('student.proker-daily_report');
    }
}
