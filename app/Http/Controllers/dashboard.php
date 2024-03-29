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
        if(Auth::user()->mode == 'Y'){
        return redirect()->route('cmh.index');
        }else{
                $hcode = Auth::user()->hcode;
                $creditor = DB::table('claim_list')
                        ->select(DB::raw('SUM(total) AS total'))
                        ->where('hcode','=',$hcode)
                        ->where('hospmain','!=',$hcode)
                        ->first();
        
                $dept = DB::table('claim_list')
                        ->select(DB::raw('SUM(total) AS total'))
                        ->where('hospmain','=',$hcode)
                        ->where('hcode','!=',$hcode)
                        ->first();
        
                $query_count = "SELECT
                        (SELECT COUNT(vn) FROM claim_list WHERE p_status = '1' AND hcode = $hcode) AS `wait`,
                        (SELECT COUNT(vn) FROM claim_list WHERE p_status = '5' AND hospmain = $hcode) AS deny";
            
                $paid = DB::table('claim_list')
                        ->select('hcode','h_name',DB::raw('SUM(total) AS paid'))
                        ->where('hospmain','=',$hcode)
                        ->where('hcode','!=',$hcode)
                        ->join('hospital','hospital.h_code','claim_list.hcode')
                        ->groupBy('hcode')
                        ->get();
                    
                $price = DB::table('claim_list')
                        ->select('hcode','h_name',DB::raw('SUM(total) AS paid'))
                        ->where('hospmain','!=',$hcode)
                        ->where('hcode','=',$hcode)
                        ->join('hospital','hospital.h_code','claim_list.hospmain')
                        ->groupBy('hospmain')
                        ->get();
        
                $count = DB::select($query_count);
                return view('index', ['creditor' => $creditor,'dept' => $dept,'count' => $count,'paid' => $paid,'price' => $price]);
        }
    }

    public function deny(){
        $hcode = Auth::user()->hcode;
        $data = DB::table('claim_list')
                ->select('vn','visit_date','hcode','hn','h_name','icd10','with_ambulance','drug','lab','proc'
                ,'p_name','p_color','trans_code','deny_note','deny_date',
                DB::raw('total AS amount,
                IF((total) > claim_paid.paid, claim_paid.paid, (total)) AS paid,
                IF(with_ambulance = "Y", claim_refer.paid, with_ambulance) AS ambulance'))
                ->join('hospital','h_code','claim_list.hcode')
                ->join('p_status','p_status.id','claim_list.p_status')
                ->join('claim_paid','claim_paid.year','claim_list.p_year')
                ->join('claim_refer','claim_refer.year','claim_list.p_year')
                ->where('hospmain',$hcode)
                ->where('p_status',5)
                ->get();
        // dd($data);
        return view('deny.index',['data'=>$data]);
    }
}
