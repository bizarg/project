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