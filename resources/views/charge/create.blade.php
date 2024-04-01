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
                    บันทึกข้อมูลลูกหนี้
                </h6>
            </div>
            <div class="card-body">
                <form action="{{ route('create.add') }}" method="POST">
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
                                <select name="hospmain" class="basic-select2">
                                    <option></option>
                                    @foreach ($hmain as $res)
                                    <option value="{{ $res->h_code }}">
                                        {{ $res->h_code." : ".$res->h_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">หมายเลขบัตรประจำตัวประชาชน</label>
                                <input type="text" name="pid" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">ผู้รับบริการ</label>
                                <input type="text" name="patient" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">HN</label>
                                <input type="text" name="hn" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">VN</label>
                                <input type="text" name="vn" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">วันที่รับบริการ</label>
                                <input type="text" name="vstdate" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">ICD10</label>
                                <input type="text" name="icd10" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">ค่ายา</label>
                                <input type="text" name="drug" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">ค่าแลบ</label>
                                <input type="text" name="lab" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">ค่า X-Ray</label>
                                <input type="text" name="xray" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">ค่าหัตถการ</label>
                                <input type="text" name="proc" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">ค่าบริการอื่น ๆ</label>
                                <input type="text" name="service" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">การใช้รถ Ambulance / Refer</label>
                                <select name="with_ambulance" class="basic-select2">
                                    <option></option>
                                    <option value="Y">ใช่</option>
                                    <option value="N">ไม่ใช่</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 text-end">
                            <button type="button" class="btn btn-success"
                                onclick="Swal.fire({
                                    icon: 'warning',
                                    title: 'ยืนยันการเพิ่มข้อมูลลูกหนี้ ?',
                                    showDenyButton: true,
                                    confirmButtonText: 'เพิ่มข้อมูล',
                                    denyButtonText: 'ยกเลิก'
                                  }).then((result) => {
                                    if (result.isConfirmed) {
                                      form.submit()
                                    }
                                });"
                            >
                                <i class="fa-solid fa-plus-circle"></i>
                                เพิ่มข้อมูลลูกหนี้
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
