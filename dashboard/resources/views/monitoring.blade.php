@extends('layouts.main')

@section('content')
    <h3 class="dash_title">Monitoring: {{ $domain }}</h3>
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">{{ $error }}</div>
    @endforeach


    <div id="availablity" style="height: 300px;"></div>


    <script>
        Highcharts.chart('availablity', {
            credits: {
                enabled: false
            },
            chart: {
                type: 'column'
            },
            title: {
                text: 'Time'
            },

            xAxis: {
                title: {
                    text: null
                },
                labels: true,
                categories: [{!! $labels !!}],

            },
            yAxis: {
                min: 0,
                title: {
                    text: null,
                },
                labels: false
            },

            plotOptions: {

                column: {
                    dataLabels: {
                        enabled: false
                    },
                    enableMouseTracking: true,
                    pointPadding: 0,
                    borderWidth: 0,
                    groupPadding: 0,
                    shadow: false
                }
            },
            colors: [ {!! $colors !!}],
            series: [
                {
                    name: 'time',
                    showInLegend: false,
                    legend: false,
                    colorByPoint: true,

                    data: [
                        {!! $availablity  !!}
                    ]
                }
            ]
        });
    </script>

    <div class="row">
        <div class="myTitle">Visitors</div>

        @if(isset($graphicname))
            @if(filesize('graphics/'.$graphicname ) > 2000)
                <div style="height: 300px;">
                    <img width="100%" src="{{ url('graphics/'.$graphicname ) }}">

                </div>
            @else
                <div id="code">
                 @include('layouts.template.piwik_code')
                </div>
            @endif
        @else

            <button id="codebt" onclick="add_pw();">Add to Monitoring</button>
            <div id="code" style="display: none;">
                @include('layouts.template.piwik_code')
            </div>
            <script type="text/javascript">

                function add_pw() {
                    $.get("{{ url('piwik/add', $domain) }}", function (data) {
                        $("#code").show();
                        $("#codebt").hide();

                    });
                }

            </script>


        @endif

    </div>


    <div class="errors">
        <p class="info myTitle">Errors during last month</p>
        <div class="card">
            <div class="card-content">
                <table class="bordered">
                    <thead>
                    <tr>
                        <th data-field="id">Date</th>
                        <th data-field="name">Status</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($statuses as $status)

                        @php

                          /*  {{--try {--}}
                                {{--if($status->value != 200 && $status->value != 302) {--}}

                                    {{--$art = unserialize($status->value);--}}
                                    {{--foreach ($art  as $item) {--}}
                                        {{--if($item['status'] != 200 && $status->value != 302){--}}*/
                        try {
                            if($status->US->responseCode != 200 && $status->US->responseCode != 302) {
                        @endphp
                        <tr>

                            <td>{{ $status->created_at->date }}</td>
                            <td>{{ $status->US->responseCode }}</td>
                        </tr>
                        @php }}
                        catch (ErrorException $ex)
                        {}
                        @endphp

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.4.0/clipboard.min.js"></script>
    <script>
        (function(){
            new Clipboard('.copy-button');
        })();
    </script>
@endsection
