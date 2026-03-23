@push('head')
    <style>
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
@endpush
<section id="section_{{ $i }}" class="py-24 lg:py-28 overflow-hidden" style="background-color: {{ $block->background_color }}">
    <div class="container px-4 mx-auto">
        <div class="mx-auto">
            <h2 class="block-title font-black font-heading mb-4">
                <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                @if($block->subtitle)
                    <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                @endif
            </h2>
            <p class="mb-14 block-description" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
            <form id="form-{{ $block->id }}" class="flex flex-wrap -m-3" action="{{ route('saveContato') }}">
                <input class="recaptchaResponse" type="hidden" name="recaptcha-response">
                <input name="layout" type="hidden" value="{{ $block->email }}">
                <input name="page_id" type="hidden" value="{{ $page->id }}">
                <div class="w-full md:w-1/2 p-3">
                    <label class="block">
                        <input required type="text" placeholder="Nome" name="name" class="px-4 py-4 w-full text-gray-600 tracking-tight bg-transparent placeholder-gray-600 outline-none border border-gray-600 rounded-lg focus:border-gray-400 transition duration-200">
                    </label>
                </div>
                <div class="w-full md:w-1/2 p-3">
                    <label class="block">
                        <input required type="text" placeholder="Sobrenome" name="lastname" class="px-4 py-4 w-full text-gray-600 tracking-tight bg-transparent placeholder-gray-600 outline-none border border-gray-600 rounded-lg focus:border-gray-400 transition duration-200">
                    </label>
                </div>
                <div class="w-full md:w-1/2 p-3">
                    <label class="block">
                        <input required type="email" placeholder="E-mail" name="email" class="px-4 py-4 w-full text-gray-600 tracking-tight bg-transparent placeholder-gray-600 outline-none border border-gray-600 rounded-lg focus:border-gray-400 transition duration-200">
                    </label>
                </div>
                <div class="w-full md:w-1/2 p-3">
                    <label class="block">
                        <input required type="text" placeholder="Telefone/Celular" name="phone" class="px-4 py-4 w-full text-gray-600 tracking-tight bg-transparent placeholder-gray-600 outline-none border border-gray-600 rounded-lg focus:border-gray-400 transition duration-200 mask-tel">
                    </label>
                </div>
                <div class="w-full md:w-1/2 p-3">
                    <label class="block">
                        <select required name="is_member" class="px-4 py-4 w-full text-gray-600 tracking-tight bg-transparent placeholder-gray-600 outline-none border border-gray-600 rounded-lg focus:border-gray-400 transition duration-200">
                            <option disabled selected>Associado?</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </label>
                </div>
                <div class="w-full md:w-1/2 p-3">
                    <label class="block">
                        <input type="text" placeholder="Número de associado" name="member_number" class="px-4 py-4 w-full text-gray-600 tracking-tight bg-transparent placeholder-gray-600 outline-none border border-gray-600 rounded-lg focus:border-gray-400 transition duration-200">
                    </label>
                </div>
                <div class="w-full p-3">
                    <label class="block">
                        <input required type="text" placeholder="Assunto" name="subject" class="px-4 py-4 w-full text-gray-600 tracking-tight bg-transparent placeholder-gray-600 outline-none border border-gray-600 rounded-lg focus:border-gray-400 transition duration-200">
                    </label>
                </div>
                <div class="w-full p-3">
                    <label class="block">
                        <textarea required placeholder="Mensagem" name="message" rows="4" class="px-4 py-4 w-full text-gray-600 tracking-tight bg-transparent placeholder-gray-600 outline-none border border-gray-600 rounded-lg focus:border-gray-400 transition duration-200 resize-none"></textarea>
                    </label>
                </div>
                <div class="w-full p-3">
                    <button id="btn-{{ $block->id }}" type="submit" class="mb-4 px-5 py-4 w-full font-semibold tracking-tight rounded-lg hover:opacity-70 focus:ring-4 focus:ring-opacity-70 transition duration-200" style="background-color: {{ $block->button_color }}; color: {{ $block->button_title_color }}">
                        <span class="flex flex-wrap items-center justify-center w-full text-center" id="btn-text-{{ $block->id }}">{{ $block->button_title }}</span>
                    </button>
                </div>
            </form>
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
            btn.html('Enviando... <div class="spinner-form-{{$block->id}}"></div>');
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
                    btn.html('Enviar');
                    btn.prop('disabled', false);
                }
            });
        });
    </script>
@endpush
