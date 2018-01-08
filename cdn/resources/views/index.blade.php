@extends('layouts.panel')

@section('jumbotron')

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
        <div class="container">
            @if(session('check.admin'))
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4>Error!</h4>
                    <p>{{session('check.admin')}}</p>
                </div>
            @endif
            <h1></h1>
            <p></p>
            @if(Auth::check())
            <p>
                <form action="{{route('files.store')}}" method="post" id="my_form" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div id="msg"></div>
                    <div class="file-upload">
                        <label>
                        <input type="file" multiple="true" name="file[]" id="file">
                            <span>Select file</span>
                        </label>
                    </div>
                    <br>


    <!--                 <input type="file" multiple="true" class="btn btn-primary btn-lg" style="display: inline-block;" name="file[]" id="file"> -->
                    <button class="btn btn-primary btn-lg" href="#" role="button" type="submit" id="submit">Upload &raquo;</button>
                </form>
                <script type="text/javascript">
                    document.get
                </script>
            </p>
            @endif
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4>Success!</h4>
                    <p>{{session('success')}}</p>
                </div>
            @elseif (session('fail') or !$errors->isEmpty())
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4>Error!</h4>
                    <p>{{session('fail')}}</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('content')

    @if(Auth::check())
    <div class="tabbable"> <!-- Only required for left/right tabs -->
        <ul class="nav nav-tabs">
            <li @if($files->count() == 0)class="active"@endif><a href="#tab1" data-toggle="tab">Uploading <span class="badge" id="upload_count" data-tab="1">0</span></a></li>
            <li @if($files->count() > 0)class="active"@endif><a href="#tab2" data-toggle="tab">Uploaded <span class="badge" data-tab="2">{{$files->count()}}</span></a></li>
            <li><a href="#tab3" data-toggle="tab">Converting <span class="badge" data-tab="3">{{$convert_files->where('status', '<=', '1')->count()}}</span></a></li>
            <li><a href="#tab4" data-toggle="tab">Converted <span class="badge" data-tab="4">{{$convert_files->where('status', '>=', '2')->count()}}</span></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane @if($files->count() == 0)active @endif" id="tab1"><br>

            </div>
            <div class="tab-pane @if($files->count() > 0)active @endif" id="tab2"><br>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th><input type="checkbox" data-target="select_all"/> #</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody id="upload_files">
                    @forelse($files as $file)
                        <tr>
                            <th scope="row"><input type="checkbox" name="uploaded_files[]" value="{{$file->id}}"> {{$file->id}}</th>
                            <td><b>{{$file->name}}.{{$file->format}}</b></td>
                            <td>
                                <form action="{{route('files.destroy', [$file->id])}}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <a href="#!"><span class="glyphicon glyphicon-remove text-danger" aria-hidden="true" data-target="delete"></span></a>
                                    <a href="#!"><span class="glyphicon glyphicon-refresh" aria-hidden="true"  data-toggle="modal" data-target="#modal{{$file->id}}"></span></a>
                                </form>
                                <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="margin-top: 200px" id="modal{{$file->id}}">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                <h4 class="modal-title" id="mySmallModalLabel">{{$file->name}}</h4> </div>
                                            <div class="modal-body">
                                                <form data-target="convert" method="POST" action="{{route('convert-files.store')}}">
                                                    {{csrf_field()}}
                                                    <input name="file_id" type="hidden" value="{{$file->id}}">
                                                    <div class="form-group">
                                                        <label for="output_format">Output format</label>
                                                        <select class="form-control" name="output_format" data-role="output_format" id="output_format">
                                                            <option selected="selected" value="mp4">mp4</option>
                                                            <option value="flv">flv</option>
                                                            <option value="m3u8">m3u8</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group" data-role="bitrate" style="display: block">
                                                        <label for="bitrate">Bitrate</label>
                                                        <select class="form-control" name="bitrate">
                                                            @foreach($bitrates as $bitrate)
                                                                <option value="{{ $bitrate->bitrate }}">{{ $bitrate->bitrate }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group" data-role="output_resolution" style="display: none;">
                                                        <label for="exampleInputEmail1">Output resolution</label>
                                                        <select multiple class="form-control" name="output_resolution[]">
                                                            <option selected value="360p">360p</option>
                                                            <option value="480p">480p</option>
                                                            <option value="720p">720p</option>
                                                            <option value="1080p">1080p</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group" data-role="resolution">
                                                        <label for="exampleInputEmail1">Output resolution</label>
                                                        <select class="form-control" name="resolution">
                                                            @foreach($resolutions as $r)
                                                            <option selected value="{{ $r->weight . 'x' . $r->height }}">
                                                                {{ $r->weight . 'x' . $r->height }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Audio Bitrate</label>
                                                        <select class="form-control" name="audio_bitrate">
                                                            <option value="32">32</option>
                                                            <option selected>128</option>
                                                            <option value="160">160</option>
                                                            <option value="192">192</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Frame Rate</label>
                                                        <select class="form-control" name="frame_rate">
                                                            <option value="10">10</option>
                                                            <option selected>29</option>
                                                            <option value="40">40</option>
                                                            <option value="60">60</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="selectFTP">Select FTP account</label>
                                                        <select class="form-control" name="ftp">
                                                            <option selected>-----</option>
                                                            @foreach($ftps as $acc)
                                                            <option value="{{$acc->id}}">{{$acc->name}} ({{$acc->adr}})</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-default">Submit</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty

                    @endforelse
                    </tbody>
                </table>
                <p>{{--<button type="button" class="btn btn-default">Invert selected</button>--}} <form method="POST" action="{{route('files.delete')}}">{{csrf_field()}}<button type="button" class="btn btn-default" data-target="mass-delete">Remove selected</button></form></p>
            </div>
            <div class="tab-pane" id="tab3"><br>
                @forelse($convert_files->where('status', '<=', '1') as $file)
                <div class="panel panel-default">
                    <div class="panel-heading"><b>{{$file->file->name}}</b></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-11">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: {{$file->progress or 0}}%;">
                                        {{$file->progress or 0}}%
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-default btn-sm">
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @empty

                @endforelse
            </div>
            <div class="tab-pane" id="tab4"><br>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th><input type="checkbox" data-target="select_all"/> #</th>
                        <th>Name</th>
                        <th>Output format</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody id="converted_files">
                    @forelse($convert_files->where('status', '>=', '1') as $file)
                        <tr class="@if($file->status == 2 and $file->ftp_status != 3 ) success @else danger @endif">
                            <th scope="row"><input type="checkbox" name="converted_files[]" value="{{$file->id}}"> {{$file->id}}</th>
                            <td><b>{{$file->file->name}}</b></td>
                            <td><b>{{$file->output_format}}</b></td>
                            <td>
                                @if($file->status == 1)
                                    worked
                                @elseif($file->status == 2)
                                    completed
                                    @if($file->ftp_status == 1)
                                        (uploading to ftp server...)
                                    @elseif($file->ftp_status == 2)
                                        (uploaded to ftp server)
                                    @elseif($file->ftp_status == 3)
                                        (uploading to ftp server failed)
                                    @endif
                                @elseif($file->status == 3)
                                    failed
                                @endif
                            </td>
                            <td>
                                <form action="{{route('convert-files.destroy', [$file->id])}}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <a href="#!"><span class="glyphicon glyphicon-remove text-danger" aria-hidden="true" data-target="delete"></span></a>
                                    @if($file->status == 2)
                                    <a href="{{ route('convert-files.download', [$file->id]) }}"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a>
                                    {{--<a href="#"><span class="glyphicon glyphicon-cog" aria-hidden="true"  data-toggle="modal" data-target="#modal{{$file->id}}" data-gener="cog"></span></a>--}}

                                        {{--<a href="#"><span class="glyphicon glyphicon-cog" data-toggle="modal" data-target=".bs-example-modal-lg"></span>--}}
                                        {{--<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">--}}
                                            {{--<div class="modal-dialog modal-lg" role="document">--}}
                                                {{--<div class="modal-content">--}}
                                                    {{--<p>modal-dialog modal-lgmodal-dialog modal-lgmodal-dialog 
                                                    {{--</p>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                        <a href="#"><span type="button" class="glyphicon glyphicon-cog" data-toggle="modal" data-target="#myModal{{ $file->id }}" data-gener="{{ $file->id }}">

                                        </span></a>


                                    @endif
                                </form>
                                <div class="modal fade" id="myModal{{ $file->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Template</h4>
                                            </div>
                                            <div class="modal-body">
                                                <textarea id="post-shortlink{{ $file->id }}" class="form-control paste"></textarea>
                                                <br/>
                                                <button class="btn btn-default copy-button" data-clipboard-target="#post-shortlink{{ $file->id }}">Copy</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                {{--<span class="glyphicon glyphicon-info-sign text-warning" aria-hidden="true" role="button" tabindex="0" data-trigger="focus" data-toggle="popover" title="An error occurred while converting" data-content="The file is corrupt or has a broken sectors!"></span>--}}

                                <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="margin-top: 200px" id="modal{{$file->id}}">
                                    <div class="modal-dialog modal-sm" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                <h4 class="modal-title" id="mySmallModalLabel">{{$file->name}}</h4> </div>
                                            <div class="modal-body">
                                                <form data-target="convert" method="POST" action="{{route('convert-files.store')}}">
                                                    {{csrf_field()}}
                                                    <input name="file_id" type="hidden" value="{{$file->id}}">
                                                    <p>{{$file->file->name}}.{{$file->output_format}}</p>
                                                    <button type="submit" class="btn btn-default">Submit</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty

                    @endforelse
                    </tbody>
                </table>
                <p><form method="POST" action="{{route('convert-files.delete')}}">{{csrf_field()}}<button type="button" class="btn btn-default" data-target="mass-delete">Remove selected</button></form></p>
            </div>
        </div>
    </div>
    @else
    <p class="text-center"><a href="{{route('login')}}">Login</a> to be able to use the service</p>
    @endif
@endsection


@section('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.4.0/clipboard.min.js"></script>
    <script>
        (function(){
            new Clipboard('.copy-button');
        })();
    </script>
    <script>
        $(function () {
            $('[data-gener]').click(function (e) {

                var that = $(this);
                var attr = that[0].attributes;
                var id = attr[4].value;

                var textarea = $(attr[3].value).find('.paste');

                $.ajax({
                    url: 'settings/generate',
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: "id="+id,
                    success: function (json) {
                        textarea.html(json);
                    }
                });
            });
        });
    </script>
    <script>
        var count = 0;
        var interval = 10000;  // 1000 = 1 second, 3000 = 3 seconds

        $(function () {

            tab1count = $("span[data-tab=1]").text();
            tab2count = $("span[data-tab=2]").text();
            tab3count = $("span[data-tab=3]").text();
            tab4count = $("span[data-tab=4]").text();

            $("ul.nav.nav-tabs li").click(function () {
                if($(this).hasClass('alert-info')) {
                    $(this).removeClass('alert-info');
                }
            });

            // click delete icon
            $("span[data-target=delete]").click(function (e) {
                deleteFile(e, $(this));
            });

            // convert file popup
            var selects = $("select[data-role=output_format]");
            changeResolution(selects);
            selects.change(function() {
                    changeResolution($(this).find(":selected"));
                }).trigger("change");

            function changeResolution(obj) {
                if(obj.text() == 'm3u8') {
                    obj.parents('form').find("div[data-role=resolution]").hide();
                    obj.parents('form').find("div[data-role=output_resolution]").show();
                    obj.parents('form').find("div[data-role=bitrate]").show();
                } else if(obj.text() == 'flv') {
                    obj.parents('form').find("div[data-role=bitrate]").hide();
                    obj.parents('form').find("div[data-role=output_resolution]").hide();
                    obj.parents('form').find("div[data-role=resolution]").show();
                } else {
                    obj.parents('form').find("div[data-role=output_resolution]").hide();
                    obj.parents('form').find("div[data-role=resolution]").show();
                    obj.parents('form').find("div[data-role=bitrate]").show();
                }

                return true;
            }

            //$('form[data-target=convert]').on('submit', function(e){
            // send file to convert
            function convertFile(e, obj) {
                e.preventDefault();
                var $that = obj;
                $that.find('select[name=ftp]').each(function(){
                    if($(this).val() == '-----'){
                        $(this).attr('disabled', 'disabled');
                    }
                });
                $.ajax({
                    url: $that.attr('action'),
                    type: $that.attr('method'),
                    data: $that.serialize(),
                    success: function(json){
                        alert(json.msg);
                        $('#tab3').append('<div class="panel panel-default" id="converting' + json.id + '">\
                                <div class="panel-heading"><b>'+ json.name +'.' + json.output_format +'</b></div>\
                                <div class="panel-body">\
                                    <div class="row">\
                                        <div class="col-md-12">\
                                            <div class="progress">\
                                                <div class="progress-bar progress-bar-striped active" data-jobid="'+ json.id +'" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: '+ 10 +'%;">\
                                                    '+ 10 +'%\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>\
                                </div>\
                        ');
                        tab3count++;
                        $("span[data-tab=3]").text(tab3count);
                        alertNewActionInTab($('ul.nav.nav-tabs > li:nth-child(3)'));
                        getProgres(json);
                    },
                    complete: function(){
                        $that.parents('div[role=dialog]').modal('hide');
                    },
                    error: function(json){
                        alert(json.msg);
                    }
                });
            }
            $('form[data-target=convert]').on('submit', function(e){
                convertFile(e, $(this));
            });

            // popover on
            $('[data-toggle="popover"]').popover();

var control = document.getElementById("file");
control.addEventListener("change", function(event) {
    // Когда происходит изменение элементов управления, значит появились новые файлы
    var msg = document.getElementById('msg'),
        files = control.files,
        len = files.length;

    console.log(files);

    if(len == 1){
            msg.textContent = files[0].name;
        } else if (len >= 2){
            msg.textContent =  'Files selected: ' + files.length;
        } else {
            msg.textContent =  'File not selected';
        }
}, false);

            // new file upload
            $('#my_form').on('submit', function(e){
                e.preventDefault();

                if(control.files.length == 0) {
                    document.getElementById('msg').textContent = 'File not selected';
                    return false;
                }




                for(var j = 0; j < control.files.length; j++){
                    if(control.files[j].type != "audio/mp3" &&
                            control.files[j].type != "audio/mp4" &&
                            control.files[j].type != "audio/mpeg" &&
                            control.files[j].type != "video/x-msvideo" &&
                            control.files[j].type != "video/x-matroska" &&
                            control.files[j].type != "video/x-flv" &&
                            control.files[j].type != "video/webm" &&
                            control.files[j].type != "video/avi" &&
                            control.files[j].type != "video/msvideo" &&
                            control.files[j].type != "video/x-msvideo" &&
                            control.files[j].type != "video/mp4"){
                        document.getElementById('msg').textContent =  'File type error';
                        console.log(control.files[j].type);

                        return false;
                    }
                }


                var start_time = Date.now();
                var upload_count = count;
                var i = 0;
                count++;
                var $that = $(this),
                formData = new FormData($that.get(0));
                var filename = '';
                var filesize = '';
                $.ajax({
                    url: $that.attr('action'),
                    type: $that.attr('method'),
                    contentType: false,
                    processData: false,
                    data: formData,
                    xhr: function(){
                        $.each($('#file').prop("files"), function(k,v){
                            filename = v['name'];
                            var size = v['size'] / 1000000;
                            if(k > 0){
                            	var i = k + 1 ;
                            	filename = 'Загружается ' + i + ' файла(ов).';
                            	filesize += size;
                            } else {
                            	filesize = size;
                            }
                        });
                        $('#tab1').append('\
                        <div class="panel panel-default">\
                            <div class="panel-heading" id="filename' + upload_count + '"><b>' + filename + '</b></div>\
                            <div class="panel-body" id="panel-body' + upload_count + '">\
                                <div class="row">\
                                    <div id="progress-block' + upload_count + '">\
                                        <div class="col-md-11">\
                                            <div class="progress">\
                                                <div class="progress-bar progress-bar-striped active" role="progressbar" id="progressbar' + upload_count + '" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: 0%;">\
                                                0%\
                                                </div>\
                                            </div>\
                                        </div>\
                                        <div class="col-md-1">\
                                            <button type="button" class="btn btn-default btn-sm" data-target="cancel">\
                                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancel\
                                            </button>\
                                        </div>\
                                    </div>\
                                    <div class="col-md-3">\
                                        Gone:<span id="progress_right' + upload_count + '"></span>\
                                    </div>\
                                    <div class="col-md-3">\
                                        Left:<span id="progress_left' + upload_count + '"></span>\
                                    </div>\
                                    <div class="col-md-3">\
                                        Upload speed:<span id="progress_speed' + upload_count + '"></span>\
                                    </div>\
                                    <div class="col-md-3">\
                                        Size: <span id="progress_size' + upload_count + '"></span>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>');


                        var xhr = $.ajaxSettings.xhr(); // получаем объект XMLHttpRequest

                        var progressBar = $('#progressbar' + upload_count);
                        $('#progress_size' + upload_count).text(filesize.toFixed(2) + ' mb');

                        tab1count++;
                        alertNewActionInTab($('ul.nav.nav-tabs > li:nth-child(1)'));
                        $("span[data-tab=1]").text(tab1count);

                        $('button[data-target=cancel]').click(function() {
                            xhr.abort();
                            $('#progress-block' + upload_count).hide();
                            $('#panel-body' + upload_count).hide();
                            $('#filename' + upload_count).append(' <span class="glyphicon glyphicon-remove text-danger aria-hidden="true" role="button" tabindex="0" data-trigger="focus" data-toggle="popover" title="Error" data-content="File upload canceled"></span>');
                            tab1count--;
                            $('[data-toggle="popover"]').popover();
                        });

                        xhr.upload.addEventListener('progress', function(evt){ // добавляем обработчик события progress (onprogress)

                            if(evt.lengthComputable) { // если известно количество байт
                                // высчитываем процент загруженного
                                var percentComplete = Math.ceil(evt.loaded / evt.total * 100);
                                // устанавливаем значение в атрибут value тега <progress>
                                // и это же значение альтернативным текстом для браузеров, не поддерживающих <progress>

                                progressBar.val(percentComplete).text('Load ' + percentComplete + '%');
                                progressBar.css('width', percentComplete + '%');
                                var now_time = Date.now() - start_time;
                                var now_speed = ((evt.loaded / 1000000) / (now_time / 1000 )) * 8;

                                $('#progress_right'+ upload_count).text(timeConversion((((evt.total - evt.loaded) / 1000000) / now_speed) * 10000));
                                $('#progress_left'+ upload_count).text(timeConversion(now_time));
                                $('#progress_speed'+ upload_count).text((now_speed).toFixed(2) + ' mbp/s');
                            }
                        }, false);

                        return xhr;

                    },
                    success: function(json){

                    	$.each(json, function(k,v){
                		json = v;
                		if(json.error == 'text'){
                			$('#filename'+ upload_count).append(' <span class="glyphicon glyphicon-remove text-danger"></span>');
                		} else {

                        $('#filename'+ upload_count).append(' <span class="glyphicon glyphicon-ok text-success"></span>');
                        tab2count++;
                        alertNewActionInTab($('ul.nav.nav-tabs > li:nth-child(2)'));
                        $("span[data-tab=2]").text(tab2count);
                        $('#upload_files').append('<tr>\
                                <th scope="row"><input type="checkbox" name="uploaded_files[]"> '+ json.id +'</th>\
                                    <td><b>'+ json.name +'</b></td>\
                                    <td>\
                                        <form action="/files/'+ json.id +'" method="POST">\
                                            {{ csrf_field() }}\
                                            {{ method_field('DELETE') }}\
                                            <a href="#!"><span class="glyphicon glyphicon-remove text-danger" aria-hidden="true" data-target="delete"></span></a>\
                                            <a href="#!"><span class="glyphicon glyphicon-refresh" aria-hidden="true"  data-toggle="modal" data-target="#modal'+ json.id +'"></span></a>\
                                        </form>\
                                        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" style="margin-top: 200px" id="modal'+ json.id +'">\
                                            <div class="modal-dialog modal-lg" role="document">\
                                                <div class="modal-content">\
                                                    <div class="modal-header">\
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>\
                                                        <h4 class="modal-title" id="mySmallModalLabel">'+ json.name +'</h4>\
                                                    </div>\
                                                    <div class="modal-body">\
                                                        <form data-target="convert" method="POST" action="/convert-files">\
                                                            {{csrf_field()}}\
                                                            <input name="file_id" type="hidden" value="'+ json.id +'">\
                                                            <div class="form-group">\
                                                                <label for="output_format">Output format</label>\
                                                                <select class="form-control" name="output_format" data-role="output_format">\
                                                                    <option selected="selected" value="mp4">mp4</option>\
                                                                    <option value="flv">flv</option>\
                                                                    <option value="m3u8">m3u8</option>\
                                                                </select>\
                                                            </div>\
                                                            <div class="form-group" data-role="bitrate" style="display: show;">\
                                                            <label for="output_format">Bitrate</label>\
                                                                <select class="form-control" name="bitrate" data-role="bitrate">\
                                                                    @foreach($bitrates as $bitrate)
                                                                        <option value="{{ $bitrate->bitrate }}">{{ $bitrate->bitrate }}</option>\
                                                                    @endforeach
                                                                </select>\
                                                            </div>\
                                                            <div class="form-group" data-role="output_resolution" style="display: none;">\
                                                                <label for="exampleInputEmail1">Output resolution</label>\
                                                                <select multiple class="form-control" name="output_resolution[]">\
                                                                    <option selected value="360p">360p</option>\
                                                                    <option value="480p">480p</option>\
                                                                    <option value="720p">720p</option>\
                                                                    <option value="1080p">1080p</option>\
                                                                </select>\
                                                            </div>\
                                                            <div class="form-group" data-role="resolution">\
                                                                <label for="exampleInputEmail1">Output resolution</label>\
                                                                <select class="form-control" name="resolution" id="resolution">\
                                                                    @foreach($resolutions as $r)
                                                                    <option value="{{$r->weight.'x'.$r->height}}">{{$r->weight.'x'.$r->height}}</option>\
                                                                    @endforeach
                                                                </select>\
                                                            </div>\
                                                            <div class="form-group">\
                                                                <label for="exampleInputEmail1">Audio Bitrate</label>\
                                                                <select class="form-control" name="audio_bitrate">\
                                                                    <option value="32">32</option>\
                                                                    <option selected>128</option>\
                                                                    <option value="160">160</option>\
                                                                    <option value="192">192</option>\
                                                                </select>\
                                                            </div>\
                                                            <div class="form-group">\
                                                                <label for="exampleInputEmail1">Frame Rate</label>\
                                                                <select class="form-control" name="frame_rate">\
                                                                    <option value="10">10</option>\
                                                                    <option selected>29</option>\
                                                                    <option value="40">40</option>\
                                                                    <option value="60">60</option>\
                                                                </select>\
                                                            </div>\
                                                            <div class="form-group">\
                                                                <label for="selectFTP">Select FTP account</label>\
                                                                <select class="form-control" name="ftp">\
                                                                    <option selected>-----</option>\
                                                                    @foreach($ftps as $acc)
                                                                    <option value="{{$acc->id}}">{{$acc->name}} ({{$acc->adr}})</option>\
                                                                    @endforeach
                                                                </select>\
                                                            </div>\
                                                            <button type="submit" class="btn btn-default">Submit</button>\
                                                        </form>\
                                                    </div>\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </td>\
                                </tr>');
                        // click delete icon
                        $("span[data-target=delete]").click(function (e) {
                            deleteFile(e, $(this));
                        });
                        $('form[data-target=convert]').on('submit', function(e){
                            convertFile(e, $(this));
                        });
                    }
                        });
                    },
                    complete: function(json){
                        $('#progress-block' + upload_count).hide();
                        $('#panel-body' + upload_count).hide();
                        tab1count--;
                        $("span[data-tab=1]").text(tab1count);
                        selects = $("select[data-role=output_format]");
                        selects
                                .change(function() {
                                    changeResolution($(this).find(":selected"));
                                })
                                .trigger("change");
                    },
                    error: function(json){
                        var responseMsg = jQuery.parseJSON(json.responseText);
                        $('#filename' + upload_count).append(' <span class="glyphicon glyphicon-remove text-danger aria-hidden="true" role="button" tabindex="0" data-trigger="focus" data-toggle="popover" title="Error" data-content="file not uploaded"></span>');
                        if (responseMsg.hasOwnProperty('file')) {
                            $('#filename' + upload_count).append(' <span class="glyphicon glyphicon-info-sign text-warning" aria-hidden="true" role="button" tabindex="0" data-trigger="focus" data-toggle="popover" title="An error occurred when the file is loaded" data-content="' + responseMsg.file + '"></span>');
                        }
                        $('[data-toggle="popover"]').popover();
                    }
                });
            });
        });


        function deleteFile(e, obj) {
            if(obj.parents('div.tab-pane').attr('id') == 'tab2') {
                string = 'Are you sure?\nThis operation deleted uploaded file!';
            } else {
                string = 'Are you sure?\nThis operation deleted converted file!';
            }
            if (!confirm(string)) {
                e.preventDefault();
            } else {
                var form = obj.parents('form:first');
                form.submit();
            }
        }

        // convert milliseconds to human time
        function timeConversion(millisec) {
            var seconds = (millisec / 1000).toFixed(1);
            var minutes = (millisec / (1000 * 60)).toFixed(1);
            var hours = (millisec / (1000 * 60 * 60)).toFixed(1);
            var days = (millisec / (1000 * 60 * 60 * 24)).toFixed(1);
            if (seconds < 60) {
                return seconds + " Sec";
            } else if (minutes < 60) {
                return minutes + " Min";
            } else if (hours < 24) {
                return hours + " Hrs";
            } else {
                return days + " Days"
            }
        }

        // alert after new action in tab
        function alertNewActionInTab(obj) {
            if(!obj.hasClass('active'))
                obj.addClass('alert-info');
        }

        // alert after new action in tab
        function deleteNewActionAlertInTab(obj) {
            if(tab3count == 0) {
                obj.removeClass('alert-info');
            }
        }

        function getProgres(json) {
            $.ajax({
                type: 'GET',
                url: '/convert-files/'+json.id,
                //dataType: 'json',
                success: function (data) {
                    temp_div = $('div[data-jobid='+ json.id +']');
                    if(data.progress == undefined || data.progress == null) {
                        data.progress = 0;
                    }
                    temp_div.text(data.progress + '%').css('width', data.progress + '%');// first set the value
                    if(data.status == 1) {
                        // Schedule the next
                        setTimeout(getProgres(json), interval);
                    } else if(data.status == 2 || data.status == 3) {
                        tab4count++;
                        alertNewActionInTab($('ul.nav.nav-tabs > li:nth-child(4)'));
                        $("span[data-tab=4]").text(tab4count);
                        tab3count--;
                        deleteNewActionAlertInTab($('ul.nav.nav-tabs > li:nth-child(3)'));
                        $("span[data-tab=3]").text(tab3count);
                        $("#converting" + data.id).hide();
                        temp_convert_div = '';
                        if(data.status == 2) {
                            color = 'success';
                        } else if(data.status == 3) {
                            color = 'danger';
                        }
                        temp_convert_div += ('<tr class="'+ color +'">\
                                <th scope="row"><input type="checkbox" name="converted_files[]" value="'+ data.id +'"> '+ data.id +'</th>\
                                <td><b>'+ data.name +'</b></td>\
                                <td><b>'+ data.output_format +'</b></td>\
                                <td>');
                        if(data.status == 2) {
                            temp_convert_div += ('completed ');
                            if (data.ftp_status == 1)
                                temp_convert_div += ('(uploading to ftp server...)');
                            else if (data.ftp_status == 2)
                                temp_convert_div += ('(uploaded to ftp server)');
                            else if (data.ftp_status == 3)
                                temp_convert_div += ('(uploading to ftp server failed)');
                        } else if(data.status == 3) {
                            temp_convert_div += ('failed');
                        }
                        temp_convert_div += ('</td><td><form action="/convert-files/'+ data.id +'" method="POST">\
                            {{ csrf_field() }}\
                            {{ method_field('DELETE') }}\
                            <a href="#!"><span class="glyphicon glyphicon-remove text-danger" aria-hidden="true" data-target="delete"></span></a>');
                        if(data.status == 2) {
                            temp_convert_div += ('\
                            <a href="/download/'+ data.id +'"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a>');
                        }
                        temp_convert_div += ('</form></td></tr>');
                        $('#converted_files').append(temp_convert_div);
                    }
                    // click delete icon
                    $("span[data-target=delete]").click(function (e) {
                        deleteFile(e, $(this));
                    });
                },
                complete: function (data) {
                    //
                }
            });
        }

        $('input[data-target=select_all]').change(function() {
            var checkboxes = $(this).closest('table').find(':checkbox');
            if($(this).is(':checked')) {
                checkboxes.prop('checked', true);
            } else {
                checkboxes.prop('checked', false);
            }
        });

        $('button[data-target=mass-delete]').click(function(e) {
            if($(this).parents('div.tab-pane').attr('id') == 'tab2') {
                string = 'Are you sure?\nThis operation deleted all uploaded files!';
            } else {
                string = 'Are you sure?\nThis operation deleted all converted or converting files!';
            }
            if (!confirm(string)) {
                e.preventDefault();
            } else {
                $(this).parent('form').hide().append($(this).closest('div').find(':checkbox').clone()).submit();
            }
        });
    </script>
@endsection
