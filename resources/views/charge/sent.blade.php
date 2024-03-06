@extends('layouts.app')
@section('content')
<div class="row mt-4">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <h6 class="text-capitalize">
                    <i class="fa-solid fa-file-invoice"></i>
                    รายการเรียกเก็บแยกตามโรงพยาบาล
                </h6>
            </div>
            <div class="card-body">
                <ol class="list-group">
                    @php $total = 0 @endphp
                    @foreach ($data as $res)
                    @php $total += $res->total @endphp
                    <a href="#" id="transClick" name="transClick" class="transClick" 
                        data-hcode="{{ Auth::user()->hcode }}" data-hospmain="{{ $res->h_code }}">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">
                                    {{ $res->h_name }}
                                </div>
                                <i class="fa-solid fa-check-circle text-success"></i>
                                ยอดเรียกเก็บ OP_AE (UC นอกเขต อุบัติเหตุ และฉุกเฉิน)<br>
                                {{ number_format($res->total,2) }} บาท 
                            </div>
                            <span class="badge bg-success rounded-pill" style="width: 15%;">
                                {{ number_format($res->number) }} รายการ
                            </span>
                        </li>
                    </a>
                    @endforeach
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">
                                รวมยอดเรียกเก็บ
                            </div>
                            ทั้งหมด {{ number_format($total,2) }} บาท
                        </div>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="show" tabindex="-1" aria-labelledby="showLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="showLabel">ข้อมูลรายการเรียกเก็บ</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="transDetail" class="table table-borderless table-striped table-sm" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">Transaction Code</th>
                            <th class="text-center">เรียกเก็บไปยัง</th>
                            <th class="text-center">วันที่เรียกเก็บ</th>
                            <th class="text-center">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $('.transClick').click(function () {
        var hcode = $(this).attr("data-hcode");
        var hospmain = $(this).attr("data-hospmain");
        var id = hcode + "," + hospmain;

        $('#show').modal('show');
        $.ajax({
            url: "/api/sent/" + id,
            success: function (data) {
                // console.log(data)
                $('tbody').html("");
                for (var i = 0; i < data.length; i++) {
                    var row =
                    $(
                        '<tr>' + 
                            '<td class="text-center">' + 
                                '<a href="/charge/sent/'+ data[i].trans_code +'">' 
                                    + data[i].trans_code + 
                                '</a>' +
                            '</td>' +
                            '<td class="text-center">' + data[i].h_name + '</td>' +
                            '<td class="text-center">' + data[i].create_date + '</td>' +
                            '<td class="text-center">' + data[i].p_name + '</td>' +
                        '</tr>'
                    );
                    $('#transDetail').append(row);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่สามารถเชื่อมต่อ API ได้',
                    text: 'Error: ' + textStatus + ' - ' + errorThrown,
                })
            }
        });
    });
</script>
@endsection
