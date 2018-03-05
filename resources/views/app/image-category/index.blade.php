@extends('app.layout')

@section('meta_title', $model->meta_title)
@section('meta_description', $model->meta_description)

@section('content')
    <div class="page-content" xmlns="http://www.w3.org/1999/html">
        <div class="row clearfix">
            <div class="grid_12 alpha">
                <div class="grid_8 alpha posts">
                    @include('app.breadcrumb.index',['breadcrumbs' => $breadcrumbs])
                    <h1>{{ $model->getH1() }}</h1>
                    <p>{{ $model->getDescription() }}</p>
                    @foreach($images as $image)
                        <span class="grid_3 toptip" original-title="{{ $image->getH1() }}">
                        <!-- post -->
                            <a class="image_hover" href="{{ $image->url }}">
                                <img src="{{ $image->image }}" alt="{{ $image->getAltImage() }}">
                            </a>
                            <!-- /post -->
                            {{ $image->getH1() }}
                        </span>
                    @endforeach
                    {{ $images->links() }}
                </div><!-- end grid9 -->

                <div class="grid_4 omega sidebar sidebar_b">
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