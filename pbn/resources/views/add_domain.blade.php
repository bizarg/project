@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-2"><h4>Domains</h4></div>
                    <div class="col-md-2 col-md-offset-7">
                        <a class="btn btn-default" href="/" id="install">Install</a>
                    </div>
                </div>
            </div>

            <div class="panel-body">
                <form id="add_domains" class="form-horizontal" action="" method="post">
                    {{ csrf_field() }}

                    <div class="form-install-groups">
                        <div class="form-install-group">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Domain <span style="color: red;font-size: 18px;">*</span></label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="domain" value="" placeholder="example.com">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Directory</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="directory" value="" placeholder="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Country <span style="color: red;font-size: 18px;">*</span></label>

                                <div class="col-md-6">
                                    <select class="form-control" name="country" value="" data-role="country">
                                        <option value="">Выберите страну</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group addserver">

                            </div>



                            <div class="form-group">
                                <label class="col-md-2 control-label">Build WP <span style="color: red;font-size: 18px;">*</span></label>

                                <div class="col-md-6">
                                    <select class="form-control" name="app" value="">
                                     @foreach($builds as $build)
                                            <option value="{{ $build->id }}">{{ $build->name }}</option>
                                     @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2 button-remove">
                                    <a class="btn btn-primary remove">
                                        <span class="glyphicon glyphicon-minus"></span>
                                    </a>
                                </div>
                            </div>
                            <hr width="100%">
                        </div>
                    </div>


                    <div class="form-group" id="button">
                        <div class="col-md-2 col-md-offset-8">
                            <a type="submit" class="btn btn-primary add">
                                <span class="glyphicon glyphicon-plus"></span>
                            </a>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
@endsection



@section('javascript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>

        $(document).ready(function () {

            $('div.button-remove:first').hide();
            addEventChange();

            $('.add').on('click', function (e) {
                e.preventDefault();
                addFields();
                addEventRemove();
                addEventChange();
            });

            $('#install').on('click', function(e){
                e.preventDefault();
                install();
//                console.log("pbncountry.com/blog1".match(/(.*)\//));
//                var div_class = "http://pbncountry.com/blog1".replace( /http[\s]?:\/\/?/i, '' );
//                div_class = div_class.match(/(.*)\//);
//                div_class = div_class[1].replace('.', '_');
//                console.log(div_class + 90);
            });

            $('#add_domains').on('submit', function(e){
                e.preventDefault();
                install();
            });

            function install(){
                $('#install').remove();
                $("#add_domains").animate({opacity:0}, 300, 'linear').animate({height:0}, 300);

                var groups = $('.form-install-group');

                var install = {
                    domain: [],
                    app: [],
                    ip: [],
                    directory: [],
                }
                groups.find('input[name=domain]').each(function(i, e){
                    install.domain.push(e.value);
                });
                groups.find('select[name=ip]').each(function(i, e){
                    install.ip.push(e.value);
                });
                groups.find('select[name=app]').each(function(i, e){
                    install.app.push(e.value);
                });
                groups.find('input[name=directory]').each(function(i, e){
                    install.directory.push(e.value);
                });

                for (var k = 0; k < install.domain.length; k++) {

//                    var div_class = install.domain[k].replace(/['.']?['/']?/gi, '_');
                    setTimeout(function(){$("#add_domains").remove()}, 600);

                    var data = "domain=" + install.domain[k] + "&";
                    data += "ip=" + install.ip[k]+ "&";
                    data += "app=" + install.app[k] + "&";
                    data += "directory=" + install.directory[k];

                    setApp('install', data).then(
                        function(result){

                            var html = '';
                            var div_class = 'block';
                            var str_repl = function(str) { return str.replace(/^\s+|\s+$/g, ""); };

                            var random = Math.round(Math.random() * 100);

                            if(result[0] == 'The installation has completed successfully!') {
                                html +='<p style="color: #009900;">' + result[0] + '</p>';
                                html +='<p>' + result[2] + '</p>';
                                html +='<p>' + result[3] + '</p>';
                                html +='<p>' + result[4] + '</p>';
                                html +='<p>' + result[5] + '</p>';
                                html +='<p>' + result[6] + '</p>';
                                html +='<p>' + result[7] + '</p>';
                                html +='<a href="' + result[8]  + '"><p>' + result[8] + '<p/></a>';
                                html +='<a href="' + result[9]  + '"><p>' + result[9] + '<p/></a>';

                                div_class = result[8].replace( /http[\s]?:\/\/?/i, '' ).match(/([\w\-]*\.\w*)[\/]?/);

                                div_class = div_class[1].replace('.', '_');

                            } else {
                                html +='<p style="color: #990000;">' + result[0] + '</p>';
                            }

                            var block = str_repl(div_class)  + random;

                            $(".panel-body").append('<div class="block-' + block + '">')
                            $('div.block-'+ block).hide().append(html).slideDown(1000);
                            $('div.block-'+ block).append('<hr width="100%"/>');
                        }
                    );
                }
            }

            function setApp(url, data){
                return new Promise(function(resolve,reject){
                    var div_class = Math.round(Math.random() * 100);
                    $.ajax({
                        type: 'post',
                        url: url,
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(json){
                            resolve(json)
                        },
                        error: function () {
                            reject(id)
                        },
                        beforeSend: function () {

                            $(".panel-body").prepend('<div class="block-' + div_class + '"></div>');
                            $('div.block-' + div_class ).hide().html('<h2>Идет установка приложения</h2>').slideDown("slow");
                        },
                        complete: function  () {
                            $('div.block-' + div_class ).remove('');
                        }
                    });
                });
            }

            function addFields() {
                $('.form-install-group:first').clone().find("input:text").val("")
                    .end().find("div.button-remove").show()
                    .end().find('div.addserver').html('')
                    .end().appendTo(".form-install-groups");
            }

            function addEventRemove(){
                $('.remove').on('click', function (e) {
                    e.preventDefault();
                    $(this).closest(".form-install-group").remove();
                });
            }

            function addEventChange() {
                $("select[data-role=country]").unbind('change');

                $("select[data-role=country]").on('change', function (e) {
                    changeCountry($(this).find(":selected"));
                })
            }

            function changeCountry(obj) {
                var country = obj.val();
//                console.log(obj.text());
                $.ajax({
                    url: 'get/servers',
                    type: 'post',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: "country="+country,
                    success: function (json) {
//                        console.log(json[0].ip);

                        var html;

                        html ='<label class="col-md-2 control-label">Server<span style="color: red;font-size: 18px;">*</span></label>';
                        html +='<div class="col-md-6">';
                        html +='<select class="form-control" name="ip" value="">';
                        for (var i = 0; i < json.length; i++) {
                            html += '<option value="' + json[i].ip + '">' + json[i].ip + '</option>'
                        }
                        html +='</select></div>';

                        obj.parent().parent().parent().next().html(html);
                    }
                });

            }

        });
    </script>

@endsection