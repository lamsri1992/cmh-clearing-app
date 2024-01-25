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
                        {{ $count." รายการ" }}
                    </div>        
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <span class="fw-bold">
                            ประมวลผลสิทธิการรักษา
                        </span>
                        <table id="basicTable" class="table table-striped table-borderless" width="100%">
                            <thead>
                                <tr>
                                    <th>รหัสสิทธิ</th>
                                    <th>ชื่อสิทธิ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bent as $res)
                                <tr>
                                    <td>{{ $res->pttype }}</td>
                                    <td>{{ $res->ptname }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>                  
                </div>
            </div>
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
