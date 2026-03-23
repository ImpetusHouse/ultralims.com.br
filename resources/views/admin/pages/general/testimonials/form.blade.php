@extends('admin.layout')

@push('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" integrity="sha512-zxBiDORGDEAYDdKLuYU9X/JaJo/DPzE42UubfBw9yg8Qvb2YRRIQ8v4KsGHOx2H1/+sdSXyXxLXv5r7tHc9ygg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .avatar {
            position: relative;
            height: 240px;
            width: 100%;
            background:#e8e8e8;
            border-radius: 8px;
        }

        .avatar img {
            max-width: 100%;
            max-height: 250px;
            border-radius: 8px;
        }

        .avatar .options {
            width: 30px;
            background: rgba(0,0,0,0.8);
            position: absolute;
            right: 5px;
            top: 5px;
            bottom: 5px;
            opacity: 0;
            z-index: -1;
            pointer-events: none;
            border-radius: 0 8px 8px 0;
            transition: all 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            align-items: center;
        }

        .avatar .options button {
            width: 20px;
            height: 20px;
            border: 0;
            background: transparent;
            color: #FFF;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease-in-out;
        }
        .avatar .options button.edit:hover {
            color: #5784c0;
            background: #5784c020;
        }
        .avatar .options button.trash:hover {
            color: #f44336;
            background: #f4433600;
        }

        .avatar .plus {
            width: 100%;
            position: absolute;
            height: 100%;
            font-size: 56px;
            background: rgba(0,0,0,0.8);
            color: #FFF;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            opacity: 0;
            z-index: -1;
            pointer-events: none;
        }

        .avatar:hover .options,
        .avatar:hover .plus {
            opacity: 1;
            z-index: 15;
            pointer-events: initial;
        }

        .modal_croppie {
            position: fixed;
            top: 0;left: 0;right: 0;bottom: 0;
            background: rgba(0,0,0,0.8);
            z-index: -5;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            pointer-events: none;
        }
        .modal_croppie.show {
            opacity: 1;
            pointer-events: initial;
            z-index: 99;
        }
        .modal_croppie .content {
            border-radius: 8px;
            padding: 4px;
        }
        .contentCroppie{
            background: #FFF;
        }

        [data-theme="dark"] .contentCroppie{
            background: #1e1e2d;
        }
    </style>
@endpush

@section('content')
    <!--begin::Form-->
    <form class="form d-flex flex-column flex-lg-row saveArticle">
        <!--begin::Aside column-->
        <div class="d-flex flex-column gap-7 gap-lg-10 w-100 w-lg-300px mb-7 me-lg-10" style="min-width: 300px !important;">
            <!--begin::Thumbnail settings-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2 class="required">Foto em destaque</h2>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body text-center pt-0">
                    <div class="avatar mb-3">

                        <input type="file" class="d-none" accept="image/*" name="foto" id="foto">

                        <div class="options" style="display: none">
                            <button type="button" class="edit changeImage" title="Editar">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button type="button" class="trash" title="Remover">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button type="button" class="cancel d-none" title="Cancelar">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <div class="plus">
                            <i class="fa fa-plus"></i>
                        </div>
                    </div>

                    <!--begin::Modal croppie-->
                    <div class="modal_croppie">
                        <div class="content contentCroppie">
                            <div class="cropper"></div>
                            <div class="d-flex mt-2 mb-2 align-items-center justify-content-end">
                                <button type="button" class="btn btn-sm btn-secondary cropped-image-cancel" style="margin-right: 8px">Cancelar</button>
                                <button type="button" class="btn btn-sm btn-primary cropped-image-send" style="margin-right: 6px">Recortar e salvar</button>
                            </div>
                        </div>
                    </div>
                    <!--end::Modal croppie-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7">Somente arquivos de imagem *.png, *.jpg e *.jpeg são aceitos. A imagem será convertida em *.webp.</div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Thumbnail settings-->
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
                        <option value="1" {{ $testimonial->status == 1 || $testimonial->id == null ? 'selected':'' }}>Ativo</option>
                        <option value="0" {{ $testimonial->status == 0 && $testimonial->id > 0 ? 'selected':'' }}>Inativo</option>
                    </select>
                    <!--end::Select2-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7">Defina o status do depoimento.</div>
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
                    <label class="form-label">Categorias</label>
                    <!--end::Label-->
                    <!--begin::Select2-->
                    <select class="form-select mb-2 categorySelect" name="categories[]" data-control="select2" data-placeholder="Selecione uma opção" multiple="multiple">
                        <option></option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}" {{ $testimonial->categories->pluck('id')->contains($category->id) ? 'selected':'' }}>{{$category->title}}</option>
                        @endforeach
                    </select>
                    <!--end::Select2-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7 mb-7">Adicionar depoimento a um sessão.</div>
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
                        Criar nova sessão
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
                        <label class="required form-label">Cliente</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="client" class="form-control mb-2" value="{{ $testimonial->client }}"/>
                        <!--end::Input-->
                        <!--begin::Description-->
                        <div class="text-muted fs-7">Um cliente é obrigatório.</div>
                        <!--end::Description-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="mb-10 fv-row">
                        <!--begin::Label-->
                        <label class="form-label">Cargo/Empresa</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="description_client" class="form-control mb-2" value="{{ $testimonial->description_client }}"/>
                        <!--end::Input-->
                        <!--begin::Description-->
                        <div class="text-muted fs-7">Um cargo/empresa é obrigatório.</div>
                        <!--end::Description-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row">
                        <!--begin::Label-->
                        <label class="required form-label">Depoimento</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <textarea type="text" name="description" class="form-control mb-2" rows="4" style="resize: none">{!! nl2br($testimonial->description) !!}</textarea>
                        <!--end::Input-->
                        <!--begin::Description-->
                        <div class="text-muted fs-7">Um depoimento é obrigatório.</div>
                        <!--end::Description-->
                    </div>
                    <!--end::Input group-->
                </div>
                <!--end::Card header-->
            </div>
            <!--end::General options-->
            <!--begin::General options-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>Vídeo</h2>
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Input group-->
                    <div class="mb-10 fv-row">
                        <!--begin::Label-->
                        <label class="form-label">Link (Youtube)</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="text" name="link" class="form-control mb-2" value="{{ $testimonial->link }}"/>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                    <!--begin::Input group-->
                    <div class="fv-row">
                        <!--begin::Label-->
                        <label class="form-label">Thumb</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="file" name="thumb" class="form-control mb-2"/>
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
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js" integrity="sha512-Gs+PsXsGkmr+15rqObPJbenQ2wB3qYvTHuJO6YJzPe/dTLvhy0fmae2BcnaozxDo5iaF8emzmCZWbQ1XXiX2Ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- DECLARAÇÃO DE VARIÁVEIS --}}
    <script>
        @if($testimonial->path != null)
            let user_profile = '{{ str_replace('public/', 'storage/', asset($testimonial->path)) }}';
            let user_profile_delete = true;
        @else
            let user_profile = null;
            let user_profile_delete = false;
        @endif

        // Avatar Scripts
        let $croppie = '';
        let $croppieModal = '.modal_croppie';
        let $croppieImage = '.cropper';

        // Source of image cropped, this is important to upload
        let $croppedImage = '';

        var submitButton = document.getElementById('btnSubmit');
    </script>
    {{-- SUBMIT FORMULÁRIO --}}
    <script>
        $('.saveArticle').on("submit", function(e){
            e.preventDefault();

            submitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
            submitButton.disabled = true;

            var form = new FormData(this);
            @if($testimonial->id > 0)
                form.append('_method', 'PUT');
            @endif
            if($croppedImage != ''){
                $('#foto').remove();
                form.append('imagem', $croppedImage);
            }else{
                form.append('imagem', user_profile)
            }
            $.ajax({
                url: '{{$testimonial->id > 0 ? route('admin.testimonials.update', $testimonial->hash_id):route('admin.testimonials.store')}}',
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
                            confirmButtonText: "Ver depoimentos",
                            cancelButtonText: "Novo depoimento",
                            customClass: {
                                confirmButton: "btn fw-bold btn-secondary",
                                cancelButton: "btn fw-bold btn-primary"
                            },
                            allowOutsideClick: false
                        }).then((function (t) {
                            if (t.value){
                                window.location.href = '{{route('admin.testimonials.index')}}'
                            }else{
                                window.location.href = '{{route('admin.testimonials.create')}}'
                            }
                        }))
                    }else{
                        Swal.fire('Erro', data.message, 'error');
                    }
                },
                error: function(data){
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;

                    Swal.fire('Falha!', 'Falha ao {{ $testimonial->id > 0 ? 'salvar':'editar' }} depoimento', 'error');
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
    {{-- SCRIPTS THUMB --}}
    <script>
        $('.plus, .changeImage').on('click', function(){
            if($(this).hasClass('plus')) $(this).parent().find('input#foto').click();
            else $(this).parent().parent().find('input#foto').click();
        });

        $('input#foto').on('change', function(){
            if($croppie != ''){
                _destroy_croppie();
            }

            $croppie = $($croppieModal).find($croppieImage).croppie({
                viewport: {
                    width: 250,
                    height: 250
                },
                boundary: {
                    width: 350,
                    height: 350
                }
            });

            var reader = new FileReader();
            reader.onload = function (e) {
                $croppie.croppie('bind', {
                    url: e.target.result
                })
            }
            reader.readAsDataURL(this.files[0]);

            $($croppieModal).addClass('show');
        });

        $('.cropped-image-send').on('click', function(e){
            e.preventDefault();
            $croppie.croppie('result', {
                type: 'canvas',
                size: 'viewport',
                quality: 1
            }).then(function (resp) {
                $croppedImage = resp;
                setImageView($croppedImage);
                _avatar_plus_remove();
                _avatar_option_show();
                _avatar_option_edit_show();
                _avatar_option_cancel_show();
                _avatar_option_trash_remove();
                _destroy_croppie();
            });
            $($croppieModal).removeClass('show');
        })

        $('.cropped-image-cancel, .avatar .options button.cancel').on('click', function(e){
            e.preventDefault();
            _destroy_croppie();
            $croppedImage = '';

            if(user_profile != null){
                setImageView(user_profile);
                _avatar_option_edit_show();
                _avatar_option_trash_show();
                _avatar_option_cancel_remove();
                _avatar_option_show();
            }else{
                removeImageView();
                _avatar_option_cancel_remove();
                _avatar_option_trash_remove();
                _avatar_option_edit_remove();
                _avatar_option_remove();
                _avatar_plus_show();
            }
            $($croppieModal).removeClass('show');
            remove_deleteImage();
        })

        $('.avatar .options button.trash').on('click', function(e){
            e.preventDefault();
            if(user_profile == null){
                return alertMessage('Erro!', 'error', 'Para excluir uma imagem, você precisa ter uma salva!');
            }
            user_profile = null;
            user_profile_delete = true;
            append_deleteImage();
            _avatar_option_edit_remove();
            _avatar_option_trash_remove();
            _avatar_option_cancel_remove();
            _avatar_option_remove();
            _avatar_plus_remove();
            _destroy_croppie();
            removeImageView();
            _avatar_plus_show();
        })

        let alertMessage = function(title, type, message){
            Swal.fire(title, message, type);
        }

        let clear_avatar = function(){
            user_profile = null;
            user_profile_delete = false;
            $croppedImage = '';
            $croppie = '';
            _destroy_croppie();
            removeImageView();
            _avatar_option_cancel_remove();
            _avatar_option_trash_remove();
            _avatar_option_edit_remove();
            _avatar_option_remove();
            _avatar_plus_show();
        }

        let _destroy_croppie = () => {
            if($croppie != ''){
                $croppie.croppie('destroy');
            }
        }

        let _avatar_plus_show = () => {
            $('.avatar .plus').removeClass('d-none').show();
        }

        let _avatar_plus_remove = () => {
            $('.avatar .plus').hide().addClass('d-none');
        }

        let _avatar_option_show = () => {
            $('.avatar .options').removeClass('d-none').show();
        }

        let _avatar_option_remove = () => {
            $('.avatar .options').hide().addClass('d-none');
        }

        let _avatar_option_edit_show = () => {
            $('.avatar .options button.edit').removeClass('d-none');
        }

        let _avatar_option_edit_remove = () => {
            $('.avatar .options button.edit').addClass('d-none');
        }

        let _avatar_option_trash_show = () => {
            $('.avatar .options button.trash').removeClass('d-none');
        }

        let _avatar_option_trash_remove = () => {
            $('.avatar .options button.trash').addClass('d-none');
        }

        let _avatar_option_cancel_show = () => {
            $('.avatar .options button.cancel').removeClass('d-none');
        }

        let _avatar_option_cancel_remove = () => {
            $('.avatar .options button.cancel').addClass('d-none');
        }

        let _has_avatar = () => {
            return $('.avatar img').length > 0;
        }

        let setImageView = (image) => {
            __imageAttribute = '<img src="'+image+'" alt="">';
            if(!_has_avatar()){
                $('.avatar').prepend(__imageAttribute);
            }else{
                $('.avatar img').attr('src', image);
            }
        }

        let removeImageView = () => {
            if(_has_avatar()){
                $('.avatar img').remove();
            }
        }

        function append_deleteImage(){
            $('.profileForm').append('<input type="hidden" name="delete_image" value="true">');
        }

        function remove_deleteImage(){
            $('.profileForm input[name="delete_image"]').remove();
        }

        @if($testimonial->path != null)
            setImageView(user_profile);
            _avatar_plus_remove();
            _avatar_option_show();
            _avatar_option_edit_show();
            _avatar_option_trash_show();
        @endif
        // End Avatar Scripts
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
                if(ModalCategoryTypeSend == 'store'){
                    $.ajax({
                        method: "POST",
                        url: "{{route('admin.testimonials.categories.store')}}",
                        data: {name: val},
                        success: function(rtn){
                            if(rtn.success){
                                $('#custom_category_save').val('');
                                function makeRow(){
                                    return "<tr data-id='category_"+rtn.id+"'><td>"+val+"</td><td style='text-align: right'><button type='button' class='btn btn-sm btn-icon btn-light-primary mr-5' onclick='changeCategory("+rtn.id+")'><i class='fas fa-pen m-0 p-0'></i></button><button type='button' class='btn btn-sm btn-light-danger btn-icon' onclick='deleteCategory("+rtn.id+")'><i class='fas fa-trash m-0 p-0'></i></button></td></tr>";
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
                        url: "{{route('admin.testimonials.categories.update', '_id_')}}".replace('_id_', ModalCategoryChange),
                        data: {name: val, id: ModalCategoryChange, _method: 'PUT'},
                        success: function(rtn){
                            if(rtn.success){
                                $('#custom_category_save').val('');
                                $('.loadItems').find('[data-id="category_'+ModalCategoryChange+'"]').find('td:first').html(val);
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
        });
        function deleteCategory(category_id){
            Swal.fire({
                text: "Tem certeza que deseja excluir essa categoria?",
                icon: "question",
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Sim, excluir!",
                cancelButtonText: "Não, cancelar",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-primary"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "DELETE",
                        url: "{{route('admin.testimonials.categories.destroy', '_id_')}}".replace('_id_', category_id),
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
                url: '{{route('admin.testimonials.categories.index')}}',
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
@endpush
