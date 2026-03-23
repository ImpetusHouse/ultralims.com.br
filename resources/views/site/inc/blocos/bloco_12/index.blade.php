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
<section id="section_{{ $i }}" class="overflow-hidden form-cta" style="background-color: {{ $block->background_color }}">
    <div class="flex flex-wrap">
        @php
            $tab = $block->tabs->first();
        @endphp
        @for($i = 1; $i <= 2; $i++)
            @if(($block->content_alignment == 'left' && $i == 1) || ($block->content_alignment == 'right' && $i == 2))
                <div class="w-full md:w-1/2">
                    <div class="container px-4 mx-auto">
                        <div class="flex flex-wrap items-center">
                            <div class="w-full">
                                <div class="md:max-w-lg mx-auto pt-10 pb-10">
                                    <div class="md:max-w-md mb-10">
                                        <h2 class="block-title font-black font-heading mb-4">
                                            <span style="color: {!! $block->title_color !!}">{{ $block->title }}</span>
                                            @if($block->subtitle)
                                                <span style="color: {!! $block->subtitle_color !!}">{{ $block->subtitle }}</span>
                                            @endif
                                        </h2>
                                        <p class="block-description" style="color: {!! $block->content_color !!} !important;">{!! $block->content !!}</p>
                                    </div>
                                    <form id="form-{{ $block->id }}" class="md:max-w-lg" action="{{ route('saveContato') }}">
                                        <input name="layout" type="hidden" value="{{ $block->email }}">
                                        <input name="page_id" type="hidden" value="{{ $page->id }}">
                                        <label class="block mb-5">
                                            <input type="text" name="name" placeholder="Nome" required class="px-4 py-2 w-full text-gray-500 font-medium placeholder-gray-500 bg-white outline-none border border-gray-300 rounded-lg focus:ring focus:ring-blue-300">
                                        </label>
                                        <label class="block mb-5">
                                            <input type="text" name="office" placeholder="Cargo" required class="px-4 py-2 w-full text-gray-500 font-medium placeholder-gray-500 bg-white outline-none border border-gray-300 rounded-lg focus:ring focus:ring-blue-300">
                                        </label>
                                        <div class="flex flex-wrap -mx-3">
                                            <div class="w-full md:w-1/2 px-3 mb-5">
                                                <input type="text" name="phone" placeholder="Telefone" required class="px-4 py-2 w-full text-gray-500 font-medium placeholder-gray-500 bg-white outline-none border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 mask-tel">
                                            </div>
                                            <div class="w-full md:w-1/2 px-3 mb-5">
                                                <input type="email" name="email" placeholder="E-mail" required class="px-4 py-2 w-full text-gray-500 font-medium placeholder-gray-500 bg-white outline-none border border-gray-300 rounded-lg focus:ring focus:ring-blue-300">
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap -mx-3">
                                            <div class="w-full md:w-1/2 px-3 mb-5">
                                                <input type="text" name="company_name" placeholder="Nome da empresa" required class="px-4 py-2 w-full text-gray-500 font-medium placeholder-gray-500 bg-white outline-none border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 mask-tel">
                                            </div>
                                            <div class="w-full md:w-1/2 px-3 mb-5">
                                                <select name="quantity" required class="px-4 py-2 w-full text-gray-500 font-medium placeholder-gray-500 bg-white outline-none border border-gray-300 rounded-lg focus:ring focus:ring-blue-300">
                                                    <option disabled selected>Número de colaboradores</option>
                                                    <option value="Até 5">Até 5</option>
                                                    <option value="De 6 a 10">De 6 a 10</option>
                                                    <option value="De 11 a 20">De 11 a 20</option>
                                                    <option value="Mais de 21">Mais de 21</option>
                                                </select>
                                            </div>
                                        </div>
                                        <label class="block mb-5">
                                            <textarea name="message" placeholder="Qual a sua principal necessidade?" required class="px-4 py-2 w-full text-gray-500 font-medium placeholder-gray-500 bg-white outline-none border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 resize-none"></textarea>
                                        </label>
                                        <div class="flex flex-wrap justify-between mb-4">
                                            <div class="w-full">
                                                <div class="flex items-center">
                                                    <input required class="w-4 h-4" id="checkbox-{{ $block->id }}" type="checkbox">
                                                    <label class="ml-2 text-sm text-gray-900 font-medium" for="checkbox-{{ $block->id }}">
                                                        <span>Aceitos os</span>
                                                        <a class="hover:opacity-70" style="color: {{ $block->button_color }}" href="{{ $block->button_link }}" target="_blank">termos</a>
                                                        <span> de privacidade da {{ env('APP_NAME') }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <button id="btn-{{ $block->id }}" type="submit" class="py-4 px-9 w-full font-semibold rounded-xl focus:ring transition ease-in-out duration-200 hover:opacity-70" style="color: {{ $block->button_title_color }}; background-color: {{ $block->button_color }}">
                                            <span class="flex flex-wrap items-center justify-center w-full text-center" id="btn-text-{{ $block->id }}">Agendar uma apresentação</span>
                                        </button>
                                        <div class="flex flex-wrap justify-center -m-2.5"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="w-full md:w-1/2">
                    <div class="flex flex-col justify-center h-full" style="background-color: {{ $tab->background_color }}">
                        <div class="text-center">
                            @if($tab->title)
                                <h2 class="font-black mb-5 block-title tracking-px-n leading-tight" style="color: {{ $tab->title_color }}">{{ $tab->title }}</h2>
                            @endif
                            @if($tab->subtitle)
                                <p class="mb-24 block-description text-opacity-80 font-medium leading-normal md:max-w-md mx-auto" style="color: {{ $tab->subtitle_color }}">{{ $tab->subtitle }}</p>
                            @endif
                            <img class="mx-auto transform hover:scale-105 transition ease-in-out duration-1000" src="{{ asset($tab->image) }}" alt="{{ $tab->title }}">
                        </div>
                    </div>
                </div>
            @endif
        @endfor
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
            btn.html('Agendar uma apresentação... <div class="spinner-form-{{$block->id}}"></div>');
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
                        location.href = '{{ route('obrigado') }}';
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro!',
                            text: data.message,
                            confirmButtonColor: '{{ env('PRIMARY_COLOR') }}', // Cor do botão de confirmação
                        });
                        btn.html('Agendar uma apresentação');
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
                    btn.html('Agendar uma apresentação');
                    btn.prop('disabled', false);
                }
            });
        });
    </script>
@endpush
