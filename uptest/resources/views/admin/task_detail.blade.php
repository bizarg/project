@extends('admin.layouts.admin')

@section('content')



    <div class="col-md-10">
        <div class="row" >
            <div class="form-group">
                <label class="col-sm-2 control-label">Main url</label>
                <div class="col-sm-3">{{ $task->main_url }}</div>
            </div><br>
            <div class="form-group">
                <label class="col-sm-2 control-label">Status</label>
                <div class="col-sm-3">{{ $task->status }}</div>
            </div><br>
            <div class="form-group">
                <label class="col-sm-2 control-label">Type</label>
                <div class="col-sm-3">{{ $task->type }}</div>
            </div><br>
            <div class="form-group">
                <label class="col-sm-2 control-label">Intensity</label>
                <div class="col-sm-3">{{ $task->intensity }}</div>
            </div><br>

            <div class="form-group">
                <label class="col-sm-2 control-label">Intensity step</label>
                <div class="col-sm-3">{{ $task->intensity_step }}</div>
            </div><br>
            <div class="form-group">
                <label class="col-sm-2 control-label">Intensity max</label>
                <div class="col-sm-3">{{ $task->intensity_max }}</div>
            </div>

        </div>



        <table class="table table-striped">
            <thead>
            <tr>
                <td>#</td>
                <td>users send</td>
                <td>work time</td>
                <td>download time</td>
                <td>traff download</td>
                <td>codes</td>
                {{--`id`, `task_id`, `users_send`, `users_request`, `all_request`, `work_time`, `codes_requests`, `created_at`, `updated_at`, `num`, `speed_upload`, `speed_download`, `upload_time`, `download_time`, `traff_download`, `traff_upload`--}}
            </tr>
            </thead>
            @foreach ($reports as $report)
                <tr>
                    <td>{{ $report->num }}</td>
                    <td>{{ $report->users_send }}</td>
                    <td>{{ $report->work_time }}</td>
                    <td>{{ $report->download_time }}</td>
                    <td>{{ $report->traff_upload }}</td>
                    <td>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <td>code</td>
                                <td>count</td>
                            </tr>
                            </thead>
                            @foreach($report->codes_requests as $k=>$v )
                                <tr>
                                    <td>{{ $k }}</td>
                                    <td>{{ $v }}</td>
                                </tr>
                            @endforeach
                        </table>

                    </td>
                </tr>
            @endforeach
        </table>
    </div>

@endsection