<style>
    .cookie-high{
        background-color: #FF4F3F !important;
        border-color: #FF4F3F !important;
        color: #FFF !important;
    }
    .cookie-high:hover{
        background-color: #FF4F3F33 !important;
        border-color: #FF4F3F33 !important;
        color: #FF4F3F !important;
    }
    .tag-high{
        background-color: #FF4F3F33 !important;
        border-color: #FF4F3F33 !important;
        color: #FF4F3F;
    }
    .cookie-medium{
        background-color: #01AEF0 !important;
        border-color: #01AEF0 !important;
        color: #FFF !important;
    }
    .cookie-medium:hover{
        background-color: #01AEF033 !important;
        border-color: #01AEF033 !important;
        color: #01AEF0 !important;
    }
    .tag-medium{
        background-color: #01AEF033 !important;
        border-color: #01AEF033 !important;
        color: #01AEF0;
    }
    .cookie-low{
        background-color: #01F06D !important;
        border-color: #01F06D !important;
        color: #FFF !important;
    }
    .cookie-low:hover{
        background-color: #01F06D33 !important;
        border-color: #01F06D33 !important;
        color: #01F06D !important;
    }
    .tag-low{
        background-color: #01F06D33 !important;
        border-color: #01F06D33 !important;
        color: #01F06D;
    }
</style>
<div id="ul-cookie" class="fixed bottom-0 inset-x-0 py-12 z-50" style="display: none">
    <div class="container px-4 mx-auto">
        <div class="max-w-7xl mx-auto">
            <div class="relative py-5 px-4 xl:px-8 rounded-lg" style="background-color: #FFF; border: 2px solid #00000040; z-index: 2">
                {{--<div class="absolute top-0 left-0 -mt-3 ml-16 w-8 h-8 transform rotate-45 rounded-sm" style="background-color: #FFF; border: 2px solid #00000040; z-index: 1;"></div>--}}
                <div class="flex flex-wrap -mx-4 items-center">
                    <div class="w-full lg:w-2/3 px-4 mb-8 lg:mb-0 flex">
                        <img id="ul-cookie-img" class="h-[90px]">
                        <div class="h-100 max-w-2xl flex flex-col items-start justify-center ms-4">
                            <p id="ul-cookie-title" class="max-w-2xl font-black" style="font-size: 16px"></p>
                            <p id="ul-cookie-content" class="max-w-2xl" style="font-size: 14px"></p>
                        </div>
                    </div>
                    <div class="w-full lg:w-1/3 px-4">
                        <div class="flex items-center lg:justify-end">
                            <div id="ul-cookie-count" class="py-1 px-3 me-3" style="border-radius: 6px"></div>
                            <button id="ul-cookie-button" class="inline-block py-3 px-5 text-sm font-semibold border rounded-lg transition duration-200">
                                Estou ciente
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let currentIndex = 0;
            let cookies = [];

            // Buscar cookies da API
            fetch('{{ route('ultralims.cookies.index') }}') // Atualize para a rota correta
                .then(response => response.json())
                .then(data => {
                    cookies = data;
                    showCookie(currentIndex);
                });

            function showCookie(index) {
                if (index < cookies.length) {
                    const cookie = cookies[index];
                    document.getElementById("ul-cookie-count").innerText = `${index + 1}/${cookies.length}`;
                    document.getElementById("ul-cookie").setAttribute("data-id", cookie.id);
                    $('#ul-cookie-title').html(cookie.title);
                    $('#ul-cookie-content').html(cookie.content.replace(/\n/g, '<br>'));

                    const cookieImg = $('#ul-cookie-img');
                    const cookieButton = $('#ul-cookie-button');
                    const cookieTag = $('#ul-cookie-count');
                    if (cookie.priority === 'high'){
                        cookieImg.attr('src', '{{ asset('images/pages/Ultra Lims/cliente-ultra/icone-laranja.svg') }}');

                        cookieButton.removeClass('cookie-medium');
                        cookieButton.removeClass('cookie-low');
                        cookieButton.addClass('cookie-high');

                        cookieTag.removeClass('tag-medium');
                        cookieTag.removeClass('tag-low');
                        cookieTag.addClass('tag-high');
                    }else if(cookie.priority === 'medium'){
                        cookieImg.attr('src', '{{ asset('images/pages/Ultra Lims/cliente-ultra/icone-azul.svg') }}');

                        cookieButton.removeClass('cookie-high');
                        cookieButton.removeClass('cookie-low');
                        cookieButton.addClass('cookie-medium');

                        cookieTag.removeClass('tag-high');
                        cookieTag.removeClass('tag-low');
                        cookieTag.addClass('tag-medium');
                    }else if(cookie.priority === 'low'){
                        cookieImg.attr('src', '{{ asset('images/pages/Ultra Lims/cliente-ultra/icone-verde.svg') }}');

                        cookieButton.removeClass('cookie-high');
                        cookieButton.removeClass('cookie-medium');
                        cookieButton.addClass('cookie-low');

                        cookieTag.removeClass('tag-high');
                        cookieTag.removeClass('tag-medium');
                        cookieTag.addClass('tag-low');
                    }

                    $('#ul-cookie').fadeIn(100);
                } else {
                    // Esconde o componente de cookie se não houver mais cookies
                    document.getElementById("ul-cookie").style.display = "none";
                }
            }

            $('#ul-cookie-button').on('click', function () {
                const cookieId = document.getElementById("ul-cookie").getAttribute("data-id");

                fetch(`{{ route('ultralims.cookies.seen', '_ID_') }}`.replace('_ID_', cookieId), { method: 'GET' })
                    .then(response => response.json())
                    .then(() => {
                        currentIndex++;
                        showCookie(currentIndex);
                    });
            })
        });
    </script>
@endpush
