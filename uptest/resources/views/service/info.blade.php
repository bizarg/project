@extends('layouts.admin')

@section('content')

    @include('layouts._layout.header_menu')

    <div class="row tab-container">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Cтатистика</div>
                <div class="panel-body">
                    {{--<a class="btn btn-primary pull-right" href="/downloads/{{ $task->id}}">
                        Полная статистика в zip архиве
                    </a>--}}
                    @if($task->status == 'new')
                        <a class="btn btn-primary pull-right" href="{{ url("/task/start/".$task->id) }}">
                            Запустить
                        </a>
                    @endif
                    <br>
                    <br>

                    <p><b>Тестируемый URL:</b> {{ $task->main_url }}</p>

                    <p><b>Статус :</b> {{ $task->status }}</p>
                    @if($task->type == 'static')
                        <div>
                            <p><b>Интенсивность:</b> {{ $task->intensity }}</p>

                            {{--<p><b>Количество запросов:</b> @{{SC.data.codecount}}</p>--}}
                        </div>
                    @else
                        <div>
                            <p><b>Стартовая интенсивность:</b> {{ $task->intensity }}</p>

                            <p><b>Прирост интенсивности:</b> {{ $task->intensity_step }} </p>


                            {{--                        <p><b>Максимальная интенсивность:</b> @{{SC.data.options.maxintensity}}</p>

                                                    <p><b>Количество сделанных запросов в последнем проходе:</b> @{{SC.data.codecount}}</p>--}}
                        </div>
                    @endif
                    <div>
                        <div id="codes" style="height: 250px; width: 500px;"></div>

                        <div id="avtime" style="height: 250px; width: 500px;"></div>
                        <div id="avspeed" style="height: 250px; width: 500px;"></div>

                    </div>


                    <table class="table table-hover" id="report">
                        <thead>
                        <tr>
                            {{--`task_id`, `users_send`, `users_request`, `all_request`, `work_time`, `codes_requests`--}}
                            <th>#</th>
                            {{--<th>Пользователей сгенерировано</th>--}}
                            <th>Страниц загружено</th>
                            <th>Запросов отвечено</th>
                            <th>Среднее время загрузки страницы</th>
                            <th>Download speed</th>
                            {{--<th>upload_time</th>--}}
                            <th>download_time</th>
                            <th>traff_download</th>
                            {{--<th>traff_upload</th>--}}
                            <th>traff_download/download_time</th>
                            {{--<th>traff_upload/upload_time</th>--}}

                            {{--<th>Upload speed</th>--}}
                            <th>Коды ответов</th>
                        </thead>
                        <tbody>
                        {{--@foreach($reports as $report)

                        <tr>
                        <td>{{ $report->id }}</td>
                        <td>{{ $report->users_send }}</td>
                        <td>{{ $report->users_request }}</td>
                        <td>{{ $report->all_request }}</td>
                        <td>{{ $report->work_time }}</td>
                        <td>
                        {{ $report->codes_requests }}
                        <table class="table table-hover">
                        <th>Ответ</th>
                        <th>Количество</th>
                        @foreach($report->codes_requests as $cod_req => $count_req)
                        <tr>
                        <td>{{ $cod_req }}</td>
                        <td>{{ $count_req }}</td>
                        </tr>
                        @endforeach
                        </table>
                        </td>
                        </tr>
                        @endforeach--}}
                        </tbody>
                    </table>
                    {{--
                                        <select style="display: none;" id="hiddenResponceCode">
                                            <option ng-repeat="dom in SC.codeNames" value="@{{dom.id}}"> @{{dom.description}}</option>
                                        </select>--}}

                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">

        var timegraf = false;
        var speedgraf = false;
        var codesgraf = false;


        $(document).ready(function () {
            @if($task->status == 'inprogress')
                setTimeout(updatereport, 2000);
            @else
                updatereport();
            @endif

        });

        function initOrUpdate(timeGrafData, speedGrafData, codeGrafData) {
            if (timegraf === false) {
                timegraf = new Morris.Line({
                    // ID of the element in which to draw the chart.
                    element: 'avtime',
                    // Chart data records -- each entry in this array corresponds to a point on
                    // the chart.
                    data: timeGrafData,
                    // The name of the data record attribute that contains x-values.
                    xkey: 'num',
                    // A list of names of data record attributes that contain y-values.
                    ykeys: ['time'],
                    // Labels for the ykeys -- will be displayed when you hover over the
                    // chart.
                    labels: ['work time'],
                    parseTime: false,
                });
            } else {
                timegraf.setData(timeGrafData);
            }

            if (speedgraf === false) {

                speedgraf = new Morris.Line({
                    // ID of the element in which to draw the chart.
                    element: 'avspeed',
                    // Chart data records -- each entry in this array corresponds to a point on
                    // the chart.
                    data: speedGrafData,
                    // The name of the data record attribute that contains x-values.
                    xkey: 'num',
                    // A list of names of data record attributes that contain y-values.
                    ykeys: ['speed'],
                    // Labels for the ykeys -- will be displayed when you hover over the
                    // chart.
                    labels: ['speed'],
                    parseTime: false,
                });
            } else {
                speedgraf.setData(speedGrafData);
            }

            if (codesgraf === false) {


            } else {
                $('#codes').html('');
                codesgraf = null;
            }

            codesgraf = new Morris.Line({
                // ID of the element in which to draw the chart.
                element: 'codes',
                // Chart data records -- each entry in this array corresponds to a point on
                // the chart.
                data: codeGrafData.data,
                // The name of the data record attribute that contains x-values.
                xkey: 'num',
                // A list of names of data record attributes that contain y-values.
                ykeys: codeGrafData.labels,
                // Labels for the ykeys -- will be displayed when you hover over the chart.
                labels: codeGrafData.labels,
                parseTime: false,
            });
            //console.log(codeGrafData.labels);
            //console.log(codeGrafData.data);

            codesgraf.labels = codeGrafData.labels;
            codesgraf.ykeys = codeGrafData.labels;
            codesgraf.setData(codeGrafData.data);

        }


        function updatereport() {

            $.ajax({
                {{--url: "{{ url('/task/get/log/'.$task->id) }}{{ $task->status == 'inprogress' ? '?update=1' : "" }}",--}}
                url: "{{ url('/task/log/json/'.$task->id) }}{{ $task->status == 'inprogress' ? '?update=1' : "" }}",


            }).done(function (data) {

                if (data.toString() != 'stop') {
                    var reports = jQuery.parseJSON(data);
                    var table = $('#report tbody');
                    table.html('');


                    var timeGraf = [];
                    var speedGraf = [];
                    var codeData = {labels: [], data: []};
                    num = 0;


                    var obj = {};
                    $.each(reports, function (index, rep) {
                        codes_requests = jQuery.parseJSON(rep.codes_requests);
                        $.each(codes_requests, function (code, count) {
                            obj[code] = 0;
                        });
                    });

                    $.each(reports, function (index, rep) {
                        codes_requests = jQuery.parseJSON(rep.codes_requests);

                        var sumreq = 0;
                        $.each(codes_requests, function (code, count) {
                            sumreq += count;
                        });
                        var newObj = {};

                        for (var key in obj) {
                            newObj[key] = obj[key];
                        }
                        $.each(codes_requests, function (code, count) {
                            //obj = {};
                            newObj[code] = ((count / sumreq) * 100).toFixed(3);
                            newObj.num = num;
                            codeData.data.push(newObj);
                            if ($.inArray(code, codeData.labels) === -1) {
                                codeData.labels.push(code);
                            }
                        });


                        speedGraf.push({
                            num: num,
                            speed:    rep.download_time> 0 ? ((rep.traff_download / rep.download_time) * 1000).toFixed(3) : 0
                        });
                        timeGraf.push({
                            num: num,
                            time: rep.work_time

                        });
                        var newRow = get_report_row(rep);
                        table.append(newRow);

                        num++;
                    });
                    console.log(codeData.data);

                    initOrUpdate(timeGraf, speedGraf, codeData);

                    // $('#report tbody').html(data);
                    {{ $task->status == 'inprogress' ? 'setTimeout(updatereport, 2000);' : "" }}


                }
            });
        }

        //возвращает строку для таблицы
        function get_report_row(report) {
            var row = '<tr>'
                    + '<td>' + report.id + '</td>'
//                    + '<td>' + report.users_send + '</td>'
                    + '<td>' + report.users_request + '</td>'
                    + '<td>' + report.all_request + '</td>'
                    + '<td>' + report.work_time + '</td>'
                    + '<td>' + report.speed_download + '</td>'
//                    + '<td>' + report.upload_time + '</td>'
                    + '<td>' + report.download_time + '</td>'
                    + '<td>' + report.traff_download + '</td>'
//                    + '<td>' + report.traff_upload + '</td>'

                    + '<td>' + ((report.traff_download / report.download_time) * 1000).toFixed(3) + '</td>'
//                    + '<td>' + (report.traff_upload / report.upload_time) * 1000 + '</td>'

//                    + '<td>' + report.speed_upload + '</td>'


                    + '<td>'
                    + '<table  class ="table table-hover">'
                    + '<th> Ответ </th>'
                    + '<th> Количество </th>';
            //row += report.codes_requests;
            codes_requests = jQuery.parseJSON(report.codes_requests);
            $.each(codes_requests, function (code, count) {
                row += '<tr>'
                        + '<td>' + code + '</td>'
                        + '<td>' + count + '</td>'
                        + '</tr>';
            });

            row += '</table>'
                    + '</td>'
                    + '</tr>';
            return row;
        }


    </script>
@endsection