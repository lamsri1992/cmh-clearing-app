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
        (SELECT COUNT(vn) FROM claim_list 
            -- LEFT JOIN benefit ON benefit.ben_pttype = claim_list.pttype
            WHERE p_status = '1' AND hcode = $hcode
            -- AND benefit.ben_status_id IN ('1','2')
            ) AS wait,
        (SELECT COUNT(vn) FROM claim_list 
            -- LEFT JOIN benefit ON benefit.ben_pttype = claim_list.pttype
            WHERE p_status IN('2','3','7','8') AND hcode = $hcode
            -- AND benefit.ben_status_id IN ('1','2')
            ) AS charge,
        (SELECT COUNT(vn) FROM claim_list 
            -- LEFT JOIN benefit ON benefit.ben_pttype = claim_list.pttype
            WHERE p_status = '4' AND hcode = $hcode
            -- AND benefit.ben_status_id IN ('1','2')
            ) AS deny,
        (SELECT COUNT(vn) FROM claim_list 
            -- LEFT JOIN benefit ON benefit.ben_pttype = claim_list.pttype
            WHERE p_status = '5' AND hcode = $hcode
            -- AND benefit.ben_status_id IN ('1','2')
            ) AS confirm,
        (SELECT COUNT(vn) FROM claim_list 
            -- LEFT JOIN benefit ON benefit.ben_pttype = claim_list.pttype
            WHERE p_status = '6' AND hcode = $hcode
            -- AND benefit.ben_status_id IN ('1','2')
            ) AS cancel";

        $count = DB::select($query_count);
        $hos = DB::table('hospital')->where('H_CODE','!=',$hcode)->get();

        $data = DB::table('claim_list')
                ->select('vn','date_rx','hcode','hn','h_name','icd10','with_ambulance',
                'drug','lab','proc','p_name','p_color','ptname','pttype',
                // 'benefit.ben_status_text',
                DB::raw('drug + lab + proc + service_charge AS amount,
                IF((drug + lab + proc + service_charge) > claim_paid.paid, claim_paid.paid, (drug + lab + proc + service_charge)) AS paid,
                IF(with_ambulance = "Y", claim_refer.paid, with_ambulance) AS ambulance'))
                ->join('hospital','h_code','claim_list.hospmain')
                ->join('p_status','p_status.id','claim_list.p_status')
                ->join('claim_paid','claim_paid.year','claim_list.p_year')
                ->join('claim_refer','claim_refer.year','claim_list.p_year')
                // ->join('benefit','benefit.ben_pttype','claim_list.pttype')
                ->where('hcode',$hcode)
                // ->whereIn('benefit.ben_status_id', [1, 2])
                ->get();

        // dd($count);
        return view('charge.index',['hos'=>$hos,'count'=>$count,'data'=>$data]);
    }

    public function filter(Request $request){
        $hcode = Auth::user()->hcode;
        $hospmain = $request->hospital;
        $d_start = $request->d_start;
        $d_end = $request->d_end;

        $data = DB::table('claim_list')
                ->select('vn','date_rx','hcode','hn','h_name','icd10','with_ambulance',
                'drug','lab','proc','p_name','p_color','ptname','pttype',
                DB::raw('drug + lab + proc + service_charge AS amount,
                IF((drug + lab + proc + service_charge) > claim_paid.paid, claim_paid.paid, (drug + lab + proc + service_charge)) AS paid,
                IF(with_ambulance = "Y", claim_refer.paid, with_ambulance) AS ambulance'))
                ->join('hospital','h_code','claim_list.hospmain')
                ->join('p_status','p_status.id','claim_list.p_status')
                ->join('claim_paid','claim_paid.year','claim_list.p_year')
                ->join('claim_refer','claim_refer.year','claim_list.p_year')
                ->where('hospmain',$hospmain)
                ->where('hcode',$hcode)
                ->whereBetween('date_rx', [$d_start, $d_end])
                ->get();
        $hos = DB::table('hospital')->where('H_CODE','!=',$hcode)->get();
        // dd($data,$d_start,$d_end);
        return view('charge.filter',['data'=>$data,'hos'=>$hos]);
    }

    public function show($id){
        $data = DB::table('claim_list')
                ->select('vn','hn','pid','date_rx','date_rec','icd9','icd10','refer','drug','lab','proc','service_charge','with_ambulance',
                'with_ct_mri','pay_order','contrast','contrast_pay','h_name','p_status','p_name','reporter','hospmain','ptname','updated','note',
                DB::raw('drug + lab + proc + service_charge AS amount,
                IF((drug + lab + proc + service_charge) > claim_paid.paid, claim_paid.paid, (drug + lab + proc + service_charge)) AS paid,
                IF(with_ambulance = "Y", claim_refer.paid, with_ambulance) AS ambulance'))
                ->join('hospital','hospital.h_code','claim_list.hospmain')
                ->join('p_status','p_status.id','claim_list.p_status')
                ->join('claim_paid','claim_paid.year','claim_list.p_year')
                ->join('claim_refer','claim_refer.year','claim_list.p_year')
                ->where('vn',base64_decode($id))
                ->first();
        // dd($data);
        return view('charge.show', ['data' => $data]);
    }

    public function confirm(Request $request)
    {
        $id = $request->recno;
        $query = DB::table('claim_list')->where('vn',$id)->update(
            [
                "p_status" => 5,
                "updated" => date('Y-m-d')
            ]
        );
    }

    public function cancel(Request $request)
    {
        $id = $request->vn;
        $note = $request->formData;
        $query = DB::table('claim_list')->where('vn',$id)->update(
            [
                "p_status" => 6,
                "note" => $note,
                "updated" => date('Y-m-d')
            ]
        );
    }

    public function list(){
        $hcode = Auth::user()->hcode;
        $data = DB::table('claim_list')
                ->select('hospmain','h_name',DB::raw('COUNT(*) AS number,IF(with_ambulance = "Y", claim_refer.paid, with_ambulance) AS ambulance,
                SUM(IF((drug + lab + proc + service_charge) > claim_paid.paid, claim_paid.paid, (drug + lab + proc + service_charge))) AS total,
                SUM(pay_order + contrast_pay) AS ct_total'))
                ->join('hospital','h_code','claim_list.hospmain')
                ->join('claim_paid','claim_paid.year','claim_list.p_year')
                ->join('claim_refer','claim_refer.year','claim_list.p_year')
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
        $data = DB::table('claim_list')
                ->select('vn','date_rx','hcode','hn','h_name','icd10','with_ambulance','drug','lab','proc',
                'p_name','p_color','hospmain','pay_order','contrast_pay',
                DB::raw('drug + lab + proc + service_charge AS amount,
                IF((drug + lab + proc + service_charge) > claim_paid.paid, claim_paid.paid, (drug + lab + proc + service_charge)) AS paid,
                IF(with_ambulance = "Y", claim_refer.paid, with_ambulance) AS ambulance'))
                ->join('hospital','h_code','claim_list.hospmain')
                ->join('p_status','p_status.id','claim_list.p_status')
                ->join('claim_paid','claim_paid.year','claim_list.p_year')
                ->join('claim_refer','claim_refer.year','claim_list.p_year')
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
        $hcode = Auth::user()->hcode;
        $transCode = $hcode."".date('Ym').substr(rand(),1,5);
        foreach($data as $array){
            $arr = explode(',',$array[9]);
            // $total = $arr[0].$arr[1];
            // dd($arr);
            $id = DB::table('transaction')->insertGetId(
                [
                    'trans_recno' => $array['0'],
                    'trans_vstdate' => $array['1'],
                    'trans_total' => $arr[0],
                    'trans_code' => $transCode,
                    'create_date' => date('Y-m-d'),
                    'trans_hcode' => $hcode,
                    'trans_hmain' => $array['11'],
                    'trans_status' => 2,
                ]
            );

            DB::table('claim_list')->where('vn',$array['0'])->update(
                [
                    'p_status' => 2,
                    'trans_id' => $transCode,
                ]
            );
        }
    }

    public function sent(){
        $hcode = Auth::user()->hcode;
        $data = DB::table('claim_list')
                ->select('hospmain','h_name','h_code',
                DB::raw('COUNT(DISTINCT trans_id) AS number,
                SUM(IF((drug + lab + proc + service_charge) > claim_paid.paid, claim_paid.paid, (drug + lab + proc + service_charge))) AS total,
                SUM(pay_order + contrast_pay) AS ctmri'))
                ->join('hospital','h_code','claim_list.hospmain')
                ->join('claim_paid','claim_paid.year','claim_list.p_year')
                ->join('claim_refer','claim_refer.year','claim_list.p_year')
                ->where('hospmain','!=',$hcode)
                ->where('hcode','=',$hcode)
                ->where('trans_id','!=',NULL)
                ->whereIn('p_status',[2,3,5,7,8])
                ->groupBy('h_code')
                ->get();
        // dd($data);
        return view('charge.sent', ['data' => $data]);
    }

    public function detail(Request $request, $id){
        $data = DB::table('claim_list')
                ->select('vn','date_rx','hcode','hn','h_name','icd10','with_ambulance','drug','lab','proc','p_name','p_color',
                'pay_order','with_ct_mri','contrast_pay',
                DB::raw('drug + lab + proc + service_charge AS amount,
                IF((drug + lab + proc + service_charge) > claim_paid.paid, claim_paid.paid, (drug + lab + proc + service_charge)) AS paid,
                IF(with_ambulance = "Y", claim_refer.paid, with_ambulance) AS ambulance'))
                ->join('hospital','h_code','claim_list.hospmain')
                ->join('p_status','p_status.id','claim_list.p_status')
                ->join('claim_paid','claim_paid.year','claim_list.p_year')
                ->join('claim_refer','claim_refer.year','claim_list.p_year')
                ->where('trans_id',$id)
                ->get();
        $paid = DB::table('paid')->where('trans_code',$id)->first();
        // echo($data);
        return view('charge.detail', ['data' => $data,'id'=>$id,'paid'=>$paid]);
    }

}
