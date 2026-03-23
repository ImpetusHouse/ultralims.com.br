<div class="card-header mb-5">
    <!--begin::Card title-->
    <div class="card-title">
        Motivos de recusa
    </div>
    <!--begin::Card title-->
    <!--begin::Card toolbar-->
    <div class="card-toolbar">
        <!--begin::Toolbar-->
        <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
            <button type="button" class="btn btn-sm btn-icon btn-primary btn-active-light-primary"
                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                <!--begin::Svg Icon | path: icons/duotune/general/gen024.svg-->
                <span class="svg-icon svg-icon-2">
                        <i class="fas fa-plus"></i>
                    </span>
                <!--end::Svg Icon-->
            </button>
            <!--begin::Menu 3-->
            <div
                class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-250px py-3"
                data-kt-menu="true">
                <!--begin::Heading-->
                <div class="menu-item px-3">
                    <a class="menu-link pb-2 px-3 fs-7" href="#" data-bs-toggle="modal"
                       data-bs-target="#makeMemberModal">Criar motivo</a>
                </div>
                <!--end::Heading-->
            </div>
            <!--end::Menu 3-->
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Card toolbar-->
</div>

<div class="card-body">
    <table class="table table-row-bordered gy-5 dTable">
        <thead>
        <tr>
            <th>Motivo</th>
            <th>Somente para administradores</th>
            <th>Mostrar em</th>
            <th class="text-end"><i class="fa fa-cog"></i></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($reasonsRefusals as $reason)
            <tr>
                <td>{{$reason->reason}}</td>
                <td>{!!$reason->only_adm == 1 ? '<span class="badge badge-light-success">Sim</span>' : '<span class="badge badge-light-danger">Não</span>'!!}</td>
                <td>
                    @switch($reason->show_to)
                        @case('all')
                        Todos
                        @break
                        @case('only_proposal')
                        Fechamento de proposta
                        @break
                        @case('only_ticket')
                        Fechamento de ticket
                        @break
                        @default

                    @endswitch
                </td>
                <td class="text-end">
                    <button class="btn btn-icon btn-sm btn-light-primary" data-bs-toggle="modal"
                            data-bs-target="#changeReason_{{$reason->hash_id}}"><i class="fa fa-pen"></i></button>
                    <button class="btn btn-icon btn-sm btn-light-danger" onclick="deleteReason({{$reason->id}})"><i
                            class="fa fa-trash"></i></button>
                </td>
                <div class="modal fade" id="changeReason_{{$reason->hash_id}}" tabindex="-1"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content" style="overflow-y: scroll">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Editar motivo de recusa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <form class="formAjax" method="post"
                                  target="{{route('admin.tickets.configuration.reasons-refusal.update', $reason->hash_id)}}">
                                <div class="modal-body">
                                    <div class="form-group mb-5">
                                        <label for="reason" class="form-label">Motivo</label>
                                        <input type="text" class="form-control" id="reason"
                                               value="{{$reason->reason}}" placeholder="Motivo" name="reason"
                                               required>
                                    </div>


                                    <div class="w-100 mt-5 d-flex justify-content-between">
                                        <div>
                                            <div class="form-label">Somente para administradores:</div>
                                        </div>
                                        <div>
                                            <div
                                                class="form-check form-check-custom form-check-solid form-check-sm  text-end">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                       {{$reason->only_adm == 1 ? 'checked': ''}} name="only_adm"
                                                       id="only_adm"/>
                                                <label class="form-check-label" for="only_adm">
                                                    Sim
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="show_to" class="form-label">Mostrar em:</label>
                                            <select class="form-select" name="show_to" id="show_to">
                                                <option
                                                    value="only_ticket" {{$reason->show_to == 'only_ticket' ? 'selected': ''}}>
                                                    Fechamento de ticket
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="is_operador" class="form-label">Destinado para:</label>
                                            <span class="text-muted">Somente para fechamento de ticket</span>
                                            <select class="form-select" name="is_operator" id="is_operador">
                                                <option value="0" {{$reason->show_to == 0 ? 'selected': ''}}>
                                                    Clientes
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Cancelar
                                    </button>
                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </tr>
        @endforeach
        </tbody>
    </table>

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
                        <label for="reason" class="form-label">Motivo</label>
                        <input type="text" class="form-control" id="reason" placeholder="Motivo" name="reason" required>
                    </div>


                    <div class="w-100 mt-5 d-flex justify-content-between">
                        <div>
                            <div class="form-label">Somente para administradores:</div>
                        </div>
                        <div>
                            <div class="form-check form-check-custom form-check-solid form-check-sm  text-end">
                                <input class="form-check-input" type="checkbox" value="1" name="only_adm"
                                       id="only_adm"/>
                                <label class="form-check-label" for="only_adm">
                                    Sim
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="form-group">
                            <label for="show_to" class="form-label">Mostrar em:</label>
                            <select class="form-select" name="show_to" id="show_to">
                                <option value="only_ticket">Fechamento de ticket</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="form-group">
                            <label for="is_operador" class="form-label">Destinado para:</label>
                            <span class="text-muted">Somente para fechamento de ticket</span>
                            <select class="form-select" name="is_operator" id="is_operador">
                                <option value="0">Clientes</option>
                            </select>
                        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
            crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script>

        function deleteReason(id) {
            Swal.fire({
                title: 'Deseja deletar este motivo de recusa?',
                text: "Você não poderá reverter isso",
                input: 'text',
                inputLabel: 'Digite DELETAR',
                cancelButtonText: 'Cancelar',
                showCancelButton: true,
                showCancelButton: true,
                inputValidator: (value) => {
                    if (!value) {
                        return 'Você precisa digitar DELETAR'
                    } else if (value === 'DELETAR') {
                        $.ajax({
                            method: "POST",
                            url: "{{route('admin.tickets.configuration.reasons-refusal.destroy')}}",
                            data: {id: id},
                            success: function (rtn) {
                                if (rtn.success) {
                                    if (rtn.reloaded) {
                                        location.reload();
                                    } else {
                                        Swal.fire('Sucesso', rtn.message, 'success');
                                    }
                                } else {
                                    Swal.fire('Erro', rtn.error, 'error')
                                }
                            },
                            error: function () {
                                Swal.fire('Falha', 'Erro ao processar requisição', 'error');
                            }
                        })
                    } else {
                        swal.fire('Erro', 'Você não digitou deletar', 'error')
                    }
                }
            })
        }

        $(document).ready(function () {

            $('.makeMember').click(function () {
                $('#makeMemberModal').modal('show');
            });

            $('.dTable').DataTable({
                responsive: true,
                "language" : {
                    "url" : "{{ asset('assets/plugins/custom/datatables/pt-br.json') }}"
                }
            });

        });
    </script>
@endpush
