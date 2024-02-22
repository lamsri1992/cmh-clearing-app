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
        (SELECT COUNT(vn) FROM claim_list WHERE p_status = '2' AND hospmain = $hcode) AS charge,
        (SELECT COUNT(vn) FROM claim_list WHERE p_status IN ('7','8') AND hospmain = $hcode) AS success,
        (SELECT COUNT(vn) FROM claim_list WHERE p_status = '4' AND hospmain = $hcode) AS deny";

        $count = DB::select($query_count);
        $data = DB::select("SELECT DISTINCT trans_code,SUM(trans_total) as total,trans_hcode,h_name,create_date
                FROM `transaction`
                LEFT JOIN hospital ON hospital.H_CODE = trans_hcode
                WHERE trans_hmain = {$hcode}
                AND trans_status = 2
                GROUP BY trans_code,trans_hcode,create_date,trans_paiddate
                ORDER BY trans_id DESC
                LIMIT 10");
        // dd($data);
        return view('paid.index', ['data' => $data,'count'=>$count]);

    }

    public function detail(Request $request, $id){
        $data = DB::table('claim_list')
                ->select('vn','date_rx','hcode','hn','h_name','icd10','with_ambulance','drug','lab','proc',
                'p_name','p_color','pay_order','contrast_pay',
                DB::raw('drug + lab + proc + service_charge AS amount,
                IF((drug + lab + proc + service_charge) > 700, 700, (drug + lab + proc + service_charge)) AS paid,
                IF(with_ambulance > "0", "600", with_ambulance) AS ambulance'))
                ->join('hospital','h_code','claim_list.hcode')
                ->join('p_status','p_status.id','claim_list.p_status')
                ->where('trans_id',$id)
                ->get();
        $check = DB::select("SELECT 
        (SELECT COUNT(*) FROM claim_list WHERE p_status = '3' AND TRANS_ID = $id) AS confirm,
        (SELECT COUNT(*) FROM claim_list WHERE p_status = '4' AND TRANS_ID = $id) AS deny,
        (SELECT COUNT(*) FROM claim_list WHERE p_status = '2' AND TRANS_ID = $id) AS progress");
        $trans = DB::table('transaction')->where('transaction.trans_code',$id)->first();
        $paid = DB::table('paid')->where('paid.trans_code',$id)->first();
        // dd($trans);
        return view('paid.detail', ['data' => $data,'id'=>$id,'check'=>$check,'trans'=>$trans,'paid'=>$paid]);
    }

    public function show($id){
        $data = DB::table('claim_list')
                ->select('vn','hn','pid','date_rx','date_rec','icd9','icd10','refer','drug','lab','proc','service_charge','with_ambulance','trans_id',
                'with_ct_mri','pay_order','contrast','contrast_pay','h_name','p_status','p_name','reporter','hospmain','ptname','updated','note',
                DB::raw('drug + lab + proc + service_charge AS amount,
                IF((drug + lab + proc + service_charge) > 700, 700, (drug + lab + proc + service_charge)) AS paid,
                IF(with_ambulance = "Y", "600", with_ambulance) AS ambulance'))
                ->join('hospital','hospital.h_code','claim_list.hcode')
                ->join('p_status','p_status.id','claim_list.p_status')
                ->where('vn',base64_decode($id))
                ->first();
        return view('paid.show', ['data' => $data]);
    }

    public function confirm(Request $request)
    {
        $date = date('Y-m-d');
        $id = $request->recno;
        DB::table('claim_list')->where('vn',$id)->update(["p_status" => 3]);
        DB::table('transaction')->where('trans_recno',$id)->update([
            "trans_status" => 3,
            "trans_confirmdate" => $date
        ]);
    }

    public function deny(Request $request)
    {
        $date = date('Y-m-d');
        $id = $request->vn;
        $note = $request->formData;

        DB::table('claim_list')->where('vn',$id)->update(
            [
                "p_status" => 4,
                "note" => $note,
                "updated_deny" => $date
            ]
        );

        DB::table('transaction')->where('trans_recno',$id)->update([
            "trans_status" => 4,
            "trans_confirmdate" => $date
        ]);
    }

    public function transConfirm(Request $request,$id)
    {
        $date = date('Y-m-d');
        DB::table('claim_list')->where('trans_id',$id)->where('p_status',3)->update([
            'p_status' => 7
        ]);

        DB::table('transaction')->where('trans_code',$id)->where('trans_status',3)->update([
            'trans_status' => 7,
            'trans_paiddate' => $date
        ]);

        return redirect()->route('paid.list');
    }

    public function list()
    {
        $hcode = Auth::user()->hcode;
        $data = DB::select("SELECT DISTINCT `transaction`.trans_code,SUM(trans_total) as total,
                trans_hcode,h_name,`transaction`.create_date,trans_paiddate,paid.file,trans_status
                FROM `transaction`
                LEFT JOIN hospital ON hospital.H_CODE = trans_hcode
                LEFT JOIN paid ON paid.trans_code = `transaction`.trans_code
                WHERE trans_hmain = {$hcode}
                AND trans_status IN('7')
                GROUP BY `transaction`.trans_code,trans_hcode,`transaction`.create_date,trans_paiddate");
        return view('paid.list', ['data' => $data]);
    }

    public function upload(Request $request)
    {
        $hcode = Auth::user()->hcode;
        $date = date('Y-m-d');
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ]);
      
        $fileName = $request->transId.'.'.$request->file->extension();  
        $request->file->move(public_path('uploads'), $fileName);

        DB::table('paid')->insert([
            'trans_code'=>$request->transId,
            'balance'=>$request->balance,
            'balance_type'=>$request->balance_type,
            'paid_date'=>$request->paid_date,
            'paid_no'=>$request->paid_no,
            'create_date'=>$date,
            'file'=>$fileName,
        ]);
       
        DB::table('transaction')->where('trans_code',$request->transId)->where('trans_status',7)->update([
            'trans_status' => 8,
            'trans_paiddate' => $date
        ]);

        DB::table('claim_list')->where('trans_id',$request->transId)->where('p_status',7)->update([
            'p_status' => 8,
        ]);

        return back()
            ->with('success','Upload ไฟล์เอกสารสำเร็จ '.$fileName);
    }

    public function success(){
        $hcode = Auth::user()->hcode;
        $data = DB::select("SELECT DISTINCT `transaction`.trans_code,SUM(trans_total) as total,
                trans_hcode,h_name,`transaction`.create_date,trans_paiddate,paid.file,trans_status,paid.balance
                FROM `transaction`
                LEFT JOIN hospital ON hospital.H_CODE = trans_hcode
                LEFT JOIN paid ON paid.trans_code = `transaction`.trans_code
                WHERE trans_hmain = {$hcode}
                AND trans_status IN('8')
                GROUP BY `transaction`.trans_code,trans_hcode,`transaction`.create_date,trans_paiddate");
        return view('paid.success', ['data' => $data]);
    }
}
