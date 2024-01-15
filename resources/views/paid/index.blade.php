@extends('layouts.app')
@section('content')
<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <h6 class="text-capitalize">
                    <i class="fa-solid fa-list-check"></i>
                    {{ Request::route()->getName() }}
                </h6>
            </div>
            <div class="card-body">
                <table id="listData" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>REC_NO::</th>
                            <th>วันที่รับบริการ</th>
                            <th>หน่วยบริการ</th>
                            <th>HN</th>
                            <th class="text-end">ค่าใช้จ่ายจริง</th>
                            <th class="text-end">ยอดที่เรียกเก็บได้</th>
                            <th class="text-end">ค่าใช้จ่าย Refer</th>
                            <th class="text-end">ยอดรวม</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $res)
                            <tr>
                                <td>{{ $res->rec_no }}</td>
                                <td>{{ $res->date_rx }}</td>
                                <td>{{ $res->h_name }}</td>
                                <td>{{ $res->hn }}</td>
                                <td class="text-end">{{ number_format($res->amount,2) }}</td>
                                <td class="text-end">{{ number_format($res->paid,2) }}</td>
                                <td class="text-end">{{ number_format($res->paid_am,2) }}</td>
                                <td class="text-end fw-bold">{{ number_format($res->total,2) }}</td>
                                <td>
                                    <span class="badge {{ $res->p_color }}">{{ $res->p_name }}</span>
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
<script src="{{ asset('js/listTablePaid.js') }}"></script>
@endsection
