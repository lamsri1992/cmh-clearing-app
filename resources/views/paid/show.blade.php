@extends('layouts.app')
@section('content')
<div class="row mt-4">
    <div class="col-lg-8 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-body">
                <span class="fw-bold">
                    <i class="fa-regular fa-clipboard"></i>
                    ข้อมูลตามจ่าย
                </span>
                <div class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column p-sm-3 p-0">
                    <div class="col-md-6">
                        <p><b>ผู้บันทึก</b> : {{ $data->reporter }}</p>
                        <p><b>REC_NO</b> : {{ $data->rec_no }}</p>
                        <p><b>HN</b> : {{ $data->hn }}</p>
                        <p><b>PID</b> : {{ $data->pid }}</p>
                        <p><b>วันที่รับบริการ</b> : {{ $data->date_rx }}</p>
                        <p><b>วันที่เรียกเก็บ</b> : {{ $data->date_rec }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>ตามจ่ายไปยัง</b> : {{ $data->h_name }}</p>
                        <p><b>ICD9</b> : {{ $data->icd9 }}</p>
                        <p><b>ICD10</b> : {{ $data->icd10 }}</p>
                        <p><b>Refer</b> : {!! ($data->refer == 1) ? 
                            '<i class="fa-solid fa-check-circle text-success"></i> ใช่' 
                            : 
                            '<i class="fa-solid fa-xmark-circle text-danger"></i> ไม่ใช่'
                            !!}
                        </p>
                        <p><b>สถานะ</b> : {{ $data->p_name }}</p>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="50%">ค่ายา</th>
                            <td class="text-end">{{ number_format($data->drug,2) }}</td>
                        </tr>
                        <tr>
                            <th>Lab</th>
                            <td class="text-end">{{ number_format($data->lab,2) }}</td>
                        </tr>
                        <tr>
                            <th>หัตถการ</th>
                            <td class="text-end">{{ number_format($data->proc,2) }}</td>
                        </tr>
                        <tr>
                            <th>รวมทั้งหมด</th>
                            <td class="text-end">{{ number_format($data->amount,2) }}</td>
                        </tr>
                        <tr>
                            <th>ยอดจ่ายจริง <small class="fw-light text-danger">(จ่ายตามเกณฑ์ไม่เกิน 700 บาท)</small></th>
                            <td class="text-end">{{ number_format($data->total,2) }}</td>
                        </tr>
                        <tr>
                            <th>Ambulance</th>
                            <td class="text-end">{{ number_format($data->ambulanc,2) }}</td>
                        </tr>
                        <tr>
                            <th>ยอดเรียกเก็บจริง</th>
                            <td class="text-end fw-bold text-decoration-underline">{{ number_format($data->total,2) }}</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-lg-0 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-success" type="button">
                        <i class="fa-regular fa-circle-check"></i>
                        ยืนยันข้อมูลตามจ่าย
                    </button>
                    <button class="btn btn-danger" type="button">
                        <i class="fa-regular fa-circle-xmark"></i>
                        ปฏิเสธการจ่าย
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection
