@push('head')
    <link rel="stylesheet" href="{{ asset('ckeditor/sample/custom.css') }}">
    <style>
        .card .card-body{
            padding: 2rem 2.25rem !important;
        }
    </style>
@endpush

<form class="customForm" action="{{route('admin.tickets.configuration.auto-message.update')}}" method="POST">
    <div class="card card-flush mb-5 mb-lg-10">
        <div class="card-body">
            <div class="row">
                <div class="col-12 mb-10">
                    <div class="form-group">
                        <label class="form-label">Quando o cliente finalizar o atendimento</label>
                        <textarea name="autoMessage[ticket_end_client]" id="editor_2" class="form-control" cols="30" rows="10" style="resize: none">{!! $autoMessage['ticket_end_client'] ?? '' !!}</textarea>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">Quando o atendente finalizar o atendimento</label>
                        <textarea name="autoMessage[ticket_end_operator]" id="editor_3" class="form-control" cols="30" rows="10" style="resize: none">{!! $autoMessage['ticket_end_operator'] ?? '' !!}</textarea>
                    </div>
                </div>
            </div>
        </div>
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

@push('scripts')
<script src="{{asset('ckeditor-simple/build/ckeditor.js')}}"></script>
<script>
    var submitButton = document.getElementById('btnSubmit');

    let editor_2;
    let editor_3;

    ClassicEditor.create(document.querySelector( '#editor_2' ), {
        language: 'pt-br',
        removePlugins: ['Title'],
        placeholder: '',
        language: 'pt-br',
    }).then( newEditor => {
        editor_2 = newEditor;
    }).catch( error => {
        console.error( error );
    });

    ClassicEditor.create(document.querySelector( '#editor_3' ), {
        language: 'pt-br',
        removePlugins: ['Title'],
        placeholder: '',
        language: 'pt-br',
    }).then( newEditor => {
        editor_3 = newEditor;
    }).catch( error => {
        console.error( error );
    });

    $('.customForm').on('submit', this, function(e){
        e.preventDefault();

        submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
        submitButton.disabled = true;

        let form = $(this);
        let data = new FormData(form[0]);


        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: data,
            processData: false,
            contentType: false,
            success: function(data){
                if(data.success){
                    if(typeof data.redirect != 'undefined'){
                        window.location.href = data.redirect;
                    }else if(typeof data.reload != 'undefined'){
                        window.location.reload();
                    }else {
                        Swal.fire('Sucesso!', data.message, 'success');
                    }
                }else{
                    Swal.fire('Erro', data.message, 'error');
                }
            },
            error: function(data){
                Swal.fire('Erro', 'Ocorreu um erro ao processar a requisição', 'error');
            }

        }).done(function (data){
            submitButton.removeAttribute('data-kt-indicator');
            submitButton.disabled = false;
        });
    })

</script>
@endpush
