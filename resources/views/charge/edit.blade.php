@extends('layouts.app')
@section('content')
<style>
    .select2-selection__rendered {
        line-height: 38px !important;
    }
    .select2-container .select2-selection--single {
        height: 40px !important;
    }
    .select2-selection__arrow {
        height: 39px !important;
    }
</style>
<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <h6 class="text-capitalize">
                    <i class="fa-solid fa-edit"></i>
                    แก้ไขข้อมูลลูกหนี้
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('charge.update',$data->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="" class="form-label">รหัสหน่วยบริการเรียกเก็บ</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->hcode }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="" class="form-label">เรียกเก็บไปยัง</label>
                                <input type="text" class="form-control" value="{{ $data->h_name }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">หมายเลขบัตรประจำตัวประชาชน</label>
                                <input type="text" name="pid" class="form-control" value="{{ $data->pid }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">ผู้รับบริการ</label>
                                <input type="text" name="patient" class="form-control" value="{{ $data->patient }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">HN</label>
                                <input type="text" name="hn" class="form-control" value="{{ $data->hn }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">VN</label>
                                <input type="text" name="vn" class="form-control" value="{{ $data->vn }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">วันที่รับบริการ</label>
                                <input type="text" name="vstdate" class="form-control datepicker" value="{{ $data->visit_date }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">ICD10</label>
                                <input type="text" name="icd10" class="form-control" value="{{ $data->icd10 }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">ค่ายา</label>
                                <input type="text" name="drug" class="form-control" value="{{ $data->drug }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">ค่าแลบ</label>
                                <input type="text" name="lab" class="form-control" value="{{ $data->lab }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">ค่า X-Ray</label>
                                <input type="text" name="xray" class="form-control" value="{{ $data->xray }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">ค่าหัตถการ</label>
                                <input type="text" name="proc" class="form-control" value="{{ $data->proc }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">ค่าบริการอื่น ๆ</label>
                                <input type="text" name="service" class="form-control" value="{{ $data->service_charge }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">การใช้รถ Ambulance / Refer</label>
                                <select name="with_ambulance" class="basic-select2">
                                    <option></option>
                                    <option value="Y"
                                    {{ ($data->with_ambulance == 'Y') ? 'SELECTED' : '' }}>
                                    ใช่
                                    </option>
                                    <option value="N"
                                    {{ ($data->with_ambulance == NULL) ? 'SELECTED' : '' }}>
                                    ไม่ใช่
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 text-end">
                            <button type="button" class="btn btn-warning"
                                onclick="Swal.fire({
                                    icon: 'warning',
                                    title: 'ยืนยันการแก้ไขข้อมูลลูกหนี้ ?',
                                    showDenyButton: true,
                                    confirmButtonText: 'แก้ไขข้อมูล',
                                    denyButtonText: 'ยกเลิก'
                                  }).then((result) => {
                                    if (result.isConfirmed) {
                                      form.submit()
                                    }
                                });"
                            >
                                <i class="fa-solid fa-edit"></i>
                                แก้ไขข้อมูลลูกหนี้
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('.basic-select2').select2({
            width: '100%',
            placeholder: 'กรุณาเลือก'
        });
    });
</script>
@endsection
