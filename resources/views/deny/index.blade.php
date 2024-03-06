@extends('layouts.app')
@section('content')
<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-capitalize">
                            <i class="fa-solid fa-file-circle-xmark"></i>
                            รายการถูกปฏิเสธจ่าย
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
                <table id="basicTable" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">TransCode::</th>
                            <th class="text-center">VN</th>
                            <th class="text-center">วันที่รับบริการ</th>
                            <th>เจ้าหนี้</th>
                            <th class="text-center">HN</th>
                            <th class="text-end">ยอดหนี้</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-center">หมายเหตุ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $res)
                            <tr>
                                <td class="text-center">{{ $res->trans_code }}</td>
                                <td class="text-center">{{ $res->vn }}</td>
                                <td class="text-center">{{ date("Y-m-d", strtotime($res->visit_date)) }}</td>
                                <td>{{ $res->h_name }}</td>
                                <td class="text-center">{{ $res->hn }}</td>
                                <td class="text-end fw-bold" style="text-decoration-line: underline">
                                    {{ number_format($res->paid + $res->ambulance,2) }}
                                </td>
                                <td class="text-center text-white {{ $res->p_color }}">{{ $res->p_name }}</td>
                                <td class="text-center">{{ $res->deny_note }}</td>
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

@endsection
