@if($lastImage)
    <div class="widget">
        <div class="title">
            <h4>Новое изображение</h4>
        </div>
        <div class="ads_widget clearfix">
            <a href="{{ $lastImage->url }}">
                <img src="{{ $lastImage->image }}" alt="{{ $lastImage->getAltImage() }}">
            </a>
        </div><!-- widget -->
        <a href="/{{ $lastImage->url }}">{{ $lastImage->h1 }}</a>
    </div><!-- widget -->
@endif