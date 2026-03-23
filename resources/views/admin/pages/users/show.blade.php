@extends('admin.layout')

@section('content')
    @include('admin.pages.users.header')

    <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
        <!--begin::Card header-->
        <div class="card-header cursor-pointer">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Informações do perfil</h3>
            </div>
            <!--end::Card title-->
            <!--begin::Action-->
            <a href="{{ route('admin.users.edit', $user->hash_id) }}" class="btn btn-sm btn-primary align-self-center">Editar usuário</a>
            <!--end::Action-->
        </div>
        <!--begin::Card header-->
        <!--begin::Card body-->
        <div class="card-body p-9">
            <!--begin::Row-->
            <div class="row mb-7">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">Nome completo</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-lg-8">
                    <span class="fw-bold fs-6 text-gray-800">{{ $user->name }} {{ $user->lastname }}</span>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->
            <!--begin::Input group-->
            <div class="row mb-7">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">Descrição</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-lg-8 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6">{{ $user->description }}</span>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="row mb-7">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">E-mail</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-lg-8 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6">{{ $user->email }}</span>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="row mb-7">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">Cargo</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-lg-8 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6">{{ ucwords($user->office) }}</span>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="row">
                <!--begin::Label-->
                <label class="col-lg-4 fw-semibold text-muted">Status</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-lg-8 fv-row">
                    <span class="fw-semibold text-gray-800 fs-6">{{ $user->status ? 'Ativo':'Inativo' }}</span>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Input group-->
            @if(Auth::user()->email == $user->email || Auth::user()->hasRole('Super-Admin'))
                <!--begin::Input group-->
                <div class="row mt-7">
                    <!--begin::Label-->
                    <label class="col-lg-4 fw-semibold text-muted">Autenticação em dois fatores</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8 fv-row">
                        @if($user->google2fa_secret == null)
                            @if(Auth::user()->email == $user->email)
                                <button class="btn btn-sm btn-primary" id="btnQrCode">Gerar QR Code</button>
                            @else
                                <span class="fw-semibold text-gray-800 fs-6">Inativo</span>
                            @endif
                        @else
                            @if(Auth::user()->hasRole('Super-Admin'))
                                <button class="btn btn-sm btn-danger" id="btnRemoveQrCode">Remover</button>
                            @else
                                <span class="fw-semibold text-gray-800 fs-6">Ativo</span>
                            @endif
                        @endif
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Input group-->
            @endif
        </div>
        <!--end::Card body-->
    </div>

    <div class="modal fade" id="modalQrCode" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form id="formMakeBlockTemplate">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">QR Code</h5>
                        <button type="button" class="btn-close" aria-label="Close" id="btnClose"></button>
                    </div>
                    <div class="modal-body text-center" id="qrCode">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let modalQrCode = new bootstrap.Modal(document.getElementById('modalQrCode'), {backdrop: 'static', keyboard: false});

        $('#btnQrCode').on('click', function (){
            $.ajax({
                url: '{{ route('admin.users.qrCode', $user->hash_id) }}',
                type: 'GET',
                processData: false,
                contentType: false,
                success: function(data){
                    console.log(data);
                    if (data.success){
                        $('#qrCode').html(data.qrCode);
                        modalQrCode.show();
                    }else{
                        Swal.fire('Falha!', 'Falha ao gerar QR Code', 'error');
                    }
                },
                error: function(data){
                    Swal.fire('Falha!', 'Falha ao gerar QR Code', 'error');
                }
            });
        });

        $('#btnClose').on('click', function (){
            Swal.fire({
                text: "Ao fechar essa janela você não terá mais acesso à esse QR Code",
                icon: "question",
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Fechar",
                cancelButtonText: "Cancelar",
                customClass: {
                    cancelButton: "btn fw-bold btn-primary",
                    confirmButton: "btn fw-bold btn-danger"
                }
            }).then((function (t) {
                if(t.value){
                    location.reload();
                }
            }))
        });

        $('#btnRemoveQrCode').on('click', function (){
            Swal.fire({
                text: "Tem certeza que deseja remover a autenticação de dois fatores?",
                icon: "question",
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Sim, remover",
                cancelButtonText: "Não, cancelar",
                customClass: {
                    cancelButton: "btn fw-bold btn-primary",
                    confirmButton: "btn fw-bold btn-danger"
                }
            }).then((function (t) {
                if(t.value){
                    $.ajax({
                        url: '{{ route('admin.users.removeQrCode', $user->hash_id) }}',
                        type: 'GET',
                        processData: false,
                        contentType: false,
                        success: function(data){
                            console.log(data);
                            if (data.success){
                                location.reload();
                            }else{
                                Swal.fire('Falha!', 'Falha ao remover autenticação em dois fatores', 'error');
                            }
                        },
                        error: function(data){
                            Swal.fire('Falha!', 'Falha ao remover autenticação em dois fatores', 'error');
                        }
                    });
                }
            }))
        });
    </script>
@endpush
