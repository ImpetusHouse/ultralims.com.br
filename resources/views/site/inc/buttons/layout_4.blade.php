@php
    $url = '';
    $onclick = '';

    $type = isset($buttonOne) ? $item->button_type_1 : $item->button_type;
    $link = isset($buttonOne) ? $item->button_link_1 : $item->button_link;
    $title = isset($buttonOne) ? $item->button_title_1 : $item->button_title;
    $color = isset($buttonOne) ? $item->button_title_color_1 : $item->button_title_color;
    $bg = isset($buttonOne) ? $item->button_color_1 : $item->button_color;
    $border = isset($buttonOne) ? $item->button_border_color_1 : $item->button_border_color;

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
<style>
    #button-{{ $item->id }}{{ $item->block_id ? '-'.$item->block_id :'' }}:hover{
        background-color: {{ $border }}!important;
    }
</style>
<a href="{{ $url }}" {!! $type == 'inner_page' || $type == 'cta' ? '' : 'target="_blank"' !!} {!! $onclick !!}
    id="button-{{ $item->id }}{{ $item->block_id ? '-'.$item->block_id :'' }}"
    class="{{ $wfull ?? '' }} block-button-title h-14 rounded-full px-5 py-3 inline-flex items-center justify-center gap-2 tracking-tight transition duration-200"
    style="background-color: {{ $bg }};">
    <span class="text-sm font-semibold tracking-tight" style="color: {{ $color }}">{{ $title }}</span>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewbox="0 0 16 16" fill="none">
        <path d="M14 6.66669H7.33333C4.38781 6.66669 2 9.0545 2 12V13.3334M14 6.66669L10 10.6667M14 6.66669L10 2.66669" stroke="{{ $color }}" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
    </svg>
</a>
