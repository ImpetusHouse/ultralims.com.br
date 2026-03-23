@extends('admin.layout')
@section('content')
    <div class="card mb-10">
        <div class="card-header card-header-stretch align-items-center border-0">
            <h3 class="card-title">{{ Auth::user()->can('Ticket Admin') ? 'Configurações':'Novo Ticket' }}</h3>
            <div class="card-toolbar">
                @if(Auth::user()->can('Ticket Admin'))
                    <a href="{{ route('admin.tickets.configuration.index') }}" class="btn btn-sm btn-icon btn-primary">
                        <span class="svg-icon svg-icon-2">
                            <i class="fas fa-cog"></i>
                        </span>
                    </a>
                @endif
                <a href="#" data-bs-toggle="modal" data-bs-target="#createTicket"
                   class="btn btn-sm btn-icon btn-primary" style="margin-left: 15px;">
                    <span class="svg-icon svg-icon-2">
                        <i class="fas fa-plus"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>

    <div class="row filters">
        <div class="col-md-2">
            <a href="{{Request::url()}}">
                <div
                    class="card p-7 hover-primary {{(isset($_GET['filter']) && $_GET['filter'] == 'open'  ? 'active' : '')}}">
                    <div class="d-flex w-100 justify-content-between align-items-center mb-4">
                        <i class="fas fa-envelope text-primary" style="font-size: 28px;"></i>
                        <b style="font-size: 38px !important;"
                           class="text-primary">{{ $tickets->count() }}</b>
                    </div>
                    <span class="fs-4 text-primary">Todos</span>
                </div>
            </a>
        </div>

        <div class="col-md-2">
            <a href="{{Request::url()}}?filter=open">
                <div
                    class="card p-7 hover-success {{(isset($_GET['filter']) && $_GET['filter'] == 'open'  ? 'active' : '')}}">
                    <div class="d-flex w-100 justify-content-between align-items-center mb-4">
                        <i class="fas fa-envelope text-success" style="font-size: 28px;"></i>
                        <b style="font-size: 38px !important;"
                           class="text-success">{{$ticketsStatics->where('status', 'open')->count()}}</b>
                    </div>
                    <span class="fs-4 text-success">Abertos</span>
                </div>
            </a>
        </div>

        <div class="col-md-2">
            <div
                class="card p-7 hover-warning {{(isset($_GET['filter']) && $_GET['filter'] == 'open'  ? 'active' : '')}}">
                <div class="d-flex w-100 justify-content-between align-items-center mb-4">
                    <i class="fas fa-envelope text-warning" style="font-size: 28px;"></i>
                    <b style="font-size: 38px !important;" class="text-warning">
                        @php
                            $iCount = 0;
                            /** @var TYPE_NAME $tickets */
                            foreach ($tickets as $ticket){
                                if ($ticket->users->count() > 0){
                                    $iCount++;
                                }
                            }
                        @endphp
                        {{ $iCount }}
                    </b>
                </div>
                <span class="fs-4 text-warning">Encaminhados</span>
            </div>
        </div>

        <div class="col-md-2">
            <a href="{{Request::url()}}?filter=operator_awnser">
                <div
                    class="card p-7 hover-primary {{(isset($_GET['filter']) && $_GET['filter'] == 'operator_awnser'  ? 'active' : '')}}">
                    <div class="d-flex w-100 justify-content-between align-items-center mb-4">
                        <i class="fas fa-envelope-open text-primary" style="font-size: 28px;"></i>
                        <b style="font-size: 38px !important;" class="text-primary">
                            @php
                                $total = 0;
                                foreach($ticketsStatics as $statics){
                                    if(isset($statics->getLastAwnser->from) && $statics->getLastAwnser->from == 1){
                                        $total++;
                                    }
                                }
                                echo $total;
                            @endphp
                        </b>
                    </div>
                    <span class="fs-4 text-primary">Resp. pelo {{ env('APP_NAME') }}</span>
                </div>
            </a>
        </div>

        <div class="col-md-2">
            <a href="{{Request::url()}}?filter=client_awnser">
                <div
                    class="card p-7 hover-purple {{(isset($_GET['filter']) && $_GET['filter'] == 'client_awnser'  ? 'active' : '')}}">
                    <div class="d-flex w-100 justify-content-between align-items-center mb-4">
                        <i class="fas fa-envelope-open-text" style="color: #7239EA; font-size: 28px;"></i>
                        <b style="font-size: 38px !important; color: #7239EA">
                            @php
                                $total = 0;
                                foreach($ticketsStatics as $statics){
                                    if(isset($statics->getLastAwnser->from) && $statics->getLastAwnser->from == 0){
                                        $total++;
                                    }
                                }
                                echo $total;
                            @endphp
                        </b>
                    </div>
                    <span class="fs-4" style="color: #7239EA">Resp. pelo cliente</span>
                </div>
            </a>
        </div>

        <div class="col-md-2">
            <a href="{{Request::url()}}?filter=closed">
                <div
                    class="card p-7 hover-danger {{(isset($_GET['filter']) && $_GET['filter'] == 'closed'  ? 'active' : '')}}">
                    <div class="d-flex w-100 justify-content-between align-items-center mb-4">
                        <i class="fas fa-hourglass-end text-danger" style="font-size: 28px;"></i>
                        <b style="font-size: 38px !important;"
                           class="text-danger">{{$ticketsStatics->where('status', 'closed')->count()}}</b>
                    </div>
                    <span class="fs-4 text-danger">Finalizado</span>
                </div>
            </a>
        </div>
    </div>

    <div class="card custom-search my-10">
        <div class="w-50" style="margin:0 auto;">
            <b class="d-block text-white text-center fs-3 mb-5">Procurar tickets</b>
            <input type="text" id="search" placeholder="Pesquise por: Nome, e-mail, telefone/celular, etc...">
        </div>

    </div>

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
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1"
                                  transform="rotate(45 17.0365 15.1223)" fill="currentColor"/>
                            <path
                                d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                fill="currentColor"/>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <input type="text" data-kt-ecommerce-product-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Procurar ticket"/>
                </div>
                <!--end::Search-->
            </div>
            <!--end::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                <div class="w-100 mw-150px">
                    <!--begin::Select2-->
                    <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                            data-placeholder="Status" data-kt-ecommerce-product-filter="status">
                        <option></option>
                        <option value="todos">Todos</option>
                        <option value="aberto">Aberto</option>
                        <option value="encaminhado">Encaminhado</option>
                        <option value="respondido">Respondido</option>
                        <option value="finalizado">Finalizado</option>
                    </select>
                    <!--end::Select2-->
                </div>
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
                    <th class="text-center">#</th>
                    <th>Tipo</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Atendente</th>
                    <th class="text-center">Status</th>
                    <th>Última resposta</th>
                    @if(Auth::user()->can('Ticket Admin'))
                        <th class="text-center">Ações</th>
                    @endif
                </tr>
                <!--end::Table row-->
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody class="fw-semibold text-gray-600">
                <!--begin::Table row-->
                @foreach($tickets as $ticket)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="ms-5">
                                    <!--begin::Title-->
                                    <a href="{{ route('admin.tickets.show', $ticket->hash_id) }}"
                                       class="text-gray-800 text-hover-primary fs-5 fw-bold"
                                       data-kt-ecommerce-product-filter="name">#{{ $ticket->id }}</a>
                                    <a class="d-none" data-kt-ecommerce-product-filter="id">{{ $ticket->hash_id }}</a>
                                    <!--end::Title-->
                                </div>
                            </div>
                        </td>
                        <td class="pe-0">{{ $ticket->type }}</td>
                        <td class="pe-0">{{$ticket->client->name}}</td>
                        <td class="pe-0">{{$ticket->client->email}}</td>
                        <td class="pe-0">{{$ticket->user->name ?? '----'}} {{$ticket->user->lastname ?? '' }}</td>
                        @php
                            $status = '';
                            $badge = '';
                            /** @var TYPE_NAME $ticket */
                            if ($ticket->status == 'open'){
                                if (($ticket->user_id == Auth::user()->id || $ticket->user_id == null) && $ticket->users->count() == 0){
                                    $status = 'Aberto';
                                    $badge = 'danger';
                                }else{
                                    $status = 'Encaminhado';
                                    $badge = 'warning';
                                }
                            }elseif ($ticket->status == 'closed'){
                                $status = 'Finalizado';
                                $badge = 'success';
                            }elseif ($ticket->status == 'awserving'){
                                $status = 'Respondido';
                                $badge = 'primary';
                            }
                        @endphp
                        <!--begin::Status=-->
                        <td class="text-center pe-0" data-order="{{ $status }}">
                            <!--begin::Badges-->
                            <div class="badge badge-light-{{ $badge }}">{{ $status }}</div>
                            <!--end::Badges-->
                        </td>
                        <!--end::Status=-->
                        <td class="pe-0">{{(isset($ticket->last_awnser_date) ? $ticket->last_awnser_date->format('d/m/Y H:i') : '----')}}</td>
                        <!--begin::Action=-->
                        @if(Auth::user()->can('Ticket Admin'))
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
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-kt-ecommerce-product-filter="delete_row">Excluir</a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                            </td>
                            <!--end::Action=-->
                        @endif
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

    <div class="modal fade" id="createTicket" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="overflow-y: scroll">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Abrir ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form-ticket" method="post" target="{{ route('admin.tickets.store') }}">
                    <input type="hidden" name="opened_by" value="{{Auth::user()->id}}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="form-group">
                                    <select name="type" id="type" class="form-select" data-control="select2"
                                            data-hide-search="true">
                                        <option value="Fale Conosco">Fale Conosco</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-4 mb-4">
                                <div class="form-group">
                                    <input type="text" name="name" id="name" placeholder="Nome completo*" required
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col-4 mb-4">
                                <div class="form-group">
                                    <input type="email" name="email" id="email" placeholder="E-mail*" required
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col-4 mb-4">
                                <div class="form-group">
                                    <input type="text" name="phone" id="phone" placeholder="Telefone*" required
                                           class="form-control mask-tel">
                                </div>
                            </div>

                            <div class="col-12 mb-4">
                                <div class="form-group">
                                    <input type="text" name="title" id="title" placeholder="Assunto*" required
                                           class="form-control">

                                </div>
                            </div>
                            <div class="col-12 mb-4">
                                <div class="form-group">
                                    <textarea name="description" id="description" required placeholder="Mensagem*"
                                              class="form-control textarea" rows="4" style="resize: none"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <!--begin::Button-->
                        <button type="submit" id="btnSubmit" class="btn btn-primary">
                            <span class="indicator-label">Salvar</span>
                            <span class="indicator-progress">Aguarde...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                        <!--end::Button-->
                    </div>
                </form>
            </div>
        </div>
    </div>
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
                            text: "Tem certeza que deseja excluir o ticket?",
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
                                    method: "DELETE",
                                    url: `{{route('admin.tickets.destroy', '_id_')}}`.replace('_id_', n.querySelector('[data-kt-ecommerce-product-filter="id"]').innerText),
                                    success: function (rtn) {
                                        if (rtn.success === true) {
                                            Swal.fire({
                                                text: "Você excluiu o ticket.",
                                                icon: "success",
                                                buttonsStyling: !1,
                                                confirmButtonText: "Ok, continuar",
                                                customClass: {confirmButton: "btn fw-bold btn-primary"}
                                            }).then((function () {
                                                e.row($(n)).remove().draw()
                                            }))
                                        } else {
                                            Swal.fire('Erro', rtn.message, 'error')
                                        }
                                    },
                                    error: function () {
                                        Swal.fire('Falha', 'Erro ao processar requisição', 'error');
                                    }
                                }) : "cancel" === t.dismiss && Swal.fire({
                                text: "O ticket não foi excluído.",
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
                        language: {
                            "url": "{{ asset('assets/plugins/custom/datatables/pt-br.json') }}"
                        },
                        columnDefs: [{
                            orderable: 1,
                            targets: 0
                        }, {
                            orderable: !1, targets: {{ Auth::user()->can('Ticket Admin') ? 7:6 }}
                        }]
                    })).on("draw", (function () {
                        n()
                    })), document.querySelector('[data-kt-ecommerce-product-filter="search"]').addEventListener("keyup", (function (t) {
                        e.search(t.target.value).draw()
                    })), (() => {
                        const t = document.querySelector('[data-kt-ecommerce-product-filter="status"]');
                        $(t).on("change", (t => {
                            let n = t.target.value;
                            "todos" === n && (n = ""), e.column(5).search(n).draw()
                        }))
                    }))
                }
            }
        }();
        KTUtil.onDOMContentLoaded((function () {
            KTAppEcommerceProducts.init()
        }));

        var submitButton = document.getElementById('btnSubmit');

        $('#form-ticket').on("submit", function (e) {
            e.preventDefault();

            submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
            submitButton.disabled = true;

            var form = new FormData(this);
            $.ajax({
                url: '{{ route('admin.tickets.store') }}',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function (data) {
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;
                    if (data.success) {
                        location.reload();
                    } else {
                        Swal.fire('Erro', data.message, 'error');
                    }
                },
                error: function (data) {
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;

                    Swal.fire('Falha', 'Falha ao criar ticket, tente novamente', 'error');
                }
            });

        });

        function limpar_campos() {
            $('select[name="type"]').val('Fale Conosco').trigger('change');
            $('input[name="name"]').val(null);
            $('input[name="email"]').val(null);
            $('input[name="phone"]').val(null);
            $('input[name="title"]').val(null);
            $('input[name="description"]').val(null);
        }
    </script>
@endpush

@push('head')
    <style>
        .custom-search {
            padding: 5rem 4rem;
            background-color: #2c294b !important;
        }

        [data-theme="dark"] .custom-search {
            background-color: #1e1e2d !important;
        }

        .custom-search input {
            background: rgba(0, 0, 0, 0.15) 0% 0% no-repeat padding-box;
            border-radius: 6px;
            color: #FFF !important;
            border: 0;
            padding: 18px 30px;
            outline: 0 !important;
            width: 100%;
        }

        .custom-search input::placeholder {
            color: #FFF;
        }

        .filters .card {
            border: 3px solid #FFF;
        }

        [data-theme="dark"] .filters .card {
            border: 3px solid #1e1e2d;
        }

        .filters .card.hover-danger:hover,
        .filters .card.hover-danger.active {
            border: 3px solid #f1416c;
        }

        .filters .card.hover-primary:hover,
        .filters .card.hover-primary.active {
            border: 3px solid #03B7FC;
        }

        .filters .card.hover-purple:hover,
        .filters .card.hover-purple.active {
            border: 3px solid #7239EA;
        }

        .filters .card.hover-warning:hover,
        .filters .card.hover-warning.active {
            border: 3px solid #ffc700;
        }

        .filters .card.hover-success:hover,
        .filters .card.hover-success.active {
            border: 3px solid #50cd89;
        }
    </style>
@endpush
