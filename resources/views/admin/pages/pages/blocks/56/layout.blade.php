<!--begin::LAYOUT 56-->
<div id="div-layout-56" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link active" data-bs-toggle="tab" href="#layout-56-0">Geral</a>
        </li>
        @for($y = 1; $y <= 4; $y++)
            <li class="nav-item text-center" style="width: 20%">
                <a class="nav-link" data-bs-toggle="tab" href="#layout-56-{{ $y }}">Aba {{ $y }}</a>
            </li>
        @endfor
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="layout-56-0" role="tabpanel">
            @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 56, 'required' => 'required', 'margin' => 'mb-9'])
            @include('admin.pages.pages.components.layout.display_content', ['blockNumber' => 56, 'tabNumber' => 1, 'required' => 'required', 'margin' => 'mb-9', 'titleLabel' => 'Exibir pattern'])
            @include('admin.pages.pages.components.layout.content_alignment', ['blockNumber' => 56, 'required' => 'required', 'margin' => 'mb-9'])
            @include('admin.pages.pages.components.layout.type', ['blockNumber' => 56, 'required' => 'required', 'margin' => 'mb-9'])
            <h2 class="fw-bold text-dark mb-6">Fundo</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box mb-12">
                @include('admin.pages.pages.components.layout.background', ['blockNumber' => 56])
            </div>
            <!--end::Input group-->
            <h2 class="fw-bold text-dark mb-6">Tag</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box mb-12">
                @include('admin.pages.pages.components.layout.tag-title', ['blockNumber' => 56])
            </div>
            <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box mb-12">
                @include('admin.pages.pages.components.layout.title', ['blockNumber' => 56])
                @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 56])
                @include('admin.pages.pages.components.layout.description', ['blockNumber' => 56])
            </div>
            <!--end::Input group-->
            <h2 class="fw-bold text-dark mb-6">Botão</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box mb-12">
                @include('admin.pages.pages.components.layout.button', ['blockNumber' => 56])
                @include('admin.pages.pages.components.layout.button-hover', ['blockNumber' => 56])
                @include('admin.pages.pages.components.layout.button-text', ['blockNumber' => 56])
            </div>
            <!--end::Input group-->
            <h2 class="fw-bold text-dark mb-6">Pesquisa</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box">
                @include('admin.pages.pages.components.layout.tag', ['blockNumber' => 56, 'titleLabel' => 'Fundo'])
                @include('admin.pages.pages.components.layout.pdf_color', ['blockNumber' => 56, 'titleLabel' => 'Texto'])
            </div>
            <!--end::Input group-->
        </div>
        @for($y = 1; $y <= 4; $y++)
            <div class="tab-pane fade" id="layout-56-{{ $y }}" role="tabpanel">
                <h2 class="fw-bold text-dark mb-6">Fundo</h2>
                <!--begin::Input group-->
                <div class="colors-parent-box mb-12">
                    @include('admin.pages.pages.components.layout.background', ['blockNumber' => 56, 'tabNumber' => $y])
                </div>
                <!--end::Input group-->
                <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
                <!--begin::Input group-->
                <div class="colors-parent-box">
                    @include('admin.pages.pages.components.layout.icon', ['blockNumber' => 56, 'tabNumber' => $y])
                    @include('admin.pages.pages.components.layout.title', ['blockNumber' => 56, 'tabNumber' => $y])
                    @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 56, 'tabNumber' => $y, 'titleLabel' => 'Descrição'])
                </div>
                <!--end::Input group-->
            </div>
        @endfor
    </div>
</div>
<!--end::LAYOUT 56-->
