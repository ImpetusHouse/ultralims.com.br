@extends('admin.layout')

@push('head')
    <link rel="stylesheet" href="{{ asset('ckeditor/sample/custom.css') }}">
@endpush

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
                        <option value="1" {{ $faq->status == 1 || $faq->id == null ? 'selected':'' }}>Ativo</option>
                        <option value="0" {{ $faq->status == 0 && $faq->id > 0 ? 'selected':'' }}>Inativo</option>
                    </select>
                    <!--end::Select2-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7">Defina o status do módulo.</div>
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
                        <h2>Detalhes da publicação</h2>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Input group-->
                    <!--begin::Label-->
                    <label class="form-label">Categoria</label>
                    <!--end::Label-->
                    <!--begin::Select2-->
                    <select class="form-select mb-2 categorySelect" name="category_id" data-control="select2" data-placeholder="Selecione uma opção">
                        <option></option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}" {{ $category->id == $faq->category_id ? 'selected':'' }}>{{$category->title}}</option>
                        @endforeach
                    </select>
                    <!--end::Select2-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7 mb-7">Adicionar publicação a uma categoria.</div>
                    <!--end::Description-->
                    <!--end::Input group-->
                    <!--begin::Button-->
                    <a href="#" data-bs-toggle="modal" data-bs-target="#makeCategoriesModal" class="btn btn-light-primary btn-sm">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
                                <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        Criar nova categoria
                    </a>
                    <!--end::Button-->
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
                        <input type="text" name="title" class="form-control mb-2" placeholder="Título" value="{{ $faq->title }}"/>
                        <!--end::Input-->
                        <!--begin::Description-->
                        <div class="text-muted fs-7">Um título é obrigatório.</div>
                        <!--end::Description-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Conteúdo</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <textarea type="text" id="description" class="form-control" rows="4" style="resize: none">{!! nl2br($faq->description) !!}</textarea>
                        <!--end::Input-->
                        <!--begin::Description-->
                        <div class="text-muted fs-7 mt-2">Um conteúdo é obrigatório.</div>
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

    <div class="modal fade" id="makeCategoriesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Gerenciar categorias</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-5">
                        <div class="form-group col-8">
                            <label for="custom_category_save" class="form-label">Categoria</label>
                            <input type="text" class="form-control" id="title_category" data-id="store" name="category">
                        </div>
                        <div class="form-group col-2">
                            <label for="display_category" class="form-label">Exibir</label>
                            <select class="form-control" id="display_category" data-id="store" name="display">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                        <div class="form-group col-2">
                            <label for="display_category" class="form-label">&nbsp;</label>
                            <button class="btn btn-primary" id="btn_category"><i class="fas fa-save"></i></button>
                        </div>
                    </div>

                    <table class="table table-striped table_category">
                        <thead>
                        <th>Categoria</th>
                        <th>Exibir</th>
                        <th style="text-align: right"><i class="fas fa-cog"></i></th>
                        </thead>
                        <tbody class="loadItems">
                        @foreach ($categories as $category)
                            <tr data-id="category_{{$category->id}}">
                                <td>{{$category->title}}</td>
                                <td>{{$category->display == '1' ? 'Sim':'Não'}}</td>
                                <td style="text-align: right">
                                    <button type="button" class="btn btn-sm btn-icon mr-5 btn-light-primary" onclick="changeCategory({{$category->id}})"><i class="fas fa-pen m-0 p-0"></i></button>
                                    <button type="button" class="btn btn-sm btn-icon btn-light-danger" onclick="deleteCategory({{$category->id}})"><i class="fas fa-trash m-0 p-0"></i></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Concluído</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('ckeditor-page/build/ckeditor.js')}}"></script>
    {{-- DECLARAÇÃO DE VARIÁVEIS --}}
    <script>
        var submitButton = document.getElementById('btnSubmit');

        let editor;
        ClassicEditor.create(document.querySelector( '#description' ), {
            language: 'pt-br',
            removePlugins: ['Title'],
            placeholder: '',
            link: {
                addTargetToExternalLinks: true // Esta configuração adiciona target="_blank" a todos os links externos.
            }
        }).then( newEditor => {
            newEditor.model.document.on('change', () => {
                const data = editor.getData();
            });
            editor = newEditor;
        }).catch( error => {});
    </script>
    {{-- SUBMIT FORMULÁRIO --}}
    <script>
        $('.saveArticle').on("submit", function(e){
            e.preventDefault();

            submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
            submitButton.disabled = true;

            var form = new FormData(this);
            @if($faq->id > 0)
                form.append('_method', 'PUT');
            @endif
            form.append('description', editor.getData());
            $.ajax({
                url: '{{$faq->id > 0 ? route('admin.faq.update', $faq->hash_id):route('admin.faq.store')}}',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function(data){
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;

                    if(data.success == true){
                        Swal.fire({
                            text: data.message,
                            icon: "success",
                            showCancelButton: !0,
                            buttonsStyling: !1,
                            confirmButtonText: "Ver faqs",
                            cancelButtonText: "Novo faq",
                            customClass: {
                                confirmButton: "btn fw-bold btn-secondary",
                                cancelButton: "btn fw-bold btn-primary"
                            },
                            allowOutsideClick: false
                        }).then((function (t) {
                            if (t.value){
                                window.location.href = '{{route('admin.faq.index')}}'
                            }else{
                                window.location.href = '{{route('admin.faq.create')}}'
                            }
                        }))
                    }else{
                        Swal.fire('Erro', data.message, 'error');
                    }
                },
                error: function(data){
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;

                    Swal.fire('Falha!', 'Falha ao {{ $faq->id > 0 ? 'salvar':'editar' }} faq', 'error');
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
    {{-- SCRIPTS DE CATEGORIAS --}}
    <script>
        /**
         * Modal Category Scripts
         */
        var ModalCategoryTypeSend = 'store';
        var ModalCategoryChange = null;
        $('#btn_category').on('click', function(e){
            var val = $('#title_category').val();
            var display = $('#display_category').val();
            if(val.trim() != ''){
                if(ModalCategoryTypeSend == 'store'){
                    $.ajax({
                        method: "POST",
                        url: "{{route('admin.faq.categories.store')}}",
                        data: {
                            name: val,
                            display: display
                        },
                        success: function(rtn){
                            if(rtn.success){
                                $('#custom_category_save').val('');
                                function makeRow(){
                                    if (display == '1'){
                                        display = 'Sim';
                                    }else{
                                        display = 'Não';
                                    }
                                    return "<tr data-id='category_"+rtn.category.id+"'><td>"+val+"</td><td>"+display+"</td><td style='text-align: right'><button type='button' class='btn btn-sm btn-icon btn-light-primary mr-5' onclick='changeCategory("+rtn.category.id+")'><i class='fas fa-pen m-0 p-0'></i></button><button type='button' class='btn btn-sm btn-light-danger btn-icon' onclick='deleteCategory("+rtn.category.id+")'><i class='fas fa-trash m-0 p-0'></i></button></td></tr>";
                                }
                                $('.loadItems').append(makeRow());
                                fetchSelect2();
                            }else{
                                Swal.fire('Erro!', rtn.message, 'error');
                            }
                        },
                        error: function(){
                            Swal.fire('Erro!', 'Erro ao processar requisição.', 'error');
                        }
                    })
                }else if(ModalCategoryTypeSend == 'update'){
                    $.ajax({
                        type: "PUT",
                        url: "{{route('admin.faq.categories.update', '_id_')}}".replace('_id_', ModalCategoryChange),
                        data: {name: val, display: display, id: ModalCategoryChange, _method: 'PUT'},
                        success: function(rtn){
                            if(rtn.success){
                                $('#custom_category_save').val('');
                                if (display == '1'){
                                    display = 'Sim';
                                }else{
                                    display = 'Não';
                                }
                                $('.loadItems').find('[data-id="category_'+ModalCategoryChange+'"]').find('td:first').html(val);
                                $('.loadItems').find('[data-id="category_'+ModalCategoryChange+'"]').find('td:nth-child(2)').html(display);
                                ModalCategoryChange = null;
                                ModalCategoryTypeSend = 'store';
                                fetchSelect2();
                            }else{
                                Swal.fire('Erro!', rtn.message, 'error');
                            }
                        },
                        error: function(){
                            Swal.fire('Erro!', 'Erro ao processar requisição.', 'error');
                        }
                    })
                }
            }
            $('#title_category').val(null);
            $('#display_category').val(1).trigger('change');
        });
        function deleteCategory(category_id){
            if(1==1){
                Swal.fire({
                    title: 'Atenção!',
                    text: "Ao deletar esta categoria, todas os faq's relacionados ficarão sem essa categoria. Deseja continuar?",
                    icon: "question",
                    showCancelButton: !0,
                    buttonsStyling: !1,
                    confirmButtonText: "Sim, excluir!",
                    cancelButtonText: "Não, cancelar",
                    customClass: {
                        cancelButton: "btn fw-bold btn-primary",
                        confirmButton: "btn fw-bold btn-danger"
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "DELETE",
                            url: "{{route('admin.faq.categories.destroy', '_id_')}}".replace('_id_', category_id),
                            data: {id: category_id},
                            success: function(rtn){
                                if(rtn.success){
                                    if(rtn.reloaded){
                                        location.reload();
                                    }else{
                                        $('[data-id="category_'+category_id+'"]').fadeOut().remove();
                                        fetchSelect2()
                                    }
                                }else{
                                    Swal.fire('Erro!', retorno.error, 'error')
                                }
                            },
                            error: function(){
                                Swal.fire('Falha!', 'Erro ao processar requisição.', 'error');
                            }
                        })
                    }
                })
            }
        }
        function changeCategory(category_id){
            ModalCategoryChange = category_id;
            ModalCategoryTypeSend = 'update';
            var name = $('[data-id="category_'+category_id+'"]').find('td:first').html();
            var display = $('.loadItems').find('[data-id="category_'+ModalCategoryChange+'"]').find('td:nth-child(2)').html(display);
            if (display == 'Sim'){
                display = 1;
            }else{
                display = 0;
            }
            $('#title_category').val(name);
            $('#display_category').val(display);
        }
        function fetchSelect2(){
            var select2 = $('.categorySelect');
            $.ajax({
                type: 'GET',
                data: {ajaxJson: true},
                url: '{{route('admin.faq.categories.index')}}',
            }).then(function (data) {
                select2.html('').select2({data: [{id: '', text: ''}]});
                var returnArray = new Array();
                returnArray.push({id: '', text: 'Sem categoria'});
                $.each(data, function (key, value) {
                    returnArray.push({id: value.id, text: value.title});
                });
                select2.html('').select2({'data': returnArray});
            });
        }
        /**
         * END Modal Category Scripts
         */
    </script>
@endpush
