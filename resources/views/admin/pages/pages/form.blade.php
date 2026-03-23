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
                    <div class="text-muted fs-7">Somente arquivos de imagem *.png, *.jpg e *.jpeg são aceitos. A imagem será convertida em *.webp.</div>
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
                        <option value="1" {{ $page->status || $page->id == 0 ? 'selected':'' }}>Publicado</option>
                        <option value="0" {{ !$page->status && $page->id > 0 ? 'selected':'' }}>Inativo</option>
                    </select>
                    <!--end::Select2-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7">Defina o status da página.</div>
                    <!--end::Description-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Status-->
            <!--begin::Status-->
            <div class="card card-flush py-4">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>Menu</h2>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Label-->
                    <label class="required form-label">Layout de menu</label>
                    <!--end::Label-->
                    <!--begin::Select2-->
                    <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="menu_id" name="menu_id">
                        <option></option>
                        @foreach($menus as $menu)
                            <option value="{{ $menu->id }}" {{ $page->menu_id == $menu->id ? 'selected':'' }}>{{ $menu->title }}</option>
                        @endforeach
                    </select>
                    <!--end::Select2-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7 mb-8">Defina o layout de menu da página.</div>
                    <!--end::Description-->
                    <!--begin::Label-->
                    <label class="required form-label">Itens de menu</label>
                    <!--end::Label-->
                    <!--begin::Select2-->
                    <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="group_id" name="group_id">
                        <option></option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}" {{ $page->group_id == $group->id ? 'selected':'' }}>{{ $group->title }}</option>
                        @endforeach
                    </select>
                    <!--end::Select2-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7">Defina os itens de menu da página.</div>
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
                        <h2>Detalhes da página</h2>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <!--begin::Input group-->
                    <!--begin::Label-->
                    <label class="form-label">Sessões</label>
                    <!--end::Label-->
                    <!--begin::Select2-->
                    <select class="form-select mb-2 categorySelect" name="categories_id[]" data-control="select2" data-placeholder="Selecione uma opção" multiple="multiple">
                        <option></option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}" {{ $page->categories->contains($category) ? 'selected':'' }}>{{$category->title}}</option>
                        @endforeach
                    </select>
                    <!--end::Select2-->
                    <!--begin::Description-->
                    <div class="text-muted fs-7 mb-7">Adicionar página a um sessão.</div>
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
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="required form-label">Título</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="title" class="form-control mb-2" placeholder="Título" value="{{ $page->title }}"/>
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">Um título é obrigatório.</div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10 row d-none">
                                    {{--<div class="col-6">
                                        <!--begin::Label-->
                                        <label class="required form-label">Item de menu</label>
                                        <!--end::Label-->
                                        <!--begin::Select2-->
                                        <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="menu" name="menu">
                                            <option></option>
                                            <option value="1" {{ $page->menu == '1' ? 'selected':'' }}>Sim</option>
                                            <option value="0" {{ $page->menu == '0' && $page->id > 0 ? 'selected':'' }}>Não</option>
                                        </select>
                                        <!--end::Select2-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">Defina se a página estará no menu.</div>
                                        <!--end::Description-->
                                    </div>--}}
                                    <div class="col-12">
                                        <!--begin::Label-->
                                        <label class="required form-label">Modo de layout</label>
                                        <!--end::Label-->
                                        <!--begin::Select2-->
                                        <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="mode" name="mode">
                                            <option></option>
                                            <option value="light" selected {{ $page->mode == 'light' ? 'selected':'' }}>Light</option>
                                            <option value="dark" {{ $page->mode == 'dark' ? 'selected':'' }}>Dark</option>
                                        </select>
                                        <!--end::Select2-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">Defina o modo da página.</div>
                                        <!--end::Description-->
                                    </div>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10 row d-none">
                                    <div class="col-6">
                                        <!--begin::Label-->
                                        <label class="required form-label">Exibir header</label>
                                        <!--end::Label-->
                                        <!--begin::Select2-->
                                        <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="header" name="header">
                                            <option></option>
                                            <option value="1" selected {{ $page->header ? 'selected':'' }}>Sim</option>
                                            <option value="0" {{ !$page->header && $page->id > 0 ? 'selected':'' }}>Não</option>
                                        </select>
                                        <!--end::Select2-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">Defina se a página exibirá o header.</div>
                                        <!--end::Description-->
                                    </div>
                                    <div class="col-6">
                                        <!--begin::Label-->
                                        <label class="required form-label">Exibir footer</label>
                                        <!--end::Label-->
                                        <!--begin::Select2-->
                                        <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="footer" name="footer">
                                            <option></option>
                                            <option value="1" selected {{ $page->footer ? 'selected':'' }}>Sim</option>
                                            <option value="0" {{ !$page->footer && $page->id > 0 ? 'selected':'' }}>Não</option>
                                        </select>
                                        <!--end::Select2-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">Defina se a página exibirá o footer.</div>
                                        <!--end::Description-->
                                    </div>
                                </div>
                                <!--end::Input group-->
                                <div class="row mb-10">
                                    <!--begin::Input group-->
                                    <div class="col-6">
                                        <!--begin::Label-->
                                        <label class="form-label">Prefixo</label>
                                        <!--end::Label-->
                                        <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção"
                                                multiple="multiple" id="slug_prefix" name="slug_prefix[]">
                                            @foreach($page->prefix_slug as $prefixSlug)
                                                <option value="{{ $prefixSlug->id }}" selected>{{ $prefixSlug->slug }}</option>
                                            @endforeach
                                            @foreach($prefixSlugs->whereNotIn('id', $page->prefix_slug->pluck('id')) as $prefixSlug)
                                                <option value="{{ $prefixSlug->id }}">{{ $prefixSlug->slug }}</option>
                                            @endforeach
                                        </select>
                                        <!--begin::Button-->
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#makePrefixModal" class="btn btn-light-primary btn-sm">
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr087.svg-->
                                            <span class="svg-icon svg-icon-2">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.5" x="11" y="18" width="12" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
                                                    <rect x="6" y="11" width="12" height="2" rx="1" fill="currentColor" />
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                            Criar novo prefixo
                                        </a>
                                        <!--end::Button-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="col-6">
                                        <!--begin::Label-->
                                        <label class="required form-label">Slug</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" name="slug" id="slug" class="form-control mb-2" placeholder="Slug" value="{{ $page->slug }}"/>
                                        <!--end::Input-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">
                                            @if($page->id > 0)
                                                <a href="#" target="_blank">
                                                    {{url('/')}}/<span id="preview-slug">{{ $page->slug }}</span>
                                                </a>
                                            @else
                                                {{url('/')}}/<span id="preview-slug">{{ $page->slug }}</span>
                                            @endif
                                        </div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--begin::Input group-->
                                <div class="fv-row">
                                    <!--begin::Label-->
                                    <label class="form-label required">Intranet?</label>
                                    <!--end::Label-->
                                    <select class="form-select" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="intranet" name="intranet">
                                        <option value="0" {{ !$page->intranet ? 'selected' : '' }}>Não</option>
                                        <option value="1" {{ $page->intranet ? 'selected' : '' }}>Sim</option>
                                    </select>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->
                        <!--begin::General options-->
                        <div class="card card-flush py-4">
                            <!--begin::Card body-->
                            <div class="card-body">
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="form-label">Página</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <!--begin::Select2-->
                                    <select class="form-select mb-2" name="pages_id[]" data-control="select2" data-placeholder="Selecione uma opção" multiple="multiple">
                                        <option></option>
                                        @foreach ($pages as $item)
                                            <option value="{{$item->id}}" {{ $page->pages_parents->contains($item) ? 'selected':'' }}>{{$item->title}}</option>
                                        @endforeach
                                    </select>
                                    <!--end::Select2-->
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">Pertence a alguma página?</div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="fv-row">
                                    <!--begin::Label-->
                                    <label class="form-label">SVG</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <!--begin::Select2-->
                                    {{-- <input type="file" class="form-control mb-2" name="svg"/> --}}
                                    <textarea class="form-control resize-none" name="svg" rows="4">{!! $page->svg !!}</textarea>
                                    <!--end::Select2-->
                                    <!--end::Input-->
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
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="required form-label">Meta title</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" class="form-control mb-2" name="seo_title" placeholder="Meta title" value="{{ $page->seo_title }}"/>
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">Defina um título de metatag. Recomendado ser palavras-chave simples e precisas.</div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label class="required form-label">Meta description</label>
                                    <!--end::Label-->
                                    <!--begin::Editor-->
                                    <textarea type="text" class="form-control mb-2" name="seo_description" placeholder="Escreva aqui..." rows="4" style="resize: none">{!! $page->seo_description !!}</textarea>
                                    <!--end::Editor-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">Defina uma descrição de metatag para a página para aumentar a classificação de SEO.</div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div>
                                    <!--begin::Label-->
                                    <label class="form-label">Meta keywords</label>
                                    <!--end::Label-->
                                    <!--begin::Editor-->
                                    <input name="seo_keywords" class="form-control mb-2" value="{{ $page->seo_keywords }}"/>
                                    <!--end::Editor-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7">Defina uma lista de palavras-chave com as quais a página está relacionada. Separe as palavras-chave adicionando uma
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
            </div>
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

    <div class="modal fade" id="makePrefixModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Gerenciar prefixos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-5">
                        <label for="prefix" class="form-label">Prefixo</label>
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-11 fv-row">
                                <input type="text" class="form-control" id="custom_prefix_save" data-id="store" name="prefix">
                                <span class="text-muted fs-8">Digite o prefixo e clique no botão para salvar.</span>
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-1 fv-row">
                                <button type="button" id="savePrefix" class="btn btn-primary btn-icon">
                                    <i class="fas fa-save"></i>
                                </button>
                            </div>
                            <!--end::Col-->
                        </div>
                    </div>
                    <table class="table table-striped table_prefix" id="tablePrefix">
                        <thead>
                        <th>Prefixo</th>
                        <th style="text-align: right"><i class="fas fa-cog"></i></th>
                        </thead>
                        <tbody class="loadPrefixItems">
                        @foreach ($prefixSlugs as $prefixSlug)
                            <tr data-id="prefix_{{$prefixSlug->id}}">
                                <td>{{$prefixSlug->slug}}</td>
                                <td style="text-align: right">
                                    <button type="button" class="btn btn-sm btn-icon mr-5 btn-light-primary" onclick="changePrefix({{$prefixSlug->id}})"><i class="fas fa-pen m-0 p-0"></i></button>
                                    <button type="button" class="btn btn-sm btn-icon btn-light-danger" onclick="deletePrefix({{$prefixSlug->id}})"><i class="fas fa-trash m-0 p-0"></i></button>
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
        let editor;

        let __autoFillTitle = true;

        @if($page->seo_image != null)
            let user_profile = '{{ asset(str_replace('public/', 'storage/', $page->seo_image)) }}';
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
            @if($page->id > 0)
                form.append('_method', 'PUT');
            @endif
            if($croppedImage != ''){
                $('#foto').remove();
                form.append('photo', $croppedImage);
            }else{
                @if($page->id == 0)
                    Swal.fire('Erro', 'A foto em destaque é obrigatória!', 'error');
                @endif
            }
            $.ajax({
                url: '{{ $page->id > 0 ? route('admin.pages.update', $page->hash_id):route('admin.pages.store') }}',
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
                            confirmButtonText: "Ver páginas",
                            cancelButtonText: "Nova página",
                            customClass: {
                                confirmButton: "btn fw-bold btn-secondary",
                                cancelButton: "btn fw-bold btn-primary"
                            },
                            allowOutsideClick: false
                        }).then((function (t) {
                             if (t.value){
                                 window.location.href = '{{route('admin.pages.index')}}'
                             }else{
                                 window.location.href = '{{route('admin.pages.create')}}'
                             }
                        }))
                    }else{
                        Swal.fire('Erro', data.message, 'error');
                    }
                },
                error: function(data){
                    submitButton.removeAttribute('data-kt-indicator');
                    submitButton.disabled = false;

                    Swal.fire('Falha!', 'Falha ao {{ $page->id > 0 ? 'salvar':'editar' }} página', 'error');
                }
            });

        });
    </script>
    {{-- ORDENAÇÃO DO SELECT DE PREFIX --}}
    <script>
        $('#slug_prefix').on("select2:select", function (evt) {
            var element = evt.params.data.element;
            var $element = $(element);

            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
        }).on('change', function (){
            changePreview($('#slug_prefix option:selected'), $('#slug').val());
        });

        function changePreview(prefix, slug){
            if ($('#slug_prefix').val().length > 0){
                $('#preview-slug').html(prefix.toArray().map(item => item.text).join().replaceAll(',', '/')+'/'+slug);
            }else{
                $('#preview-slug').html(slug);
            }
        }

        $('#slug_prefix').trigger('change');
    </script>
    {{-- DECLARAÇÃO: (STATUS), ONCHANGE: (SEO_TITLE, SEO_DESCRIPTION), SCRIPT: (generateSlug, strip) --}}
    <script>
        var statusIcon = document.getElementById("status_icon");
        var statusColors = ["bg-success", "bg-danger"];
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

        @if($page->id == 0)
            $('[name="title"]').on('change', function(){
                var title = $(this).val();
                var seo_title = $('[name="seo_title"]');
                if(__autoFillTitle) seo_title.val(title.substring(0, 65));
                generateSlug(title)
            });
        @endif

        $('[name="seo_title"]').on('change', function(){
            __autoFillTitle = false;
        });

        $('[name="slug"]').on('change', function(){
            generateSlug($(this).val());
        });

        function generateSlug(title){
            var $slug_input = $('[name="slug"]');
            $.ajax({
                url: '{{route('admin.pages.get.slug')}}',
                type: 'POST',
                data: {title: title},
                dataType: 'json',
                success: function(data){
                    if(data.success){
                        $slug_input.val(data.slug);
                        changePreview($('#slug_prefix option:selected'), data.slug);
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

        function strip(html)
        {
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
                        url: "{{route('admin.pages.categories.store')}}",
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
                        url: "{{route('admin.pages.categories.update', '_id_')}}".replace('_id_', ModalCategoryChange),
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
                    cancelButton: "btn fw-bold btn-primary",
                    confirmButton: "btn fw-bold btn-danger"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "DELETE",
                        url: "{{route('admin.pages.categories.destroy', '_id_')}}".replace('_id_', category_id),
                        data: {id: category_id},
                        success: function(data){
                            if(data.success){
                                $('[data-id="category_'+category_id+'"]').fadeOut().remove();
                                fetchSelect2()
                            }else{
                                Swal.fire('Erro!', data.message, 'error')
                            }
                        },
                        error: function(){
                            Swal.fire('Falha!', 'Erro ao processar requisição', 'error');
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
                url: '{{route('admin.pages.categories.index')}}',
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
    {{-- CRUD PREFIXO --}}
    <script>
        /**
         * Modal Category Scripts
         */
        var ModalPrefixTypeSend = 'store';
        var ModalPrefixChange = null;
        $('#savePrefix').on("click", function(e){
            var val = $('#custom_prefix_save').val();
            if(val.trim() != ''){
                if(ModalPrefixTypeSend == 'store'){
                    $.ajax({
                        method: "POST",
                        url: "{{route('admin.pages.prefixSlug.store')}}",
                        data: {name: val},
                        success: function(rtn){
                            if(rtn.success){
                                $('#custom_prefix_save').val('');
                                function makeRow(){
                                    return "<tr data-id='prefix_"+rtn.id+"'><td>"+val+"</td><td style='text-align: right'><button style='margin-right: 5px' type='button' class='btn btn-sm btn-icon btn-light-primary' onclick='changePrefix("+rtn.id+")'><i class='fas fa-pen m-0 p-0'></i></button><button type='button' class='btn btn-sm btn-light-danger btn-icon' onclick='deletePrefix("+rtn.id+")'><i class='fas fa-trash m-0 p-0'></i></button></td></tr>";
                                }
                                $('.loadPrefixItems').append(makeRow());
                                fetchSelect2Prefix();
                            }else{
                                Swal.fire('Erro!', rtn.message, 'error');
                            }
                        },
                        error: function(){
                            Swal.fire('Erro!', 'Erro ao processar requisição.', 'error');
                        }
                    })
                }else if(ModalPrefixTypeSend == 'update'){
                    $.ajax({
                        type: "PUT",
                        url: "{{route('admin.pages.prefixSlug.update', '_id_')}}".replace('_id_', ModalPrefixChange),
                        data: {name: val, id: ModalPrefixChange, _method: 'PUT'},
                        success: function(rtn){
                            if(rtn.success){
                                $('#custom_prefix_save').val('');
                                $('.loadPrefixItems').find('[data-id="prefix_'+ModalPrefixChange+'"]').find('td:first').html(val);
                                ModalPrefixChange = null;
                                ModalPrefixTypeSend = 'store';
                                fetchSelect2Prefix();
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
        function deletePrefix(prefix_id){
            Swal.fire({
                text: "Tem certeza que deseja excluir esse prefixo?",
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
                        url: "{{route('admin.pages.prefixSlug.destroy', '_id_')}}".replace('_id_', prefix_id),
                        data: {id: prefix_id},
                        success: function(rtn){
                            if(rtn.success){
                                if(rtn.reloaded){
                                    location.reload();
                                }else{
                                    $('[data-id="prefix_'+prefix_id+'"]').fadeOut().remove();
                                    fetchSelect2Prefix()
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
        function changePrefix(prefix_id){
            ModalPrefixChange = prefix_id;
            ModalPrefixTypeSend = 'update';
            var name = $('[data-id="prefix_'+prefix_id+'"]').find('td:first').html();
            $('#custom_prefix_save').val(name);
        }
        /**
         * END Modal Category Scripts
         */

        function fetchSelect2Prefix(){
            var select2 = $('#slug_prefix');
            $.ajax({
                type: 'GET',
                data: {ajaxJson: true},
                url: '{{route('admin.pages.prefixSlug.index')}}',
            }).then(function (data) {
                select2.html('').select2({data: [{id: '', text: ''}]});
                var returnArray = new Array();
                $.each(data, function (key, value) {
                    returnArray.push({id: value.id, text: value.slug});
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

        @if($page->seo_image != null)
            setImageView(user_profile);
            _avatar_plus_remove();
            _avatar_option_show();
            _avatar_option_edit_show();
            _avatar_option_trash_show();
        @endif
        // End Avatar Scripts
    </script>
@endpush
