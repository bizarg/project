{{--<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">--}}
    {{--<label for="{{ $name }}" class="col-md-4 control-label">{{ ucfirst($name) }}</label>--}}
    {{--<div class="col-md-6">--}}
        {{--<select multiple="multiple" id="{{ $name }}" class="form-control" name="{{ $name }}[]">--}}
            {{--@foreach($models as $model)--}}
                {{--<option value="{{ $model->id }}">{{ $model->name }}</option>--}}
            {{--@endforeach--}}
        {{--</select>--}}
        {{--@if ($errors->has($name))--}}
            {{--<span class="help-block">--}}
                    {{--<strong>{{ $errors->first($name) }}</strong>--}}
                {{--</span>--}}
        {{--@endif--}}
    {{--</div>--}}
{{--</div>--}}

<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    <label for="{{ $name }}" class="col-md-4 control-label">{{ ucfirst($name) }}</label>
    <div class="col-md-6">
        <select multiple="multiple" id="{{ $name }}" class="form-control js-example-basic-multiple" name="{{ $name }}[]">
            @if(isset($arrPivotId))
                @foreach($models as $model)
                    @if(in_array($model->id, $arrPivotId))
                        <option value="{{ $model->id }}" selected>{{ $model->name }}</option>
                    @else
                        <option value="{{ $model->id }}">{{ $model->name }}</option>
                    @endif
                @endforeach
            @else
                @foreach($models as $model)
                    <option value="{{ $model->id }}">{{ $model->name }}</option>
                @endforeach
            @endif
        </select>
        @if ($errors->has($name))
            <span class="help-block">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>