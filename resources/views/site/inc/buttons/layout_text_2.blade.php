@php
    $url = '';
    $onclick = '';

    $type = isset($buttonOne) ? $item->button_type_1 : $item->button_type;
    $link = isset($buttonOne) ? $item->button_link_1 : $item->button_link;
    $title = isset($buttonOne) ? $item->button_title_1 : $item->button_title;
    $bg = isset($buttonOne) ? $item->button_color_1 : $item->button_color;

    if ($type == 'inner_page') {
        $page = \App\Models\Pages\Page::where('id', $link)->first();
        if ($page != null){
            if ($page->prefix_slug->count() > 0) {
                $url .= implode('/', $page->prefix_slug->pluck('slug')->toArray()) . '/';
            }
            $url = '/' . $url . $page->slug;
        }
    } elseif ($type == 'link') {
        $url = $link;
    } elseif ($type == 'cta'){
        $url = 'javascript:void(0);';
        $onclick = 'onclick="scrollToCta()"';
    }
@endphp
<a class="flex items-center gap-2 group" href="{{ $url }}" {!! $type == 'inner_page' || $type == 'cta' ? '' : 'target="_blank"' !!} {!! $onclick !!}>
    <div class="group-hover:text-opacity-70 transition duration-200" style="color: {{ $bg }};">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewbox="0 0 20 20" fill="currentColor">
            <path d="M4.16699 10H15.8337" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M16.6663 10C16.6664 10.0826 16.6508 10.1643 16.6203 10.2406C16.5898 10.3169 16.545 10.3862 16.4886 10.4445L11.8685 15.2326C11.7548 15.3504 11.6005 15.4167 11.4396 15.4167C11.2787 15.4167 11.1244 15.3504 11.0107 15.2326C10.8969 15.1147 10.833 14.9548 10.833 14.7881C10.833 14.6214 10.8969 14.4615 11.0107 14.3436L15.2019 10L11.0107 5.65641C10.8969 5.53853 10.833 5.37864 10.833 5.21193C10.833 5.04522 10.8969 4.88533 11.0107 4.76745C11.1244 4.64957 11.2787 4.58334 11.4396 4.58334C11.6005 4.58334 11.7547 4.64956 11.8685 4.76745L16.4886 9.55554C16.545 9.61384 16.5898 9.68312 16.6203 9.75939C16.6508 9.83567 16.6664 9.91744 16.6663 10Z" fill="currentColor"></path>
        </svg>
    </div>
    <span class="text-sm font-medium group-hover:text-opacity-70 transition duration-200" style="color: {{ $bg }};">{{ $title }}</span>
</a>
