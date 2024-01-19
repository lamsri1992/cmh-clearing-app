@extends('layouts.app')
@section('content')
@foreach ($count as $res)
@php
    $wait = $res->wait;
    $charge = $res->charge;
    $deny = $res->deny;
    $confirm = $res->confirm;
    $cancel = $res->cancel;
@endphp
<div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 font-weight-bold">รอตรวจสอบ</p>
                            <a href="{{ route('charge') }}" class="font-weight-bolder">
                                {{ number_format($wait) }} รายการ
                            </a>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-warning text-center rounded-circle">
                            <i class="fa-solid fa-spinner fa-spin text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 font-weight-bold">ตรวจสอบแล้ว</p>
                            <a href="{{ route('charge.list') }}" class="font-weight-bolder">
                                {{ number_format($confirm) }} รายการ
                            </a>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-primary text-center rounded-circle">
                            <i class="fa-solid fa-check text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 font-weight-bold">เรียกเก็บแล้ว</p>
                            <a href="{{ route('charge.sent') }}" class="font-weight-bolder">
                                {{ number_format($charge) }} รายการ
                            </a>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-success text-center rounded-circle">
                            <i class="fa-solid fa-comment-dollar text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 font-weight-bold">ปฏิเสธจ่าย</p>
                            <a href="#" class="font-weight-bolder">
                                {{ number_format($deny) }} รายการ
                            </a>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-danger text-center rounded-circle">
                            <i class="fa-solid fa-xmark text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <h6 class="text-capitalize">
                    <i class="fa-solid fa-clipboard-list"></i>
                    รายการทั้งหมด
                </h6>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 1rem;">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" id="min" name="min" class="form-control" placeholder="เลือกช่วงวันที่เริ่มต้น">
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="max" name="max" class="form-control" placeholder="เลือกช่วงวันที่สิ้นสุด">
                        </div>
                    </div>
                </div>
                <table id="listData" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">VN::</th>
                            <th class="text-center">วันที่รับบริการ</th>
                            <th>หน่วยบริการ</th>
                            <th class="text-center">HN</th>
                            <th class="text-end">ค่าใช้จ่ายจริง</th>
                            <th class="text-end">ยอดที่เรียกเก็บได้</th>
                            <th class="text-end">ค่าใช้จ่าย Refer</th>
                            <th class="text-end">ยอดรวม</th>
                            <th class="text-center">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $res)
                            <tr>
                                <td class="text-center">{{ $res->vn }}</td>
                                <td class="text-center">{{ date("Y-m-d", strtotime($res->date_rx)); }}</td>
                                <td>{{ $res->h_name }}</td>
                                <td class="text-center">{{ $res->hn }}</td>
                                <td class="text-end text-primary fw-bold">{{ number_format($res->amount,2) }}</td>
                                <td class="text-end text-success fw-bold">{{ number_format($res->paid,2) }}</td>
                                <td class="text-end text-danger fw-bold">{{ number_format($res->paid_am,2) }}</td>
                                <td class="text-end fw-bold" style="text-decoration-line: underline">{{ number_format($res->total,2) }}</td>
                                <td class="text-center text-white {{ $res->p_color }}">{{ $res->p_name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th>หน่วยบริการ</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th colspan="2">สถานะ</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
@section('script')
<script src="{{ asset('js/listTableCharge.js') }}"></script>
@endsection
