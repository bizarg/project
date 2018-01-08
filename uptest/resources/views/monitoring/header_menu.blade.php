<div class="row">
    <ul class="nav nav-tabs">
        <li class="{{ Request::is('monitoring') ? ' active' : null }}"><a href="{{ url('monitoring') }}"><i
                        class="fa fa-cloud"></i>&nbsp;&nbsp;Сайты</a></li>
        {{--<li class="{{ Request::is('task/new*') ? ' active' : null }}">--}}
            {{--<a href="{{ url('/task/new') }}"><i class="fa fa-cloud-download"></i>&nbsp;&nbsp;Добавить тест</a>--}}
        {{--</li>--}}
        {{--<li class="{{ Request::is('domains') ? ' active' : null }}"><a href="{{ url('/domains') }}"><i--}}
                        {{--class="fa fa-plus"></i>&nbsp;&nbsp;Домены</a></li>--}}
        <li class="{{ Request::is('balance') ? ' active' : null }}"><a href="{{ url('/balance') }}"><i
                        class="fa fa-usd"></i>&nbsp;&nbsp;Баланс</a></li>
        {{--<li class="pull-right"><a ui-sref="root.profile"><i class="fa fa-user"></i>&nbsp;&nbsp;Профиль</a></li>--}}
        {{--<li class="pull-right"><a ui-sref="root.settings"><i class="fa fa-gear"></i>&nbsp;&nbsp;Настройки</a></li>--}}

        {{--<li class="pull-right"><a ui-sref="admin.users"><i class="fa fa-users"></i>&nbsp;&nbsp;Пользователи</a></li>--}}
        {{--<li class="pull-right"><a ui-sref="admin.posts"><i class="fa fa-file"></i>&nbsp;&nbsp;Страницы</a></li>--}}
    </ul>
</div>