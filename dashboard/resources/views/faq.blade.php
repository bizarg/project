@extends('layouts.main')

@section('content')
    <h3 class="dash_title">Help</h3>
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">{{ $error }}</div>
    @endforeach
    <div class="settings">
        <div class="row">
            <form class="col s12" method="post" action="{{ url('domain/add') }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="myTitle">Как пользоваться dashboard?</div>
                    <ol>
                        <li>Наведите курсором на значок «шестерёнки» <img src="img/img1.png" alt="Settings"> и нажмите “Add domain”, чтобы добавить новый домен на мониторинг.</li>
                        <li>Перед вами откроется окно для добавления Вашего домена.<br><img src="img/img2.png" style="width:100%" alt="Domain"></li>
                        <li>Теперь Вам необходимо подтвердить, что вы являетесь владельцем данного сайта. Нажмите на кнопку “Confirm”.<img src="img/img3.png" style="width:100%" alt="Domain"></li>
                        <li>Перед Вами откроется окно для подтверждения Ваших прав. Создайте html-файл или добавьте мета-тэг, а затем проверьте работоспособность ресурса.<br>
                            <img src="img/img4.png" style="width:100%" alt="Domain"></li>
                        <li>Поздравляем! Вы попали на страницу мониторинга ресурса.<br>
                            <img src="img/img5.png" style="width:100%" alt="Domain">
                            <ul>
                                <li>- Разноцветная инфографика имеет 4 цвета по скорости загрузки сайта:</li>
                                <li><=1 cек. – зеленый.</li>
                                <li>1-2  сек. – желтый.</li>
                                <li>2-3  сек. – красный.</li>
                                <li>>3   сек. – черный.</li>
                                <li>- При нажатии на Яндекс/Гугл/Алекса “dashboard” показывает более подробную информацию о текущем рейтинге сайта в количестве проиндексированных страниц гугла/яндекса и алекса ранка.</li>
                                <li>- Гибкая система уведомлений оповестит Вас о конкретной проблеме.</li>
                            </ul>
                        </li>
                        <li>Нажмите на разноцветную инфографику для просмотра подробной информации о мониторинге ресурса по параметрам:
                            <ul>
                                <li>- Время загрузки сайта</li>
                                <li>- Посетители</li>
                                <li>- Ошибки в течение последнего месяца.</li>
                            </ul>
                        </li>
                    </ol>
                </div>
            </form>
        </div>

    </div>
@endsection