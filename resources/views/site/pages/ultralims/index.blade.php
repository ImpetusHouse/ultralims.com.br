@extends('site.pages.ultralims.layout')
@php
    /** @var TYPE_NAME $banners */
    foreach ($banners->sortByDesc('display_order') as $banner) {
        $type = $banner->button_type;
        $link = $banner->button_link;

        if ($type === 'inner_page') {
            $page = \App\Models\Pages\Page::where('id', $link)->first();
            if ($page !== null) {
                $slugPath = '';
                if ($page->prefix_slug->count() > 0) {
                    $slugPath = implode('/', $page->prefix_slug->pluck('slug')->toArray()) . '/';
                }
                $banner->resolved_link = '/' . $slugPath . $page->slug;
            } else {
                $banner->resolved_link = '';
            }
        } elseif ($type === 'link') {
            $banner->resolved_link = $link;
        } elseif ($type === 'cta') {
            $banner->resolved_link = 'cta';
        } else {
            $banner->resolved_link = '';
        }
    }
@endphp
@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        #image-banner {
            transition: opacity 0.5s ease-in-out;
        }
        .fade-in {
            opacity: 1;
        }
        .fade-out {
            opacity: 0;
        }
        .wpp-button{
            display: none;
        }
    </style>
@endpush
@section('content')
    <section id="block-header" class="relative bg-white overflow-hidden">
        <div class="container mx-auto flex flex-wrap lg:flex-nowrap items-center">
            <div class="w-full lg:w-1/2 px-4 lg:px-0 mt-4 lg:mt-0 mb-4 lg:mb-0 order-2 lg:order-1 lg:h-[28rem] flex items-center">
                <div class="max-w-md">
                    <span class="inline-block text-xs font-semibold rounded-full py-1 px-3 mb-4" id="tag-banner"
                          style="color: {{ $banners->first()->tag_title_color }}; background-color: {{ $banners->first()->tag_color }}; {{ !$banners->first()->tag ? 'display: none':'' }}">
                        {{ $banners->first()->tag }}
                    </span>
                    <h2 class="mb-6 block-title font-black font-heading" id="title-banner" style="color: {{ $banners->first()->title_color }};">
                        {{ $banners->first()->title }}
                    </h2>
                    <div class="mb-8 block-description" id="description-banner">
                        {!! $banners->first()->description !!}
                    </div>
                    <a class="block sm:inline-block py-4 px-8 mb-4 sm:mb-0 sm:mr-3 block-button-title text-center font-semibold leading-none rounded" id="button-banner"
                       href="javascript:void(0)"
                       onclick="openBannerLink('{{ $banners->first()->button_type === 'cta' ? 'cta' : $banners->first()->button_link }}', '{{ $banners->first()->id }}')"
                       onmouseover="this.style.backgroundColor = '{{ $banners->first()->button_color_hover }}'" onmouseout="this.style.backgroundColor = '{{ $banners->first()->button_color }}'"
                       style="color: {{ $banners->first()->button_title_color }}; background-color: {{ $banners->first()->button_color }}; {{ !$banners->first()->button_display ? 'display: none':'' }}">
                        {{ $banners->first()->button_title }}
                    </a>
                    @if($banners->count() > 1)
                        <div class="hidden lg:flex flex-wrap mt-8">
                            <span class="prev-slide mr-2 cursor-pointer text-[#03B7FC] hover:text-[#018BC0]">
                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 1C5.4772 1 0.999999 5.4772 0.999999 11C1 16.5229 5.4772 21 11 21C16.5229 21 21 16.5229 21 11C21 5.4772 16.5228 1 11 1Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12.2598 7.47024L8.73976 11.0002L12.2598 14.5303" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span class="next-slide cursor-pointer text-[#03B7FC] hover:text-[#018BC0]">
                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 21C16.5228 21 21 16.5228 21 11C21 5.47715 16.5228 1 11 1C5.47715 1 1 5.47715 1 11C1 16.5228 5.47715 21 11 21Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9.74023 14.5298L13.2602 10.9998L9.74023 7.46973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="w-full lg:w-1/2 relative lg:absolute lg:right-0 lg:top-0 h-[18rem] lg:h-[28rem] order-1 lg:order-2">
                @if($banners->count() > 1)
                    <span class="prev-slide lg:hidden mr-2 cursor-pointer text-[#03B7FC] hover:text-[#018BC0] absolute top-[45%] left-[5%]">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 1C5.4772 1 0.999999 5.4772 0.999999 11C1 16.5229 5.4772 21 11 21C16.5229 21 21 16.5229 21 11C21 5.4772 16.5228 1 11 1Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12.2598 7.47024L8.73976 11.0002L12.2598 14.5303" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="next-slide lg:hidden cursor-pointer text-[#03B7FC] hover:text-[#018BC0] absolute top-[45%] right-[5%]">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 21C16.5228 21 21 16.5228 21 11C21 5.47715 16.5228 1 11 1C5.47715 1 1 5.47715 1 11C1 16.5228 5.47715 21 11 21Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9.74023 14.5298L13.2602 10.9998L9.74023 7.46973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                @endif
                <img class="w-full h-full object-cover" src="{{ str_replace('public/', 'storage/', $banners->first()->image) }}" alt="" id="image-banner">
            </div>
        </div>
        <div class="relative overflow-hidden">
            <div class="absolute inset-0 hidden lg:flex bg-gradient-to-r from-[#03B7FC] to-[#FF4F3F]">
                <div class="lg:w-1/3 bg-[#03B7FC]" id="left-bg"></div>
                <div class="lg:w-1/3"></div>
                <div class="lg:w-1/3 bg-[#FF4F3F]" id="right-bg"></div>
            </div>
            <div class="lg:container lg:px-4 lg:mx-auto relative z-10">
                <div class="flex flex-wrap lg:-m-4">
                    <div class="w-full lg:w-1/3">
                        @php
                            if(Auth::guard('ultralims')->user() != null){
                                $url = Auth::guard('ultralims')->user()->urlRedirect;
                            }else{
                                $url = 'javascript:void(0);';
                            }
                        @endphp
                        <a href="{{ $url }}" class="flex p-6 lg:p-[2.5rem] bg-[#03B7FC] hover:bg-[#0292CA] border-t border-gray-50" target="_blank"
                           onmouseover="document.getElementById('left-bg').style.backgroundColor = '#0292CA';"
                           onmouseout="document.getElementById('left-bg').style.backgroundColor = '#03B7FC';">
                            <div class="mr-8">
                                <span class="bg-[#0275A2] text-[#FFFFFF] flex justify-center items-center w-14 h-14 text-lg font-bold rounded-full">
                                    <svg width="16" height="16" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 1.5809V4.24242C0 5.11292 0.710406 5.82333 1.5809 5.82333H25.0443L1.11063 29.777C0.49028 30.3974 0.49028 31.3979 1.11063 32.0183L2.99171 33.8994C3.61206 34.5197 4.61264 34.5197 5.23299 33.8994L29.1767 9.95569V33.4191C29.1767 34.2896 29.8871 35 30.7576 35H33.4191C34.2896 35 35 34.2896 35 33.4191V1.5809C35 0.710406 34.2896 0 33.4191 0H1.5809C0.710406 0 0 0.710406 0 1.5809Z" fill="currentColor"/>
                                    </svg>
                                </span>
                            </div>
                            <div class="max-w-xs">
                                <h3 class="text-[#FFFFFF] mb-3 text-lg font-bold font-heading">Ir para o Ultra LIMS</h3>
                                <p class="text-[#FFFFFF] text-sm">Acesse o melhor LIMS do mercado.</p>
                            </div>
                        </a>
                    </div>
                    <div class="w-full lg:w-1/3">
                        <a href="{{ route('ultralims.produtos') }}" class="flex p-6 lg:p-[2.5rem] bg-[#16213E] hover:bg-[#121A32] border-t border-gray-50">
                            <div class="mr-8">
                            <span class="bg-[#0E1528] text-[#FFFFFF] flex justify-center items-center w-14 h-14 text-lg font-bold rounded-full">
                                <svg width="16" height="16" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 1.5809V4.24242C0 5.11292 0.710406 5.82333 1.5809 5.82333H25.0443L1.11063 29.777C0.49028 30.3974 0.49028 31.3979 1.11063 32.0183L2.99171 33.8994C3.61206 34.5197 4.61264 34.5197 5.23299 33.8994L29.1767 9.95569V33.4191C29.1767 34.2896 29.8871 35 30.7576 35H33.4191C34.2896 35 35 34.2896 35 33.4191V1.5809C35 0.710406 34.2896 0 33.4191 0H1.5809C0.710406 0 0 0.710406 0 1.5809Z" fill="currentColor"/>
                                </svg>
                            </span>
                            </div>
                            <div class="max-w-xs">
                                <h3 class="text-[#FFFFFF] mb-3 text-lg font-bold font-heading">Plugins Ultra LIMS</h3>
                                <p class="text-[#FFFFFF] text-sm">Acesse os plugins Ultra LIMS e conheça novos recursos</p>
                            </div>
                        </a>
                    </div>
                    <div class="w-full lg:w-1/3">
                        <a onclick="openCodex()" href="javascript:void(0)" class="flex p-6 lg:p-[2.5rem] bg-[#FF4F3F] hover:bg-[#CC3F32] border-t border-gray-50"
                           onmouseover="document.getElementById('right-bg').style.backgroundColor = '#CC3F32';"
                           onmouseout="document.getElementById('right-bg').style.backgroundColor = '#FF4F3F';">
                            <div class="mr-8">
                            <span class="bg-[#A33228] text-[#FFFFFF] flex justify-center items-center w-14 h-14 text-lg font-bold rounded-full">
                                <svg width="16" height="16" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 1.5809V4.24242C0 5.11292 0.710406 5.82333 1.5809 5.82333H25.0443L1.11063 29.777C0.49028 30.3974 0.49028 31.3979 1.11063 32.0183L2.99171 33.8994C3.61206 34.5197 4.61264 34.5197 5.23299 33.8994L29.1767 9.95569V33.4191C29.1767 34.2896 29.8871 35 30.7576 35H33.4191C34.2896 35 35 34.2896 35 33.4191V1.5809C35 0.710406 34.2896 0 33.4191 0H1.5809C0.710406 0 0 0.710406 0 1.5809Z" fill="currentColor"/>
                                </svg>
                            </span>
                            </div>
                            <div class="max-w-xs">
                                <h3 class="text-[#FFFFFF] mb-3 text-lg font-bold font-heading">Ir para o Codex</h3>
                                <p class="text-[#FFFFFF] text-sm">Acesse a documentação do Ultra LIMS</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-[6rem] lg:py-[9rem] bg-white overflow-hidden">
        <div class="container px-4 mx-auto">
            <div class="mb-6">
                <h2 class="mb-4 block-title font-black font-heading tracking-px-n text-[#0E1326]">
                    Nossos canais de atendimento
                </h2>
                <p class="block-description text-gray-900 font-medium">
                    Se precisar de ajuda, escolha um dos canais de atendimento.
                </p>
            </div>
            <div class="flex flex-wrap -m-8">
                <div class="w-full lg:w-1/3 p-8">
                    <div class="flex flex-wrap justify-end -m-4">
                        <div class="p-4">
                            <div class="xl:max-w-sm h-full">
                                <a href="javascript:void(0)" onclick="registerClickAndRedirect('{{ route('ultralims.university.read') }}', 'https://universidade.ultralims.com.br')">
                                    <div class="px-[2.25rem] py-8 h-[24rem] bg-[#0E1326] shadow-2xl" style="border-radius: 1.25rem">
                                        <div class="flex flex-col justify-between h-full relative">
                                            <div>
                                                <svg class="mb-8" width="51" height="51" viewBox="0 0 51 51" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M47.8125 25.2774V16.977C47.8125 16.977 47.7966 16.8975 47.7966 16.8657C47.7966 16.8339 47.7966 16.7862 47.7807 16.7703C47.685 16.2138 47.3025 15.7367 46.7607 15.53L24.4484 7.59541C24.0978 7.4682 23.7153 7.4682 23.3806 7.59541L1.05234 15.5459C0.446725 15.7686 0.0164169 16.341 0.000479532 16.9929C-0.0154578 17.6449 0.367039 18.2491 0.972658 18.5035L9.56289 22.1767V38.6184C9.56289 39.318 10.0251 39.9382 10.6944 40.1449L19.7309 42.8799C21.1015 43.2933 22.504 43.5 23.9065 43.5C25.309 43.5 26.7115 43.2933 28.0821 42.8799L37.1186 40.1449C37.7879 39.9382 38.2501 39.318 38.2501 38.6184V22.1767L44.6251 19.4576V25.2933C42.7763 25.9452 41.4376 27.6943 41.4376 29.7774C41.4376 32.4011 43.5891 34.5477 46.2188 34.5477C48.8485 34.5477 51 32.4011 51 29.7774C51 27.7102 49.6613 25.9611 47.8125 25.2933V25.2774ZM35.0626 37.4417L27.1577 39.8269C25.0381 40.4629 22.775 40.4629 20.6553 39.8269L12.7504 37.4417V23.5442L23.2849 28.0442C23.6674 28.2032 24.1615 28.235 24.544 28.0442L35.0786 23.5442V37.4417H35.0626ZM23.9065 24.8481L5.96105 17.1678L23.9065 10.7756L41.852 17.1678L23.9065 24.8481ZM46.2188 31.3516C45.3422 31.3516 44.6251 30.636 44.6251 29.7615C44.6251 28.8869 45.3422 28.1714 46.2188 28.1714C47.0953 28.1714 47.8125 28.8869 47.8125 29.7615C47.8125 30.636 47.0953 31.3516 46.2188 31.3516Z" fill="#01AEF0"/>
                                                </svg>
                                                <h3 class="mb-5 text-3xl text-white font-bold leading-snug">Universidade</h3>
                                                <p class="text-blueGray-300 font-medium">
                                                    Acesse nossa plataforma de vídeos, e potencialize mais seus conhecimentos
                                                </p>
                                            </div>
                                            <a class="cursor-pointer absolute bottom-0 left-0 inline-flex items-center max-w-max text-white hover:text-gray-200"
                                               href="javascript:void(0)" onclick="registerClickAndRedirect('{{ route('ultralims.university.read') }}', 'https://universidade.ultralims.com.br')">
                                                <span class="mr-2 font-sans font-medium">Ir</span>
                                                <svg width="19" height="18" viewbox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11 3.75L16.25 9M16.25 9L11 14.25M16.25 9L2.75 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full lg:w-1/3 p-8">
                    <div class="flex flex-wrap justify-end -m-4">
                        <div class="p-4">
                            <div class="xl:max-w-sm h-full">
                                <a href="javascript:void(0)"  onclick="registerClickAndRedirect('{{ route('ultralims.call.read') }}', 'https://ultralims.atlassian.net/servicedesk/customer/portal/5/user/login?destination=portal%2F5')">
                                    <div class="px-[2.25rem] py-8 h-[24rem] bg-[#0E1326] shadow-2xl" style="border-radius: 1.25rem">
                                        <div class="flex flex-col justify-between h-full relative">
                                            <div>
                                                <svg class="mb-8" width="51" height="51" viewBox="0 0 88 88" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M33 35.75C33 32.713 30.537 30.25 27.5 30.25H24.75C18.6742 30.25 13.75 35.1742 13.75 41.25V49.5C13.75 55.5758 18.6742 60.5 24.75 60.5H27.5C30.537 60.5 33 58.037 33 55V35.75ZM63.25 60.5C69.3258 60.5 74.25 55.5758 74.25 49.5V41.25C74.25 35.1742 69.3258 30.25 63.25 30.25H60.5C57.463 30.25 55 32.713 55 35.75V55C55 58.037 57.463 60.5 60.5 60.5H63.25ZM44 0C19.4528 0 0.787187 20.4239 0 44V46.75C0 48.2694 1.23062 49.5 2.75 49.5H5.5C7.01938 49.5 8.25 48.2694 8.25 46.75V44C8.25 24.2877 24.2877 8.25 44 8.25C63.7123 8.25 79.75 24.2877 79.75 44H79.7294C79.7431 44.4177 79.75 72.4831 79.75 72.4831C79.75 76.4964 76.4964 79.75 72.4831 79.75H55C55 75.1936 51.3064 71.5 46.75 71.5H41.25C36.6936 71.5 33 75.1936 33 79.75C33 84.3064 36.6936 88 41.25 88H72.4831C81.0528 88 88 81.0528 88 72.4831V44C87.2128 20.4239 68.5472 0 44 0Z" fill="#01AEF0"/>
                                                </svg>
                                                <h3 class="mb-5 text-3xl text-white font-bold leading-snug">Abra um chamado</h3>
                                                <p class="text-blueGray-300 font-medium">
                                                    Solicite um Atendimento - Acesse nossa plataforma de atendimentos, e nos conte como podemos auxiliar.
                                                </p>
                                            </div>
                                            <a class="cursor-pointer absolute bottom-0 left-0 inline-flex items-center max-w-max text-white hover:text-gray-200" href="javascript:void(0)"  onclick="registerClickAndRedirect('{{ route('ultralims.call.read') }}', 'https://ultralims.atlassian.net/servicedesk/customer/portal/5/user/login?destination=portal%2F5')">
                                                <span class="mr-2 font-sans font-medium">Ir</span>
                                                <svg width="19" height="18" viewbox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11 3.75L16.25 9M16.25 9L11 14.25M16.25 9L2.75 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @if(Auth::guard('ultralims')->user() != null && \App\Models\UltraLims\UL_Company_Chat::where('idLaboratorio', Auth::guard('ultralims')->user()->idLaboratorio)->where('status', true)->first())
                <div class="w-full lg:w-1/3 p-8">
                    <div class="flex flex-wrap justify-end -m-4">
                        <div class="p-4">
                            <div class="xl:max-w-sm h-[24rem]">
                                <a href="javascript:void(0)" onclick="registerClickAndRedirect('{{ route('ultralims.chat.read') }}', 'https://atendimento.ultralims.com.br/livechat?mode=popout')">
                                    <div class="px-[2.25rem] py-8 h-full bg-[#0E1326] shadow-2xl" style="border-radius: 1.25rem">
                                        <div class="relative flex flex-col justify-between h-full">
                                            <div>
                                                <svg class="mb-8" width="51" height="51" viewBox="0 0 88 88" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M64 50C67.3132 50 70 47.3132 70 44C70 40.6868 67.3132 38 64 38C60.6868 38 58 40.6868 58 44C58 47.3132 60.6868 50 64 50Z" fill="#01AEF0"/>
                                                    <path d="M44 50C47.3132 50 50 47.3132 50 44C50 40.6868 47.3132 38 44 38C40.6868 38 38 40.6868 38 44C38 47.3132 40.6868 50 44 50Z" fill="#01AEF0"/>
                                                    <path d="M24 50C27.3137 50 30 47.3132 30 44C30 40.6868 27.3137 38 24 38C20.6863 38 18 40.6868 18 44C18 47.3132 20.6863 50 24 50Z" fill="#01AEF0"/>
                                                    <path d="M44 84C66.0912 84 84 66.0912 84 44C84 21.9086 66.0912 4 44 4C21.9086 4 4 21.9086 4 44C4 51.2856 5.94788 58.1164 9.35128 64L6 82L24 78.6488C29.8835 82.052 36.7144 84 44 84Z" stroke="#01AEF0" stroke-width="7.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                <h3 class="mb-5 text-3xl text-white font-bold leading-snug">
                                                    Chat
                                                </h3>
                                                <p class="text-blueGray-300 font-medium">
                                                    Fale conosco agora por chat. Um de nossos consultores está esperando por você
                                                </p>
                                            </div>
                                            <a class="cursor-pointer absolute bottom-0 left-0 inline-flex items-center max-w-max text-white hover:text-gray-200" href="javascript:void(0)" onclick="registerClickAndRedirect('{{ route('ultralims.chat.read') }}', 'https://atendimento.ultralims.com.br/livechat?mode=popout')">
                                                <span class="mr-2 font-sans font-medium">Ir</span>
                                                <svg width="19" height="18" viewbox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11 3.75L16.25 9M16.25 9L11 14.25M16.25 9L2.75 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>

    @if($events->count() >= 1)
        <section class="bg-black bg-no-repeat bg-center bg-cover bg-fixed overflow-hidden"
                 id="image-event"
                 style="background-image: url('{{ asset(str_replace('public/', 'storage/', $events->first()->photo)) }}'); padding-top: 7rem; padding-bottom: 7rem; transition: background-image 1s ease-in-out;">
            <div class="container px-4 mx-auto">
                <div class="px-12 pt-12 pb-[2.25rem] md:max-w-xl bg-black bg-opacity-80" style="backdrop-filter: blur(10px); border-radius: 1.25rem">
                    <p class="mb-7 font-sans max-w-max px-3 py-[0.375rem] text-sm text-white font-semibold uppercase border border-gray-700 rounded-lg" id="date-event">
                        {{ $events->first()->date->format('d/m/Y').($events->first()->end_date ? ' - '.$events->first()->end_date->format('d/m/Y'):'') }}
                    </p>
                    <h2 class="mb-4 block-title text-white font-black font-heading tracking-px-n" id="title-event">
                        {{ $events->first()->title }}
                    </h2>
                    <p class="mb-4 block-description text-gray-400 font-medium" id="description-event">
                        {{ $events->first()->description }}
                    </p>
                    <p class="block-description text-gray-400 font-medium" id="time-event">
                        {{ $events->first()->time }}
                    </p>
                    <p class="mb-4 block-description text-gray-400 font-medium" id="local-event">
                        {{ $events->first()->local }}
                    </p>
                    @if($events->count() > 1)
                        <div class="flex flex-wrap mb-4">
                            <span id="event-prev-slide" class="mr-2 cursor-pointer text-[#03B7FC] hover:text-[#018BC0]">
                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 1C5.4772 1 0.999999 5.4772 0.999999 11C1 16.5229 5.4772 21 11 21C16.5229 21 21 16.5229 21 11C21 5.4772 16.5228 1 11 1Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12.2598 7.47024L8.73976 11.0002L12.2598 14.5303" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span id="event-next-slide" class="cursor-pointer text-[#03B7FC] hover:text-[#018BC0]">
                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11 21C16.5228 21 21 16.5228 21 11C21 5.47715 16.5228 1 11 1C5.47715 1 1 5.47715 1 11C1 16.5228 5.47715 21 11 21Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M9.74023 14.5298L13.2602 10.9998L9.74023 7.46973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </div>
                    @endif
                    <a class="mt-6 inline-flex flex-wrap items-center text-white hover:text-gray-200" href="{{ route('events.show', $events->first()->slug) }}" id="button-event">
                        <span class="mr-2 font-semibold leading-normal">Ver evento</span>
                        <svg width="19" height="18" viewbox="0 0 19 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 3.75L16.25 9M16.25 9L11 14.25M16.25 9L2.75 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    @endif

    @if($articles->count() == 4)
        <section class="bg-white overflow-hidden pb-[6rem] lg:pb-[9rem]" x-data="{ showContent: false, slideWidth: 0, activeSlide: 0, slideCount: 2 }">
            <div class="container mx-auto px-4">
                <h2 class="mb-24 block-title font-black font-heading text-[#0E1326]">
                    Atualizações Ultra LIMS
                </h2>
                <div class="relative">
                    <a href="#" x-on:click.prevent="activeSlide = activeSlide &lt; slideCount ? activeSlide + 1 : 1, activeSlide &lt; slideCount ? slideWidth += $refs['slide' + activeSlide].offsetWidth : slideCount, activeSlide == slideCount ? (slideWidth = 0, activeSlide = 0) : null"
                       class="absolute top-[1.5rem] right-0 md:top-[50%] md:-transform-y-[50%] z-10 inline-flex justify-center items-center text-center h-12 px-6 font-semibold text-white hover:text-white focus:text-white bg-[#EFF0F1] hover:bg-[#C3C7CD] focus:bg-gray-100 rounded-full focus:ring-4 focus:ring-gray-200 transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewbox="0 0 16 16" fill="none">
                            <path d="M8.68464 2.28591C8.59426 2.3789 8.52252 2.48953 8.47357 2.61142C8.42461 2.73332 8.39941 2.86406 8.39941 2.99611C8.39941 3.12816 8.42461 3.2589 8.47357 3.38079C8.52252 3.50269 8.59426 3.61332 8.68464 3.70631L11.8571 6.99723L2.21429 6.99724C1.95854 6.99724 1.71327 7.10262 1.53243 7.29021C1.35159 7.4778 1.25 7.73223 1.25 7.99752C1.25 8.26281 1.35159 8.51723 1.53243 8.70482C1.71327 8.89241 1.95854 8.9978 2.21429 8.9978L11.8571 8.9978L8.68464 12.2887C8.59426 12.3817 8.52252 12.4923 8.47357 12.6142C8.42461 12.7361 8.39941 12.8669 8.39941 12.9989C8.39941 13.131 8.42461 13.2617 8.47357 13.3836C8.52252 13.5055 8.59426 13.6161 8.68464 13.7091C8.86531 13.8954 9.10971 14 9.36446 14C9.61922 14 9.86362 13.8954 10.0443 13.7091L14.1811 9.40791C14.5432 9.03446 14.7478 8.52724 14.75 7.99752C14.7453 7.47126 14.5409 6.96812 14.1811 6.59712L10.0443 2.29591C9.86489 2.10827 9.62121 2.0019 9.36645 2.00002C9.1117 1.99815 8.86658 2.10093 8.68464 2.28591Z" fill="#060918"></path>
                        </svg>
                    </a>
                    <div :style="'transform: translateX(-' + slideWidth + 'px)'" class="flex transition-transform duration-500 ease-in-out -m-[9rem]">
                        <div x-ref="slide1" class="flex-shrink-0 max-w-full p-[9rem]">
                            <div class="flex flex-wrap justify-center -m-6 lg:-m-12">
                                <div class="max-w-lg w-full md:w-1/2 p-6 lg:p-12">
                                    <div class="relative bg-[#EFF0F1] overflow-hidden rounded-3xl">
                                        <div class="group relative overflow-hidden" style="height: 220px">
                                            <img class="absolute w-full h-full object-cover transform group-hover:scale-105 transition duration-200" src="{{ str_replace('public/', 'storage/', $articles[0]->photo) }}" alt="">
                                        </div>
                                        <div class="pt-10 px-10 pb-12">
                                            <a href="{{ route('ultralims.blog.show', $articles[0]->slug) }}" class="hover:underline">
                                                <h3 class="mb-4 font-heading text-2xl font-bold leading-tight text-[#0E1326]">{{ $articles[0]->title }}</h3>
                                            </a>
                                            <p class="text-[#838386] font-medium five-line-text">{!! strip_tags(html_entity_decode($articles[0]->content)) !!}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="max-w-lg w-full md:w-1/2 p-6 lg:p-12">
                                    <div class="flex flex-col h-full relative bg-[#EFF0F1] overflow-hidden rounded-3xl">
                                        <div class="group relative overflow-hidden" style="height: 220px">
                                            <img class="absolute w-full h-full object-cover transform group-hover:scale-105 transition duration-200" src="{{ str_replace('public/', 'storage/', $articles[1]->photo) }}" alt="">
                                        </div>
                                        <div class="pt-10 px-10 pb-12">
                                            <a href="{{ route('ultralims.blog.show', $articles[1]->slug) }}" class="hover:underline">
                                                <h3 class="mb-4 font-heading text-2xl font-bold leading-tight text-[#0E1326]">{{ $articles[1]->title }}</h3>
                                            </a>
                                            <p class="text-[#838386] font-medium five-line-text">{!! strip_tags(html_entity_decode($articles[1]->content)) !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div x-ref="slide2" class="flex-shrink-0 max-w-full p-[9rem]">
                            <div class="flex flex-wrap justify-center -m-6 lg:-m-12">
                                <div class="max-w-lg w-full md:w-1/2 p-6 lg:p-12">
                                    <div class="relative bg-[#EFF0F1] overflow-hidden rounded-3xl">
                                        <div class="group relative overflow-hidden" style="height: 220px">
                                            <img class="absolute w-full h-full object-cover transform group-hover:scale-105 transition duration-200" src="{{ str_replace('public/', 'storage/', $articles[2]->photo) }}" alt="">
                                        </div>
                                        <div class="pt-10 px-10 pb-12">
                                            <a href="{{ route('ultralims.blog.show', $articles[2]->slug) }}" class="hover:underline">
                                                <h3 class="mb-4 font-heading text-2xl font-bold leading-tight text-[#0E1326]">{{ $articles[2]->title }}</h3>
                                            </a>
                                            <p class="text-[#838386] font-medium five-line-text">{!! strip_tags(html_entity_decode($articles[2]->content)) !!}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="max-w-lg w-full md:w-1/2 p-6 lg:p-12">
                                    <div class="flex flex-col h-full relative bg-[#EFF0F1] overflow-hidden rounded-3xl">
                                        <div class="group relative overflow-hidden" style="height: 220px">
                                            <img class="absolute w-full h-full object-cover transform group-hover:scale-105 transition duration-200" src="{{ str_replace('public/', 'storage/', $articles[3]->photo) }}" alt="">
                                        </div>
                                        <div class="pt-10 px-10 pb-12">
                                            <a href="{{ route('ultralims.blog.show', $articles[3]->slug) }}" class="hover:underline">
                                                <h3 class="mb-4 font-heading text-2xl font-bold leading-tight text-[#0E1326]">{{ $articles[3]->title }}</h3>
                                            </a>
                                            <p class="text-[#838386] font-medium five-line-text">{!! strip_tags(html_entity_decode($articles[3]->content)) !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="relative block sm:inline-block py-4 px-8 mt-24 block-button-title text-center font-semibold leading-none rounded text-white bg-[#01AEF0] hover:bg-[#0596D2]" href="{{ route('ultralims.blog') }}">
                    Ver publicações
                </a>
            </div>
        </section>
    @endif
@endsection
@push('scripts')
    <script>
        function registerClickAndRedirect(endpoint, redirectUrl) {
            fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({})
            }).finally(() => {
                window.open(redirectUrl, '_blank');
            });
        }
    </script>
    @if($banners->count() > 1)
        <script>
            let currentIndex = 0;
            const banners = @json($banners);

            function updateBanner(index) {
                const banner = banners[index];
                const imageElement = document.getElementById('image-banner');
                const tagElement = document.getElementById('tag-banner');
                const titleElement = document.getElementById('title-banner');
                const descriptionElement = document.getElementById('description-banner');
                const buttonElement = document.getElementById('button-banner');


                // Adicione uma classe para o efeito de transição
                imageElement.classList.add('fade-out');
                setTimeout(() => {
                    $(imageElement).attr('src', '{{asset('')}}' + (banner.image ? banner.image.replace('public/', 'storage/') : ''));
                    $(imageElement).attr('alt', banner.title);
                    imageElement.classList.remove('fade-out');
                    imageElement.classList.add('fade-in');

                    if (banner.tag){
                        tagElement.innerText = banner.tag;
                        tagElement.style.color = banner.tag_title_color;
                        tagElement.style.backgroundColor = banner.tag_color;
                        $(tagElement).fadeIn(200);
                    }else{
                        $(tagElement).hide();
                    }
                    titleElement.innerText = banner.title;
                    titleElement.style.color = banner.title_color;
                    descriptionElement.innerHTML = banner.description;
                    if (banner.button_display){
                        buttonElement.innerHTML = banner.button_title;
                        buttonElement.href = "javascript:void(0)";
                        buttonElement.setAttribute('onclick', `openBannerLink('${banner.button_type === 'cta' ? 'cta' : banner.button_link}', '${banner.id}')`);
                        buttonElement.style.color = banner.button_title_color;
                        buttonElement.style.backgroundColor = banner.button_color;

                        // Adiciona eventos de hover para alterar a cor do botão
                        buttonElement.addEventListener('mouseover', function() {
                            buttonElement.style.backgroundColor = banner.button_color_hover;
                        });

                        buttonElement.addEventListener('mouseout', function() {
                            buttonElement.style.backgroundColor = banner.button_color;
                        });

                        $(buttonElement).fadeIn(200);
                    }else{
                        $(buttonElement).hide();
                    }
                }, 500); // Tempo de transição correspondente à duração no CSS
            }
            function resetAutoSlide() {
                clearInterval(autoSlideInterval);
                autoSlideInterval = setInterval(function() {
                    currentIndex = (currentIndex + 1) % banners.length;
                    updateBanner(currentIndex);
                }, 8000);
            }
            // Adicionando o evento de clique a todos os elementos com a classe 'next-slide'
            document.querySelectorAll('.next-slide').forEach(function(element) {
                element.addEventListener('click', function() {
                    currentIndex = (currentIndex + 1) % banners.length;
                    updateBanner(currentIndex);
                    resetAutoSlide();
                });
            });
            // Adicionando o evento de clique a todos os elementos com a classe 'prev-slide'
            document.querySelectorAll('.prev-slide').forEach(function(element) {
                element.addEventListener('click', function() {
                    currentIndex = (currentIndex - 1 + banners.length) % banners.length;
                    updateBanner(currentIndex);
                    resetAutoSlide();
                });
            });
            // Initialize with the first event
            updateBanner(currentIndex);
            // Automatic slide change every 8 seconds
            autoSlideInterval = setInterval(function() {
                currentIndex = (currentIndex + 1) % banners.length;
                updateBanner(currentIndex);
            }, 8000);
            window.addEventListener('resize', function() {
                updateBanner(currentIndex);
            });
            //Open banner
            function openBannerLink(link, bannerId) {
                if (!bannerId) return;

                fetch(`/cliente-ultra/banners/${bannerId}/read`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({})
                }).then(() => {
                    if (link === 'cta') {
                        scrollToCta();
                    } else if (link) {
                        window.open(link); // ou window.location.href = link;
                    }
                }).catch((error) => {
                    console.error('Erro ao registrar clique no banner:', error);
                    // Mesmo com erro, redireciona:
                    if (link === 'cta') {
                        scrollToCta();
                    } else if (link) {
                        window.open(link);
                    }
                });
            }
        </script>
    @endif
    @if($events->count() > 1)
        <script>
            let currentIndexEvent = 0;
            const events = @json($events);

            function updateEvent(index) {
                const event = events[index];
                const imageElement = document.getElementById('image-event');
                const dateElement = document.getElementById('date-event');
                const titleElement = document.getElementById('title-event');
                const descriptionElement = document.getElementById('description-event');
                const timeElement = document.getElementById('time-event');
                const localElement = document.getElementById('local-event');
                const buttonElement = document.getElementById('button-event');

                let dateText = new Date(event.date).toLocaleDateString('pt-BR');
                if (event.end_date) {
                    dateText += ' - ' + new Date(event.end_date).toLocaleDateString('pt-BR');
                }

                imageElement.style.backgroundImage = "url('" + '{{asset('')}}' + (event.photo ? event.photo.replace('public/', 'storage/') : '') + "')";
                dateElement.innerText = dateText;
                titleElement.innerText = event.title;
                descriptionElement.innerHTML = event.description;
                if (event.time){
                    timeElement.innerText = event.time;
                    $(timeElement).fadeIn(200);
                }else{
                    $(timeElement).hide();
                }
                if (event.local){
                    localElement.innerText = event.local;
                    $(localElement).fadeIn(200);
                }else{
                    $(localElement).hide();
                }
                buttonElement.href = '{{ route('events.show', '_SLUG_') }}'.replace('_SLUG_', event.slug);
            }

            function resetAutoSlideEvent() {
                clearInterval(autoSlideIntervalEvent);
                autoSlideIntervalEvent = setInterval(function() {
                    currentIndexEvent = (currentIndexEvent + 1) % events.length;
                    updateEvent(currentIndexEvent);
                }, 8000);
            }
            document.getElementById('event-next-slide').addEventListener('click', function() {
                currentIndexEvent = (currentIndexEvent + 1) % events.length;
                updateEvent(currentIndexEvent);
                resetAutoSlideEvent();
            });
            document.getElementById('event-prev-slide').addEventListener('click', function() {
                currentIndexEvent = (currentIndexEvent - 1 + events.length) % events.length;
                updateEvent(currentIndexEvent);
                resetAutoSlideEvent();
            });
            // Initialize with the first event
            updateEvent(currentIndexEvent);
            // Automatic slide change every 8 seconds
            autoSlideIntervalEvent = setInterval(function() {
                currentIndexEvent = (currentIndexEvent + 1) % events.length;
                updateEvent(currentIndexEvent);
            }, 8000);
            window.addEventListener('resize', function() {
                updateEvent(currentIndexEvent);
            });
        </script>
    @endif
    @if($articles->count() > 1)
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js" defer></script>
    @endif
    {{-- RocketChat --}}
    @if(Auth::guard('ultralims')->user() != null && Auth::guard('ultralims')->user()->chat)
        <script type="text/javascript">
            (function(w, d, s, u) {
                w.RocketChat = function(c) { w.RocketChat._.push(c) }; w.RocketChat._ = []; w.RocketChat.url = u;
                var h = d.getElementsByTagName(s)[0], j = d.createElement(s);
                j.async = true; j.src = 'https://atendimento.ultralims.com.br/livechat/rocketchat-livechat.min.js?_=201903270000';
                h.parentNode.insertBefore(j, h);
            })(window, document, 'script', 'https://atendimento.ultralims.com.br/livechat');
        </script>
    @endif

    {{-- LiveChat --}}
    {{--
    <script src='https://ultralims.impetussistemas.com.br/build/assets/plugins/livechat/liveChat.js' wsPort='8443' domainName='https://ultralims.impetussistemas.com.br' defer></script>
    <script>
        $(document).ready(function() {
            // Supondo que o elemento shadow-host seja o host do Shadow DOM
            const shadowHost = document.querySelector('.mainLiveChatDiv');
            // Acesse o shadow root do host
            const shadowRoot = shadowHost.shadowRoot;
            $('#openLiveChat').click(function (){
                // Encontre o elemento dentro do Shadow DOM
                const chatPopup = shadowRoot.querySelector('#chat-popup');
                chatPopup.click();
            });
        });
    </script>
    --}}
@endpush