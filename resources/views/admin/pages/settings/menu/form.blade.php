@extends('admin.layout')
@push('head')
    <style>
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
    <form class="form d-flex flex-column flex-lg-row saveMenu">
        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <!--begin::General options-->
            <div class="card card-flush py-4">
                <!--begin::Card body-->
                <div class="card-body">
                    <h2 class="mb-6">Geral</h2>
                    <!--begin::Input group-->
                    <div class="mb-18 row">
                        <div class="col-6">
                            <!--begin::Label-->
                            <label class="required form-label">Título</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="title" class="form-control" value="{{ $menu->title }}"/>
                            <!--end::Input-->
                        </div>
                        <div class="col-6">
                            <!--begin::Label-->
                            <label class="required form-label">Layout</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select id="menu-layout" class="form-select mb-2" data-control="select2" data-placeholder="Selecione um layout de menu" data-hide-search="true">
                                <option></option>
                                @for($i = 1; $i <= 3; $i++)
                                    <option value="{{ $i }}" {{ $i == $menu->layout ? 'selected' : ''}}>Layout {{ $i }}</option>
                                @endfor
                            </select>
                            <!--end::Input-->
                            <!--begin::Description-->
                            <div class="text-muted fs-7">Um layout é obrigatório.</div>
                            <!--end::Description-->
                        </div>
                    </div>
                    <!--end::Input group-->
                    <h2 class="mb-6">Logos</h2>
                    <!--begin::Input group-->
                    <div class="mb-18 row">
                        <div class="col-6">
                            <div style="display: flex; align-items: start; justify-content: flex-start;">
                                <!-- Esquerda: Input File e Descrição -->
                                <div class="mb-3" id="div-menu-logo">
                                    <!--begin::Label-->
                                    <label class="form-label">Logo</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="file" id="menu-logo" class="form-control mb-2"/>
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">Somente arquivos de imagem *.png, *.jpg e *.jpeg são aceitos.</div>
                                    <!--end::Description-->
                                </div>
                                <!-- Direita: SVG, Nome do Arquivo e Botão de Remoção -->
                                @if ($menu->logo != null)
                                    <!-- O link de download -->
                                    <div id="preview-menu-logo" class="ms-3" style="display: flex; flex-direction: column; align-items: flex-end;">
                                        <div style="position: relative; display: flex; flex-direction: column; align-items: center;">
                                            <button type="button" class="btn btn-sm btn-icon btn-light-danger" onclick="removeLogo('{{$menu->hash_id}}')" style="position: absolute; top: 5px; right: 5px;"><i class="fa fa-times fs-1"></i></button>
                                            <a href="{{ asset(str_replace('public/', 'storage/', $menu->logo)) }}" download style="text-decoration: none; color: inherit;">
                                                <svg width="100px" height="125px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z" fill="#009ef7"/>
                                                    <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="#009ef7"/>
                                                </svg>
                                            </a>
                                            <a href="{{ asset(str_replace('public/', 'storage/', $menu->logo)) }}" download style="text-decoration: none; color: inherit;">
                                                <div class="text-hover-primary fs-7" style="margin-top: -10px;">{{ str_replace('public/settings/menu/'.$menu->hash_id.'/', '', $menu->logo) }}</div>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="display: flex; align-items: start; justify-content: flex-start;">
                                <!-- Esquerda: Input File e Descrição -->
                                <div class="mb-3" id="div-menu-logo-scroll">
                                    <!--begin::Label-->
                                    <label class="form-label">Logo (Scroll)</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="file" id="menu-logo-scroll" class="form-control mb-2"/>
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">Somente arquivos de imagem *.png, *.jpg e *.jpeg são aceitos.</div>
                                    <!--end::Description-->
                                </div>
                                <!-- Direita: SVG, Nome do Arquivo e Botão de Remoção -->
                                @if ($menu->logo_scroll != null)
                                    <!-- O link de download -->
                                    <div id="preview-menu-logo-scroll" class="ms-3" style="display: flex; flex-direction: column; align-items: flex-end;">
                                        <div style="position: relative; display: flex; flex-direction: column; align-items: center;">
                                            <button type="button" class="btn btn-sm btn-icon btn-light-danger" onclick="removeLogoScroll('{{$menu->hash_id}}')" style="position: absolute; top: 5px; right: 5px;">
                                                <i class="fa fa-times fs-1"></i>
                                            </button>
                                            <a href="{{ asset(str_replace('public/', 'storage/', $menu->logo_scroll)) }}" download style="text-decoration: none; color: inherit;">
                                                <svg width="100px" height="125px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z" fill="#009ef7"/>
                                                    <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="#009ef7"/>
                                                </svg>
                                            </a>
                                            <a href="{{ asset(str_replace('public/', 'storage/', $menu->logo_scroll)) }}" download style="text-decoration: none; color: inherit;">
                                                <div class="text-hover-primary fs-7" style="margin-top: -10px;">{{ str_replace('public/settings/menu/'.$menu->hash_id.'/', '', $menu->logo_scroll) }}</div>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <h2 class="mb-6">Cores</h2>
                    <!--begin::Input group-->
                    <div class="fv-row">
                        <div class="colors-parent-box mb-8">
                            <div class="color-box-parent">
                                <div class="color-box">
                                    <!--begin::Label-->
                                    <p>Cor do fundo</p>
                                    <!--end::Label-->
                                    <div class="color-select" style="background-color: {{$menu->background_color}}" id="menu-background-color"></div>
                                    <div class="colors-box">
                                        @foreach($colors as $color)
                                            <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="color-box-parent">
                                <div class="color-box">
                                    <!--begin::Label-->
                                    <p>Cor do item</p>
                                    <!--end::Label-->
                                    <div class="color-select" style="background-color: {{ $menu->item_color }}" id="menu-item-color"></div>
                                    <div class="colors-box">
                                        @foreach($colors as $color)<div class="color-input"
                                                                        style="background-color: {!! $color->color !!}"></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="color-box-parent">
                                <div class="color-box">
                                    <!--begin::Label-->
                                    <p>Cor do item (Hover)</p>
                                    <!--end::Label-->
                                    <div class="color-select" style="background-color: {{ $menu->item_hover_color }}" id="menu-item-hover-color"></div>
                                    <div class="colors-box">
                                        @foreach($colors as $color)
                                            <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="colors-parent-box mb-8">
                            <div class="color-box-parent"></div>
                            <div class="color-box-parent">
                                <div class="color-box">
                                    <!--begin::Label-->
                                    <p>Cor do item (Scroll)</p>
                                    <!--end::Label-->
                                    <div class="color-select" style="background-color: {{ $menu->item_color_scroll }}" id="menu-item-color-scroll"></div>
                                    <div class="colors-box">
                                        @foreach($colors as $color)
                                            <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="color-box-parent">
                                <div class="color-box">
                                    <!--begin::Label-->
                                    <p>Cor do item (Hover - Scroll)</p>
                                    <!--end::Label-->
                                    <div class="color-select" style="background-color: {{ $menu->item_hover_color_scroll }}" id="menu-item-hover-color-scroll"></div>
                                    <div class="colors-box">
                                        @foreach($colors as $color)
                                            <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="colors-parent-box">
                            <div class="color-box-parent">
                                <div class="color-box">
                                    <!--begin::Label-->
                                    <p>Cor do fundo (Dropdown)</p>
                                    <!--end::Label-->
                                    <div class="color-select"
                                         style="background-color: {{$menu->background_color_dropdown}}"
                                         id="menu-background-dropdown-color"></div>
                                    <div class="colors-box">
                                        @foreach($colors as $color)
                                            <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="color-box-parent">
                                <div class="color-box">
                                    <!--begin::Label-->
                                    <p>Cor do item (Dropdown)</p>
                                    <!--end::Label-->
                                    <div class="color-select"
                                         style="background-color: {{ $menu->item_color_dropdown }}"
                                         id="menu-item-dropdown-color"></div>
                                    <div class="colors-box">
                                        @foreach($colors as $color)
                                            <div class="color-input"
                                                 style="background-color: {!! $color->color !!}"></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="color-box-parent">
                                <div class="color-box">
                                    <!--begin::Label-->
                                    <p>Cor do item (Hover - Dropdown)</p>
                                    <!--end::Label-->
                                    <div class="color-select"
                                         style="background-color: {{ $menu->item_hover_color_dropdown }}"
                                         id="menu-item-hover-dropdown-color"></div>
                                    <div class="colors-box">
                                        @foreach($colors as $color)
                                            <div class="color-input"
                                                 style="background-color: {!! $color->color !!}"></div>
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
    {{-- DECLARAÇÃO DE VARIÁVEIS --}}
    <script>
        var submitButton = document.getElementById('btnSubmit');
    </script>
    {{-- SUBMIT FORMULÁRIO --}}
    <script>
        $('.saveMenu').on("submit", function(e){
            e.preventDefault();

            submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
            submitButton.disabled = true;

            var form = new FormData(this);
            @if($menu->id > 0)
                form.append('_method', 'PUT');
            @endif
            if ($('#menu-logo').prop('files').length){
                form.append('logo', $('#menu-logo').prop('files')[0]);
            }
            if ($('#menu-logo-scroll').prop('files').length){
                form.append('logo_scroll', $('#menu-logo-scroll').prop('files')[0]);
            }
            form.append('layout', $('#menu-layout').val());
            form.append('background_color', $('#menu-background-color').css("background-color"));
            form.append('item_color', $('#menu-item-color').css("background-color"));
            form.append('item_color_scroll', $('#menu-item-color-scroll').css("background-color"));
            form.append('item_hover_color', $('#menu-item-hover-color').css("background-color"));
            form.append('item_hover_color_scroll', $('#menu-item-hover-color-scroll').css("background-color"));
            form.append('background_color_dropdown', $('#menu-background-dropdown-color').css("background-color"));
            form.append('item_color_dropdown', $('#menu-item-dropdown-color').css("background-color"));
            form.append('item_hover_color_dropdown', $('#menu-item-hover-dropdown-color').css("background-color"));

            $.ajax({
                url: '{{$menu->id > 0 ? route('admin.settings.menu.update', $menu->hash_id):route('admin.settings.menu.store')}}',
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
                            confirmButtonText: "Configurações",
                            cancelButtonText: "Novo menu",
                            customClass: {
                                confirmButton: "btn fw-bold btn-secondary",
                                cancelButton: "btn fw-bold btn-primary"
                            },
                            allowOutsideClick: false
                        }).then((function (t) {
                            if (t.value){
                                window.location.href = '{{route('admin.settings.index')}}'
                            }else{
                                window.location.href = '{{route('admin.settings.menu.create')}}'
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
                    Swal.fire('Erro', data.message, 'error');
                }
            });
        });

        function removeLogo(id){
            Swal.fire({
                text: "Tem certeza que deseja remover a logo?",
                icon: "question",
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Sim, remover",
                cancelButtonText: "Não, cancelar",
                customClass: {
                    cancelButton: "btn fw-bold btn-primary",
                    confirmButton: "btn fw-bold btn-danger"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.settings.removeLogo', '_ID_') }}'.replace('_ID_', id),
                        type: 'GET',
                        processData: false,
                        contentType: false,
                        success: function(data){
                            if(data.success){
                                Swal.fire('Sucesso', data.message, 'success').then((function () {
                                    $('#preview-menu-logo').fadeOut(150);
                                }));
                            }else{
                                Swal.fire('Erro', data.message, 'error');
                            }
                        },
                        error: function(data){
                            Swal.fire('Erro', 'Falha ao remover logo, tente novamente', 'error');
                        }
                    });
                }
            });
        }

        function removeLogoScroll(id){
            Swal.fire({
                text: "Tem certeza que deseja remover a logo?",
                icon: "question",
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Sim, remover",
                cancelButtonText: "Não, cancelar",
                customClass: {
                    cancelButton: "btn fw-bold btn-primary",
                    confirmButton: "btn fw-bold btn-danger"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.settings.removeLogoScroll', '_ID_') }}'.replace('_ID_', id),
                        type: 'GET',
                        processData: false,
                        contentType: false,
                        success: function(data){
                            if(data.success){
                                Swal.fire('Sucesso', data.message, 'success').then((function () {
                                    $('#preview-menu-logo-scroll').fadeOut(150);
                                }));
                            }else{
                                Swal.fire('Erro', data.message, 'error');
                            }
                        },
                        error: function(data){
                            Swal.fire('Erro', 'Falha ao remover logo, tente novamente', 'error');
                        }
                    });
                }
            });
        }
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
