@extends('admin.layout')
@section('content')
    <!--begin::Form-->
    <form class="form d-flex flex-column flex-lg-row saveFont">
        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <!--begin::General options-->
            <div class="card card-flush py-4">
                <!--begin::Card body-->
                <div class="card-body">
                    <h2 class="mb-6">Geral</h2>
                    <!--begin::Input group-->
                    <div class="mb-18 row">
                        <div class="col-6">
                            <!--begin::Label-->
                            <label class="required form-label">Perfil</label>
                            <!--end::Label-->
                            <input type="text" id="fonts-profile" class="form-control" value="{{ $font->profile }}"/>
                        </div>
                        <div class="col-6">
                            <!--begin::Label-->
                            <label class="required form-label">Tipo</label>
                            <!--end::Label-->
                            <!--begin::Select2-->
                            <select id="fonts-type" class="form-select" data-control="select2" data-hide-search="true" data-placeholder="&nbsp;" data-kt-ecommerce-product-filter="status">
                                <option></option>
                                <option value="title" {{ $font->type == 'title' ? 'selected' : '' }}>Título</option>
                                <option value="description" {{ $font->type == 'description' ? 'selected' : '' }}>Descrição</option>
                                <option value="button" {{ $font->type == 'button' ? 'selected' : '' }}>Botão</option>
                            </select>
                            <!--end::Select2-->
                        </div>
                    </div>
                    <!--end::Input group-->
                    <h2 class="mb-6">Tamanhos</h2>
                    <!--begin::Input group-->
                    <div class="mb-18 row">
                        <div class="col-6">
                            <!--begin::Label-->
                            <label class="required form-label">Desktop</label>
                            <!--end::Label-->
                            <div class="input-group mb-2">
                                <input type="text" id="fonts-desktop" class="form-control" aria-describedby="px-desktop" value="{{ $font->desktop }}"/>
                                <span class="input-group-text" id="px-desktop">px</span>
                            </div>
                            <!--begin::Description-->
                            <div class="text-muted fs-7">Um tamanho de fonte para desktop é obrigatório.</div>
                            <!--end::Description-->
                        </div>
                        <div class="col-6">
                            <!--begin::Label-->
                            <label class="required form-label">Mobile</label>
                            <!--end::Label-->
                            <div class="input-group mb-2">
                                <input type="text" id="fonts-mobile" class="form-control" aria-describedby="px-mobile" value="{{ $font->mobile }}"/>
                                <span class="input-group-text" id="px-mobile">px</span>
                            </div>
                            <!--begin::Description-->
                            <div class="text-muted fs-7">Um tamanho de fonte para mobile é obrigatório.</div>
                            <!--end::Description-->
                        </div>
                    </div>
                    <!--end::Input group-->
                    <h2 class="mb-6">Configurações</h2>
                    <!--begin::Input group-->
                    <div class="row">
                        <div class="col-1">
                            <!--begin::Label-->
                            <label class="form-label">Negrito</label>
                            <!--end::Label-->
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" id="fonts-is_bold" {{ $font->is_bold ? 'checked' : '' }} />
                            </div>
                        </div>
                        <div class="col-4">
                            <!--begin::Label-->
                            <label class="required form-label">Espaçamento entre linhas</label>
                            <!--end::Label-->
                            <input type="text" id="fonts-line_spacing" class="form-control" value="{{ $font->line_spacing }}"/>
                        </div>
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Card body-->
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
        $('.saveFont').on("submit", function(e){
            e.preventDefault();

            submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple clicks
            submitButton.disabled = true;

            var form = new FormData(this);
            @if($font->id > 0)
            form.append('_method', 'PUT');
            @endif
            form.append('profile', $('#fonts-profile').val());
            form.append('desktop', $('#fonts-desktop').val());
            form.append('mobile', $('#fonts-mobile').val());
            form.append('is_bold', $('#fonts-is_bold').is(':checked') ? 1 : 0);
            form.append('line_spacing', $('#fonts-line_spacing').val());
            form.append('type', $('#fonts-type').val());

            $.ajax({
                url: '{{$font->id > 0 ? route('admin.settings.fonts.update', $font->hash_id) : route('admin.settings.fonts.store')}}',
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
                            confirmButtonText: "Configurações",
                            cancelButtonText: "Nova fonte",
                            customClass: {
                                confirmButton: "btn fw-bold btn-secondary",
                                cancelButton: "btn fw-bold btn-primary"
                            },
                            allowOutsideClick: false
                        }).then((function (t) {
                            if (t.value){
                                window.location.href = '{{route('admin.settings.index')}}'
                            }else{
                                window.location.href = '{{route('admin.settings.fonts.create')}}'
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
                    Swal.fire('Erro', data.message, 'error');
                }
            });
        });
    </script>
@endpush
