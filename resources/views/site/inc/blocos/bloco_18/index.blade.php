@push('head')
    <style>
        .input-{{ $block->id }}{
            background-color: {{ $block->primary_color }};
            border: {{ $block->button_color_1 }} solid 1px;
            color: {{ $block->button_title_color_1 }}
        }
        .input-{{$block->id}}:focus{
            border-color: {{ str_replace(')', ', 0.5)', $block->button_color_1) }};
        }
        .input-{{$block->id}}::placeholder {
            color: {{ str_replace(')', ', 0.5)', $block->button_title_color_1) }}; /* Cor cinza claro */
        }
        .spinner-form-{{$block->id}} {
            border: 4px solid rgba(255, 255, 255, 0.2);
            border-left-color: {{ $block->button_title_color }};
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
    @include('site.inc.styles.fonts', ['block' => $block, 'tab' => new \App\Models\Pages\Block_Tab()])
@endpush
<section id="section_{{ $i }}" class="pt-[2rem] lg:pt-[4rem] pb-[6rem] overflow-hidden form-cta" style="background-color: {{ $block->background_color }}">
    <div class="container px-4 mx-auto">
        <div class="flex flex-wrap -m-8">
            @for($i = 1; $i <= 2; $i++)
                @if(($block->content_alignment == 'left' && $i == 1) || ($block->content_alignment == 'right' && $i == 2))
                    <div class="w-full md:w-1/2 p-8">
                        <div class="p-6 md:max-w-lg mx-auto rounded-2xl shadow-xl" style="background-color: {{ $block->primary_color }}">
                            <form id="form-{{ $block->id }}" class="flex flex-wrap -m-2" action="{{ route('saveContato') }}">
                                <input class="recaptchaResponse" type="hidden" name="recaptcha-response">
                                <input name="layout" type="hidden" value="{{ $block->email }}">
                                <input name="page_id" type="hidden" value="{{ isset($page) ? $page->id:'' }}">
                                <input type="hidden" name="subject" value="{{ $block->button_title_1 }}">
                                <input type="hidden" name="url" value="{{ url()->full() }}">
                                @if($block->type == '1')
                                    <div class="w-full md:w-1/2 p-2">
                                        <label class="block">
                                            <input type="text" placeholder="Nome" name="name" required class="p-2 w-full tracking-tight outline-none rounded-lg transition duration-200 input-{{ $block->id }}">
                                        </label>
                                    </div>
                                    <div class="w-full md:w-1/2 p-2">
                                        <label class="block">
                                            <input type="text" placeholder="Sobrenome" name="lastname" required class="p-2 w-full tracking-tight outline-none rounded-lg transition duration-200 input-{{ $block->id }}">
                                        </label>
                                    </div>
                                    <div class="w-full md:w-1/2 p-2">
                                        <label class="block">
                                            <input type="email" placeholder="E-mail" name="email" required class="p-2 w-full tracking-tight outline-none rounded-lg transition duration-200 input-{{ $block->id }}">
                                        </label>
                                    </div>
                                    <div class="w-full md:w-1/2 p-2">
                                        <label class="block">
                                            <input type="text" placeholder="Telefone/Celular" name="phone" required class="p-2 w-full tracking-tight outline-none rounded-lg transition duration-200 mask-tel input-{{ $block->id }}">
                                        </label>
                                    </div>
                                    <div class="w-full p-2">
                                        <label class="block">
                                            <input type="text" placeholder="Nome da empresa" name="company_name" required class="p-2 w-full tracking-tight outline-none rounded-lg transition duration-200 input-{{ $block->id }}">
                                        </label>
                                    </div>
                                @elseif($block->type == '2')
                                    <div class="w-full p-2">
                                        <label class="block">
                                            <input type="text" placeholder="Nome" name="name" required class="p-2 w-full tracking-tight outline-none rounded-lg transition duration-200 input-{{ $block->id }}" style="">
                                        </label>
                                    </div>
                                    <div class="w-full p-2">
                                        <label class="block">
                                            <input type="text" placeholder="Cargo" name="office" required class="p-2 w-full tracking-tight outline-none rounded-lg transition duration-200 input-{{ $block->id }}">
                                        </label>
                                    </div>
                                    <div class="w-full md:w-1/2 p-2">
                                        <label class="block">
                                            <input type="text" placeholder="Telefone/Celular" name="phone" required class="p-2 w-full tracking-tight outline-none rounded-lg transition duration-200 mask-tel input-{{ $block->id }}">
                                        </label>
                                    </div>
                                    <div class="w-full md:w-1/2 p-2">
                                        <label class="block">
                                            <input type="email" placeholder="E-mail" name="email" required class="p-2 w-full tracking-tight outline-none rounded-lg transition duration-200 input-{{ $block->id }}">
                                        </label>
                                    </div>
                                    <div class="w-full md:w-1/2 p-2">
                                        <label class="block">
                                            <input type="text" placeholder="Nome da empresa" name="company_name" required class="p-2 w-full tracking-tight outline-none rounded-lg transition duration-200 input-{{ $block->id }}">
                                        </label>
                                    </div>
                                    <div class="w-full md:w-1/2 p-2">
                                        <label class="block">
                                            <select name="quantity" required class="p-2 w-full tracking-tight outline-none rounded-lg transition duration-200 input-{{ $block->id }}">
                                                <option disabled selected>Número de colaboradores</option>
                                                <option value="Até 5">Até 5</option>
                                                <option value="De 6 a 10">De 6 a 10</option>
                                                <option value="De 11 a 20">De 11 a 20</option>
                                                <option value="Mais de 21">Mais de 21</option>
                                            </select>
                                        </label>
                                    </div>
                                    <div class="w-full p-2">
                                        <label class="block">
                                            <textarea name="message" rows="4" required class="block p-2 w-full outline-none rounded-lg resize-none transition duration-200 input-{{ $block->id }}"
                                                      placeholder="{{ env('APP_NAME') == 'Ultra Lims' ? 'Qual a principal necessidade ou problema do seu laboratório?':'Qual a sua principal necessidade?' }}"></textarea>
                                        </label>
                                    </div>
                                @elseif($block->type == '3')
                                    <div class="w-full md:w-1/2 p-2">
                                        <label class="block">
                                            <input type="text" placeholder="Nome" name="name" required class="p-2 w-full tracking-tight outline-none rounded-lg transition duration-200 input-{{ $block->id }}">
                                        </label>
                                    </div>
                                    <div class="w-full md:w-1/2 p-2">
                                        <label class="block">
                                            <input type="text" placeholder="Sobrenome" name="lastname" required class="p-2 w-full tracking-tight outline-none rounded-lg transition duration-200 input-{{ $block->id }}">
                                        </label>
                                    </div>
                                    <div class="w-full md:w-1/2 p-2">
                                        <label class="block">
                                            <input type="email" placeholder="E-mail" name="email" required class="p-2 w-full tracking-tight outline-none rounded-lg transition duration-200 input-{{ $block->id }}">
                                        </label>
                                    </div>
                                    <div class="w-full md:w-1/2 p-2">
                                        <label class="block">
                                            <input type="text" placeholder="Telefone/Celular" name="phone" required class="p-2 w-full tracking-tight outline-none rounded-lg transition duration-200 mask-tel input-{{ $block->id }}">
                                        </label>
                                    </div>
                                    <div class="w-full p-2">
                                        <label class="block">
                                            <input type="text" placeholder="Nome da empresa" name="company_name" required class="p-2 w-full tracking-tight outline-none rounded-lg transition duration-200 input-{{ $block->id }}">
                                        </label>
                                    </div>
                                    <div class="w-full p-2">
                                        <label class="block">
                                            <textarea name="message" rows="4" required class="block p-2 w-full outline-none rounded-lg resize-none transition duration-200 input-{{ $block->id }}"
                                                      placeholder="{{ env('APP_NAME') == 'Ultra Lims' ? 'Qual a principal necessidade ou problema do seu laboratório?':'Qual a sua principal necessidade?' }}"></textarea>
                                        </label>
                                    </div>
                                @endif
                                <div class="w-full p-2">
                                    <button id="btn-{{ $block->id }}" type="submit" class="block-button-title-{{ $block->id }} hover:opacity-70 inline-block mb-4 px-5 py-4 w-full text-center tracking-tight rounded-lg focus:ring-4 focus:ring-opacity-70 transition duration-200" style="background-color: {{ $block->button_color }}; color: {{ $block->button_title_color }}">
                                        <span class="flex flex-wrap items-center justify-center w-full text-center" id="btn-text-{{ $block->id }}">{{ $block->button_title }}</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="w-full md:w-1/2 p-8">
                        <div class="flex flex-col justify-between max-w-lg h-full">
                            <div>
                                @if($block->tag)
                                    <span class="inline-block text-xs py-1 px-3 font-semibold rounded-xl mb-6" style="background-color: {{ $block->tag_color }}; color: {{ $block->tag_title_color }}">{{ $block->tag }}</span>
                                @endif
                                <h2 class="font-black font-heading mb-4">
                                    <span class="block-title-{{ $block->id }}" style="color: {!! $block->title_color !!}">{{ $block->title }}</span>@if($block->subtitle)<span class="block-subtitle-{{ $block->id }}" style="color: {!! $block->subtitle_color !!}">&nbsp;{{ $block->subtitle }}</span>@endif
                                </h2>
                                <p class="block-description-{{ $block->id }}" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
                            </div>
                            @if($block->content_type == null || $block->content_type == 'image')
                                @php
                                    $testimonial = \App\Models\General\Testimonials\Testimonial::whereIn('id', json_decode($block->testimonials))->first();
                                @endphp
                                @if($testimonial)
                                    <div class="inline-block mt-12">
                                        <p class="text-sm mb-6 tracking-tight italic" style="color: {{ $block->divider_color }}">{!! nl2br($testimonial->description) !!}</p>
                                        <div class="flex flex-wrap items-center -m-2">
                                            <div class="w-auto p-2">
                                                <img class="h-16 w-16 rounded-full object-cover" src="{{ asset(str_replace('public/', 'storage/', $testimonial->path)) }}?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=500&amp;q=60" alt="{{ $testimonial->client }}">
                                            </div>
                                            <div class="flex-1 p-2">
                                                <h3 class="font-semibold tracking-tight leading-tight" style="color: {{ $block->pdf_title_color }}">{{ $testimonial->client }}</h3>
                                                <span class="text-sm leading-tight" style="color: {{ $block->pdf_color }}">{{ $testimonial->description_client }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else
                                @if($block->tabs->count() > 0)
                                    <div class="flex flex-wrap mt-12">
                                        @foreach($block->tabs->sortBy('tab') as $tab)
                                            @push('head')
                                                @include('site.inc.styles.fonts', ['block' => $block, 'tab' => $tab])
                                            @endpush
                                            <div class="w-full p-2">
                                                @if($tab->content_link)
                                                    <a href="{{ $tab->content_link }}" target="_blank">
                                                @endif
                                                <div class="flex flex-wrap items-center -m-2">
                                                    <div class="w-auto p-2">
                                                        <img class="h-12 w-12 object-cover" src="{{ asset($tab->image) }}" alt="{{ $tab->title }}">
                                                    </div>
                                                    <div class="flex-1 p-2">
                                                        <h3 class="font-semibold tracking-tight leading-tight block-title-{{ $block->id }}-{{ $tab->id }}" style="color: {{ $tab->title_color }}">{{ $tab->title }}</h3>
                                                        <span class="block-description-{{ $block->id }}-{{ $tab->id }} leading-tight" style="color: {{ $tab->subtitle_color }}">{{ $tab->subtitle }}</span>
                                                    </div>
                                                </div>
                                                @if($tab->content_link)
                                                    </a>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                @endif
            @endfor
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
            btn.html('{{ $block->button_title }}... <div class="spinner-form-{{$block->id}}"></div>');
            btn.prop('disabled', true);

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function(data) {
                    if (data.success){
                        /*Swal.fire({
                            icon: 'success',
                            title: 'Sucesso!',
                            text: 'Seu formulário foi enviado com sucesso.',
                            confirmButtonColor: '{{ env('PRIMARY_COLOR') }}', // Cor do botão de confirmação
                            showConfirmButton: true,
                        }).then((result) => {
                            location.reload();
                        });*/
                        @php
                            $url = '';
                            if ($block->button_display){
                                if ($block->button_type == 'inner_page') {
                                    $page = \App\Models\Pages\Page::where('id', $block->button_link)->first();
                                    if ($page != null){
                                        if ($page->prefix_slug->count() > 0) {
                                            $url .= implode('/', $page->prefix_slug->pluck('slug')->toArray()) . '/';
                                        }
                                        $url = '/' . $url . $page->slug;
                                    }
                                } elseif ($block->button_type == 'link') {
                                    $url = $block->button_link;
                                } elseif ($block->button_type == 'cta'){
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
                        btn.html('{{ $block->button_title }}');
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
                    btn.html('{{ $block->button_title }}');
                    btn.prop('disabled', false);
                }
            });
        });
    </script>
@endpush
