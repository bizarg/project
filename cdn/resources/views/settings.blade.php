@extends('layouts.panel')

@section('breadcrumb')
    <li><a href="/">Home</a></li>
    <li class="active">Settings</li>
@endsection

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">Users</div>
        <div class="panel-body">
            @if(Session::has('status'))
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                    <h4 id="class4">Saved!</h4>
                    <p>Status changed.</p>
                </div>
            @endif
            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Upload file</th>
                    <th></th>
                </tr>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    @if($user->status)
                    <td><a href="{{ url('admin/status/'.$user->id) }}" class="btn btn-success url">Одобрен</a></td>
                    @else
                    <td ><a href="{{ url('admin/status/'.$user->id) }}" class="btn btn-warning">Не одобрен</a></td>
                    @endif
                    <form action="{{ route('status.upload', [$user->id]) }}" method="POST">
                        {{ csrf_field() }}
                    <td><input type="number" size="" name="num" min="0" max="" value="{{ $user->quantity}}"></td>
                    <td>
                        <input type='submit' id="submit" data-target="refresh" class="btn btn-primary submit" value="Обновить">
                    </td>
                    </form>

                </tr>
                @endforeach
            </table>
        </div>
    </div>
<script>
window.onload = function() {

    $('form').on('submit', function(e){
        e.preventDefault();
        var $form = $(this);
        var data = $form.context.parentElement.children[5].children[0];
        var formData = new FormData($form.get(0));
            $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method'),
                contentType: false,
                processData: false,
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                success: function(json){
                    if(json.res == 'error'){
                        data.value = json.res;
                        data.style.color='#f00';
                    } else {
                        data.value = json.res;
                        data.style.color='#449d44';
                    }
                },
            });

        });
    };

</script>

@endsection

