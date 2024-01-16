<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class paid extends Controller
{
    public function index()
    {
        $hcode = Auth::user()->hcode;
        $query_count = "SELECT
        (SELECT COUNT(rec_no) FROM claim_er WHERE p_status = '2' AND hospmain = $hcode) AS charge,
        (SELECT COUNT(rec_no) FROM claim_er WHERE p_status = '8' AND hospmain = $hcode) AS success,
        (SELECT COUNT(rec_no) FROM claim_er WHERE p_status = '4' AND hospmain = $hcode) AS deny";

        $count = DB::select($query_count);
        $data = DB::select("SELECT DISTINCT trans_code,SUM(trans_total) as total,trans_hcode,h_name,create_date
                FROM `transaction`
                LEFT JOIN hospital ON hospital.H_CODE = trans_hcode
                WHERE trans_hmain = {$hcode}
                GROUP BY trans_code,trans_hcode,create_date,trans_paiddate
                ORDER BY trans_id DESC
                LIMIT 10");
        return view('paid.index', ['data' => $data,'count'=>$count]);

    }

    public function detail(Request $request, $id){
        $data = DB::table('claim_er')
                ->select('rec_no','date_rx','hcode','hn','h_name','icd10','ambulanc','drug','lab','proc','p_name','p_color',
                DB::raw('drug + lab + proc AS amount,
                IF((drug + lab + proc) > 700, 700, (drug + lab + proc)) AS paid,
                IF(ambulanc > "0", "600", ambulanc) AS paid_am,
                IF((drug + lab + proc) > 700, 700, (drug + lab + proc)) + IF(ambulanc > "0", "600", ambulanc) AS total'))
                ->join('hospital','h_code','claim_er.hcode')
                ->join('p_status','id','claim_er.p_status')
                ->where('trans_id',$id)
                ->get();
        $check = DB::select("SELECT 
        (SELECT COUNT(*) FROM claim_er WHERE p_status = '3' AND TRANS_ID = $id) AS confirm,
        (SELECT COUNT(*) FROM claim_er WHERE p_status = '4' AND TRANS_ID = $id) AS deny,
        (SELECT COUNT(*) FROM claim_er WHERE p_status = '2' AND TRANS_ID = $id) AS progress");
        $trans = DB::table('transaction')->where('trans_code',$id)->first();
        // echo($data);
        return view('paid.detail', ['data' => $data,'id'=>$id,'check'=>$check,'trans'=>$trans]);
    }

    public function show($id){
        $data = DB::table('claim_er')
                ->select('rec_no','hn','pid','date_rx','date_rec','icd9','icd10','refer','drug','lab','proc','ambulanc',
                'h_name','p_name','reporter','p_status','trans_id',
                DB::raw('drug + lab + proc AS amount,
                IF((drug + lab + proc) > 700, 700, (drug + lab + proc)) AS paid,
                IF(ambulanc > "0", "600", ambulanc) AS paid_amb,
                IF((drug + lab + proc) > 700, 700, (drug + lab + proc)) + IF(ambulanc > "0", "600", ambulanc) AS total'))
                ->join('hospital','hospital.h_code','claim_er.hcode')
                ->join('p_status','p_status.id','claim_er.p_status')
                ->where('rec_no',base64_decode($id))
                ->first();
        return view('paid.show', ['data' => $data]);
    }

    public function confirm(Request $request)
    {
        $date = date('Y-m-d');
        $id = $request->recno;
        DB::table('claim_er')->where('rec_no',$id)->update(["p_status" => 3]);
        DB::table('transaction')->where('trans_recno',$id)->update([
            "trans_status" => 3,
            "trans_confirmdate" => $date
        ]);
    }

    public function transConfirm(Request $request,$id)
    {
        $date = date('Y-m-d');
        DB::table('claim_er')->where('trans_id',$id)->update([
            'p_status' => 7
        ]);

        DB::table('transaction')->where('trans_code',$id)->update([
            'trans_status' => 7,
            'trans_paiddate' => $date
        ]);

        return redirect()->route('paid.list');
    }

    public function list()
    {
        $hcode = Auth::user()->hcode;
        $data = DB::select("SELECT DISTINCT trans_code,SUM(trans_total) as total,trans_hcode,h_name,create_date,trans_paiddate
                FROM `transaction`
                LEFT JOIN hospital ON hospital.H_CODE = trans_hcode
                WHERE trans_hmain = {$hcode}
                AND trans_status = '7'
                GROUP BY trans_code,trans_hcode,create_date,trans_paiddate");
        // dd($data);
        return view('paid.list', ['data' => $data]);
    }

}
