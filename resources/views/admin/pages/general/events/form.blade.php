@extends('admin.layout')

@push('head')
    <link rel="stylesheet" href="{{ asset('ckeditor/sample/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" integrity="sha512-zxBiDORGDEAYDdKLuYU9X/JaJo/DPzE42UubfBw9yg8Qvb2YRRIQ8v4KsGHOx2H1/+sdSXyXxLXv5r7tHc9ygg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .avatar {
            position: relative;
            height: {{ env('APP_NAME') == 'AABB-SP' ? '100':'82' }}px;
            width: 240px;
            background:#e8e8e8;
            border-radius: 8px;
        }

        .avatar img {
            max-width: 240px;
            max-height: 100px;
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
        .contentCroppie{
            background: #FFF;
        }

        [data-theme="dark"] .contentCroppie{
            background: #1e1e2d;
        }
    </style>
@endpush

@section('content')
    <!--begin::Form-->
    <form class="form d-flex flex-column flex-lg-row saveEvent">
        <!--begin::Aside column-->
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10" style="min-width: 300px !important;">
            <!--begin::Thumbnail settings-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>Foto em destaque</h2>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body text-center pt-0">
                    <div class="avatar mb-3">
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
                    <!--begin::Modal croppie-->
                    <div class="modal_croppie">
                        <div class="content contentCroppie">
                            <div class="cropper"></div>
                            <div class="d-flex mt-2 mb-2 align-items-center justify-content-end">
                                <button type="button" class="btn btn-sm btn-secondary cropped-image-cancel" style="margin-right: 8px">Cancelar</button>
                                <button type="button" class="btn btn-sm btn-primary cropped-image-send" style="margin-right: 6px">Recortar e salvar</button>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal croppie-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7">Somente arquivos de imagem *.png, *.jpg e *.jpeg são aceitos. A imagem será convertida em *.webp.</div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Thumbnail settings-->
            <!--begin::Foto-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2 class="required">Foto</h2>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Select2-->
                    <input type="file" class="form-control mb-2" name="photo_square">
                    <!--end::Select2-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7">Imagem quadrada do evento.</div>
                    <!--end::Description-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Foto-->
            <!--begin::Status-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>Status</h2>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <div class="rounded-circle bg-success w-15px h-15px" id="status_icon"></div>
                    </div>
                    <!--begin::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Select2-->
                    <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="status" name="status">
                        <option></option>
                        <option value="1" {{ $event->status == 1 || $event->id == null ? 'selected':'' }}>Ativo</option>
                        <option value="0" {{ $event->status == 0 && $event->id > 0 ? 'selected':'' }}>Inativo</option>
                    </select>
                    <!--end::Select2-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7">Defina o status do evento.</div>
                    <!--end::Description-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Status-->
            <!--begin::Botão-->
            {{--<div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>Botão</h2>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <label class="form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input cursor-pointer" type="checkbox" value="1" name="button_display" id="button_display" {{ $event->button_display ? 'checked="checked"':'' }}>
                    </label>
                    <!--begin::Description-->
                    <div class="text-muted fs-7 mt-4">Defina se será exibido o botão.</div>
                    <!--end::Description-->
                </div>
                <!--end::Card body-->
            </div>--}}
            <!--end::Botão-->
        </div>
        <!--end::Aside column-->
        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <!--begin::General options-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>Geral</h2>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Input group-->
                    <div class="mb-10 row">
                        <div class="col-4">
                            <!--begin::Label-->
                            <label class="required form-label">Título</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="title" class="form-control" value="{{ $event->title }}"/>
                            <!--end::Input-->
                        </div>
                        <div class="col-4">
                            <!--begin::Label-->
                            <label class="required form-label">Data Inicial</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="date" name="date" class="form-control" value="{{ optional($event->date)->format('Y-m-d') }}"/>
                            <!--end::Input-->
                        </div>
                        <div class="col-4">
                            <!--begin::Label-->
                            <label class="form-label">Data Final</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="date" name="end_date" class="form-control" value="{{ optional($event->end_date)->format('Y-m-d') }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-10 row">
                        <div class="col-12">
                            <!--begin::Label-->
                            <label class="required form-label">Slug</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="slug" class="form-control mb-2" placeholder="Slug" value="{{ $event->slug }}"/>
                            <!--end::Input-->
                            <!--begin::Description-->
                            <div class="text-muted fs-7">
                                @if($event->id > 0)
                                    <a href="#" target="_blank">
                                        {{url('/')}}/<span id="preview-type">eventos/</span><span id="preview-slug">{{ $event->slug }}</span>
                                    </a>
                                @else
                                    {{url('/')}}/<span id="preview-type">eventos/</span><span id="preview-slug">{{ $event->slug }}</span>
                                @endif
                            </div>
                            <!--end::Description-->
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-10 row">
                        <div class="col-12">
                            <!--begin::Label-->
                            <label class="form-label">Descrição</label>
                            <!--end::Label-->
                            <textarea name="description" class="form-control mb-2" rows="2" style="resize: none">{!! $event->description !!}</textarea>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-10 row">
                        <div class="col-12">
                            <!--begin::Label-->
                            <label class="form-label required">Conteúdo</label>
                            <!--end::Label-->
                            <textarea id="content" class="form-control mb-2" rows="5" style="resize: none">{!! $event->content !!}</textarea>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row">
                        <div class="col-6">
                            <!--begin::Label-->
                            <label class="form-label">Horário</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="time" class="form-control" value="{{ $event->time }}"/>
                            <!--end::Input-->
                        </div>
                        <div class="col-6">
                            <!--begin::Label-->
                            <label class="form-label">Local</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="local" class="form-control" value="{{ $event->local }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Card header-->
            </div>
            <!--end::General options-->
            <!--begin::General options-->
            {{--<div class="card card-flush py-4" id="div-button" {!! !$event->button_display ? 'style="display: none;"':'' !!}>
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>Botão</h2>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Input group-->
                    <div class="row">
                        <div class="col-6">
                            <!--begin::Label-->
                            <label class="form-label required">Título</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="button_title" class="form-control mb-2" value="{{ $event->button_title }}"/>
                            <!--end::Input-->
                        </div>
                        <div class="col-6">
                            <!--begin::Label-->
                            <label class="form-label required">Tipo</label>
                            <!--end::Label-->
                            <!--begin::Select2-->
                            <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="button_type" name="button_type">
                                <option></option>
                                <option value="inner_page" {{ $event->button_type == 'inner_page' ? 'selected':'' }}>Página interna</option>
                                <option value="link" {{ $event->button_type == 'link' ? 'selected':'' }}>Link</option>
                            </select>
                            <!--end::Select2-->
                        </div>
                    </div>
                    <!--end::Input group-->
                    <div class="row">
                        <div class="col-12 mt-10" id="div-inner-page" style="display: none">
                            <!--begin::Label-->
                            <label class="form-label required">Página interna</label>
                            <!--end::Label-->
                            <!--begin::Select2-->
                            <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="button_pagina" name="button_pagina">
                                <option></option>
                                @foreach($pages as $page)
                                    <option value="{{ $page->id }}" {{ $event->button_link == $page->id ? 'selected':'' }}>{{ $page->title }}</option>
                                @endforeach
                            </select>
                            <!--end::Select2-->
                        </div>
                        <div class="col-12 mt-10" id="div-link" style="display: none">
                            <!--begin::Label-->
                            <label class="required form-label">Link</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="button_url" class="form-control mb-2" value="{{ $event->button_type == 'link' ? $event->button_link : '' }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                </div>
                <!--end::Card header-->
            </div>--}}
            <!--end::General options-->
            <!--end::Tab content-->
            <div class="d-flex justify-content-end">
                <!--begin::Button-->
                <button type="submit" id="btnSubmit" class="btn btn-primary">
                    <span class="indicator-label">Salvar</span>
                    <span class="indicator-progress">Aguarde...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
                <!--end::Button-->
            </div>
        </div>
        <!--end::Main column-->
    </form>
    <!--end::Form-->
@endsection

@push('scripts')
    <script src="{{asset('ckeditor-page/build/ckeditor.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js" integrity="sha512-Gs+PsXsGkmr+15rqObPJbenQ2wB3qYvTHuJO6YJzPe/dTLvhy0fmae2BcnaozxDo5iaF8emzmCZWbQ1XXiX2Ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- DECLARAÇÃO DE VARIÁVEIS --}}
    <script>
        @if($event->photo != null)
            let user_profile = '{{ str_replace('public/', 'storage/', asset($event->photo)) }}';
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
    </script>
    {{-- SUBMIT FORMULÁRIO --}}
    <script>
        $('.saveEvent').on("submit", function(e){
            e.preventDefault();

            submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
            submitButton.disabled = true;

            // Forcefully set the date fields to ensure they are included in the request
            var dateField = document.querySelector('input[name="date"]');
            var endDateField = document.querySelector('input[name="end_date"]');

            if (dateField) {
                dateField.value = dateField.value || '{{ optional($event->date)->format('Y-m-d') }}';
            }

            if (endDateField) {
                endDateField.value = endDateField.value || '{{ optional($event->end_date)->format('Y-m-d') }}';
            }

            var form = new FormData(this);
            form.append('content', content.getData());
            @if($event->id > 0)
            form.append('_method', 'PUT');
            @endif
            if($croppedImage != ''){
                $('#foto').remove();
                form.append('imagem', $croppedImage);
            }else{
                form.append('imagem', user_profile)
            }

            $.ajax({
                url: '{{$event->id > 0 ? route('admin.events.update', $event->hash_id):route('admin.events.store')}}',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function(data){
                    if(data.success){
                        Swal.fire({
                            text: data.message,
                            icon: "success",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Ver eventos",
                            cancelButtonText: "Novo evento",
                            customClass: {
                                confirmButton: "btn fw-bold btn-secondary",
                                cancelButton: "btn fw-bold btn-primary"
                            },
                            allowOutsideClick: false
                        }).then((function (t) {
                            if (t.value){
                                window.location.href = '{{route('admin.events.index')}}'
                            }else{
                                window.location.href = '{{route('admin.events.create')}}'
                            }
                        }))
                    }else{
                        Swal.fire('Erro', data.message, 'error');
                        submitButton.removeAttribute('data-kt-indicator');
                        submitButton.disabled = false;
                    }
                },
                error: function(data){
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;
                    Swal.fire('Erro', 'Falha ao {{ $event->id > 0 ? 'salvar':'editar' }} evento, tente novamente', 'error');
                }
            });
        });
    </script>
    {{-- SE EXIBE OU NÃO O CARD DE BOTÃO/SE EXIBE OU NÃO PÁGINA INTERNA E LINK --}}
    <script>
        $('#button_display').on('change', function(){
            if($(this).is(':checked')){
                $('#div-button').show();
            }else{
                $('#div-button').hide();
            }
        });

        $('#button_type').on('change', function (){
           if ($(this).val() === 'inner_page'){
               $('#div-inner-page').show();
               $('#div-link').hide();
           }else if ($(this).val() === 'link'){
               $('#div-inner-page').hide();
               $('#div-link').show();
           }
        });
        $('#button_type').change();
    </script>
    {{--EDITORES --}}
    <script>
        let content;
        ClassicEditor.create(document.querySelector( '#content' ), {
            language: 'pt-br',
            removePlugins: ['Title'],
            placeholder: '',
            link: {
                addTargetToExternalLinks: true // Esta configuração adiciona target="_blank" a todos os links externos.
            }
        }).then( newEditor => {
            content = newEditor;
        }).catch( error => {});
    </script>
    {{-- SLUG --}}
    <script>
        @if($event->id == 0)
            $('[name="title"]').on('change', function(){
                var name = $(this).val();
                generateSlug(name)
            });
        @endif
        $('[name="slug"]').on('change', function(){
            generateSlug($(this).val());
        });
        function generateSlug(title){
            var $slug_input = $('[name="slug"]');
            $.ajax({
                url: '{{route('admin.events.get.slug')}}',
                type: 'POST',
                data: {title: title},
                dataType: 'json',
                success: function(data){
                    if(data.success){
                        $slug_input.val(data.slug);
                        $('#preview-slug').html(data.slug);
                        $('[name="slug"]').keyup();
                    }else{
                        Swal.fire('Erro', 'Este slug já existe, geramos um que não foi usado', 'error').then(() => {
                            $slug_input.val(data.suggestion);
                        });
                    }
                },
                error: function(data){
                    Swal.fire('Erro', 'Falha ao gerar slug, tente novamente', 'error');
                }
            });
        }
    </script>
    {{-- DECLARAÇÃO: (STATUS) --}}
    <script>
        var statusColors = ["bg-success", "bg-danger"];
        var statusIcon = document.getElementById("status_icon");
        $('#status').on('change', function (){
            switch (this.value) {
                case"1":
                    statusIcon.classList.remove(...statusColors);
                    statusIcon.classList.add("bg-success");
                    break;
                case"0":
                    statusIcon.classList.remove(...statusColors);
                    statusIcon.classList.add("bg-danger");
                    break;
            }
        });
        $('#status').trigger('change');
    </script>
    {{-- SCRIPTS THUMB --}}
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
                    width: 960,
                    height: {{ env('APP_NAME') == 'AABB-SP' ? '325':'326' }}
                },
                boundary: {
                    width: 1010,
                    height: {{ env('APP_NAME') == 'AABB-SP' ? '425':'426' }}
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
                size: {width: 1920, height: {{ env('APP_NAME') == 'AABB-SP' ? '650':'652' }} }, // Dobro da largura e altura do viewport
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
            user_profile = null;
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

        @if($event->photo != null)
            setImageView(user_profile);
            _avatar_plus_remove();
            _avatar_option_show();
            _avatar_option_edit_show();
            _avatar_option_trash_show();
        @endif
        // End Avatar Scripts
    </script>
@endpush
