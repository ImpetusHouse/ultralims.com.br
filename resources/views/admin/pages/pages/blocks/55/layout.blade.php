<!--begin::LAYOUT 55-->
<div id="div-layout-55" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item text-center" style="width: 25%">
            <a class="nav-link active" data-bs-toggle="tab" href="#layout-55-0">Geral</a>
        </li>
        @for($y = 1; $y <= 3; $y++)
            <li class="nav-item text-center" style="width: 25%">
                <a class="nav-link" data-bs-toggle="tab" href="#layout-55-{{ $y }}">Aba {{ $y }}</a>
            </li>
        @endfor
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="layout-55-0" role="tabpanel">
            @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 55, 'required' => 'required', 'margin' => 'mb-9'])
            <h2 class="fw-bold text-dark mb-6">Fundo</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box mb-12">
                @include('admin.pages.pages.components.layout.background', ['blockNumber' => 55])
            </div>
            <!--end::Input group-->
            <h2 class="fw-bold text-dark mb-6">Tag</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box mb-12">
                @include('admin.pages.pages.components.layout.tag', ['blockNumber' => 55])
                @include('admin.pages.pages.components.layout.tag-title', ['blockNumber' => 55])
            </div>
            <!--end::Input group-->
            <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box">
                @include('admin.pages.pages.components.layout.title', ['blockNumber' => 55])
                @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 55])
            </div>
            <!--end::Input group-->
        </div>
        @for($y = 1; $y <= 3; $y++)
            <div class="tab-pane fade" id="layout-55-{{ $y }}" role="tabpanel">
                <h2 class="fw-bold text-dark mb-6">Fundo</h2>
                <!--begin::Input group-->
                <div class="colors-parent-box mb-12">
                    @include('admin.pages.pages.components.layout.background', ['blockNumber' => 55, 'tabNumber' => $y])
                    @include('admin.pages.pages.components.layout.border', ['blockNumber' => 55, 'tabNumber' => $y])
                </div>
                <!--end::Input group-->
                <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
                <!--begin::Input group-->
                <div class="colors-parent-box mb-12">
                    @include('admin.pages.pages.components.layout.title', ['blockNumber' => 55, 'tabNumber' => $y])
                    @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 55, 'tabNumber' => $y, 'titleLabel' => 'Descrição'])
                    @include('admin.pages.pages.components.layout.number', ['blockNumber' => 55, 'tabNumber' => $y, 'titleLabel' => 'Subtítulo'])
                </div>
                <!--end::Input group-->
                <h2 class="fw-bold text-dark mb-6">Botão</h2>
                <!--begin::Input group-->
                @include('admin.pages.pages.components.layout.type', ['blockNumber' => 55, 'tabNumber' => $y, 'required' => null, 'margin' => 'mb-4'])
                <div class="colors-parent-box">
                    @include('admin.pages.pages.components.layout.button', ['blockNumber' => 55, 'tabNumber' => $y])
                    @include('admin.pages.pages.components.layout.button-hover', ['blockNumber' => 55, 'tabNumber' => $y])
                    @include('admin.pages.pages.components.layout.button-text', ['blockNumber' => 55, 'tabNumber' => $y])
                </div>
                <!--end::Input group-->
            </div>
        @endfor
    </div>
</div>
<!--end::LAYOUT 55-->
