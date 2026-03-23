@extends('admin.layout')

@push('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" integrity="sha512-zxBiDORGDEAYDdKLuYU9X/JaJo/DPzE42UubfBw9yg8Qvb2YRRIQ8v4KsGHOx2H1/+sdSXyXxLXv5r7tHc9ygg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .avatar {
            position: relative;
            height: 200px;
            width: 200px;
            background:#e8e8e8;
            border-radius: 8px;
        }

        .avatar img {
            width: 200px;
            height: 200px;
            border-radius: 8px;
        }

        .avatar .options {
            width: 30px;
            background: rgba(0,0,0,0.8);
            position: absolute;
            right: 5px;
            top: 5px;
            bottom: 5px;
            opacity: 0;
            z-index: -1;
            pointer-events: none;
            border-radius: 0 8px 8px 0;
            transition: all 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
        }

        .avatar .options button {
            width: 20px;
            height: 20px;
            border: 0;
            background: transparent;
            color: #FFF;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease-in-out;
        }
        .avatar .options button.edit:hover {
            color: #5784c0;
            background: #5784c020;
        }
        .avatar .options button.trash:hover {
            color: #f44336;
            background: #f4433600;
        }

        .avatar .plus {
            width: 100%;
            position: absolute;
            height: 100%;
            font-size: 56px;
            background: rgba(0,0,0,0.8);
            color: #FFF;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            opacity: 0;
            z-index: -1;
            pointer-events: none;
        }

        .avatar:hover .options,
        .avatar:hover .plus {
            opacity: 1;
            z-index: 15;
            pointer-events: initial;
        }

        .modal_croppie {
            position: fixed;
            top: 0;left: 0;right: 0;bottom: 0;
            background: rgba(0,0,0,0.8);
            z-index: -5;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
        }
        .modal_croppie.show {
            opacity: 1;
            pointer-events: initial;
            z-index: 99;
        }
        .modal_croppie .content {
            border-radius: 8px;
            padding: 4px;
        }
    </style>
    <style>
        .contentCroppie{
            background: #FFF;
        }

        [data-theme="dark"] .contentCroppie{
            background: #1e1e2d;
        }
    </style>
@endpush

@section('content')
    @if($user->id > 0)
        @include('admin.pages.users.header')
    @endif

    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Informações do perfil</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="kt_account_settings_profile_details" class="collapse show">
            <!--begin::Form-->
            <form id="kt_account_profile_details_form" class="form saveUser">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Foto</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Image input-->
                            <div class="d-flex w-100">
                                <div class="avatar">

                                    <input type="file" class="d-none" accept="image/*" name="foto" id="foto">

                                    <div class="options" style="display: none">
                                        <button type="button" class="edit changeImage" title="Editar">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button type="button" class="trash" title="Remover">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <button type="button" class="cancel d-none" title="Cancelar">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>

                                    <div class="plus">
                                        <i class="fa fa-plus"></i>
                                    </div>
                                </div>

                                <div class="modal_croppie">
                                    <div class="content contentCroppie">
                                        <div class="cropper"></div>
                                        <div class="d-flex mt-2 mb-2 align-items-center justify-content-end">
                                            <button type="button" class="btn btn-sm btn-secondary cropped-image-cancel" style="margin-right: 8px">Cancelar</button>
                                            <button type="button" class="btn btn-sm btn-primary cropped-image-send" style="margin-right: 6px">Recortar e salvar</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--end::Image input-->
                            <!--begin::Hint-->
                            <div class="form-text">Formatos aceitos: png, jpg, jpeg.</div>
                            <!--end::Hint-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Nome completo</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="text" name="name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Nome" value="{{ $user->name }}" required/>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="text" name="lastname" class="form-control form-control-lg form-control-solid" placeholder="Sobrenome" value="{{ $user->lastname }}" required/>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Descrição</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <textarea rows="3" name="description" class="form-control form-control-lg form-control-solid" placeholder="Descrição" style="resize: none" required>{!! nl2br($user->description) !!}</textarea>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6" id="div-email">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                            E-Mail
                        </label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="email" name="email" class="form-control form-control-lg form-control-solid" placeholder="E-mail" value="{{ $user->email }}"/>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Cargo</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <input type="text" name="office" class="form-control form-control-lg form-control-solid" placeholder="Cargo" value="{{ $user->office }}"/>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                    @can('Usuários')
                        <!--begin::Input group-->
                        <div class="row mb-6" id="div-status">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span class="required">Acesso</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <select name="access_type" aria-label="Selecione uma opção" data-control="select2" data-placeholder="Selecione uma opção..." class="form-select form-select-solid form-select-lg fw-semibold" required>
                                    <option value="">Selecione uma opção...</option>
                                    <option value="panel" {{ $user->access_type == 'panel' ? 'selected':'' }}>Painel</option>
                                    <option value="page" {{ $user->access_type == 'page' ? 'selected':'' }}>Página</option>
                                </select>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mb-6" id="div-status">
                            <!--begin::Label-->
                            <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                <span class="required">Status</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Col-->
                            <div class="col-lg-8 fv-row">
                                <select name="status" aria-label="Select a Country" data-control="select2" data-placeholder="Selecione uma opção..." class="form-select form-select-solid form-select-lg fw-semibold" required>
                                    <option value="">Selecione uma opção...</option>
                                    <option value="1" {{ $user->status ? 'selected':'' }}>Ativo</option>
                                    <option value="0" {{ !$user->status && $user->id > 0 ? 'selected':'' }}>Inativo</option>
                                </select>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->
                    @endcan
                    <!--begin::Input group-->
                    <div class="row mb-6" id="div-password">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Senha</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <!--begin::Row-->
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="password" name="password" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="Senha"/>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-lg-6 fv-row">
                                    <input type="password" name="confirm_password" class="form-control form-control-lg form-control-solid" placeholder="Confirmar senha"/>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Card body-->
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="submit" id="btnSubmit" class="btn btn-primary">
                        <span class="indicator-label">Salvar</span>
                        <span class="indicator-progress">Aguarde...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content-->
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js" integrity="sha512-Gs+PsXsGkmr+15rqObPJbenQ2wB3qYvTHuJO6YJzPe/dTLvhy0fmae2BcnaozxDo5iaF8emzmCZWbQ1XXiX2Ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        @if($user->photo != null)
            let user_profile = '{{ asset(str_replace('public/', 'storage/', $user->photo)) }}';
            let user_profile_delete = true;
        @else
            let user_profile = null;
            let user_profile_delete = false;
        @endif

        // Avatar Scripts
        let $croppie = '';
        let $croppieModal = '.modal_croppie';
        let $croppieImage = '.cropper';

        // Source of image cropped, this is important to upload
        let $croppedImage = '';

        var submitButton = document.getElementById('btnSubmit');

        $('.saveUser').on("submit", function(e){
            e.preventDefault();

            submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
            submitButton.disabled = true;


            var form = new FormData(this);
            @if($user->id > 0)
                form.append('_method', 'PUT');
            @endif
            if($croppedImage != ''){
                $('#foto').remove();
                form.append('_profile', $croppedImage);
            }
            $.ajax({
                url: '{{ $user->id > 0 ? route('admin.users.update', $user->hash_id):route('admin.users.store') }}',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function(data){
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;
                    if(data.success === true){
                        Swal.fire('Sucesso!', data.message, 'success').then(() => {
                            location.reload();
                        });
                    }else{
                        Swal.fire('Erro', data.message, 'error');
                    }
                },
                error: function(data){
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;
                    Swal.fire('Falha!', data.message, 'error');
                }
            });
        });
    </script>
    <script>
        $('.plus, .changeImage').on('click', function(){
            if($(this).hasClass('plus')) $(this).parent().find('input#foto').click();
            else $(this).parent().parent().find('input#foto').click();
        });

        $('input#foto').on('change', function(){
            if($croppie != ''){
                _destroy_croppie();
            }
            $croppie = $($croppieModal).find($croppieImage).croppie({
                viewport: {
                    width: 250,
                    height: 250
                },
                boundary: {
                    width: 350,
                    height: 350
                }
            });

            var reader = new FileReader();
            reader.onload = function (e) {
                $croppie.croppie('bind', {
                    url: e.target.result
                })
            }
            reader.readAsDataURL(this.files[0]);

            $($croppieModal).addClass('show');
        });

        $('.cropped-image-send').on('click', function(e){
            e.preventDefault();
            $croppie.croppie('result', {
                type: 'canvas',
                size: 'viewport',
                quality: 1
            }).then(function (resp) {
                $croppedImage = resp;
                setImageView($croppedImage);
                _avatar_plus_remove();
                _avatar_option_show();
                _avatar_option_edit_show();
                _avatar_option_cancel_show();
                _avatar_option_trash_remove();
                _destroy_croppie();
            });
            $($croppieModal).removeClass('show');
        })

        $('.cropped-image-cancel, .avatar .options button.cancel').on('click', function(e){
            e.preventDefault();
            _destroy_croppie();
            $croppedImage = '';

            if(user_profile != null){
                setImageView(user_profile);
                _avatar_option_edit_show();
                _avatar_option_trash_show();
                _avatar_option_cancel_remove();
                _avatar_option_show();
            }else{
                removeImageView();
                _avatar_option_cancel_remove();
                _avatar_option_trash_remove();
                _avatar_option_edit_remove();
                _avatar_option_remove();
                _avatar_plus_show();
            }
            $($croppieModal).removeClass('show');
            remove_deleteImage();
        })

        $('.avatar .options button.trash').on('click', function(e){
            e.preventDefault();
            if(user_profile == null){
                return alertMessage('Erro!', 'error', 'Para excluir uma imagem, você precisa ter uma salva!');
            }
            user_profile_delete = true;
            append_deleteImage();
            _avatar_option_edit_remove();
            _avatar_option_trash_remove();
            _avatar_option_cancel_remove();
            _avatar_option_remove();
            _avatar_plus_remove();
            _destroy_croppie();
            removeImageView();
            _avatar_plus_show();
        })

        let alertMessage = function(title, type, message){
            Swal.fire(title, message, type);
        }

        let clear_avatar = function(){
            user_profile = null;
            user_profile_delete = false;
            $croppedImage = '';
            $croppie = '';
            _destroy_croppie();
            removeImageView();
            _avatar_option_cancel_remove();
            _avatar_option_trash_remove();
            _avatar_option_edit_remove();
            _avatar_option_remove();
            _avatar_plus_show();
        }

        let _destroy_croppie = () => {
            if($croppie != ''){
                $croppie.croppie('destroy');
            }
        }

        let _avatar_plus_show = () => {
            $('.avatar .plus').removeClass('d-none').show();
        }

        let _avatar_plus_remove = () => {
            $('.avatar .plus').hide().addClass('d-none');
        }

        let _avatar_option_show = () => {
            $('.avatar .options').removeClass('d-none').show();
        }

        let _avatar_option_remove = () => {
            $('.avatar .options').hide().addClass('d-none');
        }

        let _avatar_option_edit_show = () => {
            $('.avatar .options button.edit').removeClass('d-none');
        }

        let _avatar_option_edit_remove = () => {
            $('.avatar .options button.edit').addClass('d-none');
        }

        let _avatar_option_trash_show = () => {
            $('.avatar .options button.trash').removeClass('d-none');
        }

        let _avatar_option_trash_remove = () => {
            $('.avatar .options button.trash').addClass('d-none');
        }

        let _avatar_option_cancel_show = () => {
            $('.avatar .options button.cancel').removeClass('d-none');
        }

        let _avatar_option_cancel_remove = () => {
            $('.avatar .options button.cancel').addClass('d-none');
        }

        let _has_avatar = () => {
            return $('.avatar img').length > 0;
        }

        let setImageView = (image) => {
            __imageAttribute = '<img src="'+image+'" alt="">';
            if(!_has_avatar()){
                $('.avatar').prepend(__imageAttribute);
            }else{
                $('.avatar img').attr('src', image);
            }
        }

        let removeImageView = () => {
            if(_has_avatar()){
                $('.avatar img').remove();
            }
        }

        function append_deleteImage(){
            $('.profileForm').append('<input type="hidden" name="delete_image" value="true">');
        }

        function remove_deleteImage(){
            $('.profileForm input[name="delete_image"]').remove();
        }

        @if($user->photo != null)
            setImageView(user_profile);
            _avatar_plus_remove();
            _avatar_option_show();
            _avatar_option_edit_show();
            _avatar_option_trash_show();
        @endif
        // End Avatar Scripts
    </script>
@endpush
