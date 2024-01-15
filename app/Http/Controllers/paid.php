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
        $data = DB::table('claim_er')
                ->select('rec_no','date_rx','hcode','hn','h_name','icd10','ambulanc','drug','lab','proc','p_name','p_color',
                DB::raw('drug + lab + proc AS amount,
                IF((drug + lab + proc) > 700, 700, (drug + lab + proc)) AS paid,
                IF(ambulanc > "0", "600", ambulanc) AS paid_am,
                IF((drug + lab + proc) > 700, 700, (drug + lab + proc)) + IF(ambulanc > "0", "600", ambulanc) AS total'))
                ->join('hospital','h_code','claim_er.hcode')
                ->join('p_status','id','claim_er.p_status')
                ->where('hospmain','=',$hcode)
                ->where('hcode','!=',$hcode)
                // ->where('p_status','2')
                ->get();
        return view('paid.index', ['data' => $data]);

    }
    public function show($id){
        $data = DB::table('claim_er')
                ->select('rec_no','hn','pid','date_rx','date_rec','icd9','icd10','refer','drug','lab','proc','ambulanc','h_name','p_name','reporter',
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
}
