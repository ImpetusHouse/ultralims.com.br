<style>
    .menu-item:hover {
        color: {{ $menu->item_hover_color }} !important;
        border-color: {{ $menu->item_hover_color }} !important;
    }

    .menu-bg:hover {
        background-color: {{ str_replace(')', ', 0.5)', $menu->background_color) }};
    }

    .menu-arrow {
        transition: transform 0.3s ease;
    }

    .menu-arrow.rotate {
        transform: rotate(180deg);
    }

    /* Estilo padrão do submenu, oculto */
    .submenu {
        display: none;
        position: absolute;
        /* Outros estilos necessários para o posicionamento e a aparência */
    }

    /* Mostrar o submenu quando o pai é focado com o mouse */
    .menu-item:hover + .submenu,
    .menu-item:focus + .submenu,
    .submenu:hover {
        display: block;
    }
</style>
@php
    if (isset($page)){
        if ($page->group){
            $group = $page->group;
        }else{
            $group = \App\Models\Settings\Group_Item_Menu::where('default', true)->first();
        }
    }else{
        $group = \App\Models\Settings\Group_Item_Menu::where('default', true)->first();
    }
    $items_menu = $group->items->where('item_menu_id', null);
@endphp
<header class="{{ env('APP_NAME') == 'iii-INCT' ? 'shadow-blueGray-900':(env('APP_NAME') == 'Ultra Lims' ? 'shadow':'') }}" style="background-color: {{ $menu->background_color }}; position: fixed; top: 0; width: 100%; z-index: 1000;">
    @if(env('APP_NAME') == 'PróLab')
        @include('site.inc.prolab.alert')
    @endif
    <div class="container px-4 mx-auto">
        <nav class="flex items-center py-4">
            <a class="text-3xl font-semibold leading-none" href="/">
                <img style="height: 3rem" src="{{ asset(str_replace('public/', 'storage/', $menu->logo)) }}" alt="{{ env('APP_NAME') }}" width="auto">
            </a>
            <div class="lg:hidden ml-auto">
                <button class="navbar-burger flex items-center py-2 px-3 border rounded menu-item" style="color: {{ $menu->item_color }}; border-color: {{ $menu->item_color }}">
                    <svg class="fill-current h-4 w-4" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <title>Mobile menu</title>
                        <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                    </svg>
                </button>
            </div>
            <ul class="hidden lg:flex items-center {{ env('APP_NAME') == 'PróLab' ? 'space-x-6':'space-x-12 mr-12' }} ml-auto">
                @foreach ($items_menu as $item_menu)
                    @if ($item_menu->type != 'menu')
                        <li>
                            @if(!$item_menu->background)
                                <a class="text-sm font-bold menu-item menu-bg" href="{{ $item_menu->type == 'link' ? $item_menu->link : '/' . ($item_menu->page->prefix_slug->count() > 0 ? implode('/', $item_menu->page->prefix_slug->pluck('slug')->toArray()) . '/' . $item_menu->page->slug : $item_menu->page->slug) }}" style="color: {{ $menu->item_color }}">{{ $item_menu->title }}</a>
                            @else
                                <a class="mr-2 inline-block px-4 py-3 text-xs font-semibold leading-none hover:opacity-70 rounded" href="{{ $item_menu->type == 'link' ? $item_menu->link : '/' . ($item_menu->page->prefix_slug->count() > 0 ? implode('/', $item_menu->page->prefix_slug->pluck('slug')->toArray()) . '/' . $item_menu->page->slug : $item_menu->page->slug) }}" style="color: {{ $item_menu->title_color }}; background-color: {{ $item_menu->background_color }}">{{ $item_menu->title }}</a>
                            @endif
                        </li>
                    @else
                        <li class="relative">
                            <span class="text-sm font-bold menu-item inline-block cursor-pointer menu-bg"
                                  @if($item_menu->menu_with_link) onclick="location.href = '{{ $item_menu->menu_with_link_type == 'link' ? $item_menu->link : '/' . ($item_menu->page->prefix_slug->count() > 0 ? implode('/', $item_menu->page->prefix_slug->pluck('slug')->toArray()) . '/' . $item_menu->page->slug : $item_menu->page->slug) }}'" @endif
                                  style="color: {{ $menu->item_color }}; padding-top: 10px; padding-bottom: 10px">
                                {{ $item_menu->title }}
                            </span>
                            <div class="submenu absolute hidden shadow {{ env('APP_NAME') == 'Ultra Lims' ? '':'shadow-blueGray-900' }} rounded-lg" style="top: 80%; left: -5%; background-color: {{ $menu->background_color }}; width: {{ env('APP_NAME') == 'PróLab' ? '11':'10' }}rem">
                                @include('site.inc.headers.layout_1.partials.dropdown', ['submenus' => $item_menu->itemsMenu->sortBy('display_order')])
                            </div>
                        </li>
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>

    <div class="hidden navbar-menu fixed top-0 left-0 bottom-0 w-5/6 max-w-sm z-50">
        <div class="navbar-backdrop fixed inset-0 bg-blueGray-800 opacity-25"></div>
        <nav class="relative flex flex-col py-6 px-6 w-full h-full overflow-y-auto" style="background-color: {{ $menu->background_color }}">
            <div class="flex items-center mb-8">
                <a class="mr-auto text-3xl font-semibold leading-none" href="/">
                    <img class="h-13" src="{{ asset(str_replace('public/', 'storage/', $menu->logo)) }}" alt="{{ env('APP_NAME') }}" width="auto">
                </a>
                <button class="navbar-close menu-item" style="color: {{ $menu->item_color }}">
                    <svg class="h-6 w-6 cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div>
                <ul>
                    @foreach ($items_menu as $item_menu)
                        @if ($item_menu->type != 'menu' || ($item_menu->menu_with_link && $item_menu->menu_with_link_mobile))
                            <li class="mb-1">
                                @if(!$item_menu->background)
                                    <a class="block p-4 text-sm font-bold menu-item" href="{{ $item_menu->type == 'link' || $item_menu->menu_with_link_type == 'link' ? $item_menu->link : '/' . ($item_menu->page->prefix_slug->count() > 0 ? implode('/', $item_menu->page->prefix_slug->pluck('slug')->toArray()) . '/' . $item_menu->page->slug : $item_menu->page->slug) }}" style="color: {{ $menu->item_color }}">{{ $item_menu->title }}</a>
                                @else
                                    <a class="block px-4 py-3 mb-3 text-xs text-center font-semibold leading-none hover:opacity-70 rounded" href="{{ $item_menu->type == 'link' || $item_menu->menu_with_link_type == 'link' ? $item_menu->link : '/' . ($item_menu->page->prefix_slug->count() > 0 ? implode('/', $item_menu->page->prefix_slug->pluck('slug')->toArray()) . '/' . $item_menu->page->slug : $item_menu->page->slug) }}" style="color: {{ $item_menu->title_color }}; background-color: {{ $item_menu->background_color }}">{{ $item_menu->title }}</a>
                                @endif
                            </li>
                        @else
                            <span class="flex justify-between items-center p-4 text-sm font-semibold cursor-pointer menu-item" style="color: {{ $menu->item_color }}" onclick="$(this).next().slideToggle(); $(this).children('.menu-arrow').toggleClass('rotate')">
                                {{ $item_menu->title }}
                                <svg class="menu-arrow h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </span>
                            @include('site.inc.headers.layout_1.partials.submenu', ['submenus' => $item_menu->itemsMenu->sortBy('display_order')])
                        @endif
                    @endforeach
                </ul>
            </div>
        </nav>
    </div>
</header>

@push('scripts')
    <script>
        window.addEventListener('load', function() {
            var headerHeight = document.querySelector('header').offsetHeight;
            document.body.style.marginTop = headerHeight + 'px';
        });
        // Burger menus
        document.addEventListener('DOMContentLoaded', function() {
            // open
            const burger = document.querySelectorAll('.navbar-burger');
            const menu = document.querySelectorAll('.navbar-menu');

            if (burger.length && menu.length) {
                for (var i = 0; i < burger.length; i++) {
                    burger[i].addEventListener('click', function() {
                        for (var j = 0; j < menu.length; j++) {
                            menu[j].classList.toggle('hidden');
                        }
                    });
                }
            }

            // close
            const close = document.querySelectorAll('.navbar-close');
            const backdrop = document.querySelectorAll('.navbar-backdrop');

            if (close.length) {
                for (var i = 0; i < close.length; i++) {
                    close[i].addEventListener('click', function() {
                        for (var j = 0; j < menu.length; j++) {
                            menu[j].classList.toggle('hidden');
                        }
                    });
                }
            }

            if (backdrop.length) {
                for (var i = 0; i < backdrop.length; i++) {
                    backdrop[i].addEventListener('click', function() {
                        for (var j = 0; j < menu.length; j++) {
                            menu[j].classList.toggle('hidden');
                        }
                    });
                }
            }
        });
    </script>
@endpush
