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
                    <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Procurar usuário"/>
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
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
                <!--begin::Add product-->
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Adicionar usuário</a>
                <!--end::Add product-->
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
                    <th class="min-w-200px">Nome</th>
                    <th class="min-w-100px">Descrição</th>
                    <th class="text-center min-w-100px">E-mail</th>
                    <th class="text-center min-w-100px">Status</th>
                    <th class="text-center min-w-70px">Ações</th>
                </tr>
                <!--end::Table row-->
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody class="fw-semibold text-gray-600">
                <!--begin::Table row-->
                @foreach($users as $user)
                    @if($user->email == 'admin@impetussistemas.com.br' && $user->email != Auth::user()->email)
                        @continue
                    @endif
                    <tr>
                        <!--begin::Nome=-->
                        <td>
                            <div class="d-flex align-items-center">
                                <!--begin::Thumbnail-->
                                <a href="{{ route('admin.users.show', $user->hash_id) }}" class="symbol symbol-50px">
                                    <span class="symbol-label" style="background-image:url('{{$user->photo == null ? asset('images/default.png') : asset(str_replace('public/','storage/', $user->photo)) }}');"></span>
                                </a>
                                <!--end::Thumbnail-->
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="{{ route('admin.users.show', $user->hash_id) }}" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="name">{{ $user->name }} {{ $user->lastname }}</a>
                                    <a class="d-none" data-kt-ecommerce-product-filter="id">{{ $user->hash_id }}</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <!--end::Nome=-->
                        <!--begin::Descrição=-->
                        <td class="pe-0" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $user->description }}">
                            {{ Str::limit($user->description, 50, '...')}}
                        </td>
                        <!--end::Descrição=-->
                        <!--begin::Email=-->
                        <td class="text-center pe-0">
                            {{ $user->email }}
                        </td>
                        <!--end::Email=-->
                        <!--begin::Status=-->
                        <td class="text-center pe-0" data-order="{{ $user->status ? 'Publicado':'Inativo' }}">
                            <!--begin::Badges-->
                            <div class="badge badge-light-{{ $user->status ? 'success':'danger' }}">{{ $user->status ? 'Publicado':'Inativo' }}</div>
                            <!--end::Badges-->
                        </td>
                        <!--end::Status=-->
                        <!--begin::Action=-->
                        <td class="text-center">
                            <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Ações
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
                                    <a href="{{ route('admin.users.edit', $user->hash_id) }}" class="menu-link px-3">Editar</a>
                                </div>
                                <!--end::Menu item-->
                                @if($user->id != Auth::id() or $user->email != 'admin@impetussistemas.com.br' && $user->id != Auth::id())
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Excluir</a>
                                    </div>
                                    <!--end::Menu item-->
                                @endif
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
@endsection

@push('scripts')
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
                            text: "Tem certeza que deseja excluir o usuário " + r + "?",
                            icon: "warning",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Sim, excluir!",
                            cancelButtonText: "Não, cancelar",
                            customClass: {
                                confirmButton: "btn fw-bold btn-danger",
                                cancelButton: "btn fw-bold btn-active-light-primary"
                            }
                        }).then((function (t) {
                            t.value ?
                                $.ajax({
                                    method: "DELETE",
                                    url: `{{route('admin.users.destroy', '_id_')}}`.replace('_id_', n.querySelector('[data-kt-ecommerce-product-filter="id"]').innerText),
                                    success: function(rtn){
                                        if(rtn.success === true){
                                            Swal.fire({
                                                text: "Você excluiu o usuário " + r + "!.",
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
                                text: r + " não foi excluído.",
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
                        columnDefs: [{
                            orderable: 1,
                            targets: 0
                        }, {orderable: !1, targets: 4}]
                    })).on("draw", (function () {
                        n()
                    })), document.querySelector('[data-kt-ecommerce-product-filter="search"]').addEventListener("keyup", (function (t) {
                        e.search(t.target.value).draw()
                    })), (() => {
                        const t = document.querySelector('[data-kt-ecommerce-product-filter="status"]');
                        $(t).on("change", (t => {
                            let n = t.target.value;
                            "todos" === n && (n = ""), e.column(3).search(n).draw()
                        }))
                    })())
                }
            }
        }();
        KTUtil.onDOMContentLoaded((function () {
            KTAppEcommerceProducts.init()
        }));
    </script>
@endpush
