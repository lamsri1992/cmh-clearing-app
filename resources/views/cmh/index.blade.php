@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <h6 class="text-capitalize">งานประกันสุขภาพ สาธารณสุขจังหวัดเชียงใหม่</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 mb-lg-0 mb-4">
                        <div class="card z-index-2 h-100">
                            <div class="card-header pb-0 pt-3 bg-transparent">
                                <h6 class="text-capitalize">
                                    <i class="fa-solid fa-chart-pie"></i>
                                    แผนภูมิแสดงข้อมูลหนี้รายโรงพยาบาล
                                </h6>
                            </div>
                            <div class="card-body">
                                <canvas id="indexChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
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
        @foreach ($data as $res)
        [ "{{ $res->h_name }}"],
        @endforeach
    ];

    const config = {
      type: 'bar',
      data: {
        datasets: [
            {
                label: 'ยอดลูกหนี้',
                data: [
                    @foreach ($data as $res)
                    "{{ $res->debtor }}",
                    @endforeach
                ],
                backgroundColor: ['#2dce89'],
                borderColor: ['#2dce89'],
            },
            {
                label: 'ยอดเจ้าหนี้',
                data: [
                    @foreach ($data as $res)
                    "{{ $res->creditor }}",
                    @endforeach
                ],
                backgroundColor: ['#f5365c'],
                borderColor: ['#f5365c'],
            }
        ],
        labels: labels
        }
    };
    const indexChart = new Chart(
        document.getElementById('indexChart'),
        config
    );
</script>
@endsection
