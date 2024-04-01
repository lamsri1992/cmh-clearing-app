@extends('layouts.app')
@section('content')
@foreach ($count as $res)
@php
    $charge = $res->charge;
    $success = $res->success;
    $deny = $res->deny;
@endphp
<div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 font-weight-bold">ยอดเจ้าหนี้ทั้งหมด</p>
                            <a href="#" class="font-weight-bolder">
                                {{ number_format($charge) }} รายการ
                            </a>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-info text-center rounded-circle">
                            <i class="fa-solid fa-comments-dollar text-lg opacity-10" aria-hidden="true"></i>
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
                            <p class="text-sm mb-0 font-weight-bold">รายการรอตามจ่าย</p>
                            <a href="#" class="font-weight-bolder">
                                {{ number_format($charge) }} รายการ
                            </a>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-secondary text-center rounded-circle">
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
                            <p class="text-sm mb-0 font-weight-bold">ดำเนินการตามจ่ายแล้ว</p>
                            <a href="{{ route('paid.success') }}" class="font-weight-bolder">
                                {{ number_format($success) }} รายการ
                            </a>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-success text-center rounded-circle">
                            <i class="fa-solid fa-check-to-slot text-lg opacity-10" aria-hidden="true"></i>
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
                            <a href="{{ route('deny') }}" class="font-weight-bolder">
                                {{ number_format($deny) }} รายการ
                            </a>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-danger text-center rounded-circle">
                            <i class="fa-solid fa-rectangle-xmark text-lg opacity-10" aria-hidden="true"></i>
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
            <div class="card-header pb-0 bg-transparent">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-capitalize">
                            <i class="fa-solid fa-circle-dollar-to-slot"></i>
                            Transaction - ใบแจ้งตามจ่าย 
                            <span class="badge bg-danger">
                                <i class="fa-regular fa-bell"></i>
                                New
                            </span>
                        </h6>
                    </div>
                    <div class="col-md-6 text-end">
                        <h6 class="text-capitalize">
                            <a href="{{ route('paid.list') }}" class="btn btn-info btn-sm">
                                <i class="fa-solid fa-clipboard-check"></i>
                                รายการทั้งหมด
                            </a>
                        </h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (COUNT($data) == 0)
                <div class="alert alert-warning text-center" role="alert">
                    ไม่มีรายการที่ต้องตามจ่าย
                </div>
                @else
                <ol class="list-group">
                    @foreach ($data as $res)
                    <a href="{{ route('paid.detail',$res->trans_code) }}">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">
                                    {{ $res->trans_code }}
                                </div>
                                    {{ "เรียกเก็บจาก ".$res->h_name }} <br>
                                <small>
                                    <i class="fa-regular fa-calendar"></i>
                                    {{ "วันที่เรียกเก็บ ".date("Y-m-d", strtotime($res->create_date)) }} <br>
                                </small>
                            </div>
                            <span class="badge bg-primary rounded-pill" style="width: 20%;font-size:14px;">
                                ยอด {{ number_format($res->total,2) }} บาท
                            </span>
                        </li>
                    </a>
                    @endforeach
                </ol>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
@section('script')

@endsection
