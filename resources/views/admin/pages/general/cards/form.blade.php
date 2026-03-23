@extends('admin.layout')

@push('head')
    <link rel="stylesheet" href="{{ asset('ckeditor/sample/custom.css') }}">
@endpush

@section('content')
    <!--begin::Form-->
    <form class="form d-flex flex-column flex-lg-row saveCard">
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
                        <option value="1" {{ $card->status == 1 || $card->id == null ? 'selected':'' }}>Ativo</option>
                        <option value="0" {{ $card->status == 0 && $card->id > 0 ? 'selected':'' }}>Inativo</option>
                    </select>
                    <!--end::Select2-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7">Defina o status do card.</div>
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
                        <h2>Detalhes do card</h2>
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
                    <select class="form-select mb-4" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="type" name="type">
                        <option></option>
                        <option value="0" {{ $card->type == null ? 'selected':'' }}>Nenhum</option>
                        <option value="page" {{ $card->type == 'page' ? 'selected':'' }}>Página</option>
                        <option value="link" {{ $card->type == 'link' ? 'selected':'' }}>Link</option>
                        <option value="file" {{ $card->type == 'file' ? 'selected':'' }}>Arquivo</option>
                        <option value="modal" {{ $card->type == 'modal' ? 'selected':'' }}>Modal</option>
                    </select>
                    <!--begin::Label-->
                    <label class="form-label required">Categoria</label>
                    <!--end::Label-->
                    <!--begin::Select2-->
                    <select class="form-select mb-2 categorySelect" name="category_id" data-control="select2" data-placeholder="Selecione uma opção">
                        <option></option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}" {{ $card->category_id == $category->id ? 'selected':'' }}>{{$category->title}}</option>
                        @endforeach
                    </select>
                    <!--end::Select2-->
                    <!--end::Input group-->
                    <!--begin::Button-->
                    <a href="#" data-bs-toggle="modal" data-bs-target="#makeCategoriesModal" class="btn btn-light-primary btn-sm mt-2 mb-4">
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
                    <!--begin::Label-->
                    <label class="form-label">Subcategoria</label>
                    <!--end::Label-->
                    <!--begin::Select2-->
                    <select class="form-select mb-2 subcategorySelect" name="subcategory_id" data-control="select2" data-placeholder="Selecione uma opção">
                        <option></option>
                        @foreach ($subcategories as $subcategory)
                            <option value="{{$subcategory->id}}" {{ $card->subcategory_id == $subcategory->id ? 'selected':'' }}>{{$subcategory->title}} ({{ $subcategory->category->title }})</option>
                        @endforeach
                    </select>
                    <!--end::Select2-->
                    <!--end::Input group-->
                    <!--begin::Button-->
                    <a href="#" data-bs-toggle="modal" data-bs-target="#makeSubcategoriesModal" class="btn btn-light-primary btn-sm mt-2">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
                                <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        Criar nova subcategoria
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
                        <input type="text" name="title" class="form-control" value="{{ $card->title }}"/>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="row">
                        <div class="col-12">
                            <!--begin::Label-->
                            <label class="form-label">Descrição</label>
                            <!--end::Label-->
                            <textarea id="description" class="form-control" rows="5" style="resize: none">{!! $card->description !!}</textarea>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mt-10 row" id="div-page" {!! $card->type != 'page' ? 'style="display: none"':'' !!}>
                        <div class="col-12">
                            <!--begin::Label-->
                            <label class="required form-label">Página</label>
                            <!--end::Label-->
                            <select class="form-select" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" name="page_id">
                                <option></option>
                                @foreach($pages as $page)
                                    <option value="{{$page->id}}" {{ $card->page_id == $page->id ? 'selected':'' }}>{{ $page->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mt-10 row" id="div-link" {!! $card->type != 'link' ? 'style="display: none"':'' !!}>
                        <div class="col-12">
                            <!--begin::Label-->
                            <label class="required form-label">Link</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="link" class="form-control" value="{{ $card->link }}"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mt-10 row" id="div-file" {!! $card->type != 'file' ? 'style="display: none"':'' !!}>
                        <div class="col-12">
                            <!--begin::Label-->
                            <label class="form-label">Arquivo</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="file" name="file" class="form-control mb-2"/>
                            <!--end::Input-->
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mt-10 row" id="div-uploaded-file" {!! $card->type != 'file' || $card->file == null ? 'style="display: none"':'' !!}>
                        <div class="col-12">
                            <div class="col-md-2 position-relative p-3">
                                <svg width="100%" height="125px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22Z" fill="#009ef7"/>
                                    <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="#009ef7"/>
                                </svg>
                                {{ str_replace('public/cards/'.$card->id.'/', '', $card->file) }}
                                <div class="position-absolute m-3" style="right: 5px; top: 5px;">
                                    <button type="button" class="btn btn-sm btn-icon btn-light-danger" onclick="removeFile('{{$card->hash_id}}')"><i class="fa fa-times fs-1"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mt-10 row" id="div-modal-description" {!! $card->type != 'modal' ? 'style="display: none"':'' !!}>
                        <div class="col-12">
                            <!--begin::Label-->
                            <label class="required form-label">Descrição (Modal)</label>
                            <!--end::Label-->
                            <textarea id="modal_description" class="form-control" rows="5" style="resize: none">{!! $card->modal_description !!}</textarea>
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

    <div class="modal fade" id="makeCategoriesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Gerenciar categorias</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-5">
                        <label for="category" class="form-label">Categoria</label>
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-11 fv-row">
                                <input type="text" class="form-control" id="custom_category_save" data-id="store" name="category">
                                <span class="text-muted fs-8">Digite a categoria e clique no botão para salvar.</span>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-1 fv-row">
                                <button type="button" id="saveCategory" class="btn btn-primary btn-icon">
                                    <i class="fas fa-save"></i>
                                </button>
                            </div>
                            <!--end::Col-->
                        </div>
                    </div>
                    <table class="table table-striped table_category" id="tableCategories">
                        <thead>
                        <th>Categoria</th>
                        <th style="text-align: right"><i class="fas fa-cog"></i></th>
                        </thead>
                        <tbody class="loadItems">
                        @foreach ($categories as $category)
                            <tr data-id="category_{{$category->id}}">
                                <td>{{$category->title}}</td>
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

    <div class="modal fade" id="makeSubcategoriesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Gerenciar subcategorias</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-5">
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-6 fv-row">
                                <label for="custom_subcategory_save" class="form-label">Subcategoria</label>
                                <input type="text" class="form-control" id="custom_subcategory_save" data-id="store" name="subcategory">
                                <span class="text-muted fs-8">Digite a subcategoria, selecione a categoria e clique no botão para salvar.</span>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-5 fv-row">
                                <label for="custom_subcategory_category_save" class="form-label">Categoria</label>
                                <select class="form-select mb-2 categorySelect" id="custom_subcategory_category_save" data-control="select2" data-placeholder="Selecione uma opção">
                                    <option></option>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-1 fv-row">
                                <label for="subcategory" class="form-label">&nbsp;</label>
                                <button type="button" id="saveSubcategory" class="btn btn-primary btn-icon">
                                    <i class="fas fa-save"></i>
                                </button>
                            </div>
                            <!--end::Col-->
                        </div>
                    </div>
                    <table class="table table-striped table_subcategory" id="tableSubcategories">
                        <thead>
                        <th>Subcategoria</th>
                        <th>Categoria</th>
                        <th style="text-align: right"><i class="fas fa-cog"></i></th>
                        </thead>
                        <tbody class="loadItemsSubcategory">
                        @foreach ($subcategories as $subcategory)
                            <tr data-id="subcategory_{{$subcategory->id}}" data-category-id="{{ $subcategory->category_id }}">
                                <td>{{$subcategory->title}}</td>
                                <td class="td-subcategory-category">{{$subcategory->category->title}}</td>
                                <td style="text-align: right">
                                    <button type="button" class="btn btn-sm btn-icon mr-5 btn-light-primary" onclick="changeSubcategory({{$subcategory->id}})"><i class="fas fa-pen m-0 p-0"></i></button>
                                    <button type="button" class="btn btn-sm btn-icon btn-light-danger" onclick="deleteSubcategory({{$subcategory->id}})"><i class="fas fa-trash m-0 p-0"></i></button>
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
    <script src="{{asset('ckeditor-simple/build/ckeditor.js')}}"></script>
    {{-- DECLARAÇÃO DE VARIÁVEIS --}}
    <script>
        let editor, modalEditor;
        var submitButton = document.getElementById('btnSubmit');
    </script>
    {{-- SUBMIT FORMULÁRIO --}}
    <script>
        $('.saveCard').on("submit", function(e){
            e.preventDefault();

            submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
            submitButton.disabled = true;

            var form = new FormData(this);
            @if($card->id > 0)
                form.append('_method', 'PUT');
            @endif
            form.append('description', editor.getData());
            form.append('modal_description', modalEditor.getData());

            $.ajax({
                url: '{{ $card->id > 0 ? route('admin.cards.update', $card->hash_id):route('admin.cards.store') }}',
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
                            confirmButtonText: "Ver cards",
                            cancelButtonText: "Novo card",
                            customClass: {
                                confirmButton: "btn fw-bold btn-secondary",
                                cancelButton: "btn fw-bold btn-primary"
                            },
                            allowOutsideClick: false
                        }).then((function (t) {
                             if (t.value){
                                 window.location.href = '{{route('admin.cards.index')}}'
                             }else{
                                 window.location.href = '{{route('admin.cards.create')}}'
                             }
                        }))
                    }else{
                        Swal.fire('Erro', data.message, 'error');
                    }
                },
                error: function(data){
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;

                    Swal.fire('Erro', 'Falha ao {{ $card->id > 0 ? 'salvar':'editar' }} card, tente novamente', 'error');
                }
            });
        });
    </script>
    {{-- DECLARAÇÃO: (CKEDITOR, STATUS) ONCHANGE: TYPE, SCRIPT: removeFile --}}
    <script>
        ClassicEditor.create(document.querySelector( '#description' ), {
            language: 'pt-br',
            removePlugins: ['Title'],
            placeholder: '',
            link: {
                addTargetToExternalLinks: true // Esta configuração adiciona target="_blank" a todos os links externos.
            }
        }).then( newEditor => {
            editor = newEditor;
        }).catch( error => {});
        ClassicEditor.create(document.querySelector( '#modal_description' ), {
            language: 'pt-br',
            removePlugins: ['Title'],
            placeholder: '',
            link: {
                addTargetToExternalLinks: true // Esta configuração adiciona target="_blank" a todos os links externos.
            }
        }).then( newEditor => {
            modalEditor = newEditor;
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

        $('#type').on('change', function (){
           if ($(this).val() === 'page'){
               $('#div-page').fadeIn(150);
               $('#div-link').hide();
               $('#div-file').hide();
               $('#div-uploaded-file').hide();
               $('#div-modal-description').hide();
           }else if($(this).val() === 'link'){
               $('#div-page').hide();
               $('#div-link').fadeIn(150);
               $('#div-file').hide();
               $('#div-uploaded-file').hide();
               $('#div-modal-description').hide();
           }else if($(this).val() === 'file'){
               $('#div-page').hide();
               $('#div-link').hide();
               $('#div-file').fadeIn(150);
               @if($card->file != null)
                    $('#div-uploaded-file').fadeIn(150);
               @endif
               $('#div-modal-description').hide();
           }else if($(this).val() === 'modal'){
               $('#div-page').fadeOut(150);
               $('#div-link').fadeOut(150);
               $('#div-file').fadeOut(150);
               $('#div-uploaded-file').fadeOut(150);
               $('#div-modal-description').fadeIn(150);
           }else{
               $('#div-page').fadeOut(150);
               $('#div-link').fadeOut(150);
               $('#div-file').fadeOut(150);
               $('#div-uploaded-file').fadeOut(150);
               $('#div-modal-description').fadeOut(150);
            }
        });

        function removeFile(id){
            Swal.fire({
                text: "Tem certeza que deseja remover esse arquivo?",
                icon: "question",
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Sim, remover",
                cancelButtonText: "Não, cancelar",
                customClass: {
                    cancelButton: "btn fw-bold btn-primary",
                    confirmButton: "btn fw-bold btn-danger"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.cards.file', '_ID_') }}'.replace('_ID_', id),
                        type: 'GET',
                        processData: false,
                        contentType: false,
                        success: function(data){
                            if(data.success){
                                Swal.fire('Sucesso', data.message, 'success').then((function () {
                                    $('#div-uploaded-file').fadeOut(150);
                                }));
                            }else{
                                Swal.fire('Erro', data.message, 'error');
                            }
                        },
                        error: function(data){
                            Swal.fire('Erro', 'Falha ao remover arquivo, tente novamente', 'error');
                        }
                    });
                }
            });
        }
    </script>
    {{-- CRUD CATEGORIES --}}
    <script>
        /**
         * Modal Category Scripts
         */
        var ModalCategoryTypeSend = 'store';
        var ModalCategoryChange = null;
        $('#saveCategory').on("click", function(e){
            var val = $('#custom_category_save').val();
            if(val.trim() != ''){
                if(ModalCategoryTypeSend === 'store'){
                    $.ajax({
                        method: "POST",
                        url: "{{route('admin.cards.categories.store')}}",
                        data: {name: val},
                        success: function(rtn){
                            if(rtn.success){
                                $('#custom_category_save').val('');
                                function makeRow(){
                                    return "<tr data-id='category_"+rtn.id+"'><td>"+val+"</td><td style='text-align: right'><button type='button' class='btn btn-sm btn-icon btn-light-primary me-1' onclick='changeCategory("+rtn.id+")'><i class='fas fa-pen m-0 p-0'></i></button><button type='button' class='btn btn-sm btn-light-danger btn-icon' onclick='deleteCategory("+rtn.id+")'><i class='fas fa-trash m-0 p-0'></i></button></td></tr>";
                                }
                                $('.loadItems').append(makeRow());
                                fetchSelect2();
                            }else{
                                Swal.fire('Erro', rtn.message, 'error');
                            }
                        },
                        error: function(){
                            Swal.fire('Erro', 'Falha ao processar requisição, tente novamente', 'error');
                        }
                    })
                }else if(ModalCategoryTypeSend === 'update'){
                    $.ajax({
                        type: "PUT",
                        url: "{{route('admin.cards.categories.update', '_id_')}}".replace('_id_', ModalCategoryChange),
                        data: {name: val, id: ModalCategoryChange, _method: 'PUT'},
                        success: function(rtn){
                            if(rtn.success){
                                $('#custom_category_save').val('');
                                $('.loadItems').find('[data-id="category_'+ModalCategoryChange+'"]').find('td:first').html(val);
                                ModalCategoryChange = null;
                                ModalCategoryTypeSend = 'store';
                                fetchSelect2();
                            }else{
                                Swal.fire('Erro', rtn.message, 'error');
                            }
                        },
                        error: function(){
                            Swal.fire('Erro', 'Falha ao processar requisição, tente novamente', 'error');
                        }
                    })
                }
            }
        });
        function deleteCategory(category_id){
            Swal.fire({
                text: "Tem certeza que deseja excluir essa categoria?",
                icon: "question",
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Sim, excluir",
                cancelButtonText: "Não, cancelar",
                customClass: {
                    cancelButton: "btn fw-bold btn-primary",
                    confirmButton: "btn fw-bold btn-danger"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "DELETE",
                        url: "{{route('admin.cards.categories.destroy', '_id_')}}".replace('_id_', category_id),
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
                                Swal.fire('Erro', retorno.error, 'error')
                            }
                        },
                        error: function(){
                            Swal.fire('Erro', 'Falha ao processar requisição, tente novamente', 'error');
                        }
                    })
                }
            })
        }
        function changeCategory(category_id){
            ModalCategoryChange = category_id;
            ModalCategoryTypeSend = 'update';
            var name = $('[data-id="category_'+category_id+'"]').find('td:first').html();
            $('#custom_category_save').val(name);
        }
        /**
         * END Modal Category Scripts
         */
        function fetchSelect2(){
            var select2 = $('.categorySelect');
            $.ajax({
                type: 'GET',
                data: {ajaxJson: true},
                url: '{{route('admin.cards.categories.index')}}',
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
    </script>
    {{-- CRUD SUBCATEGORIES --}}
    <script>
        $('#makeSubcategoriesModal').on('show.bs.modal', function (e) {
            $('#custom_subcategory_category_save').select2({
                dropdownParent: $('#makeSubcategoriesModal .modal-body') // Ajuste o seletor conforme necessário
            });
        })
        /**
         * Modal Category Scripts
         */
        var ModalSubcategoryTypeSend = 'store';
        var ModalSubcategoryChange = null;
        $('#saveSubcategory').on("click", function(e){
            var subcategory = $('#custom_subcategory_save').val();
            var category = $('#custom_subcategory_category_save option:selected').text().trim();
            var category_id = $('#custom_subcategory_category_save').val();
            if(subcategory.trim() != ''){
                if(ModalSubcategoryTypeSend === 'store'){
                    $.ajax({
                        method: "POST",
                        url: "{{route('admin.cards.subcategories.store')}}",
                        data: {
                            name: subcategory,
                            category_id: category_id
                        },
                        success: function(rtn){
                            if(rtn.success){
                                $('#custom_subcategory_save').val(null).focus();
                                $('#custom_subcategory_category_save').val(null).trigger('change');
                                function makeRow(){
                                    return `<tr data-id="subcategory_${rtn.id}" data-category-id="${category_id}">
                                                <td>${subcategory}</td>
                                                <td class="td-subcategory-category">${category}</td>
                                                <td style="text-align: right">
                                                    <button type="button" class="btn btn-sm btn-icon btn-light-primary me-1" onclick="changeSubcategory(${rtn.id})">
                                                        <i class="fas fa-pen m-0 p-0"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-light-danger btn-icon" onclick="deleteSubcategory(${rtn.id})">
                                                        <i class="fas fa-trash m-0 p-0"></i>
                                                    </button>
                                                </td>
                                            </tr>`;
                                }
                                $('.loadItemsSubcategory').append(makeRow());
                                fetchSelect2Subcategory();
                            }else{
                                Swal.fire('Erro', rtn.message, 'error');
                            }
                        },
                        error: function(){
                            Swal.fire('Erro', 'Falha ao processar requisição, tente novamente', 'error');
                        }
                    })
                }else if(ModalSubcategoryTypeSend === 'update'){
                    $.ajax({
                        type: "PUT",
                        url: "{{route('admin.cards.subcategories.update', '_id_')}}".replace('_id_', ModalSubcategoryChange),
                        data: {
                            name: subcategory,
                            category_id: category_id,
                            id: ModalSubcategoryChange,
                            _method: 'PUT'
                        },
                        success: function(rtn){
                            if(rtn.success){
                                $('#custom_subcategory_save').val(null).focus();
                                $('#custom_subcategory_category_save').val(null).trigger('change');
                                $('.loadItemsSubcategory').find('[data-id="subcategory_'+ModalSubcategoryChange+'"]').find('td:first').html(subcategory);
                                $('.loadItemsSubcategory').find('[data-id="subcategory_'+ModalSubcategoryChange+'"]').find('.td-subcategory-category').html(category);
                                $('.loadItemsSubcategory').find('[data-id="subcategory_'+ModalSubcategoryChange+'"]').attr('data-category-id', category_id);
                                ModalSubcategoryChange = null;
                                ModalSubcategoryTypeSend = 'store';
                                fetchSelect2Subcategory();
                            }else{
                                Swal.fire('Erro', rtn.message, 'error');
                            }
                        },
                        error: function(){
                            Swal.fire('Erro', 'Falha ao processar requisição, tente novamente', 'error');
                        }
                    })
                }
            }
        });
        function deleteSubcategory(subcategory_id){
            Swal.fire({
                text: "Tem certeza que deseja excluir essa subcategoria?",
                icon: "question",
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Sim, excluir",
                cancelButtonText: "Não, cancelar",
                customClass: {
                    cancelButton: "btn fw-bold btn-primary",
                    confirmButton: "btn fw-bold btn-danger"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "DELETE",
                        url: "{{route('admin.cards.subcategories.destroy', '_id_')}}".replace('_id_', subcategory_id),
                        data: {id: subcategory_id},
                        success: function(rtn){
                            if(rtn.success){
                                $('[data-id="subcategory_'+subcategory_id+'"]').fadeOut().remove();
                                fetchSelect2Subcategory()
                            }else{
                                Swal.fire('Erro', rtn.message, 'error')
                            }
                        },
                        error: function(){
                            Swal.fire('Erro', 'Falha ao processar requisição, tente novamente', 'error');
                        }
                    })
                }
            })
        }
        function changeSubcategory(subcategory_id){
            ModalSubcategoryChange = subcategory_id;
            ModalSubcategoryTypeSend = 'update';
            var name = $('[data-id="subcategory_'+subcategory_id+'"]').find('td:first').html();
            $('#custom_subcategory_save').val(name);
            $('#custom_subcategory_category_save').val($('[data-id="subcategory_'+subcategory_id+'"]').attr('data-category-id')).trigger('change');
        }
        /**
         * END Modal Category Scripts
         */
        function fetchSelect2Subcategory(){
            var select2 = $('.subcategorySelect');
            $.ajax({
                type: 'GET',
                data: {ajaxJson: true},
                url: '{{route('admin.cards.subcategories.index')}}',
            }).then(function (data) {
                select2.html('').select2({data: [{id: '', text: ''}]});
                var returnArray = new Array();
                returnArray.push({id: '', text: 'Sem categoria'});
                $.each(data, function (key, value) {
                    returnArray.push({
                        id: value.id,
                        text: value.title + ' (' + value.category_title + ')',
                    });
                });
                select2.html('').select2({'data': returnArray});
            });
        }
    </script>
@endpush
