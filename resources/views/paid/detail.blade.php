@extends('layouts.app')
@section('content')
<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <h6 class="text-capitalize">
                    <i class="fa-solid fa-file-invoice"></i>
                    Transaction Code : {{ $id }}
                </h6>
            </div>
            <div class="card-body">
                <table id="listData" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">REC_NO::</th>
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
                        @php
                            $orgDate = $res->date_rx;  
                            $newDate = date("Y-m-d", strtotime($orgDate));  
                        @endphp
                            <tr>
                                <td class="text-center">{{ $res->rec_no }}</td>
                                <td class="text-center">{{ $newDate }}</td>
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
                </table>
                @if ($trans->trans_status != 7)
                @foreach ($check as $item)
                @if ($item->progress >= 1)
                <p>
                    <div class="alert alert-danger" role="alert">
                        ค้างดำเนินการตรวจสอบข้อมูลตามจ่าย :: <b>{{ $item->progress }} รายการ</b>
                    </div>
                </p>
                @else
                <p class="text-center">
                    <button class="btn btn-primary btn-lg"
                        onclick="Swal.fire({
                            icon: 'warning',
                            title: 'ยืนยันการดำเนินการ',
                            text: 'Transaction Code :: '+ {{ $id }},
                            footer: '<small>หากยืนยันแล้ว จะไม่สามารถยกเลิกได้</small>'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'ดำเนินการเสร็จสิ้น',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                                window.setTimeout(function () {
                                    location.replace('/paid/transaction/confirm/'+{{ $id }})
                                }, 3500);
                            } 
                        });">
                        <i class="fa-solid fa-clipboard-check"></i>
                        ดำเนินการตามจ่าย Transaction นี้
                    </button>
                </p>
                @endif
                @endforeach
                @else
                <div class="text-center">
                    <p>
                        <div class="alert alert-success" role="alert">
                            <i class="fa-solid fa-spinner fa-spin"></i>
                            อยู่ระหว่างรอดำเนินการจ่าย
                        </div>
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/listTableTransactionPaid.js') }}"></script>
@endsection
