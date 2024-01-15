<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Auth;

class dashboard extends Controller
{
    public function index()
    {
        $hcode = Auth::user()->hcode;
        $creditor = DB::table('claim_er')
                ->select(DB::raw('SUM(drug + lab + proc) AS total'))
                ->where('hcode','=',$hcode)
                ->where('hospmain','!=',$hcode)
                ->first();

        $dept = DB::table('claim_er')
                ->select(DB::raw('SUM(drug + lab + proc) AS total'))
                ->where('hospmain','=',$hcode)
                ->where('hcode','!=',$hcode)
                ->first();

        $query_count = "SELECT
                (SELECT COUNT(rec_no) FROM claim_er WHERE p_status = '1' AND hcode = $hcode) AS wait,
                (SELECT COUNT(rec_no) FROM claim_er WHERE p_status = '2' AND hcode = $hcode) AS charge,
                (SELECT COUNT(rec_no) FROM claim_er WHERE p_status = '3' AND hcode = $hcode) AS success,
                (SELECT COUNT(rec_no) FROM claim_er WHERE p_status = '4' AND hcode = $hcode) AS deny";
    
        $paid = DB::table('claim_er')
                ->select('hcode','h_name',DB::raw('SUM(drug + lab + proc) AS paid'))
                ->where('hospmain','=',$hcode)
                ->where('hcode','!=',$hcode)
                ->join('hospital','hospital.h_code','claim_er.hcode')
                ->groupBy('hcode')
                ->get();
            
        $price = DB::table('claim_er')
                ->select('hcode','h_name',DB::raw('SUM(drug + lab + proc) AS paid'))
                ->where('hospmain','!=',$hcode)
                ->where('hcode','=',$hcode)
                ->join('hospital','hospital.h_code','claim_er.hospmain')
                ->groupBy('hospmain')
                ->get();

        $count = DB::select($query_count);
        return view('index', ['creditor' => $creditor,'dept' => $dept,'count' => $count,'paid' => $paid,'price' => $price]);
    }
}
