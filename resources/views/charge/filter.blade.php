@extends('layouts.app')
@section('content')
<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <h6 class="text-capitalize">
                    <i class="fa-solid fa-clipboard-list"></i>
                    รายการเรียกเก็บ
                </h6>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 1rem;">
                    <a class="btn btn-secondary btn-sm" data-bs-toggle="collapse" href="#collapseForm" 
                        role="button" aria-expanded="false" aria-controls="collapseForm">
                        <i class="fa-solid fa-filter"></i>
                        Filter : ค้นหาข้อมูลใหม่
                    </a>
                    <a class="btn btn-success btn-sm" href="{{ route('charge.list') }}">
                        <i class="fa-solid fa-file-circle-plus"></i>
                        สร้าง Transaction เรียกเก็บ
                    </a>
                    <form action="{{ route('charge.filter') }}" method="GET">
                        <div class="collapse" id="collapseForm">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="" class="form-label">วันที่เริ่มต้น</label>
                                    <input type="text" class="form-control datepicker" name="d_start" placeholder="กรุณาเลือกวันที่">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">วันที่สิ้นสุด</label>
                                    <input type="text" class="form-control datepicker" name="d_end" placeholder="กรุณาเลือกวันที่">
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">โรงพยาบาล</label>
                                    <select class="select-basic" name="hospital">
                                        <option value="">เลือกโรงพยาบาล</option>
                                        @foreach ($hos as $res)
                                        <option value="{{ $res->H_CODE }}"
                                            {{ ($res->H_CODE == $_REQUEST['hospital']) ? 'SELECTED' : '' }}>
                                            {{ $res->H_NAME }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3" hidden>
                                    <input type="text" class="form-control" name="menuChoose" id="menuChoose">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-search"></i>
                                ค้นหาข้อมูลเรียกเก็บ
                            </button>
                        </div>
                    </form>
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
                            <th class="">สิทธิการรักษา</th>
                            <th class="text-center">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $res)
                        @php $total = $res->paid + $res->ambulance; @endphp
                            <tr>
                                <td class="text-center">{{ $res->vn }}</td>
                                <td class="text-center">{{ date("Y-m-d", strtotime($res->date_rx)); }}</td>
                                <td>{{ $res->h_name }}</td>
                                <td class="text-center">{{ $res->hn }}</td>
                                <td class="text-end text-primary fw-bold">{{ number_format($res->amount,2) }}</td>
                                <td class="text-end text-success fw-bold">{{ number_format($res->paid,2) }}</td>
                                <td class="text-end text-danger fw-bold">{{ number_format($res->ambulance,2) }}</td>
                                <td class="text-end fw-bold" style="text-decoration-line: underline">{{ number_format($total,2) }}</td>
                                <td class="">{{ $res->ptname }}</td>
                                <td class="text-center text-white {{ $res->p_color }}">{{ $res->p_name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/listTableCharge.js') }}"></script>
<script>
    $(function(){
        $(".datepicker").datepicker();
        $(".datepicker").datepicker( "option", "dateFormat", 'yy-mm-dd');
    });
    
    $(document).ready(function () {
        $('.select-basic').select2({
            width: '100%',
        });
    });
</script>
@endsection
