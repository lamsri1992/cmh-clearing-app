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
                <ol class="list-group">
                    @php $total = 0 @endphp
                    @foreach ($data as $res)
                    @php $total += $res->total @endphp
                    <a href="{{ route('charge.transaction',base64_encode($res->hospmain)) }}">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">
                                    {{ $res->h_name }}
                                </div>
                                <i class="fa-solid fa-spinner fa-spin text-info"></i>
                                ยอดเรียกเก็บ {{ number_format($res->total,2) }} บาท
                            </div>
                            <span class="badge bg-primary rounded-pill" style="width: 15%;">
                                {{ number_format($res->number) }} รายการ
                            </span>
                        </li>
                    </a>
                    @endforeach
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">
                                รวมยอดเรียกเก็บ
                            </div>
                            ทั้งหมด {{ number_format($total,2) }} บาท
                        </div>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@endsection
