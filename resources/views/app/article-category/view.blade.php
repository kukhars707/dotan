@extends('app.layout')

@section('meta_title', $model->meta_title)
@section('meta_description', $model->meta_description)

@section('content')
    <div class="page-content" xmlns="http://www.w3.org/1999/html">
        <div class="row clearfix">
            <div class="grid_12 alpha">
                <div class="grid_9 alpha posts">
                    @include('app.breadcrumb.index',['breadcrumbs' => $breadcrumbs])
                    <h1>{{ $model->getH1() }}</h1>
                    <p>{{ $model->getDescription() }}</p>
                    @foreach($articles as $article)
                        <span class="grid_3 toptip" original-title="{{ $article->getH1() }}">
                            <a class="image_hover" href="{{ $article->url }}">
                                <img src="{{ $article->image }}" alt="{{ $article->getAltImage() }}">
                            </a>
                            {{ $article->getH1() }}
                        </span>
                    @endforeach
                    {{ $articles->links() }}
                </div><!-- end grid9 -->

                <div class="grid_3 omega sidebar sidebar_b">
                    <!-- LAST VIDEO -->
                @widget('lastVideo')
                <!-- LAST VIDEO /-->
                    <!-- NEW IMAGE -->
                @widget('newImage')
                <!-- NEW IMAGE /-->
                </div><!-- end grid9 -->
            </div><!-- end grid9 -->
            <!-- /grid3 sidebar A -->
        </div><!-- /row -->
    </div>
@stop