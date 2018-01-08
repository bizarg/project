@extends('layouts.appAdmin')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $task->name }}</div>
            	<div class="panel-body">
                    <div>{{  $task->description }}</div>

                    
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Comments</div>
            	<div class="panel-body">

                    <div>
					@foreach($comments as $comment)
                        <div style="border:1px solid silver;padding-left: 20px;margin-bottom: 3px;">
                            <div class="author">
                            <span style="font-size:18px;color:#f00;">{{ $comment->user_name }}</span><span style="font-size:10px;"> {{ $comment->created_at }}</span></div>
                            <div class="comment" style="">{{ $comment->text }}</div>
                        </div>
					@endforeach
					</div>
                    {{ $comments->links() }}

					<div style="margin-top: 30px;border-top:1px solid silver;padding-top: 10px;">

					<form class="form-horizontal" role="form" method="POST" action="{{ url('comment/'.$task->id) }}">
                    {{ csrf_field() }}
						<input type="hidden" name="object" value="task">
                         <div class="form-group{{ $errors->has('text') ? ' has-error' : '' }}">
                            <label for="text" class="col-md-4 control-label">Comment</label>
                            <div class="col-md-6">
                                <textarea id="text" type="textarea" class="form-control" name="text" rows='3'>{{ old('text') }}</textarea>                               
                                @if ($errors->has('text'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('text') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Add Comment
                                </button>
                            </div>
                        </div>
                    </form>
                    </div>
            	</div>
            </div>
        </div>
    </div>
</div>
@endsection