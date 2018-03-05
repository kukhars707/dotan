@extends('app.layout')

@section('content')
    <div class="page-content errorpage">
        <div class="row clearfix">
            <div class="grid_6">
                <img src="{{ asset('images/404.jpg')}}" alt="">
            </div>
            <div class="grid_6">
                <h2 class="mts mb"> Страница не найдена
                    <small> Страницу которую вы пытаетесь найти нет.</small>
                </h2>
                <a href="/" class="tbutton medium"><span><i
                                class="fa-arrow-left mi"></i> Назад на главную</span></a>
            </div>
        </div><!-- /row -->
    </div><!-- /end page content -->
@stop