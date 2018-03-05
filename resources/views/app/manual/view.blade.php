@extends('app.layout')

@section('meta_title', $model->meta_title)
@section('meta_description', $model->meta_description)

@section('content')
    <div class="page-content">
        <div class="row clearfix">
            <div class="grid_12 alpha">
                <div class="grid_9 alpha posts">
                    <div class="single_post mbf clearfix">
                        @include('app.breadcrumb.index',['breadcrumbs' => $breadcrumbs])
                        <h1 class="single_title">{{ $model->getH1() }}</h1>
                        <div class="meta mb"> добавилено
                            {{ LocalizedCarbon::instance($model->created_at)->diffForHumans() }}
                        </div>
                        {!! $model->text !!}
                    </div><!-- /single post -->
                    {{--<div class="share_post mbf clearfix">--}}
                    {{--<span> Share </span>--}}
                    {{--<div class="socials clearfix">--}}
                    {{--<img src="images/assets/share.png" alt="">--}}
                    {{--</div><!-- /socials -->--}}
                    {{--</div><!-- /share -->--}}

                    {{--<div class="author_post mbf clearfix">--}}
                    {{--<div class="title"><h4>About Alexander</h4></div>--}}
                    {{--<div class="author_co clearfix">--}}
                    {{--<img src="images/assets/avatar1.jpg" alt="">--}}
                    {{--<p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem</p><p>--}}
                    {{--</p><div class="social">--}}
                    {{--<a href="#" class="toptip" original-title="Twitter"><i class="fa-twitter"></i></a>--}}
                    {{--<a href="#" class="toptip" original-title="Facebook"><i class="fa-facebook"></i></a>--}}
                    {{--<a href="#" class="toptip" original-title="Google Plus"><i class="fa-google-plus"></i></a>--}}
                    {{--<a href="#" class="toptip" original-title="Dribbble"><i class="fa-dribbble"></i></a>--}}
                    {{--</div><!-- /social -->--}}
                    {{--</div><!-- /author co -->--}}
                    {{--</div><!-- /author -->--}}

                    {{--<div class="posts_links mbf clearfix">--}}
                    {{--@if(isset($otherModels[0]))--}}
                    {{--<a class="grid_6 lefter relative" href="{{ $otherModels[0]->url }}">--}}
                    {{--<i class="icon-chevron-left"></i>--}}
                    {{--<small> Предыдущая:</small>--}}
                    {{--<span> {{ $otherModels[0]->h1 }} </span>--}}
                    {{--</a><!-- /grid_6 -->--}}
                    {{--@endif--}}
                    {{--@if(isset($otherModels[1]))--}}
                    {{--<a class="grid_6 righter tar relative" href="{{ $otherModels[1]->url }}">--}}
                    {{--<i class="icon-chevron-right"></i>--}}
                    {{--<small> Следующая:</small>--}}
                    {{--<span> {{ $otherModels[1]->h1 }} </span>--}}
                    {{--</a><!-- /grid_6 -->--}}
                    {{--@endif--}}
                    {{--</div><!-- /posts links -->--}}

                    {{--<div class="disqus_comments">--}}
                    {{--<!-- Disqus Comment Form -->--}}
                    {{--<div id="disqus_thread"></div>--}}
                    {{--<script type="text/javascript">--}}
                    {{--/* <![CDATA[ */--}}
                    {{--var disqus_shortname = 'officialtemplate';--}}
                    {{--(function () {--}}
                    {{--var dsq = document.createElement('script');--}}
                    {{--dsq.type = 'text/javascript';--}}
                    {{--dsq.async = true;--}}
                    {{--dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';--}}
                    {{--(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);--}}
                    {{--})();--}}
                    {{--/* ]]> */--}}
                    {{--</script>--}}
                    {{--<noscript>Please enable JavaScript to view the &lt;a href="http://disqus.com/?ref_noscript"&gt;comments--}}
                    {{--powered by Disqus.&lt;/a&gt;</noscript>--}}
                    {{--<!-- Disqus Comment Form -->--}}
                    {{--</div><!-- /comments -->--}}
                </div><!-- end grid8 -->
                <div class="grid_3 omega sidebar sidebar_b">
                    <!-- LAST VIDEO -->
                @widget('lastVideo')
                <!-- LAST VIDEO /-->
                    <!-- NEW IMAGE -->
                @widget('newImage')
                <!-- NEW IMAGE /-->
                </div><!-- end grid8 -->
            </div><!-- end grid9 -->

            <!-- /grid3 sidebar A -->
        </div><!-- /row -->
    </div>
@stop