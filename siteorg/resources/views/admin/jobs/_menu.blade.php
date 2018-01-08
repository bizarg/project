<div class="panel panel-default">
    <div class="panel-body">
        <ul class="nav nav-pills">
            <li class="@if(Request::path() == 'admin/jobs'){{ 'active' }}@endif">
                <a href="{{ action('Admin\AdminController@show_jobs') }}">Jobs<span class="badge"> {{ $count_jobs }}</span></a>
            </li>
            <li class="@if(Request::path() == 'admin/failed_jobs'){{ 'active' }}@endif">
                <a href="{{ action('Admin\AdminController@show_failed_jobs') }}">Failed Jobs<span class="badge"> {{ $count_failed_jobs }}</span></a>
            </li>
        </ul>
    </div>
</div>