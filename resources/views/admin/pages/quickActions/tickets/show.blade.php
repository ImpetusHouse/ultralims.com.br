@extends('admin.layout')
@section('content')
    <div class="card">
        <div class="card-body">
            <section class="row ticket">
                <article class="col-md-8">
                    <div class="ticket-header">
                        <div class="d-flex mb-4">
                            <div class="symbol w-60px h-60px bg-light-primary rounded me-5">
                                <img src="{{asset('images/default.png')}}" alt="" class="rounded w-60px h-60px">
                            </div>
                            <div class="infos">
                                <div class="top">
                                    <h3 class="fs-3 me-5 mb-0">{{$ticket->title}}</h3>

                                        @php
                                            /** @var TYPE_NAME $ticket */
                                            switch($ticket->status){
                                                case "open":
                                                    if (($ticket->user_id == Auth::user()->id || $ticket->user_id == null) && $ticket->users->count() == 0){
                                                        echo '<span class="badge badge-light-danger" style="line-height: initial !important;">Aberto</span>';
                                                    }else{
                                                        echo '<span class="badge badge-light-warning" style="line-height: initial !important;">Encaminhado</span>';
                                                    }
                                                    break;
                                                case "closed":
                                                    echo '<span class="badge badge-light-success" style="line-height: initial !important;">Finalizado</span>';
                                                    break;
                                                case "awserving":
                                                    echo '<span class="badge badge-light-primary" style="line-height: initial !important;">Respondido</span>';
                                                    break;
                                            }
                                        @endphp

                                </div>
                                <div class="bottom">
                                    <span class="text-primary d-inline-block me-5">#{{$ticket->id}}</span>
                                    <span class="date">Criado em: {{$ticket->created_at->format('d/m/Y H:i')}}</span>
                                </div>

                            </div>

                        </div>
                        <div>
                            <p>{!! nl2br($ticket->description) !!}</p>
                        </div>

                        @if($ticket->files->where('awnser_id', null) !== null && $ticket->files->where('awnser_id', null)->count() > 0)
                            <div class="files">
                                @foreach ($ticket->files->where('awnser_id', null) as $file)
                                    <a href="{{asset(str_replace('public/', 'storage/', $file->path))}}" target="_blank" class="bg-white text-primary me-4"><i class="fas fa-download text-primary me-2"></i> {{$file->name}}</a>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="messages">
                        @foreach($ticket->awnsers as $awnser)
                            @if ($awnser->awnser_to == null && $awnser->type == 1)
                                <div class="message-item {{$awnser->from == 1 ? 'operator' : 'client'}}" >
                                    <div class="message-header">
                                        <div class="d-flex mb-4">
                                            <div class="symbol w-40px h-40px bg-light-primary rounded me-5">
                                                <img src="{{$awnser->from == 1 ? ($awnser->user->photo != null ? asset(str_replace('public/', 'storage/', $awnser->user->photo)) : asset('images/default.png'))  :  asset('images/default.png')}}" alt="" class="rounded w-40px h-40px">
                                            </div>
                                            <div class="w-100">
                                                <div class="mb-1 w-100 d-flex justify-content-between">
                                                    <div>
                                                        @if($awnser->from == 1)
                                                            <h6>{{$awnser->user->name}}</h6>
                                                        @else
                                                            <h6>{{$awnser->client->name ?? $ticket->client_name}}</h6>
                                                        @endif
                                                        <span class="date">{{$awnser->created_at->format('d/m/Y H:i')}}</span>
                                                    </div>

                                                    <div>
                                                    @if(count($awnser->attach) > 0)
                                                        <!--begin::More options-->
                                                            <a href="#" class="btn btn-sm btn-light" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                                Ver arquivos
                                                                <i class="fa fa-angle-down"></i>
                                                            </a>
                                                            <!--begin::Menu-->
                                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-6 w-300px py-4" data-kt-menu="true" style="">

                                                                @foreach ($awnser->attach as $attach)
                                                                    <div class="menu-item px-3">
                                                                        <a href="{{asset(str_replace('public/', 'storage/', $attach->path))}}" target="_blank" class="menu-link px-3">
                                                                            <span>{{ $attach->name }}</span>
                                                                        </a>
                                                                    </div>
                                                                @endforeach
                                                            <!--end::Menu item-->
                                                            </div>
                                                            <!--end::Menu-->
                                                            <!--end::More options-->
                                                        @endif

                                                        @if(Auth::user()->hasPermissionTo('Ticket Admin') && $awnser->from == 1)
                                                            <a class="bg-white" style="margin-left: 8px; color: #a1a5b7; cursor: pointer" onclick="deleteAwnser('{{$awnser->hash_id}}')"><i class="fas fa-trash me-2 lixeira"></i></a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="message">
                                        {!! nl2br($awnser->message) !!}
                                    </div>
                                </div>
                            @elseif($awnser->awnser_to == null && $awnser->type == 3)
                                <div class="message-info mb-4">
                                    <b>{{$awnser->message}}</b>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @if($ticket->status == 'awserving' && $ticket->user_id == Auth::id()
                        or $ticket->user_id == null && $ticket->status == 'open'
                        or $ticket->user_id == Auth::id() && $ticket->status == 'open'
                        or $ticket->users->contains(Auth::user())
                    )
                        <form id="sendMessage">
                            <div class="reply">
                                <label for="reply" class="form-label">Responder</label>
                                <div class="">
                                    <textarea class="form-control" id="message" name="message" rows="5" style="resize: none"></textarea>
                                    <div class="d-flex w-100 justify-content-end my-4 p-4">

                                        <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                                        <input type="hidden" name="user_id" value="{{Auth::id()}}">
                                        <input type="hidden" name="from" value="1">

                                        <input type="file" name="attach_message[]" id="attach_message" class="d-none" multiple="multiple">
                                        <div class="d-flex align-items-center me-3 attach_filename" style="display: none"></div>
                                        <button type="button" class="btn btn-primary btn-file btn-icon me-4" id="attach_button"><i class="fa fa-paperclip"></i></button>
                                        <button type="submit" id="btnSubmit" class="btn btn-primary">
                                            <span class="indicator-label">Enviar</span>
                                            <span class="indicator-progress">Aguarde...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    @endif
                </article>
                <aside class="col-md-4">
                    <div class="card mb-10 bg-light-dark">
                        <div class="card-body">
                            <h3 class="fs-3 me-5 mb-5">Informações do ticket</h3>
                            <div class="info mb-3">
                                <b>Tipo</b>
                                {{ $ticket->type }}
                            </div>
                        </div>
                    </div>

                    <div class="card bg-light-dark">
                        <div class="card-body">
                            <h3 class="fs-3 me-5 mb-0 accordion-collapse">Informações do cliente <i class="fa fa-angle-down"></i></h3>
                            <div class="accordion mt-5">
                                <div class="info mb-3">
                                    <b>Nome</b>
                                    {{$ticket->client->name}}
                                </div>
                                <div class="info mb-3">
                                    <b>E-mail</b>
                                    {{$ticket->client->email}}
                                </div>
                                <div class="info mb-3">
                                    <b>Telefone</b>
                                    <span class="phone">{{$ticket->client->phone}}</span>
                                </div>
                                @if($ticket->client->cpf_cnpj != null)
                                    <div class="info mb-3">
                                        <b>CPF/CNPJ</b>
                                        <span>{{ $ticket->client->cpf_cnpj }}</span>
                                    </div>
                                @endif
                                @if($ticket->client->company_name != null)
                                    <div class="info mb-3">
                                        <b>Empresa</b>
                                        <span>{{ $ticket->client->company_name }}</span>
                                    </div>
                                @endif
                                @if($ticket->client->state != null)
                                    <div class="info mb-3">
                                        <b>Estado</b>
                                        <span>{{ $ticket->client->state }}</span>
                                    </div>
                                @endif
                                @if($ticket->client->city != null)
                                    <div class="info mb-3">
                                        <b>Cidade</b>
                                        <span>{{ $ticket->client->city }}</span>
                                    </div>
                                @endif
                                @if($ticket->client->is_member != null)
                                    <div class="info mb-3">
                                        <b>Membro?</b>
                                        <span>{{ $ticket->client->is_member ? 'Sim':'Não' }}</span>
                                    </div>
                                @endif
                                @if($ticket->client->is_member != null)
                                    <div class="info mb-3">
                                        <b>Número de membro</b>
                                        <span>{{ $ticket->client->member_number }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($ticket->utm_source || $ticket->utm_medium || $ticket->utm_campaign)
                        <div class="card mt-10 bg-light-dark">
                            <div class="card-body">
                                <h3 class="fs-3 me-5 mb-0 accordion-collapse">Origem da conversão <i class="fa fa-angle-down"></i></h3>
                                <div class="accordion mt-5">
                                    @if($ticket->utm_source)
                                        <div class="info mb-3">
                                            <b>Source (utm_source)</b>
                                            {{$ticket->utm_source}}
                                        </div>
                                    @endif
                                    @if($ticket->utm_medium)
                                        <div class="info mb-3">
                                            <b>Medium (utm_medium)</b>
                                            {{$ticket->utm_medium}}
                                        </div>
                                    @endif
                                    @if($ticket->utm_campaign)
                                        <div class="info mb-3">
                                            <b>Campaign (utm_campaign)</b>
                                            {{$ticket->utm_campaign}}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(isset($ticket->user) || Auth::user()->hasPermissionTo('Ticket Admin'))
                        @if(isset($ticket->user))
                            <div class="card mt-10 bg-light-dark">
                                <div class="card-body">
                                    <h3 class="fs-3 me-5 mb-5">Informações do atendente</h3>

                                    <div class="info mb-3">
                                        <b>Nome</b>
                                        {{$ticket->user->name}} {{$ticket->user->lastname}}
                                    </div>

                                </div>
                            </div>
                        @endif

                        @if(isset($ticket->files) && $ticket->files->count() > 0)
                            <div class="card mt-10 bg-light-dark">
                                <div class="card-body">
                                    <h3 class="fs-3 me-5 mb-5">Arquivos compartilhados</h3>
                                    @foreach ($ticket->files as $file)
                                        <a href="{{asset(str_replace('public/', 'storage/', $file->path))}}" target="_blank" class="mb-3 me-3">
                                            {!!$icons[$file->extension] ?? ''!!}
                                            {{$file->name}}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if(($ticket->status != 'closed' && $ticket->user_id == Auth::id()) || ($ticket->status != 'closed' && Auth::user()->hasPermissionTo('Ticket Admin')))
                            <div class="card mt-10">
                                <div class="card-toolbar d-flex justify-content-end">
                                    <button class="btn btn-sm btn-primary-custom btn-block w-100" style="margin-right: 6px" onclick="setTicketStatus('closed')">Finalizar atendimento</button>
                                    <div>
                                        <!--begin::More options-->
                                        <a href="#" class="btn btn-sm btn-primary-custom menu-dropdown" style="padding: calc(0.65rem + 1px)" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </a>
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-6 w-300px py-4 " data-kt-menu="true" data-popper-placement="bottom-end">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" class="menu-link px-3" onclick="setTicketStatus('closed')">Finalizar</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#forwardTicket" class="menu-link px-3">Encaminhar</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#transferTicket" class="menu-link px-3">Transferir atendimento</a>
                                            </div>
                                            @if(($ticket->status != 'closed' && $ticket->user_id == Auth::id()))
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3 bg-danger text-white" onclick="setTicketStatus('userOut')">Desistir do atendimento</a>
                                                </div>
                                            @endif
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu-->
                                        <!--end::More options-->
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif

                    @if($ticket->status == 'closed')
                        <div class="mt-10 w-100 d-flex">
                            <button class="btn btn-primary-custom btn-block w-100" onclick="reopenTicket()">Reabrir ticket</button>
                        </div>
                    @endif
                </aside>
            </section>
        </div>
    </div>

    <div class="modal fade" id="transferTicket" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="overflow-y: scroll">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Transferir Ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" class="formTransferTicket" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <select name="type" id="typeTransfer" class="form-select">
                                <option></option>
                                @foreach($users as $item)
                                    <option value="{{ $item->id }}">{{ $item->name.' '.$item->lastname }}</option>
                                @endforeach
                                {{--@if($ticket->type != 'Fale Conosco')
                                    <option value="Fale Conosco">Fale Conosco</option>
                                @endif--}}
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnCloseTransferModal" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Transferir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="forwardTicket" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="overflow-y: scroll">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Transferir Ticket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" class="formForwardTicket" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <select name="users_id[]" id="users_id" class="form-select" multiple="multiple">
                                @foreach(\App\Models\User::orderBy('name')->orderBy('lastname')->where('status', true)->get() as $item)
                                    <option value="{{ $item->id }}" {{ $ticket->users->contains($item) ? 'selected':'' }}>{{ $item->name.' '.$item->lastname }}</option>
                                @endforeach
                                {{--@if($ticket->type != 'Fale Conosco')
                                    <option value="Fale Conosco">Fale Conosco</option>
                                @endif--}}
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnCloseForwardModal" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Encaminhar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('ckeditor-simple/build/ckeditor.js')}}"></script>
    <script>
        var submitButton = document.getElementById('btnSubmit');
        function deleteAwnser(id){
            Swal.fire({
                text: "Deseja realmente excluir esta resposta? Esta ação não poderá ser desfeita",
                icon: 'question',
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Sim, excluir",
                cancelButtonText: "Não, cancelar",
                customClass: {
                    cancelButton: "btn fw-bold btn-primary btn-active-light-primary",
                    confirmButton: "btn fw-bold btn-danger"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "DELETE",
                        url: `{{route('admin.tickets.deleteMessage', '_id_')}}`.replace('_id_', id),
                        data: {id: id},
                        success: function(rtn){
                            if(rtn.success === true){
                                location.reload();
                            }else{
                                Swal.fire('Erro', rtn.message, 'error')
                            }
                        },
                        error: function(){
                            Swal.fire('Falha', 'Erro ao processar requisição', 'error');
                        }
                    })
                }
            })
        }

        let editor;

        if($('.phone').html().length <= 8){
            $('.phone').mask('(00) 0000-0000');
        }else{
            $('.phone').mask('(00) 00000-0000');
        }

        function reopenTicket(){
            Swal.fire({
                text: 'Deseja realmente reabrir este ticket?',
                icon: 'question',
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Sim, reabrir",
                cancelButtonText: "Não, cancelar",
                customClass: {
                    cancelButton: "btn fw-bold btn-primary btn-active-light-primary",
                    confirmButton: "btn fw-bold btn-secondary"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{route('tickets.set-status')}}',
                        type: 'POST',
                        data: {
                            from: 1,
                            status: '{{ isset($ticket->user) ? 'awserving':'open' }}',
                            ticket_id: '{{$ticket->id}}'
                        },
                        success: function(data){
                            if(data.success){
                                location.reload();
                            }else{
                                Swal.fire('Erro', data.message, 'error');
                            }
                        }
                    });
                }
            })

        }

        function setTicketUser(){
            $.ajax({
                url: '{{route('admin.tickets.set-user')}}',
                type: 'POST',
                data: {
                    ticket_id: '{{$ticket->id}}'
                },
                success: function(data){
                    if(data.success){
                       location.reload();
                    }else{
                        Swal.fire({
                            title: 'Erro',
                            text: data.message,
                            type: 'error'
                        });
                    }
                }
            });
        }

        $("#typeTransfer").select2({
            dropdownParent: $("#transferTicket"),
            placeholder: 'Selecione o usuário para quem deseja transferir o ticket'
        });

        const addSelectAll = matches => {
            // Adiciona a opção "Select all" apenas se ela ainda não existir
            if (!matches.some(match => match.id === 'selectAll')) {
                matches.unshift({id: 'selectAll', text: 'Selecionar todos'});
            }
            return matches;
        };

        const handleSelection = event => {
            const $select = $('#users_id');
            if (event.params.data.id === 'selectAll') {
                // Não todos estão selecionados, então marque todos
                $select.val($select.find('option').map(function () { return this.value })).trigger('change');
            }
        };

        $("#users_id").select2({
            dropdownParent: $("#forwardTicket"), // Certifique-se de que o elemento com ID forwardTicket existe
            placeholder: 'Selecione os usuários para quem deseja encaminhar o ticket',
            allowClear: true,
            sorter: addSelectAll
        }).on('select2:select', handleSelection).on('select2:unselect', handleSelection);

        $('.formTransferTicket').on("submit", function(e){
            e.preventDefault();
            $('#btnCloseTransferModal').click();
            setTicketStatus('userOut', $('#typeTransfer').val());
        });

        $('.formForwardTicket').on("submit", function(e){
            e.preventDefault();

            var form = new FormData(this);
            form.append('ticket_id', '{{$ticket->id}}');
            $('#btnCloseForwardModal').click();

            Swal.fire({
                text: "Deseja realmente encaminhar este ticket?",
                icon: 'question',
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: 'Sim, encaminhar',
                cancelButtonText: 'Não, cancelar',
                customClass: {
                    cancelButton: "btn fw-bold btn-primary btn-active-light-primary",
                    confirmButton: "btn fw-bold btn-danger"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.tickets.forward') }}',
                        type: 'POST',
                        data: form,
                        processData: false,
                        contentType: false,
                        success: function(data){
                            if(data.success){
                                //location.reload();
                                location.href = '{{ route('admin.tickets.index') }}';
                            }else{
                                Swal.fire('Erro', data.message, 'error');
                            }
                        }
                    });
                }
            })
        });

        function setTicketStatus(status, type = null){
            Swal.fire({
                text: "Deseja realmente alterar o status deste ticket? Esta ação não poderá ser desfeita",
                icon: 'question',
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: 'Sim, alterar',
                cancelButtonText: 'Não, cancelar',
                customClass: {
                    cancelButton: "btn fw-bold btn-primary btn-active-light-primary",
                    confirmButton: "btn fw-bold btn-danger"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{route('admin.tickets.set-status')}}',
                        type: 'POST',
                        data: {
                            ticket_id: '{{$ticket->id}}',
                            status: status,
                            user_id: type,
                            //type: type,
                            from: 1
                        },
                        success: function(data){
                            if(data.success){
                                location.reload();
                            }else{
                                Swal.fire('Erro', data.message, 'error');
                            }
                        }
                    });
                }
            })
        }

        $('.accordion-collapse').click(function(){
            $(this).find('i').toggleClass('rotate');
            $(this).parent().find('.accordion').slideToggle();
        });

        $('#attach_button').on('click', function(){
            $('#attach_message').click();
        });

        $('#attach_message').on('change', function(){
            var html = '';
            if ($(this)[0].files.length > 0){
                for (var i = 0; i < $(this)[0].files.length; i++){
                    html += $(this)[0].files[i].name+', ';
                }
                $('.attach_filename').html(html.substring(0, html.length - 2)).fadeIn();
            }else{
                $('.attach_filename').html('').fadeOut();
            }
        });

        $('#sendMessage').on('submit', this, function(e){
            e.preventDefault();

            submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
            submitButton.disabled = true;

            $fd = new FormData(this);
            $fd.append('message', editor.getData());
            $.ajax({
                method: 'POST',
                url: '{{route('admin.tickets.send-message')}}',
                data: $fd,
                contentType: false,
                processData: false,
                success: function(data){
                    if(data.success){
                        location.reload();
                    }else{
                        Swal.fire('Erro', data.message, 'error');
                    }
                },
                error: function(){
                }
            }).done(function (data){
                submitButton.removeAttribute('data-kt-indicator');
                submitButton.disabled = false;
            });
        })

        ClassicEditor.create(document.querySelector( '#message' ), {
            language: 'pt-br',
            removePlugins: ['Title'],
            placeholder: '',
        })
        .then( newEditor => {
            editor = newEditor;
        }).catch( error => {
            console.error( error );
        });
    </script>
@endpush

@push('head')
    <link rel="stylesheet" href="{{ asset('ckeditor/sample/custom.css') }}">
    <style>
        i{
            transition: all 0.2s ease-in-out;
            margin-left: 5px;
        }

        .ticket .ticket-header{
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        .ticket .ticket-header .infos {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .ticket .ticket-header .infos .top {
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 10px;
        }

        aside .info b{
            display: block;
        }

        .btn-primary-custom {
            background: #FFFFFF 0 0 no-repeat padding-box;
            border: 2px solid #009EF7 !important;
            color: #009EF7;
        }

        .btn-primary-custom i{
            color: #009EF7;
        }

        [data-theme="dark"] .btn-primary-custom{
            background: #1e1e2d 0 0 no-repeat padding-box;
        }

        .btn-primary-custom:hover {
            background: #009EF7 0 0 no-repeat padding-box;
            color: #FFFFFF;
        }

        .btn-primary-custom:hover i{
            color: #FFFFFF;
        }

        .ticket .messages {
            margin: 35px 0;
        }

        .ticket .messages .message-item {
            padding: 15px;
            border: 2px solid #A1A5B720;
            border-radius: 12px;
            margin-bottom: 15px;
        }

        .ticket .messages .message-item.client{
            margin-left: 35px;
        }

        .message-info {
            width: 100%;
            background-color: #eff2f5;
            padding: 10px;
            border-radius: 0.475rem;
        }

        [data-theme="dark"] .message-info{
            background-color: #2b2b40;
        }

        .lixeira:hover{
            color: #f1416c;
        }
    </style>
@endpush
