@extends('admin.layout')
@push('head')
    <link rel="stylesheet" href="{{ asset('ckeditor/sample/custom.css') }}">
    <style>

        .color-input-box {
            position: relative !important;
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

        .filters .card {
            border: 3px solid #FFF;
        }

        [data-theme="dark"] .filters .card {
            border: 3px solid #1e1e2d;
        }

        .filters .card.hover-danger:hover,
        .filters .card.hover-danger.active {
            border: 3px solid #f1416c;
        }

        .filters .card.hover-success:hover,
        .filters .card.hover-success.active {
            border: 3px solid #50cd89;
        }

        {{--.avatar {
            position: relative;
            height: 146px;
            width: 540px;
            background: var(--kt-card-bg);
            border-radius: 8px;
        }

        .avatar img {
            max-width: 540px;
            max-height: 146px;
            border-radius: 8px;
        }

        .avatar .options {
            width: 30px;
            background: rgba(0, 0, 0, 0.8);
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
            background: rgba(0, 0, 0, 0.8);
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
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
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

        .contentCroppie {
            background: #FFF;
        }

        [data-theme="dark"] .contentCroppie {
            background: #1e1e2d;
        }--}}
    </style>
@endpush
@section('content')
    <!--begin::Form-->
    <div class="d-flex flex-column flex-lg-row">
        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <!--begin:::Tabs-->
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2">
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a id="btn-tab-menu" class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#tab-menu">Menu</a>
                </li>
                <!--end:::Tab item-->
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a id="btn-tab-menu" class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#tab-fonts">Fontes</a>
                </li>
                <!--end:::Tab item-->
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a id="btn-tab-menu" class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#tab-cookie">Cookie</a>
                </li>
                <!--end:::Tab item-->
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a id="btn-tab-menu" class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#tab-colors">Cores</a>
                </li>
                <!--end:::Tab item-->
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a id="btn-tab-menu" class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#tab-scripts">Scripts</a>
                </li>
                <!--end:::Tab item-->
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a id="btn-tab-menu" class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#tab-integracoes">Integrações</a>
                </li>
                <!--end:::Tab item-->
            </ul>
            <!--end:::Tabs-->
            <!--begin::Tab content-->
            <div class="tab-content">
                <!--begin::Tab pane-->
                <div class="tab-pane fade show active" id="tab-menu" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <!--begin::General options-->
                        <div class="card py-4">
                            <div class="card-header card-header-stretch">
                                <div class="card-title">
                                    <h2>Menu</h2>
                                </div>
                                <div class="card-toolbar">
                                    <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#menu-items">Itens de menu</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#menu-settings">Layouts de menu</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--begin::Card body-->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="menu-items" role="tabpanel">
                                        <!--begin::Card toolbar-->
                                        <div class="w-100 d-flex flex-row-fluid justify-content-end gap-5 mb-8">
                                            <!--begin::Add product-->
                                            <button type="button" onclick="openMenuModal(null, null)" class="btn btn-primary">
                                                Criar menu
                                            </button>
                                            <!--end::Add product-->
                                        </div>
                                        <!--end::Card toolbar-->
                                        <!--begin::Table-->
                                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                                            <!--begin::Table head-->
                                            <thead>
                                            <!--begin::Table row-->
                                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                <th class="w-10px"></th>
                                                <th>Título</th>
                                                <th class="text-center w-150px">Ações</th>
                                            </tr>
                                            <!--end::Table row-->
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody class="fw-semibold text-gray-600" id="body-menu">
                                            @foreach($groups as $group)
                                                <!--begin::Table row-->
                                                <tr>
                                                    <td>
                                                        @if($group->default)
                                                            <i class="fas fa-star text-warning"></i>
                                                        @endif
                                                    </td>
                                                    <!--begin::Título=-->
                                                    <td>
                                                        <span class="text-gray-800 fs-5 fw-bold">{{ $group->title }}</span>
                                                    </td>
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
                                                                <a href="{{ route('admin.settings.group.show', $group->hash_id) }}" class="menu-link px-3">Editar</a>
                                                            </div>
                                                            <!--end::Menu item-->
                                                            <!--begin::Menu item-->
                                                            <div class="menu-item px-3">
                                                                <a href="{{ route('admin.settings.group.default', $group->hash_id) }}" class="menu-link px-3">Padrão</a>
                                                            </div>
                                                            <!--end::Menu item-->
                                                            <!--begin::Menu item-->
                                                            <div class="menu-item px-3">
                                                                <a href="javascript:void(0)" onclick="openMenuModal('{{ $group->hash_id }}', '{{ $group->title }}')" class="menu-link px-3">Renomear</a>
                                                            </div>
                                                            <!--end::Menu item-->
                                                            <!--begin::Menu item-->
                                                            <div class="menu-item px-3">
                                                                <a href="javascript:void(0)" onclick="destroyMenu('{{ $group->hash_id }}')" class="menu-link px-3">Excluir</a>
                                                            </div>
                                                            <!--end::Menu item-->
                                                        </div>
                                                        <!--end::Menu-->
                                                    </td>
                                                    <!--end::Action=-->
                                                </tr>
                                                <!--end::Table row-->
                                            @endforeach
                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                    <div class="tab-pane fade" id="menu-settings" role="tabpanel">
                                        <!--begin::Card toolbar-->
                                        <div class="w-100 d-flex flex-row-fluid justify-content-end gap-5 mb-8">
                                            <!--begin::Add product-->
                                            <a href="{{ route('admin.settings.menu.create') }}" class="btn btn-primary">
                                                Criar layout
                                            </a>
                                            <!--end::Add product-->
                                        </div>
                                        <!--end::Card toolbar-->
                                        <!--begin::Table-->
                                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                                            <!--begin::Table head-->
                                            <thead>
                                                <!--begin::Table row-->
                                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                    <th class="w-10px"></th>
                                                    <th>Título</th>
                                                    <th>Layout</th>
                                                    <th class="text-center w-150px">Ações</th>
                                                </tr>
                                                <!--end::Table row-->
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody class="fw-semibold text-gray-600" id="body-menu">
                                            @foreach($menus as $menuItem)
                                                <!--begin::Table row-->
                                                <tr>
                                                    <td>
                                                        @if($menuItem->default)
                                                            <i class="fas fa-star text-warning"></i>
                                                        @endif
                                                    </td>
                                                    <!--begin::Título=-->
                                                    <td>
                                                        <span class="text-gray-800 fs-5 fw-bold">{{ $menuItem->title }}</span>
                                                    </td>
                                                    <!--end::Título=-->
                                                    <!--begin::Tipo=-->
                                                    <td>
                                                        <span class="text-gray-800 fs-5 fw-bold">Layout {{ $menuItem->layout }}</span>
                                                    </td>
                                                    <!--end::Tipo=-->
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
                                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                            data-kt-menu="true">
                                                            <!--begin::Menu item-->
                                                            <div class="menu-item px-3">
                                                                <a href="{{ route('admin.settings.menu.default', $menuItem->hash_id) }}" class="menu-link px-3">Padrão</a>
                                                            </div>
                                                            <!--end::Menu item-->
                                                            <!--begin::Menu item-->
                                                            <div class="menu-item px-3">
                                                                <a href="{{ route('admin.settings.menu.edit', $menuItem->hash_id) }}" class="menu-link px-3">Editar</a>
                                                            </div>
                                                            <!--end::Menu item-->
                                                            <!--begin::Menu item-->
                                                            <div class="menu-item px-3">
                                                                <span onclick="deleteMenu('{{ $menuItem->hash_id }}')" class="menu-link px-3">Excluir</span>
                                                            </div>
                                                            <!--end::Menu item-->
                                                        </div>
                                                        <!--end::Menu-->
                                                    </td>
                                                    <!--end::Action=-->
                                                </tr>
                                                <!--end::Table row-->
                                            @endforeach
                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                </div>
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->
                    </div>
                </div>
                <!--end::Tab pane-->
                <!--begin::Tab pane-->
                <div class="tab-pane fade" id="tab-fonts" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <!--begin::General options-->
                        <div class="card py-4">
                            <div class="card-header card-header-stretch">
                                <div class="card-title">
                                    <h2>Fontes</h2>
                                </div>
                            </div>
                            <!--begin::Card body-->
                            <div class="card-body">
                                <div class="tab-content">
                                    <!--begin::Card toolbar-->
                                    <div class="w-100 d-flex flex-row-fluid justify-content-end gap-5 mb-8">
                                        <!--begin::Add product-->
                                        <a href="{{ route('admin.settings.fonts.create') }}" class="btn btn-primary">
                                            Adicionar item
                                        </a>
                                        <!--end::Add product-->
                                    </div>
                                    <!--end::Card toolbar-->
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                                        <!--begin::Table head-->
                                        <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th class="w-10px"></th>
                                            <th>Perfil</th>
                                            <th>Tipo</th>
                                            <th class="text-center w-150px">Ações</th>
                                        </tr>
                                        <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-semibold text-gray-600" id="body-menu">
                                        @foreach($fonts as $font)
                                            <!--begin::Table row-->
                                            <tr>
                                                <td>
                                                    @if($font->default)
                                                        <i class="fas fa-star text-warning"></i>
                                                    @endif
                                                </td>
                                                <!--begin::Perfil-->
                                                <td>
                                                    <span class="text-gray-800 fs-5 fw-bold">{{ $font->profile }}</span>
                                                </td>
                                                <!--end::Perfil-->
                                                <!--begin::Tipo-->
                                                <td>
                                                    @if($font->type == 'title')
                                                        Título
                                                    @elseif($font->type == 'description')
                                                        Descrição
                                                    @elseif($font->type == 'button')
                                                        Botão
                                                    @endif
                                                </td>
                                                <!--end::Tipo-->
                                                <!--begin::Action-->
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
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                         data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="{{ route('admin.settings.fonts.default', $font->hash_id) }}" class="menu-link px-3">Padrão</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="{{ route('admin.settings.fonts.edit', $font->hash_id) }}" class="menu-link px-3">Editar</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <span onclick="deleteFont('{{ $font->hash_id }}')" class="menu-link px-3">Excluir</span>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu-->
                                                </td>
                                                <!--end::Action-->
                                            </tr>
                                            <!--end::Table row-->
                                        @endforeach
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->
                    </div>
                </div>
                <!--end::Tab pane-->
                <!--begin::Tab pane-->
                <div class="tab-pane fade show" id="tab-cookie" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <!--begin::General options-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Alerta de cookie</h2>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Input group-->
                                <div class="mb-10 row">
                                    <div class="col-6">
                                        <!--begin::Label-->
                                        <label class="required form-label">Título</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" id="cookie-title" class="form-control mb-2" placeholder="Título"
                                               value="{{ $cookie->title }}"/>
                                        <!--end::Input-->
                                        <!--begin::Description-->
                                        <div class="text-muted fs-7">Um título é obrigatório.</div>
                                        <!--end::Description-->
                                    </div>
                                    <div class="col-6">
                                        <!--begin::Label-->
                                        <label class="required form-label">Exibir?</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <select class="form-select" id="cookie-status" data-control="select2" data-placeholder="Selecione uma opção">
                                            <option value="1" {{ $cookie->status ? 'selected':'' }}>Sim</option>
                                            <option value="0" {{ !$cookie->status ? 'selected':'' }}>Não</option>
                                        </select>
                                        <!--end::Input-->
                                    </div>
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="mb-10 fv-row">
                                    <!--begin::Label-->
                                    <label class="form-label">Descrição</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <textarea type="text" id="cookie-description" class="form-control" rows="4"
                                              style="resize: none">{!! nl2br($cookie->description) !!}</textarea>
                                    <!--end::Input-->
                                    <!--begin::Description-->
                                    <div class="text-muted fs-7 mt-2">Uma descrição é obrigatória.</div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="fv-row">
                                    <!--begin::Label-->
                                    <label class="form-label">Fundo</label>
                                    <!--end::Label-->
                                    <div class="colors-parent-box mb-10">
                                        <div class="color-box-parent">
                                            <div class="color-box">
                                                <!--begin::Label-->
                                                <p>Fundo</p>
                                                <!--end::Label-->
                                                <div class="color-select" style="background-color: {{$cookie->color}}" id="cookie-color"></div>
                                                <div class="colors-box">
                                                    @foreach($colors as $color)
                                                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--begin::Label-->
                                    <label class="form-label">Recusar</label>
                                    <!--end::Label-->
                                    <div class="colors-parent-box mb-10">
                                        <div class="color-box-parent">
                                            <div class="color-box">
                                                <!--begin::Label-->
                                                <p>Fundo</p>
                                                <!--end::Label-->
                                                <div class="color-select" style="background-color: {{$cookie->button_decline_color}}" id="cookie-decline-color"></div>
                                                <div class="colors-box">
                                                    @foreach($colors as $color)
                                                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="color-box-parent">
                                            <div class="color-box">
                                                <!--begin::Label-->
                                                <p>Borda</p>
                                                <!--end::Label-->
                                                <div class="color-select" style="background-color: {{$cookie->button_decline_border_color}}" id="cookie-decline-border-color"></div>
                                                <div class="colors-box">
                                                    @foreach($colors as $color)
                                                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="color-box-parent">
                                            <div class="color-box">
                                                <!--begin::Label-->
                                                <p>Texto</p>
                                                <!--end::Label-->
                                                <div class="color-select" style="background-color: {{$cookie->button_decline_title_color}}" id="cookie-decline-title-color"></div>
                                                <div class="colors-box">
                                                    @foreach($colors as $color)
                                                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--begin::Label-->
                                    <label class="form-label">Recusar (Hover)</label>
                                    <!--end::Label-->
                                    <div class="colors-parent-box mb-10">
                                        <div class="color-box-parent">
                                            <div class="color-box">
                                                <!--begin::Label-->
                                                <p>Fundo</p>
                                                <!--end::Label-->
                                                <div class="color-select" style="background-color: {{$cookie->button_hover_decline_color}}" id="cookie-hover-decline-color"></div>
                                                <div class="colors-box">
                                                    @foreach($colors as $color)
                                                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="color-box-parent">
                                            <div class="color-box">
                                                <!--begin::Label-->
                                                <p>Borda</p>
                                                <!--end::Label-->
                                                <div class="color-select" style="background-color: {{$cookie->button_hover_decline_border_color}}" id="cookie-hover-decline-border-color"></div>
                                                <div class="colors-box">
                                                    @foreach($colors as $color)
                                                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="color-box-parent">
                                            <div class="color-box">
                                                <!--begin::Label-->
                                                <p>Texto</p>
                                                <!--end::Label-->
                                                <div class="color-select" style="background-color: {{$cookie->button_hover_decline_title_color}}" id="cookie-hover-decline-title-color"></div>
                                                <div class="colors-box">
                                                    @foreach($colors as $color)
                                                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--begin::Label-->
                                    <label class="form-label">Aceitar</label>
                                    <!--end::Label-->
                                    <div class="colors-parent-box mb-10">
                                        <div class="color-box-parent">
                                            <div class="color-box">
                                                <!--begin::Label-->
                                                <p>Fundo</p>
                                                <!--end::Label-->
                                                <div class="color-select" style="background-color: {{$cookie->button_accept_color}}" id="cookie-accept-color"></div>
                                                <div class="colors-box">
                                                    @foreach($colors as $color)
                                                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="color-box-parent">
                                            <div class="color-box">
                                                <!--begin::Label-->
                                                <p>Borda</p>
                                                <!--end::Label-->
                                                <div class="color-select" style="background-color: {{$cookie->button_accept_border_color}}" id="cookie-accept-border-color"></div>
                                                <div class="colors-box">
                                                    @foreach($colors as $color)
                                                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="color-box-parent">
                                            <div class="color-box">
                                                <!--begin::Label-->
                                                <p>Texto</p>
                                                <!--end::Label-->
                                                <div class="color-select" style="background-color: {{$cookie->button_accept_title_color}}" id="cookie-accept-title-color"></div>
                                                <div class="colors-box">
                                                    @foreach($colors as $color)
                                                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--begin::Label-->
                                    <label class="form-label">Aceitar (Hover)</label>
                                    <!--end::Label-->
                                    <div class="colors-parent-box">
                                        <div class="color-box-parent">
                                            <div class="color-box">
                                                <!--begin::Label-->
                                                <p>Fundo</p>
                                                <!--end::Label-->
                                                <div class="color-select" style="background-color: {{$cookie->button_hover_accept_color}}" id="cookie-hover-accept-color"></div>
                                                <div class="colors-box">
                                                    @foreach($colors as $color)
                                                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="color-box-parent">
                                            <div class="color-box">
                                                <!--begin::Label-->
                                                <p>Borda</p>
                                                <!--end::Label-->
                                                <div class="color-select" style="background-color: {{$cookie->button_hover_accept_border_color}}" id="cookie-hover-accept-border-color"></div>
                                                <div class="colors-box">
                                                    @foreach($colors as $color)
                                                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="color-box-parent">
                                            <div class="color-box">
                                                <!--begin::Label-->
                                                <p>Texto</p>
                                                <!--end::Label-->
                                                <div class="color-select" style="background-color: {{$cookie->button_hover_accept_title_color}}" id="cookie-hover-accept-title-color"></div>
                                                <div class="colors-box">
                                                    @foreach($colors as $color)
                                                        <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->
                        <div class="d-flex justify-content-end mt-10">
                            <!--begin::Button-->
                            <button type="submit" id="btn-submit-cookie" class="btn btn-primary">
                                <span class="indicator-label">Salvar</span>
                                <span class="indicator-progress">
                                Aguarde...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                            </button>
                            <!--end::Button-->
                        </div>
                    </div>
                </div>
                <!--end::Tab pane-->
                <!--begin::Tab pane-->
                <div class="tab-pane fade" id="tab-colors" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <!--begin::Header options-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Cores</h2>
                                </div>
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                    <!--begin::Add product-->
                                    <button type="button" onclick="openColorModal(null)" class="btn btn-primary">
                                        Adicionar item
                                    </button>
                                    <!--end::Add product-->
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="fv-row">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                                        <!--begin::Table head-->
                                        <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th>Cor</th>
                                            <th class="text-center">Título</th>
                                            <th class="text-center">Conteúdo</th>
                                            <th class="text-center">Ícone</th>
                                            <th class="text-center min-w-100px">Ações</th>
                                        </tr>
                                        <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-semibold text-gray-600" id="body-menu">
                                        @foreach(\App\Models\Settings\Color::all() as $color)
                                            <tr>
                                                <td>
                                                    <div class="color-input-box rounded-circle w-35px h-35px"
                                                         style="border: solid 1px white; margin-right: 12px; cursor: pointer; background-color: {{ $color->color }}"></div>
                                                </td>
                                                <td class="pe-0 text-center">
                                                    Light: {{ $color->is_default_title_light ? 'Sim':'Não' }} /
                                                    Dark: {{ $color->is_default_title_dark ? 'Sim':'Não' }}
                                                </td>
                                                <td class="pe-0 text-center">
                                                    Light: {{ $color->is_default_content_light ? 'Sim':'Não' }} /
                                                    Dark: {{ $color->is_default_content_dark ? 'Sim':'Não' }}
                                                </td>
                                                <td class="pe-0 text-center">
                                                    Light: {{ $color->is_default_icon_light ? 'Sim':'Não' }} /
                                                    Dark: {{ $color->is_default_icon_dark ? 'Sim':'Não' }}
                                                </td>
                                                <td class="text-center">
                                                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                                       data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                        Ações
                                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                        <span class="svg-icon svg-icon-5 m-0">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                                    fill="currentColor"/>
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </a>
                                                    <!--begin::Menu-->
                                                    <div
                                                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                        data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a onclick="openColorModal({{ $color->id }})"
                                                               class="menu-link px-3">Editar</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a class="menu-link px-3"
                                                               onclick="removeColor('{{ $color->id }}')">Excluir</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu-->
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Header options-->
                    </div>
                </div>
                <!--end::Tab pane-->
                <!--begin::Tab pane-->
                <div class="tab-pane fade" id="tab-scripts" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <!--begin::Header options-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>Scripts</h2>
                                </div>
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                                    <!--begin::Add product-->
                                    <button type="button" onclick="openScriptModal(null)" class="btn btn-primary">
                                        Adicionar item
                                    </button>
                                    <!--end::Add product-->
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <div class="fv-row">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                                        <!--begin::Table head-->
                                        <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th>Título</th>
                                            <th>Posição</th>
                                            <th>Exibir no mobile</th>
                                            <th>Script</th>
                                            <th class="text-center w-100px">Ações</th>
                                        </tr>
                                        <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-semibold text-gray-600" id="body-menu">
                                        @foreach($scripts as $script)
                                            <tr>
                                                <td>{{ $script->title }}</td>
                                                <td>{{ ucfirst($script->position) }}</td>
                                                <td>{{ $script->show_mobile ? 'Sim':'Não' }}</td>
                                                <td>{{ Str::limit($script->script, 50, '...') }}</td>
                                                <td class="text-center">
                                                    <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                                       data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                        Ações
                                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                        <span class="svg-icon svg-icon-5 m-0">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                                    fill="currentColor"/>
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </a>
                                                    <!--begin::Menu-->
                                                    <div
                                                        class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                        data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a onclick="openScriptModal({{ $script->id }})"
                                                               class="menu-link px-3">Editar</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a class="menu-link px-3"
                                                               onclick="removeScript('{{ $script->id }}')">Excluir</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu-->
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Header options-->
                    </div>
                </div>
                <!--end::Tab pane-->
                <!--begin::Tab pane-->
                <div class="tab-pane fade" id="tab-integracoes" role="tab-panel">
                    <div class="row filters mt-8">
                        <div class="col-md-3 mb-6">
                            <div class="card p-7 hover-success align-items-center text-center cursor-pointer" style="position: relative" onclick="editIntegration(0);">
                                <i class="fas fa-info-circle" style="position: absolute; right: 10%; top: 10%"
                                   data-bs-toggle="tooltip" data-bs-html="true" title="Impetus Sistemas"
                                   data-bs-delay-hide="1000"></i>
                                <img class="mb-4" src="{{ asset('images/admin/integrations/impetus.svg') }}" style="width: 28px; height: 28px">
                                <span class="fs-4 text-muted mb-4">Impetus Sistemas</span>
                                <!--begin::Badges-->
                                <div>
                                    <div class="badge badge-light-success">Integrado</div>
                                </div>
                                <!--end::Badges-->
                            </div>
                        </div>
                        @foreach($integrations as $integration)
                            @php $status = $integration->status ? 'success':'danger'; @endphp
                            <div class="col-md-3 mb-6">
                                <div class="card p-7 hover-{{ $status }} align-items-center text-center cursor-pointer" style="position: relative" onclick="editIntegration({{ $integration->id }});">
                                    <i class="fas fa-info-circle" style="position: absolute; right: 10%; top: 10%"
                                       data-bs-toggle="tooltip" data-bs-html="true" title="{{ $integration->documentation }}"
                                       data-bs-delay-hide="1000"></i>
                                    <img class="mb-4" src="{{ asset('images/admin/integrations/'.$integration->title.'.svg') }}" style="width: 28px; height: 28px">
                                    <span class="fs-4 text-muted mb-4">{{ $integration->title }}</span>
                                    <!--begin::Badges-->
                                    <div>
                                        <div class="badge badge-light-{{ $status }}">{{ $integration->status ? 'I':'Não i' }}ntegrado</div>
                                    </div>
                                    <!--end::Badges-->
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!--end::Tab pane-->
            </div>
            <!--end::Tab content-->
        </div>
        <!--end::Main column-->
    </div>
    <!--end::Form-->

    <div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Configurações do menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formMenu">
                        <input name="id" id="idMenu" type="hidden">
                        <div class="fv-row" id="div-title-type">
                            <!--begin::Label-->
                            <label class="required form-label">Título</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="title" id="titleMenu" class="form-control mb-2" placeholder="Título"/>
                            <!--end::Input-->
                            <!--begin::Description-->
                            <div class="text-muted fs-7">Um título é obrigatório.</div>
                            <!--end::Description-->
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="closeMenuModal()">Concluído</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="colorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Configurações da cor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formColor">
                        <input name="id" id="idColor" type="hidden">
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="required form-label">Cor</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="color" id="color" class="form-control mb-2" placeholder="Cor"/>
                            <!--end::Input-->
                            <!--begin::Description-->
                            <div class="text-muted fs-7">Uma cor é obrigatória.</div>
                            <!--end::Description-->
                        </div>
                        <div class="fv-row">
                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                <!--begin::Table head-->
                                <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="w-10 text-center"></th>
                                    <th class="w-40 text-center">Padrão Light</th>
                                    <th class="w-40 text-center">Padrão Dark</th>
                                </tr>
                                <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-semibold text-gray-600" id="body-menu">
                                <tr>
                                    <td>Título</td>
                                    <td class="text-center">
                                        <div class="form-check form-check-solid form-switch fv-row">
                                            <input name="is_default_title_light" id="is_default_title_light"
                                                   class="form-check-input w-45px h-30px" type="checkbox"
                                                   style="float: none !important;">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check form-check-solid form-switch fv-row">
                                            <input name="is_default_title_dark" id="is_default_title_dark"
                                                   class="form-check-input w-45px h-30px" type="checkbox"
                                                   style="float: none !important;">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Conteúdo</td>
                                    <td class="text-center">
                                        <div class="form-check form-check-solid form-switch fv-row">
                                            <input name="is_default_content_light" id="is_default_content_light"
                                                   class="form-check-input w-45px h-30px" type="checkbox"
                                                   style="float: none !important;">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check form-check-solid form-switch fv-row">
                                            <input name="is_default_content_dark" id="is_default_content_dark"
                                                   class="form-check-input w-45px h-30px" type="checkbox"
                                                   style="float: none !important;">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ícone</td>
                                    <td class="text-center">
                                        <div class="form-check form-check-solid form-switch fv-row">
                                            <input name="is_default_icon_light" id="is_default_icon_light"
                                                   class="form-check-input w-45px h-30px" type="checkbox"
                                                   style="float: none !important;">
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check form-check-solid form-switch fv-row">
                                            <input name="is_default_icon_dark" id="is_default_icon_dark"
                                                   class="form-check-input w-45px h-30px" type="checkbox"
                                                   style="float: none !important;">
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="closeColorModal()">Concluído</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="scriptModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Configurações do script</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formScript">
                        <input name="id" id="idScript" type="hidden">
                        <div class="row mb-10">
                            <div class="col-6">
                                <!--begin::Label-->
                                <label class="required form-label">Título</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="title" id="titleScript" class="form-control mb-2"
                                       placeholder="Título"/>
                                <!--end::Input-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7">Um títuulo é obrigatório.</div>
                                <!--end::Description-->
                            </div>
                            <div class="col-3">
                                <!--begin::Label-->
                                <label class="required form-label">Posição</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="position" id="position" class="form-select mb-2"
                                        data-placeholder="Posição" data-control="select2" data-hide-search="true">
                                    <option></option>
                                    <option value="head">Head</option>
                                    <option value="footer">Footer</option>
                                </select>
                                <!--end::Input-->
                                <!--begin::Description-->
                                <div class="text-muted fs-7">Uma posição é obrigatória.</div>
                                <!--end::Description-->
                            </div>
                            <div class="col-3">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold required mb-2">Exibir no mobile?</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <label class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1" name="show_mobile"
                                           id="show_mobile_script">
                                </label>
                                <!--end::Input-->
                            </div>
                        </div>
                        <div class="fv-row">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold required mb-2">Script</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea class="form-control mb-2" name="script" id="script" rows="6"
                                      style="resize: none"></textarea>
                            <!--end::Input-->
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="closeScriptModal()">Concluído</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="integrationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Configurações da integração</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formIntegration">
                        <input name="id" id="idIntegration" type="hidden">
                        <div id="divImpetusIntegration" class="fv-row mb-6">
                            <!--begin::Label-->
                            <label class="form-label">Token</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="url" id="impetusIntegration" class="form-control mb-2" value="{{ str_replace('base64:', '', env('APP_KEY')) }}" readonly/>
                            <!--end::Input-->
                        </div>

                        <div id="divUrlIntegration" class="fv-row mb-6">
                            <!--begin::Label-->
                            <label class="form-label">URL</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="url" id="urlIntegration" class="form-control mb-2"/>
                            <!--end::Input-->
                        </div>
                        <div id="divTokenIntegration" class="fv-row mb-6">
                            <!--begin::Label-->
                            <label class="form-label">Token</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="token" id="tokenIntegration" class="form-control mb-2"/>
                            <!--end::Input-->
                        </div>
                        <div id="divKeyIntegration" class="fv-row mb-6">
                            <!--begin::Label-->
                            <label class="form-label">Key</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="key" id="keyIntegration" class="form-control mb-2"/>
                            <!--end::Input-->
                        </div>
                        <div id="divSecretIntegration" class="fv-row mb-6">
                            <!--begin::Label-->
                            <label class="form-label">Secret</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="secret" id="secretIntegration" class="form-control mb-2"/>
                            <!--end::Input-->
                        </div>

                        <div id="divModelIntegration" class="fv-row mb-6">
                            <!--begin::Label-->
                            <label class="form-label">Model</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="model" id="modelIntegration" class="form-control mb-2"/>
                            <!--end::Input-->
                        </div>
                        <div id="divTemperatureIntegration" class="fv-row mb-6">
                            <!--begin::Label-->
                            <label class="form-label">Temperature</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="temperature" id="temperatureIntegration" class="form-control mb-2"/>
                            <!--end::Input-->
                        </div>
                        <div id="divTokensIntegration" class="fv-row mb-6">
                            <!--begin::Label-->
                            <label class="form-label">Tokens</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="tokens" id="tokensIntegration" class="form-control mb-2"/>
                            <!--end::Input-->
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="closeIntegrationModal()">Concluído</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{asset('ckeditor-page/build/ckeditor.js')}}"></script>
    {{-- SCRIPTS CRUD MENU (ITENS) --}}
    <script>
        var menuModal = new bootstrap.Modal(document.getElementById('menuModal'), {
            backdrop: 'static',
            keyboard: false
        });

        function openMenuModal(id, title) {
            $('#idMenu').val(id);
            $('#titleMenu').val(title);
            menuModal.show();
        }
        function closeMenuModal() {
            $('#formMenu').submit();
        }
        function destroyMenu(id) {
            Swal.fire({
                text: "Tem certeza que deseja excluir esse menu?",
                icon: "question",
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Sim, excluir",
                cancelButtonText: "Não, cancelar",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-primary"
                }
            }).then((function (t) {
                if(t.value){
                    $.ajax({
                        method: "DELETE",
                        url: '{{ route('admin.settings.group.destroy', '_ID_') }}'.replace('_ID_', id),
                        success: function (data) {
                            if (data.success) {
                                Swal.fire({
                                    text: data.message,
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, continuar",
                                    customClass: {confirmButton: "btn fw-bold btn-primary"}
                                }).then((function () {
                                    location.reload();
                                }))
                            } else {
                                Swal.fire('Falha', data.message, 'error')
                            }
                        },
                        error: function (e) {
                            console.log(e);
                            Swal.fire('Falha', 'Erro ao processar requisição, tente novamente', 'error');
                        }
                    })
                }
            }))
        }

        $('#formMenu').on('submit', function (e) {
            e.preventDefault();
            var form = new FormData(this);
            var id = $('#idMenu').val();
            var method =  id ? 'PUT' : 'POST';
            if (method === 'PUT'){
                 form.append('_method', 'PUT');
            }

            $.ajax({
                method: "POST",
                data: form,
                url: method === 'POST' ? '{{ route('admin.settings.group.store') }}':'{{ route('admin.settings.group.update', '_ID_') }}'.replace('_ID_', id),
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.success) {
                        menuModal.hide();
                        Swal.fire('Sucesso', data.message, 'success').then((function () {
                            location.reload();
                        }))
                    } else {
                        Swal.fire('Falha', data.message, 'error');
                    }
                },
                error: function (e) {
                    console.log(e);
                    Swal.fire('Falha', 'Erro ao processar requisição, tente novamente', 'error');
                }
            })
        })
    </script>
    {{-- SCRIPTS CRUD MENU (LAYOUT) --}}
    <script>
        function deleteMenu(id) {
            Swal.fire({
                text: "Tem certeza que deseja excluir o menu?",
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
                        url: '{{ route('admin.settings.menu.destroy', '_ID_') }}'.replace('_ID_', id),
                        type: 'DELETE',
                        processData: false,
                        contentType: false,
                        success: function(data){
                            if(data.success){
                                Swal.fire('Sucesso', data.message, 'success').then((function () {
                                    location.reload();
                                }));
                            }else{
                                Swal.fire('Erro', data.message, 'error');
                            }
                        },
                        error: function(data){
                            Swal.fire('Erro', 'Falha ao excluir menu, tente novamente', 'error');
                        }
                    });
                }
            });
        }
    </script>
    {{-- SCRIPTS CRUD FONTES --}}
    <script>
        function deleteFont(id) {
            Swal.fire({
                text: "Tem certeza que deseja excluir oa fonte?",
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
                        url: '{{ route('admin.settings.fonts.destroy', '_ID_') }}'.replace('_ID_', id),
                        type: 'DELETE',
                        processData: false,
                        contentType: false,
                        success: function(data){
                            if(data.success){
                                Swal.fire('Sucesso', data.message, 'success').then((function () {
                                    location.reload();
                                }));
                            }else{
                                Swal.fire('Erro', data.message, 'error');
                            }
                        },
                        error: function(data){
                            Swal.fire('Erro', 'Falha ao excluir menu, tente novamente', 'error');
                        }
                    });
                }
            });
        }
    </script>
    {{-- SCRIPTS CRUD ALERTA DE COOKIE --}}
    <script>
        var cookieSubmitButton = document.getElementById('btn-submit-cookie');
        $('#btn-submit-cookie').on("click", function () {
            cookieSubmitButton.setAttribute('data-kt-indicator', 'on'); // Disable button to avoid multiple click
            cookieSubmitButton.disabled = true;

            var form = new FormData();
            form.append('title', $('#cookie-title').val());
            form.append('description', descriptionCookie.getData());
            form.append('status', $('#cookie-status').val());
            form.append('color', $('#cookie-color').css("background-color"));
            form.append('button_decline_color', $('#cookie-decline-color').css("background-color"));
            form.append('button_decline_border_color', $('#cookie-decline-border-color').css("background-color"));
            form.append('button_decline_title_color', $('#cookie-decline-title-color').css("background-color"));
            form.append('button_hover_decline_color', $('#cookie-hover-decline-color').css("background-color"));
            form.append('button_hover_decline_border_color', $('#cookie-hover-decline-border-color').css("background-color"));
            form.append('button_hover_decline_title_color', $('#cookie-hover-decline-title-color').css("background-color"));
            form.append('button_accept_color', $('#cookie-accept-color').css("background-color"));
            form.append('button_accept_border_color', $('#cookie-accept-border-color').css("background-color"));
            form.append('button_accept_title_color', $('#cookie-accept-title-color').css("background-color"));
            form.append('button_hover_accept_color', $('#cookie-hover-accept-color').css("background-color"));
            form.append('button_hover_accept_border_color', $('#cookie-hover-accept-border-color').css("background-color"));
            form.append('button_hover_accept_title_color', $('#cookie-hover-accept-title-color').css("background-color"));
            $.ajax({
                url: '{{ route('admin.settings.saveCookie') }}',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                success: function (data) {
                    cookieSubmitButton.removeAttribute('data-kt-indicator');
                    cookieSubmitButton.disabled = false;

                    if (data.success) {
                        Swal.fire('Sucesso', 'Informações do alerta de cookie salvas com sucesso', 'success');
                    } else {
                        Swal.fire('Erro', data.message, 'error');
                    }
                },
                error: function (data) {
                    cookieSubmitButton.removeAttribute('data-kt-indicator');
                    cookieSubmitButton.disabled = false;

                    Swal.fire('Erro', 'Falha ao salvar informações do alerta de cookie, tente novamente', 'error');
                }
            });

        });

        let descriptionCookie;
        ClassicEditor.create(document.querySelector('#cookie-description'), {
            language: 'pt-br',
            removePlugins: ['Title'],
            placeholder: '',
        }).then(newEditor => {
            newEditor.model.document.on('change', () => {
                const data = descriptionCookie.getData();
            });
            descriptionCookie = newEditor;
        }).catch(error => {});
    </script>
    {{-- SCRIPT CRUD COLORS --}}
    <script>
        var colorModal = new bootstrap.Modal(document.getElementById('colorModal'), {
            backdrop: 'static',
            keyboard: false
        });

        function openColorModal(id) {
            var form = new FormData();
            form.append('id', id);
            $.ajax({
                method: "POST",
                data: form,
                url: '{{ route('admin.settings.getColor') }}',
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.success) {
                        if (data.color === null) {
                            $('#idColor').val(null);

                            $('#color').val(null);
                            $('#is_default_title_light').prop('checked', false);
                            $('#is_default_title_dark').prop('checked', false);
                            $('#is_default_content_light').prop('checked', false);
                            $('#is_default_content_dark').prop('checked', false);
                            $('#is_default_icon_light').prop('checked', false);
                            $('#is_default_icon_dark').prop('checked', false);
                        } else {
                            $('#idColor').val(data.color.id);

                            $('#color').val(data.color.color);
                            $('#is_default_title_light').prop('checked', parseInt(data.color.is_default_title_light));
                            $('#is_default_title_dark').prop('checked', parseInt(data.color.is_default_title_dark));
                            $('#is_default_content_light').prop('checked', parseInt(data.color.is_default_content_light));
                            $('#is_default_content_dark').prop('checked', parseInt(data.color.is_default_content_dark));
                            $('#is_default_icon_light').prop('checked', parseInt(data.color.is_default_icon_light));
                            $('#is_default_icon_dark').prop('checked', parseInt(data.color.is_default_icon_dark));
                        }
                        colorModal.show();
                    } else {
                        Swal.fire('Erro!', data.message, 'error')
                    }
                },
                error: function (e) {
                    console.log(e);
                    Swal.fire('Falha!', 'Erro ao processar requisição.', 'error');
                }
            })
        }

        function closeColorModal() {
            $('#formColor').submit();
        }

        $('#formColor').on('submit', function (e) {
            e.preventDefault();
            var form = new FormData(this);
            $.ajax({
                method: "POST",
                data: form,
                url: '{{ route('admin.settings.saveColor') }}',
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.success) {
                        menuItemModal.hide();
                        Swal.fire('Sucesso!', data.message, 'success').then((function () {
                            location.reload();
                        }));
                    } else {
                        Swal.fire('Erro!', data.message, 'error');
                    }
                },
                error: function (e) {
                    console.log(e);
                    Swal.fire('Falha!', 'Erro ao processar requisição.', 'error');
                }
            })
        });

        function removeColor(id) {
            Swal.fire({
                text: "Tem certeza que deseja remover essa cor?",
                icon: "question",
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Sim, excluir!",
                cancelButtonText: "Não, cancelar",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-primary"
                }
            }).then((function (t) {
                t.value ?
                    $.ajax({
                        method: "DELETE",
                        url: '{{ route('admin.settings.deleteColor', '_ID_') }}'.replace('_ID_', id),
                        success: function (data) {
                            if (data.success) {
                                Swal.fire({
                                    text: data.message,
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, continuar!",
                                    customClass: {confirmButton: "btn fw-bold btn-primary"}
                                }).then((function () {
                                    location.reload();
                                }))
                            } else {
                                Swal.fire('Erro!', data.message, 'error')
                            }
                        },
                        error: function (e) {
                            console.log(e);
                            Swal.fire('Falha!', 'Erro ao processar requisição.', 'error');
                        }
                    }) : "cancel" === t.dismiss && Swal.fire({
                    text: "O item não foi removido.",
                    icon: "error",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, continuar!",
                    customClass: {confirmButton: "btn fw-bold btn-primary"}
                })
            }))
        }
    </script>
    {{-- SCRIPT CRUD SCRIPTS --}}
    <script>
        var scriptModal = new bootstrap.Modal(document.getElementById('scriptModal'), {
            backdrop: 'static',
            keyboard: false
        });

        function openScriptModal(id) {
            var form = new FormData();
            form.append('id', id);
            $.ajax({
                method: "POST",
                data: form,
                url: '{{ route('admin.settings.getScripts') }}',
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.success) {
                        if (data.script === null) {
                            $('#idScript').val(null);

                            $('#titleScript').val(null);
                            $('#position').val(null).trigger('change');
                            $('#show_mobile_script').attr("checked", false);
                            $('#script').val(null);
                        } else {
                            $('#idScript').val(data.script.id);

                            $('#titleScript').val(data.script.title);
                            $('#position').val(data.script.position).trigger('change');
                            $('#show_mobile_script').attr("checked", data.script.show_mobile ? true : false);
                            $('#script').val(data.script.script);
                        }
                        scriptModal.show();
                    } else {
                        Swal.fire('Erro!', data.message, 'error')
                    }
                },
                error: function (e) {
                    console.log(e);
                    Swal.fire('Falha!', 'Erro ao processar requisição.', 'error');
                }
            })
        }

        function closeScriptModal() {
            $('#formScript').submit();
        }

        $('#formScript').on('submit', function (e) {
            e.preventDefault();
            var form = new FormData(this);
            $.ajax({
                method: "POST",
                data: form,
                url: '{{ route('admin.settings.saveScript') }}',
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.success) {
                        scriptModal.hide();
                        Swal.fire('Sucesso!', data.message, 'success').then((function () {
                            location.reload();
                        }));
                    } else {
                        Swal.fire('Erro!', data.message, 'error');
                    }
                },
                error: function (e) {
                    console.log(e);
                    Swal.fire('Falha!', 'Erro ao processar requisição.', 'error');
                }
            })
        });

        function removeScript(id) {
            Swal.fire({
                text: "Tem certeza que deseja remover esse script?",
                icon: "question",
                showCancelButton: !0,
                buttonsStyling: !1,
                confirmButtonText: "Sim, excluir!",
                cancelButtonText: "Não, cancelar",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-primary"
                }
            }).then((function (t) {
                t.value ?
                    $.ajax({
                        method: "DELETE",
                        url: '{{ route('admin.settings.deleteScript', '_ID_') }}'.replace('_ID_', id),
                        success: function (data) {
                            if (data.success) {
                                Swal.fire({
                                    text: data.message,
                                    icon: "success",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Ok, continuar!",
                                    customClass: {confirmButton: "btn fw-bold btn-primary"}
                                }).then((function () {
                                    location.reload();
                                }))
                            } else {
                                Swal.fire('Erro!', data.message, 'error')
                            }
                        },
                        error: function (e) {
                            console.log(e);
                            Swal.fire('Falha!', 'Erro ao processar requisição.', 'error');
                        }
                    }) : "cancel" === t.dismiss && Swal.fire({
                    text: "O item não foi removido.",
                    icon: "error",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, continuar!",
                    customClass: {confirmButton: "btn fw-bold btn-primary"}
                })
            }))
        }
    </script>
    {{-- SCRIPT CRUD INTEGRATION --}}
    <script>
        var integrationModal = new bootstrap.Modal(document.getElementById('integrationModal'), {
            backdrop: 'static',
            keyboard: false
        });

        function editIntegration(id) {
            if(id === 0){
                $('#divImpetusIntegration').show();

                $('#divUrlIntegration').hide();
                $('#divTokenIntegration').hide();
                $('#divKeyIntegration').hide();
                $('#divSecretIntegration').hide();
                $('#divModelIntegration').hide();
                $('#divTemperatureIntegration').hide();
                $('#divTokensIntegration').hide();

                $('#idIntegration').val(id);
                integrationModal.show();
                return;
            }

            $('#divImpetusIntegration').hide();
            $.ajax({
                method: "GET",
                url: '{{ route('admin.settings.getIntegration', '_ID_') }}'.replace('_ID_', id),
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.success) {
                        $('#idIntegration').val(data.integration.id);
                        $('#urlIntegration').val(data.integration.url);
                        $('#tokenIntegration').val(data.integration.token);
                        $('#keyIntegration').val(data.integration.key);
                        $('#secretIntegration').val(data.integration.secret);
                        $('#modelIntegration').val(data.integration.model);
                        $('#temperatureIntegration').val(data.integration.temperature);
                        $('#tokensIntegration').val(data.integration.tokens);

                        if(data.integration.title === 'Google Recaptcha'){
                            $('#divUrlIntegration').hide();
                            $('#divTokenIntegration').hide();
                            $('#divKeyIntegration').show();
                            $('#divSecretIntegration').show();
                            $('#divModelIntegration').hide();
                            $('#divTemperatureIntegration').hide();
                            $('#divTokensIntegration').hide();
                        }else if (data.integration.title === 'JIRA'){
                            $('#divUrlIntegration').show();
                            $('#divTokenIntegration').show();
                            $('#divKeyIntegration').hide();
                            $('#divSecretIntegration').hide();
                            $('#divModelIntegration').hide();
                            $('#divTemperatureIntegration').hide();
                            $('#divTokensIntegration').hide();
                        }else if (data.integration.title === 'OpenAI'){
                            $('#divUrlIntegration').hide();
                            $('#divTokenIntegration').hide();
                            $('#divKeyIntegration').show();
                            $('#divSecretIntegration').hide();
                            $('#divModelIntegration').show();
                            $('#divTemperatureIntegration').show();
                            $('#divTokensIntegration').show();
                        }else if (data.integration.title === 'EpicFlow'){
                            $('#divUrlIntegration').show();
                            $('#divTokenIntegration').show();
                            $('#divKeyIntegration').hide();
                            $('#divSecretIntegration').hide();
                            $('#divModelIntegration').hide();
                            $('#divTemperatureIntegration').hide();
                            $('#divTokensIntegration').hide();
                        }

                        integrationModal.show();
                    } else {
                        Swal.fire('Falha', data.message, 'error')
                    }
                },
                error: function (e) {
                    Swal.fire('Falha', 'Erro ao processar requisição, tente novamente', 'error');
                }
            })
        }
        function closeIntegrationModal(){
            if ($('#idIntegration').val() > 0){
                $('#formIntegration').submit();
            }else{
                integrationModal.hide();
            }
        }

        $('#formIntegration').on('submit', function (e) {
            e.preventDefault();
            var form = new FormData(this);
            $.ajax({
                method: "POST",
                data: form,
                url: '{{ route('admin.settings.saveIntegration', '_ID_') }}'.replace('_ID_', $('#idIntegration').val()),
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.success) {
                        integrationModal.hide();
                        Swal.fire('Sucesso', data.message, 'success').then((function () {
                            location.reload();
                        }));
                    } else {
                        Swal.fire('Falha', data.message, 'error');
                    }
                },
                error: function (e) {
                    Swal.fire('Falha', 'Erro ao processar requisição, tente novamente', 'error');
                }
            })
        });
    </script>
    {{-- SCRIPT BOX SELECT BLOCK --}}
    <script>
        $(document).on('click', function (event) {
            if (!$(event.target).closest('.colors-box').length && !$(event.target).hasClass(
                'color-select')) {
                $('.colors-box').css('display', 'none');
            }
        });

        $('.color-box').on('click', function () {
            $('.colors-box').not($(this).children('.colors-box')).css('display', 'none');
            $(this).children('.colors-box').css('display', 'flex');
        });

        $('.colors-box div').on('click', function () {
            var color = $(this).css('background-color');
            $(this).closest('.color-box').find('.color-select').css('background-color', color);
            console.log($(this).siblings('.color-select'));
            $(this).parent().fadeOut(100);
        });

        /* antigo remover */

        $(document).on('click', function (event) {
            if (!$(event.target).closest('.color-select-box').length && !$(event.target).hasClass(
                'color-input-box')) {
                $('.color-select-box').css('display', 'none');
            }
        });

        $('.color-input-box').on('click', function () {
            $('.color-select-box').not($(this).children('.color-select-box')).css('display', 'none');
            $(this).children('.color-select-box').css('display', 'grid');
        });

        $('.color-select-box div').on('click', function () {
            var color = $(this).css('background-color');
            $(this).closest('.color-input-box').css('background-color', color);
            $(this).parent().fadeOut(100);
        });
    </script>
@endpush
