<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class cmh extends Controller
{
    public function index()
    {
        $data = DB::table('claim_list')
            ->select('hcode','h_name',DB::raw('SUM(total) AS paid'))
            ->join('hospital','hospital.h_code','claim_list.hcode')
            ->groupBy('hcode')
            ->get();
        
        return view('cmh.index',['data'=>$data]);
    }
}
