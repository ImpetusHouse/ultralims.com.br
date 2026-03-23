@extends('admin.layout')
@section('content')
    <!--begin::Form-->
    <form class="form d-flex flex-column flex-lg-row saveArticle">
        <!--begin::Aside column-->
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10" style="min-width: 300px !important;">
            <!--begin::Status-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>Status</h2>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <div class="rounded-circle bg-success w-15px h-15px" id="status_icon"></div>
                    </div>
                    <!--begin::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Select2-->
                    <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="status" name="status">
                        <option></option>
                        <option value="1" {{ $logosCategory->status == 1 || $logosCategory->id == null ? 'selected':'' }}>Ativo</option>
                        <option value="0" {{ $logosCategory->status == 0 && $logosCategory->id > 0 ? 'selected':'' }}>Inativo</option>
                    </select>
                    <!--end::Select2-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7">Defina o status da categoria.</div>
                    <!--end::Description-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Status-->
        </div>
        <!--end::Aside column-->
        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <!--begin::General options-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>Geral</h2>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Input group-->
                    <div class="mb-10 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Título</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="title" class="form-control mb-2" placeholder="Título" value="{{ $logosCategory->title }}"/>
                        <!--end::Input-->
                        <!--begin::Description-->
                        <div class="text-muted fs-7">Um título é obrigatório.</div>
                        <!--end::Description-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="v-row">
                        <!--begin::Label-->
                        <label class="form-label">Logos</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="file" name="logos[]" class="form-control mb-2" accept="image/*" multiple="multiple"/>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row">
                        @foreach ($logosCategory->logos as $logo)
                            <div class="col-md-2 position-relative p-3">
                                <img src="{{ str_replace('public/', 'storage/', asset($logo->path)) }}" class="w-100 rounded" style="object-fit: cover; height: 125px;">

                                <div class="position-absolute m-3" style="right: 5px; top: 5px;">
                                    <button type="button" class="btn btn-sm btn-icon btn-light-danger" onclick="deleteLogo({{$logo->id}}, this)"><i class="fa fa-times fs-1"></i></button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Card header-->
            </div>
            <!--end::General options-->
            <!--end::Tab content-->
            <div class="d-flex justify-content-end">
                <!--begin::Button-->
                <button type="submit" id="btnSubmit" class="btn btn-primary">
                    <span class="indicator-label">Salvar</span>
                    <span class="indicator-progress">Aguarde...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
                <!--end::Button-->
            </div>
        </div>
        <!--end::Main column-->
    </form>
    <!--end::Form-->
@endsection

@push('scripts')
    {{-- DECLARAÇÃO DE VARIÁVEIS --}}
    <script>
        var submitButton = document.getElementById('btnSubmit');
    </script>
    {{-- SUBMIT FORMULÁRIO --}}
    <script>
        $('.saveArticle').on("submit", function(e){
            e.preventDefault();

            submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
            submitButton.disabled = true;

            var form = new FormData(this);
            @if($logosCategory->id > 0)
                form.append('_method', 'PUT');
            @endif
            $.ajax({
                url: '{{$logosCategory->id > 0 ? route('admin.logosCategories.update', $logosCategory->hash_id):route('admin.logosCategories.store')}}',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function(data){
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;
                    if(data.success){
                        Swal.fire({
                            text: data.message,
                            icon: "success",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Ver categorias",
                            cancelButtonText: "Nova categoria",
                            customClass: {
                                confirmButton: "btn fw-bold btn-secondary",
                                cancelButton: "btn fw-bold btn-primary"
                            },
                            allowOutsideClick: false
                        }).then((function (t) {
                            if (t.value){
                                window.location.href = '{{route('admin.logosCategories.index')}}'
                            }else{
                                window.location.href = '{{route('admin.logosCategories.create')}}'
                            }
                        }))
                    }else{
                        Swal.fire('Erro', data.message, 'error');
                    }
                },
                error: function(data){
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;

                    Swal.fire('Falha!', 'Falha ao {{ $logosCategory->id > 0 ? 'salvar':'editar' }} categoria de logos', 'error');
                }
            });

        });
    </script>
    {{-- DECLARAÇÃO: (STATUS) --}}
    <script>
        var statusColors = ["bg-success", "bg-danger"];
        var statusIcon = document.getElementById("status_icon");
        $('#status').on('change', function (){
            switch (this.value) {
                case"1":
                    statusIcon.classList.remove(...statusColors);
                    statusIcon.classList.add("bg-success");
                    break;
                case"0":
                    statusIcon.classList.remove(...statusColors);
                    statusIcon.classList.add("bg-danger");
                    break;
            }
        });
        $('#status').trigger('change');
    </script>
    {{-- CRUD LOGO --}}
    <script>
        function deleteLogo(id){
            Swal.fire({
                text: "Tem certeza que deseja excluir a logo?",
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
                if(t.value){
                    $.ajax({
                        method: "DELETE",
                        url: `{{route('admin.logosCategories.logos.destroy', '_id_')}}`.replace('_id_', id),
                        success: function (rtn) {
                            if (rtn.success === true) {
                                Swal.fire({
                                    text: "Você excluiu a logo",
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, continuar!",
                                    customClass: {confirmButton: "btn fw-bold btn-primary"}
                                }).then((function () {
                                    location.reload()
                                }))
                            } else {
                                Swal.fire('Erro!', rtn.message, 'error')
                            }
                        },
                        error: function () {
                            Swal.fire('Falha!', 'Erro ao processar requisição', 'error');
                        }
                    })
                }
            }))
        }
    </script>
@endpush
