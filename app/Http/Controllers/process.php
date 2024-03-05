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
        $map = DB::table('map_benefit')
                ->join('map_system','map_system_id','map_ben_id')
                ->where('map_hcode',$hcode)->get();
        $op_paid = DB::table('claim_paid')->get();
        $op_refer = DB::table('claim_refer')->get();
        return view('process.index',['data'=>$data,'count'=>$count,'map'=>$map,'op_paid'=>$op_paid,'op_refer'=>$op_refer]);
    }

    public function mapping(Request $request)
    {
        $hcode = Auth::user()->hcode;
        $array = explode(",",$request->itemOPAE);
        $check = DB::table('map_benefit')
                ->where('map_pttype',$array[0])
                ->where('map_hcode',$hcode)
                ->first();
        if(!isset($check)){
            DB::table('map_benefit')->insert([
                'map_pttype' => $array[0],
                'map_ptname' => $array[1],
                'map_ben_id' => 1,
                'map_hcode' => $hcode,
            ]);
            return back()->with('success','Mapping สิทธิใหม่สำเร็จ');
        }else{
            return back()->with('success','สิทธิถูก Mapping อยู่แล้ว');
        }

    }
}
