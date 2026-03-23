@extends('admin.layout')

@section('content')
    <!--begin::Products-->
    <div class="card card-flush">
        <!--begin::Card header-->
        <div class="card-header align-items-center py-5 gap-2 gap-md-5">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-1 position-absolute ms-4">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor"/>
                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor"/>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Procurar página"/>
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                <div class="w-100 mw-150px">
                    <!--begin::Select2-->
                    <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Sessão" data-kt-ecommerce-product-filter="sessao">
                        <option></option>
                        <option value="todos">Todos</option>
                        @foreach(\App\Models\Pages\Category::orderBy('title')->get() as $category)
                            <option value="{{ $category->title }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                    <!--end::Select2-->
                </div>

                <div class="w-100 mw-150px">
                    <!--begin::Select2-->
                    <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Status" data-kt-ecommerce-product-filter="status">
                        <option></option>
                        <option value="todos">Todos</option>
                        <option value="publicado">Publicado</option>
                        <option value="inativo">Inativo</option>
                    </select>
                    <!--end::Select2-->
                </div>

                <a href="#" class="btn btn-primary w-200px" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                    Ações
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                    <span class="svg-icon svg-icon-5 m-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"/>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </a>
                <!--begin::Menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                     data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="{{ route('admin.pages.create') }}" class="menu-link px-3">Adicionar página</a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalOrderPages" class="menu-link px-3">Ordem de exibição</a>
                    </div>
                    <!--end::Menu item-->
                </div>
                <!--end::Menu-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
                <!--begin::Table head-->
                <thead>
                <!--begin::Table row-->
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th>Título</th>
                    <th>Slug</th>
                    <th>Sessão</th>
                    <th class="text-center">Data de criação</th>
                    <th class="text-center min-w-100px">Status</th>
                    <th class="text-center min-w-70px">Ações</th>
                </tr>
                <!--end::Table row-->
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody class="fw-semibold text-gray-600">
                <!--begin::Table row-->
                @foreach($pages as $page)
                    <tr>
                        <!--begin::Título=-->
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin::Thumbnail-->
                                <a href="{{ route('admin.pages.edit', $page->hash_id) }}" class="symbol symbol-50px">
                                    <span class="symbol-label" style="background-image:url('{{$page->seo_image == null ? asset('assets/media/svg/files/blank-image.svg') : asset(str_replace('public/','storage/', $page->seo_image)) }}');"></span>
                                </a>
                                <!--end::Thumbnail-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="{{ route('admin.pages.edit', $page->hash_id) }}" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="name" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $page->title }}">{{ Str::limit($page->title, 45, '...') }}</a>
                                    <a class="d-none" data-kt-ecommerce-product-filter="id">{{ $page->hash_id }}</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        @php
                            $url = '';
                            if ($page->prefix_slug->count() > 0) {
                                $url .= implode('/', $page->prefix_slug->pluck('slug')->toArray()) . '/';
                            }
                            $url .= $page->slug;
                        @endphp
                        <td class="pe-0">/{{ $url }}</td>
                        <!--end::Título=-->
                        {{--<!--begin::Conteúdo=-->
                        <td class="pe-0" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $article->subtitle }}">
                            {{ Str::limit($article->subtitle, 55, '...') }}
                        </td>
                        <!--end::Conteúdo=-->--}}
                        <td class="pe-0">
                            @if($page->categories->count() > 0)
                                <span data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ implode(', ', $page->categories->pluck('title')->toArray()) }}">
                                    {{ $page->categories->first()->title }} {{ $page->categories->count() > 1 ? ', +'.$page->categories->count()-1:'' }}
                                </span>
                            @endif
                        </td>
                        <td class="pe-0 text-center">
                            {{ $page->created_at->format('d/m/Y') }}
                        </td>
                        @php
                            $status = '';
                            $badge = '';
                            /** @var TYPE_NAME $page */
                            if ($page->status){
                                $status = 'Publicado';
                                $badge = 'success';
                            }else{
                                $status = 'Inativo';
                                $badge = 'danger';
                            }
                        @endphp
                        <!--begin::Status=-->
                        <td class="text-center pe-0" data-order="{{ $status }}">
                            <!--begin::Badges-->
                            <div class="badge badge-light-{{ $badge }}">{{ $status }}</div>
                            <!--end::Badges-->
                        </td>
                        <!--end::Status=-->
                        <!--begin::Action=-->
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                Ações
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                <span class="svg-icon svg-icon-5 m-0">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"/>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </a>
                            <!--begin::Menu-->
                            <div
                                class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="{{ route('admin.pages.edit', $page->hash_id) }}" class="menu-link px-3">Editar</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="{{ route('admin.pages.show', $page->hash_id) }}" class="menu-link px-3">Layout</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a onclick="copy('{{ $page->hash_id }}')" class="menu-link px-3">Copiar</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="/{{ $url }}" target="_blank" class="menu-link px-3">Visualizar</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Excluir</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                        <!--end::Action=-->
                    </tr>
                @endforeach
                <!--end::Table row-->
                </tbody>
                <!--end::Table body-->
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Products-->

    <div class="modal fade" id="modalOrderPages" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ordernar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-order">
                        <div class="form-group mb-5">
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-6 fv-row">
                                    <label for="order-type" class="form-label">Tipo</label>
                                    <select class="form-select mb-2" id="order-type" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção">
                                        <option></option>
                                        <option value="page">Página</option>
                                        <option value="pages">Páginas</option>
                                    </select>
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                                <div class="col-6 fv-row" id="div-order-type-value">
                                    <label for="order-type-value" class="form-label" id="order-type-title">&nbsp;</label>
                                    <select class="form-select mb-2" id="order-type-value" data-control="select2" data-placeholder="Selecione uma opção" disabled>
                                        <option></option>
                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                        </div>
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="table-order" style="display: none">
                            <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="w-10px"></th>
                                <th>Título</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Concluído</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('assets/plugins/custom/jquery-ui-1.13.2.custom/jquery-ui.min.js')}}"></script>
    <script>
        "use strict";
        var KTAppEcommerceProducts = function () {
            var t, e, n = () => {
                t.querySelectorAll('[data-kt-ecommerce-product-filter="delete_row"]').forEach((t => {
                    t.addEventListener("click", (function (t) {
                        t.preventDefault();
                        const n = t.target.closest("tr"),
                            r = n.querySelector('[data-kt-ecommerce-product-filter="name"]').innerText;
                        Swal.fire({
                            text: "Tem certeza que deseja excluir a página: " + r + "?",
                            icon: "question",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Sim, excluir!",
                            cancelButtonText: "Não, cancelar",
                            customClass: {
                                cancelButton: "btn fw-bold btn-primary",
                                confirmButton: "btn fw-bold btn-danger"
                            }
                        }).then((function (t) {
                            t.value ?
                                $.ajax({
                                    method: "DELETE",
                                    url: `{{route('admin.pages.destroy', '_id_')}}`.replace('_id_', n.querySelector('[data-kt-ecommerce-product-filter="id"]').innerText),
                                    success: function(rtn){
                                        if(rtn.success === true){
                                            Swal.fire({
                                                text: "Você excluiu a página: " + r + "!.",
                                                icon: "success",
                                                buttonsStyling: !1,
                                                confirmButtonText: "Ok, continuar!",
                                                customClass: {confirmButton: "btn fw-bold btn-primary"}
                                            }).then((function () {
                                                e.row($(n)).remove().draw()
                                            }))
                                        }else{
                                            Swal.fire('Erro!', rtn.message, 'error')
                                        }
                                    },
                                    error: function(){
                                        Swal.fire('Falha!', 'Erro ao processar requisição.', 'error');
                                    }
                                }) : "cancel" === t.dismiss && Swal.fire({
                                text: "A página: " + r + " não foi excluída.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, continuar!",
                                customClass: {confirmButton: "btn fw-bold btn-primary"}
                            })
                        }))
                    }))
                }))
            };
            return {
                init: function () {
                    (t = document.querySelector("#kt_ecommerce_products_table")) && ((e = $(t).DataTable({
                        info: !1,
                        order: [],
                        pageLength: 10,
                        language : {
                            "url" : "{{ asset('assets/plugins/custom/datatables/pt-br.json') }}"
                        },
                        columnDefs: [{render: DataTable.render.number(",", ".", 2), targets: 4}, {
                            orderable: 1,
                            targets: 0
                        }, {orderable: !1, targets: 5}]
                    })).on("draw", (function () {
                        n()
                    })), document.querySelector('[data-kt-ecommerce-product-filter="search"]').addEventListener("keyup", (function (t) {
                        e.search(t.target.value).draw()
                    })), (() => {
                        const t = document.querySelector('[data-kt-ecommerce-product-filter="status"]');
                        $(t).on("change", (t => {
                            let n = t.target.value;
                            "todos" === n && (n = ""), e.column(4).search(n).draw()
                        }))
                    })(), (() => {
                        const t = document.querySelector('[data-kt-ecommerce-product-filter="sessao"]');
                        $(t).on("change", (t => {
                            let n = t.target.value;
                            "todos" === n && (n = ""), e.column(2).search(n).draw()
                        }))
                    })(), n())
                }
            }
        }();
        KTUtil.onDOMContentLoaded((function () {
            KTAppEcommerceProducts.init()
        }));

        function copy(id){
            Swal.fire({
                text: "Tem certeza que deseja copiar a página?",
                icon: "question",
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Sim, copiar!",
                cancelButtonText: "Não, cancelar",
                customClass: {
                    cancelButton: "btn fw-bold btn-primary",
                    confirmButton: "btn fw-bold btn-success"
                }
            }).then((function (t) {
                if (t.value) {
                    $.ajax({
                        method: "GET",
                        url: `{{route('admin.pages.copy', '_id_')}}`.replace('_id_', id),
                        success: function (rtn) {
                            if (rtn.success) {
                                Swal.fire({
                                    text: "Você copiou a página.",
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, continuar!",
                                    customClass: {confirmButton: "btn fw-bold btn-primary"}
                                }).then((function () {
                                    location.reload();
                                }))
                            } else {
                                Swal.fire('Erro!', rtn.message, 'error')
                            }
                        },
                        error: function () {
                            Swal.fire('Falha!', 'Erro ao processar requisição.', 'error');
                        }
                    })
                }
            }))
        }
    </script>
    <script>
        $("#table-order tbody").sortable({
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
                $('#form-order').submit();
            }
        });
        $('#modalOrderPages').on('hide.bs.modal', function (e) {
            var select2 = $('#order-type-value');
            select2.html('').select2({data: [{id: '', text: ''}]});
            select2.attr('disabled', true);
            $('#order-type').val(null).trigger('change');
            $('#table-order').hide();
        })
        $('#order-type').on('change', function (){
            var select2 = $('#order-type-value');
            var orderType = $(this).val();
            $.ajax({
                type: 'GET',
                url: '{{route('admin.pages.order', '_TYPE_')}}'.replace('_TYPE_', this.value),
            }).then(function (data) {
                if (data.success) {
                    $('#table-order').fadeOut(150);
                    $('#order-type-value').attr('disabled', false);
                    if (orderType === 'pages') {
                        $('#div-order-type-value').hide();
                        $('#order-type-value').trigger('change');
                    }else {
                        $('#order-type-title').html('Página');
                        $('#div-order-type-value').fadeIn(200);
                    }
                    select2.html('').select2({data: [{id: '', text: ''}]});
                    var returnArray = new Array();
                    returnArray.push({id: '', text: 'Sem categoria'});
                    $.each(data.items, function (key, value) {
                        returnArray.push({
                            id: value.id,
                            text: value.title,
                        });
                    });
                    select2.html('').select2({'data': returnArray});
                    $('#order-type-value').select2({
                        dropdownParent: $('#modalOrderPages .modal-body') // Ajuste o seletor conforme necessário
                    });
                }else{
                    Swal.fire('Erro', data.message, 'error')
                }
            });
        });
        $('#order-type-value').on('change', function (){
            $.ajax({
                type: 'GET',
                url: '{{route('admin.pages.order.type', ['type' => '_TYPE_', 'id' => '_ID_'])}}'.replace('_TYPE_', $('#order-type').val()).replace('_ID_', this.value),
            }).then(function (data) {
                if (data.success) {
                    var html;
                    var table = $('#table-order');
                    if (data.items.length === 0){
                        html = `<tr>
                                    <td colspan="2" class="text-center">Nenhum item encontrado</td>
                                </tr>`
                    }else {
                        $.each(data.items, function (key, value) {
                            html += `<tr>
                                    <td class="cursor-pointer">
                                        <input type="hidden" name="items[]" value="${value.id}">
                                        <i class="fas fa-bars text-gray-800"></i>
                                    </td>
                                    <td>${value.title}</td>
                                 </tr>`
                        });
                    }
                    table.find('tbody').html(html);
                    table.fadeIn(150);
                }else{
                    Swal.fire('Erro', data.message, 'error')
                }
            });
        });
        $('#form-order').on('submit', function (e){
            e.preventDefault();
            const type = $('#order-type').val();
            const id = type === 'pages' ? 0 : $('#order-type-value').val();
            var form = new FormData(this);
            $.ajax({
                url: '{{route('admin.pages.order.type', ['type' => '_TYPE_', 'id' => '_ID_'])}}'.replace('_TYPE_', type).replace('_ID_', id),
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function(data){
                    if(data.success === false){
                        openAlert('Erro', data.message, 'error');
                    }
                },
                error: function(data){
                    openAlert('Erro', 'Falha ao editar ordem de exibição, tente novamente', 'error');
                }
            });
        });
    </script>
@endpush
