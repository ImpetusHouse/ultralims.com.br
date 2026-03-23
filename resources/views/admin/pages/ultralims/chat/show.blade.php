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
                    <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Procurar usuuário"/>
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->
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
                    <th></th>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>E-mail</th>
                    <th>Tipo</th>
                </tr>
                <!--end::Table row-->
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody class="fw-semibold text-gray-600">
                <!--begin::Table row-->
                @foreach ($users as $user)
                    <tr>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input cursor-pointer" type="checkbox" value="{{ $user->id }}"
                                    onchange="saveUser(this)" {!! $user->chat ? 'checked="checked"':'' !!}/>
                            </div>
                        </td>
                        <td>{{ $user->idUser }}</td>
                        <td>{{ $user->user }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->tipoUser }}</td>
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
            var t, e, n = () => {};
            return {
                init: function () {
                    (t = document.querySelector("#kt_ecommerce_products_table")) && ((e = $(t).DataTable({
                        info: !1,
                        order: [],
                        pageLength: 10,
                        language : {
                            "url" : "{{ asset('assets/plugins/custom/datatables/pt-br.json') }}"
                        },
                        columnDefs: [
                            { orderable: false, targets: 0 }, // Bloqueia ordenação na primeira coluna
                        ]
                    })).on("draw", (function () {
                        n()
                    })), document.querySelector('[data-kt-ecommerce-product-filter="search"]').addEventListener("keyup", (function (t) {
                        e.search(t.target.value).draw()
                    })), (() => {})(), n())
                }
            }
        }();
        KTUtil.onDOMContentLoaded((function () {
            KTAppEcommerceProducts.init()
        }));

        function saveUser(checkbox){
            var form = new FormData();
            form.append('_method', 'PUT');
            if (checkbox.checked){
                form.append('chat', 1);
            }

            $.ajax({
                url: '{{ route('admin.ultralims.chat.update', '_ID_') }}'.replace('_ID_', checkbox.value),
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function(data){
                    if(!data.success){
                        Swal.fire('Erro', data.message, 'error');
                    }
                },
                error: function(data){
                    Swal.fire('Erro', 'Falha ao salvar usuário, tente novamente', 'error');
                }
            });
        }
    </script>
@endpush
