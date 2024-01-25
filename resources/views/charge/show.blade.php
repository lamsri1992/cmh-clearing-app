@extends('layouts.app')
@section('content')
<div class="row mt-4">
    <div class="col-lg-8 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-body">
                <span class="fw-bold">
                    <i class="fa-regular fa-clipboard"></i>
                    ข้อมูลเรียกเก็บ
                </span>
                <div class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column p-sm-3 p-0">
                    <div class="col-md-6">
                        <p><b>ผู้บันทึก</b> : {{ $data->reporter }}</p>
                        <p><b>VN</b> : {{ $data->vn }}</p>
                        <p><b>HN</b> : {{ $data->hn }}</p>
                        <p><b>PID</b> : {{ $data->pid }}</p>
                        <p><b>สิทธิการรักษา</b> : {{ $data->ptname }}</p>
                        <p><b>วันที่รับบริการ</b> : {{ date("Y-m-d", strtotime($data->date_rx)) }}</p>
                        <p><b>วันที่เรียกเก็บ</b> : {{ date("Y-m-d", strtotime($data->date_rec)) }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>เรียกเก็บไปยัง</b> : {{ $data->h_name }}</p>
                        <p><b>ICD9</b> : {{ $data->icd9 }}</p>
                        <p><b>ICD10</b> : {{ $data->icd10 }}</p>
                        <p><b>Refer</b> : {!! ($data->refer == 1) ? 
                            '<i class="fa-solid fa-check-circle text-success"></i> ใช่' 
                            : 
                            '<i class="fa-solid fa-xmark-circle text-danger"></i> ไม่ใช่'
                            !!}
                        </p>
                        <p>
                            <b>สถานะ</b> : 
                            {{ $data->p_name." (".date("Y-m-d", strtotime($data->updated)).")" }} <br>
                            <i>{{ $data->note }}</i>
                        </p>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="50%">ค่ายา</th>
                            <td class="text-end">{{ number_format($data->drug,2) }}</td>
                        </tr>
                        <tr>
                            <th>Lab</th>
                            <td class="text-end">{{ number_format($data->lab,2) }}</td>
                        </tr>
                        <tr>
                            <th>หัตถการ</th>
                            <td class="text-end">{{ number_format($data->proc,2) }}</td>
                        </tr>
                        <tr>
                            <th>ค่าบริการ</th>
                            <td class="text-end">{{ number_format($data->service_charge,2) }}</td>
                        </tr>
                        <tr>
                            <th>รวมทั้งหมด</th>
                            <td class="text-end">{{ number_format($data->amount,2) }}</td>
                        </tr>
                        <tr>
                            <th>ยอดจ่ายจริง <small class="fw-light text-danger">(จ่ายตามเกณฑ์ไม่เกิน 700 บาท)</small></th>
                            <td class="text-end">{{ number_format($data->paid,2) }}</td>
                        </tr>
                        <tr>
                            <th>Ambulance</th>
                            <td class="text-end">{{ number_format($data->ambulance,2) }}</td>
                        </tr>
                        <tr>
                            <th>ยอดเรียกเก็บจริง</th>
                            <td class="text-end fw-bold text-decoration-underline">{{ number_format($data->paid + $data->ambulance,2) }}</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-lg-0 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button id="btnConfirm" type="button" class="btn btn-success"
                        onclick="
                        var recno = {{ $data->vn }}
                        Swal.fire({
                            title: 'ยืนยันข้อมูลการเรียกเก็บ',
                            text: 'กรุณาตรวจสอบข้อมูลก่อนดำเนินการ',
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonText: 'ยืนยัน',
                            cancelButtonText: 'ยกเลิก',
                        }).then((result) => {
                            if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route('charge.confirm') }}',
                                method: 'GET',
                                data: {
                                    recno: recno,
                                },
                                success: function (data) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'ยืนยันเรียกเก็บ',
                                        text: 'บันทึกการดำเนินการเสร็จสิ้น',
                                        showConfirmButton: false,
                                        timer: 3000
                                    })
                                    window.setTimeout(function () {
                                        location.replace('/charge/filter?d_start=&d_end=&hospital=11120&menuChoose=OPAE')
                                    }, 1500);
                                }
                            });
                        }
                    })">
                    <i class="fa-regular fa-paper-plane"></i>
                        ยืนยันการเรียกเก็บ
                    </button>
                    <button id="btnUpdate" class="btn btn-primary" type="button">
                        <i class="fa-solid fa-rotate fa-spin"></i>
                        อัพเดตข้อมูลใหม่
                    </button>
                    <button id="btnCancel" class="btn btn-danger" type="button">
                        <i class="fa-solid fa-ban"></i>
                        ยกเลิกการเรียกเก็บ
                    </button>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-primary" type="button">
                        <i class="fa-solid fa-arrow-left"></i>
                        ย้อนกลับ
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        var pstatus = {{ $data->p_status }};
        if(pstatus != 1) {
            document.getElementById("btnConfirm").disabled = true;
            document.getElementById("btnUpdate").disabled = true;
            document.getElementById("btnCancel").disabled = true;
        }
        Swal.fire({
            title: '{{ $data->p_name }}',
            text: '{{ $data->note }}',
            icon: 'info',
        });
    });

    $('#btnCancel').on("click", function (event) {
        event.preventDefault();
        Swal.fire({
            title: 'ยกเลิกรายการเรียกเก็บ \n{{ " VN : ".$data->vn }}',
            text: 'หากยกเลิกรายการแล้ว จะไม่สามารถย้อนกลับรายการได้อีก',
            showCancelButton: true,
            confirmButtonText: `ยืนยัน`,
            cancelButtonText: `ยกเลิก`,
            icon: 'warning',
            input: 'text',
            inputPlaceholder: 'ระบุหมายเหตุการยกเลิกรายการ'
        }).then((result) => {
            if (result.isConfirmed) {
                var vn = {{ $data->vn }}
                var formData = result.value;
                var token = "{{ csrf_token() }}";
                console.log(vn,formData);
                $.ajax({
                    url: "{{ route('charge.cancel') }}",
                    data:
                    {
                        vn: vn,
                        formData: formData,
                        _token: token
                    },
                    success: function (data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'ยกเลิกรายการแล้ว',
                            showConfirmButton: false,
                            timer: 3000
                        })
                        window.setTimeout(function () {
                            location.reload()
                        }, 1500);
                    }
                });
            }
        })
    });
</script>
@endsection
