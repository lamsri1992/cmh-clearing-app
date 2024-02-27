@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <h6 class="text-capitalize">
                    <i class="fa-solid fa-cloud-download"></i>
                    รายการประมวลผลข้อมูลจาก API
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <span class="fw-bold">ข้อมูลประมวลผลล่าสุด :: </span>
                        @if ($count <= 0)
                        <i>ไม่พบการประมวลผลข้อมูล</i>
                        @else
                            <i class="fa-regular fa-calendar-check"></i>
                            {{ date("Y-m-d", strtotime($data->date_rx)); }}
                        @endif
                    </div>                    
                    <div class="col-md-6">
                        <span class="fw-bold">จำนวนข้อมูล :: </span>
                        {{ number_format($count)." รายการ" }}
                    </div>
                    <div class="col-md-12" style="margin-top: 1rem;">
                        <span class="fw-bold">เกณฑ์การจ่าย</span>
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th width="30%">ปี</th>
                                    <th width="30%">ประเภท</th>
                                    <th width="30%">ยอดจ่ายจริง (ไม่เกิน)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($op_paid as $res)
                                <tr>
                                    <td>{{ $res->year }}</td>
                                    <td>{{ $res->type }}</td>
                                    <td>{{ number_format($res->paid,2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <table class="table table-striped table-bordered text-center">
                            <thead>
                                <tr>
                                    <th width="30%">ปี</th>
                                    <th width="30%">ประเภท</th>
                                    <th width="30%">ยอดเหมาจ่าย</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($op_refer as $res)
                                <tr>
                                    <td>{{ $res->year }}</td>
                                    <td>{{ $res->type }}</td>
                                    <td>{{ number_format($res->paid,2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <span class="fw-bold">
                            ประมวลผลสิทธิการรักษา
                        </span>
                        <table id="basicTable" class="table table-striped table-borderless" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center">รหัสสิทธิ</th>
                                    <th>ชื่อสิทธิ</th>
                                    <th class="text-center">
                                        <i class="fa-solid fa-bars"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bent as $res)
                                <tr>
                                    <td class="text-center">{{ $res->pttype }}</td>
                                    <td>{{ $res->ptname }}</td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-success btn-xs"
                                            onclick="
                                                var pttype = {{ $res->pttype }};
                                                Swal.fire({
                                                    title: 'ยืนยันการ Map สิทธิการรักษา',
                                                    text: '{{ $res->ptname }}',
                                                    icon: 'info',
                                                    showCancelButton: true,
                                                    confirmButtonText: 'ยืนยัน',
                                                    cancelButtonText: 'ยกเลิก',
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                    $.ajax({
                                                        url: '{{ route('process.map') }}',
                                                        method: 'GET',
                                                        data: {
                                                            pttype: pttype,
                                                        },
                                                        success: function (data) {
                                                            Swal.fire({
                                                                icon: 'success',
                                                                title: 'Map สิทธิสำเร็จ',
                                                                showConfirmButton: false,
                                                                timer: 3000
                                                            })
                                                            window.setTimeout(function () {
                                                                location.reload()
                                                            }, 1500);
                                                        }
                                                    });
                                                }
                                            })">
                                            <i class="fa-solid fa-circle-check"></i>
                                            Map สิทธิ
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>                  
                </div>
            </div> --}}
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(function(){
        $(".datepicker").datepicker();
        $(".datepicker").datepicker( "option", "dateFormat", 'yy-mm-dd');
    });
</script>
@endsection
