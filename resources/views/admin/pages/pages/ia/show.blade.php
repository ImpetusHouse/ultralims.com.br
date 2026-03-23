@extends('admin.layout')

@section('content')
    <!--begin::Form-->
    <form class="form d-flex flex-column flex-lg-row saveBlock">
        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <!--begin::General options-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <!--begin::Add product-->
                        <button type="button" class="btn btn-primary" id="btnIA">
                            <span class="indicator-label">Gerar</span>
                            <span class="indicator-progress">Aguarde...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                        <!--end::Add product-->
                    </div>
                    <!--end::Card toolbar-->
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
                        <input type="text" class="form-control mb-2" value="{{ $block->title.' '.$block->subtitle }}" readonly/>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-10 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Conteúdo</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <textarea type="text" id="description" class="form-control" rows="4" style="resize: none" readonly>{!! nl2br($block->content) !!}</textarea>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-10 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Prompt</label>
                        <!--end::Label-->
                        <select id="prompt" class="form-select" data-control="select2" data-placeholder="Selecione um prompt">
                            <option></option>
                            @foreach($prompts as $prompt)
                                <option value="{{ $prompt->prompt }}">{{ $prompt->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-10 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Palavra chave</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input id="keyword" type="text" class="form-control mb-2"/>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Conteúdo (IA)</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <textarea type="text" id="new_description" class="form-control" rows="4" style="resize: none" readonly></textarea>
                        <!--end::Input-->
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
    {{-- SUBMIT IA --}}
    <script>
        var iaButton = document.getElementById('btnIA');

        $('#btnIA').on('click', function (){
            iaButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
            iaButton.disabled = true;

            var form = new FormData();
            form.append('description', $('#description').val());
            form.append('keyword', $('#keyword').val());
            form.append('prompt', $('#prompt').val());

            $.ajax({
                url: '{{ route('admin.ia.generate') }}',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function(data){
                    iaButton.removeAttribute('data-kt-indicator');
                    iaButton.disabled = false;
                    if(data.success){
                        $('#new_description').val(data.response);
                    }else{
                        Swal.fire('Erro', data.message, 'error');
                    }
                },
                error: function(data){
                    iaButton.removeAttribute('data-kt-indicator');
                    iaButton.disabled = false;
                    Swal.fire('Erro', 'Falha ao gerar conteúdo, tente novamente', 'error');
                }
            });
        });
    </script>
    {{-- SUBMIT FORMULÁRIO --}}
    <script>
        var submitButton = document.getElementById('btnSubmit');

        $('.saveBlock').on("submit", function(e){
            e.preventDefault();

            submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
            submitButton.disabled = true;

            var form = new FormData(this);
            form.append('_method', 'PUT');
            form.append('description', $('#new_description').val());

            $.ajax({
                url: '{{ route('admin.ia.update', $block->id) }}',
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
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, continuar",
                            customClass: {confirmButton: "btn fw-bold btn-primary"}
                        }).then((function () {
                            location.href = '{{ route('admin.ia.index') }}';
                        }))
                    }else{
                        Swal.fire('Erro', data.message, 'error');
                    }
                },
                error: function(data){
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;

                    Swal.fire('Erro', 'Falha ao atualizar conteúdo, tente novamente', 'error');
                }
            });

        });
    </script>
@endpush
