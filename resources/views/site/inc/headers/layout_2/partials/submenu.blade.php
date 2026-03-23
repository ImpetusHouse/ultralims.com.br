<ul class="hidden pl-4">
    @foreach ($submenus as $submenu)
        <li class="mb-1">
            @if ($submenu->type != 'menu')
                <a class="block p-4 text-sm font-semibold menu-item-mobile" style="color: {{ $menu->item_color_scroll }}" href="{{ $submenu->type == 'link' ? $submenu->link : '/' . ($submenu->page->prefix_slug->count() > 0 ? implode('/', $submenu->page->prefix_slug->pluck('slug')->toArray()) . '/' . $submenu->page->slug : $submenu->page->slug) }}">{{ $submenu->title }}</a>
            @else
                <span class="flex justify-between items-center p-4 text-sm font-semibold cursor-pointer menu-item-mobile" style="color: {{ $menu->item_color_scroll }}" onclick="$(this).next().slideToggle(); $(this).children('.menu-arrow').toggleClass('rotate')">
                    {{ $submenu->title }}
                    <svg class="menu-arrow h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </span>
                @include('site.inc.headers.layout_2.partials.submenu', ['submenus' => $submenu->itemsMenu->sortBy('display_order')])
            @endif
        </li>
    @endforeach
</ul>
