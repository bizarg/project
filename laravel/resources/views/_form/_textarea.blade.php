<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    <label for="{{ $name }}" class="col-md-4 control-label">{{ ucfirst($name) }}</label>

    <div class="col-md-6">
        <textarea id="{{ $name }}"  rows="10" class="form-control" name="{{ $name }}">@if(isset(${$model})){{ ${$model}[$name] }}@else{{ old($name) }}@endif</textarea>
        @if ($errors->has($name))
            <span class="help-block">
                        <strong>{{ $errors->first($name) }}</strong>
                </span>
        @endif
    </div>
</div>