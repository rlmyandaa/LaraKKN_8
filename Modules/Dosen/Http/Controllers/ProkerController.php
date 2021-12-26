<?php

namespace Modules\Dosen\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class ProkerController extends Controller
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
        $data = DB::table('app-faculty_student-group')->where('group_mentor_id', $mentor_id)->get();
        
        $groupPendingName = array();
        $groupRejectName = array();

        $prokerPendingName = array();
        $prokerPendingUid = array();

        $prokerRejectName = array();
        $prokerRejectComment = array();
        $prokerRejectFileName = array();

        foreach ($data as $dd) {
            $pendingList = DB::table('app-proker-propose_pending')->where('group_uid', $dd->unique_id)->get();
            $rejectList = DB::table('app-proker-propose_reject')->where('group_uid', $dd->unique_id)->get();
            foreach ($pendingList as $d) {
                $temp = DB::table('app-faculty_student-group')->where('unique_id', $d->group_uid)->value('group_name');
                array_push($groupPendingName, $temp);
                $temp = DB::table('app-proker-propose_pending')->where('group_uid', $d->group_uid)->get();
                foreach($temp as $t){
                    $ret = $t->proker_name;
                    $uid = $t->proker_uid;
                    array_push($prokerPendingName, $ret);
                    array_push($prokerPendingUid, $uid);
                }
            }
            foreach ($rejectList as $r) {
                $temp = DB::table('app-faculty_student-group')->where('unique_id', $r->group_uid)->value('group_name');
                array_push($groupRejectName, $temp);
                $temp = DB::table('app-proker-propose_reject')->where('group_uid', $r->group_uid)->get();
                foreach($temp as $t){
                    $ret = $t->proker_name;
                    $com = $t->proker_decline_comment;
                    $fn = $t->proker_filename;
                    array_push($prokerRejectName, $ret);
                    array_push($prokerRejectComment, $com);
                    array_push($prokerRejectFileName, $fn);
                }
            }
        }




        return view('dosen::pages.management.proker.proker-index', compact('data', 'groupPendingName', 'prokerPendingUid', 'groupRejectName', 'prokerPendingName', 'prokerRejectName', 'prokerRejectComment', 'prokerRejectFileName'));
    }

    public function detail($id)
    {
        $data = DB::table('app-proker-propose_pending')->where('proker_uid', $id)->first();
        $gid = $data->group_uid;
        $fileName = encrypt($data->proker_filename);

        $gname = DB::table('app-faculty_student-group')->where('unique_id', $gid)->value('group_name');
        return view('dosen::pages.management.proker.detail.proker-pending-detail', compact('data', 'gname', 'fileName'));
    }

    public function getFileAcc($id)
    {
        $fileName = decrypt($id);
        $path = 'Proker/Accepted/' . $fileName;
        return response()->file(Storage::path($path));
    }
    public function getFilePending($id)
    {
        $fileName = decrypt($id);
        $path = 'Proker/Proposed-Pending/' . $fileName;
        return response()->file(Storage::path($path));
    }

    public function getFileReject($id)
    {
        $fileName = $id;
        $path = 'Proker/Rejected/' . $fileName;
        return response()->file(Storage::path($path));
    }




    public function proposal_decide(Request $request)
    {
        $uid = $request->proker_uid;
        switch ($request->input('action')) {
            case 'accept':
                Self::acc($uid, $request);
                return redirect()->route('dosen.management-proker');
                break;

            case 'returned':
                Self::declined($uid, $request);
                return redirect()->route('dosen.management-proker');
                break;
        }
    }

    private function acc($uid, $request)
    {
        $data = DB::table('app-proker-propose_pending')->where('proker_uid', $uid)->first();
        DB::table('app-proker-list')->insert([
            'group_uid' => $data->group_uid,
            'proker_name' => $data->proker_name,
            'proker_category' => $data->proker_category,
            'proker_detail' => $data->proker_detail,
            'proker_filename' => $data->proker_filename,
            'proker_uid' => $data->proker_uid,
            'proker_submit_date' => $data->proker_submit_date,
        ]);

        DB::table('app-proker-propose_pending')->where('proker_uid', $uid)->delete();

        $pendingCount = DB::table('app-faculty_student-group')->where('unique_id', $data->group_uid)->value('proker_pending_count');
        $accCount = DB::table('app-faculty_student-group')->where('unique_id', $data->group_uid)->value('proker_acc_count');
        DB::table('app-faculty_student-group')->where('unique_id', $data->group_uid)->update([
            'proker_pending_count' => $pendingCount - 1,
            'proker_acc_count' => $accCount + 1
        ]);

        $oldPath = 'Proker/Proposed-Pending/' . $data->proker_filename;
        $newPath = 'Proker/Accepted/' . $data->proker_filename;
        Storage::move($oldPath, $newPath);
        Storage::setVisibility($newPath, 'public');
    }
    private function declined($uid, $request)
    {
        if ($request->proker_comment === NULL || $request->proker_comment == '') {
            echo "<script type='text/javascript'>
                alert('Mohon isikan kolom komentar jika akan menolak program kerja.');
            </script>";
            $path = ('/dosen/proker/detail/') . $uid;
        } else {
            $data = DB::table('app-proker-propose_pending')->where('proker_uid', $uid)->first();
            DB::table('app-proker-propose_reject')->insert([
                'group_uid' => $data->group_uid,
                'proker_name' => $data->proker_name,
                'proker_category' => $data->proker_category,
                'proker_detail' => $data->proker_detail,
                'proker_filename' => $data->proker_filename,
                'proker_uid' => $data->proker_uid,
                'proker_submit_date' => $data->proker_submit_date,
                'proker_decline_comment' => $request->proker_comment
            ]);

            DB::table('app-proker-propose_pending')->where('proker_uid', $uid)->delete();
            $pendingCount = DB::table('app-faculty_student-group')->where('unique_id', $data->group_uid)->value('proker_pending_count');

            DB::table('app-faculty_student-group')->where('unique_id', $data->group_uid)->update([
                'proker_pending_count' => $pendingCount - 1,

            ]);
            $oldPath = 'Proker/Proposed-Pending/' . $data->proker_filename;
            $newPath = 'Proker/Rejected/' . $data->proker_filename;
            Storage::move($oldPath, $newPath);
            Storage::setVisibility($newPath, 'public');
        }
    }

    public function group_detail($id)
    {
        $dataPending = DB::table('app-proker-propose_pending')->where('group_uid', $id)->get();
        $dataAcc = DB::table('app-proker-list')->where('group_uid', $id)->get();
        $group_member = DB::table('app-faculty_student')->where('group_uid', $id)->get();
        $gname = DB::table('app-faculty_student-group')->where('unique_id', $id)->value('group_name');
        return view('dosen::pages.management.proker.detail.proker-group-detail', compact('dataAcc', 'dataPending', 'group_member', 'gname'));
    }
}
