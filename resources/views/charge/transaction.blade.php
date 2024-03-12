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
                <table id="listData" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">วันที่รับบริการ</th>
                            <th class="text-center">VN</th>
                            <th>หน่วยบริการ</th>
                            <th class="text-center">HN</th>
                            <th class="text-end">ยอดลูกหนี้</th>
                            <th class="text-end">ยอดเรียกเก็บ</th>
                            <th class="text-end">Ambulance</th>
                            <th class="text-end">ยอดรวม</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-center" hidden>HCODE</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $res)
                        @php $total = $res->paid + $res->ambulance; @endphp
                            <tr>
                                <td class="text-center">{{ date("d/m/Y", strtotime($res->visit_date)) }}</td>
                                <td class="text-center">{{ $res->vn }}</td>
                                <td>{{ $res->h_name }}</td>
                                <td class="text-center">{{ $res->hn }}</td>
                                <td class="text-end text-primary fw-bold">{{ number_format($res->amount,2) }}</td>
                                <td class="text-end text-success fw-bold">{{ number_format($res->paid,2) }}</td>
                                <td class="text-end text-danger fw-bold">{{ number_format($res->ambulance,2) }}</td>
                                <td class="text-end fw-bold" style="text-decoration-line: underline">{{ number_format($total,2) }}</td>
                                <td class="text-center text-white {{ $res->p_color }}">{{ $res->p_name }}</td>
                                <td class="text-center" hidden>{{ $res->hospmain }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <p>
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
<script src="{{ asset('js/listTableCharge.js') }}"></script>
<script>
    $(document).ready(function() {
        Swal.fire({
            icon: 'warning',
            title: 'กรุณาดำเนินการสร้างใบเรียกเก็บ',
            text: 'ข้อมูลจะถูกประมวลผลอัตโนมัติทุกวันที่ 5 ของเดือน',
        })
    });

    $('#btnCreate_all').click(function () {
    var count = 'จำนวน ' + table.rows().data().length + ' : รายการ';

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    var array = [];
    table.rows().every(function(rowIdx) {
        array.push(table.row(rowIdx).data())
    })
    var formData = array;

    Swal.fire({
        title: 'ยืนยันสร้างการ Transaction ?',
        text: count,
        showCancelButton: true,
        confirmButtonText: `สร้างรายการ Transaction`,
        cancelButtonText: `ยกเลิก`,
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('btnCreate_all').disabled = true;
            $.ajax({
                url:"/charge/bill",
                method:'POST',
                data:{formData: formData},
                success:function(data){
                    let timerInterval
                        Swal.fire({
                        title: 'กำลังสร้าง Transaction',
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                            timerInterval = setInterval(() => {
                            const content = Swal.getContent()
                            if (content) {
                                const b = content.querySelector('b')
                                if (b) {
                                b.textContent = Swal.getTimerLeft()
                                }
                            }
                            }, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                        }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                                Swal.fire({
                                icon: 'success',
                                title: 'สร้างรายการสำเร็จ',
                                showConfirmButton: false,
                                timer: 3000
                            })
                            window.setTimeout(function () {
                                location.replace('/charge/sent')
                            }, 3500);
                        }
                    })
                }
            });
        }
    })
});

</script>
@endsection
