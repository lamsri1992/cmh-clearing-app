@extends('layouts.app')
@section('content')
<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="text-capitalize">
                            <i class="fa-solid fa-clipboard-list"></i>
                            ข้อมูลเรียกเก็บ - {{ $hospital->h_name }}
                        </h6>
                    </div>
                    <small>
                        <i class="fa-solid fa-spinner fa-spin"></i>
                        ข้อมูลจะถูกประมวลผลโดยอัตโนมัติทุกวันที่ 5 ของเดือน
                    </small>
                </div>
            </div>
            <div class="card-body">
                <table id="listData" class="display nowarp" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">Transaction</th>
                            <th>เรียกเก็บไปยัง</th>
                            <th class="text-center">จำนวนเคส</th>
                            <th class="text-end">ค่าใช้จริง</th>
                            <th class="text-end">จ่ายตามเกณฑ์</th>
                            <th class="text-end">ส่วนต่าง</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $res)
                        <tr>
                            <td class="text-center">{{ $res->trans_code }}</td>
                            <td>{{ $res->h_name }}</td>
                            <td class="text-center">{{ $res->number }}</td>
                            <td class="text-end fw-bold text-danger">
                                {{ number_format($res->amount,2) }}
                            </td>
                            <td class="text-end fw-bold text-success">
                                {{ number_format($res->total,2) }}
                            </td>
                            <td class="text-end fw-bold text-primary">
                                {{ number_format($res->amount - $res->total,2) }}
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
