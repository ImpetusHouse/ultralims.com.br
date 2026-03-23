<style>
    .cookie-decline:hover{
        background-color: {{ $cookie->button_hover_decline_color }} !important;
        border-color: {{ $cookie->button_hover_decline_border_color }} !important;
        color: {{ $cookie->button_hover_decline_title_color }} !important;
    }
    .cookie-accept:hover{
        background-color: {{ $cookie->button_hover_accept_color }} !important;
        border-color: {{ $cookie->button_hover_accept_border_color }} !important;
        color: {{ $cookie->button_hover_accept_title_color }} !important;
    }
</style>
<div class="fixed bottom-0 inset-x-0 py-12 z-50">
    <div class="container px-4 mx-auto">
        <div class="max-w-7xl mx-auto">
            <div class="relative py-10 px-8 xl:px-16 rounded-lg" style="background-color: {{ $cookie->color }}">
                <div class="absolute top-0 left-0 -mt-3 ml-16 w-8 h-8 transform rotate-45 rounded-sm" style="background-color: {{ $cookie->color }}"></div>
                <div class="flex flex-wrap -mx-4 items-center">
                    <div class="w-full lg:w-2/3 px-4 mb-8 lg:mb-0">
                        <p class="max-w-2xl">
                            {!! nl2br($cookie->description) !!}
                        </p>
                    </div>
                    <div class="w-full lg:w-1/3 px-4">
                        <div class="flex items-center lg:justify-end">
                            <a class="inline-block mr-4 py-3 px-5 text-sm font-semibold border rounded-lg transition duration-200 cookie-decline" href="#"
                               style="background-color: {{ $cookie->button_decline_color }}; border-color: {{ $cookie->button_decline_border_color }}; color: {{ $cookie->button_decline_title_color }}">
                                Recusar
                            </a>
                            <a class="inline-block py-3 px-5 text-sm font-semibold border rounded-lg transition duration-200 cookie-accept" href="#"
                               style="background-color: {{ $cookie->button_accept_color }}; border-color: {{ $cookie->button_accept_border_color }}; color: {{ $cookie->button_accept_title_color }}">
                                Aceitar cookies
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
