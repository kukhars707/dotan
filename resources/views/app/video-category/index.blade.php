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
                    @foreach($items as $item)
                        <span class="grid_3 toptip" original-title="{{ $item->getH1() }}">
                        <!-- post -->
                            <a class="image_hover" href="{{ $item->url }}">
                                <img src="{{ $item->image }}" alt="{{ $item->getAltImage() }}">
                            </a>
                            <!-- /post -->
                            {{ $item->getH1() }}
                        </span>
                    @endforeach
                    {{ $items->links() }}
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