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
<a class="inline-flex items-center gap-3 group mr-auto" href="{{ $url }}" {!! $type == 'inner_page' || $type == 'cta' ? '' : 'target="_blank"' !!}
    {!! $onclick !!}>
    <span class="font-semibold group-hover:opacity-70 tracking-tight transition duration-200" style="color: {{ $bg }};">{{ $title }}</span>
    <div class="w-6 h-6 rounded-full border group-hover:opacity-70 transition duration-200 flex items-center justify-center" style="border-color: {{ $bg }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewbox="0 0 12 12" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M6 1L5.2825 1.6965L9.086 5.5H1V6.5H9.086L5.293 10.293L6 11L11 6L6 1Z" fill="{{ $bg }}"></path>
        </svg>
    </div>
</a>
