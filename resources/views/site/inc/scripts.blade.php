@yield('scripts')
{{-- SCRIPTS INSERIDOS PELO PAINEL --}}
@foreach(\App\Models\Settings\Script::where('position', 'footer')->get() as $script)
    {!! $script->script !!}
@endforeach
{{-- JQUERY E JQUERY MASK --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script fetchpriority="low" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- RECAPTCHA --}}
<script src="https://www.google.com/recaptcha/api.js?render={{ \App\Models\Settings\Integration::where('title', 'Google Recaptcha')->first()->key }}"></script>
{{-- SWIPER (CARROSSEL) --}}
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
{{-- SWEET ALERT --}}
<script async src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
{{-- FLUTUANTE DO WHATSAPP --}}
@if(env('APP_NAME') == "Ultra Lims")
    <div class="fixed bottom-[30px] right-[30px] visible w-[60px] z-50">
        <a class="wpp-button" id="{{ Request::getRequestUri() }}" href="https://wa.me/+554731500601?text={{ urlencode('Olá Marcele, gostaria de saber mais sobre o: '.url()->current()) }}" target="_blank">
            <img src="{{ asset('images/logos/whatsapp.svg') }}" alt="Whatsapp">
        </a>
    </div>
@endif
@if(env('APP_NAME') == "PróLab")
    <div class="fixed bottom-[30px] right-[30px] visible w-[60px] z-50">
        <a class="wpp-button" id="{{ Request::getRequestUri() }}" href="{{ route('wpp') }}?redirect=https://wa.me/+5511969170479?text={{ urlencode('Olá, gostaria de saber mais sobre o: '.url()->current()) }}&from={{ url('') }}{{ Request::getRequestUri() }}" target="_blank">
            <img src="{{ asset('images/logos/whatsapp.svg') }}" alt="WhatsApp">
        </a>
    </div>
@endif
@if(env('APP_NAME') == "Estoque Legal")
    <div class="fixed bottom-[30px] right-[30px] visible w-[60px] z-50">
        <a class="wpp-button" id="{{ Request::getRequestUri() }}" href="https://wa.me/+5531997532005?text={{ urlencode('Olá, gostaria de saber mais sobre o: '.url()->current()) }}" target="_blank">
            <img src="{{ asset('images/logos/whatsapp.svg') }}" alt="Whatsapp">
        </a>
    </div>
@endif
<script>
    {{-- MÁSCARAS --}}
    $(document).ready(function() {
        var SPMaskBehavior = function (val) {
                return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            spOptions = {
                onKeyPress: function (val, e, field, options) {
                    field.mask(SPMaskBehavior.apply({}, arguments), options);
                }
            };
        $('.mask-tel').mask(SPMaskBehavior, spOptions);
        var CpfCnpjMaskBehavior = function (val) {
                return val.replace(/\D/g, '').length <= 11 ? '000.000.000-009' : '00.000.000/0000-00';
            },
            cpfCnpjpOptions = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(CpfCnpjMaskBehavior.apply({}, arguments), options);
                }
            };
        $('.mask-cpf-cnpj').mask(CpfCnpjMaskBehavior, cpfCnpjpOptions);
    });

    // RECAPTCHA
    var lastGeneratedTokenTime;
    function generateRecaptchaToken() {
        grecaptcha.ready(function() {
            grecaptcha.execute('{{ \App\Models\Settings\Integration::where('title', 'Google Recaptcha')->first()->key }}', { action: 'submit' }).then(function(token) {
                // Verificar se o elemento existe antes de definir o valor
                var recaptchaResponseElement = document.querySelector('.recaptchaResponse');
                if (recaptchaResponseElement) {
                    recaptchaResponseElement.value = token;
                }
                // Salvar a hora em que o token foi gerado
                lastGeneratedTokenTime = new Date().getTime();
            });
        });
    }
    // Inicializar a geração do token
    generateRecaptchaToken();
    // Intervalo para verificar a validade do token e regenerá-lo, se necessário
    setInterval(function() {
        var currentTime = new Date().getTime();
        // Regenerar o token a cada 1 minuto (60000 ms)
        if (currentTime - lastGeneratedTokenTime > 60000) {
            generateRecaptchaToken();
        }
    }, 60000);


    {{-- TROCAR IMAGEM POR VÍDOE DO YOUTUBE --}}
    function imageToVideo(id, url, block = 13) {
        if (block === 13){
            var videoIframe = `<iframe width="560" height="315" src="${convertYoutubeLink(url)}?autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>`;
        }else if(block === 48){
            var videoIframe = `<iframe id="block-${id}-image" class="rounded-3xl md:rounded-6xl md:rounded-br-none w-full h-full" src="${convertYoutubeLink(url)}?autoplay=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>`;
        }
        $(`#image-${id}-container`).html(videoIframe);
    }

    {{-- MODAL DE VÍDEO DO YOUTUBE --}}
    var canCloseModal = false;
    var canCloseModalCard = false;
    $('img[data-video-url]').click(function () {
        var videoUrl = convertYoutubeLink($(this).data('video-url')) + "?autoplay=1";
        var iframe = `<iframe width="560" height="315" src="${videoUrl}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>`;
        $('#youtubeModal .modal-body').html(iframe);
        $('#youtubeModal').removeClass('hidden');

        // Permitir fechamento do modal após um curto atraso
        setTimeout(function() {
            canCloseModal = true;
        }, 100);
    });
    // Fecha o modal ao clicar fora do vídeo
    $(document).on('click', function(event) {
        if (canCloseModal && !$(event.target).closest('.modal-body').length) {
            $('#youtubeModal').addClass('hidden');
            $('#youtubeModal .modal-body').html('');
            canCloseModal = false; // Resetar a permissão para fechar o modal
        }
        if (canCloseModalCard && !$(event.target).closest('.modal-card-content').length) {
            closeModalCard();
            canCloseModalCard = false; // Resetar a permissão para fechar o modal
        }
    });

    {{-- CONVERTA A URL DO YOUTUBE PARA O PADRÃO CORRETO --}}
    function convertYoutubeLink(url) {
        url = url.replace('"', '');
        return url.replace('watch?v=', 'embed/');
    }

    {{-- ACCORDION --}}
    $('.accordion-title').click(function() {
        // Close all open accordions except the one clicked
        $('.accordion-content').not($(this).next()).slideUp();
        $('.accordion-icon').not($(this).find('.accordion-icon')).removeClass('rotate-180');

        // Toggle the clicked accordion
        var accordionContent = $(this).next('.accordion-content');
        var accordionIcon = $(this).find('.accordion-icon');

        accordionContent.slideToggle();
        accordionIcon.toggleClass('rotate-180');
    });

    {{-- AO CLICAR EM UM CARD --}}
    function cardClick(url, type){
        if (type == 'link' || type == 'file') {
            window.open(url, '_blank');
        }else if(type == 'page'){
            window.location.href = `${url}`;
        }else if (type == 'modal'){
            document.getElementById('modal-card-content').innerHTML = url;
            openModalCard();
        }
    }
    function openModalCard() {
        const modal = document.getElementById('modal-card');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('.rounded-md').classList.add('opacity-100');
            modal.querySelector('.rounded-md').classList.remove('opacity-0');
            canCloseModalCard = true;
        }, 10); // Um pequeno atraso para garantir que a transição ocorra
    }
    function closeModalCard() {
        const modal = document.getElementById('modal-card');
        modal.querySelector('.rounded-md').classList.add('opacity-0');
        modal.querySelector('.rounded-md').classList.remove('opacity-100');
        modal.classList.add('hidden');
        canCloseModalCard = false; // Resetar a permissão para fechar o modal
        //setTimeout(() => {}, 300); // Tempo de duração da transição
    }

    {{-- MUDA A ABA --}}
    function changeTab(evt, divId) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].style.backgroundColor = "#FFF";
            tablinks[i].style.color = "#737276";
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(divId).style.display = "block";
        evt.currentTarget.className += " active";
        evt.currentTarget.style.backgroundColor = "{{ env('PRIMARY_COLOR') }}";
        evt.currentTarget.style.color = "#FFF";
    }

    {{-- SCROLLA ATÉ O FORMULÁRIO DE CTA --}}
    function scrollToCta(){
        // Anima o scroll até o primeiro elemento com a classe 'form-cta'
        $('html, body').animate({
            scrollTop: $('.form-cta').first().offset().top - 100
        }, 1000); // Ajuste a duração do scroll (em milissegundos) conforme necessário
    }
</script>
@stack('scripts')
