@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="text-capitalize">
                            <i class="fa-regular fa-file"></i>
                            รายงานข้อมูล
                        </h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="listData" class="display nowarp" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">รหัส รพ.เจ้าหนี้</th>
                            <th class="text-start">ชื่อ รพ. เจ้าหนี้</th>
                            <th class="text-center">รหัส รพ.ลูกหนี้</th>
                            <th class="text-start">ชื่อ รพ.ลูกหนี้</th>
                            <th class="text-center">จำนวน</th>
                            <th class="text-end">ค่าใช้จ่ายที่เรียกเก็บ</th>
                            <th class="text-center">รหัสเดือน</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $res)
                        <tr>
                            <td class="text-center">{{ $res->trans_hcode }}</td>
                            <td class="text-start">{{ $res->visit_hospital }}</td>
                            <td class="text-center">{{ $res->trans_hmain }}</td>
                            <td class="text-start">{{ $res->main_hospital }}</td>
                            <td class="text-center">{{ $res->cases }}</td>
                            <td class="text-end fw-bold">{{ number_format($res->total,2) }}</td>
                            <td class="text-center">{{ $month }}</td>
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
    layout: {
        topStart: {
            buttons: ['excel', 'print']
        }
    },
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
