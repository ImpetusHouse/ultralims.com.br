@extends('admin.layout')

@section('content')
    <!--begin::Form-->
    <form class="form d-flex flex-column flex-lg-row saveChat">
        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <!--begin::General options-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>Laboratórios</h2>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <div class="row">
                        @foreach($companies_chat as $company_chat)
                            <div class="col-3 mb-2 mt-2">
                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" name="companies_chat_id[]" type="checkbox" value="{{ $company_chat->id }}" id="{{ $company_chat->id }}" style="cursor: pointer" {!! $company_chat->status ? 'checked="checked"':'' !!}/>
                                    <label class="form-check-label ps-2" for="{{ $company_chat->id }}">{{ $company_chat->title }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
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
        $('.saveChat').on("submit", function(e){
            e.preventDefault();

            submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
            submitButton.disabled = true;

            var form = new FormData(this);
            $.ajax({
                url: '{{ route('admin.ultralims.chat.store') }}',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function(data){
                    if(data.success){
                        Swal.fire('Sucesso', data.message, 'success').then((function () {
                            window.location.reload();
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
                    Swal.fire('Erro', 'Falha ao salvar configuração, tente novamente', 'error');
                }
            });
        });
    </script>
@endpush
