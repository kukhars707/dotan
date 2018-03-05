<div class="grid_4 alpha posts">
    <div class="posts_block mbf clearfix">
        <div class="title">
            <h4>Последние статьи</h4>
        </div>

        <ul class="small_posts">
            @foreach($lastArticles as $lastArticle)
                <li class="clearfix">
                    <a class="s_thumb image_hover" href="{{ $lastArticle->url }}">
                        <img width="70" height="70" src="uploads/{{ $lastArticle->image }}" alt="{{ $lastArticle->getAltImage() }}">
                    </a>
                    <h3>
                        <a href="{{ $lastArticle->url }}">{{ $lastArticle->h1 }}</a>
                    </h3>
                    <div class="meta mb">
                        {{ LocalizedCarbon::instance($lastArticle->created_at)->diffForHumans() }} /
                        <a href="{{ $lastArticle->url }}">1 коммент</a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div><!-- /posts block People -->
</div><!-- /grid4 -->