@extends('layouts.main')

@section('content')
    <h3 class="dash_title">Seo</h3>
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger" role="alert">{{ $error }}</div>
    @endforeach

    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s3"><a href="#test1">HTML файл</a></li>
                <li class="tab col s3"><a href="#test2">Мета-тэг</a></li>
            </ul>
        </div>
        <div id="test1" class="col s12">
            <ul class="collection mt">
                <li class="collection-item red-text text-accent-1">В настоящий момент права не подтверждены</li>
                <li class="collection-item">1. Создайте html-файл со следующим именем</li>
                <li class="collection-item"><span class="light-green-text text-darken-1">{{ $info }}.html</span> и содержим {{ $info }}</li>
                <li class="collection-item">2. Загрузите его в корневой каталог вашего сайта</li>
                <li class="collection-item">3. Убедитесь, что загруженный файл открывается по адресу <br/>
                    <a target="_blank" href="http://{{ $domain->domain }}/{{ $info }}.html">http://{{ $domain->domain }}/{{ $info }}.html</a>
                    <br/> или если ваш сайт использует SSL сертификат <br/>
                    <a target="_blank" href="https://{{ $domain->domain }}/{{ $info }}.html">https://{{ $domain->domain }}/{{ $info }}.html</a>
                </li>
                <li class="collection-item">4. Нажмите на кнопку &laquo;Проверить&raquo;</li>
            </ul>
        </div>
        <div id="test2" class="col s12">
            <ul class="collection mt">
                <li class="collection-item red-text text-accent-1">В настоящий момент права не подтверждены</li>
                <li class="collection-item">1. Добавьте в код главной страницы вашего сайта (в раздел head) мета-тэг</li>
                <li class="collection-item"><span class="light-green-text text-darken-1">&lt;meta name='siteorg-verification' content='{{ $info }}' /&gt;</span></li>
                <li class="collection-item">2. Зайдите на главную страницу сайта и убедитесь, что мета-тэг появился в html-коде страницы. В большинстве браузеров это можно сделать выбрав пункт &quot;Исходный код страницы&quot; в контекстном меню. На некоторых сайтах обновление мета-тэгов может занимать несколько минут!</li>
                <li class="collection-item">3. Нажмите на кнопку &laquo;Проверить&raquo;</li>
            </ul>
        </div>

    </div>

    <a class="btn  light-green darken-1" href="{{  url('confirm',$id) }}">Проверить</a>

@endsection