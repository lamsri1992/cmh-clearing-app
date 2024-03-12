@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <h6 class="text-capitalize">
                    <i class="fa-solid fa-cloud-download"></i>
                    รายการประมวลผลข้อมูลจาก API
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <span class="fw-bold">ข้อมูลประมวลผลล่าสุด :: </span>
                        @if ($count <= 0)
                        <i>ไม่พบการประมวลผลข้อมูล</i>
                        @else
                            <i class="fa-regular fa-calendar-check"></i>
                            {{ date("d/m/Y", strtotime($data->date_rx)); }}
                        @endif
                    </div>                    
                    <div class="col-md-6">
                        <span class="fw-bold">จำนวนข้อมูล :: </span>
                        {{ number_format($count)." รายการ" }}
                    </div>
                    <div class="col-md-12" style="margin-top: 1rem;">
                        <span class="fw-bold">เกณฑ์การจ่าย</span>
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th width="30%">ปี</th>
                                    <th width="30%">ประเภท</th>
                                    <th width="30%">ยอดจ่ายจริง (ไม่เกิน)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($op_paid as $res)
                                <tr>
                                    <td>{{ $res->year }}</td>
                                    <td>{{ $res->type }}</td>
                                    <td>{{ number_format($res->paid,2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th width="30%">ปี</th>
                                    <th width="30%">ประเภท</th>
                                    <th width="30%">ยอดเหมาจ่าย</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($op_refer as $res)
                                <tr>
                                    <td>{{ $res->year }}</td>
                                    <td>{{ $res->type }}</td>
                                    <td>{{ number_format($res->paid,2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                          <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-opae" role="tabpanel" aria-labelledby="nav-opae-tab" tabindex="0">
                                <button type="button" class="btn btn-success" style="margin-top: 0.5rem;"
                                    data-bs-toggle="modal" data-bs-target="#opae">
                                    <i class="fa-solid fa-clipboard-check"></i>
                                    Mapping สิทธิ
                                </button>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">รหัสสิทธิจาก HIS</th>
                                            <th>สิทธิการรักษา</th>
                                            <th>สิทธิ Mapping</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($map as $res)
                                        <tr>
                                            <td class="text-center">{{ $res->map_pttype }}</td>
                                            <td>{{ $res->map_ptname }}</td>
                                            <td>{{ $res->map_system_name }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="opae" aria-labelledby="opaeLabel" aria-hidden="true">
    <form action="{{ route('process.map') }}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="opaeLabel">OP_AE (อุบัติเหตุ และฉุกเฉิน) UC นอก CUP ในจังหวัด</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <select class="array-select" name="itemOPAE"></select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                    <button type="button" class="btn btn-success"
                        onclick="Swal.fire({
                            title: 'ยืนยันการ Mapping สิทธิ ?',
                            showDenyButton: true,
                            confirmButtonText: 'บันทึกข้อมูล',
                            denyButtonText: 'ยกเลิก'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                console.log('Confirm Submit')
                                form.submit()
                            }
                        });"
                    >
                        <i class="fa-solid fa-save"></i>
                        บันทึกข้อมูล
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('script')
<script>
    const hcode = {{ Auth::user()->hcode }};
    $('.array-select').select2({
        width: '100%',
        placeholder: "Mapping ข้อมูลสิทธิ",
        ajax: {
            url: 'https://exp.cmhis.org/query/pttype/' + hcode,
            type: 'GET',
            processResults: function (data) {
                var text= []
                for(i = 0; i < data.length; i++){
                    text.push({"id": data[i].pttype + ',' + data[i].name, "text": data[i].name})
                }
                return {
                    results: text,
                };
            } 
        }
    });
</script>
@endsection
