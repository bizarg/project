@extends('layouts.main')

@section('content')
    <h3 class="dash_title">Seo</h3>
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">{{ $error }}</div>
    @endforeach
    <div class="seo">
        @if(count($gi))
        <div class="myTitle">Google Index</div>
        <div id="gi" style="height: 300px;"></div>
        <script>
            Highcharts.chart('gi', {
                credits: {
                    enabled: false
                },
                chart: {
                    type: 'column'
                },
                title: {
                    text: false
                },

                xAxis: {
//                    title: {
//                        text: null
//                    },
//                    labels: true,
                    categories: [{!! $gi['labels'] !!}],


                },
//                yAxis: {
//                    min: 0,
//                    title: {
//                        text: '',
//                    },
//                    labels: true
//                },

                plotOptions: {

                    column: {
                        dataLabels: {
                            enabled: false
                        },
                        enableMouseTracking: true,
                        //pointPadding: 0,
                        //borderWidth: 0,
                        //groupPadding: 0,
                        shadow: true
                    }
                },
                series: [
                    {
                        name: 'index',
                        showInLegend: false,
                        legend: false,
                        colorByPoint: false,

                        data: [
                            {!! $gi['indexes'] !!}
                        ]
                    }
                ]
            });
        </script>
        @endif
        @if(count($yi))
        <div class="myTitle">Yandex Index</div>
        <div id="yi" style="height: 300px;"></div>
        <script>
            Highcharts.chart('yi', {
                credits: {
                    enabled: false
                },
                chart: {
                    type: 'column'
                },
                title: {
                    text: false
                },

                xAxis: {
//                    title: {
//                        text: null
//                    },
//                    labels: true,
                    categories: [{!! $yi['labels'] !!}],


                },

                plotOptions: {

                    column: {
                        dataLabels: {
                            enabled: false
                        },
                        enableMouseTracking: true,
                        shadow: true
                    }
                },
                series: [
                    {
                        name: 'index',
                        showInLegend: false,
                        legend: false,
                        colorByPoint: false,
                        data: [
                            {!! $yi['indexes'] !!}
                        ]
                    }
                ]
            });
        </script>
        @endif

        @if(count($params))
        <div class="row">
            <div class="myTitle">Alexa Rank</div>

            <div class="col s12 m6">
                <div class="rank">
                    <div class="card">
                        <div class="card-content">
                            <table>
                                <thead>
                                <tr>
                                    <th data-field="id">Keyword</th>
                                    <th data-field="name">Percent of Search Traffic</th>
                                    {{--<th data-field="price">Rank in country</th>--}}
                                </tr>
                                </thead>

                                <tbody id="alexa_traffic">
                                    @foreach($params->alexa_traffic as $k => $v)
                                        <tr>
                                            <td>{{ $k }}</td>
                                            <td>{{ $v }}%</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="rank">
                    <div class="card">
                        <div class="card-content">
                            <li>Global rank:<span class="global" id="global"> {{ number_format(($params->global_rank)? $params->global_rank : ' 0') }}</span></li>
                            <li>Rank in country:<span class="global" id="country"> {{ number_format(($params->country_rank) ? $params->country_rank : ' 0') }}</span></li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
@endsection
