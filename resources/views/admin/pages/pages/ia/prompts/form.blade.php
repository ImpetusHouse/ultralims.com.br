@extends('admin.layout')

@section('content')
    <!--begin::Form-->
    <form class="form d-flex flex-column flex-lg-row savePrompt">
        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <!--begin::General options-->
            <div class="card card-flush py-4">
                <!--begin::Card body-->
                <div class="card-body">
                    <!--begin::Input group-->
                    <div class="mb-10 fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Título</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input name="title" type="text" class="form-control mb-2" value="{{ $prompt->title }}"/>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Prompt</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <textarea type="text" name="prompt" class="form-control" rows="6" style="resize: none">{!! $prompt->prompt !!}</textarea>
                        <!--end::Input-->
                        <!--begin::Description-->
                        <div class="text-muted fs-7">
                            _TEXT_ = Conteúdo do bloco<br>
                            _KEYWORD_ = Palavra chave<br>
                            _WORDCOUNT_ = Quantidade de caracteres do conteúdo do bloco
                        </div>
                        <!--end::Description-->
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
    {{-- SUBMIT FORMULÁRIO --}}
    <script>
        var submitButton = document.getElementById('btnSubmit');

        $('.savePrompt').on("submit", function(e){
            e.preventDefault();

            submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
            submitButton.disabled = true;

            var form = new FormData(this);
            @if($prompt->id > 0)
                form.append('_method', 'PUT');
            @endif

            $.ajax({
                url: '{{$prompt->id > 0 ? route('admin.ia.prompts.update', $prompt->hash_id):route('admin.ia.prompts.store')}}',
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
                            location.href = '{{ route('admin.ia.prompts.index') }}';
                        }))
                    }else{
                        Swal.fire('Erro', data.message, 'error');
                    }
                },
                error: function(data){
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;

                    Swal.fire('Falha!', 'Falha ao {{ $prompt->id > 0 ? 'salvar':'editar' }} prompt', 'error');
                }
            });

        });
    </script>
@endpush
