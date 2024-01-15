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
        $data = DB::table('transaction')
            ->select(DB::raw('distinct claim_er.trans_id'),'h_name','h_code','p_name','create_date')
            ->join('claim_er','claim_er.trans_id','transaction.trans_code')
            ->join('hospital','hospital.h_code','claim_er.hospmain')
            ->join('p_status','id','claim_er.p_status')
            ->where('claim_er.hospmain',$id)
            ->where('p_status',2)
            ->groupBy('claim_er.trans_id')
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
