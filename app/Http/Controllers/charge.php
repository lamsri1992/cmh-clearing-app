<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class charge extends Controller
{   
    public function index(){
        $hcode = Auth::user()->hcode;
        $query_count = "SELECT
        (SELECT COUNT(rec_no) FROM claim_er WHERE p_status = '1' AND hcode = $hcode) AS wait,
        (SELECT COUNT(rec_no) FROM claim_er WHERE p_status = '2' AND hcode = $hcode) AS charge,
        (SELECT COUNT(rec_no) FROM claim_er WHERE p_status = '3' AND hcode = $hcode) AS success,
        (SELECT COUNT(rec_no) FROM claim_er WHERE p_status = '4' AND hcode = $hcode) AS deny,
        (SELECT COUNT(rec_no) FROM claim_er WHERE p_status = '5' AND hcode = $hcode) AS confirm,
        (SELECT COUNT(rec_no) FROM claim_er WHERE p_status = '6' AND hcode = $hcode) AS cancel";

        $count = DB::select($query_count);

        $data = DB::table('claim_er')
                ->select('rec_no','date_rx','hcode','hn','h_name','icd10','ambulanc','drug','lab','proc','p_name','p_color',
                DB::raw('drug + lab + proc AS amount,
                IF((drug + lab + proc) > 700, 700, (drug + lab + proc)) AS paid,
                IF(ambulanc > "0", "600", ambulanc) AS paid_am,
                IF((drug + lab + proc) > 700, 700, (drug + lab + proc)) + IF(ambulanc > "0", "600", ambulanc) AS total'))
                ->join('hospital','h_code','claim_er.hospmain')
                ->join('p_status','id','claim_er.p_status')
                ->where('hospmain','!=',$hcode)
                ->where('hcode','=',$hcode)
                ->get();
        return view('charge.index', ['data' => $data,'count' => $count]);
    }

    public function show($id){
        $data = DB::table('claim_er')
                ->select('rec_no','hn','pid','date_rx','date_rec','icd9','icd10','refer','drug','lab','proc','ambulanc','h_name','p_status','p_name','reporter',
                DB::raw('drug + lab + proc AS amount,
                IF((drug + lab + proc) > 700, 700, (drug + lab + proc)) AS paid,
                IF(ambulanc > "0", "600", ambulanc) AS paid_amb,
                IF((drug + lab + proc) > 700, 700, (drug + lab + proc)) + IF(ambulanc > "0", "600", ambulanc) AS total'))
                ->join('hospital','hospital.h_code','claim_er.hospmain')
                ->join('p_status','p_status.id','claim_er.p_status')
                ->where('rec_no',base64_decode($id))
                ->first();
        return view('charge.show', ['data' => $data]);
    }

    public function confirm(Request $request)
    {
        $id = $request->recno;
        $query = DB::table('claim_er')->where('rec_no',$id)->update(["p_status" => 5]);
    }

    public function list(){
        $hcode = Auth::user()->hcode;
        $data = DB::table('claim_er')
                ->select('hospmain','h_name',DB::raw('COUNT(*) AS number,SUM(IF((drug + lab + proc) > 700, 700, (drug + lab + proc)) + IF(ambulanc > "0", "600", ambulanc)) AS total'))
                ->join('hospital','h_code','claim_er.hospmain')
                ->where('hospmain','!=',$hcode)
                ->where('hcode','=',$hcode)
                ->where('p_status','=',5)
                ->groupBy('h_code')
                ->get();
        // dd($data);
        return view('charge.list', ['data' => $data]);
    }

    public function transaction($id)
    {
        $data = DB::table('claim_er')
                ->select('rec_no','date_rx','hcode','hn','h_name','icd10','ambulanc','drug','lab','proc','p_name','p_color',
                DB::raw('drug + lab + proc AS amount,
                IF((drug + lab + proc) > 700, 700, (drug + lab + proc)) AS paid,
                IF(ambulanc > "0", "600", ambulanc) AS paid_am,
                IF((drug + lab + proc) > 700, 700, (drug + lab + proc)) + IF(ambulanc > "0", "600", ambulanc) AS total'))
                ->join('hospital','h_code','claim_er.hospmain')
                ->join('p_status','id','claim_er.p_status')
                ->where('hospmain','=',base64_decode($id))
                ->where('hcode','!=',base64_decode($id))
                ->where('p_status',5)
                ->get();
        // echo($data);
        return view('charge.transaction', ['data' => $data]);
    }

    public function bill(Request $request)
    {
        $data = $request->get('formData');
        $transCode = Auth::user()->hcode."".date('Ym').substr(rand(),1,5);
        foreach($data as $array){
            $id = DB::table('transaction')->insertGetId(
                [
                    'trans_recno' => $array['0'],
                    'trans_vstdate' => $array['1'],
                    'trans_total' => $array['7'],
                    'trans_code' => $transCode,
                    'create_date' => date('Y-m-d')
                ]
            );

            DB::table('claim_er')->where('rec_no',$array['0'])->update(
                [
                    'p_status' => 2,
                    'trans_id' => $transCode,
                ]
            );
        }
    }

    public function sent(){
        $hcode = Auth::user()->hcode;
        $data = DB::table('claim_er')
                ->select('hospmain','h_name',DB::raw('COUNT(DISTINCT trans_id) AS number,SUM(IF((drug + lab + proc) > 700, 700, (drug + lab + proc)) + IF(ambulanc > "0", "600", ambulanc)) AS total'))
                ->join('hospital','h_code','claim_er.hospmain')
                ->where('hospmain','!=',$hcode)
                ->where('hcode','=',$hcode)
                ->where('p_status','=',2)
                ->groupBy('h_code')
                ->get();
        // dd($data);
        return view('charge.sent', ['data' => $data]);
    }

    public function detail(Request $request, $id){
        $data = DB::table('claim_er')
                ->select('rec_no','date_rx','hcode','hn','h_name','icd10','ambulanc','drug','lab','proc','p_name','p_color',
                DB::raw('drug + lab + proc AS amount,
                IF((drug + lab + proc) > 700, 700, (drug + lab + proc)) AS paid,
                IF(ambulanc > "0", "600", ambulanc) AS paid_am,
                IF((drug + lab + proc) > 700, 700, (drug + lab + proc)) + IF(ambulanc > "0", "600", ambulanc) AS total'))
                ->join('hospital','h_code','claim_er.hospmain')
                ->join('p_status','id','claim_er.p_status')
                ->where('trans_id',$id)
                ->get();
        // echo($data);
        return view('charge.detail', ['data' => $data,'id'=>$id]);
    }

}
