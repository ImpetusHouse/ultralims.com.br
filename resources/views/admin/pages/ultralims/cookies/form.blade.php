@extends('admin.layout')

@section('content')
    <!--begin::Form-->
    <form class="form d-flex flex-column flex-lg-row saveBanner">
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
                        <option value="1" {{ $cookie->status == 1 || $cookie->id == null ? 'selected':'' }}>Ativo</option>
                        <option value="0" {{ $cookie->status == 0 && $cookie->id > 0 ? 'selected':'' }}>Inativo</option>
                    </select>
                    <!--end::Select2-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7">Defina o status do cookie.</div>
                    <!--end::Description-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Status-->
            <!--begin::Início/Fim-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>Datas</h2>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Input group-->
                    <div class="mb-10 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Início</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="date" class="form-control mb-2" id="start" name="start" value="{{ optional($cookie->start)->format('Y-m-d') }}"/>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Final</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="date" class="form-control mb-2" id="end" name="end" value="{{ optional($cookie->end)->format('Y-m-d') }}"/>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Início/Fim-->
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
                        <input type="text" name="title" class="form-control" value="{{ $cookie->title }}"/>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row mb-10">
                        <!--begin::Label-->
                        <label class="form-label required">Conteúdo</label>
                        <!--end::Label-->
                        <textarea id="content" name="content" class="form-control mb-2" rows="5" style="resize: none">{!! $cookie->content !!}</textarea>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row">
                        <!--begin::Label-->
                        <label class="form-label required">Prioridade</label>
                        <!--end::Label-->
                        <!--begin::Select2-->
                        <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="priority" name="priority">
                            <option></option>
                            <option value="high" {{ $cookie->priority == 'high' ? 'selected':'' }}>Alto</option>
                            <option value="medium" {{ $cookie->priority == 'medium' ? 'selected':'' }}>Médio</option>
                            <option value="low" {{ $cookie->priority == 'low' ? 'selected':'' }}>Baixo</option>
                        </select>
                        <!--end::Select2-->
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
        $('.saveBanner').on("submit", function(e){
            e.preventDefault();

            submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
            submitButton.disabled = true;

            var form = new FormData(this);
            @if($cookie->id > 0)
                form.append('_method', 'PUT');
            @endif
            $.ajax({
                url: '{{$cookie->id > 0 ? route('admin.ultralims.cookies.update', $cookie->hash_id):route('admin.ultralims.cookies.store')}}',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function(data){
                    if(data.success){
                        Swal.fire({
                            text: data.message,
                            icon: "success",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Ver cookies",
                            cancelButtonText: "Novo cookie",
                            customClass: {
                                confirmButton: "btn fw-bold btn-secondary",
                                cancelButton: "btn fw-bold btn-primary"
                            },
                            allowOutsideClick: false
                        }).then((function (t) {
                            if (t.value){
                                window.location.href = '{{route('admin.ultralims.cookies.index')}}'
                            }else{
                                window.location.href = '{{route('admin.ultralims.cookies.create')}}'
                            }
                        }))
                    }else{
                        Swal.fire('Erro', data.message, 'error');
                        submitButton.removeAttribute('data-kt-indicator');
                        submitButton.disabled = false;
                    }
                },
                error: function(data){
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;
                    Swal.fire('Erro', 'Falha ao {{ $cookie->id > 0 ? 'salvar':'editar' }} cookie, tente novamente', 'error');
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
@endpush
