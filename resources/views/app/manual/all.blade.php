@extends('app.layout')

@section('meta_title', $siteSettingModel->getValue('meta_title_for_manuals'))
@section('meta_description', $siteSettingModel->getValue('meta_description_for_manuals'))

@section('content')
    <div class="page-content" xmlns="http://www.w3.org/1999/html">
        <div class="row clearfix">
            <div class="grid_12 alpha">
                @include('app.breadcrumb.index',['breadcrumbs' => $breadcrumbs])
                <div class="grid_9 alpha posts">
                    <h1>Гайды</h1>
                    @foreach($models as $model)
                        <span class="grid_3 toptip" original-title="{{ $model->getH1() }}">
                            <a class="image_hover gaidi_image" style="background-image: url('/uploads/{{ $model->image }}')" href="{{ $model->url }}">
                                <!-- <img src="/uploads/{{ $model->image }}" alt="{{ $model->getAltImage() }}"> -->
                            </a>
                            <a class="image_hover" href="{{ $model->url }}">
                                {{ $model->getH1() }}
                            </a>
                        </span>
                    @endforeach
                    {{ $models->links() }}
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