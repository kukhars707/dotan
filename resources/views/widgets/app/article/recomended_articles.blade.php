@if($articles)
    <div class="related_posts mbf clearfix">
        <div class="title">
            <h4>Рекомендуемые статьи</h4>
        </div>
        <div class="carousel_related">
            @foreach($articles as $article)
                <div class="item">
                    <a href="{{ $article->getUrl() }}">
                        <img class="toptip" src="{{ $article->getImage() }}" alt="#" original-title="{{ $article->getH1() }}">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endif