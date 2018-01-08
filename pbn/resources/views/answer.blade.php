@extends('layouts.app')



@section('content')

    <div class="container">
        @if(count($answers))
        @foreach($answers as $message)
            <div class="panel panel-default">

            <div class="panel-heading">
                <h4>Result</h4>
            </div>
                <div class="panel-body">
                    @foreach($message as $item)
                        <table class="table-bordered table">
                            <tr>
                                <td>{{ $item }}</td>
                            </tr>
                        </table>
                    @endforeach
                </div>
            </div>
        @endforeach
        @endif
    </div>
@endsection



@section('javascript')


@endsection