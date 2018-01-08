@if(session('success'))
    <div class="alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">x</span></button>
        <h4>Success!</h4>
        <p>{{session('success')}}</p>
    </div>
@elseif (session('fail') or !$errors->isEmpty())
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">x</span></button>
        <h4>Error!</h4>
        <p>{{session('fail')}}</p>
    </div>
@endif