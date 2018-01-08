@extends('layouts.app')

@section('content')
    <h3 class="dash_title">Monitoring: {{ $domain }}</h3>
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">{{ $error }}</div>
    @endforeach
    <div class="container">
        <div class="row">
            <div class="col-md-12">

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
            <div style="height: 300px;">
                <img src="{{ url('graphics/'.$graphicname ) }}">

            </div>
        @else

            <button id="codebt" onclick="add_pw();">Add to Monitoring</button>
            <div id="code" style="height: 300px; display: none;">
                JavaScript Tracking-код
                <br>

                Удостоверьтесь, что этот код находится на каждой странице вашего вебсайта. Мы рекомендуем вставлять его сразу перед закрытием тега &lt;/head&gt;.
                <br>
                <code>
                    &lt;script type="text/javascript"&gt;
                    document.write('
                    var _paq = _paq || [];
                    /* tracker methods like "setCustomDimension" should be called before "trackPageView"*/
                    _paq.push(['trackPageView']);
                    _paq.push(['enableLinkTracking']);
                    (function () {
                    var u = "//piwik.staff.pub-dns.org/";
                    _paq.push(['setTrackerUrl', u + 'piwik.php']);
                    _paq.push(['setSiteId', '{{ $domain }}']);
                    var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
                    g.type = 'text/javascript';
                    g.async = true;
                    g.defer = true;
                    g.src = u + 'piwik.js';
                    s.parentNode.insertBefore(g, s);
                    })();
                    ');
                    &lt;/script&gt;
                </code>
            </div>
            <script type="text/javascript">
                function add_pw() {
                    $.get("{{ url('piwik/add', $domain) }}", function (data) {
                        $("#code").show();
                        $("#codebt").hide();

                    });
                }
                ;
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

                        try {
                        if($status->value != 200 && $status->value != 302) {

                        $art = unserialize($status->value);
                        foreach ($art  as $item) {
                        if($item['status'] != 200 && $status->value != 302){
                        @endphp
                        <tr>

                            <td>{{ $status->date }}</td>
                            <td>
                                {{ $item['status'] }}
                            </td>
                        </tr>
                        @php

                        }
                        }
                        }
                        } catch (ErrorException $ex){}
                        @endphp

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>

@endsection