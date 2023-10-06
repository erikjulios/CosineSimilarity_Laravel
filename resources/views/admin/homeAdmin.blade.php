@extends('templateAdmin')
@section('content')

<div class="data"></div>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="bc-judul" id="bc-judul"></div>
        </div>
        <div class="col-md-6">
            <div class="bc-abstraksi" id="bc-abstraksi"></div>
        </div>
    </div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    Highcharts.chart('bc-judul', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Kemiripan judul skripsi',
            align: 'left'
        },
        // subtitle: {
        //     text:
        //         'Source: <a target="_blank" ' +
        //         'href="https://www.indexmundi.com/agriculture/?commodity=corn">indexmundi</a>',
        //     align: 'left'
        // },
        xAxis: {
            categories: ['0-10%', '11-20%', '21-30%', '31-40%', '41-50%', '51-100%'],
            crosshair: true,
            accessibility: {
                description: 'Countries'
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Persen (%)'
            }
        },
        tooltip: {
            valueSuffix: ' (orang)'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [
            {
                name: 'Mahasiswa',
                data: {!!json_encode($judul)!!}
            }
        ]
    });
</script>
<script>
    Highcharts.chart('bc-abstraksi', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Kemiripan abstraksi skripsi',
            align: 'left'
        },
        // subtitle: {
        //     text:
        //         'Source: <a target="_blank" ' +
        //         'href="https://www.indexmundi.com/agriculture/?commodity=corn">indexmundi</a>',
        //     align: 'left'
        // },
        xAxis: {
            categories: ['0-10%', '11-20%', '21-30%', '31-40%', '41-50%', '51-100%'],
            crosshair: true,
            accessibility: {
                description: 'Countries'
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Persen (%)'
            }
        },
        tooltip: {
            valueSuffix: ' (orang)'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [
            {
                name: 'Mahasiswa',
                // jumlah mahasiswa
                data: {!!json_encode($abstraksi)!!}
            }
        ]
    });
</script>
@endsection

  