<!--begin::LAYOUT 19-->
<div id="div-layout-19" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item text-center" style="width: 25%">
            <a class="nav-link active" data-bs-toggle="tab" href="#layout-19-0">Geral</a>
        </li>
        @for($y = 1; $y <= 3; $y++)
            <li class="nav-item text-center" style="width: 25%">
                <a class="nav-link" data-bs-toggle="tab" href="#layout-19-{{ $y }}">Aba {{ $y }}</a>
            </li>
        @endfor
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="layout-19-0" role="tabpanel">
            @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 19, 'required' => 'required', 'margin' => 'mb-12'])
            <div class="row mb-12">
                <div class="col-4">
                    @include('admin.pages.pages.components.layout.content_alignment', ['blockNumber' => 19, 'required' => 'required', 'margin' => null, 'titleLabel' => 'Alinhamento (Imagem)'])
                </div>
                <div class="col-4">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2">Tipo</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="type_19" name="type_19">
                        <option></option>
                        <option value="close">Fechado</option>
                        <option value="open">Aberto</option>
                    </select>
                    <!--end::Input-->
                </div>
                <div class="col-4">
                    @include('admin.pages.pages.components.layout.display_content', ['blockNumber' => 19, 'required' => 'required', 'margin' => null, 'titleLabel' => 'Exibir (Pattern)?'])
                </div>
            </div>
            @include('admin.pages.pages.components.layout.display_content', ['blockNumber' => 19, 'tabNumber' => 1, 'required' => 'required', 'margin' => 'mb-12', 'titleLabel' => 'Exibir imagem no mobile?'])
            <h2 class="fw-bold text-dark mb-6">Fundo</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box mb-12">
                @include('admin.pages.pages.components.layout.background', ['blockNumber' => 19])
            </div>
            <!--end::Input group-->
            <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box">
                @include('admin.pages.pages.components.layout.title', ['blockNumber' => 19])
                @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 19])
                @include('admin.pages.pages.components.layout.description', ['blockNumber' => 19])
            </div>
        </div>
        @for($y = 1; $y <= 3; $y++)
            <div class="tab-pane fade" id="layout-19-{{ $y }}" role="tabpanel">
                <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
                <!--begin::Input group-->
                <div class="colors-parent-box">
                    @include('admin.pages.pages.components.layout.title', ['blockNumber' => 19, 'tabNumber' => $y])
                    @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 19, 'tabNumber' => $y])
                </div>
                <!--end::Input group-->
            </div>
        @endfor
    </div>
</div>
<!--end::LAYOUT 19-->
