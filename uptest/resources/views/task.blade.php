@extends('layout')

@section('content')

    <div class="col-md-10">

        <div class="row">
            <div class="col-md-8">
                <h3>Add Domain</h3>

                <form class="form-horizontal" name="test" role="form" method="post"
                      action="{{ url('url/static') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="col-sm-8">
                            <input class="form-control" type="text" name="url" placeholder="Domain"/>
                            @if ($errors->has('url'))
                                <span class="warning">
                        <strong>{{ $errors->first('url') }}</strong>
                        </span>
                            @endif
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-8">
                            <input type="submit" onclick="geturls(); return false;"
                                   class=" form-control btn btn-default" name="send"/>
                        </div>
                    </div>

                </form>
            </div>
        </div>


        <div class="row">
            <div class="col-md-10 mt">
                <h3>Page URls</h3>


                <table class="table" id="table">
                    <tr>
                        <td></td>
                    </tr>

                </table>
                <div id="info">
                </div>

            </div>
        </div>


    </div>



    <script lang="text/javascript">
        //                        urls = jQuery.parseJSON(data);
        //                        table = '<table class="table">';
        //                        $.each(urls, function (i, val) {
        //                            //console.log(val);
        //                            table+='<tr><td>'+val+'</td></tr>';
        //                        });
        //                        table += '</table>';
        //                        console.log(table);

        function getInfo() {
            //console.log('timer get info');
            $.post("/url/info", $(test).serialize())
                    .done(function (data) {
                        // $('#table tr:last').after('<tr><td>' + data + '</td></tr>');
                        console.log(data);
                        console.log(data !== 'stop');
                        if (data !== 'stop') {
                            table = '<table class="table">';
                            infos = jQuery.parseJSON(data);

                            $.each(infos, function (i, val) {
                                //console.log(val);
                                table += '<tr><td>' + val + '</td></tr>';
                            });
                            //$('#table tr:last').after('<tr><td>' + data + '</td></tr>');
                            table += '<table>';
                            $('#info').html(table);
                            setTimeout(getInfo, 1000);
                        } else {
                            $('#table tr:last').after('<tr><td>stop</td></tr>');
                        }
                    });
        }

        function geturls() {
            //url = $(test).find('input[name="domain"]').val();
            $.post("/url/static", $(test).serialize())
                    .done(function (data) {


                        $('#table tr:last').after('<tr><td>' + data + '</td></tr>');
                        setTimeout(getInfo, 3000);
                    });
        }

        function checkDomain(id) {
            $.ajax({
                url: '{{ url('admin/domain/check/') }}/' + id,             // указываем URL и

                success: function (data) {
                    $('#info').html(data);
                }
            });
            return false;
        }
    </script>

@endsection