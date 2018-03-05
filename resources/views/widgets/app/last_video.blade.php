@if($lastVideo)
    <div class="widget">
        <div class="title"><h4>Последнее видео</h4></div>
        <a href="/{{ $lastVideo->url }}">
            <img src="{{ $lastVideo->image }}" alt="{{ $lastVideo->getAltImage() }}">
        </a>
        <a href="/{{ $lastVideo->url }}">{{ $lastVideo->h1 }}</a>
    </div><!-- widget -->
@endif