@push('head')
    <style>
        @php /** @var TYPE_NAME $block */
        echo '#input-email-'.$block->id.'::placeholder'; @endphp {
            color:  {{ $block->button_title_color_1 }};
        }
    </style>
@endpush
<section id="section_{{ $i }}" class="relative py-20 overflow-hidden" style="background-color: {{ $block->background_color }}">
    <div class="relative container px-4 mx-auto z-10">
        <div class="flex flex-wrap justify-center items-center -mx-3">
            <div class="w-full lg:w-1/2 px-3 mb-8 text-center lg:text-{{ $block->type == 1 ? 'left':'center' }}">
                <h2 class="block-title font-black font-heading">
                    <span style="color: {{ $block->title_color }}">{{ $block->title }}</span>
                    @if($block->subtitle)
                        <span style="color: {{ $block->subtitle_color }}">{{ $block->subtitle }}</span>
                    @endif
                </h2>
                <p class="{{ $block->type == 2 ? 'mb-6':''}} block-description" style="color: {{ $block->content_color }}">{!! nl2br($block->content) !!}</p>
                @if($block->type == 2 && $block->button_display)
                    @include('site.inc.buttons.layout_1', ['item' => $block])
                @endif
            </div>
            @if($block->type == 1)
                <div class="w-full lg:w-1/2 px-3">
                    <div class="flex flex-wrap max-w-lg mx-auto">
                        <div class="flex w-full md:w-2/3 px-3 mb-3 md:mb-0 md:ml-auto md:mr-6 rounded" style="background-color: {{ $block->button_color_1 }}">
                            <svg class="h-6 w-6 my-auto" style="color: {{ $block->button_title_color_1 }}" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                            <input id="input-email-{{$block->id}}" class="w-full pl-3 py-4 text-xs font-semibold leading-none outline-none input-email" type="text" placeholder="Escreva seu e-mail" style="color: {{ $block->button_title_color_1 }}; background-color: {{ $block->button_color_1 }}">
                        </div>
                        <button class="w-full md:w-auto py-4 px-8 text-xs hover:opacity-70 font-semibold leading-none rounded transition duration-300 ease-in-out" type="submit" style="color: {{ $block->button_title_color }}; background-color: {{ $block->button_color }}">Enviar</button>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <img class="hidden lg:block absolute left-0 top-0 h-192 -mt-48 pb-16" src="{{ asset($block->image) }}">
</section>
