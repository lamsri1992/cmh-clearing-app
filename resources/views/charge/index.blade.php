@extends('layouts.app')
@section('content')
@foreach ($count as $res)
@php
    $wait = $res->wait;
    $depts = $res->depts;
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
                            <a href="#" class="font-weight-bolder">{{ number_format($deptor,2) }} บาท</a>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-success text-center rounded-circle">
                            <i class="fa-solid fa-comments-dollar text-lg opacity-10" aria-hidden="true"></i>
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
                            <i class="fa-solid fa-paper-plane text-lg opacity-10" aria-hidden="true"></i>
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
                            <p class="text-sm mb-0 font-weight-bold">รอประมวลผล</p>
                            <a href="{{ route('charge.sent') }}" class="font-weight-bolder">
                                {{ number_format($charge) }} รายการ
                            </a>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-primary text-center rounded-circle">
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
                            <p class="text-sm mb-0 font-weight-bold">ข้อมูลลูกหนี้เรียกเก็บ</p>
                            <a href="#" class="font-weight-bolder">
                                {{ number_format($depts) }} รายการ
                            </a>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-warning text-center rounded-circle">
                            <i class="fa-solid fa-list-check text-lg opacity-10" aria-hidden="true"></i>
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
                            <i class="fa-solid fa-history"></i>
                            รายการนำเข้าข้อมูลลูกหนี้
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
                <table id="listData" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">
                                วันที่นำเข้าข้อมูล
                            </th>
                            <th class="text-center">
                                หน่วยบริการ
                            </th>
                            <th class="text-center">
                                <i class="fa-solid fa-file-excel text-success"></i>
                                ไฟล์ Excel
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $res)
                            <tr>
                                <td class="text-center">
                                    {{ date("d/m/Y", strtotime($res->import_date)); }}
                                </td>
                                <td class="text-center">
                                    {{ $res->h_name }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ asset('ImportFiles/'.$res->ex_file) }}" target="_blank">
                                        <i class="fa-solid fa-download"></i>
                                        {{ $res->ex_file }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
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
                    <h1 class="modal-title fs-5" id="importText">
                        <i class="fa-solid fa-file-excel"></i>
                        Import Excel
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <input id="select-file" name="select-file" type="file" class="custom-file-input" required>
                        <small class="text-danger">(ไฟล์นามสกุล .xlsx หรือ .xls เท่านั้น)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnUpload" type="button" class="btn btn-sm btn-success"
                        onclick="Swal.fire({
                            title: 'ยืนยันการนำเข้าข้อมูล Excel ?',
                            showDenyButton: true,
                            confirmButtonText: 'นำเข้า',
                            denyButtonText: 'ยกเลิก',
                            allowEscapeKey: false,
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                            document.getElementById('btnUpload').disabled = true;
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
                <div class="text-center" style="margin-bottom: 1rem;">
                    <a href="{{ asset('dataset_template.xls') }}">
                        <i class="fa-solid fa-download text-primary"></i>
                        ดาวน์โหลด Template + Query
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/listTableCharge.js') }}"></script>
@endsection
