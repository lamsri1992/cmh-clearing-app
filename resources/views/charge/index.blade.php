@extends('layouts.app')
@section('content')
@foreach ($count as $res)
@php
    $wait = $res->wait;
    $deny = $res->deny;
    $charge = $res->charge;
    $deptor = $res->deptor;
@endphp
<div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 font-weight-bold">ยอดลูกหนี้ทั้งหมด</p>
                            <span class="font-weight-bolder">{{ number_format($deptor,2) }} บาท</span>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-success text-center rounded-circle">
                            <i class="fa-solid fa-clipboard-list text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 font-weight-bold">รอนำส่ง</p>
                            <a href="{{ route('charge.list') }}" class="font-weight-bolder">
                                {{ number_format($wait) }} รายการ
                            </a>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-info text-center rounded-circle">
                            <i class="fa-solid fa-spinner fa-spin text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 font-weight-bold">เรียกเก็บแล้ว</p>
                            <a href="{{ route('charge.sent') }}" class="font-weight-bolder">
                                {{ number_format($charge) }} รายการ
                            </a>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-primary text-center rounded-circle">
                            <i class="fa-solid fa-check text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 font-weight-bold">ถูกปฏิเสธจ่าย</p>
                            <a href="#" class="font-weight-bolder">
                                {{ number_format($deny) }} รายการ
                            </a>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-danger text-center rounded-circle">
                            <i class="fa-solid fa-xmark text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-capitalize">
                            <i class="fa-solid fa-clipboard-list"></i>
                            รายการทั้งหมด
                        </h6>
                    </div>
                    <div class="col-md-6 text-end">
                        <button type="button" class="btn btn-success btn-sm"
                            data-bs-toggle="modal" data-bs-target="#import">
                            <i class="fa-solid fa-cloud-upload"></i>
                            Import Excel
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div style="margin-bottom: 1rem;">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" id="min" name="min" class="form-control" placeholder="เลือกช่วงวันที่เริ่มต้น">
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="max" name="max" class="form-control" placeholder="เลือกช่วงวันที่สิ้นสุด">
                        </div>
                    </div>
                </div>
                <table id="listData" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">วันที่</th>
                            <th class="text-center">VN</th>
                            <th>หน่วยบริการ</th>
                            <th class="text-center">HN</th>
                            <th class="text-end">ยอดลูกหนี้</th>
                            <th class="text-end">ยอดเรียกเก็บ</th>
                            <th class="text-end">Ambulance</th>
                            <th class="text-end">ยอดรวม</th>
                            <th class="text-center">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $res)
                        @php $total = $res->paid + $res->ambulance; @endphp
                            <tr>
                                <td class="text-center">{{ date("Y-m-d", strtotime($res->visit_date)); }}</td>
                                <td class="text-center">{{ $res->vn }}</td>
                                <td>{{ $res->h_name }}</td>
                                <td class="text-center">{{ $res->hn }}</td>
                                <td class="text-end text-primary fw-bold">{{ number_format($res->total,2) }}</td>
                                <td class="text-end text-success fw-bold">{{ number_format($res->paid,2) }}</td>
                                <td class="text-end text-danger fw-bold">{{ number_format($res->ambulance,2) }}</td>
                                <td class="text-end fw-bold" style="text-decoration-line: underline">{{ number_format($total,2) }}</td>
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
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endforeach
<!-- Modal -->
<div class="modal fade" id="import" tabindex="-1" aria-labelledby="importLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" enctype="multipart/form-data" action="{{ route('charge.import') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="importText"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <input id="select-file" name="select-file" type="file" class="custom-file-input" required>
                        <small class="text-danger">(ไฟล์นามสกุล .xlsx หรือ .xls เท่านั้น)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-success"
                        onclick="Swal.fire({
                            title: 'ยืนยันการนำเข้าข้อมูล Excel ?',
                            showDenyButton: true,
                            confirmButtonText: 'นำเข้า',
                            denyButtonText: 'ยกเลิก',
                            allowEscapeKey: false,
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                            let timerInterval;
                            form.submit()
                            Swal.fire({
                                icon: 'warning',
                                title: 'กำลังนำเข้า',
                                text: 'กรุณารอจนกว่าจะนำเข้าสำเร็จ ห้ามปิดหน้าจอนี้ !!',
                                timerProgressBar: true,
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                    const timer = Swal.getPopup().querySelector('b');
                                    timerInterval = setInterval(() => {
                                    timer.textContent = `${Swal.getTimerLeft()}`;
                                    }, 100);
                                },
                                willClose: () => {
                                    clearInterval(timerInterval);
                                }
                                }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.timer) {
                                    console.log('Import Success');
                                }
                                });
                            }
                        });"
                        >
                        <i class="fa-solid fa-cloud-upload"></i>
                        Import Excel
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/listTableCharge.js') }}"></script>
@endsection
