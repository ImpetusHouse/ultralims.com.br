<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('site.inc.head')

<!-- Overlay de carregamento -->
<div id="global-loader"
     style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5);
            z-index:9999; align-items:center; justify-content:center;">
    <div style="background:white; padding:24px; border-radius:8px;
              box-shadow:0 4px 20px rgba(0,0,0,0.2); text-align:center;">

        <div style="width:48px; height:48px;
                      border:4px solid #3B82F6;
                      border-top-color:transparent;
                      border-radius:50%;
                      animation:spin 1s linear infinite;
                      margin:0 auto 12px auto;
                    "></div>

        <span style="color:#374151; font-weight:500;">Carregando...</span>
    </div>
</div>
<style>
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>

<body class="antialiased bg-body text-body font-body">
{{-- HEADER --}}
@include('site.pages.ultralims.inc.header')

{{-- CONTEÚDO --}}
<main class="allButFooter">
    @yield('content')
</main>

@if(Auth::guard('ultralims')->user() != null)
    @include('site.inc.cookies.ultralims')
@endif

@php
    $cookie = \App\Models\Settings\Cookie::orderBy('title')->first();
@endphp
@if($cookie->status)
    @include('site.inc.cookies.layout_1', ['cookie' => $cookie])
@endif

{{-- MODAL --}}
@include('site.inc.modals.youtube')
@include('site.inc.modals.card')
@include('site.pages.ultralims.inc.modal')

{{-- Modal A: Comunicado Coletas Ultra --}}
{{--@include('site.pages.ultralims.inc.app-coletas-ultra-comunicado')--}}

{{-- Modal B: Formulário de Atualização --}}
@php
    $idUser = \Illuminate\Support\Facades\Auth::guard('ultralims')->user()->idUser;
    $idLaboratorio = \Illuminate\Support\Facades\Auth::guard('ultralims')->user()->idLaboratorio;
    $showFormModal = (\App\Models\UltraLims\UL_Form::where('idUser', $idUser)->where('idLaboratorio', $idLaboratorio)->count() == 0);
@endphp
@if($showFormModal && !Str::startsWith(\Illuminate\Support\Facades\Auth::guard('ultralims')->user()->user, 'spu_'))
    @include('site.pages.ultralims.inc.form')
@endif

{{-- FOOTER --}}
@include('site.inc.footers.'.env('APP_NAME'))

@include('site.inc.scripts')
<script>
    // Variável Blade para informar ao JavaScript se o Modal B deve ser exibido
    const shouldShowFormModal = @json($showFormModal);

    // Lógica de exibição sequencial dos modais
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Tenta exibir o Modal A (Comunicado Coletas Ultra)
        const coletasModal = document.getElementById('coletasUltraModal');
        const formModal = document.getElementById('updateFormModal');

        // Verifica se o Modal A existe e se deve ser exibido (lógica no app-coletas-ultra-comunicado.blade.php)
        if (coletasModal && typeof shouldShowColetasUltraModal === 'function' && shouldShowColetasUltraModal()) {
            // O Modal A será exibido. A lógica de mostrar o Modal B deve ser chamada APÓS o fechamento do Modal A.
            // A função closeColetasUltraModal (em app-coletas-ultra-comunicado.blade.php) será modificada para chamar showNextModal.
            setTimeout(showColetasUltraModal, 1000); // Mostra Modal A após 1 segundo
        } else if (shouldShowFormModal && formModal) {
            // Se o Modal A não deve ser exibido, e o Modal B deve, exibe o Modal B diretamente.
            showNextModal();
        }
    });

    // Função para exibir o próximo modal (Modal B)
    function showNextModal() {
        const formModal = document.getElementById('updateFormModal');
        if (shouldShowFormModal && formModal && typeof openUpdateFormModal === 'function') {
            // A função openUpdateFormModal está definida em form.blade.php
            setTimeout(openUpdateFormModal, 300); // Pequeno delay para transição
        }
    }

    // Codex AJAX redirection
    function openCodex(){
        showLoader();

        fetch('{{ route('ultralims.codex') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        })
            .then(r => r.json())
            .then(data => {
                if (data && data.url) {
                    window.location.href = data.url;
                } else {
                    console.error('Resposta sem URL:', data);
                }
            })
            .catch(err => {
                console.error('Erro ao acionar Codex:', err);
            })
            .finally(() => {
                hideLoader();
            });
    }
    function openIa(){
        showLoader();

        fetch('{{ route('ultralims.ia') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({})
        })
            .then(r => r.json())
            .then(data => {
                if (data && data.url) {
                    window.location.href = data.url;
                } else {
                    console.error('Resposta sem URL:', data);
                }
            })
            .catch(err => {
                console.error('Erro ao acionar Codex:', err);
            })
            .finally(() => {
                hideLoader();
            });
    }
</script>
@vite('resources/js/app.js')
</body>

</html>