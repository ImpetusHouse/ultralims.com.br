<div class="card card-flush mb-5 mb-lg-10">
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
                <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Procurar resposta"/>
            </div>
            <!--end::Search-->
        </div>
        <!--end::Card title-->
        <!--begin::Card toolbar-->
        <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
            <!--begin::Add product-->
            <a href="{{route('admin.tickets.configuration.pre-awnser.create')}}" class="btn btn-primary">Adicionar resposta</a>
            <!--end::Add product-->
        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->
    <div class="card-body pt-0">
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_ecommerce_products_table">
            <!--begin::Table head-->
            <thead>
            <!--begin::Table row-->
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                <th>Título</th>
                <th class="text-center w-100px">Ações</th>
            </tr>
            <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            <tbody class="fw-semibold text-gray-600">
            <!--begin::Table row-->
            @foreach ($preAwnsers as $awnser)
                <tr>
                    <!--begin::Título=-->
                    <td>
                        <div>
                            <!--begin::Title-->
                            <a href="{{route('admin.tickets.configuration.pre-awnser.edit', $awnser->hash_id)}}" class="text-gray-800 text-hover-primary fs-5 fw-bold" data-kt-ecommerce-product-filter="name" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $awnser->title }}">{{$awnser->title}}</a>
                            <a class="d-none" data-kt-ecommerce-product-filter="id">{{ $awnser->id }}</a>
                            <!--end::Title-->
                        </div>
                    </td>
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
    </div>
</div>

<div class="modal fade" id="makeMemberModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="overflow-y: scroll">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Criar motivo de recusa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="formAjax" method="post"
                  target="{{route('admin.tickets.configuration.reasons-refusal.store')}}">
                <div class="modal-body">
                    <div class="form-group mb-5">
                        <label for="title" class="form-label">Título</label>
                        <input type="text" class="form-control" id="title" placeholder="Título" name="title" required>
                    </div>


                    <div class="form-group mb-5">
                        <label for="content1" class="form-label">Resposta</label>
                        <textarea class="form-control" id="content1" placeholder="Resposta" name="awnser"
                                  required></textarea>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>


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
                            text: "Tem certeza que deseja excluir a resposta?",
                            icon: "question",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Sim, excluir",
                            cancelButtonText: "Não, cancelar",
                            customClass: {
                                cancelButton: "btn fw-bold btn-primary btn-active-light-primary",
                                confirmButton: "btn fw-bold btn-danger"
                            }
                        }).then((function (t) {
                            t.value ?
                                $.ajax({
                                    method: "POST",
                                    url: "{{route('admin.tickets.configuration.pre-awnser.destroy')}}",
                                    data: {id: n.querySelector('[data-kt-ecommerce-product-filter="id"]').innerText},
                                    success: function(rtn){
                                        if(rtn.success === true){
                                            Swal.fire({
                                                text: "Você excluiu a resposta",
                                                icon: "success",
                                                buttonsStyling: !1,
                                                confirmButtonText: "Ok, continuar",
                                                customClass: {confirmButton: "btn fw-bold btn-primary"}
                                            }).then((function () {
                                                e.row($(n)).remove().draw()
                                            }))
                                        }else{
                                            Swal.fire('Erro', rtn.message, 'error')
                                        }
                                    },
                                    error: function(){
                                        Swal.fire('Falha', 'Erro ao processar requisição', 'error');
                                    }
                                }) : "cancel" === t.dismiss && Swal.fire({
                                text: "A resposta não foi excluída.",
                                icon: "error",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok, continuar",
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
                        }, {orderable: !1, targets: 1}]
                    })).on("draw", (function () {
                        n()
                    })), document.querySelector('[data-kt-ecommerce-product-filter="search"]').addEventListener("keyup", (function (t) {
                        e.search(t.target.value).draw()
                    })), n())
                }
            }
        }();
        KTUtil.onDOMContentLoaded((function () {
            KTAppEcommerceProducts.init()
        }));
    </script>
    <script>
        $(document).ready(function () {

            $('.makeMember').click(function () {
                $('#makeMemberModal').modal('show');
            });

            $('.dTable2').DataTable({
                responsive: true,
                "language" : {
                    "url" : "{{ asset('assets/plugins/custom/datatables/pt-br.json') }}"
                }
            });

        });
    </script>
@endpush
