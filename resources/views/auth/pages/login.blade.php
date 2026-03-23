@extends('auth.layout')

@section('content')
    <!--begin::Body-->
    <div class="d-flex flex-center w-lg-50 p-10" id="div-login">
        <!--begin::Card-->
        <div class="card rounded-3 w-md-550px">
            <!--begin::Card body-->
            <div class="card-body p-10 p-lg-20">
                <!--begin::Form-->
                <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" action="{{route('auth.makeLogin')}}">
                    <!--begin::Heading-->
                    <div class="text-center mb-11">
                        <!--begin::Title-->
                        <h1 class="text-dark fw-bolder mb-3">Entrar</h1>
                        <!--end::Title-->
                        <!--begin::Subtitle-->
                        <div class="text-gray-500 fw-semibold fs-6">Seu painel de controle</div>
                        <!--end::Subtitle=-->
                    </div>
                    <!--begin::Heading-->
                    <!--begin::Input group=-->
                    <div class="fv-row mb-8">
                        <!--begin::Email-->
                        <input type="text" placeholder="E-mail" name="email" id="email" autocomplete="off" class="form-control bg-transparent" />
                        <!--end::Email-->
                    </div>
                    <!--end::Input group=-->
                    <div class="fv-row mb-3">
                        <!--begin::Password-->
                        <input type="password" placeholder="Senha" name="password" id="password" autocomplete="off" class="form-control bg-transparent" />
                        <!--end::Password-->
                    </div>
                    <!--end::Input group=-->
                    {{--
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                        <div></div>
                        <!--begin::Link-->
                        <a href="{{route('auth.forgetPassword')}}" class="link-primary">Esqueci minha senha</a>
                        <!--end::Link-->
                    </div>
                    <!--end::Wrapper-->
                    --}}
                    <!--begin::Submit button-->
                    <div class="d-grid mb-10">
                        <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                            <!--begin::Indicator label-->
                            <span class="indicator-label">Continuar</span>
                            <!--end::Indicator label-->
                            <!--begin::Indicator progress-->
                            <span class="indicator-progress">Aguarde...
										<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            <!--end::Indicator progress-->
                        </button>
                    </div>
                    <!--end::Submit button-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Body-->

    <!--begin::Body-->
    <div class="d-flex flex-center w-lg-50 p-10" id="div-two-factor" style="display: none !important;">
        <!--begin::Wrapper-->
        <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
            <!--begin::Content-->
            <div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
                <!--begin::Wrapper-->
                <div class="d-flex flex-center flex-column-fluid">
                    <!--begin::Form-->
                    <form class="form w-100" novalidate="novalidate" id="kt_sing_in_two_steps_form">
                        <!--begin::Heading-->
                        <div class="text-center mb-10">
                            <!--begin::Title-->
                            <h1 class="text-dark mb-3">Verificação em duas etapas</h1>
                            <!--end::Title-->
                            <!--begin::Sub-title-->
                            <div class="text-muted fw-semibold fs-5 mb-5">Insira o código que foi cadastrado no seu<br><strong>Google Authenticator</strong></div>
                            <!--end::Sub-title-->
                        </div>
                        <!--end::Heading-->
                        <!--begin::Section-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <div class="fw-bold text-start text-dark fs-6 mb-1 ms-1">Insira seu código de segurança</div>
                            <!--end::Label-->
                            <!--begin::Input group-->
                            <div class="d-flex flex-wrap flex-stack">
                                <input type="text" name="code" class="form-control bg-transparent h-60px w-100 fs-2qx text-center mx-1 my-2" value="" />
                            </div>
                            <!--begin::Input group-->
                        </div>
                        <!--end::Section-->
                        <!--begin::Submit-->
                        <div class="d-flex flex-center">
                            <button type="submit" id="kt_sing_in_two_steps_submit" class="btn btn-lg btn-primary fw-bold">
                                <span class="indicator-label">Continuar</span>
                                <span class="indicator-progress">Aguarde...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                        <!--end::Submit-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Body-->
@endsection

@section('scripts')
<!--begin::Page Custom Javascript(used by this page)-->
    <script src="{{asset('assets/js/custom/authentication/sign-in/general.js')}}"></script>
    <script>
        var submitButtonTwoSteps = document.getElementById('kt_sing_in_two_steps_submit');
        $('#kt_sing_in_two_steps_form').on("submit", function(e) {
            e.preventDefault();

            submitButtonTwoSteps.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
            submitButtonTwoSteps.disabled = true;

            var form = new FormData(this);
            form.append('email', $('#email').val());
            form.append('password', $('#password').val());

            $.ajax({
                url: '{{ route('auth.makeLoginCode') }}',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function(data){
                    submitButtonTwoSteps.removeAttribute('data-kt-indicator');
                    submitButtonTwoSteps.disabled = false;

                    if(data.status){
                        window.location.href = data.url;
                    }else{
                        Swal.fire('Erro', data.message, 'error');
                    }
                },
                error: function(data){
                    submitButtonTwoSteps.removeAttribute('data-kt-indicator');
                    submitButtonTwoSteps.disabled = false;

                    Swal.fire('Erro', 'Ocorreu um erro ao tentar se conectar', 'error');
                }
            });
        });
        @if(Session::has('success'))
            Swal.fire('Sucesso!', "{{session::get('success')}}", 'success');
        @endif
    </script>
<!--end::Page Custom Javascript-->
@endsection
