<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class sentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $keys = explode(",",$id);
        $data = DB::table('transaction')
            ->select(DB::raw('distinct claim_list.trans_id'),'h_name','h_code','p_name','create_date')
            ->select(DB::raw('distinct claim_list.trans_id'),'h_name','h_code','p_name','create_date','hcode')
            ->join('claim_list','claim_list.trans_id','transaction.trans_code')
            ->join('hospital','hospital.h_code','claim_list.hospmain')
            ->join('p_status','p_status.id','claim_list.p_status')
            ->where('claim_list.hospmain',$keys[1])
            ->where('claim_list.hcode',$keys[0])
            ->whereIn('p_status',[2,3,5,7,8])
            ->groupBy('claim_list.trans_id')
            ->get();
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}