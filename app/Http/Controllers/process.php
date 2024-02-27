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
        $bent = DB::select("SELECT DISTINCT pttype , ptname
                FROM claim_list
                WHERE hcode = {$hcode}");
        $map = DB::table('benefit')->where('ben_hcode',$hcode)->get();
        $op_paid = DB::table('claim_paid')->get();
        $op_refer = DB::table('claim_refer')->get();
        return view('process.index',['data'=>$data,'count'=>$count,'bent'=>$bent,'map'=>$map,'op_paid'=>$op_paid,'op_refer'=>$op_refer]);
    }

    public function mapping(Request $request)
    {
        $hcode = Auth::user()->hcode;
        $pttype = $request->pttype;
        $data = DB::table('claim_list')->where('pttype',$pttype)->where('hcode',$hcode)->first();
        // dd($pttype,$data);
        DB::table('benefit')->insert([
            'ben_pttype' => $data->pttype,
            'ben_ptname' => $data->ptname,
            'ben_hcode' => $data->hcode,
        ]);
    }
}
