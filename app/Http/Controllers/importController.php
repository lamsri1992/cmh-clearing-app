<?php

namespace App\Http\Controllers;

use App\Imports\ClaimImport;
use Illuminate\Http\Request;
use DB;
use Excel;
use File;
use Auth;

class importController extends Controller
{
    public function import(Request $request)
    {
        $hcode = Auth::user()->hcode;
        $this->validate($request, [
            'select-file' => 'required|mimes:xls'
        ]);
        
        Excel::import(new ClaimImport,request()->file('select-file'));
        $file  = $request->file('select-file');
        $fileName = $hcode."_".date('Ymdhis').".xls";
        $destination = public_path('ImportFiles/');
        File::makeDirectory($destination, 0777, true, true);
        $file->move(public_path('ImportFiles/'), $fileName);
        
        DB::table('import_log')->insert(
            [
                'ex_file' => $fileName,
                'import_date' => date("Y-m-d"),
                'hcode' => $hcode,
            ]
        );
        DB::table('claim_list')->where('vn', NULL)->delete();
        return back()->with('success', 'นำเข้าข้อมูลสำเร็จ');
    }
}
