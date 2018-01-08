@extends('layouts.app')

@section('breadcrumb')
    <li><a href="/">Home</a></li>
    <li class="active">Site</li>
@endsection

@section('content')
    <div class="container">
        <div class="row">

            <div class="panel panel-default">
                <div class="panel-heading">Status</div>
                <div class="panel-body">
                    <table class="table">
                        @if(count($userSite))
                            <tr>
                                <td>Notify Level <span id="update"></span></td>
                                <td>Status</td>
                                <td>Confirm</td>
                            </tr>
                            <tr>
                                <td>
                                    <form id="form" action="{{ action('User\UserController@change_notify') }}">
                                        <input type="hidden" id="site_id" name="site_id" value="{{ $site->id }}">
                                        <select class="form-control" id="notify" name="notify">
                                            <option name='notify' value="1" @if($userSite->notify_level == 1) selected @endif>1</option>
                                            <option name='notify' value="2" @if($userSite->notify_level == 2) selected @endif>2</option>
                                            <option name='notify' value="3" @if($userSite->notify_level == 3) selected @endif>3</option>
                                            <option name='notify' value="4" @if($userSite->notify_level == 4) selected @endif>4</option>
                                            <option name='notify' value="5" @if($userSite->notify_level == 5) selected @endif>5</option>
                                        </select>
                                    </form>
                                </td>
                                <td @if($userSite->status == 'enabled')style='color: green' @else style='color: red' @endif>
                                    {{ $userSite->status }}
                                </td>
                                <td @if($userSite->confirm == 'not_confirm')style='color: red' @else style='color: green' @endif>{{ $userSite->confirm }}</td>
                            </tr>
                        @else
                            <tr><td>Null</td></tr>
                        @endif
                    </table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">MainInfo</div>
                <div class="panel-body">
                    <table class="table table-bordered table-condensed border-separate">
                        @if(count($site->mainInfo))
                            <tr>
                                <th>Title</th>
                                <td>{{ $site->mainInfo->title }}</td>
                            </tr>
                            <tr>
                                <th>Keywords</th>
                                <td>{{ $site->mainInfo->keywords }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $site->mainInfo->description }}</td>
                            </tr>
                            <tr>
                                <th>Cms</th>
                                <td>{{ $site->mainInfo->cms }}</td>
                            </tr>
                            <tr>
                                <th>Favicon</th>
                                <td><img src="{{ $site->mainInfo->favicon }}" height="16px" width="16px" alt="favicon"/></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $site->mainInfo->status }}</td>
                            </tr>
                            <tr>
                                <th>Server</th>
                                <td>{{ $site->mainInfo->server }}</td>
                            </tr>
                            <tr>
                                <th>IP</th>
                                <td>{{ $site->mainInfo->ip }}</td>
                            </tr>
                            <tr>
                                <th>Country</th>
                                <td>{{ $site->mainInfo->country }}</td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>{{ $site->mainInfo->city }}</td>
                            </tr>
                            <tr>
                                <th>Time zone</th>
                                <td>{{ $site->mainInfo->time_zone }}</td>
                            </tr>
                            <tr>
                                <th>CSS framework</th>
                                <td>{{ $site->mainInfo->css_framework }}</td>
                            </tr>
                            <tr>
                                <th>JS framework</th>
                                <td>{{ $site->mainInfo->js_framework }}</td>
                            </tr>
                            <tr>
                                <th>Valid HTML</th>
                                <td><span class="read block">{{ $site->mainInfo->valid_html }}</span></td>
                            </tr>
                            <tr>
                                <th>Yandex metrica</th>
                                <td>{{ $site->mainInfo->yandex_metrica }}</td>
                            </tr>
                            <tr>
                                <th>Google analytics</th>
                                <td>{{ $site->mainInfo->google_analytics }}</td>
                            </tr>
                            <tr>
                                <th>Expiry Date</th>
                                <td>{{ $site->mainInfo->expiry_date }}</td>
                            </tr>
                        @else
                            <tr><td>Null</td></tr>
                        @endif
                    </table>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-3"><h4>Yandex</h4></div>
                        <div class="col-md-2 col-md-offset-6">
                            @if( count($yandex))
                                <a href="{{ action('User\HistoryController@yandex_history', [$site->id]) }}" class="btn btn-default">History</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">

                        @if( count($yandex))
                            <tr>
                                <th>Yaca</th>
                                <td>{{ $yandex->yaca }}</td>
                            </tr>
                            <tr>
                                <th>Yaca theme</th>
                                <td>{{ $yandex->yaca_theme }}</td>
                            </tr>
                            <tr>
                                <th>Tic</th>
                                <td>{{ $yandex->tic }}</td>
                            </tr>
                        @else
                            <tr><td>Null</td></tr>
                        @endif
                    </table>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-3"><h4>Screenshots</h4></div>
                        <div class="col-md-2 col-md-offset-6">
                            @if( count($site->screenshots))
                                <a href="{{ action('User\HistoryController@screenshots_history', [$site->id]) }}" class="btn btn-default">History</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        @if(count($screenshot))
                            <tr>
                                <th>ScreenshotName</th>
                                <td>{{ $screenshot->screenshot }}</td>
                            </tr>
                        @else
                            <tr><td>Null</td></tr>
                        @endif
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('js/readmore.min.js') }}"></script>
    <script>
        $('.read').readmore({
            afterToggle: function(trigger, element, more) {
                if(! more) { // ������ "������" ���� ������
                    $('html, body').animate({
                        scrollTop: element.offset().top
                    },{
                        duration: 100
                    });
                }
            }
        });
    </script>
    <script>
        $(function() {

            function send() {
                $.ajax({
                    url: $('#form').attr('action'),
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: $('#form').serialize(),
                    success: function (answer) {
                        console.log(answer);
                        $('#update').text(answer);
                        $('#update').css("color", "green").css("fontWeight", "bold");
                    },
                    error: function (e) {
                        $('#update').text(" Not updated");
                        $('#update').css("color", "red").css("fontWeight", "bold");
                    }
                });
            }

            $("#notify").change(function () {
                send();
            });

        });

    </script>

@endsection