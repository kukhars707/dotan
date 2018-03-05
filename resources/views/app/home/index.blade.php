@extends('app.layout')

@section('meta_title', $siteSettingModel->getValue('meta_title_for_main'))
@section('meta_description', $siteSettingModel->getValue('meta_description_for_main'))

@section('content')
    <div class="page-content">
        <div class="row clearfix">
            <div class="grid_9 alpha">
                <!-- LAST ARTICLES -->
            @widget('lastArticles')
            <!-- LAST ARTICLES /-->
                <div class="grid_8 omega posts">

                    <div class="posts_block mbf clearfix">
                        <div class="title">
                            <h4>Новые гайды</h4>
                        </div>
                        <div class="grid_6 alpha">
                            @if($lastManual)
                                <div class="mb image_hover" style="position: relative;">
                                    <a href="{{ $lastManual->url }}">
                                        <img src="{{ $lastManual->image }}" alt="{{ $lastManual->getAltImage() }}">
                                    </a>
                                </div>
                                <div class="post_m_content">
                                    <h3>
                                        <a href="{{ $lastManual->url }}">{{ $lastManual->h1 }}</a>
                                    </h3>
                                    <div class="meta mb">
                                        {{ LocalizedCarbon::instance($lastManual->created_at)->diffForHumans() }}
                                    </div>
                                    <p> {{ $stringHelper->getStringWithLimit($lastManual->text) }} </p>
                                </div><!-- post content -->
                            @endif
                        </div><!-- grid6 omega -->

                        <div class="grid_6 omega">
                            <div class="small_slider_travel owl-carousel owl-theme">
                                @foreach($manuals as $manual)
                                    @if($stringHelper->checkIteration($loop->iteration, 'open'))
                                        <div class="item clearfix">
                                            <ul class="small_posts">
                                    @endif
                                        <li class="clearfix">
                                            <a class="s_thumb image_hover" href="{{ $manual->url }}">
                                                <img width="70" height="70" src="/uploads/{{ $manual->image }}" alt="{{ $manual->getAltImage() }}">
                                            </a>
                                            <h3>
                                                <a href="{{ $manual->url }}">{{ $manual->h1 }}</a>
                                            </h3>
                                            <div class="meta mb">
                                                {{ LocalizedCarbon::instance($manual->created_at)->diffForHumans() }}
                                            </div>
                                        </li>
                                        @if($stringHelper->checkIteration($loop->iteration, 'close') || $loop->last)
                                                </ul>
                                            </div>
                                        @endif
                                @endforeach
                            </div>
                        </div><!-- grid6 omega -->
                    </div><!-- posts block Travel -->

                </div><!-- /grid8 -->
            </div><!-- /grid9 -->

            <div class="grid_3 omega sidebar sidebar_a">
                <!-- LAST VIDEO -->
                    @widget('lastVideo')
                <!-- LAST VIDEO /-->
                <!-- NEW IMAGE -->
                    @widget('newImage')
                <!-- NEW IMAGE /-->
            </div><!-- /grid3 sidebar -->
        </div><!-- /row -->
    </div><!-- /end page content -->
@stop