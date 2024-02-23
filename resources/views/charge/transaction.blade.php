@extends('layouts.app')
@section('content')
<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-capitalize">
                            <i class="fa-solid fa-file-circle-plus"></i>
                            Transaction - สร้างใบเรียกเก็บ
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
                {{-- <div style="margin-bottom: 1rem;">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" id="min" name="min" class="form-control" placeholder="เลือกช่วงวันที่เริ่มต้น">
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="max" name="max" class="form-control" placeholder="เลือกช่วงวันที่สิ้นสุด">
                        </div>
                    </div>
                </div> --}}
                <table id="listData" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">VN::</th>
                            <th class="text-center">วันที่รับบริการ</th>
                            <th>หน่วยบริการ</th>
                            <th class="text-center">HN</th>
                            <th class="text-end">ค่าใช้จ่าย</th>
                            <th class="text-end">ยอดเรียกเก็บ</th>
                            <th class="text-end">Refer</th>
                            <th class="text-end">CT / MRI</th>
                            <th class="text-end">CONTRAST</th>
                            <th class="text-end">ยอดรวม</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-center" hidden>HCODE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $res)
                        @php $total = $res->paid + $res->ambulance + $res->pay_order + $res->contrast_pay; @endphp
                            <tr>
                                <td class="text-center">{{ $res->vn }}</td>
                                <td class="text-center">{{ date("Y-m-d", strtotime($res->date_rx)) }}</td>
                                <td>{{ $res->h_name }}</td>
                                <td class="text-center">{{ $res->hn }}</td>
                                <td class="text-end text-primary fw-bold">{{ number_format($res->amount,2) }}</td>
                                <td class="text-end text-success fw-bold">{{ number_format($res->paid,2) }}</td>
                                <td class="text-end text-danger fw-bold">{{ number_format($res->ambulance,2) }}</td>
                                <td class="text-end text-dark fw-bold">{{ number_format($res->pay_order,2) }}</td>
                                <td class="text-end text-warning fw-bold">{{ number_format($res->contrast_pay,2) }}</td>
                                <td class="text-end fw-bold" style="text-decoration-line: underline">{{ number_format($total,2) }}</td>
                                <td class="text-center text-white {{ $res->p_color }}">{{ $res->p_name }}</td>
                                <td class="text-center" hidden>{{ $res->hospmain }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <p>
                    {{-- <button id="btnCreate" class="btn btn-success">
                        <i class="fa-solid fa-check-circle"></i>
                        Create Select
                    </button> --}}
                    <button id="btnCreate_all" class="btn btn-success">
                        <i class="fa-solid fa-check-circle"></i>
                        สร้างใบเรียกเก็บ
                    </button>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/listTableTransaction.js') }}"></script>
<script>
    $(document).ready(function() {
        Swal.fire({
            icon: 'warning',
            title: 'กรุณาดำเนินการสร้างใบเรียกเก็บ',
            text: 'ข้อมูลจะถูกนำส่งอัตโนมัติทุกวันที่ 5 ของเดือน',
        })
    });
</script>
@endsection
