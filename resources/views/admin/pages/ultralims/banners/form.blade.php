@extends('admin.layout')

@push('head')
    <link rel="stylesheet" href="{{ asset('ckeditor/sample/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" integrity="sha512-zxBiDORGDEAYDdKLuYU9X/JaJo/DPzE42UubfBw9yg8Qvb2YRRIQ8v4KsGHOx2H1/+sdSXyXxLXv5r7tHc9ygg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .avatar {
            position: relative;
            height: 100px;
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

        .color-input-box {
            position: relative !important;
        }

        .color-box {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-width: 2px !important;
            border-style: solid;
            border-color: #383855;
            border-radius: 5px;
            height: 35px;
            cursor: pointer;
        }

        .color-box p {
            margin-bottom: 0 !important;
            margin-top: 0 !important;
            font-size: 1.075rem;
            padding: 6px;
        }

        .color-select {
            width: 34px;
            height: 35px;
            border-radius: 5px;
            border-width: 2px !important;
            border-right: 0px !important;
            border-style: solid;
            border-color: #383855 !important;
        }

        .colors-parent-box {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 2rem; /* 24px */
        }

        .colors-box {
            display: none;
            position: absolute;
            background: #fff;
            z-index: 99999 !important;
            top: 40px;
            flex-wrap: wrap;
            width: auto;
            border-width: 2px !important;
            border-style: solid;
            border-color: #383855;
            border-radius: 3px;
            min-width: 29px;
            padding: 5px;
        }

        [data-theme="dark"] .colors-box {
            background: #2b2b40 !important;
        }

        .colors-box > .color-input {
            width: 19px;
            height: 19px;
            border-width: 2px !important;
            border-style: solid;
            border-color: #383855;
            border-radius: 3px;
            margin-bottom: 3px;
            margin-right: 3px;
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <!--begin::Form-->
    <form class="form d-flex flex-column flex-lg-row saveBanner">
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
                        <option value="1" {{ $banner->status == 1 || $banner->id == null ? 'selected':'' }}>Ativo</option>
                        <option value="0" {{ $banner->status == 0 && $banner->id > 0 ? 'selected':'' }}>Inativo</option>
                    </select>
                    <!--end::Select2-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7">Defina o status do banner.</div>
                    <!--end::Description-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Status-->
            <!--begin::Botão-->
            <div class="card card-flush py-4">
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
                        <input class="form-check-input cursor-pointer" type="checkbox" value="1" name="button_display" id="button_display" {{ $banner->button_display ? 'checked="checked"':'' }}>
                    </label>
                    <!--begin::Description-->
                    <div class="text-muted fs-7 mt-4">Defina se será exibido o botão.</div>
                    <!--end::Description-->
                </div>
                <!--end::Card body-->
            </div>
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
                        <div class="col-8">
                            <!--begin::Label-->
                            <label class="form-label">Tag</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="tag" class="form-control" value="{{ $banner->tag }}"/>
                            <!--end::Input-->
                        </div>
                        <div class="col-2" style="display: flex; align-items: end">
                            <div class="color-box-parent w-100">
                                <div class="color-box">
                                    <!--begin::Label-->
                                    <p>Fundo</p>
                                    <!--end::Label-->
                                    <div class="color-select" style="background-color: {{ $banner->id > 0 ? $banner->tag_color:'#01AEF0' }}" id="tag_color"></div>
                                    <div class="colors-box">
                                        @foreach($colors as $color)
                                            <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2" style="display: flex; align-items: end">
                            <div class="color-box-parent w-100">
                                <div class="color-box">
                                    <!--begin::Label-->
                                    <p>Título</p>
                                    <!--end::Label-->
                                    <div class="color-select" style="background-color: {{ $banner->id > 0 ? $banner->tag_title_color:'#FFFFFF' }}" id="tag_title_color"></div>
                                    <div class="colors-box">
                                        @foreach($colors as $color)
                                            <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-10 row">
                        <div class="col-10">
                            <!--begin::Label-->
                            <label class="required form-label">Título</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="title" class="form-control" value="{{ $banner->title }}"/>
                            <!--end::Input-->
                        </div>
                        <div class="col-2" style="display: flex; align-items: end">
                            <div class="color-box-parent w-100">
                                <div class="color-box">
                                    <!--begin::Label-->
                                    <p>Cor</p>
                                    <!--end::Label-->
                                    <div class="color-select" style="background-color: {{ $banner->id > 0 ? $banner->title_color:'#0E1326' }}" id="title_color"></div>
                                    <div class="colors-box">
                                        @foreach($colors as $color)
                                            <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row">
                        <!--begin::Label-->
                        <label class="form-label required">Descrição</label>
                        <!--end::Label-->
                        <textarea id="description" name="description" class="form-control mb-2" rows="2" style="resize: none">{!! $banner->description !!}</textarea>
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Card header-->
            </div>
            <!--end::General options-->
            <!--begin::General options-->
            <div class="card card-flush py-4" id="div-button" {!! !$banner->button_display ? 'style="display: none;"':'' !!}>
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
                            <input type="text" name="button_title" class="form-control mb-2" value="{{ $banner->button_title }}"/>
                            <!--end::Input-->
                        </div>
                        <div class="col-6">
                            <!--begin::Label-->
                            <label class="form-label required">Tipo</label>
                            <!--end::Label-->
                            <!--begin::Select2-->
                            <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="button_type" name="button_type">
                                <option></option>
                                <option value="inner_page" {{ $banner->button_type == 'inner_page' ? 'selected':'' }}>Página interna</option>
                                <option value="link" {{ $banner->button_type == 'link' ? 'selected':'' }}>Link</option>
                            </select>
                            <!--end::Select2-->
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row">
                        <div class="col-12 mt-10" id="div-inner-page" style="display: none">
                            <!--begin::Label-->
                            <label class="form-label required">Página interna</label>
                            <!--end::Label-->
                            <!--begin::Select2-->
                            <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="button_pagina" name="button_pagina">
                                <option></option>
                                @foreach($pages as $page)
                                    <option value="{{ $page->id }}" {{ $banner->button_link == $page->id ? 'selected':'' }}>{{ $page->title }}</option>
                                @endforeach
                            </select>
                            <!--end::Select2-->
                        </div>
                        <div class="col-12 mt-10" id="div-link" style="display: none">
                            <!--begin::Label-->
                            <label class="required form-label">Link</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="button_url" class="form-control mb-2" value="{{ $banner->button_type == 'link' ? $banner->button_link : '' }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row mt-10">
                        <div class="col-4">
                            <div class="color-box-parent">
                                <div class="color-box">
                                    <!--begin::Label-->
                                    <p>Botão</p>
                                    <!--end::Label-->
                                    <div class="color-select" style="background-color: {{$banner->id > 0 ? $banner->button_color : '#01AEF0'}}" id="button_color"></div>
                                    <div class="colors-box">
                                        @foreach($colors as $color)
                                            <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="color-box-parent">
                                <div class="color-box">
                                    <!--begin::Label-->
                                    <p>Botão (Hover)</p>
                                    <!--end::Label-->
                                    <div class="color-select" style="background-color: {{$banner->id > 0 ? $banner->button_color_hover : '#018BC0'}}" id="button_color_hover"></div>
                                    <div class="colors-box">
                                        @foreach($colors as $color)
                                            <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="color-box-parent">
                                <div class="color-box">
                                    <!--begin::Label-->
                                    <p>Título</p>
                                    <!--end::Label-->
                                    <div class="color-select" style="background-color: {{$banner->id > 0 ? $banner->button_title_color : '#FFFFFF'}}" id="button_title_color"></div>
                                    <div class="colors-box">
                                        @foreach($colors as $color)
                                            <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Card header-->
            </div>
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
        @if($banner->image != null)
            let user_profile = '{{ str_replace('public/', 'storage/', asset($banner->image)) }}';
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
        $('.saveBanner').on("submit", function(e){
            e.preventDefault();

            submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
            submitButton.disabled = true;

            var form = new FormData(this);
            form.append('description', content.getData());
            @if($banner->id > 0)
                form.append('_method', 'PUT');
            @endif
            if($croppedImage != ''){
                $('#foto').remove();
                form.append('imagem', $croppedImage);
            }else{
                form.append('imagem', user_profile)
            }
            form.append('tag_color', $('#tag_color').css("background-color"));
            form.append('tag_title_color', $('#tag_title_color').css("background-color"));
            form.append('title_color', $('#title_color').css("background-color"));
            form.append('button_color', $('#button_color').css("background-color"));
            form.append('button_color_hover', $('#button_color_hover').css("background-color"));
            form.append('button_title_color', $('#button_title_color').css("background-color"));
            $.ajax({
                url: '{{$banner->id > 0 ? route('admin.banners.update', $banner->hash_id):route('admin.banners.store')}}',
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
                            confirmButtonText: "Ver banners",
                            cancelButtonText: "Novo banner",
                            customClass: {
                                confirmButton: "btn fw-bold btn-secondary",
                                cancelButton: "btn fw-bold btn-primary"
                            },
                            allowOutsideClick: false
                        }).then((function (t) {
                            if (t.value){
                                window.location.href = '{{route('admin.banners.index')}}'
                            }else{
                                window.location.href = '{{route('admin.banners.create')}}'
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
                    Swal.fire('Erro', 'Falha ao {{ $banner->id > 0 ? 'salvar':'editar' }} banner, tente novamente', 'error');
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
        ClassicEditor.create(document.querySelector( '#description' ), {
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
                    width: 990,
                    height: 467
                },
                boundary: {
                    width: 1090,
                    height: 569
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
                size: {width: 1980, height: 934}, // Dobro da largura e altura do viewport
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

        @if($banner->image != null)
            setImageView(user_profile);
            _avatar_plus_remove();
            _avatar_option_show();
            _avatar_option_edit_show();
            _avatar_option_trash_show();
        @endif
        // End Avatar Scripts
    </script>
    {{-- SCRIPT BOX SELECT BLOCK --}}
    <script>
        $(document).on('click', function (event) {
            if (!$(event.target).closest('.colors-box').length && !$(event.target).hasClass(
                'color-select')) {
                $('.colors-box').css('display', 'none');
            }
        });

        $('.color-box').on('click', function () {
            $('.colors-box').not($(this).children('.colors-box')).css('display', 'none');
            $(this).children('.colors-box').css('display', 'flex');
        });

        $('.colors-box div').on('click', function () {
            var color = $(this).css('background-color');
            $(this).closest('.color-box').find('.color-select').css('background-color', color);
            console.log($(this).siblings('.color-select'));
            $(this).parent().fadeOut(100);
        });

        /* antigo remover */

        $(document).on('click', function (event) {
            if (!$(event.target).closest('.color-select-box').length && !$(event.target).hasClass(
                'color-input-box')) {
                $('.color-select-box').css('display', 'none');
            }
        });

        $('.color-input-box').on('click', function () {
            $('.color-select-box').not($(this).children('.color-select-box')).css('display', 'none');
            $(this).children('.color-select-box').css('display', 'grid');
        });

        $('.color-select-box div').on('click', function () {
            var color = $(this).css('background-color');
            $(this).closest('.color-input-box').css('background-color', color);
            $(this).parent().fadeOut(100);
        });
    </script>
@endpush
