@extends('layouts.appAdmin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @if(Session::has('error'))
                    <div class="alert alert-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif
                @if(Session::has('successfully'))
                    <div class="alert alert-success">
                        {{ Session::get('successfully') }}
                    </div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">Orders</div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>URL</th>
                                <th>Tariff</th>
                                <th>date</th>
                            </tr>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->url }}</td>
                                    <td>{{ $order->tariff }}</td>
                                    <td>{{ $order->created_at }}</td>
                                </tr>
                            @endforeach
                        </table>
                        <?php echo $orders->links(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection