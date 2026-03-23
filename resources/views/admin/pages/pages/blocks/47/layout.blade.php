<!--begin::LAYOUT 47-->
<div id="div-layout-47" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item text-center" style="width: 14.28%">
            <a class="nav-link active" data-bs-toggle="tab" href="#layout-47-0">Geral</a>
        </li>
        @for($y = 1; $y <= 6; $y++)
            <li class="nav-item text-center" style="width: 14.28%">
                <a class="nav-link" data-bs-toggle="tab" href="#layout-47-{{ $y }}">Aba {{ $y }}</a>
            </li>
        @endfor
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="layout-47-0" role="tabpanel">
            <!--begin::Input group-->
            <div class="row mb-12">
                <div class="col-6">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2">Margin top</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="number" value="15" class="form-control" name="margin_top_47" id="margin_top_47" />
                    <!--end::Input-->
                </div>
                <div class="col-6">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2">Margin bottom</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="number" value="15" class="form-control" name="margin_bottom_47" id="margin_bottom_47" />
                    <!--end::Input-->
                </div>
            </div>
            <!--end::Input group-->
            <h2 class="fw-bold text-dark mb-6">Fundo</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box mb-12">
                @include('admin.pages.pages.components.layout.background', ['blockNumber' => 47])
            </div>
            <!--end::Input group-->
            <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box">
                @include('admin.pages.pages.components.layout.tag', ['blockNumber' => 47, 'titleLabel' => 'Tag'])
                @include('admin.pages.pages.components.layout.title', ['blockNumber' => 47])
                @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 47])
            </div>
            <!--end::Input group-->
        </div>
        @for($y = 1; $y <= 6; $y++)
            <div class="tab-pane fade" id="layout-47-{{ $y }}" role="tabpanel">
                <h2 class="fw-bold text-dark mb-6">Fundo</h2>
                <!--begin::Input group-->
                <div class="colors-parent-box mb-12">
                    @include('admin.pages.pages.components.layout.background', ['blockNumber' => 47, 'tabNumber' => $y])
                </div>
                <!--end::Input group-->
                <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
                <!--begin::Input group-->
                <div class="colors-parent-box">
                    @include('admin.pages.pages.components.layout.icon', ['blockNumber' => 47, 'tabNumber' => $y, 'titleLabel' => 'Número'])
                    @include('admin.pages.pages.components.layout.title', ['blockNumber' => 47, 'tabNumber' => $y])
                    @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 47, 'tabNumber' => $y, 'titleLabel' => 'Conteúdo'])
                </div>
                <!--end::Input group-->
            </div>
        @endfor
    </div>
</div>
<!--end::LAYOUT 47-->
