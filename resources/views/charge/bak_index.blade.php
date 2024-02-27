@extends('layouts.app')
@section('content')
@foreach ($count as $res)
@php
    $wait = $res->wait;
    $charge = $res->charge;
    $deny = $res->deny;
    $confirm = $res->confirm;
    $cancel = $res->cancel;
@endphp
<div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 font-weight-bold">รอตรวจสอบ</p>
                            <a href="{{ route('charge') }}" class="font-weight-bolder">
                                {{ number_format($wait) }} รายการ
                            </a>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-warning text-center rounded-circle">
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
                            <p class="text-sm mb-0 font-weight-bold">ตรวจสอบแล้ว</p>
                            <a href="{{ route('charge.list') }}" class="font-weight-bolder">
                                {{ number_format($confirm) }} รายการ
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
    <div class="col-xl-3 col-sm-6">
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
                        <div class="icon icon-shape bg-success text-center rounded-circle">
                            <i class="fa-solid fa-comment-dollar text-lg opacity-10" aria-hidden="true"></i>
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
                            <a href="{{ route('deny') }}" class="font-weight-bolder">
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
    <div class="col-xl-12 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 font-weight-bold">รายการเรียกเก็บ</p>
                            <a href="#" class="font-weight-bolder chargeClick" data-id="OPAE" data-text="เรียกเก็บ รพ. ภายในจังหวัด" style="font-size: 20px;">
                                เรียกเก็บ รพ. ภายในจังหวัด
                            </a>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-secondary text-center rounded-circle">
                            <i class="fa-solid fa-house-medical text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="col-xl-12 col-sm-6">
        <div class="card">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 font-weight-bold">รายการเรียกเก็บ</p>
                            <a href="#" class="font-weight-bolder" data-id="FWF" data-text="สิทธิต่างด้าว" style="font-size: 20px;">
                                สิทธิต่างด้าว
                            </a>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-secondary text-center rounded-circle">
                            <i class="fa-solid fa-address-card text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="col-xl-12 col-sm-6">
        <div class="card">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 font-weight-bold">รายการเรียกเก็บ</p>
                            <a href="#" class="font-weight-bolder ctClick" data-id="CT" data-text="การรับบริการ CT Scan" 
                            style="font-size: 20px;">
                                การรับบริการ CT Scan
                            </a>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-secondary text-center rounded-circle">
                            <i class="fa-solid fa-x-ray text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="col-xl-12 col-sm-6">
        <div class="card">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 font-weight-bold">รายการเรียกเก็บ</p>
                            <a href="#" class="font-weight-bolder" data-id="MRI" data-text="การรับบริการ MRI"
                            style="font-size: 20px;">
                                การรับบริการ MRI
                            </a>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-secondary text-center rounded-circle">
                            <i class="fa-solid fa-chalkboard text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="menu" tabindex="-1" aria-labelledby="menuLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('charge.filter') }}" method="GET">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="menuText"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="" class="form-label">วันที่เริ่มต้น</label>
                        <input type="text" class="form-control datepicker" name="d_start" placeholder="กรุณาเลือกวันที่" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">วันที่สิ้นสุด</label>
                        <input type="text" class="form-control datepicker" name="d_end" placeholder="กรุณาเลือกวันที่" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">โรงพยาบาล</label>
                        <select class="select-basic" name="hospital" required>
                            <option value="">เลือกโรงพยาบาล</option>
                            @foreach ($hos as $res)
                            <option value="{{ $res->H_CODE }}">{{ $res->H_NAME }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3" hidden>
                        <input type="text" class="form-control" name="menuChoose" id="menuChoose">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fa-solid fa-search"></i>
                        ค้นหาข้อมูลเรียกเก็บ
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="import" tabindex="-1" aria-labelledby="importLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="frmImport" method="POST" enctype="multipart/form-data" action="{{ route('charge.import') }}">
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
                    <div class="mb-3" hidden>
                        <input type="text" class="form-control" name="importChoose" id="importChoose">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="fa-solid fa-cloud-upload"></i>
                        Import Excel
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach
@endsection
@section('script')
<script>
    $('.chargeClick').click(function () {
        var id = $(this).attr("data-id");
        var text = $(this).attr("data-text");
        document.getElementById('menuText').innerHTML = text;
        document.getElementById('menuChoose').value = id;
        $("#menu").modal('show')
    });

    $('.ctClick').click(function () {
        var id = $(this).attr("data-id");
        var text = $(this).attr("data-text");
        document.getElementById('importText').innerHTML = text;
        document.getElementById('importChoose').value = id;
        $("#import").modal('show')
    });
      
    $(document).ready(function () {
        $('.select-basic').select2({
            width: '100%',
            dropdownParent: $('#menu')
        });
    });

    $('#frmImport').on("submit", function (event) {
        let timerInterval
        Swal.fire({
        title: 'กำลังทำการ Import',
        timer: 1000000,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading()
            const b = Swal.getHtmlContainer().querySelector('b')
            timerInterval = setInterval(() => {
            b.textContent = Swal.getTimerLeft()
            }, 100)
        },
        willClose: () => {
            clearInterval(timerInterval)
        }
        }).then((result) => {
        /* Read more about handling dismissals below */
        if (result.dismiss === Swal.DismissReason.timer) {
            console.log('I was closed by the timer')
        }
        })
    });
</script>
@endsection