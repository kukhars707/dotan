<ul id="breadcrumb">
    <li>
        <a href="/">Главная</a>
    </li>
    @if($breadcrumbs)
        @foreach($breadcrumbs as $breadcrumb)
            <li>
                @if($breadcrumb['url'] || (isset($breadcrumb['withCategory']) && $breadcrumb['withCategory'] == true))
                    {{ link_to(url($breadcrumb['url']), $breadcrumb['title']) }}
                @else
                    {{ $breadcrumb['title'] }}
                @endif
            </li>
        @endforeach
    @endif
</ul>