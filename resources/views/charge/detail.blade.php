@extends('layouts.app')
@section('content')
<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-capitalize">
                            <i class="fa-solid fa-file-invoice"></i>
                            Transaction Code : {{ $id }}
                        </h6>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-primary btn-xs" type="button">
                            <i class="fa-solid fa-arrow-left"></i>
                            ย้อนกลับ
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="listData" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">วันที่</th>
                            <th class="text-center">VN</th>
                            <th>รพ.ลูกหนี้</th>
                            <th class="text-center">HN</th>
                            <th class="text-end">ยอดลูกหนี้</th>
                            <th class="text-end">จ่ายตามเกณฑ์</th>
                            <th class="text-end">ส่วนต่าง</th>
                            <th class="text-end">Ambulance</th>
                            <th class="text-end">ยอดเรียกเก็บ</th>
                            <th class="text-center">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $all = 0; @endphp
                        @php $all_diff = 0; @endphp
                        @foreach ($data as $res)
                        @php 
                            $total = $res->paid + $res->ambulance;
                            $all += $total;
                            $diff = $res->paid - $res->amount;
                            $all_diff += $diff;
                        @endphp
                            <tr>
                                <td class="text-center">{{ date("d/m/Y", strtotime($res->visit_date)) }}</td>
                                <td class="text-center">{{ $res->vn }}</td>
                                <td>{{ $res->h_name }}</td>
                                <td class="text-center">{{ $res->hn }}</td>
                                <td class="text-end text-primary fw-bold">{{ number_format($res->amount,2) }}</td>
                                <td class="text-end text-success fw-bold">{{ number_format($res->paid,2) }}</td>
                                <td class="text-end text-danger fw-bold">{{ number_format($diff,2) }}</td>
                                <td class="text-end text-warning fw-bold">{{ number_format($res->ambulance,2) }}</td>
                                <td class="text-end fw-bold" style="text-decoration-line: underline">{{ number_format($total,2) }}</td>
                                <td class="text-center text-white {{ $res->p_color }}">{{ $res->p_name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-center alert alert-danger" style="margin-top: 0.5rem;">
                    ยอดส่วนต่างรวมทั้งหมด : {{ number_format($all_diff,2) }} บาท
                </div>
                @if ($paid != NULL)
                <div class="row mt-4">
                    <div class="col-md-6">
                        <span class="badge rounded-pill bg-dark">
                            <i class="fa-solid fa-receipt"></i>
                            {{ "เลขที่หนังสือ :: ".$paid->paid_no }}
                        </span>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ asset('uploads/'.$paid->file) }}" target="_blank">
                            <i class="fa-regular fa-file-pdf text-danger"></i>
                            File - {{ $paid->file }}
                        </a>
                    </div>
                </div>
                <div style="margin-top: 1rem;">
                    <table class="table table-striped text-center table-bordered">
                        <thead>
                          <tr>
                            <th scope="col" width="30%">ยอดเรียกเก็บ</th>
                            <th scope="col" width="30%">ยอดจ่ายจริง</th>
                            <th scope="col" width="30%">ส่วนต่างการเรียกเก็บ</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="text-primary fw-bold">{{ number_format($all,2) }}</td>
                            <td class="text-success fw-bold">{{ number_format($paid->balance,2) }}</td>
                            <td class="text-danger fw-bold">{{ number_format($paid->balance - $all,2) }}</td>
                          </tr>
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/listTableCharge.js') }}"></script>
@endsection
