@php
    $url = '';
    /** @var TYPE_NAME $card */
    if ($card->type == 'page') {
        $page = \App\Models\Pages\Page::where('id', $card->page_id)->first();
        if ($page != null){
            if ($page->prefix_slug->count() > 0) {
                $url .= implode('/', $page->prefix_slug->pluck('slug')->toArray()) . '/';
            }
            $url = '/' . $url . $page->slug;
        }
    } elseif ($card->type == 'link') {
        $url = $card->link;
    } elseif($card->type == 'file'){
        $url = asset(str_replace('public/', 'storage/', $card->file));
    } elseif($card->type == 'modal'){
        $url = nl2br($card->modal_description);
    }

    $card->description = str_replace('<h2', '<h2 class="mb-2 text-lg md:text-xl font-semibold text-[#00268A]"', $card->description);
    $card->description = str_replace('<h3', '<h3 class="mb-2 text-md md:text-lg font-semibold text-[#00268A]"', $card->description);
    $card->description = str_replace('<h4', '<h4 class="mb-2 text-sm md:text-md font-semibold text-[#00268A]"', $card->description);
    $card->description = str_replace('<strong', '<strong class="text-[#00268A] font-black"', $card->description);
    $card->description = str_replace('<a', '<a class="text-blue-600"', $card->description);
@endphp
<div class="w-full md:w-1/4 md:p-8">
    <div class="flex flex-wrap -m-3 py-4 md:py-0 lg:py-0 {{ $card->type != null ? 'cursor-pointer':'' }}" onclick="cardClick('{{ $url }}', '{{ $card->type }}')">
        <div class="w-auto md:w-full lg:w-auto {{ $card->type == null || $card->type == 'modal' ? 'h-full':'' }} p-3">
            <div class="flex items-center justify-center {{ $card->type == null || $card->type == 'modal' ? 'h-8 w-1':'w-8 h-8' }} rounded" style="background-color: {{ env('APP_NAME') == 'AABB-SP' ? '#3499F6':$block->pdf_color }};">
                @if($card->type == 'link' || $card->type == 'page')
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.9236 0.617689C13.8477 0.435158 13.7195 0.279143 13.5552 0.169245C13.3908 0.0593462 13.1977 0.000465607 12.9999 0L2.8775 0C2.61223 0 2.35783 0.105378 2.17025 0.292953C1.98268 0.480527 1.8773 0.734932 1.8773 1.0002C1.8773 1.26547 1.98268 1.51988 2.17025 1.70745C2.35783 1.89503 2.61223 2.0004 2.8775 2.0004H10.5859L0.293412 12.2929C0.105543 12.4807 0 12.7355 0 13.0012C0 13.2669 0.105543 13.5217 0.293412 13.7096C0.48128 13.8974 0.736084 14.003 1.00177 14.003C1.26746 14.003 1.52226 13.8974 1.71013 13.7096L11.9997 3.41429V11.1226C11.9997 11.3879 12.1051 11.6423 12.2927 11.8299C12.4803 12.0175 12.7347 12.1229 12.9999 12.1229C13.2652 12.1229 13.5196 12.0175 13.7072 11.8299C13.8948 11.6423 14.0002 11.3879 14.0002 11.1226V1.0002C14.0002 0.86889 13.9742 0.738871 13.9236 0.617689Z" fill="white"/>
                    </svg>
                @elseif($card->type == 'file')
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19.25 13.75V17.4167C19.25 17.9029 19.0568 18.3692 18.713 18.713C18.3692 19.0568 17.9029 19.25 17.4167 19.25H4.58333C4.0971 19.25 3.63079 19.0568 3.28697 18.713C2.94315 18.3692 2.75 17.9029 2.75 17.4167V13.75" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M6.41675 9.16663L11.0001 13.75L15.5834 9.16663" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M11 13.75V2.75" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                @endif
            </div>
        </div>
        <div class="flex-1 py-2">
            <div class="relative tooltip-group">
                <div class="relative tooltip-group">
                    <span class="{{ $card->description ? 'mb-1':'' }} text-sm font-black two-line-text" style="color: {{ env('APP_NAME') == 'AABB-SP' ? '#00268A':$block->topics_color }};">
                        {{ $card->title }}
                    </span>
                    {{--
                    <div class="tooltip hidden absolute z-10 p-2 text-white bg-black rounded opacity-0 transition-opacity duration-300 -translate-x-2/2 left-2/2 top-full mb-2 transform">
                        {{ $card->title }}
                    </div>
                    --}}
                </div>
            </div>
            @if($card->description)
                <div class="block-description" style="color: {!! $block->content_color !!} !important;">{!! nl2br($card->description) !!}</div>
            @endif
        </div>
    </div>
</div>
@push('scripts')

    <script>
        document.querySelectorAll('.tooltip-group').forEach(group => {
            const textElement = group.querySelector('span');
            const tooltip = group.querySelector('.tooltip');

            textElement.addEventListener('mouseenter', () => {
                tooltip.classList.remove('hidden', 'opacity-0');
                tooltip.classList.add('opacity-100');
            });

            textElement.addEventListener('mouseleave', () => {
                tooltip.classList.remove('opacity-100');
                tooltip.classList.add('opacity-0');
                setTimeout(() => tooltip.classList.add('hidden'), 300);
            });
        });
    </script>
@endpush
