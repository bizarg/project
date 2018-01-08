@extends('layouts.main')

@section('content')

    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">{{ $error }}</div>
    @endforeach

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            <h4>Success!</h4>
            <p>{{session('success')}}</p>
        </div>
    @elseif (session('fail'))
        <div class="alert alert-danger" role="alert">
            <h4>Error!</h4>
            <p>{{session('fail')}}</p>
        </div>
    @endif

    {{--<div>--}}
        {{--<form action="{{ action('DashboardController@main_search') }}" method="get">--}}
            {{--<input type="text" name="search">--}}
            {{--<input type="submit" value="search">--}}
        {{--</form>--}}
    {{--</div>--}}


    <h1 class="dash_title">Dashboard page</h1>
    <div class="row">
        <form action="{{ action('DashboardController@main') }}" method="get">
            <div class="row">
                <div class="input-field col s6">
                    <i class="material-icons prefix">link</i>
                    <input id="icon_telephone" class="validate" name="search" type="text" placeholder="{{ trans('app.Search') }}">
                    <label for="icon_telephone"></label>
                </div>
                <div class="input-field col s6">
                    <p class="waves-effect waves-light right orangebtn btn">
                        <input type="submit" value="{{ trans('app.Search') }}">
                    </p>
                </div>
            </div>
        </form>
    </div>
    <table class="bordered">
        <thead>
        <tr>
            <th data-field="id">Domain</th>
            <th style="text-align: center;" data-field="name">Availablity</th>
            <th style="text-align: center;" data-field="price">Indexed pages</th>
            <th style="text-align: center;" data-field="name">Alexa rank</th>
            <th data-field="price">Notification</th>
        </tr>
        </thead>
        <tbody id="body">
            @foreach($domains as $domain)
                <tr class="query" id="{{$domain->id}}">
                    <td>
                        @if($domain->confirm != 'not_confirm' )
                            <a class="domain_title tooltipped" data-position="top" data-delay="50"
                               data-tooltip="{{ $domain->domain }}"
                               href="{{ url('info', $domain->domain) }}">
                                {{ $domain->domain}}
                            </a>
                        @else
                            <a class="domain_title tooltipped" data-position="top" data-delay="50"
                               data-tooltip="{{ $domain->domain }}"
                               href="#">
                                {{ $domain->domain}}
                            </a>
                        @endif
                    </td>
                    <td>
                        <div class="icon_wr">


                                @if($domain->confirm != 'not_confirm' && $domain->availablity)
                                <a class="tooltipped"
                                   data-position="top"
                                   data-delay="50"
                                   data-tooltip="Monitoring"
                                   href="{{ url('info', $domain->domain) }}">

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
                                </a>
                                @else
                                    <i class="material-icons lnk">insert_chart</i>
                                @endif

                        </div>
                    </td>
                    <td>
                        <div class="icon_wr" id="div_index_pages{{$domain->id}}">

                                <div id="y_index{{$domain->id}}">

                                        <div class="windows8 y_error">
                                            <div class="wBall" id="wBall_1">
                                                <div class="wInnerBall"></div>
                                            </div>
                                            <div class="wBall" id="wBall_2">
                                                <div class="wInnerBall"></div>
                                            </div>
                                            <div class="wBall" id="wBall_3">
                                                <div class="wInnerBall"></div>
                                            </div>
                                            <div class="wBall" id="wBall_4">
                                                <div class="wInnerBall"></div>
                                            </div>
                                            <div class="wBall" id="wBall_5">
                                                <div class="wInnerBall"></div>
                                            </div>
                                        </div>

                                </div><br>
                                <div id="g_index{{$domain->id}}">

                                        <div class="windows8 g_error">
                                            <div class="wBall" id="wBall_1">
                                                <div class="wInnerBall"></div>
                                            </div>
                                            <div class="wBall" id="wBall_2">
                                                <div class="wInnerBall"></div>
                                            </div>
                                            <div class="wBall" id="wBall_3">
                                                <div class="wInnerBall"></div>
                                            </div>
                                            <div class="wBall" id="wBall_4">
                                                <div class="wInnerBall"></div>
                                            </div>
                                            <div class="wBall" id="wBall_5">
                                                <div class="wInnerBall"></div>
                                            </div>
                                        </div>
                                </div>
                            </a>
                        </div>
                    </td>
                    <td>
                        <div class="icon_wr" id="div_alexa_rank{{$domain->id}}">
                                <div id="alexa{{ $domain->id }}">
                                    <div class="windows8 a_error">
                                        <div class="wBall" id="wBall_1">
                                            <div class="wInnerBall"></div>
                                        </div>
                                        <div class="wBall" id="wBall_2">
                                            <div class="wInnerBall"></div>
                                        </div>
                                        <div class="wBall" id="wBall_3">
                                            <div class="wInnerBall"></div>
                                        </div>
                                        <div class="wBall" id="wBall_4">
                                            <div class="wInnerBall"></div>
                                        </div>
                                        <div class="wBall" id="wBall_5">
                                            <div class="wInnerBall"></div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </td>
                    <td id="notify{{$domain->id}}"> <!-- Dropdown Trigger -->
                        {{--@if($domain->confirm != 'not_confirm' && isset($domain->notify))--}}

                            {{--<a class='dropdown-button btn {{ count($domain->notify) == 0 ? 'green' : 'red' }}' href='#'--}}
                               {{--data-activates='dropdown{{ $domain->id }}'>{{ count($domain->notify) }}</a>  --}}
                            {{--<a class='dropdown-button btn green' href='#'--}}
                               {{--data-activates='dropdown{{ $domain->id }}'></a>--}}
                        <a class='dropdown-button btn green'
                           href='{{ url('confirm/info',[$domain->domain, $domain->id]) }}'
                                   data-activates='dropdown{{ $domain->id }}'>Confirm</a>

                                    {{--<!-- Dropdown Structure -->--}}
                            <ul style="min-width: 160px" id='dropdown{{ $domain->id }}' class='dropdown-content'>
                                    {{--@foreach($domain->notify as $notify)--}}
                                        {{--<li><a href="#!">{{ $notify }}</a></li>--}}
                                    {{--@endforeach--}}
                                {{--<li class="divider"></li>--}}
                                {{--<li><a href="#!">three</a></li>--}}
                                {{--<li><a href="#!">two</a></li>--}}
                            </ul>
                        {{--@else--}}
                            {{--<a class='dropdown-button btn green'--}}
                               {{--href='{{ url('confirm/info',[$domain->domain, $domain->id]) }}'>Confirm</a>--}}
                        {{--@endif--}}
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

    <div>
        @if(count($domains))
            {{ $domains->links() }}
        @endif
    </div>

@endsection

@section('js')
<script>

    $(document).ready(function(){
        var tr = $('tr.query');

        var arrId = [];
        for(var i = 0; i < tr.length; i++){
            arrId.push(tr[i].getAttribute('id'));
        }

        function getIndex(url, id){
            return new Promise(function(resolve,reject){
                $.ajax({
                    type: 'post',
                    url: url,
                    data: "id=" + id,
                    success: function(json){
                        resolve(json)
                    },
                    error: function () {
                        reject(id)
                    }
                });
            });
        }

        function getDomains(url, id){
            return new Promise(function(resolve,reject){
                $.ajax({
                    type: 'post',
                    url: url,
                    data: "id=" + id,
                    success: function(json){
                        resolve(json)
                    },
                    error: function () {
                        reject(id)
                    }
                });
            });
        }

        getDomains('/domains/get_domains', JSON.stringify(arrId)).then(
            function(domains){

                for(var i = 0; i < domains.length; i++){

                    getIndex('/domains/index', JSON.stringify(domains[i])).then(
                        function (json) {
                                if(json.confirm == 'not_confirm' || json == null){
                                $('#div_alexa_rank'+json.id).html('<i class="material-icons lnk">trending_up</i>');
                                $('#div_index_pages'+json.id).html('<i class="material-icons lnk">sort</i>');
                                $('#div_index_pages'+json.id).html('<i class="material-icons lnk">sort</i>');
                                } else {
//                                    console.log(json);

                                var alexa = "N/A";
                                if (json.alexa && !json.alexa.error) {
                                    alexa = json.alexa.global_rank;
                                }

                                $('#alexa' + json.id).html('<a class="tooltipped" data-position="top"\
                                    data-delay="50" data-tooltip="Seo" href="seo/' + json.domain + '">\
                                    <img style="margin-bottom: -2px;"\
                                    src="http://try.alexa.com/wp-content/uploads/2017/01/favicon-16x16-5.png"\
                                    height="16" width="16">' + alexa + '<br></a>');

                                var google = "N/A";

                                if (json.google_index && !json.google_index.error) {
                                    google = json.google_index.index;
                                }

                                $('#g_index' + json.id).html('<a class="tooltipped" data-position="top"\
                                    data-delay="50" data-tooltip="Seo" href="seo/' + json.domain + '">\
                                    <img style="margin-bottom: -2px;"\
                                    src="https://www.google.ru/images/branding/product/ico/googleg_lodp.ico"\
                                    height="16" width="16">' + google + '<br></a>');

                                var yandex = "N/A";
                                if (json.yandex_index && !json.yandex_index.error) {
                                    yandex = json.yandex_index.index;
                                }

                                $('#y_index'+json.id).html('<a class="tooltipped" data-position="top"\
                                    data-delay="50" data-tooltip="Seo" href="seo/' + json.domain + '">\
                                    <img src="https://yastatic.net/morda-logo/i/ya_favicon_ru.png" height="16"\
                                    width="16">' + yandex + '</br>');

                                if(json.notify != null && json.notify.length) {

                                    var messages = '';

                                    for(i = 0; i < json.notify.length; i++) {
                                        messages += '<li><a href="#!">' + json.notify[i] + '</a></li>';
                                    }

                                    $('#notify'+json.id+' a.dropdown-button').addClass('red').removeClass('green').text(json.notify.length).attr('href', '#');

                                    $('#notify'+json.id+' > ul').html(messages);
                                } else {
                                    $('#notify'+json.id+' a.dropdown-button').addClass('green').text(0);
                                }
                            }
                        }
                    )
                }
            }
        );// getDomains
    }); //ready
</script>
@endsection