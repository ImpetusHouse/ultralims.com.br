@extends('admin.layout')
@section('content')
    <!--begin::Form-->
    <div class="d-flex flex-column flex-lg-row">
        <!--begin::Main column-->
        <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
            <!--begin:::Tabs-->
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-n2">
                <!--begin:::Tab item-->
                <li class="nav-item">
                    <a id="btn-tab-menu" class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#tab-lgpd">LGPD</a>
                </li>
                <!--end:::Tab item-->
            </ul>
            <!--end:::Tabs-->
            <!--begin::Tab content-->
            <div class="tab-content">
                <!--begin::Tab pane-->
                <div class="tab-pane fade show active" id="tab-lgpd" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-10">
                        <!--begin::General options-->
                        <div class="card card-flush py-4">
                            <!--begin::Card header-->
                            <div class="card-header">
                                <div class="card-title">
                                    <h2>LGPD</h2>
                                </div>

                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body pt-0">
                                <!--begin::Table-->
                                <form id="displayOrderHome">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="tableOrderMenu">
                                        <!--begin::Table head-->
                                        <thead>
                                        <!--begin::Table row-->
                                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                            <th>Página</th>
                                            <th>Tipo</th>
                                            <th>Aceito</th>
                                            <th>Nome</th>
                                            <th>Telefone</th>
                                            <th>E-mail</th>
                                            <th>IP</th>
                                            <th class="text-center">Criado em</th>
                                        </tr>
                                        <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-semibold text-gray-600" id="body-menu">
                                        @foreach($lgpds as $lgpd)
                                            <!--begin::Table row-->
                                            <tr>
                                                <!--begin::Título=-->
                                                <td>
                                                    <span class="text-gray-800 fs-5 fw-bold">
                                                        {{ $lgpd->page != null ? $lgpd->page->title : '-' }}
                                                    </span>
                                                </td>
                                                <!--end::Título=-->
                                                <!--begin::Tipo=-->
                                                <td>
                                                    <span class="text-gray-800 fs-5 fw-bold">
                                                        {{ $lgpd->type == 'alert' ? 'Alerta de cookies':'Formulário' }}
                                                    </span>
                                                </td>
                                                <!--end::Tipo=-->
                                                <td>
                                                    <span class="text-gray-800 fs-5 fw-bold">
                                                        {{ $lgpd->type == 'alert' ? ($lgpd->accept ? 'Sim':'Não'):'-' }}
                                                    </span>
                                                </td>
                                                <!--end::Tipo=-->
                                                <!--begin::Pertence à=-->
                                                <td>
                                                    <span class="text-gray-800 fs-5 fw-bold">
                                                        {{ strlen($lgpd->name) > 0 ? $lgpd->name : '-' }}
                                                    </span>
                                                </td>
                                                <!--end::Pertence à=-->
                                                <!--begin::Pertence à=-->
                                                <td>
                                                    <span class="text-gray-800 fs-5 fw-bold {{ strlen($lgpd->phone) > 0 ? 'mask-tel' : '' }}">
                                                        {{ strlen($lgpd->phone) > 0 ? $lgpd->phone : '-' }}
                                                    </span>
                                                </td>
                                                <!--end::Pertence à=-->
                                                <!--begin::Pertence à=-->
                                                <td>
                                                    <span class="text-gray-800 fs-5 fw-bold">
                                                        {{ strlen($lgpd->email) > 0 ? $lgpd->email : '-' }}
                                                    </span>
                                                </td>
                                                <!--end::Pertence à=-->
                                                <!--begin::Pertence à=-->
                                                <td>
                                                    <span class="text-gray-800 fs-5 fw-bold">
                                                        {{$lgpd->ip }}
                                                    </span>
                                                </td>
                                                <!--end::Pertence à=-->
                                                <!--begin::Pertence à=-->
                                                <td class="text-center">
                                                    <span class="text-gray-800 fs-5 fw-bold">
                                                        {{$lgpd->created_at->format('d/m/Y').' às '.$lgpd->created_at->format('H:i') }}
                                                    </span>
                                                </td>
                                                <!--end::Pertence à=-->
                                            </tr>
                                            <!--end::Table row-->
                                        @endforeach
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </form>
                            </div>
                            <!--end::Card header-->
                        </div>
                        <!--end::General options-->
                    </div>
                </div>
                <!--end::Tab pane-->
            </div>
            <!--end::Tab content-->
        </div>
        <!--end::Main column-->
    </div>
    <!--end::Form-->
@endsection
