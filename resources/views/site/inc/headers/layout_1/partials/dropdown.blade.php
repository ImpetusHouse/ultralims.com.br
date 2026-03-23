<ul class="py-1">
    @foreach ($submenus as $submenu)
        @if ($submenu->type != 'menu')
            <li>
                <a class="block px-4 py-3 text-xs font-semibold menu-item menu-bg" style="color: {{ $menu->item_color }}" href="{{ $submenu->type == 'link' ? $submenu->link : '/' . ($submenu->page->prefix_slug->count() > 0 ? implode('/', $submenu->page->prefix_slug->pluck('slug')->toArray()) . '/' . $submenu->page->slug : $submenu->page->slug) }}">{{ $submenu->title }}</a>
            </li>
        @else
            <li class="relative">
                <span class="block px-4 py-3 text-xs font-semibold menu-item menu-bg cursor-pointer"
                      @if($item_menu->menu_with_link) onclick="location.href = '{{ $submenu->menu_with_link_type == 'link' ? $submenu->link : '/' . ($submenu->page->prefix_slug->count() > 0 ? implode('/', $submenu->page->prefix_slug->pluck('slug')->toArray()) . '/' . $submenu->page->slug : $submenu->page->slug) }}'" @endif
                      style="color: {{ $menu->item_color }}">
                    {{ $submenu->title }}
                </span>
                <div class="submenu absolute hidden shadow {{ env('APP_NAME') == 'Ultra Lims' ? '':'shadow-blueGray-900' }} w-40 rounded-lg" style="background-color: {{ $menu->background_color }}; left: 100%; top: 0;">
                    @include('site.inc.headers.layout_1.partials.dropdown', ['submenus' => $submenu->itemsMenu->sortBy('display_order')])
                </div>
            </li>
        @endif
    @endforeach
</ul>
