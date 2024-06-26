<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class create extends Controller
{
    public function index()
    {
        $hcode = Auth::user()->hcode;
        $hmain = DB::table('hospital')->where('h_code','!=',$hcode)->get();
        return view('charge.create',['hmain'=>$hmain]);
    }

    public function add(Request $request)
    {
        $hcode = Auth::user()->hcode;
        $validated = $request->validate([
            'hospmain' => 'required',
            'pid' => 'required',
            'patient' => 'required',
            'hn' => 'required',
            'vn' => 'required',
            'vstdate' => 'required',
            'icd10' => 'required',
            'drug' => 'required',
            'lab' => 'required',
            'xray' => 'required',
            'proc' => 'required',
            'service' => 'required',
            'with_ambulance' => 'required',
        ],
        [
            'hospmain.required' => 'กรุณาระบุ รพ. ที่เรียกเก็บ',
            'pid.required' => 'กรุณาระ บุหมายเลข 13 หลัก',
            'patient.required' => 'กรุณาระบุ ผู้รับบริการ',
            'hn.required' => 'กรุณาระบุ HN',
            'vn.required' => 'กรุณาระบุ VN',
            'vstdate.required' => 'กรุณาระบุ วันที่เข้ารับบริการ',
            'icd10.required' => 'กรุณาระบุ ICD10',
            'drug.required' => 'กรุณาระบุ ค่ายา',
            'lab.required' => 'กรุณาระบุ ค่าแลบ',
            'xray.required' => 'กรุณาระบุ ค่า X-Ray',
            'proc.required' => 'กรุณาระบุ ค่าหัตถการ',
            'service.required' => 'กรุณาระบุ ค่าบริการอื่น ๆ',
            'with_ambulance.required' => 'กรุณาระบุ การใช้รถ Ambulance / Refer',
        ]
        );

        if($request->with_ambulance == 'Y'){
            $ambulance = 'Y';
        }else{
            $ambulance = NULL;
        }
        $vstdate = date('Y-m-d', strtotime($request->vstdate));

        DB::table('claim_list')->insert([
            'hcode' => $hcode,
            'hospmain' => $request->hospmain,
            'pid' => $request->pid,
            'patient' => $request->patient,
            'hn' => $request->hn,
            'vn' => $request->vn,
            'visit_date' => $vstdate,
            'icd10' => $request->icd10,
            'drug' => $request->drug,
            'lab' => $request->lab,
            'xray' => $request->xray,
            'proc' => $request->proc,
            'service_charge' => $request->service,
            'total' => $request->drug+$request->lab+$request->xray+$request->proc+$request->service,
            'with_ambulance' => $ambulance,
            'pttype' => 'UC',
            'ptname' => 'OP_AE : UC นอกเขต กรณีอุบัติเหตุและฉุกเฉิน',
        ]);
        return back()->with('success','เพิ่มข้อมูลลูกหนี้สำเร็จ');
    }

    public function update(Request $request, $id)
    {
        if($request->with_ambulance == 'Y'){
            $ambulance = 'Y';
        }else{
            $ambulance = NULL;
        }
        
        $vstdate = date('Y-m-d', strtotime($request->vstdate));

        DB::table('claim_list')->where('id',$id)->update([
            'visit_date' => $vstdate,
            'icd10' => $request->icd10,
            'drug' => $request->drug,
            'lab' => $request->lab,
            'xray' => $request->xray,
            'proc' => $request->proc,
            'service_charge' => $request->service,
            'total' => $request->drug+$request->lab+$request->xray+$request->proc+$request->service,
            'with_ambulance' => $ambulance,
        ]);
        return back()->with('success','แก้ไขข้อมูลลูกหนี้สำเร็จ');
    }
}
