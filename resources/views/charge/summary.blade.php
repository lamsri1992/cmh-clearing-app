@extends('layouts.app')
@section('content')
<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-capitalize">
                            <i class="fa-solid fa-file-circle-check text-success"></i>
                            Transaction ที่ดำเนินการตามจ่ายแล้ว
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
                <table id="listData" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">Transaction</th>
                            <th class="text-center">วันที่ยืนยันข้อมูล</th>
                            <th class="text-center">ลูกหนี้</th>
                            <th class="text-center">ยอดเรียกเก็บ</th>
                            <th class="text-center">ยอดจ่ายจริง</th>
                            <th class="text-center">ส่วนต่าง</th>
                            <th class="text-center">เอกสารแนบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $res)
                        @php $diff = $res->balance - $res->total @endphp
                        @if ($diff < 0)
                            @php $text = "text-danger"; @endphp
                        @else
                        @php $text = "text-success"; @endphp
                        @endif
                            <tr>
                                <td class="text-center">
                                    <a href="{{ route('charge.detail',$res->trans_code) }}">
                                        {{ $res->trans_code }}
                                    </a>
                                </td>
                                <td class="text-center">{{ $res->trans_paiddate }}</td>
                                <td class="text-center">{{ $res->h_name }}</td>
                                <td class="text-center fw-bold">{{ number_format($res->total,2) }}</td>
                                <td class="text-center fw-bold text-primary">{{ number_format($res->balance,2) }}</td>
                                <td class="text-center fw-bold {{ $text }}">{{ number_format($diff,2) }}</td>
                                <td class="text-center">
                                    <div class="text-center">
                                        <a href="{{ asset('uploads/'.$res->file) }}" target="_blank">
                                            <i class="fa-regular fa-file-pdf text-danger"></i>
                                            File - {{ $res->file }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/listTablePaidList.js') }}"></script>
@endsection
