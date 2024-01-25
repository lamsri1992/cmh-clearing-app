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
        $data = DB::table('claim_er')->where('hcode',$hcode)->orderBy('date_rx','DESC')->first();
        $count = DB::table('claim_er')->where('hcode',$hcode)->count();
        $bent = DB::select("SELECT DISTINCT pttype , ptname
                FROM claim_er
                WHERE hcode = {$hcode}");
        return view('process.index',['data'=>$data,'count'=>$count,'bent'=>$bent]);
    }
}
