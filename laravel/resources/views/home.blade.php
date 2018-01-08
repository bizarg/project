@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                @include('errors._sessionBlock')

                @if ($errors->has('url'))
                    <div class="alert alert-danger">
                        <strong>{{ $errors->first('url') }}</strong>
                    </div>
                @endif

                <div>Balance: {{ $user->balance }} UAH</div>
                <div>Пополнить баланс</div>
                <form action="{{ action('Admin\OrderController@createOrder') }}" method="post">
                    {{ csrf_field() }}
                    <input type="text" name="value">
                    <input type="submit">
                </form>
                </br>

                @if(isset($domains))
                <table class="bordered">
                    <thead>
                        <tr>
                        <th data-field="id">Domain</th>
                        <th style="text-align: center;" data-field="name">Availablity</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($domains as $domain)
                    @if($domain->domain_status )
                    <tr>
                    <td>
                    <a class="domain_title tooltipped" data-position="top" data-delay="50"
                    data-tooltip="{{ $domain->domain }}"
                    href="{{ url('info', $domain->domain) }}">
                    {{ $domain->domain }}
                    </a>
                    </td>
                    <td>
                    <div class="icon_wr">
                    <a class="tooltipped"
                    data-position="top"
                    data-delay="50"
                    data-tooltip="Monitoring"
                    href="{{ url('info', $domain->domain) }}">
                    <i class="material-icons lnk">insert_chart</i>

                    @if(!isset($domain->availablity->error))

                    <div id="availablity{{ $domain->id }}" style="height: 150px; width: 310px;"></div>
                    <script>
                    Highcharts.chart('availablity{{ $domain->id }}', {
                    credits: {
                    enabled: false
                    },
                    chart: {
                    type: 'column'
                    },
                    title: {
                    text: null
                    },

                    xAxis: {
                    title: {
                    text: null
                    },
                    labels: false
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
                    enableMouseTracking: false,
                    pointPadding: 0,
                    borderWidth: 0,
                    groupPadding: 0,
                    shadow: false
                    }
                    },
                    colors: [ {!! $domain->colors !!}],
                    series: [
                    {
                    name: null,
                    showInLegend: false,
                    legend: false,
                    colorByPoint: true,

                    data: [
                    {!! $domain->availablity  !!}
                    ]
                    }
                    ]
                    });
                    </script>

                    <p>Page load time (last 24 hrs)</p>
                    @else
                    <i class="material-icons lnk">insert_chart</i>
                    @endif
                    </a>
                    </div>
                    </td>
                    </tr>
                    @else

                    <tr>
                    <td><a class="domain_title" href="#">{{ $domain->domain }}</a></td>
                    <td>
                    <div class="icon_wr"><i class="material-icons lnk">equalizer</i></div>
                    </td>
                    </tr>
                    @endif

                    @endforeach
                    @endif
                    </tbody>
                </table>
                <a href="#!" class="btn btn-primary"><span aria-hidden="true"  data-toggle="modal" data-target="#modal">New Domain</span></a>
                <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="margin-top: 200px" id="modal">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <h4 class="modal-title" id="mySmallModalLabel">New Domain</h4> </div>
                            <div class="modal-body">
                                <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/add_domain') }}">
                                    {{csrf_field()}}

                                    <div class="form-group">
                                        <label for="url" class="col-md-2 control-label">URL</label>

                                        <div class="col-md-10">
                                            <input id="url" type="text" class="form-control" name="url" placeholder="http://websitter.org/" autofocus>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="tariff" class="col-md-2 control-label">Tariff</label>
                                        <div class="col-md-8">
                                            <select id="tariff" class="form-control" name="tariff">

                                                @foreach($tariffs as $tariff)
                                                    <option value="{{ $tariff->id }}">{{ $tariff->name }} {{ $tariff->value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary">
                                                Send
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
