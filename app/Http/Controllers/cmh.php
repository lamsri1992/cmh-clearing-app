<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class cmh extends Controller
{
    public function index()
    {
        $sql = "SELECT h.h_name,
            (SELECT SUM(claim_list.total) 
                FROM claim_list 
                WHERE claim_list.hcode = h.h_code) AS debtor,
            (SELECT SUM(claim_list.total) 
                FROM claim_list 
                WHERE claim_list.hospmain = h.h_code) AS creditor
            FROM hospital h
            WHERE h.h_type = '1'";
        $data = DB::select($sql);
        return view('cmh.index',['data'=>$data]);
    }

    public function fetch()
    {
        $sql = "SELECT
            (SELECT COUNT(*) 
                FROM `transaction`) AS trans_all,
            (SELECT COUNT(*) 
                FROM `transaction` 
                WHERE `transaction`.trans_status = 2) AS trans_wait,
            (SELECT SUM(`transaction`.trans_total) 
                FROM `transaction` 
                WHERE `transaction`.trans_status = 2) AS trans_amount";
        $count = DB::select($sql);
        $data = DB::table('transaction')
                ->select('h_name','h_code','trans_code','create_date','p_name','p_color',
                DB::raw('COUNT(DISTINCT trans_code) AS number,
                SUM(trans_total) AS total'))
                ->join('hospital','h_code','transaction.trans_hcode')
                ->join('p_status','p_status.id','transaction.trans_status')
                // ->where('trans_status',2)
                ->groupBy('h_code')
                ->get();
        // echo $data;
        return view('cmh.data',['data'=>$data,'count'=>$count]);
    }

    public function detail($id)
    {
        $hospital = DB::table('hospital')->where('h_code',$id)->first();
        $data = DB::table('claim_list')
                ->select(DB::raw('DISTINCT trans_code ,hospmain,h_name,h_code,
                COUNT(vn) AS number,
                SUM(total) AS amount,
                SUM(IF((total) > claim_paid.paid, claim_paid.paid, (total))) AS total'))
                ->join('hospital','h_code','claim_list.hospmain')
                ->join('claim_paid','claim_paid.year','claim_list.p_year')
                ->join('claim_refer','claim_refer.year','claim_list.p_year')
                ->where('hcode',$id)
                ->where('trans_code','!=',NULL)
                // ->where('p_status',2)
                ->groupBy('trans_code')
                ->orderBy('h_code','ASC')
                ->get();
        return view('cmh.detail',['hospital'=>$hospital,'data'=>$data]);
    }

    public function process()
    {
        $date = date('Y-m-d');
        DB::table('transaction')->where('trans_status',2)->update(
            [
                'trans_process_date' => $date,
                'trans_status' => 3
            ]
        );

        DB::table('claim_list')->where('p_status',2)->update(
            [
                'p_status' => 3
            ]
        );

        return back()->with('success','ประมวลผลข้อมูลประจำรอบสำเร็จ');
    }

    public function report()
    {
        dd('Hello World , Report');
    }
}
