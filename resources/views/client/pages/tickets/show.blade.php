@extends('client.ticket_layout')
@push('head')
    <link rel="stylesheet" href="{{ asset('ckeditor/sample/custom.css') }}">
@endpush
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
                                                    echo '<span class="badge badge-light-danger" style="line-height: initial !important;">Aberto</span>';
                                                    break;
                                                case "closed":
                                                    echo '<span class="badge badge-danger" style="line-height: initial !important;">Finalizado</span>';
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
                                                            <h6 class="text-primary">{{$awnser->user->name}}</h6>
                                                        @else
                                                            <h6 class="text-primary">{{$awnser->client->name}}</h6>
                                                        @endif
                                                        <span class="date">{{$awnser->created_at->format('d/m/Y H:i')}}</span>
                                                    </div>

                                                    @if(count($awnser->attach) > 0)
                                                        <div>
                                                            <!--begin::More options-->
                                                            <a href="#" class="btn btn-sm btn-light" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                                Ver arquivos <i class="fa fa-angle-down"></i>
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
                                                        </div>
                                                    @endif

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
                                @elseif($awnser->awnser_to == null && $awnser->type == 2)
                                <div class="message-item proposal">
                                    <div class="message-header">
                                        <div class="d-flex mb-4">
                                            <div class="symbol w-40px h-40px bg-light-primary rounded me-5">
                                                <img src="{{$awnser->from == 1 ? ($awnser->user->photo != null ? asset(str_replace('public/', 'storage/', $awnser->user->photo)) : asset('images/default.png'))  :  asset('images/default.png')}}" alt="" class="rounded w-40px h-40px">
                                            </div>
                                            <div class="w-100">
                                                <div class="mb-1 w-100 d-flex justify-content-between">
                                                    <div>
                                                        @if($awnser->from == 1)
                                                            <h6 class="text-primary">{{$awnser->user->name}} - <span style="font-weight: 500 !important">{{$awnser->user->office}}</span></h6>
                                                        @else
                                                            <h6 class="text-primary">{{$awnser->client->name ?? $ticket->client_name}}</h6>
                                                        @endif
                                                        <span class="date">{{$awnser->created_at->format('d/m/Y H:i')}}</span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @if($ticket->status == 'closed' && $ticket->closed_by >= 1)
                            <div class="message-item" style="border-color: red;">
                                <div class="message-header">
                                    <div class="d-flex mb-4">
                                        <div class="symbol w-40px h-40px bg-light-primary rounded me-5">
                                            <img src="{{($awnser->user->photo != null ? asset(str_replace('public/', 'storage/', $awnser->user->photo)) : asset('images/default.png'))}}" alt="" class="rounded w-40px h-40px">
                                        </div>
                                        <div class="w-100">
                                            <div class="mb-1 w-100 d-flex justify-content-between">
                                                <div>
                                                    @if($awnser->from == 1)
                                                        <h6 class="text-primary">{{$ticket->closedBy->name}} - <span style="font-weight: 500 !important">{{$ticket->closedBy->office}}</span></h6>
                                                    @endif
                                                    <span class="date">{{$ticket->updated_at->format('d/m/Y H:i')}}</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="message">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <b>Ticket finalizado pelo atendente</b>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endif
                    </div>
                    @if($ticket->status == 'awserving')
                        <form id="sendMessageClient" method="post">
                            <div class="reply">
                                <label for="reply" class="form-label">Responder</label>
                                <div class="">
                                    <textarea class="form-control form-control-solid" id="message" name="message"></textarea>
                                    <div class="d-flex w-100 justify-content-end my-4 p-4">

                                        <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                                        <input type="hidden" name="client_id" value="{{$ticket->client_id}}">
                                        <input type="hidden" name="from" value="0">

                                        <input type="file" name="attach_message[]" id="attach_message" class="d-none" multiple="multiple">
                                        <div class="d-flex align-items-center me-3 attach_filename" style="display: none"></div>
                                        <button type="button" class="btn btn-primary btn-file btn-icon me-4" id="attach_button"><i class="fa fa-paperclip"></i></button>
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                </article>
                <aside class="col-md-4">
                    <div class="card mb-10 bg-light-dark" style="background: #eff2f580 !important">
                        <div class="card-body">
                            <h3 class="fs-3 me-5 mb-5">Informações do ticket</h3>
                            <div class="info mb-3">
                                <b>Tipo</b>
                                {{ $ticket->type }}
                            </div>
                        </div>
                    </div>
                    <div class="card bg-light-dark" style="background: #eff2f580 !important">
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
                            </div>
                        </div>
                    </div>

                    @if(isset($ticket->user))
                        <div class="card mt-10 bg-light-dark" style="background: #eff2f580 !important">
                            <div class="card-body">
                                <h3 class="fs-3 me-5 mb-5">Informações do atendente</h3>

                                <div class="info mb-3">
                                    <b>Nome</b>
                                    {{$ticket->user->name}} {{$ticket->user->lastname}}
                                </div>
                            </div>
                        </div>
                        @if(isset($ticket->files) && $ticket->files->count() > 0)
                        <div class="card mt-10 bg-light-dark" style="background: #eff2f580 !important">
                            <div class="card-body">
                                <h3 class="fs-3 me-5 mb-5">Arquivos compartilhados</h3>
                                @foreach ($ticket->files as $file)
                                    <a href="{{asset(str_replace('public/', 'storage/', $file->path))}}" target="_blank" class="badge badge-light-info mb-3 me-3">
                                        {!!$icons[$file->extension] ?? ''!!}
                                        {{$file->name}}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($ticket->status != 'closed')
                            <div class="mt-10 w-100 d-flex">
                                <button class="btn btn-primary-custom btn-block w-100" data-bs-toggle="modal" data-bs-target="#closeTicket">Finalizar atendimento</button>
                            </div>
                        @endif
                        @if($ticket->status == 'closed')
                            <div class="mt-10 w-100 d-flex">
                                <button class="btn btn-primary-custom btn-block w-100" onclick="reopenTicket()">Reabrir ticket</button>
                            </div>
                        @endif
                    @endif
                </aside>
            </section>
        </div>
    </div>


    <div class="modal fade" id="closeTicket" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="overflow-y: scroll">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Atenção!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="formAjax" method="post" target="{{route('tickets.set-status')}}">
                    <input type="hidden" name="from" value="0">
                    <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                    <input type="hidden" name="status" value="closed">

                    <div class="modal-body">

                        <p class="d-block mb-3">Deseja realmente finalizar este atendimento?</p>

                        <div class="form-group mt-5">
                            <label for="obs" class="form-label">Mensagem</label>
                            <textarea name="obs" class="form-control"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success btn-sm">Finalizar atendimento</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('ckeditor-simple/build/ckeditor.js')}}"></script>
    <script>
        let editor;

        if($('.phone').html().length <= 8){
            $('.phone').mask('(00) 0000-0000');
        }else{
            $('.phone').mask('(00) 00000-0000');
        }

        function reopenTicket(){

            Swal.fire({
                    title: 'Atenção!',
                    text: 'Deseja realmente reabrir este ticket?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#EF233C',
                    cancelButtonColor: '#E8EBEF',
                    confirmButtonText: 'Reabrir',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true,
                    buttons: {cancel: true, confirm: true},

                    customClass: {
                        cancelButton: 'btn btn-secondary',
                        confirmButton: 'btn btn-danger'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{route('tickets.set-status')}}',
                            type: 'POST',
                            data: {
                                from: 0,
                                status: 'awserving',
                                ticket_id: '{{$ticket->id}}'
                            },
                            success: function(data){
                                if(data.success){
                                    location.reload();
                                }else{
                                    Swal.fire('Erro!', data.message, 'error');
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

        $('#sendMessageClient').on('submit', function(e){
            e.preventDefault();

            var form = $(this)
            $fd = new FormData(form[0]);
            $fd.append('message', editor.getData());

            var formSerialize = form.serializeArray();
            formSerialize.push('message', editor.getData());

            $.ajax({
                url: "{{route('tickets.public.send-message', $ticket->hash_id)}}",
                type: 'POST',
                data: $fd,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(data){
                    if(data.success){
                        location.reload();
                    }else{
                        Swal.fire('Erro!', data.message, 'error');
                    }
                },
                error: function(data){
                    Swal.fire('Erro!', 'Ocorreu um erro ao enviar a mensagem', 'error');
                }
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
    <style>
        i{
            transition: all 0.2s ease-in-out;
            margin-left: 5px;
        }
        .rotate{
            transform: rotate(-90deg)
        }

        .ticket .ticket-header{
            width: 100;
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
            background: #FFFFFF 0% 0% no-repeat padding-box;
            border: 2px solid #009EF7 !important;
            color: #009EF7;
        }

        .btn-primary-custom:hover {
            background: #009EF7 0% 0% no-repeat padding-box;
            color: #FFFFFF;
        }

        .ticket .messages {
            margin: 35px 0;
        }

        .ticket .messages .message-item .text-primary{
           color: #181C32 !important;
        }

        .ticket .messages .message-item.proposal{
            border: 2px solid #7239EA;
        }

        .ticket .messages .message-item {
            padding: 15px;
            border: 2px solid #A1A5B720;
            border-radius: 12px;
            margin-bottom: 15px;
        }

        .ticket .messages .message-item.operator{
            margin-left: 45px;
        }


        .ticket .reply .bg-dark{
            background: #F4F5F6 0% 0% no-repeat padding-box !important;
            border-radius: 12px;
        }

        .ticket .reply .bg-dark textarea {
            border-radius: 12px 12px 0 0;
            background: #f4f5f6
        }

        .message-info {
            width: 100%;
            background-color: #eff2f580;
            padding: 10px;
            border-radius: 0.475rem;
        }
    </style>
@endpush
