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
    <!--begin::General options-->
    <div class="card py-4">
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <div class="card-title">
                <h2>Menu</h2>
            </div>
            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                <!--begin::Add product-->
                <button type="button" onclick="openMenuModal(null)" class="btn btn-primary">
                    Adicionar item
                </button>
                <!--end::Add product-->
            </div>
        </div>
        <!--begin::Card body-->
        <div class="card-body">
            <!--begin::Table-->
            <form id="displayOrderHome">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="tableOrderMenu">
                    <!--begin::Table head-->
                    <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th></th>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Pertence à</th>
                        <th class="text-center">Mega menu</th>
                        <th class="text-center w-150px">Ações</th>
                    </tr>
                    <!--end::Table row-->
                    </thead>
                    <!--end::Table head-->
                    <!--begin::Table body-->
                    <tbody class="fw-semibold text-gray-600" id="body-menu">
                    @foreach($items_menu as $itemMenu)
                        <!--begin::Table row-->
                        <tr>
                            <input type="hidden" name="ids[]" value="{{ $itemMenu->id }}"/>
                            <td style="cursor: pointer">
                                <i class="fas fa-bars text-gray-800"></i>
                            </td>
                            <!--begin::Título=-->
                            <td>
                                <span class="text-gray-800 fs-5 fw-bold">{{ $itemMenu->title }}</span>
                            </td>
                            <!--end::Título=-->
                            <!--begin::Tipo=-->
                            <td>
                                <span class="text-gray-800 fs-5 fw-bold">{{ ucfirst($itemMenu->type) }}</span>
                            </td>
                            <!--end::Tipo=-->
                            <!--begin::Pertence à=-->
                            <td>
                                <span class="text-gray-800 fs-5 fw-bold">{{ $itemMenu->item_menu_id == null ? 'Nenhum':$itemMenu->itemMenu->title }}</span>
                            </td>
                            <!--end::Pertence à=-->
                            <!--begin::Pertence à=-->
                            <td class="text-center">
                                <span class="text-gray-800 fs-5 fw-bold">{{ $itemMenu->is_mega_menu ? 'Sim':'Não' }}</span>
                            </td>
                            <!--end::Pertence à=-->
                            <!--begin::Action=-->
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-icon btn-light-primary" onclick="openMenuModal('{{ $itemMenu->id }}')">
                                    <i class="fas fa-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-icon btn-light-danger" onclick="removeItemMenu('{{ $itemMenu->id }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                            <!--end::Action=-->
                        </tr>
                        <!--end::Table row-->
                    @endforeach
                    </tbody>
                    <!--end::Table body-->
                </table>
                <!--end::Table-->
            </form>
        </div>
        <!--end::Card header-->
    </div>
    <!--end::General options-->
    <div class="modal fade" id="menuItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Configurações do item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formItemMenu">
                        <input name="group_id" value="{{ $group->id }}" type="hidden">
                        <input name="id" id="idItemMenu" type="hidden">
                        <input name="type" value="widget" type="hidden">
                        <div class="row" id="div-title-type">
                            <!--begin::Input group-->
                            <div class="col-8">
                                <!--begin::Label-->
                                <label class="required form-label">Título</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="title" id="titleItemMenu" class="form-control mb-2"
                                       placeholder="Título"/>
                                <!--end::Input-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7">Um título é obrigatório.</div>
                                <!--end::Description-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="col-4">
                                <!--begin::Label-->
                                <label class="required form-label">Tipo</label>
                                <!--end::Label-->
                                <select name="type" id="typeItemMenu" class="form-select mb-2" data-control="select2"
                                        data-placeholder="Tipo" data-hide-search="true">
                                    <option></option>
                                    <option value="link">Link</option>
                                    <option value="página">Página</option>
                                    <option value="menu">Menu</option>
                                </select>
                                <!--begin::Description-->
                                <div class="text-muted fs-7">Selecione o tipo de item.</div>
                                <!--end::Description-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--begin::Input group-->
                        <div class="fv-row mb-10" id="div-link-item-menu" style="display: none">
                            <!--begin::Label-->
                            <label class="required form-label">Link</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="link" id="linkItemMenu" class="form-control mb-2" placeholder="Url"/>
                            <!--end::Input-->
                            <!--begin::Description-->
                            <div class="text-muted fs-7">Um link é obrigatório.</div>
                            <!--end::Description-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10" id="div-page-item-menu" style="display: none">
                            <!--begin::Label-->
                            <label class="required form-label">Página</label>
                            <!--end::Label-->
                            <select name="page_id" id="pageItemMenu" class="form-select mb-2" data-placeholder="Página">
                                <option></option>
                                @foreach($pages as $page)
                                    <option value="{{ $page->id }}">{{ $page->title }}</option>
                                @endforeach
                            </select>
                            <!--begin::Description-->
                            <div class="text-muted fs-7">Selecione a página.</div>
                            <!--end::Description-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row" style="display: none" id="div-pertence-menu">
                            <!--begin::Label-->
                            <label class="form-label">Pertence à</label>
                            <!--end::Label-->
                            <select name="item_menu_id" id="itemItemMenu" class="form-select mb-2" data-placeholder="Item">
                                <option></option>
                            </select>
                            <!--begin::Description-->
                            <div class="text-muted fs-7">Selecione um item de menu.</div>
                            <!--end::Description-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="row mt-10" style="display: none" id="div-menu-with-link-type">
                            <div class="col-10">
                                <!--begin::Label-->
                                <label class="required form-label">Tipo</label>
                                <!--end::Label-->
                                <select name="menu_with_link_type" id="menu_with_link_type" class="form-select mb-2" data-control="select2" data-placeholder="Tipo" data-hide-search="true">
                                    <option></option>
                                    <option value="link">Link</option>
                                    <option value="página">Página</option>
                                </select>
                                <!--begin::Description-->
                                <div class="text-muted fs-7">Selecione o tipo de item.</div>
                                <!--end::Description-->
                            </div>
                            <div class="col-2">
                                <!--begin::Label-->
                                <label class="form-label">Mobile</label>
                                <!--end::Label-->
                                <div class="form-check form-check-solid form-switch form-check-custom fv-row mb-2">
                                    <input name="menu_with_link_mobile" id="menu_with_link_mobile" class="form-check-input w-45px h-30px" type="checkbox">
                                    <label class="form-check-label" for="menu_with_link_mobile"></label>
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                    </form>
                    <div class="row">
                        <div class="col-3" id="div-menu-with-link">
                            <!--begin::Input group-->
                            <div class="fv-row mt-10">
                                <!--begin::Label-->
                                <label class="form-label">Possui link?</label>
                                <!--end::Label-->
                                <div class="form-check form-check-solid form-switch form-check-custom fv-row mb-2">
                                    <input name="menu_with_link" id="menu_with_link" class="form-check-input w-45px h-30px" type="checkbox">
                                    <label class="form-check-label" for="menu_with_link"></label>
                                </div>
                                <!--begin::Description-->
                                <div class="text-muted fs-7">Menu possui link?</div>
                                <!--end::Description-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        {{--<div class="col-3" id="div-mega-menu">
                            <!--begin::Input group-->
                            <div class="fv-row mt-10">
                                <!--begin::Label-->
                                <label class="form-label">Mega menu?</label>
                                <!--end::Label-->
                                <div class="form-check form-check-solid form-switch form-check-custom fv-row mb-2">
                                    <input name="is_mega_menu" id="isMegaMenuItemMenu" class="form-check-input w-45px h-30px" type="checkbox">
                                    <label class="form-check-label" for="isMegaMenuItemMenu"></label>
                                </div>
                                <!--begin::Description-->
                                <div class="text-muted fs-7">Exibir no mega menu?.</div>
                                <!--end::Description-->
                            </div>
                            <!--end::Input group-->
                        </div>--}}
                        <div class="col-3" id="div-cor-fundo" style="display: none">
                            <div class="fv-row mt-10">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold mb-2">Cor de fundo</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <label class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1" name="background" id="backgroundItemMenu">
                                </label>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                    </div>
                    <!--begin::Input group-->
                    <div class="fv-row mt-10" style="display: none" id="div-cores-item-menu">
                        <!--end::Input group-->
                        <label class="fs-6 fw-semibold mb-2">Cores</label>
                        <!--begin::Input group-->
                        <div class="colors-parent-box">
                            <div class="color-box-parent">
                                <div class="color-box">
                                    <p>
                                        Botão
                                    </p>
                                    <div class="color-select" style="background-color: #151624"
                                         id="backgroundColorItemMenu"></div>
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
                                    <p>
                                        Texto
                                    </p>
                                    <div class="color-select" style="background-color: #FFFFFF"
                                         id="titleColorItemMenu"></div>
                                    <div class="colors-box">
                                        @foreach($colors as $color)
                                            <div class="color-input"
                                                 style="background-color: {!! $color->color !!}"></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Input group-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="closeMenuModal()">Concluído</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('assets/plugins/custom/jquery-ui-1.13.2.custom/jquery-ui.min.js')}}"></script>
    {{-- SCRIPTS CRUD MENU (ITENS) --}}
    <script>
        var menuItemModal = new bootstrap.Modal(document.getElementById('menuItemModal'), {
            backdrop: 'static',
            keyboard: false
        });

        $("#pageItemMenu").select2({
            dropdownParent: $("#menuItemModal")
        });

        $("#itemItemMenu").select2({
            dropdownParent: $("#menuItemModal")
        });

        $("#tableOrderMenu tbody").sortable({
            start: function (e, ui) {
                var elements = ui.item.siblings('.selected.hidden').not('.ui-sortable-placeholder');
                ui.item.data('items', elements);
            },
            update: function (e, ui) {
                ui.item.after(ui.item.data("items"));
            },
            stop: function (e, ui) {
                ui.item.siblings('.selected').removeClass('hidden');
                $('tr.selected').removeClass('selected');

                $('#displayOrderHome').submit();
            }
        });

        function openMenuModal(id) {
            var form = new FormData();
            form.append('id', id);
            $.ajax({
                method: "POST",
                data: form,
                url: '{{ route('admin.settings.getItemMenu') }}',
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.success) {
                        var itemItemMenu = $("#itemItemMenu");

                        itemItemMenu.html('').select2({data: [{id: '', text: ''}]});
                        var returnArray = new Array();
                        returnArray.push({id: 'null', text: 'Nenhum'});
                        if (data.itemsMenu !== null) {
                            $.each(data.itemsMenu, function (key, value) {
                                returnArray.push({id: value.id, text: value.title});
                            });
                        }
                        itemItemMenu.html('').select2({'data': returnArray});

                        if (data.itemMenu === null) {
                            $('#idItemMenu').val(null);
                            $('#typeItemMenu').val(null).trigger('change');
                            $('#pageItemMenu').val(null).trigger('change');
                            $('#titleItemMenu').val(null);
                            $('#linkItemMenu').val(null);
                            itemItemMenu.val('null').trigger('change');
                            $('#menu_with_link').prop('checked', false);
                            $('#menu_with_link_mobile').prop('checked', false);
                            $('#isMegaMenuItemMenu').prop('checked', false);

                            $('#backgroundItemMenu').prop('checked', false);
                            $('#backgroundColorItemMenu').css('background-color', '#151624');
                            $('#titleColorItemMenu').css('background-color', '#FFFFFF');

                            $('#div-link-item-menu').hide();
                            $('#div-category-item-menu').hide();
                        } else {
                            $('#menu_with_link_type').val(data.itemMenu.menu_with_link_type);
                            $('#menu_with_link').prop('checked', data.itemMenu.menu_with_link);
                            $('#menu_with_link_mobile').prop('checked', data.itemMenu.menu_with_link_mobile);

                            $('#idItemMenu').val(data.itemMenu.id);
                            $('#typeItemMenu').val(data.itemMenu.type).trigger('change');
                            $('#pageItemMenu').val(data.itemMenu.page_id).trigger('change');
                            $('#titleItemMenu').val(data.itemMenu.title);
                            $('#linkItemMenu').val(data.itemMenu.link);

                            if (data.itemMenu.item_menu_id === null) {
                                itemItemMenu.val('null').trigger('change');
                            } else {
                                itemItemMenu.val(data.itemMenu.item_menu_id).trigger('change');
                            }

                            $('#isMegaMenuItemMenu').prop('checked', data.itemMenu.is_mega_menu);

                            $('#backgroundItemMenu').prop('checked', data.itemMenu.background).trigger('change');
                            $('#backgroundColorItemMenu').css('background-color', data.itemMenu.background_color);
                            $('#titleColorItemMenu').css('background-color', data.itemMenu.title_color);
                        }

                        menuItemModal.show();
                    } else {
                        Swal.fire('Erro!', data.message, 'error')
                    }
                },
                error: function (e) {
                    console.log(e);
                    Swal.fire('Falha!', 'Erro ao processar requisição.', 'error');
                }
            })
        }

        function closeMenuModal() {
            $('#formItemMenu').submit();
        }

        $('#formItemMenu').on('submit', function (e) {
            e.preventDefault();
            var form = new FormData(this);
            form.append('background_color', $('#backgroundColorItemMenu').css("background-color"));
            form.append('title_color', $('#titleColorItemMenu').css("background-color"));
            // Background true or false
            if ($('#backgroundItemMenu').is(':checked')) {
                form.append('background', 1);
            }
            if ($('#menu_with_link').is(':checked')) {
                form.append('menu_with_link', 1);
            }
            if ($('#menu_with_link_mobile').is(':checked')) {
                form.append('menu_with_link_mobile', 1);
            }
            $.ajax({
                method: "POST",
                data: form,
                url: '{{ route('admin.settings.saveItemMenu') }}',
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.success) {
                        menuItemModal.hide();
                        Swal.fire('Sucesso!', data.message, 'success').then((function () {
                            location.reload();
                        }));
                        /*if (data.html !== false){
                            $('#body-menu').append(data.html);
                        }*/
                    } else {
                        Swal.fire('Erro!', data.message, 'error');
                    }
                },
                error: function (e) {
                    console.log(e);
                    Swal.fire('Falha!', 'Erro ao processar requisição.', 'error');
                }
            })
        })

        function removeItemMenu(id) {
            Swal.fire({
                text: "Tem certeza que deseja remover esse item?",
                icon: "question",
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Sim, excluir!",
                cancelButtonText: "Não, cancelar",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-primary"
                }
            }).then((function (t) {
                t.value ?
                    $.ajax({
                        method: "DELETE",
                        url: '{{ route('admin.settings.deleteItemMenu', '_ID_') }}'.replace('_ID_', id),
                        success: function (data) {
                            if (data.success) {
                                Swal.fire({
                                    text: data.message,
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, continuar!",
                                    customClass: {confirmButton: "btn fw-bold btn-primary"}
                                }).then((function () {
                                    location.reload();
                                }))
                            } else {
                                Swal.fire('Erro!', data.message, 'error')
                            }
                        },
                        error: function (e) {
                            console.log(e);
                            Swal.fire('Falha!', 'Erro ao processar requisição.', 'error');
                        }
                    }) : "cancel" === t.dismiss && Swal.fire({
                    text: "O item não foi removido.",
                    icon: "error",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, continuar!",
                    customClass: {confirmButton: "btn fw-bold btn-primary"}
                })
            }))
        }

        $('#displayOrderHome').on('submit', function (e) {
            e.preventDefault();
            var form = new FormData(this);
            $.ajax({
                method: "POST",
                data: form,
                url: '{{ route('admin.settings.displayOrderItemMenu') }}',
                processData: false,
                contentType: false,
                success: function (data) {
                    if (!data.success) {
                        Swal.fire('Erro!', data.message, 'error')
                    }
                },
                error: function (e) {
                    console.log(e);
                    Swal.fire('Falha!', 'Erro ao processar requisição.', 'error');
                }
            })
        });

        $('#typeItemMenu').on('change', function () {
            var type = $(this).val();
            if (type === 'link') {
                $('#div-link-item-menu').show();
                $('#div-page-item-menu').hide();
                $('#div-pertence-menu').show();
                $('#div-cor-fundo').show();
                $('#div-mega-menu').hide();
                $('#div-menu-with-link').hide();
                $('#div-menu-with-link-type').hide();

                $('#div-title-type').addClass('mb-10');
            } else if (type === 'página') {
                $('#div-link-item-menu').hide();
                $('#div-page-item-menu').show();
                $('#div-pertence-menu').show();
                $('#div-cor-fundo').show();
                $('#div-mega-menu').hide();
                $('#div-menu-with-link').hide();
                $('#div-menu-with-link-type').hide();

                $('#div-title-type').addClass('mb-10');
            } else if (type === 'menu') {
                $('#div-link-item-menu').hide();
                $('#div-page-item-menu').hide();
                $('#div-pertence-menu').show();
                $('#div-cor-fundo').show();
                $('#div-mega-menu').show();
                $('#div-menu-with-link').show();
                $('#menu_with_link').trigger('change');
                $('#menu_with_link_type').trigger('change');

                $('#div-title-type').addClass('mb-10');
            } else {
                $('#div-link-item-menu').hide();
                $('#div-page-item-menu').hide();
                $('#div-pertence-menu').hide();
                $('#div-mega-menu').hide();
                $('#div-menu-with-link').hide();
                $('#div-cor-fundo').hide();
                $('#div-menu-with-link-type').hide();

                $('#div-title-type').removeClass('mb-10');
            }
        });

        $('#backgroundItemMenu').on('change', function (){
            if($(this).is(':checked')){
                $('#div-cores-item-menu').show();
            }else{
                $('#div-cores-item-menu').hide();
            }
        });

        $('#menu_with_link').on('change', function (){
            if($(this).is(':checked')){
                $('#div-menu-with-link-type').show();
            }else{
                $('#div-menu-with-link-type').hide();
            }
        });

        $('#menu_with_link_type').on('change', function (){
            var type = $(this).val();
            if (type === 'link') {
                $('#div-link-item-menu').show();
                $('#div-page-item-menu').hide();
                $('#div-title-type').addClass('mb-10');
            } else if (type === 'página') {
                $('#div-link-item-menu').hide();
                $('#div-page-item-menu').show();
                $('#div-title-type').addClass('mb-10');
            }
        })
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
