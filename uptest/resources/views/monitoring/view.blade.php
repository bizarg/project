@extends('layouts.admin')

@section('content')

    @include('monitoring.header_menu')

    <div class="row tab-container">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Cтатистика</div>
                <div class="panel-body">


                    <p><b>Проверяемый URL:</b> {{ $site->url }}</p>
                    <p><b>Страна мониторинга :</b> {{ $site->node->getNodeName() }}</p>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="domain input">
                                Напраление сравнения
                            </label>
                                    <span class="input-group-btn">
                                          <select id="f_id" class="btn btn-default form-select">
                                              @foreach($nodes as $node)
                                                  <option {{ $site->node->id ==  $node->id ? 'selected' : '' }} value="{{ $node->id }}">{{ $node->getNodeName() }}</option>
                                              @endforeach
                                          </select>

                                        <select id="to_id" class="btn btn-default form-select">
                                              @foreach($nodes as $node)
                                                <option {{ !is_null($siteNode) && $siteNode->id ==  $node->id ? 'selected' : '' }}  value="{{ $node->id }}">{{ $node->getNodeName() }}</option>
                                            @endforeach
                                        </select>

                                    </span>
                        </div>
                    </div>

                    <div>
                        {{--@if($infos->count() > 24 )--}}
                        <canvas id="site" style="height: 250px;"></canvas>
                        <div id="compare" style="height: 250px;"></div>
                        {{--@else--}}
                        {{--<div style="height: 250px;">Не достаточно данных</div>--}}
                        {{----}}

                        {{--@endif--}}
                    </div>


                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">

        colors = {
            red: 'rgb(255, 99, 132)',
            blue: 'rgb(54, 162, 235)',
            black: 'rgb(0, 0, 0)',


        };


        labelsMonitor = [];
        labelsCompare = [];
        pointBackgroundColor = [];

        data = [];


        @foreach($infos as $info)
            @if(empty($info->error) )
                data.push({x: '{{ $info->created_at }}', y:{{ $info->time }} });
        pointBackgroundColor.push(colors.red);
        @else
            data.push({x: '{{ $info->created_at }}', y: 0});
        pointBackgroundColor.push(colors.black);
        @endif

        labelsMonitor.push('{{ $info->created_at }}');
        @endforeach
                labels = labelsMonitor.concat(labelsCompare).sort();


        var config = {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: "time load",
                    backgroundColor: colors.red,
                    borderColor: colors.red,
                    data: data,
                    fill: false,
                    pointBackgroundColor: pointBackgroundColor
                }, {
                    label: "time load compare",
                    fill: false,
                    backgroundColor: colors.blue,
                    borderColor: colors.blue,
                    data: {},
                    //  pointBackgroundColor: [],
                }]
            },
            options: {}
        };

        $(document).ready(function () {

            $('#f_id').change(function () {
                update();
            });
            $('#to_id').change(function () {
                update();
            });

            var ctx = document.getElementById('site').getContext('2d');

            window.lineChart = new Chart(ctx, config);
            update();
        });
        function update() {
            var from_id = $('#f_id').val();
            var to_id = $('#to_id').val();
            $.getJSON("{{ url('monitoring/compare') }}?from_id=" + from_id + "&to_id=" + to_id, function (data) {
                dataCompare = [];
                labelsCompare = [];
                pointСolors = [];
                $.each(data, function (key, val) {
                    //console.log(val)
                    dateTime = val.created_at;
                    dateTime = dateTime.substring(0, dateTime.indexOf('.'));
                    if (val.speed > 0) {
                        dataCompare.push({x: dateTime, y: (1024000 / val.speed)});
                        pointСolors.push(colors.blue);
                    } else {
                        dataCompare.push({x: dateTime, y: 0});
                        pointСolors.push(colors.black);
                    }

                    labelsCompare.push(dateTime);

                });
                config.data.datasets[1].data = dataCompare;
                config.data.labels = labelsMonitor.concat(labelsCompare).sort();
                config.data.pointBackgroundColor = pointСolors;
                window.lineChart.update();
            });
        }

    </script>
@endsection