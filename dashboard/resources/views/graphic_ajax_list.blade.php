<div class="row">
    @foreach($data as $graph)
        <div class="col s12">
            <div class="card">
                <div class="card-image center">
                    <img src="{{ route("graphics.graphic_img") }}?graph_id={{ $graph->graphid }}&width={{ $graph->width }}&height={{ $graph->height }}"
                         alt="{{ $graph->name }}" class="responsive-img bm_graph_img">
                    <div class="loading">
                        <div class="preloader-wrapper big active">
                            <div class="spinner-layer spinner-blue">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div>
                                <div class="gap-patch">
                                    <div class="circle"></div>
                                </div>
                                <div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                            <div class="spinner-layer spinner-red">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div>
                                <div class="gap-patch">
                                    <div class="circle"></div>
                                </div>
                                <div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                            <div class="spinner-layer spinner-yellow">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div>
                                <div class="gap-patch">
                                    <div class="circle"></div>
                                </div>
                                <div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                            <div class="spinner-layer spinner-green">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div>
                                <div class="gap-patch">
                                    <div class="circle"></div>
                                </div>
                                <div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-content">
                    <span class="card-title">{{ $graph->name }}</span>
                </div>
                {{--<div class="card-action">
                    <a href="{{ route("graphics.graphic_img") }}?graph_id={{ $graph->graphid }}" target="_blank" class="waves-effect waves-light btn">Open full width</a>
                </div>--}}
            </div>
        </div>
    @endforeach
</div>