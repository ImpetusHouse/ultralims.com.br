@php
    /** @var TYPE_NAME $block */
    $formButton = $block->tabs->first();
@endphp
@push('head')
    <style>
        .input-{{ $block->id }}{
            background-color: {{ $block->primary_color }};
            border: {{ $block->tag_color }} solid 1px;
            color: {{ $block->pdf_color }}
        }
        .input-{{$block->id}}:focus{
            border-color: {{ str_replace(')', ', 0.5)', $block->tag_color) }};
        }
        .input-{{$block->id}}::placeholder {
            color: {{ str_replace(')', ', 0.5)', $block->pdf_color) }}; /* Cor cinza claro */
        }
        .spinner-form-{{$block->id}} {
            border: 4px solid rgba(255, 255, 255, 0.2);
            border-left-color: {{ $formButton->button_title_color }};
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
@endpush
<section id="section_{{ $i }}" class="relative bg-cover bg-no-repeat" style="background-image: url('{{ asset($block->image) }}');">
    <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
    <div class="relative pt-20 pb-20">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap -mx-4">
                @for($i = 1; $i <= 2; $i++)
                    @if(($block->content_alignment == 'left' && $i == 1) || ($block->content_alignment == 'right' && $i == 2))
                        <div class="w-full lg:w-1/2 px-4">
                            <div class="max-w-sm text-center mx-auto">
                                <div class="mb-4 px-6 py-8 rounded-xl" style="background-color: {{ $block->background_color }}">
                                    <div class="mb-6">
                                        <h3 class="text-2xl font-bold" style="color: {{ $block->tag_title_color }}">{{ $block->tag }}</h3>
                                    </div>
                                    <form id="form-{{ $block->id }}" action="{{ route('saveContato') }}">
                                        <div class="flex flex-wrap -mx-2">
                                            <div class="mb-4 w-full lg:w-1/2 px-2">
                                                <input name="name" required class="w-full p-4 text-xs bg-gray-50 outline-none rounded input-{{ $block->id }}" type="text" placeholder="Nome">
                                            </div>
                                            <div class="mb-4 w-full lg:w-1/2 px-2">
                                                <input name="lastname" required class="w-full p-4 text-xs bg-gray-50 outline-none rounded input-{{ $block->id }}" type="text" placeholder="Sobrenome">
                                            </div>
                                        </div>
                                        <div class="mb-4 flex p-4 rounded" style="background-color: {{ $block->primary_color }}">
                                            <input name="email" required class="w-full text-xs bg-gray-50 outline-none input-{{ $block->id }}" type="email" placeholder="exemplo@email.com">
                                            <svg class="h-6 w-6 ml-4 my-auto" style="color: {{ $block->pdf_color }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                            </svg>
                                        </div>
                                        <div class="mb-6 flex p-4 rounded" style="background-color: {{ $block->primary_color }}">
                                            <input name="phone" required class="w-full text-xs bg-gray-50 outline-none mask-tel input-{{ $block->id }}" type="text" placeholder="Telefone/celular">
                                            <svg class="h-6 w-6 ml-4 my-auto" style="color: {{ $block->pdf_color }}" width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M17.5985 18.0252C12.687 22.9367 -2.30974 7.93993 2.60174 3.02845L3.97696 1.65324C4.21838 1.41201 4.51191 1.22934 4.83497 1.11928C5.15802 1.00921 5.50202 0.974683 5.84051 1.01834C6.17899 1.062 6.50297 1.18268 6.78753 1.37112C7.07208 1.55955 7.30965 1.81072 7.48197 2.10532L8.07804 3.12557C8.2907 3.48906 8.39621 3.9053 8.38239 4.32621C8.36856 4.74712 8.23596 5.15553 7.99991 5.50429L7.59471 6.10148C7.37651 6.42381 7.27744 6.81209 7.31451 7.19956C7.35159 7.58703 7.5225 7.94947 7.79786 8.22458L10.0996 10.5274L12.4024 12.8291C12.6776 13.1043 13.0401 13.275 13.4276 13.3119C13.8151 13.3487 14.2033 13.2495 14.5255 13.0311L15.1227 12.627C15.4714 12.391 15.8798 12.2584 16.3007 12.2446C16.7217 12.2307 17.1379 12.3363 17.5014 12.5489L18.5216 13.145C18.8162 13.3174 19.0672 13.555 19.2556 13.8396C19.4439 14.1243 19.5644 14.4482 19.608 14.7867C19.6515 15.1252 19.6169 15.4692 19.5068 15.7922C19.3966 16.1152 19.2139 16.4086 18.9726 16.65L17.5985 18.0252Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="mb-2 w-full py-4 hover:opacity-70 rounded text-sm font-bold" style="background-color: {{ $formButton->button_color }}; color: {{ $formButton->button_title_color }}">
                                                <span class="flex flex-wrap items-center justify-center w-full text-center" id="btn-text-{{ $block->id }}">{{ $formButton->button_title }}</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="w-full lg:w-1/2 px-4 mb-12 md:mb-20 lg:mb-0 flex items-center">
                            <div class="w-full text-center lg:text-left">
                                <div class="max-w-md mx-auto lg:mx-0">
                                    <h2 class="block-title font-black font-heading mb-4">
                                        <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                                        @if($block->subtitle)
                                            <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                                        @endif
                                    </h2>
                                </div>
                                <div class="max-w-sm mx-auto lg:mx-0">
                                    <p class="block-description {{ $block->button_display || $block->button_display_1 ? 'mb-6':'' }}" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
                                    <div>
                                        @if($block->button_display)
                                            @include('site.inc.buttons.layout_'.$block->type, ['item' => $block])
                                        @endif
                                        @if($block->button_display_1)
                                            @include('site.inc.buttons.layout_'.$block->type, ['item' => $block, 'buttonOne' => true])
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endfor
            </div>
        </div>
    </div>
</section>
@push('scripts')
    <script>
        $('#form-{{ $block->id }}').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            let url = form.attr('action');

            // Adiciona o spinner no botão
            let btn = $('#btn-text-{{ $block->id }}');
            btn.html('{{ $formButton->button_title }}... <div class="spinner-form-{{$block->id}}"></div>');
            btn.prop('disabled', true);

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function(data) {
                    if (data.success){
                        @php
                            $url = '';
                            if ($formButton->button_display){
                                if ($formButton->button_type == 'inner_page') {
                                    $page = \App\Models\Pages\Page::where('id', $formButton->button_link)->first();
                                    if ($page != null){
                                        if ($page->prefix_slug->count() > 0) {
                                            $url .= implode('/', $page->prefix_slug->pluck('slug')->toArray()) . '/';
                                        }
                                        $url = '/' . $url . $page->slug;
                                    }
                                } elseif ($formButton->button_type == 'link') {
                                    $url = $formButton->button_link;
                                } elseif ($formButton->button_type == 'cta'){
                                    $url = '/obrigado';
                                }
                            }else{
                                $url = '/obrigado';
                            }
                        @endphp
                        location.href = '{{ $url }}';
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: data.message,
                            confirmButtonColor: '{{ env('PRIMARY_COLOR') }}', // Cor do botão de confirmação
                        });
                        btn.html('{{ $formButton->button_title }}');
                        btn.prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: 'Ocorreu um erro ao enviar seu formulário. Por favor, tente novamente.',
                        confirmButtonColor: '{{ env('PRIMARY_COLOR') }}', // Cor do botão de confirmação
                    });
                    btn.html('{{ $formButton->button_title }}');
                    btn.prop('disabled', false);
                }
            });
        });
    </script>
@endpush
