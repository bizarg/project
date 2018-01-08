@extends('layouts.main')

@section('content')

    <div class="row">
        <div class="input-field col s12 m6">
            <select name="bm_select_user_name" id="bm_select_user_name">
                <option value="" disabled selected>Select User</option>
                @foreach($data as $id => $user)
                    <option value="{{ $id }}">{{ $user->alias }}</option>
                @endforeach
            </select>
            <label for="bm_select_user_name">User name</label>
        </div>
        <div class="input-field col s12 m6">
            <select disabled name="bm_select_server" id="bm_select_server">
                <option value="" disabled selected>Select User first</option>
            </select>
            <label for="bm_select_server">Screen</label>
        </div>
        <div class="col s12" id="bm_graphs_container"></div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('select').material_select();

            $("#bm_select_user_name").on('change', function () {
                $('#bm_graphs_container').empty();

                var elem = $('#bm_select_server');

                elem.empty()
                    .append("<option value=''>Loading...</option>")
                    .attr('disabled', 'true')
                    .material_select();

                $.post('{{ route('graphics.screens') }}', {userid: $(this).val()})
                    .done(function (json) {
                        var html_data = "<option value='' disabled selected>Select Screen</option>";
                        var screen_exist = false;
                        console.log($.parseJSON(json));
                        $.each($.parseJSON(json), function (index, value) {
                            /*$('#select_server')
                             .append("<option value='"+index+"'>"+value.name+"</option>");*/
                            screen_exist = true;
                            html_data += "<option value='" + value.graphs + "'>" + value.name + "</option>";
                        });

                        if (screen_exist) {
                            elem.empty()
                                .append(html_data)
                                .removeAttr('disabled')
                                .material_select();
                        } else {
                            elem.empty()
                                .append("<option value='' disabled selected>User have no Screens</option>")
                                .attr('disabled', 'true')
                                .material_select();
                        }
                    });
            });

            $("#bm_select_server").on('change', function () {
                $.ajax({
                    url: "{{ route('graphics.graphics') }}",
                    context: $('#bm_graphs_container'),
                    type: "POST",
                    data: {
                        graphs: $(this).val()
                    },
                    beforeSend: function () {
                        $(this)
                            .empty()
                            .append('<div class="progress"><div class="indeterminate"></div></div>');
                    }
                }).done(function (data) {
                    $(this)
                        .empty()
                        .append(data)
                        .find(".bm_graph_img")
                        .each(function () {
                            $(this).on('load', function () {
                                $(this)
                                    .parent()
                                    .find('.loading')
                                    .remove();
                            });
                        })
                });
            });
        });

    </script>
@endsection