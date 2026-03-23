@extends('admin.layout')
@push('head')
    <link rel="stylesheet" href="{{ asset('ckeditor/sample/custom.css') }}">
@endpush
@section('content')
    <form id="customForm" method="POST" action="{{route('admin.tickets.configuration.pre-awnser.store')}}">
        <div class="card card-flush pt-3 mb-5 mb-lg-10">

            <div class="card-header">
                <!--begin::Card title-->
                <div class="card-title">
                    <h2 class="fw-bolder">Criar resposta</h2>
                </div>
                <!--begin::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">

                <!--begin::Custom fields-->
                <div class="d-flex flex-column mb-8 fv-row">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="title" class="form-label">Título</label>
                                <input type="text" id="title" name="title" class="form-control" placeholder="Título" required>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Custom fields-->

                <!--begin::Custom fields-->
                <div class="d-flex flex-column fv-row">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="content" class="form-label">Descrição</label>
                                <textarea name="awnser" id="content" class="form-control form-control-solid" cols="30"
                                          rows="10" data-dashlane-rid="a8dd4b5483e0a604"
                                          data-form-type="other" style="resize: none"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Custom fields-->

            </div>
            <!--end::Card body-->
        </div>

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
    </form>
@endsection

@push('scripts')
    <script src="{{asset('ckeditor-simple/build/ckeditor.js')}}"></script>
    <script>
        var submitButton = document.getElementById('btnSubmit');
        let editor;
        ClassicEditor.create(document.querySelector('#content'), {
            language: 'pt-br',
            removePlugins: ['Title'],
            placeholder: '',
        }).then(newEditor => {
            editor = newEditor;
        }).catch(error => {
            console.error(error);
        });

        $('#customForm').on('submit', this, function (e) {
            e.preventDefault();

            submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
            submitButton.disabled = true;

            if (editor.getData() == '' || editor.getData() == null) {
                Swal.fire('Atenção', 'Preencha o campo de descrição', 'warning');
                return;
            }

            let form = $(this);
            let data = new FormData(form[0]);
            data.append('awnser', editor.getData());
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: data,
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.success) {
                        if (typeof data.redirect != 'undefined') {
                            window.location.href = data.redirect;
                        } else if (typeof data.reload != 'undefined') {
                            window.location.reload();
                        } else {
                            Swal.fire('Sucesso', data.message, 'success');
                        }
                    } else {
                        Swal.fire('Erro', data.message, 'error');
                    }
                },
                error: function (data) {
                    Swal.fire('Erro', 'Ocorreu um erro ao processar a requisição', 'error');
                }

            }).done(function (data){
                submitButton.removeAttribute('data-kt-indicator');
                submitButton.disabled = false;
            });
        })

    </script>
@endpush
