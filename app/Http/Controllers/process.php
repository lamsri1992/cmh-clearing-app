<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class process extends Controller
{
    public function index()
    {
        $hcode = Auth::user()->hcode;
        $data = DB::table('claim_list')->where('hcode',$hcode)->orderBy('date_rx','DESC')->first();
        $count = DB::table('claim_list')->where('hcode',$hcode)->count();
        $bent = DB::select("SELECT DISTINCT pttype , ptname , ben_pttype , ben_ptname
                FROM claim_list
                LEFT JOIN benefit ON benefit.ben_pttype = claim_list.pttype
                WHERE benefit.ben_pttype IS NULL
                AND hcode = {$hcode}");
        //  dd($bent);
        $map = DB::table('benefit')->where('ben_hcode',$hcode)->orderBy('ben_status_id','ASC')->get();
        $op_paid = DB::table('claim_paid')->get();
        $op_refer = DB::table('claim_refer')->get();
        return view('process.index',['data'=>$data,'count'=>$count,'bent'=>$bent,'map'=>$map,'op_paid'=>$op_paid,'op_refer'=>$op_refer]);
    }

    public function mapping(Request $request)
    {
        $hcode = Auth::user()->hcode;
        $check = DB::table('benefit')
                ->where('ben_pttype',$request->code)
                ->first();

        if(!isset($check)){
            DB::table('benefit')->insert([
                'ben_pttype' => $request->code,
                'ben_ptname' => $request->map,
                'ben_hcode' => $hcode,
                'ben_status_id' => $request->id,
                'ben_status_text' => $request->text,
            ]);
        }
    }
}
