@extends('layouts.app')
@section('content')
<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-capitalize">
                            <i class="fa-regular fa-clock"></i>
                            Transaction : รอดำเนินการตามจ่าย + แนบหลักฐานการจ่าย
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
                            <th class="text-center">Transaction</th>
                            <th class="text-center">วันที่ยืนยันข้อมูล</th>
                            <th class="text-center">โรงพยาบาลเรียกเก็บ</th>
                            <th class="text-center">ยอดตามจ่าย</th>
                            <th class="text-center"><i class="fa-solid fa-bars"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $res)
                            <tr>
                                <td class="text-center">
                                    <a href="{{ route('paid.detail',$res->trans_code) }}">
                                        {{ $res->trans_code }}
                                    </a>
                                </td>
                                <td class="text-center">{{ $res->trans_paiddate }}</td>
                                <td class="text-center">{{ $res->h_name }}</td>
                                <td class="text-center fw-bold">{{ number_format($res->total,2) }}</td>
                                <td class="text-center">
                                    @if ($res->trans_status == 8)
                                        <div class="text-center">
                                        <a href="{{ asset('uploads/'.$res->file) }}" target="_blank">
                                            <i class="fa-regular fa-file-pdf text-danger"></i>
                                            File - {{ $res->file }}
                                        </a>
                                    </div>
                                    @endif
                                    @if ($res->trans_status == 7)
                                    <a href="#" id="attach" class="badge bg-warning" 
                                        data-id="{{ $res->trans_code }}"
                                        data-bs-toggle="modal" data-bs-target="#attachModal">
                                        <i class="fa-solid fa-check-circle"></i>
                                        ยืนยัน/แนบเอกสาร
                                    </a>
                                    @endif
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
                        </tr>
                    </tfoot>
                </table>
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
                        <input type="text" class="form-control datepicker" name="paid_date" placeholder="ระบุวันที่ชำระเงิน" required>
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">หมายเลขอ้างอิง</label>
                        <input name="paid_no" class="form-control" type="text" placeholder="ระบุหมายเลขอ้างอิง">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                    <button type="button" class="btn btn-success btn-sm"
                        onclick="Swal.fire({
                            title: 'ยืนยันการบันทึกข้อมูล',
                            text: 'กรุณาตรวจสอบข้อมูลให้ถูกต้อง ครบถ้วน',
                            showDenyButton: true,
                            confirmButtonText: 'ยืนยัน',
                            denyButtonText: 'ยกเลิก'
                          }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit()
                            }
                          });">
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
<script src="{{ asset('js/listTablePaidList.js') }}"></script>
<script>
    $('[data-bs-target="#attachModal"').on('click', function () {
        var id = "<i class='fa-regular fa-clipboard'></i> Transaction Code : " + $(this).data('id');
        var trans_id = $(this).data('id');
        document.getElementById('dataId').innerHTML = id;
        document.getElementById('transId').value = trans_id;
    });
</script>
@endsection
