<nav>
    <ul class="sf-menu">
        <li class="current colordefault home_class">
            <a href="{{ secure_url('/') }}">
                <img src="/images/dotaicon.png" alt="">
            </a>
        </li>
        @foreach($menus as $menu)
            <li class="colordefault">
                <a href="{{ $menu->link }}">{{ $menu->name }}</a>
            </li>
        @endforeach

    </ul><!-- /menu -->
</nav><!-- /nav -->