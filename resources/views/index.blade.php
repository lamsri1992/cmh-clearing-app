@extends('layouts.app')
@section('content')
@foreach ($count as $res)
@php
    $wait = $res->wait;
    $charge = $res->charge;
    $success = $res->success;
    $deny = $res->deny;
@endphp
<div class="row">
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 font-weight-bold">ยอดเรียกเก็บ</p>
                            <h5 class="font-weight-bolder" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                data-bs-title="ยอดเรียกเก็บจริง">
                                {{ number_format($creditor->total,2) }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-success text-center rounded-circle">
                            <i class="fa-solid fa-file-invoice-dollar text-lg opacity-10" aria-hidden="true"></i>
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
                            <p class="text-sm mb-0 font-weight-bold">ยอดตามจ่าย</p>
                            <h5 class="font-weight-bolder" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                data-bs-title="ยอดตามจ่ายจริง">
                                {{ number_format($dept->total,2) }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-warning text-center rounded-circle">
                            <i class="fa-solid fa-comments-dollar text-lg opacity-10" aria-hidden="true"></i>
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
                            <p class="text-sm mb-0 font-weight-bold">รอตรวจสอบ</p>
                            <h5 class="font-weight-bolder">
                                {{ number_format($wait) }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-info text-center rounded-circle">
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
                            <p class="text-sm mb-0 font-weight-bold">ปฏิเสธจ่าย</p>
                            <h5 class="font-weight-bolder">
                                {{ number_format($deny) }}
                            </h5>
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
@endforeach
<div class="row mt-4">
    <div class="col-lg-6 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <h6 class="text-capitalize">
                    <i class="fa-solid fa-chart-pie"></i>
                    แผนภูมิแสดงรายการตามจ่าย
                </h6>
            </div>
            <div class="card-body">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <h6 class="text-capitalize">
                    <i class="fa-solid fa-chart-pie"></i>
                    แผนภูมิแสดงรายการเรียกเก็บ
                </h6>
            </div>
            <div class="card-body">
                <canvas id="chargeChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function () {
        Chart.defaults.font.family = 'Prompt';
    });

    const labels = [
        @foreach ($paid as $res)
        [ "{{ $res->h_name }}"],
        @endforeach
    ];
  
    const config = {
      type: 'bar',
      data: {
        datasets: [{
            label: 'ยอดตามจ่าย',
            data: [
                @foreach ($paid as $res)
                "{{ $res->paid }}",
                @endforeach
            ],
            backgroundColor: [
                '#2dce89',
            ],
            borderColor: [
                '#2dce89',
            ],
        }],
        labels: labels
    },
      options: {}
    };

    const myChart = new Chart(
        document.getElementById('myChart'),
        config
    );

    // MOO
    const labels2 = [
        @foreach ($price as $res)
        [ "{{ $res->h_name }}"],
        @endforeach
    ];
  
    const config2 = {
      type: 'bar',
      data: {
        datasets: [{
            label: 'ยอดเรียกเก็บ',
            data: [
                @foreach ($price as $res)
                "{{ $res->paid }}",
                @endforeach
            ],
            backgroundColor: [
                '#f6c23ecf',
            ],
            borderColor: [
                '#f6c23ecf',
            ],
        }],
        labels: labels2
    },
      options: {}
    };

    const chargeChart = new Chart(
        document.getElementById('chargeChart'),
        config2
    );
</script>
@endsection
