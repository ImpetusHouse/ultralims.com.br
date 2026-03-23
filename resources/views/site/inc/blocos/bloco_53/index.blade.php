@php
    /** @var TYPE_NAME $block */
    $categories = \App\Models\General\FAQ\Category::whereIn('id', json_decode($block->faqs))->orderBy('display_order')->get()
@endphp
@push('head')
    <style>
        .block-{{ $block->id }}.active{
            color: {{ $block->primary_color }} !important;
        }
        .block-{{ $block->id }}:hover{
            color: {{ $block->primary_color }} !important;
        }
    </style>
@endpush
<section id="section_{{ $i }}" class="relative py-20 md:py-24 overflow-hidden" style="background-color: {{ $block->background_color }}">
    <div class="relative container px-4 mx-auto">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-20">
                @if($block->tag)
                    <span class="inline-block py-1 px-3 mb-4 text-xs font-semibold rounded-full" style="color: {{ $block->tag_title_color }}; background-color: {{ $block->tag_color }}">
                        {{ $block->tag }}
                    </span>
                @endif
                <h2 class="block-title font-black font-heading">
                    <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                    @if($block->subtitle)
                        <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                    @endif
                </h2>
            </div>
            <div class="flex flex-wrap -mx-4 -mb-8">
                <div class="w-full lg:w-1/3 px-4 mb-15 lg:mb-0">
                    <div class="flex flex-wrap -mx-2 lg:flex-col lg:max-w-sm border-b lg:border-b-0 lg:border-r border-gray-100">
                        @foreach($categories as $category)
                            <div class="w-full md:w-1/2 lg:w-full px-2 {{ !$loop->last ? 'mb-15':'' }}">
                                <h4 class="text-2xl font-semibold mb-8">{{ $category->title }}</h4>
                                <ul>
                                    @foreach($category->frequentlyQuestion->sortBy('display_order_category') as $faq)
                                        <li class="mb-6">
                                            <div class="faq-item block-{{ $block->id }} flex items-center text-lg font-semibold {{ $loop->first && $loop->parent->first ? 'active':'' }}"
                                                 href="#" data-faqId="{{ $faq->id }}" data-categoryId="{{ $category->id }}"
                                                 style="color: {{ $block->content_color }}; cursor: pointer">
                                                <svg width="12" height="12" viewbox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="6" cy="6" r="5" stroke="#C3C6CE" stroke-width="2"></circle>
                                                </svg>
                                                <span class="ml-3">{{ $faq->title }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="w-full lg:w-2/3 px-4">
                    @foreach($categories as $category)
                        @foreach($category->frequentlyQuestion->sortBy('display_order_category') as $faq)
                            <div class="faq-description max-w-xl xl:max-w-3xl mx-auto lg:mr-0 {{ $loop->first && $loop->parent->first ? 'block':'hidden' }}"
                                 id="faq-{{ $faq->id }}-{{ $category->id }}">
                                <h2 class="text-5xl font-semibold mb-15" style="color: {{ $block->content_color }}">{{ $faq->title }}</h2>
                                <p class="text-xl">
                                    {!! nl2br($faq->description) !!}
                                </p>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.faq-item').on('click', function(e) {
                e.preventDefault(); // Evita o comportamento padrão do link
                const faqId = $(this).attr('data-faqId'); // Obtém o ID do FAQ clicado
                const categoryId = $(this).attr('data-categoryId'); // Obtém o ID do FAQ clicado

                // Remove a classe 'active' de todos os itens e esconde suas descrições
                $('.faq-item').removeClass('active');
                $('.faq-description').removeClass('block').addClass('hidden');

                // Adiciona a classe 'active' ao item clicado e mostra a descrição relacionada
                $(this).addClass('active');
                $('#faq-'+faqId+'-'+categoryId).removeClass('hidden').addClass('block'); // Assume que a descrição segue imediatamente o título na estrutura do HTML
            });
        });
    </script>
@endpush
