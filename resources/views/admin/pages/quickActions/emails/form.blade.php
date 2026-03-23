@extends('admin.layout')

@push('head')
    <link rel="stylesheet" href="{{ asset('ckeditor/sample/custom.css') }}">
    <style>
        .ck-powered-by-balloon{
            display: none !important;
        }
    </style>
@endpush

@section('content')
    <!--begin::Form-->
    <form class="form d-flex flex-column flex-lg-row saveEmail">
        <!--begin::Aside column-->
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10" style="min-width: 300px !important;">
            <!--begin::Status-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title required">
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
                        <option value="1" {{ $email->status == 1 || $email->id == null ? 'selected':'' }}>Ativo</option>
                        <option value="0" {{ $email->status == 0 && $email->id > 0 ? 'selected':'' }}>Inativo</option>
                    </select>
                    <!--end::Select2-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7">Defina o status do email.</div>
                    <!--end::Description-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Status-->
            <!--begin::Category & tags-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>Detalhes do e-mail</h2>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Input group-->
                    <!--begin::Label-->
                    <label class="required form-label">Tipo</label>
                    <!--end::Label-->
                    <select class="form-select mb-4" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="layout" name="layout">
                        <option></option>
                        <option value="1" {{ $email->type == '1' ? 'selected':'' }}>Layout 1</option>
                    </select>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Category & tags-->
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
                        <input type="text" name="title" class="form-control" value="{{ $email->title }}"/>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-10 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Assunto</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="subject" class="form-control" value="{{ $email->subject }}"/>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row">
                        <div class="col-12">
                            <!--begin::Label-->
                            <label class="form-label required">Contúdo</label>
                            <!--end::Label-->
                            <textarea id="content" class="form-control" rows="5" style="resize: none">{!! $email->content !!}</textarea>
                        </div>
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
    <script src="{{asset('ckeditor-page/build/ckeditor.js')}}"></script>
    {{-- DECLARAÇÃO DE VARIÁVEIS --}}
    <script>
        let editor;
        var submitButton = document.getElementById('btnSubmit');
    </script>
    {{-- SUBMIT FORMULÁRIO --}}
    <script>
        $('.saveEmail').on("submit", function(e){
            e.preventDefault();

            submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
            submitButton.disabled = true;

            var form = new FormData(this);
            @if($email->id > 0)
                form.append('_method', 'PUT');
            @endif
            form.append('content', editor.getData());

            $.ajax({
                url: '{{ $email->id > 0 ? route('admin.emails.update', $email->hash_id):route('admin.emails.store') }}',
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
                            confirmButtonText: "Ver e-mails",
                            cancelButtonText: "Novo e-mail",
                            customClass: {
                                confirmButton: "btn fw-bold btn-secondary",
                                cancelButton: "btn fw-bold btn-primary"
                            },
                            allowOutsideClick: false
                        }).then((function (t) {
                             if (t.value){
                                 window.location.href = '{{route('admin.emails.index')}}'
                             }else{
                                 window.location.href = '{{route('admin.emails.create')}}'
                             }
                        }))
                    }else{
                        Swal.fire('Erro', data.message, 'error');
                    }
                },
                error: function(data){
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;

                    Swal.fire('Erro', 'Falha ao {{ $email->id > 0 ? 'salvar':'editar' }} e-mail, tente novamente', 'error');
                }
            });
        });
    </script>
    {{-- DECLARAÇÃO: (CKEDITOR, STATUS) ONCHANGE: TYPE, SCRIPT: removeFile --}}
    <script>
        ClassicEditor.create(document.querySelector( '#content' ), {
            language: 'pt-br',
            removePlugins: ['Title'],
            placeholder: '',
        }).then( newEditor => {
            editor = newEditor;
        }).catch( error => {});

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
@endpush
