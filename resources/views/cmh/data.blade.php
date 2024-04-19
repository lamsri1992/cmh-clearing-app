@extends('layouts.app')
@section('content')
@foreach ($count as $res)
@php
    $all = $res->trans_all;
    $wait = $res->trans_wait;
    $total = $res->trans_amount;
@endphp
<div class="row">
    <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 font-weight-bold">ข้อมูลเรียกเก็บทั้งหมด</p>
                            <a href="#" class="font-weight-bolder">{{ number_format($all) }} รายการ</a>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-success text-center rounded-circle">
                            <i class="fa-solid fa-clipboard-list text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 font-weight-bold">รอประมวลผล</p>
                            <a href="#" class="font-weight-bolder">{{ number_format($wait) }} รายการ</a>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-primary text-center rounded-circle">
                            <i class="fa-solid fa-spinner fa-spin text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 font-weight-bold">ยอดเรียกเก็บ / ตามรอบ</p>
                            <a href="#" class="font-weight-bolder">{{ number_format($total,2) }} บาท</a>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-warning text-center rounded-circle">
                            <i class="fa-solid fa-comments-dollar text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-capitalize">
                            <i class="fa-regular fa-file"></i>
                            ข้อมูลเรียกเก็บรอประมวลผล
                        </h6>
                        <small>
                            <i class="fa-solid fa-spinner fa-spin"></i>
                            ข้อมูลจะถูกประมวลผลโดยอัตโนมัติทุกวันที่ 5 ของเดือน
                        </small>
                    </div>
                    <div class="col-md-6 text-end">
                        @if ($wait > 0)
                        <form action="{{ route('cmh.process') }}">
                            <button type="button" class="btn btn-sm btn-secondary"
                                onclick="Swal.fire({
                                    icon: 'warning',
                                    title: 'ประมวลผลข้อมูล {{ number_format($wait) }} รายการ ?',
                                    text: 'ข้อมูลจะถูกส่งเรียกเก็บไปยังแต่ละหน่วยบริการ',
                                    showDenyButton: true,
                                    confirmButtonText: 'ประมวลผลข้อมูล',
                                    denyButtonText: 'ยกเลิก'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        form.submit()
                                    }
                                });"
                                >
                            <i class="fa-solid fa-database"></i>
                            Manual Process
                            </button>
                        </form>
                        @else
                        <small>
                            <i>ไม่มีรายการรอประมวลผล</i>
                        </small>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="listData" class="display nowarp" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">รหัสหน่วยบริการ</th>
                            <th>ชื่อหน่วยบริการ</th>
                            <th class="text-center">จำนวน Transaction</th>
                            {{-- <th class="text-end">ยอดเรียกเก็บ</th> --}}
                            <th class="text-center">สถานะ</th>
                            <th class="text-center"><i class="fa-solid fa-search"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $res)
                        <tr>
                            <td class="text-center">{{ $res->h_code }}</td>
                            <td>{{ $res->h_name }}</td>
                            <td class="text-center">{{ $res->number }}</td>
                            {{-- <td class="text-end fw-bold">{{ number_format($res->total,2) }}</td> --}}
                            <td class="text-center">
                                <span class="badge {{ $res->p_color }}">
                                    {{ $res->p_name }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('cmh.detail',$res->h_code) }}" class="badge bg-success">
                                    <i class="fa-solid fa-list"></i>
                                    รายละเอียด
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
new DataTable('#listData', {
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
    ],
    responsive: true,
    scrollX: true,
    oLanguage: {
        oPaginate: {
            sFirst: '<small>หน้าแรก</small>',
            sLast: '<small>หน้าสุดท้าย</small>',
            sNext: '<small>ถัดไป</small>',
            sPrevious: '<small>กลับ</small>'
        },
        sSearch: '<small><i class="fa fa-search"></i> ค้นหา</small>',
        sInfo: '<small>ทั้งหมด _TOTAL_ รายการ</small>',
        sLengthMenu: '<small>แสดง _MENU_ รายการ</small>',
        sInfoEmpty: '<small>ไม่มีข้อมูล</small>'
    },
});
</script>
@endsection
