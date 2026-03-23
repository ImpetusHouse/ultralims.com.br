<!--begin::LAYOUT 66-->
<div id="div-layout-66" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item text-center" style="width: 16.66%">
            <a class="nav-link active" data-bs-toggle="tab" href="#layout-66-0">Geral</a>
        </li>
        @for($y = 1; $y <= 5; $y++)
            <li class="nav-item text-center" style="width: 16.66%">
                <a class="nav-link" data-bs-toggle="tab" href="#layout-66-{{ $y }}">Aba {{ $y }}</a>
            </li>
        @endfor
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="layout-66-0" role="tabpanel">
            @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 66, 'required' => 'required', 'margin' => 'mb-9'])
            @include('admin.pages.pages.components.layout.type', ['blockNumber' => 66, 'required' => 'required', 'margin' => 'mb-9'])
            <h2 class="fw-bold text-dark mb-6">Fundo</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box mb-12">
                @include('admin.pages.pages.components.layout.background', ['blockNumber' => 66])
                @include('admin.pages.pages.components.layout.primary_color', ['blockNumber' => 66, 'titleLabel' => 'Paginação'])
            </div>
            <!--end::Input group-->
        </div>
        @for($y = 1; $y <= 5; $y++)
            <div class="tab-pane fade" id="layout-66-{{ $y }}" role="tabpanel">
                <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
                <!--begin::Input group-->
                <div class="colors-parent-box mb-12">
                    @include('admin.pages.pages.components.layout.title', ['blockNumber' => 66, 'tabNumber' => $y])
                    @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 66, 'tabNumber' => $y])
                    @include('admin.pages.pages.components.layout.description', ['blockNumber' => 66, 'tabNumber' => $y])
                </div>
                <!--end::Input group-->
                <h2 class="fw-bold text-dark mb-6">Botão</h2>
                <!--begin::Input group-->
                <div class="colors-parent-box mb-12">
                    @include('admin.pages.pages.components.layout.button', ['blockNumber' => 66, 'tabNumber' => $y])
                    @include('admin.pages.pages.components.layout.button-hover', ['blockNumber' => 66, 'tabNumber' => $y])
                    @include('admin.pages.pages.components.layout.button-text', ['blockNumber' => 66, 'tabNumber' => $y])
                </div>
                <!--end::Input group-->
                <h2 class="fw-bold text-dark mb-6">Botão 2</h2>
                <!--begin::Input group-->
                <div class="colors-parent-box">
                    @include('admin.pages.pages.components.layout.button', ['blockNumber' => 66, 'tabNumber' => $y, 'buttonOne' => true])
                    @include('admin.pages.pages.components.layout.button-hover', ['blockNumber' => 66, 'tabNumber' => $y, 'buttonOne' => true])
                    @include('admin.pages.pages.components.layout.button-text', ['blockNumber' => 66, 'tabNumber' => $y, 'buttonOne' => true])
                </div>
                <!--end::Input group-->
            </div>
        @endfor
    </div>
</div>
<!--end::LAYOUT 66-->
