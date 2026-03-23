@php
    $block_quantity = 73;
@endphp
@extends('admin.layout')
@push('head')
    <link rel="stylesheet" href="{{ asset('ckeditor/sample/custom.css') }}">
    <style>
        .color-input-box {
            position: relative !important;
        }

        [data-theme="dark"] .color-select-box {
            background: #2b2b40 !important;
        }

        .color-select-box {
            position: absolute;
            top: -2px;
            left: 30px;
            background: #fff;
            z-index: 99999 !important;
            width: 150px;
            min-height: 50px;
            padding: 15px;
            border-radius: 0px 10px 10px 10px;
            display: none;
            gap: 1.5rem;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        .color-box {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-width: 2px !important;
            border-style: solid;
            border-color: #383855;
            border-radius: 5px;
            height: 35px;
            cursor: pointer;
        }

        .color-box p {
            margin-bottom: 0 !important;
            margin-top: 0 !important;
            font-size: 1.075rem;
            padding: 6px;
        }

        .color-select {
            width: 34px;
            height: 35px;
            border-radius: 5px;
            border-width: 2px !important;
            border-right: 0px !important;
            border-style: solid;
            border-color: #383855 !important;
        }

        .colors-parent-box {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 2rem; /* 24px */
        }

        .colors-box {
            display: none;
            position: absolute;
            background: #fff;
            z-index: 99999 !important;
            top: 40px;
            flex-wrap: wrap;
            width: auto;
            border-width: 2px !important;
            border-style: solid;
            border-color: #383855;
            border-radius: 3px;
            min-width: 29px;
            padding: 5px;
        }

        [data-theme="dark"] .colors-box {
            background: #2b2b40 !important;
        }

        .colors-box > .color-input {
            width: 19px;
            height: 19px;
            border-width: 2px !important;
            border-style: solid;
            border-color: #383855;
            border-radius: 3px;
            margin-bottom: 3px;
            margin-right: 3px;
            cursor: pointer;
        }

        .inputTitleText{
            width: 100%;
            box-shadow: 0 0 0 0;
            border: 0 none;
            outline: 0;
            font-size: inherit;
            font-weight: inherit;
            line-height: 1.2;
            background-color: transparent;
            color: inherit;
        }

        @for($i = 1; $i <= $block_quantity; $i++)
            #img-layout-{{ $i }} {
                content: url('{{ asset('images/admin/pages/light/Bloco-'.$i.'.png') }}');
            }

            [data-theme="dark"] #img-layout-{{ $i }} {
                content: url('{{ asset('images/admin/pages/dark/Bloco-'.$i.'.png') }}');
            }
        @endfor

        .img-thumbnail{
            max-width: 700px !important;
        }

        .tooltip-inner{
            max-width: 800px !important;
        }

        /*.ck-reset_all :not(.ck-reset_all-excluded *), .ck.ck-reset_all {
            z-index: 999999 !important;
        }*/

        body {
            --ck-z-default: 100;
            --ck-z-modal: calc( var(--ck-z-default) + 999 );
        }

        .ck-powered-by-balloon{
            display: none !important;
        }
    </style>
@endpush
@section('content')
    @if($page->blocks->count() == 0)
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card body-->
            <div class="card-body">
                <!--begin::Heading-->
                <div class="card-px text-center pt-15 pb-15">
                    <!--begin::Title-->
                    <h2 class="fs-2x fw-bold mb-0">Layout</h2>
                    <!--end::Title-->
                    <!--begin::Description-->
                    <p class="text-gray-400 fs-4 fw-semibold py-7">Clique no botão abaixo<br />para adicionar o primeiro bloco dessa página.
                    </p>
                    <!--end::Description-->
                    <!--begin::Action-->
                    <button class="btn btn-primary er fs-6 px-8 py-4" onclick="editBlock(0)">Adicionar bloco</button>
                    <!--end::Action-->
                </div>
                <!--end::Heading-->
                <!--begin::Illustration-->
                <div class="text-center pb-15 px-5">
                    <img src="{{ asset('assets/media/illustrations/sigma-1/4.png') }}" alt="" class="mw-100 h-200px h-sm-325px">
                </div>
                <!--end::Illustration-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    @else
        <!--end::Table-->
        <div class="card card-flush py-4">
            <!--begin::Card header-->
            <div class="card-header">
                <div class="card-title">
                    <h2>Layout</h2>
                </div>
                <!--begin::Card toolbar-->
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                    <!--begin::Add product-->
                    <a href="#" data-bs-toggle="modal" data-bs-target="#useBlockTemplateModal" type="button" class="btn btn-primary">Template</a>
                    @php
                        $url = '';
                        if ($page->prefix_slug->count() > 0) {
                            $url .= implode('/', $page->prefix_slug->pluck('slug')->toArray()) . '/';
                        }
                        $url .= $page->slug;
                    @endphp
                    <a href="/{{ $url }}/{{ $page->hash_id }}" target="_blank" class="btn btn-primary">Visualizar</a>
                    <button class="btn btn-primary" onclick="editBlock(0)">Adicionar bloco</button>
                    <!--end::Add product-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Input group-->
                <div class="fv-row">
                    <form id="displayOrder">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="tableOrder">
                            <!--begin::Table head-->
                            <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th></th>
                                <th class="min-w-200px">Título</th>
                                <th class="min-w-100px">Layout</th>
                                <th class="text-center min-w-100px">Ações</th>
                            </tr>
                            <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-semibold text-gray-600" id="body-articles">
                            <!--begin::Table row-->
                            @foreach($page->blocks->sortBy('display_order') as $block)
                                <tr>
                                    <input type="hidden" name="ids[]" value="{{$block->id}}">
                                    <td style="cursor: pointer"><i class="fas fa-bars text-gray-800"></i></td>
                                    <!--begin::Título=-->
                                    <td class="pe-0">
                                        <input class="inputTitleText" value="{{ $block->block_title }}" onchange="changeTitle(this, '{{ $block->id }}')">
                                    </td>
                                    <!--end::Título=-->
                                    <!--begin::Título=-->
                                    <td class="pe-0">Layout {{ $block->layout }}</td>
                                    <!--end::Título=-->
                                    <!--begin::Action=-->
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            Ações
                                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"/>
                                                </svg>
                                            </span>
                                            <!--end::Svg Icon-->
                                        </a>
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a onclick="editBlock({{ $block->id }})" class="menu-link px-3 cursor-pointer">Editar</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a onclick="copyBlock('{{ $block->id }}')" class="menu-link px-3">Copiar</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a onclick="templateBlock('{{ $block->id }}')" class="menu-link px-3">Template</a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a onclick="deleteBlock({{ $block->id }})" class="menu-link px-3 cursor-pointer">Excluir</a>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu-->
                                    </td>
                                    <!--end::Action=-->
                                </tr>
                            @endforeach
                            <!--end::Table row-->
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </form>
                </div>
                <!--end::Input group-->
            </div>
            <!--end::Card header-->
        </div>
        <!--end::Table-->
    @endif

    <!--begin::Modal - Create Project-->
    <div class="modal fade" id="block_modal" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-fullscreen p-9">
            <!--begin::Modal content-->
            <div class="modal-content modal-rounded">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2>Configurações</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" onclick="destroyCK()" data-bs-dismiss="modal" id="btnCloseModal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y m-5">
                    <!--begin::Stepper-->
                    <div class="stepper stepper-links d-flex flex-column" id="stepperBlock">
                        <!--begin::Container-->
                        <div class="container">
                            <!--begin::Nav-->
                            <div class="stepper-nav justify-content-center py-2">
                                <!--begin::Step 1-->
                                <div class="stepper-item me-5 me-md-15 current" data-kt-stepper-element="nav">
                                    <h3 class="stepper-title">Bloco</h3>
                                </div>
                                <!--end::Step 1-->
                                <!--begin::Step 2-->
                                <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
                                    <h3 class="stepper-title">Conteúdo</h3>
                                </div>
                                <!--end::Step 2-->
                                <!--begin::Step 3-->
                                <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
                                    <h3 class="stepper-title">Layout</h3>
                                </div>
                                <!--end::Step 3-->
                                <!--begin::Step 4-->
                                <div class="stepper-item me-5 me-md-15" data-kt-stepper-element="nav">
                                    <h3 class="stepper-title">Conclusão</h3>
                                </div>
                                <!--end::Step 4-->
                            </div>
                            <!--end::Nav-->
                            <!--begin::Form-->
                            <form id="formBlock" class="mx-auto w-100 pt-15" novalidate="novalidate" method="post">
                                <!--begin::BLOCO-->
                                <div class="current" data-kt-stepper-element="content">
                                    <input type="hidden" name="page_id" value="{{ $page->id }}">
                                    <input type="hidden" id="block_id">
                                    <!--begin::Wrapper-->
                                    <div class="w-100">
                                        <div class="mb-5 hover-scroll-x">
                                            <div class="d-grid">
                                                <ul class="nav nav-tabs flex-nowrap text-nowrap">
                                                    <li class="nav-item">
                                                        <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0 active" data-bs-toggle="tab" href="#tab-banner">Banner</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#tab-breadcumb">Breadcumb</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#tab-features">Features</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#tab-depoimentos">Depoimentos</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#tab-CTA">CTA</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#tab-forms">Formulário</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#tab-galeria">Galeria</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#tab-equipe">Equipe</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#tab-vantagens">Vantagens</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#tab-FAQ">FAQ</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#tab-blog">Blog</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#tab-loja">Loja</a>
                                                    </li>
                                                    @if(env('APP_NAME') == 'iii-INCT')
                                                        <li class="nav-item">
                                                            <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#tab-III">{{ env('APP_NAME') }}</a>
                                                        </li>
                                                    @endif
                                                    @if(env('APP_NAME') == 'AABB-SP')
                                                        <li class="nav-item">
                                                            <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#tab-AABB">{{ env('APP_NAME') }}</a>
                                                        </li>
                                                    @endif
                                                    @if(env('APP_NAME') == 'PróLab')
                                                        <li class="nav-item">
                                                            <a class="nav-link btn btn-active-light btn-color-gray-600 btn-active-color-primary rounded-bottom-0" data-bs-toggle="tab" href="#tab-ProLab">{{ env('APP_NAME') }}</a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="tab-content" id="myTabContent" data-kt-buttons="true">
                                            <div class="tab-pane fade show active" id="tab-banner" role="tabpanel">
                                                <div class="row mb-6">
                                                    @include('admin.pages.pages.components.block', ['i' => 3])
                                                    @include('admin.pages.pages.components.block', ['i' => 4])
                                                    @include('admin.pages.pages.components.block', ['i' => 14])
                                                    @include('admin.pages.pages.components.block', ['i' => 39])
                                                    @include('admin.pages.pages.components.block', ['i' => 40])
                                                    @include('admin.pages.pages.components.block', ['i' => 49])
                                                    @include('admin.pages.pages.components.block', ['i' => 50])
                                                    @include('admin.pages.pages.components.block', ['i' => 52])
                                                    @include('admin.pages.pages.components.block', ['i' => 66])
                                                    @include('admin.pages.pages.components.block', ['i' => 68])
                                                    @include('admin.pages.pages.components.block', ['i' => 69])
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab-breadcumb" role="tabpanel">
                                                <div class="row mb-6">
                                                    @include('admin.pages.pages.components.block', ['i' => 33])
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab-features" role="tabpanel">
                                                <div class="row mb-6">
                                                    @include('admin.pages.pages.components.block', ['i' => 1])
                                                    @include('admin.pages.pages.components.block', ['i' => 5])
                                                    @include('admin.pages.pages.components.block', ['i' => 7])
                                                    @include('admin.pages.pages.components.block', ['i' => 10])
                                                    @include('admin.pages.pages.components.block', ['i' => 13])
                                                    @include('admin.pages.pages.components.block', ['i' => 15])
                                                    @include('admin.pages.pages.components.block', ['i' => 19])
                                                    @include('admin.pages.pages.components.block', ['i' => 25])
                                                    @include('admin.pages.pages.components.block', ['i' => 28])
                                                    @include('admin.pages.pages.components.block', ['i' => 29])
                                                    @include('admin.pages.pages.components.block', ['i' => 31])
                                                    @include('admin.pages.pages.components.block', ['i' => 32])
                                                    @include('admin.pages.pages.components.block', ['i' => 34])
                                                    @include('admin.pages.pages.components.block', ['i' => 36])
                                                    @include('admin.pages.pages.components.block', ['i' => 41])
                                                    @include('admin.pages.pages.components.block', ['i' => 43])
                                                    @include('admin.pages.pages.components.block', ['i' => 44])
                                                    @include('admin.pages.pages.components.block', ['i' => 45])
                                                    @include('admin.pages.pages.components.block', ['i' => 47])
                                                    @include('admin.pages.pages.components.block', ['i' => 48])
                                                    @include('admin.pages.pages.components.block', ['i' => 55])
                                                    @include('admin.pages.pages.components.block', ['i' => 57])
                                                    @include('admin.pages.pages.components.block', ['i' => 59])
                                                    @include('admin.pages.pages.components.block', ['i' => 60])
                                                    @include('admin.pages.pages.components.block', ['i' => 61])
                                                    @include('admin.pages.pages.components.block', ['i' => 62])
                                                    @include('admin.pages.pages.components.block', ['i' => 63])
                                                    @include('admin.pages.pages.components.block', ['i' => 64])
                                                    @include('admin.pages.pages.components.block', ['i' => 65])
                                                    @include('admin.pages.pages.components.block', ['i' => 67])
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab-depoimentos" role="tabpanel">
                                                <div class="row mb-6">
                                                    @include('admin.pages.pages.components.block', ['i' => 9])
                                                    @include('admin.pages.pages.components.block', ['i' => 46])
                                                    @include('admin.pages.pages.components.block', ['i' => 51])
                                                    @include('admin.pages.pages.components.block', ['i' => 54])
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab-CTA" role="tabpanel">
                                                <div class="row mb-6">
                                                    @include('admin.pages.pages.components.block', ['i' => 20])
                                                    @include('admin.pages.pages.components.block', ['i' => 24])
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab-forms" role="tabpanel">
                                                <div class="row mb-6">
                                                    @include('admin.pages.pages.components.block', ['i' => 12])
                                                    @include('admin.pages.pages.components.block', ['i' => 17])
                                                    @include('admin.pages.pages.components.block', ['i' => 18])
                                                    @include('admin.pages.pages.components.block', ['i' => 38])
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab-galeria" role="tabpanel">
                                                <div class="row mb-6">
                                                    @include('admin.pages.pages.components.block', ['i' => 26])
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab-equipe" role="tabpanel">
                                                Vazio
                                            </div>
                                            <div class="tab-pane fade" id="tab-vantagens" role="tabpanel">
                                                <div class="row mb-6">
                                                    @include('admin.pages.pages.components.block', ['i' => 2])
                                                    @include('admin.pages.pages.components.block', ['i' => 6])
                                                    @include('admin.pages.pages.components.block', ['i' => 8])
                                                    @include('admin.pages.pages.components.block', ['i' => 16])
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab-FAQ" role="tabpanel">
                                                <div class="row mb-6">
                                                    @include('admin.pages.pages.components.block', ['i' => 37])
                                                    @include('admin.pages.pages.components.block', ['i' => 53])
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab-blog" role="tabpanel">
                                                <div class="row mb-6">
                                                    @include('admin.pages.pages.components.block', ['i' => 11])
                                                    @include('admin.pages.pages.components.block', ['i' => 42])
                                                    @include('admin.pages.pages.components.block', ['i' => 58])
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="tab-loja" role="tabpanel">
                                                <div class="row mb-6">
                                                    @include('admin.pages.pages.components.block', ['i' => 72])
                                                    @include('admin.pages.pages.components.block', ['i' => 73])
                                                </div>
                                            </div>
                                            @if(env('APP_NAME') == 'iii-INCT')
                                                <div class="tab-pane fade" id="tab-III" role="tabpanel">
                                                    <div class="row mb-6">
                                                        @include('admin.pages.pages.components.block', ['i' => 21])
                                                        @include('admin.pages.pages.components.block', ['i' => 22])
                                                        @include('admin.pages.pages.components.block', ['i' => 23])
                                                    </div>
                                                </div>
                                            @endif
                                            @if(env('APP_NAME') == 'AABB-SP')
                                                <div class="tab-pane fade" id="tab-AABB" role="tabpanel">
                                                    <div class="row mb-6">
                                                        @include('admin.pages.pages.components.block', ['i' => 27])
                                                        @include('admin.pages.pages.components.block', ['i' => 28])
                                                        @include('admin.pages.pages.components.block', ['i' => 30])
                                                        @include('admin.pages.pages.components.block', ['i' => 35])
                                                    </div>
                                                </div>
                                            @endif
                                            @if(env('APP_NAME') == 'PróLab')
                                                <div class="tab-pane fade" id="tab-ProLab" role="tabpanel">
                                                    <div class="row mb-6">
                                                        @include('admin.pages.pages.components.block', ['i' => 56])
                                                        @include('admin.pages.pages.components.block', ['i' => 70])
                                                        @include('admin.pages.pages.components.block', ['i' => 71])
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        {{--<!--begin::Input group-->
                                        <div class="row mb-6" data-kt-buttons="true">
                                            @for($i = 1; $i <= $block_quantity; $i++)
                                                <!--begin::Option-->
                                                <div class="col-3">
                                                    <label id="layout-{{ $i }}" class="m-6 btn btn-outline btn-outline-dashed btn-active-light-primary d-flex text-start p-6 {{ $i == 1 ? 'active':'' }}">
                                                        <!--begin::Input-->
                                                        <input class="btn-check" type="radio" {!! $i == 1 ? 'checked="checked"':'' !!} name="layout" value="{{ $i }}" />
                                                        <!--end::Input-->
                                                        <!--begin::Label-->
                                                        <span class="d-flex align-items-center">
                                                            <!--begin::Icon-->
                                                            <!--begin::Svg Icon | path: icons/duotune/communication/com006.svg-->
                                                            <img id="img-layout-{{ $i }}" height="64px" />
                                                            <!--end::Svg Icon-->
                                                            <!--end::Icon-->
                                                            <!--begin::Info-->
                                                            <span class="ms-4">
                                                                <span class="fs-3 fw-bold text-gray-900 mb-2 d-block">Bloco {{ $i < 10 ? '0'.$i:$i}}</span>
                                                            </span>
                                                            <!--end::Info-->
                                                        </span>
                                                        <!--end::Label-->
                                                    </label>
                                                </div>
                                                <!--end::Option-->
                                            @endfor
                                        </div>
                                        <!--end::Input group-->--}}
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::BLOCO-->
                                <!--begin::CONTEÚDO-->
                                <div data-kt-stepper-element="content" class="justify-content-center">
                                    @for($i = 1; $i <= $block_quantity; $i++)
                                        @include('admin.pages.pages.blocks.'.$i.'.content')
                                    @endfor
                                </div>
                                <!--end::CONTEÚDO-->
                                <!--begin::LAYOUT-->
                                <div data-kt-stepper-element="content" class="justify-content-center">
                                    @for($i = 1; $i <= $block_quantity; $i++)
                                        @include('admin.pages.pages.blocks.'.$i.'.layout')
                                    @endfor
                                </div>
                                <!--end::LAYOUT-->
                                <!--begin::CONCLUSÃO-->
                                <div data-kt-stepper-element="content" class="justify-content-center">
                                    <!--begin::Wrapper-->
                                    <div class="w-100 mw-600px">
                                        <!--begin::Heading-->
                                        <div class="pb-12">
                                            <!--begin::Title-->
                                            <h1 class="fw-bold text-dark">Conclusão</h1>
                                            <!--end::Title-->
                                        </div>
                                        <!--end::Heading-->
                                        <div class="text-center pb-15 px-5">
                                            <img src="{{ asset('assets/media/illustrations/sigma-1/17.png') }}" alt="" class="mw-100 h-200px h-sm-325px">
                                        </div>
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::CONCLUSÃO-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--begin::Container-->
                    </div>
                    <!--end::Stepper-->
                </div>
                <!--end::Modal body-->
                <div class="modal-footer">
                    <!--begin::Actions-->
                    <div id="buttons-block" class="w-full container mx-auto mw-600px" style="display: none; padding-right: 0; padding-left: 0">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-lg btn-primary" id="btnNextBloco" onclick="stepperNext(stepper, 'bloco', this);editorCK()">
                                <span class="indicator-label">Próximo</span>
                                <span class="indicator-progress">Aguarde...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                            </button>
                        </div>
                    </div>
                    <!--end::Actions-->
                    <!--begin::Actions-->
                    <div id="buttons-content" class="w-100 container mx-auto mw-600px" style="display: none; padding-right: 0; padding-left: 0">
                        <div class="d-flex flex-stack">
                            <button type="button" class="btn btn-lg btn-light me-3" onclick="stepperBack(stepper, 'content');destroyCK()">Voltar</button>
                            <button type="button" class="btn btn-lg btn-primary" onclick="stepperNext(stepper, 'conteúdo', this)">
                                <span class="indicator-label">Próximo</span>
                                <span class="indicator-progress">Aguarde...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                            </button>
                        </div>
                    </div>
                    <!--end::Actions-->
                    <!--begin::Actions-->
                    <div id="buttons-layout" class="w-100 container mx-auto mw-600px" style="display: none; padding-right: 0; padding-left: 0">
                        <div class="d-flex flex-stack">
                            <button type="button" class="btn btn-lg btn-light me-3" onclick="stepperBack(stepper, 'layout')">Voltar</button>
                            <button type="button" class="btn btn-lg btn-primary" onclick="stepperNext(stepper, 'layout', this)">
                                <span class="indicator-label">Próximo</span>
                                <span class="indicator-progress">Aguarde...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <!--end::Actions-->
                    <!--begin::Actions-->
                    <div id="buttons-finish" class="w-100 container mx-auto mw-600px" style="display: none; padding-right: 0; padding-left: 0">
                        <div class="d-flex flex-stack">
                            <button type="button" class="btn btn-lg btn-light me-3" onclick="stepperBack(stepper, 'finish')">Voltar</button>
                            <button type="button" class="btn btn-lg btn-primary" onclick="stepperNext(stepper, 'finalizar', this)">
                                <span class="indicator-label">Finalizar</span>
                                <span class="indicator-progress">Aguarde...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <!--end::Actions-->
                </div>
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Create Project-->

    {{-- MODAL DE CRIAR TEMPLATE --}}
    <div class="modal fade" id="makeBlockTemplateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form id="formMakeBlockTemplate">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Template de bloco</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-5">
                            <label for="category" class="form-label">Título</label>
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-12 fv-row">
                                    <input type="hidden" name="block_id" id="make_block_template_id">
                                    <input type="text" class="form-control" name="title">
                                    <span class="text-muted fs-8">Digite o título do template do bloco.</span>
                                </div>
                                <!--end::Col-->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Concluído</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL DE USO DE TEMPLATE --}}
    <div class="modal fade" id="useBlockTemplateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form id="formUseBlockTemplate">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Templates de bloco</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-5">
                            <label for="category" class="form-label">Template</label>
                            <div class="row">
                                <!--begin::Col-->
                                <div class="col-12 fv-row">
                                    <input type="hidden" name="page_id" value="{{ $page->id }}">
                                    <select class="form-select mb-2" data-placeholder="Selecione uma opção" name="block_id" id="use_block_template_id">
                                        <option></option>
                                        @foreach(\App\Models\Pages\Block::where('is_template', true)->orderBy('block_title')->get() as $template)
                                            <option value="{{ $template->id }}">{{ $template->block_title }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-muted fs-8">Selecione o bloco no qual deseja utilizar o template.</span>
                                </div>
                                <!--end::Col-->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Concluído</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('ckeditor-page/build/ckeditor.js')}}"></script>
    <script src="{{asset('assets/plugins/custom/jquery-ui-1.13.2.custom/jquery-ui.min.js')}}"></script>
    {{-- OERDENAÇÃO DOS BLOCOS E MUDANÇA NO TÍTULO --}}
    <script>
        $("#tableOrder tbody").sortable({
            start: function (e, ui) {
                var elements = ui.item.siblings('.selected.hidden').not('.ui-sortable-placeholder');
                ui.item.data('items', elements);
            },
            update: function (e, ui) {
                ui.item.after(ui.item.data("items"));
            },
            stop: function (e, ui) {
                ui.item.siblings('.selected').removeClass('hidden');
                $('tr.selected').removeClass('selected');
                $('#displayOrder').submit();
            }
        });

        $('#displayOrder').on("submit", function(e) {
            e.preventDefault();
            var form = new FormData(this);
            $.ajax({
                url: '{{ route('admin.pages.blocks.display-order') }}',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function(data){
                    if(data.success === false){
                        openAlert('Erro', data.message, 'error');
                    }
                },
                error: function(data){
                    openAlert('Erro', 'Falha ao editar ordem de exibição', 'error');
                }
            });
        });

        function changeTitle(input, id) {
            $.ajax({
                method: "POST",
                url: "{{route('admin.pages.blocks.change-title')}}",
                data: {
                    id: id,
                    block_title: $(input).val()
                },
                success: function (data) {
                    if (!data.success) {
                        openAlert('Erro', data.message, 'error');
                    }
                },
                error: function () {
                    openAlert('Erro', 'Erro ao processar requisição', 'error');
                }
            })
        }
    </script>

    {{-- CRUD DO BLOCO --}}
    <script>
        //Quantidade de blocos
        const $block_quantity = {{ $block_quantity }};
        //Blocos que serão ignorados o ckeditor e ficará apenas um textarea
        const ignoreCkeditorBlocks = [
            1, 2, 3, 4, 5, 6, 8, 9, 10,
            11, 12, 14, 15, 16, 17, 18, 19, 20,
            21, 22, 23, 24, 25, 26, 27, 28, 30,
            34, 35, 36, 37, 38, 39, 40,
            47, 49, 50,
            52, 54, 55, 56, 57,
            62, 63, 64, 65, 67, 68, 69, 70, 71
        ];
        //Modal que cria um bloco
        let blockModal = new bootstrap.Modal(document.getElementById('block_modal'), {backdrop: 'static', keyboard: false, focus: false});
        //Modal que cria um template de bloco
        let makeBlockTemplateModal = new bootstrap.Modal(document.getElementById('makeBlockTemplateModal'), {backdrop: 'static', keyboard: false});

        const buttonsBlock = $('#buttons-block');
        const buttonsContent = $('#buttons-content');
        const buttonsLayout = $('#buttons-layout');
        const buttonsFinish = $('#buttons-finish');

        let element = document.querySelector("#stepperBlock");
        let stepper = new KTStepper(element);

        $("#use_block_template_id").select2({
            dropdownParent: $("#useBlockTemplateModal")
        });

        function stepperNext(stepper, type, button) {
            const form = document.querySelector('#formBlock');
            const data = new FormData(form);
            data.append('block_id', $('#block_id').val());

            if (type === 'bloco') {
                steppSubmit(data, button, "{{ route('admin.pages.blocks.validateBloco') }}", 'block');
            } else if (type === 'conteúdo') {
                steppSubmit(data, button, "{{ route('admin.pages.blocks.validateContent') }}", 'content');
            } else if (type === 'layout') {
                steppSubmit(data, button, "{{ route('admin.pages.blocks.validateLayout') }}", 'layout');
            } else if (type === 'finalizar'){
                if ($('#block_id').val().length > 0){
                    steppSubmit(data, button, "{{ route('admin.pages.blocks.update', '_ID_') }}".replace('_ID_', $('#block_id').val()), 'finish', true);
                }else{
                    steppSubmit(data, button, "{{ route('admin.pages.blocks.store') }}", 'finish', true);
                }
            }
        }

        function stepperBack(stepper, type) {
            stepper.goPrevious(); // go previous step

            if (type === 'content'){
                buttonsBlock.show();
                buttonsContent.hide();
                buttonsLayout.hide();
                buttonsFinish.hide();
            }else if (type === 'layout'){
                buttonsBlock.hide();
                buttonsContent.show();
                buttonsLayout.hide();
                buttonsFinish.hide();
            }else if (type === 'finish'){
                buttonsBlock.hide();
                buttonsContent.hide();
                buttonsLayout.show();
                buttonsFinish.hide();
            }
        }

        function steppSubmit(form, button, route, type, submit = false) {
            button.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
            button.disabled = true;

            let rtn;

            if (submit){
                form.append('background_color_'+form.get('layout'), $('#background_color_'+form.get('layout')).css("background-color"));
                form.append('title_color_'+form.get('layout'), $('#title_color_'+form.get('layout')).css("background-color"));
                form.append('content_color_'+form.get('layout'), $('#content_color_'+form.get('layout')).css("background-color"));
                form.append('subtitle_color_'+form.get('layout'), $('#subtitle_color_'+form.get('layout')).css("background-color"));
                form.append('tag_color_'+form.get('layout'), $('#tag_color_'+form.get('layout')).css("background-color"));
                form.append('tag_title_color_'+form.get('layout'), $('#tag_title_color_'+form.get('layout')).css("background-color"));
                form.append('button_title_color_'+form.get('layout'), $('#button_title_color_'+form.get('layout')).css("background-color"));
                form.append('button_border_color_'+form.get('layout'), $('#button_border_color_'+form.get('layout')).css("background-color"));
                form.append('button_color_'+form.get('layout'), $('#button_color_'+form.get('layout')).css("background-color"));
                form.append('number_color_'+form.get('layout'), $('#number_color_'+form.get('layout')).css("background-color"));
                form.append('divider_color_'+form.get('layout'), $('#divider_color_'+form.get('layout')).css("background-color"));
                form.append('icon_color_'+form.get('layout'), $('#icon_color_'+form.get('layout')).css("background-color"));
                form.append('value_of_color_'+form.get('layout'), $('#value_of_color_'+form.get('layout')).css("background-color"));
                form.append('value_by_color_'+form.get('layout'), $('#value_by_color_'+form.get('layout')).css("background-color"));
                form.append('button_title_color1_'+form.get('layout'), $('#button_title_color1_'+form.get('layout')).css("background-color"));
                form.append('button_border_color1_'+form.get('layout'), $('#button_border_color1_'+form.get('layout')).css("background-color"));
                form.append('button_color1_'+form.get('layout'), $('#button_color1_'+form.get('layout')).css("background-color"));
                form.append('cursos_button_color_'+form.get('layout'), $('#cursos_button_color_'+form.get('layout')).css("background-color"));
                form.append('cursos_button_title_color_'+form.get('layout'), $('#cursos_button_title_color_'+form.get('layout')).css("background-color"));
                form.append('primary_color_'+form.get('layout'), $('#primary_color_'+form.get('layout')).css("background-color"));
                form.append('topics_color_'+form.get('layout'), $('#topics_color_'+form.get('layout')).css("background-color"));
                form.append('date_color_'+form.get('layout'), $('#date_color_'+form.get('layout')).css("background-color"));
                form.append('pdf_title_color_'+form.get('layout'), $('#pdf_title_color_'+form.get('layout')).css("background-color"));
                form.append('pdf_color_'+form.get('layout'), $('#pdf_color_'+form.get('layout')).css("background-color"));
                form.append('logo_title_color_'+form.get('layout'), $('#logo_title_color_'+form.get('layout')).css("background-color"));
                form.append('logo_background_color_'+form.get('layout'), $('#logo_background_color_'+form.get('layout')).css("background-color"));

                for (var i = 1; i <= 6; i++){
                    form.append('background_color_'+form.get('layout')+'_'+i, $('#background_color_'+form.get('layout')+'_'+i).css("background-color"));
                    form.append('title_color_'+form.get('layout')+'_'+i, $('#title_color_'+form.get('layout')+'_'+i).css("background-color"));
                    form.append('content_color_'+form.get('layout')+'_'+i, $('#content_color_'+form.get('layout')+'_'+i).css("background-color"));
                    form.append('subtitle_color_'+form.get('layout')+'_'+i, $('#subtitle_color_'+form.get('layout')+'_'+i).css("background-color"));
                    form.append('button_title_color_'+form.get('layout')+'_'+i, $('#button_title_color_'+form.get('layout')+'_'+i).css("background-color"));
                    form.append('button_border_color_'+form.get('layout')+'_'+i, $('#button_border_color_'+form.get('layout')+'_'+i).css("background-color"));
                    form.append('button_color_'+form.get('layout')+'_'+i, $('#button_color_'+form.get('layout')+'_'+i).css("background-color"));
                    form.append('number_color_'+form.get('layout')+'_'+i, $('#number_color_'+form.get('layout')+'_'+i).css("background-color"));
                    form.append('divider_color_'+form.get('layout')+'_'+i, $('#divider_color_'+form.get('layout')+'_'+i).css("background-color"));
                    form.append('icon_color_'+form.get('layout')+'_'+i, $('#icon_color_'+form.get('layout')+'_'+i).css("background-color"));
                    form.append('value_of_color_'+form.get('layout')+'_'+i, $('#value_of_color_'+form.get('layout')+'_'+i).css("background-color"));
                    form.append('value_by_color_'+form.get('layout')+'_'+i, $('#value_by_color_'+form.get('layout')+'_'+i).css("background-color"));
                    form.append('button_title_color1_'+form.get('layout')+'_'+i, $('#button_title_color1_'+form.get('layout')+'_'+i).css("background-color"));
                    form.append('button_border_color1_'+form.get('layout')+'_'+i, $('#button_border_color1_'+form.get('layout')+'_'+i).css("background-color"));
                    form.append('button_color1_'+form.get('layout')+'_'+i, $('#button_color1_'+form.get('layout')+'_'+i).css("background-color"));
                }

                if ($('#block_id').val().length > 0){
                    //form.append('_method', 'PUT');
                }
            }

            $.ajax({
                url: route,
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data.success) {
                        rtn = true;
                        if(stepper.getCurrentStepIndex() === 1){
                            showContent(data.layout);
                        }else if(stepper.getCurrentStepIndex() === 2){
                            showLayout(data.layout);
                        }
                    } else {
                        rtn = false;
                        openAlert('Erro', data.message, 'error');
                    }
                },
                error: function(data) {
                    button.removeAttribute('data-kt-indicator');
                    button.disabled = false;

                    console.log(data);
                    openAlert('Erro', 'Erro ao processar requisição, tente novamente', 'error');

                    rtn = false;
                }
            }).done(function() {
                button.removeAttribute('data-kt-indicator');
                button.disabled = false;

                if (rtn) {
                    if (!submit){
                        stepper.goNext(); // go next step
                        if (type === 'block') {
                            buttonsBlock.hide();
                            buttonsContent.show();
                            buttonsLayout.hide();
                            buttonsFinish.hide();
                        } else if (type === 'content') {
                            buttonsBlock.hide();
                            buttonsContent.hide();
                            buttonsLayout.show();
                            buttonsFinish.hide();
                        } else if (type === 'layout') {
                            buttonsBlock.hide();
                            buttonsContent.hide();
                            buttonsLayout.hide();
                            buttonsFinish.show();
                        }
                    }else{
                        $('#btnCloseModal').click();
                        openAlert('Sucesso', 'Bloco salvo com sucesso', 'success');
                    }
                }
            });
        }

        function editBlock(id){
            zerarCampos();
            if (id == 0){
                $('#block_id').val(null);
                stepper.goFirst();
                buttonsBlock.show();
                buttonsContent.hide();
                buttonsLayout.hide();
                buttonsFinish.hide();
                blockModal.show();
            }else{
                $.ajax({
                    url: "{{ route('admin.pages.blocks.edit', '_ID_') }}".replace('_ID_', id),
                    type: 'GET',
                    success: function(data){

                        $('#block_id').val(data.id);
                        stepper.goFirst();
                        $('#layout-'+data.layout).click();
                        $('#btnNextBloco').click();

                        setTimeout(function (){
                            preencherCampos(data);
                        },300)

                        blockModal.show();
                    },
                    error: function(data){
                        openAlert('Falha!', 'Falha ao editar evento', 'error');
                    }
                });
            }
        }

        function copyBlock(id){
            Swal.fire({
                text: "Tem certeza que deseja copiar a página?",
                icon: "question",
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Sim, copiar!",
                cancelButtonText: "Não, cancelar",
                customClass: {
                    cancelButton: "btn fw-bold btn-primary",
                    confirmButton: "btn fw-bold btn-success"
                }
            }).then((function (t) {
                if (t.value) {
                    $.ajax({
                        method: "GET",
                        url: `{{route('admin.pages.blocks.copy', '_id_')}}`.replace('_id_', id),
                        success: function (rtn) {
                            if (rtn.success) {
                                Swal.fire({
                                    text: "Você copiou o bloco.",
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, continuar!",
                                    customClass: {confirmButton: "btn fw-bold btn-primary"}
                                }).then((function () {
                                    location.reload();
                                }))
                            } else {
                                Swal.fire('Erro!', rtn.message, 'error')
                            }
                        },
                        error: function () {
                            Swal.fire('Falha!', 'Erro ao processar requisição.', 'error');
                        }
                    })
                }
            }))
        }

        function templateBlock(id){
            $('#make_block_template_id').val(id);
            makeBlockTemplateModal.show();
        }

        $('#formMakeBlockTemplate').on('submit', function(e){
           e.preventDefault();
            var form = new FormData(this);
            $.ajax({
                url: '{{ route('admin.pages.blocks.makeTemplate') }}',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function(data){
                    if(data.success){
                        Swal.fire({
                            text: "Você criou o template do bloco.",
                            icon: "success",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, continuar!",
                            customClass: {confirmButton: "btn fw-bold btn-primary"}
                        }).then((function () {
                            location.reload();
                        }))
                    }else{
                        Swal.fire('Erro', data.message, 'error');
                    }
                },
                error: function(data){
                    Swal.fire('Falha!', 'Falha ao criar template do bloco', 'error');
                }
            });
        });

        $('#formUseBlockTemplate').on('submit', function (e){
            e.preventDefault();
            var form = new FormData(this);
            $.ajax({
                url: '{{ route('admin.pages.blocks.useTemplate') }}',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function(data){
                    if(data.success){
                        Swal.fire({
                            text: "Você usou o template do bloco.",
                            icon: "success",
                            buttonsStyling: !1,
                            confirmButtonText: "Ok, continuar!",
                            customClass: {confirmButton: "btn fw-bold btn-primary"}
                        }).then((function () {
                            location.reload();
                        }))
                    }else{
                        Swal.fire('Erro', data.message, 'error');
                    }
                },
                error: function(data){
                    Swal.fire('Falha!', 'Falha ao criar template do bloco', 'error');
                }
            });
        });

        function deleteBlock(id){
            Swal.fire({
                text: "Tem certeza que deseja excluir esse bloco?",
                icon: "question",
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Sim, excluir!",
                cancelButtonText: "Não, cancelar",
                customClass: {
                    cancelButton: "btn fw-bold btn-primary",
                    confirmButton: "btn fw-bold btn-danger"
                }
            }).then((function (t) {
                if (t.value) {
                    $.ajax({
                        method: "DELETE",
                        url: `{{route('admin.pages.blocks.destroy', '_id_')}}`.replace('_id_', id),
                        success: function (rtn) {
                            if (rtn.success === true) {
                                Swal.fire({
                                    text: "Bloco excluído com sucesso",
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, continuar!",
                                    customClass: {confirmButton: "btn fw-bold btn-primary"}
                                }).then((function () {
                                    location.reload();
                                }))
                            } else {
                                Swal.fire('Erro!', rtn.message, 'error')
                            }
                        },
                        error: function () {
                            Swal.fire('Falha!', 'Erro ao processar requisição', 'error');
                        }
                    })
                }
            }))
        }

        function preencherCampos(data){
            $('#margin_top_'+data.layout).val(data.margin_top);
            $('#margin_bottom_'+data.layout).val(data.margin_bottom);
            $('#title_'+data.layout).val(data.title);
            $('#title_color_'+data.layout).css('background-color', data.title_color);
            $('#subtitle_'+data.layout).val(data.subtitle);
            $('#subtitle_color_'+data.layout).css('background-color', data.subtitle_color);
            $('#tag_'+data.layout).val(data.tag);
            $('#tag_color_'+data.layout).css('background-color', data.tag_color);
            $('#tag_title_color_'+data.layout).css('background-color', data.tag_title_color);
            $('#content_'+data.layout).val(data.content);
            if(data.content && !ignoreCkeditorBlocks.includes(parseInt(data.layout))){
                document.querySelector(`textarea#content_${data.layout}`).parentNode.querySelector('.ck-editor .ck-editor__editable').ckeditorInstance.setData(data.content);
            }
            $('#content_color_'+data.layout).css('background-color', data.content_color);
            $('#content_type_'+data.layout).val(data.content_type).trigger('change');
            $('#display_content_'+data.layout).val(data.display_content).trigger('change');
            $('#content_alignment_'+data.layout).val(data.content_alignment).trigger('change');
            $('#content_link_'+data.layout).val(data.content_link);
            $('#image_'+data.layout).val(null);
            $('#proportion_'+data.layout).val(data.proportion).trigger('change');
            $('#background_color_'+data.layout).css('background-color', data.background_color);
            $('#button_display_'+data.layout).prop('checked', data.button_display).trigger('change');
            $('#button_title_'+data.layout).val(data.button_title);
            $('#button_title_color_'+data.layout).css('background-color', data.button_title_color);
            $('#button_border_color_'+data.layout).css('background-color', data.button_border_color);
            $('#button_color_'+data.layout).css('background-color', data.button_color);
            $('#button_type_'+data.layout).val(data.button_type).trigger('change');
            $('#button_link_'+data.layout).val(data.button_link);
            $('#button_url_'+data.layout).val(data.button_link);
            $('#button_pagina_'+data.layout).val(data.button_link).trigger('change');
            $('#button_display1_'+data.layout).prop('checked', data.button_display_1).trigger('change');
            $('#button_title1_'+data.layout).val(data.button_title_1);
            $('#button_title_color1_'+data.layout).css('background-color', data.button_title_color_1);
            $('#button_border_color1_'+data.layout).css('background-color', data.button_border_color_1);
            $('#button_color1_'+data.layout).css('background-color', data.button_color_1);
            $('#button_type1_'+data.layout).val(data.button_type_1).trigger('change');
            $('#button_link1_'+data.layout).val(data.button_link_1);
            $('#button_url1_'+data.layout).val(data.button_link_1);
            $('#button_pagina1_'+data.layout).val(data.button_link_1).trigger('change');
            $('#divider_display_'+data.layout).prop('checked', data.divider).trigger('change');
            $('#divider_color_'+data.layout).css('background-color', data.divider_color);
            $('#date_'+data.layout).val(data.date);
            $('#date_color_'+data.layout).css('background-color', data.date_color);
            $('#primary_color_'+data.layout).css('background-color', data.primary_color);
            $('#value_of_'+data.layout).val(data.page_value_of);
            $('#value_of_color_'+data.layout).css('background-color', data.page_value_of_color);
            $('#value_by_'+data.layout).val(data.page_value_by);
            $('#value_by_color_'+data.layout).css('background-color', data.page_value_by_color);
            $('#initial_value_'+data.layout).val(data.initial_value);
            $('#final_value_'+data.layout).val(data.final_value);
            $('#display_pdf_'+data.layout).prop('checked', !!data.display_pdf).trigger('change');
            $('#pdf_title_'+data.layout).val(data.pdf_title);
            $('#pdf_title_color_'+data.layout).css('background-color', data.pdf_title_color);
            $('#pdf_color_'+data.layout).css('background-color', data.pdf_color);
            $('#logo_display_'+data.layout).prop('checked', !!data.logo_display).trigger('change');
            $('#logo_title_'+data.layout).val(data.logo_title);
            $('#logo_title_color_'+data.layout).css('background-color', data.logo_title_color);
            $('#logo_background_color_'+data.layout).css('background-color', data.logo_background_color);
            $('#blogs_model_'+data.layout).val(data.blogs_model).trigger('change');
            $('#blog_category_'+data.layout).val(data.blog_category).trigger('change');
            $('#blogs_'+data.layout).val(data.blogs).trigger('change');
            $('#testimonial_category_'+data.layout).val(data.testimonial_category).trigger('change');
            if(data.testimonials){
                let testimonials = JSON.parse(data.testimonials);
                $('#testimonials_'+data.layout).val(testimonials).trigger('change');
            }
            $('#faq_category_'+data.layout).val(data.faq_category).trigger('change');
            if(data.faqs){
                let faqs = JSON.parse(data.faqs);
                $('#faqs_'+data.layout).val(faqs).trigger('change');
            }
            $('#is_topic_'+data.layout).val(data.is_topic).trigger('change');
            $('#topic_category_'+data.layout).val(data.topic_category).trigger('change');
            $('#topics_categories_'+data.layout).val(data.topics_categories).trigger('change');
            if(data.topics){
                document.querySelector(`textarea#topics_${data.layout}`).parentNode.querySelector('.ck-editor .ck-editor__editable').ckeditorInstance.setData(data.topics);
            }
            $('#topics_color_'+data.layout).css('background-color', data.topics_color);
            if(data.logos_category){
                let logos_category = JSON.parse(data.logos_category)
                $('#logos_category_'+data.layout).val(logos_category).trigger('change');
            }
            if(data.events){
                let events = JSON.parse(data.events);
                $('#events_'+data.layout).val(events).trigger('change');
            }
            if(data.galleries){
                let galleries = JSON.parse(data.galleries);
                $('#galleries_'+data.layout).val(galleries).trigger('change');
            }
            if(data.alerts){
                let alerts = JSON.parse(data.alerts);
                $('#alerts_'+data.layout).val(alerts).trigger('change');
            }
            if(data.cards_categories){
                let cards_categories = JSON.parse(data.cards_categories);
                $('#cards_categories_'+data.layout).val(cards_categories).trigger('change');
            }
            $('#type_'+data.layout).val(data.type).trigger('change');
            if(data.pages){
                let pages = JSON.parse(data.pages);
                last_valid_courses34 = pages;
                $('#pages_'+data.layout).val(pages).trigger('change');
            }
            $('#email_'+data.layout).val(data.email).trigger('change');
            if(data.portfolios_categories){
                let portfolios_categories = JSON.parse(data.portfolios_categories);
                $('#portfolios_categories_'+data.layout).val(portfolios_categories).trigger('change');
            }
            if(data.portfolios){
                let portfolios = JSON.parse(data.portfolios);
                $('#portfolios_'+data.layout).val(portfolios).trigger('change');
            }
            $('#font_title_'+data.layout).val(data.font_title).trigger('change').trigger('select2:select');
            $('#font_subtitle_'+data.layout).val(data.font_subtitle).trigger('change').trigger('select2:select');
            $('#font_description_'+data.layout).val(data.font_description).trigger('change').trigger('select2:select');
            $('#font_button_'+data.layout).val(data.font_button).trigger('change').trigger('select2:select');
            for (let y = 1;y <= data.tabs.length;y++){
                $('#title_'+data.layout+'_'+y).val(data.tabs[y-1].title);
                $('#title_color_'+data.layout+'_'+y).css('background-color', data.tabs[y-1].title_color);
                $('#subtitle_'+data.layout+'_'+y).val(data.tabs[y-1].subtitle);
                $('#subtitle_color_'+data.layout+'_'+y).css('background-color', data.tabs[y-1].subtitle_color);
                $('#content_'+data.layout+'_'+y).val(data.tabs[y-1].content);
                if(data.tabs[y-1].content){
                    document.querySelector(`textarea#content_${data.layout}_${y}`).parentNode.querySelector('.ck-editor .ck-editor__editable').ckeditorInstance.setData(data.tabs[y-1].content);
                }
                $('#content_alignment_'+data.layout+'_'+y).val(data.tabs[y-1].content_alignment).trigger('change');
                $('#content_color_'+data.layout+'_'+y).css('background-color', data.tabs[y-1].content_color);
                $('#content_type_'+data.layout+'_'+y).val(data.tabs[y-1].content_type).trigger('change');
                $('#display_content_'+data.layout+'_'+y).val(data.tabs[y-1].display_content).trigger('change');
                $('#content_link_'+data.layout+'_'+y).val(data.tabs[y-1].content_link);
                $('#image_'+data.layout+'_'+y).val(null);
                $('#display_image_'+data.layout+'_'+y).val(data.tabs[y-1].display_image).trigger('change');
                $('#background_color_'+data.layout+'_'+y).css('background-color', data.tabs[y-1].background_color);
                $('#button_display_'+data.layout+'_'+y).prop('checked', data.tabs[y-1].button_display).trigger('change');
                $('#button_title_'+data.layout+'_'+y).val(data.tabs[y-1].button_title);
                $('#button_title_color_'+data.layout+'_'+y).css('background-color', data.tabs[y-1].button_title_color);
                $('#button_border_color_'+data.layout+'_'+y).css('background-color', data.tabs[y-1].button_border_color);
                $('#button_color_'+data.layout+'_'+y).css('background-color', data.tabs[y-1].button_color);
                $('#button_type_'+data.layout+'_'+y).val(data.tabs[y-1].button_type).trigger('change');
                $('#button_link_'+data.layout+'_'+y).val(data.tabs[y-1].button_link);
                $('#button_url_'+data.layout+'_'+y).val(data.tabs[y-1].button_link);
                $('#button_pagina_'+data.layout+'_'+y).val(data.tabs[y-1].button_link).trigger('change');
                $('#button_display1_'+data.layout+'_'+y).prop('checked', data.tabs[y-1].button_display_1).trigger('change');
                $('#button_title1_'+data.layout+'_'+y).val(data.tabs[y-1].button_title_1);
                $('#button_title_color1_'+data.layout+'_'+y).css('background-color', data.tabs[y-1].button_title_color_1);
                $('#button_border_color1_'+data.layout+'_'+y).css('background-color', data.tabs[y-1].button_border_color_1);
                $('#button_color1_'+data.layout+'_'+y).css('background-color', data.tabs[y-1].button_color_1);
                $('#button_type1_'+data.layout+'_'+y).val(data.tabs[y-1].button_type_1).trigger('change');
                $('#button_link1_'+data.layout+'_'+y).val(data.tabs[y-1].button_link_1);
                $('#button_url1_'+data.layout+'_'+y).val(data.tabs[y-1].button_link_1);
                $('#button_pagina1_'+data.layout+'_'+y).val(data.tabs[y-1].button_link_1).trigger('change');
                $('#date_'+data.layout+'_'+y).val(data.tabs[y-1].date);
                $('#hour_'+data.layout+'_'+y).val(data.tabs[y-1].hour);
                $('#month_'+data.layout+'_'+y).val(data.tabs[y-1].month).trigger('change');
                $('#icon_'+data.layout+'_'+y).val(data.tabs[y-1].icon);
                $('#icon_color_'+data.layout+'_'+y).css('background-color', data.tabs[y-1].icon_color);
                $('#number_'+data.layout+'_'+y).val(data.tabs[y-1].number);
                $('#number_color_'+data.layout+'_'+y).css('background-color', data.tabs[y-1].number_color);
                $('#divider_display_'+data.layout+'_'+y).prop('checked', data.tabs[y-1].divider).trigger('change');
                $('#divider_color_'+data.layout+'_'+y).css('background-color', data.tabs[y-1].divider_color);
                $('#divider_'+data.layout+'_'+y).val(data.tabs[y-1].divider).trigger('change');
                $('#value_of_'+data.layout+'_'+y).val(data.tabs[y-1].page_value_of);
                $('#value_of_color_'+data.layout+'_'+y).css('background-color', data.tabs[y-1].page_value_of_color);
                $('#value_by_'+data.layout+'_'+y).val(data.tabs[y-1].page_value_by);
                $('#value_by_color_'+data.layout+'_'+y).css('background-color', data.tabs[y-1].page_value_by_color);
                if(data.tabs[y-1].cards_categories){
                    let cards_categories = JSON.parse(data.tabs[y-1].cards_categories);
                    $('#cards_categories_'+data.layout+'_'+y).val(cards_categories).trigger('change');
                }
                $('#type_'+data.layout+'_'+y).val(data.tabs[y-1].type).trigger('change');
                $('#font_title_'+data.layout+'_'+y).val(data.tabs[y-1].font_title).trigger('change').trigger('select2:select');
                $('#font_subtitle_'+data.layout+'_'+y).val(data.tabs[y-1].font_subtitle).trigger('change').trigger('select2:select');
                $('#font_description_'+data.layout+'_'+y).val(data.tabs[y-1].font_description).trigger('change').trigger('select2:select');
                $('#font_button_'+data.layout+'_'+y).val(data.tabs[y-1].font_button).trigger('change').trigger('select2:select');
            }
        }

        function zerarCampos(){
            for (var i = 1; i <= $block_quantity; i++){
                $('.color-input-box').css('background-color', '#151624');
                $('#margin_top_'+i).val(15);
                $('#margin_bottom_'+i).val(15);
                $('#title_'+i).val(null);
                $('#subtitle_'+i).val(null);
                $('#tag_'+i).val(null);
                $('#content_'+i).val(null);
                $('#content_type_'+i).val(null).trigger('change');
                $('#display_content_'+i).val(null).trigger('change');
                $('#content_alignment_'+i).val(null).trigger('change');
                $('#content_link_'+i).val(null);
                $('#image_'+i).val(null);
                $('#proportion_'+i).val(null).trigger('change');
                $('#button_display_'+i).prop('checked', false).trigger('change');
                $('#button_title_'+i).val(null);
                $('#button_type'+i).val(null).trigger('change');
                $('#button_link_'+i).val(null);
                $('#button_type_'+i).val(null).trigger('change');
                $('#button_pagina_'+i).val(null).trigger('change');
                $('#button_url_'+i).val(null);
                $('#div-button-link-'+i).hide();
                $('#div-url-link-'+i).hide();
                $('#button_display1_'+i).prop('checked', false).trigger('change');
                $('#button_title1_'+i).val(null);
                $('#button_type1_'+i).val(null).trigger('change');
                $('#button_link1_'+i).val(null);
                $('#button_pagina1_'+i).val(null).trigger('change');
                $('#button_url1_'+i).val(null);
                $('#div1-button-link-'+i).hide();
                $('#div1-url-link-'+i).hide();
                $('#divider_display_'+i).prop('checked', false).trigger('change');
                $('#divider_'+i).val(null).trigger('change');
                $('#date_'+i).val(null);
                $('#value_of_'+i).val(null);
                $('#value_by_'+i).val(null);
                $('#div-value-of-'+i).hide();
                $('#div-value-by-'+i).hide();
                $('#initial_value_'+i).val(null);
                $('#final_value_'+i).val(null);
                $('#display_pdf_'+i).prop('checked', false).trigger('change');
                $('#pdf_title_'+i).val(null);
                $('#pdf_'+i).val(null);
                $('#logo_display_'+i).prop('checked', false).trigger('change');
                $('#logo_title_'+i).val(null);
                $('#logo_'+i).val(null);
                $('#blogs_model_'+i).val(1).trigger('change');
                $('#blog_category_'+i).val(null).trigger('change');
                $('#blogs_'+i).val(null).trigger('change');
                $('#testimonial_category_'+i).val(null).trigger('change');
                $('#testimonials_'+i).val(null).trigger('change');
                $('#faq_category_'+i).val(null).trigger('change');
                $('#faqs_'+i).val(null).trigger('change');
                $('#is_topic_'+i).val(null).trigger('change');
                $('#topic_category_'+i).val(null).trigger('change');
                $('#topics_categories_'+i).val(null).trigger('change');
                $('#topics_'+i).val(null);
                $('#logos_category_'+i).val(null).trigger('change');
                $('#events_'+i).val(null).trigger('change');
                $('#galleries_'+i).val(null).trigger('change');
                $('#alerts_'+i).val(null).trigger('change');
                $('#type_'+i).val(null).trigger('change');
                $('#cards_categories_'+i).val(null).trigger('change');
                $('#pages_'+i).val(null).trigger('change');
                $('#email_'+i).val(null).trigger('change');
                $('#portfolios_categories_'+i).val(null).trigger('change');
                $('#portfolios_'+i).val(null).trigger('change');
                for (var y = 1; y <= 6; y++){
                    $('#title_'+i+'_'+y).val(null);
                    $('#subtitle_'+i+'_'+y).val(null);
                    $('#content_'+i+'_'+y).val(null);
                    $('#content_alignment_'+i+'_'+y).val(null).trigger('change');
                    $('#content_type_'+i+'_'+y).val(null).trigger('change');
                    $('#display_content_'+i+'_'+y).val(null).trigger('change');
                    $('#content_link_'+i+'_'+y).val(null);
                    $('#image_'+i+'_'+y).val(null);
                    $('#display_image_'+i+'_'+y).val(null).trigger('change');
                    $('#button_display_'+i+'_'+y).prop('checked', false).trigger('change');
                    $('#button_title_'+i+'_'+y).val(null);
                    $('#button_type'+i+'_'+y).val(null).trigger('change');
                    $('#button_type_'+i+'_'+y).val(null).trigger('change');
                    $('#button_link_'+i+'_'+y).val(null);
                    $('#button_pagina_'+i+'_'+y).val(null).trigger('change');
                    $('#button_url_'+i+'_'+y).val(null);
                    $('#div-button-link-'+i+'-'+y).hide();
                    $('#div-url-link-'+i+'-'+y).hide();
                    $('#button_display1_'+i+'_'+y).prop('checked', false).trigger('change');
                    $('#button_title1_'+i+'_'+y).val(null);
                    $('#button_type1_'+i+'_'+y).val(null).trigger('change');
                    $('#button_link1_'+i+'_'+y).val(null);
                    $('#button_pagina1_'+i+'_'+y).val(null).trigger('change');
                    $('#button_url1_'+i+'_'+y).val(null);
                    $('#div1-button-link-'+i+'-'+y).hide();
                    $('#div1-url-link-'+i+'-'+y).hide();
                    $('#date_'+i+'_'+y).val(null);
                    $('#hour_'+i+'_'+y).val(null);
                    $('#month_'+i+'_'+y).val(0).trigger('change');
                    $('#icon_'+i+'_'+y).val(null);
                    $('#number_'+i+'_'+y).val(null);
                    $('#divider_'+i+'_'+y).val(null).trigger('change');
                    $('#divider_display_'+i+'_'+y).prop('checked', false).trigger('change');
                    $('#value_of_'+i+'_'+y).val(null);
                    $('#value_by_'+i+'_'+y).val(null);
                    $('#div-page-value-'+i+'-'+y).hide();
                    $('#div-value-of-'+i+'-'+y).hide();
                    $('#div-value-by-'+i+'-'+y).hide();
                    $('#initial_value_'+i+'_'+y).val(null);
                    $('#final_value_'+i+'_'+y).val(null);
                    $('#card_categories_'+i+'_'+y).val(null).trigger('change');
                    $('#type_'+i+'_'+y).val(null).trigger('change');
                }
            }
        }

        function showContent(layout){
            for (var i = 1; i <= $block_quantity; i++){
                if (layout ==  i){
                    $('#content-'+i).show();
                }else{
                    $('#content-'+i).hide();
                }
            }
        }

        function showLayout(layout){
            for (var i = 1; i <= $block_quantity; i++){
                if (layout == i){
                    $('#div-layout-'+i).show();
                }else{
                    $('#div-layout-'+i).hide();
                }
            }
        }

        function openAlert(title, message, type) {
            Swal.fire({
                title: title,
                text: message,
                icon: type,
                showCancelButton: 0,
                buttonsStyling: !1,
                confirmButtonText: "Ok!",
                customClass: {
                    confirmButton: "btn fw-bold btn-primary"
                }
            }).then(function (){
                if(message === 'Bloco salvo com sucesso'){
                    location.reload();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            $('#testimonials_18').select2({
                maximumSelectionLength: 1,
                placeholder: "Selecione uma opção",
                allowClear: true
            });
            $('#testimonials_51').select2({
                maximumSelectionLength: 1,
                placeholder: "Selecione uma opção",
                allowClear: true
            });
        });
    </script>

    {{-- SCRIPTS INTERNO DO BLOCO --}}
    <script>
        function editorCK(){
            let layout = document.querySelector('.btn-check:checked').value;

            //Se não tiver esse bloco no array de blocos a ser ignorados, ele cria um ckeditor
            if (!ignoreCkeditorBlocks.includes(parseInt(layout))){
                let editor;
                ClassicEditor.create(document.querySelector( '#content_' + layout ), {
                    language: 'pt-br',
                    removePlugins: ['Title'],
                    placeholder: '',
                    link: {
                        addTargetToExternalLinks: true // Esta configuração adiciona target="_blank" a todos os links externos.
                    }
                }).then( newEditor => {
                    newEditor.model.document.on('change', () => {
                        editor.getData();
                        $('#content_' + layout ).val(editor.getData())
                    });
                    editor = newEditor;
                }).catch( error => {});
            }

            let topics;
            ClassicEditor.create(document.querySelector( '#topics_' + layout ), {
                language: 'pt-br',
                removePlugins: ['Title'],
                placeholder: '',
                link: {
                    addTargetToExternalLinks: true // Esta configuração adiciona target="_blank" a todos os links externos.
                }
            }).then( newEditor => {
                newEditor.model.document.on('change', () => {
                    topics.getData();
                    $('#topics_' + layout ).val(topics.getData())
                });
                topics = newEditor;
            }).catch( error => {});

            for (let l = 1;l <= 6;l++) {
                let editor;
                ClassicEditor.create(document.querySelector( '#content_' + layout + '_' + l), {
                    language: 'pt-br',
                    removePlugins: ['Title'],
                    placeholder: '',
                    link: {
                        addTargetToExternalLinks: true // Esta configuração adiciona target="_blank" a todos os links externos.
                    }
                }).then( newEditor => {
                    newEditor.model.document.on('change', () => {
                        editor.getData();
                        $('#content_' + layout + '_' + l ).val(editor.getData())
                    });
                    editor = newEditor;
                }).catch( error => {});
                let topics;
                ClassicEditor.create(document.querySelector( '#topics_' + layout + '_' + l), {
                    language: 'pt-br',
                    removePlugins: ['Title'],
                    placeholder: '',
                    link: {
                        addTargetToExternalLinks: true // Esta configuração adiciona target="_blank" a todos os links externos.
                    }
                }).then( newEditor => {
                    newEditor.model.document.on('change', () => {
                        topics.getData();
                        $('#topics_' + layout + '_' + l ).val(topics.getData())
                    });
                    topics = newEditor;
                }).catch( error => {});
            }
        }

        function destroyCK() {
            let ck = document.querySelectorAll('.ck-editor__editable')
            ck.forEach(function (ck){
                ck.ckeditorInstance.destroy();
            })
        }

        function changeContentType(layout, content_type, tab = 0){
            if (content_type.value === 'image' || content_type.value === 'youtube_embed'){
                if (content_type.value === 'image') {
                    $(`#label_url_${layout}`+(tab > 0 ? `_${tab}`:``)).removeClass('required')
                }
                if (content_type.value === 'youtube_embed'){
                    $(`#label_url_${layout}`+(tab > 0 ? `_${tab}`:``)).addClass('required')
                }
                $(`#image_${layout}`+(tab > 0 ? `_${tab}`:``)).fadeIn(150);
                $(`#video_${layout}`+(tab > 0 ? `_${tab}`:``)).hide();
                $(`#label_content_type_${layout}`+(tab > 0 ? `_${tab}`:``)).html('Imagem').fadeIn(150);
            }else if(content_type.value === 'video'){
                $(`#image_${layout}`+(tab > 0 ? `_${tab}`:``)).hide();
                $(`#video_${layout}`+(tab > 0 ? `_${tab}`:``)).fadeIn(150);
                $(`#label_content_type_${layout}`+(tab > 0 ? `_${tab}`:``)).html('Vídeo').fadeIn(150);
            }else{
                $(`#image_${layout}`+(tab > 0 ? `_${tab}`:``)).hide();
                $(`#video_${layout}`+(tab > 0 ? `_${tab}`:``)).hide();
                $(`#label_content_type_${layout}`+(tab > 0 ? `_${tab}`:``)).hide();
            }
        }

        function changeButtonDisplay(button_display, block, tab, is_button_one){
            if ($(button_display).is(':checked')) {
                $(`#div`+(is_button_one ? `1`:``)+`-button-title-${block}`+(tab > 0 ? `-${tab}`:``)).show();
                $(`#div`+(is_button_one ? `1`:``)+`-button-type-${block}`+(tab > 0 ? `-${tab}`:``)).show();
                $(`#button_type`+(is_button_one ? `1`:``)+`_${block}`+(tab > 0 ? `_${tab}`:``)).trigger('change');
            } else {
                $(`#div`+(is_button_one ? `1`:``)+`-button-title-${block}`+(tab > 0 ? `-${tab}`:``)).hide();
                $(`#div`+(is_button_one ? `1`:``)+`-button-type-${block}`+(tab > 0 ? `-${tab}`:``)).hide();
                $(`#div`+(is_button_one ? `1`:``)+`-button-link-${block}`+(tab > 0 ? `-${tab}`:``)).hide();
                $(`#div`+(is_button_one ? `1`:``)+`-url-link-${block}`+(tab > 0 ? `-${tab}`:``)).hide();
            }
        }

        function changeButtonType(button_type, block, tab, is_button_one){
            if (!$(`#button_display`+(is_button_one ? `1`:``)+`_${block}`+(tab > 0 ? `_${tab}`:``)).is(':checked')){
                $(`#div`+(is_button_one ? `1`:``)+`-button-link-${block}`+(tab > 0 ? `-${tab}`:``)).hide();
                $(`#div`+(is_button_one ? `1`:``)+`-url-link-${block}`+(tab > 0 ? `-${tab}`:``)).hide();
            }else if (button_type.value === 'inner_page') {
                $(`#div`+(is_button_one ? `1`:``)+`-button-link-${block}`+(tab > 0 ? `-${tab}`:``)).show();
                $(`#div`+(is_button_one ? `1`:``)+`-url-link-${block}`+(tab > 0 ? `-${tab}`:``)).hide();
            }else if (button_type.value === 'link') {
                $(`#div`+(is_button_one ? `1`:``)+`-button-link-${block}`+(tab > 0 ? `-${tab}`:``)).hide();
                $(`#div`+(is_button_one ? `1`:``)+`-url-link-${block}`+(tab > 0 ? `-${tab}`:``)).show();
            }else{
                $(`#div`+(is_button_one ? `1`:``)+`-button-link-${block}`+(tab > 0 ? `-${tab}`:``)).hide();
                $(`#div`+(is_button_one ? `1`:``)+`-url-link-${block}`+(tab > 0 ? `-${tab}`:``)).hide();
            }
        }

        var last_valid_courses34 = null;
        $('#pages_34').on("select2:select", function (evt) {
            var element = evt.params.data.element;
            var $element = $(element);

            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
        }).on('change', function (){
            last_valid_courses34 = $(this).val();
            $(this).val(last_valid_courses34);
        });

        {{--@for ($i = 1; $i <= $block_quantity; $i++)
            $('#topics_categories_{{ $i }}').select2({
                dropdownParent: $('#block_modal')
            });

            $('#is_topic_{{ $i }}').change(function(event) {
                if ($(this).val() === '0') {
                    $('#div-category-faq-{{ $i }}').show();
                    $('#div-topics-categories-{{ $i }}').hide();
                } else if($(this).val() === '1') {
                    $('#div-category-faq-{{ $i }}').hide();
                    $('#div-topics-categories-{{ $i }}').show();
                }else{
                    $('#div-category-faq{{ $i }}').hide();
                    $('#div-topics-categories-{{ $i }}').hide();
                }
            })

            $('#display_pdf_{{ $i }}').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#div-pdf-title-{{ $i }}').show();
                    $('#div-pdf-{{ $i }}').show();
                } else {
                    $('#div-pdf-title-{{ $i }}').hide();
                    $('#div-pdf-{{ $i }}').hide();
                }
            })

            $('#logo_display_{{ $i }}').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#div-logo-title-{{ $i }}').show();
                    $('#div-logo-{{ $i }}').show();
                } else {
                    $('#div-logo-title-{{ $i }}').hide();
                    $('#div-logo-{{ $i }}').hide();
                }
            })
        @endfor--}}
    </script>

    {{-- SCRIPT BOX SELECT BLOCK --}}
    <script>
        $(document).on('click', function(event) {
            if (!$(event.target).closest('.colors-box').length && !$(event.target).hasClass(
                'color-select')) {
                $('.colors-box').css('display', 'none');
            }
        });

        $('.color-box').on('click', function() {
            $('.colors-box').not($(this).children('.colors-box')).css('display', 'none');
            $(this).children('.colors-box').css('display', 'flex');
        });

        $('.colors-box div').on('click', function() {
            var color = $(this).css('background-color');
            $(this).closest('.color-box').find('.color-select').css('background-color', color);
            console.log($(this).siblings('.color-select'));
            $(this).parent().fadeOut(100);
        });
    </script>
@endpush
