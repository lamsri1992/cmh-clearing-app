@extends('layouts.app')
@section('content')
<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <h6 class="text-capitalize">
                    <i class="fa-solid fa-file-invoice"></i>
                    Transaction Code : {{ $id }}
                </h6>
            </div>
            <div class="card-body">
                <table id="listData" class="display nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">VN::</th>
                            <th class="text-center">วันที่รับบริการ</th>
                            <th>หน่วยบริการ</th>
                            <th class="text-center">HN</th>
                            <th class="text-end">ค่าใช้จ่ายจริง</th>
                            <th class="text-end">ยอดที่เรียกเก็บได้</th>
                            <th class="text-end">ค่าใช้จ่าย Refer</th>
                            <th class="text-end">ยอดรวม</th>
                            <th class="text-center">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $res)
                        @php
                            $orgDate = $res->date_rx;  
                            $newDate = date("Y-m-d", strtotime($orgDate));  
                        @endphp
                            <tr>
                                <td class="text-center">{{ $res->vn }}</td>
                                <td class="text-center">{{ $newDate }}</td>
                                <td>{{ $res->h_name }}</td>
                                <td class="text-center">{{ $res->hn }}</td>
                                <td class="text-end text-primary fw-bold">{{ number_format($res->amount,2) }}</td>
                                <td class="text-end text-success fw-bold">{{ number_format($res->paid,2) }}</td>
                                <td class="text-end text-danger fw-bold">{{ number_format($res->paid_am,2) }}</td>
                                <td class="text-end fw-bold" style="text-decoration-line: underline">{{ number_format($res->total,2) }}</td>
                                <td class="text-center text-white {{ $res->p_color }}">{{ $res->p_name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if ($trans->trans_status != 7)
                @if ($trans->trans_status != 8)                    
                @foreach ($check as $item)
                @if ($item->progress >= 1)
                <p>
                    <div class="alert alert-danger" role="alert">
                        ค้างดำเนินการตรวจสอบข้อมูลตามจ่าย :: <b>{{ $item->progress }} รายการ</b>
                    </div>
                </p>
                @else
                <p class="text-center">
                    <button class="btn btn-primary btn-lg"
                        onclick="Swal.fire({
                            icon: 'warning',
                            title: 'ยืนยันการดำเนินการ',
                            text: 'Transaction Code :: '+ {{ $id }},
                            footer: '<small>หากยืนยันแล้ว จะไม่สามารถยกเลิกได้</small>'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'ดำเนินการเสร็จสิ้น',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                                window.setTimeout(function () {
                                    location.replace('/paid/transaction/confirm/'+{{ $id }})
                                }, 3500);
                            } 
                        });">
                        <i class="fa-solid fa-clipboard-check"></i>
                        ดำเนินการตามจ่าย Transaction นี้
                    </button>
                </p>
                @endif
                @endforeach
                @endif
                @endif
                @if ($trans->trans_status == 7)
                    <div class="text-center">
                    <p>
                        <div class="alert alert-success" role="alert">
                            <i class="fa-solid fa-spinner fa-spin"></i>
                            อยู่ระหว่างรอดำเนินการจ่าย
                        </div>
                        <a href="#" id="attach" class="badge bg-warning" 
                            data-id="{{ $id }}"
                            data-bs-toggle="modal" data-bs-target="#attachModal">
                            <i class="fa-solid fa-check-circle"></i>
                            ยืนยัน/แนบเอกสาร
                        </a>
                    </p>
                </div>
                @endif
                @if ($trans->trans_status == 8)
                    <div class="text-center">
                    <p>
                        <div class="alert alert-success" role="alert">
                            <i class="fa-solid fa-check-circle"></i>
                            ดำเนินการเสร็จสิ้น
                        </div>
                    </p>
                    <a href="{{ asset('uploads/'.$paid->file) }}" target="_blank">
                        <i class="fa-regular fa-file-pdf text-danger"></i>
                        File - {{ $paid->file }}
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="attachModal" tabindex="-1" aria-labelledby="attachModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('paid.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="attachModalLabel">
                        <span id="dataId"></span>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="transId" name="transId" hidden>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">แนบเอกสารการจ่ายเงิน</label>
                        <input class="form-control @error('file') is-invalid @enderror"
                        type="file" id="formFile" name="file">
                        @error('file')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">ยอดเงินโอน</label>
                        <input name="balance" class="form-control" type="text" placeholder="ระบุจำนวนเงินเป็นตัวเลขและจุดทศนิยมเท่านั้น">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">วิธีชำระเงิน</label>
                        <select name="balance_type" class="form-select" aria-label="">
                            <option selected>--- กรุณาเลือก ---</option>
                            <option value="1">เงินโอน</option>
                            <option value="2">เช็ค</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">วันที่</label>
                        <input name="paid_date" class="form-control" type="text" placeholder="ระบุวันที่ชำระเงิน">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">หมายเลขอ้างอิง</label>
                        <input name="paid_no" class="form-control" type="text" placeholder="ระบุหมายเลขอ้างอิง">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa-solid fa-save"></i>
                        บันทึกข้อมูล
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/listTableTransactionPaid.js') }}"></script>
<script>
    $('[data-bs-target="#attachModal"').on('click', function () {
        var id = "<i class='fa-regular fa-clipboard'></i> Transaction Code : " + $(this).data('id');
        var trans_id = $(this).data('id');
        document.getElementById('dataId').innerHTML = id;
        document.getElementById('transId').value = trans_id;
    });
</script>
@endsection
