<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use DateTime;

class charge extends Controller
{   
    public function index(){
        $hcode = Auth::user()->hcode;
        $query_count = "SELECT
        (SELECT COUNT(vn) FROM claim_list WHERE p_status = '1' AND hcode = $hcode) AS `wait`,
        (SELECT COUNT(vn) FROM claim_list WHERE p_status = '2' AND hcode = $hcode) AS charge,
        (SELECT COUNT(*) FROM `transaction` WHERE trans_status = '8' AND trans_hcode = $hcode) AS depts,
        (SELECT SUM(total) FROM claim_list WHERE hcode = $hcode) AS deptor";

        $count = DB::select($query_count);

        $data = DB::table('import_log')
                ->join('hospital','hospital.h_code','import_log.hcode')
                ->where('hcode',$hcode)
                ->get();
        return view('charge.index',['count'=>$count,'data'=>$data]);
    }

    public function show($id){
        $data = DB::table('claim_list')
                ->select('vn','hn','pid','visit_date','icd10','drug','lab','proc','xray','service_charge','service_charge','with_ambulance',
                'h_name','p_status','p_name','hospmain','ptname','patient','cancel_note','cancel_date',
                DB::raw('total AS amount,
                IF((total) > claim_paid.paid, claim_paid.paid, (total)) AS paid,
                IF(with_ambulance = "Y", claim_refer.paid, with_ambulance) AS ambulance'))
                ->join('hospital','hospital.h_code','claim_list.hospmain')
                ->join('p_status','p_status.id','claim_list.p_status')
                ->join('claim_paid','claim_paid.year','claim_list.p_year')
                ->join('claim_refer','claim_refer.year','claim_list.p_year')
                ->where('vn',base64_decode($id))
                ->first();
        return view('charge.show', ['data' => $data]);
    }

    public function edit($id){
        $data = DB::table('claim_list')
                ->select('claim_list.id','vn','hn','pid','visit_date','icd10','drug','lab','proc','xray','service_charge','service_charge','with_ambulance',
                'h_name','p_status','p_name','hospmain','ptname','patient','cancel_note','cancel_date',
                DB::raw('total AS amount,
                IF((total) > claim_paid.paid, claim_paid.paid, (total)) AS paid,
                IF(with_ambulance = "Y", claim_refer.paid, with_ambulance) AS ambulance'))
                ->join('hospital','hospital.h_code','claim_list.hospmain')
                ->join('p_status','p_status.id','claim_list.p_status')
                ->join('claim_paid','claim_paid.year','claim_list.p_year')
                ->join('claim_refer','claim_refer.year','claim_list.p_year')
                ->where('vn',base64_decode($id))
                ->first();
        return view('charge.edit', ['data' => $data]);
    }

    // public function confirm(Request $request)
    // {
    //     $id = $request->recno;
    //     $query = DB::table('claim_list')->where('vn',$id)->update(
    //         [
    //             "p_status" => 5,
    //             "updated" => date('Y-m-d')
    //         ]
    //     );
    // }

    public function cancel(Request $request)
    {
        $id = $request->vn;
        $note = $request->formData;
        $query = DB::table('claim_list')->where('vn',$id)->update(
            [
                "p_status" => 6,
                "cancel_note" => $note,
                "cancel_date" => date('Y-m-d')
            ]
        );
    }

    public function list(){
        $hcode = Auth::user()->hcode;
        $data = DB::table('claim_list')
                ->select('hospmain','h_name','h_type_name','h_color',
                DB::raw('COUNT(*) AS number,IF(with_ambulance = "Y", claim_refer.paid, with_ambulance) AS ambulance,
                SUM(IF((total) > claim_paid.paid, claim_paid.paid, (total))) AS total'))
                ->join('hospital','h_code','claim_list.hospmain')
                ->join('hospital_type','h_type_id','hospital.h_type')
                ->join('claim_paid','claim_paid.year','claim_list.p_year')
                ->join('claim_refer','claim_refer.year','claim_list.p_year')
                ->where('hospmain','!=',$hcode)
                ->where('hcode','=',$hcode)
                ->where('p_status','=',1)
                ->groupBy('h_code')
                ->get();
        return view('charge.list', ['data' => $data]);
    }

    public function transaction($id)
    {
        $hcode = Auth::user()->hcode;
        $data = DB::table('claim_list')
                ->select('vn','visit_date','hcode','hn','h_name','icd10','with_ambulance','drug','lab','proc','xray','service_charge',
                'p_name','p_color','hospmain',
                DB::raw('total AS amount,
                IF((total) > claim_paid.paid, claim_paid.paid, (total)) AS paid,
                IF(with_ambulance = "Y", claim_refer.paid, with_ambulance) AS ambulance'))
                ->join('hospital','h_code','claim_list.hospmain')
                ->join('p_status','p_status.id','claim_list.p_status')
                ->join('claim_paid','claim_paid.year','claim_list.p_year')
                ->join('claim_refer','claim_refer.year','claim_list.p_year')
                ->where('hospmain','=',base64_decode($id))
                ->where('hcode','=',$hcode)
                ->where('p_status',1)
                ->get();
        return view('charge.transaction', ['data' => $data]);
    }

    public function bill(Request $request)
    {
        $data = $request->get('formData');
        $hcode = Auth::user()->hcode;
        $transCode = $hcode."".date('Ym').substr(rand(),1,5);
        foreach($data as $array){

            $date = DateTime::createFromFormat('d/m/Y', $array['0']);
            $formatted_date = $date->format('Y-m-d');

            $total = $array['7'];
            $new_total = str_replace(",", "", $total);
            $id = DB::table('transaction')->insertGetId(
                [
                    'trans_vn' => $array['1'],
                    'trans_vstdate' => $formatted_date,
                    'trans_total' => $new_total,
                    'trans_code' => $transCode,
                    'trans_hcode' => $hcode,
                    'trans_hmain' => $array['9'],
                    'create_date' => date('Y-m-d'),
                    'trans_status' => 2,
                ]
            );

            DB::table('claim_list')->where('vn',$array['1'])->update(
                [
                    'p_status' => 2,
                    'trans_code' => $transCode,
                ]
            );
        }
    }

    public function sent(){
        $hcode = Auth::user()->hcode;
        $data = DB::table('claim_list')
                ->select('hospmain','h_name','h_code',
                DB::raw('COUNT(DISTINCT trans_code) AS number,
                SUM(IF((total) > claim_paid.paid, claim_paid.paid, (total))) AS total'))
                ->join('hospital','h_code','claim_list.hospmain')
                ->join('claim_paid','claim_paid.year','claim_list.p_year')
                ->join('claim_refer','claim_refer.year','claim_list.p_year')
                ->where('hospmain','!=',$hcode)
                ->where('hcode','=',$hcode)
                ->where('trans_code','!=',NULL)
                ->whereIn('p_status',[2])
                ->groupBy('h_code')
                ->get();
        return view('charge.sent', ['data' => $data]);
    }

    public function detail(Request $request, $id){
        $data = DB::table('claim_list')
                ->select('vn','visit_date','hcode','hn','h_name','icd10','with_ambulance',
                'drug','lab','proc','xray','service_charge','p_name','p_color',
                DB::raw('total AS amount,
                IF((total) > claim_paid.paid, claim_paid.paid, (total)) AS paid,
                IF(with_ambulance = "Y", claim_refer.paid, with_ambulance) AS ambulance'))
                ->join('hospital','h_code','claim_list.hospmain')
                ->join('p_status','p_status.id','claim_list.p_status')
                ->join('claim_paid','claim_paid.year','claim_list.p_year')
                ->join('claim_refer','claim_refer.year','claim_list.p_year')
                ->where('trans_code',$id)
                ->get();
        $paid = DB::table('paid')->where('trans_code',$id)->first();
        return view('charge.detail', ['data' => $data,'id'=>$id,'paid'=>$paid]);
    }

    public function summary(){
        $hcode = Auth::user()->hcode;
        $data = DB::select("SELECT DISTINCT `transaction`.trans_code,SUM(trans_total) as total,
                trans_hcode,h_name,`transaction`.create_date,trans_paiddate,paid.file,trans_status,paid.balance
                FROM `transaction`
                LEFT JOIN hospital ON hospital.H_CODE = trans_hmain
                LEFT JOIN paid ON paid.trans_code = `transaction`.trans_code
                WHERE trans_hcode = {$hcode}
                AND trans_status IN('8')
                GROUP BY `transaction`.trans_code,trans_hcode,`transaction`.create_date,trans_paiddate");
        return view('charge.summary', ['data' => $data]);
    }

}
