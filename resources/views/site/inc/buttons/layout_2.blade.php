@php
    $url = '';
    $onclick = '';

    $type = isset($buttonOne) ? $item->button_type_1 : $item->button_type;
    $link = isset($buttonOne) ? $item->button_link_1 : $item->button_link;
    $title = isset($buttonOne) ? $item->button_title_1 : $item->button_title;
    $color = isset($buttonOne) ? $item->button_title_color_1 : $item->button_title_color;
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
<a href="{{ $url }}" {!! $type == 'inner_page' || $type == 'cta' ? '' : 'target="_blank"' !!} class="{{ $wfull ?? '' }} block-button-title inline-block mb-3 lg:mb-0 lg:mr-3 w-full lg:w-auto py-2 px-6 leading-loose hover:opacity-70 font-semibold rounded-l-xl rounded-t-xl transition duration-200" {!! $onclick !!} style="color: {{ $color }}; background-color: {{ $bg }}">{{ $title }}</a>
