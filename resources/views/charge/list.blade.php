@extends('layouts.app')
@section('content')
<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <h6 class="text-capitalize">
                    <i class="fa-solid fa-file-invoice"></i>
                    รายการรอตรวจสอบแยกตามโรงพยาบาล
                </h6>
            </div>
            <div class="card-body">
                @if (count($data) > 0)
                <table id="listData" class="table table-hover table-borderless table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-filter"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $res)
                        <tr>
                            <td>
                                <a href="{{ route('charge.transaction',base64_encode($res->hospmain)) }}">
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">
                                                {{ $res->h_name }}
                                            </div>
                                            <i class="fa-solid fa-paper-plane text-info"></i>
                                            ยอดเรียกเก็บ OP_AE (UC นอกเขต อุบัติเหตุ และฉุกเฉิน)<br>
                                            {{ number_format($res->total,2) }} บาท 
                                        </div>
                                        <span class="badge bg-primary rounded-pill" style="width: 15%;">
                                            {{ number_format($res->number) }} รายการ
                                        </span>
                                    </li>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <span><i>ไม่มีข้อมูล</i></span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    new DataTable('#listData', {
    lengthMenu: [
        [5, 10, 15, -1],
        [5, 10, 15, "All"]
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
