@extends('admin.layout')

@push('head')
    <link rel="stylesheet" href="{{ asset('ckeditor/sample/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" integrity="sha512-zxBiDORGDEAYDdKLuYU9X/JaJo/DPzE42UubfBw9yg8Qvb2YRRIQ8v4KsGHOx2H1/+sdSXyXxLXv5r7tHc9ygg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .avatar {
            position: relative;
            height: 135px;
            width: 99%;
            background:#e8e8e8;
            border-radius: 8px;
        }

        .avatar img {
            max-width: 100%;
            max-height: 135px;
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
                    <div class="text-muted fs-7 mb-4">Somente arquivos de imagem *.png, *.jpg e *.jpeg são aceitos. A imagem será convertida em *.webp.</div>
                    <!--end::Description-->
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
                        <option value="published" {{ $article->status == 'published' ? 'selected':'' }}>Publicado</option>
                        <option value="draft" {{ $article->status == 'draft' || $article->id == 0 ? 'selected':'' }}>Rascunho</option>
                        <option value="scheduled" {{ $article->status == 'scheduled' ? 'selected':'' }}>Agendado</option>
                        <option value="inactive" {{ $article->status == 'inactive' ? 'selected':'' }}>Inativo</option>
                    </select>
                    <!--end::Select2-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7">Defina o status da publicação.</div>
                    <!--end::Description-->
                    <!--begin::Datepicker-->
                    <div class="d-none mt-10">
                        <label for="published_at" class="form-label">Selecione a data</label>
                        <input type="date" class="form-control" name="published_at" id="published_at" placeholder="Escolha data" value="{{ optional($article->published_at)->format('Y-m-d') }}" />
                    </div>
                    <!--end::Datepicker-->
                    <!--begin::Datepicker-->
                    <div class="d-none mt-10">
                        <label for="scheduled_for" class="form-label">Selecione a data e hora de publicação</label>
                        <input type="datetime-local" class="form-control" name="scheduled_for" id="scheduled_for" placeholder="Escolha data e hora" @if($article->scheduled_for != null && $article->status == 'scheduled') value="{{date('Y-m-d', strtotime($article->scheduled_for))}}T{{date('H:i', strtotime($article->scheduled_for))}}" @endif min="{{now()->format('Y-m-d')}}T{{now()->format('H:i')}}" />
                    </div>
                    <!--end::Datepicker-->
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
                            <option value="{{$category->id}}" {{ $article->categories->pluck('id')->contains($category->id) ? 'selected':'' }}>{{$category->title}}</option>
                        @endforeach
                    </select>
                    <!--end::Select2-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7 mb-2">Adicionar publicação a uma categoria.</div>
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
                    <br><br>
                    <!--begin::Label-->
                    <label class="form-label">Galerias</label>
                    <!--end::Label-->
                    <!--begin::Select2-->
                    <select class="form-select mb-2" name="galleries[]" data-control="select2" data-placeholder="Selecione uma opção" multiple="multiple">
                        <option></option>
                        @foreach ($galleries as $gallery)
                            <option value="{{$gallery->id}}" {{ $article->galleries->pluck('id')->contains($gallery->id) ? 'selected':'' }}>{{$gallery->title}}</option>
                        @endforeach
                    </select>
                    <!--end::Select2-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7">Adicionar publicação a uma galeria.</div>
                    <!--end::Description-->
                    <!--end::Input group-->
                    {{--
                    <!--begin::Input group-->
                    <!--begin::Label-->
                    <label class="form-label d-block">Tags</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input id="tags" name="tags" class="form-control mb-2" value="{!! implode(',', $article->tags->pluck('title')->toArray()) !!}" />
                    <!--end::Input-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7">Adicione tags a publicação.</div>
                    <!--end::Description-->
                    <!--end::Input group-->
                    --}}
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Category & tags-->
        </div>
        <!--end::Aside column-->
        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <!--begin:::Tabs-->
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2">
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#tab_geral">Geral</a>
                </li>
                <!--end:::Tab item-->
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#tab_seo">SEO</a>
                </li>
                <!--end:::Tab item-->
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#tab_historico">Histórico</a>
                </li>
                <!--end:::Tab item-->
            </ul>
            <!--end:::Tabs-->
            <!--begin::Tab content-->
            <div class="tab-content">
                <!--begin::Tab pane-->
                <div class="tab-pane fade show active" id="tab_geral" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
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
                                <div class="row mb-10">
                                    <div class="col-12">
                                        <!--begin::Label-->
                                        <label class="required form-label">Título</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" name="title" class="form-control mb-2" placeholder="Título" value="{{ $article->title }}"/>
                                        <!--end::Input-->
                                    </div>
                                    <div class="col-12">
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">Um título é obrigatório.</div>
                                        <!--end::Description-->
                                    </div>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10 row">
                                    <div class="col-12">
                                        <!--begin::Label-->
                                        <label class="required form-label">Conteúdo</label>
                                        <!--end::Label-->
                                        <textarea id="content" name="content" class="form-control mb-2" rows="5" style="resize: none">{!! $article->content !!}</textarea>
                                    </div>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row">
                                    <div class="col-12">
                                        <!--begin::Label-->
                                        <label class="required form-label">Slug</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" name="slug" class="form-control mb-2" placeholder="Slug" value="{{ $article->slug }}"/>
                                        <!--end::Input-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">
                                            @if($article->id > 0)
                                                <a href="{{ route('blog.show', $article->slug) }}" target="_blank">
                                                    {{url('/')}}/<span id="preview-type">blog/</span><span id="preview-slug">{{ $article->slug }}</span>
                                                </a>
                                            @else
                                                {{url('/')}}/<span id="preview-type">blog/</span><span id="preview-slug">{{ $article->slug }}</span>
                                            @endif
                                        </div>
                                        <!--end::Description-->
                                    </div>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->
                    </div>
                </div>
                <!--end::Tab pane-->
                <!--begin::Tab pane-->
                <div class="tab-pane fade" id="tab_seo" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">

                        <!--begin::Meta options-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>SEO</h2>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Input group-->
                                <div class="row mb-10">
                                    <div class="col-12">
                                        <!--begin::Label-->
                                        <label class="required form-label">Meta title</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" class="form-control mb-2" name="seo_title" placeholder="Meta title" value="{{ $article->seo_title }}"/>
                                        <!--end::Input-->
                                    </div>
                                    <div class="col-12">
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">Defina um título de metatag. Recomendado ser palavras-chave simples e precisas.</div>
                                        <!--end::Description-->
                                    </div>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="row mb-10">
                                    <div class="col-12">
                                        <!--begin::Label-->
                                        <label class="required form-label">Meta description</label>
                                        <!--end::Label-->
                                        <!--begin::Editor-->
                                        <textarea type="text" class="form-control mb-2" name="seo_description" placeholder="Escreva aqui..." rows="4" style="resize: none">{!! $article->seo_description !!}</textarea>
                                        <!--end::Editor-->
                                    </div>
                                    <div class="col-12">
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">Defina uma descrição de meta tag para a publicação para aumentar a classificação de SEO.</div>
                                        <!--end::Description-->
                                    </div>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div>
                                    <!--begin::Label-->
                                    <label class="form-label">Meta keywords</label>
                                    <!--end::Label-->
                                    <!--begin::Editor-->
                                    <input name="seo_keywords" class="form-control mb-2" value="{{ $article->seo_keywords }}"/>
                                    <!--end::Editor-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">Defina uma lista de palavras-chave com as quais a publicação está relacionada. Separe as palavras-chave adicionando uma
                                        <code>,</code>entre cada palavra-chave.</div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Meta options-->
                    </div>
                </div>
                <!--end::Tab pane-->
                <!--begin::Tab pane-->
                <div class="tab-pane fade" id="tab_historico" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">

                        <!--begin::Meta options-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Histórico</h2>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                @if($article->id > 0)
                                    <!--begin::Timeline-->
                                    <div class="timeline-label">
                                        <!--begin::Item-->
                                        <div class="timeline-item">
                                            <!--begin::Label-->
                                            <div class="timeline-label fw-bold text-gray-800 fs-6">{{ $article->updated_at->format('d/m/Y') == \Carbon\Carbon::today()->format('d/m/Y') ? $article->updated_at->format('H:i'):$article->updated_at->format('d/m') }}</div>
                                            <!--end::Label-->
                                            <!--begin::Badge-->
                                            <div class="timeline-badge">
                                                <i class="fa fa-genderless text-success fs-1"></i>
                                            </div>
                                            <!--end::Badge-->
                                            <!--begin::Text-->
                                            <div class="timeline-content d-flex">
                                                {!! $article->message !!}
                                            </div>
                                            <!--end::Text-->
                                        </div>
                                        <!--end::Item-->
                                        @php
                                            $oldArticle = $article;
                                            do{
                                                $oldArticle = $oldArticle->article;
                                                if ($oldArticle != null){
                                        @endphp
                                            <!--begin::Item-->
                                            <div class="timeline-item">
                                                <!--begin::Label-->
                                                <div class="timeline-label fw-bold text-gray-800 fs-6">{{ $oldArticle->deleted_at->format('d/m/Y') == \Carbon\Carbon::today()->format('d/m/Y') ? $oldArticle->deleted_at->format('H:i'):$oldArticle->deleted_at->format('d/m') }}</div>
                                                <!--end::Label-->
                                                <!--begin::Badge-->
                                                <div class="timeline-badge">
                                                    <i class="fa fa-genderless text-warning fs-1"></i>
                                                </div>
                                                <!--end::Badge-->
                                                <!--begin::Text-->
                                                <div class="timeline-content d-flex">
                                                    {!! $oldArticle->message !!}
                                                    <a href="#">
                                                        <i class="text-primary fw-bold fas fa-eye ps-3" title="Visualizar v-{{$oldArticle->version}}" data-bs-toggle="tooltip" data-bs-placement="bottom"></i>
                                                    </a>
                                                    <a href="{{ route('admin.articles.undo', [$article->hash_id, $oldArticle->id]) }}">
                                                        <i class="text-primary fw-bold fas fa-undo ps-3" title="Recuperar v-{{$oldArticle->version}}" data-bs-toggle="tooltip" data-bs-placement="bottom"></i>
                                                    </a>
                                                </div>
                                                <!--end::Text-->
                                            </div>
                                            <!--end::Item-->
                                        @php
                                                    if ($oldArticle->article == null){
                                                        $repeat = false;
                                                    }else{
                                                        $repeat = true;
                                                    }
                                                }else{
                                                    $repeat = false;
                                                }
                                            }while($repeat);
                                        @endphp
                                    </div>
                                    <!--end::Timeline-->
                                </div>
                                <!--end::Card body-->
                            @endif
                        </div>
                        <!--end::Meta options-->
                    </div>
                </div>
                <!--end::Tab pane-->
            </div>
            <!--end::Tab content-->
            <div class="d-flex justify-content-end mt-7">
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
    <script src="{{ asset('ckeditor/ckfinder/ckfinder.js') }}"></script>
    <script src="{{asset('ckeditor/build/ckeditor.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js" integrity="sha512-Gs+PsXsGkmr+15rqObPJbenQ2wB3qYvTHuJO6YJzPe/dTLvhy0fmae2BcnaozxDo5iaF8emzmCZWbQ1XXiX2Ig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- DECLARAÇÃO DE VARIÁVEIS --}}
    <script>
        let __autoFillTitle = true;
        let __autoFillDescription = true;

        let editor;

        @if($article->photo != null)
            let user_profile = '{{ asset((asset('') != 'http://127.0.0.1:8000/' ? 'public/':'').str_replace('public/', 'storage/', $article->photo)) }}';
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
            @if($article->id > 0)
                form.append('_method', 'PUT');
            @endif
            if($croppedImage != ''){
                $('#foto').remove();
                form.append('photo', $croppedImage);
            }else{
                @if($article->id == 0)
                    Swal.fire('Erro', 'A foto em destaque é obrigatória!', 'error');
                @endif
            }
            form.append('content', editor.getData());
            $.ajax({
                url: '{{ $article->id > 0 ? route('admin.articles.update', $article->hash_id):route('admin.articles.store') }}',
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
                            confirmButtonText: "Ver publicações",
                            cancelButtonText: "Nova publicação",
                            customClass: {
                                confirmButton: "btn fw-bold btn-secondary",
                                cancelButton: "btn fw-bold btn-primary"
                            },
                            allowOutsideClick: false
                        }).then((function (t) {
                             if (t.value){
                                 window.location.href = '{{route('admin.articles.index')}}'
                             }else{
                                 window.location.href = '{{route('admin.articles.create')}}'
                             }
                        }))
                    }else{
                        Swal.fire('Erro', data.message, 'error');
                    }
                },
                error: function(data){
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;

                    Swal.fire('Falha!', 'Falha ao {{ $article->id > 0 ? 'salvar':'editar' }} publicação', 'error');
                }
            });

        });
    </script>
    {{-- DECLARAÇÃO: (CKEDITOR, TAGS, STATUS), ONCHANGE: (SEO_TITLE, SEO_DESCRIPTION), SCRIPT: (generateSlug, strip) --}}
    <script>
        ClassicEditor.create(document.querySelector( '#content' ), {
            language: 'pt-br',
            removePlugins: ['Title', 'FontBackgroundColor', 'FontColor', 'FontFamily', 'FontSize', 'Autoformat'],
            placeholder: '',
            link: {
                addTargetToExternalLinks: true // Esta configuração adiciona target="_blank" a todos os links externos.
            },
            toolbar: {
                items: [
                    'undo', 'redo', 'heading', 'findAndReplace',
                    '|',
                    'bold', 'italic', 'underline', 'link', 'bulletedList', 'numberedList', 'horizontalLine',
                    '|',
                    'alignment', 'outdent', 'indent',
                    '|',
                    'CKFinder', 'mediaEmbed',
                    '|',
                    'insertTable', 'highlight', 'blockQuote'
                ]
            },
            image: {
                // Configure the available styles.
                styles: [
                    'alignLeft', 'alignCenter', 'alignRight'
                ],
                // Configure the available image resize options.
                resizeOptions: [
                    {
                        name: 'resizeImage:original',
                        label: 'Original',
                        value: null
                    },
                    {
                        name: 'resizeImage:25',
                        label: '25%',
                        value: '25'
                    },
                    {
                        name: 'resizeImage:50',
                        label: '50%',
                        value: '50'
                    },
                    {
                        name: 'resizeImage:75',
                        label: '75%',
                        value: '75'
                    }
                ],

                // You need to configure the image toolbar, too, so it shows the new style
                // buttons as well as the resize buttons.
                toolbar: [
                    'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight',
                    '|',
                    'resizeImage',
                    '|',
                    'imageTextAlternative'
                ]
            },
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells'
                ]
            },
        }).then( newEditor => {
            newEditor.model.document.on('change', () => {
                @if($article->id == 0)
                const data = editor.getData();
                    if(__autoFillDescription) $('[name="seo_description"]').val(strip(data).substring(0, 155));
                @endif
            });
            editor = newEditor;
        }).catch( error => {});

        var tags = document.querySelector("#tags");
        new Tagify(tags, {
            whitelist: {!! \App\Models\Articles\Tag::orderBy('title')->get()->pluck('title') !!},
            maxTags: 10,
            dropdown: {
                maxItems: 20,           // <- mixumum allowed rendered suggestions
                classname: "tagify__inline__suggestions", // <- custom classname for this dropdown, so it could be targeted
                enabled: 0,             // <- show suggestions on focus
                closeOnSelect: false    // <- do not hide the suggestions dropdown once an item has been selected
            }
        });

        var statusIcon = document.getElementById("status_icon");
        var statusColors = ["bg-success", "bg-warning", "bg-danger", "bg-primary"];
        const scheduledFor = document.getElementById("scheduled_for");
        const publishedAt = document.getElementById("published_at");
        $('#status').on('change', function (){
            switch (this.value) {
                case"published":
                    scheduledFor.parentNode.classList.add("d-none");
                    publishedAt.parentNode.classList.remove("d-none");
                    statusIcon.classList.remove(...statusColors);
                    statusIcon.classList.add("bg-success");
                    break;
                case"scheduled":
                    scheduledFor.parentNode.classList.remove("d-none");
                    publishedAt.parentNode.classList.add("d-none");
                    statusIcon.classList.remove(...statusColors);
                    statusIcon.classList.add("bg-warning");
                    break;
                case"inactive":
                    scheduledFor.parentNode.classList.add("d-none");
                    publishedAt.parentNode.classList.add("d-none");
                    statusIcon.classList.remove(...statusColors);
                    statusIcon.classList.add("bg-danger");
                    break;
                case"draft":
                    scheduledFor.parentNode.classList.add("d-none");
                    publishedAt.parentNode.classList.add("d-none");
                    statusIcon.classList.remove(...statusColors);
                    statusIcon.classList.add("bg-primary");
            }
        });

        $('#status').trigger('change');

        @if($article->id == 0)
            $('[name="title"]').on('change', function(){
                var title = $(this).val();
                var seo_title = $('[name="seo_title"]');
                if(__autoFillTitle) seo_title.val(title.substring(0, 65));
                generateSlug(title)
            });
        @endif

        $('[name="content"]').on('change', function(){
            var content = $(this).val();
            var seo_description = $('[name="seo_description"]');
            if(__autoFillDescription) seo_description.val(content.substring(0, 150));
        });

        $('[name="seo_title"]').on('change', function(){
            __autoFillTitle = false;
        });

        $('[name="seo_description"]').on('change', function(){
            __autoFillDescription = false;
        });

        $('[name="slug"]').on('change', function(){
            generateSlug($(this).val());
        });

        function generateSlug(title){
            var $slug_input = $('[name="slug"]');
            $.ajax({
                url: '{{route('admin.articles.get.slug')}}',
                type: 'POST',
                data: {title: title},
                dataType: 'json',
                success: function(data){
                    if(data.success == true){
                        $slug_input.val(data.slug);
                        $('#preview-slug').html(data.slug);
                        $('[name="slug"]').keyup();
                    }else{
                        Swal.fire('Erro', 'Este slug já existe, geramos um que não foi usado!', 'error').then(() => {
                            $slug_input.val(data.suggestion);
                        });
                    }
                },
                error: function(data){
                    Swal.fire('Falha!', 'Falha ao gerar slug', 'error');
                }
            });
        }

        function strip(html) {
            var tmp = document.implementation.createHTMLDocument("New").body;
            tmp.innerHTML = html;
            return tmp.textContent || tmp.innerText || "";
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
                if(ModalCategoryTypeSend == 'store'){
                    $.ajax({
                        method: "POST",
                        url: "{{route('admin.articles.categories.store')}}",
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
                        url: "{{route('admin.articles.categories.update', '_id_')}}".replace('_id_', ModalCategoryChange),
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
                icon: "warning",
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Sim, excluir!",
                cancelButtonText: "Não, cancelar",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "DELETE",
                        url: "{{route('admin.articles.categories.destroy', '_id_')}}".replace('_id_', category_id),
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
                url: '{{route('admin.articles.categories.index')}}',
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
                    width: 954,
                    height: 537
                },
                boundary: {
                    width: 1054,
                    height: 637
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

        @if($article->photo != null)
            setImageView(user_profile);
            _avatar_plus_remove();
            _avatar_option_show();
            _avatar_option_edit_show();
            _avatar_option_trash_show();
        @endif
        // End Avatar Scripts
    </script>
@endpush
