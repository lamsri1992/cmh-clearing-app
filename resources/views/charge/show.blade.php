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
                        <p><b>VN</b> : {{ $data->vn }}</p>
                        <p><b>HN</b> : {{ $data->hn }}</p>
                        <p><b>PID</b> : {{ $data->pid }}</p>
                        <p><b>ผู้รับบริการ</b> : {{ $data->patient }}</p>
                        <p><b>สิทธิการรักษา</b> : {{ $data->ptname }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><b>วันที่รับบริการ</b> : {{ date("d/m/Y", strtotime($data->visit_date)) }}</p>
                        <p><b>เรียกเก็บไปยัง</b> : {{ $data->h_name }}</p>
                        <p><b>ICD10</b> : {{ $data->icd10 }}</p>
                        <p><b>สถานะ</b> : {{ $data->p_name }}</p>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="50%">ค่ายา</th>
                            <td class="text-end">{{ number_format($data->drug,2) }} บาท</td>
                        </tr>
                        <tr>
                            <th>Lab</th>
                            <td class="text-end">{{ number_format($data->lab,2) }} บาท</td>
                        </tr>
                        <tr>
                            <th>Xray</th>
                            <td class="text-end">{{ number_format($data->xray,2) }} บาท</td>
                        </tr>
                        <tr>
                            <th>หัตถการ</th>
                            <td class="text-end">{{ number_format($data->proc,2) }} บาท</td>
                        </tr>
                        <tr>
                            <th>ค่าบริการ</th>
                            <td class="text-end">{{ number_format($data->service_charge,2) }} บาท</td>
                        </tr>
                        <tr>
                            <th>Ambulance</th>
                            <td class="text-end">{{ number_format($data->ambulance,2) }} บาท</td>
                        </tr>
                        <tr>
                            <th>ยอดรวมค่าใช้จ่ายทั้งหมด</th>
                            <td class="text-end">{{ number_format($data->amount,2) }} บาท</td>
                        </tr>
                        <tr>
                            <th>ยอดเรียกเก็บได้ตามเกณฑ์</th>
                            <td class="text-end fw-bold text-decoration-underline">
                                {{ number_format($data->paid + $data->ambulance,2) }} บาท
                            </td>
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
            document.getElementById("btnUpdate").disabled = true;
            document.getElementById("btnCancel").disabled = true;
        }
        Swal.fire({
            title: '{{ $data->p_name }}',
            text: '{{ $data->cancel_date." :: ".$data->cancel_note }}',
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
                            window.location.href = "{{ route('charge.transaction',base64_encode($data->hospmain)) }}";
                        }, 1500);
                    }
                });
            }
        })
    });
</script>
@endsection
