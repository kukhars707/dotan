@extends('app.layout')

@section('meta_title', $siteSettingModel->getValue('meta_title_for_articles'))
@section('meta_description', $siteSettingModel->getValue('meta_description_for_articles'))

@section('content')
    <div class="page-content">
        <div class="row clearfix">
            <div class="grid_12 alpha">
                @include('app.breadcrumb.index',['breadcrumbs' => $breadcrumbs])
                <div class="grid_9 alpha posts">
                    <h1>Статьи</h1>
                @foreach($models as $model)
                    <!-- post -->
                        <div class="post_day mbf clearfix">
                            <div class="grid_6 alpha relative">
                                <a class="image_hover stati_image" style="background-image: url('{{ $model->image }}')" href="{{ $model->url }}">
                                    <!-- <img src="{{ $model->image }}" alt="{{ $model->getAltImage() }}"> -->
                                </a>
                            </div><!-- /grid6 alpha -->
                            <div class="grid_6 omega">
                                <div class="post_day_content">
                                    <h3>
                                        <a href="{{ $model->url }}">{{ $model->h1 }}</a>
                                    </h3>
                                    <div class="meta mb"> {{ LocalizedCarbon::instance($model->created_at)->diffForHumans() }}
                                        <!-- / -->
                                        <!-- <a href="{{ $model->url }}">0 comments</a> -->
                                    </div>
                                    <p> Lorem Ipsum is simply dummy text of the printing and typesetting industry
                                        unknown printer took a galley of type and scrambled it to make a type has
                                        survived not only fiv... </p>
                                </div><!-- /post content -->
                            </div><!-- /grid6 omega -->
                        </div><!-- /post day -->
                        <!-- /post -->
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
                </div>
            </div><!-- end grid9 -->

            <!-- /grid3 sidebar A -->
        </div><!-- /row -->
    </div>



@stop