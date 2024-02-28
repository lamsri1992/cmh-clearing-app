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
        $creditor = DB::table('claim_list')
                ->select(DB::raw('SUM(drug + lab + proc) AS total'))
                ->join('benefit','benefit.ben_pttype','claim_list.pttype')
                ->where('hcode','=',$hcode)
                ->where('hospmain','!=',$hcode)
                ->whereIn('benefit.ben_status_id', [1, 2])
                ->first();

        $dept = DB::table('claim_list')
                ->select(DB::raw('SUM(drug + lab + proc) AS total'))
                ->join('benefit','benefit.ben_pttype','claim_list.pttype')
                ->where('hospmain','=',$hcode)
                ->where('hcode','!=',$hcode)
                ->whereIn('benefit.ben_status_id', [1, 2])
                ->first();

        $query_count = "SELECT
                (SELECT COUNT(vn) FROM claim_list 
                        LEFT JOIN benefit ON benefit.ben_pttype = claim_list.pttype
                        WHERE p_status = '1' 
                        AND hcode = $hcode
                        AND benefit.ben_status_id IN ('1','2')) AS wait,
                (SELECT COUNT(vn) FROM claim_list 
                        LEFT JOIN benefit ON benefit.ben_pttype = claim_list.pttype
                        WHERE p_status = '2' 
                        AND hcode = $hcode
                        AND benefit.ben_status_id IN ('1','2')) AS charge,
                (SELECT COUNT(vn) FROM claim_list 
                        LEFT JOIN benefit ON benefit.ben_pttype = claim_list.pttype
                        WHERE p_status = '3' 
                        AND hcode = $hcode
                        AND benefit.ben_status_id IN ('1','2')) AS success,
                (SELECT COUNT(vn) FROM claim_list 
                        LEFT JOIN benefit ON benefit.ben_pttype = claim_list.pttype
                        WHERE p_status = '4' 
                        AND hospmain = $hcode
                        AND benefit.ben_status_id IN ('1','2')) AS deny";
    
        $paid = DB::table('claim_list')
                ->select('hcode','h_name',DB::raw('SUM(drug + lab + proc) AS paid'))
                ->where('hospmain','=',$hcode)
                ->where('hcode','!=',$hcode)
                ->join('hospital','hospital.h_code','claim_list.hcode')
                ->join('benefit','benefit.ben_pttype','claim_list.pttype')
                ->whereIn('benefit.ben_status_id', [1, 2])
                ->groupBy('hcode')
                ->get();
            
        $price = DB::table('claim_list')
                ->select('hcode','h_name',DB::raw('SUM(drug + lab + proc) AS paid'))
                ->where('hospmain','!=',$hcode)
                ->where('hcode','=',$hcode)
                ->join('hospital','hospital.h_code','claim_list.hospmain')
                ->join('benefit','benefit.ben_pttype','claim_list.pttype')
                ->whereIn('benefit.ben_status_id', [1, 2])
                ->groupBy('hospmain')
                ->get();

        $count = DB::select($query_count);
        return view('index', ['creditor' => $creditor,'dept' => $dept,'count' => $count,'paid' => $paid,'price' => $price]);
    }

    public function deny(){
        $hcode = Auth::user()->hcode;
        $data = DB::table('claim_list')
                ->select('vn','date_rx','hcode','hn','h_name','icd10','with_ambulance','drug','lab','proc','p_name','p_color',
                DB::raw('drug + lab + proc + service_charge AS amount,note,trans_id,
                IF((drug + lab + proc + service_charge) > claim_paid.paid, claim_paid.paid, (drug + lab + proc + service_charge)) AS paid,
                IF(with_ambulance = "Y", claim_refer.paid, with_ambulance) AS ambulance'))
                ->join('hospital','h_code','claim_list.hcode')
                ->join('p_status','p_status.id','claim_list.p_status')
                ->join('claim_paid','claim_paid.year','claim_list.p_year')
                ->join('claim_refer','claim_refer.year','claim_list.p_year')
                ->where('hospmain',$hcode)
                ->where('p_status',4)
                ->get();
        // dd($data);
        return view('deny.index',['data'=>$data]);
    }
}
