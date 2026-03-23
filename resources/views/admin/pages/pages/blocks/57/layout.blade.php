<!--begin::LAYOUT 57-->
<div id="div-layout-57" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item text-center" style="width: 25%">
            <a class="nav-link active" data-bs-toggle="tab" href="#layout-57-0">Geral</a>
        </li>
        @for($y = 1; $y <= 3; $y++)
            <li class="nav-item text-center" style="width: 25%">
                <a class="nav-link" data-bs-toggle="tab" href="#layout-57-{{ $y }}">Aba {{ $y }}</a>
            </li>
        @endfor
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="layout-57-0" role="tabpanel">
            @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 57, 'required' => 'required', 'margin' => 'mb-9'])
            @include('admin.pages.pages.components.layout.content_alignment', ['blockNumber' => 57, 'required' => 'required', 'margin' => 'mb-9', 'titleLabel' => 'Alinhamento (Ícones)'])
            <h2 class="fw-bold text-dark mb-6">Fundo</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box mb-12">
                @include('admin.pages.pages.components.layout.background', ['blockNumber' => 57])
            </div>
            <!--end::Input group-->
            <h2 class="fw-bold text-dark mb-6">Tag</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box mb-12">
                @include('admin.pages.pages.components.layout.tag', ['blockNumber' => 57])
                @include('admin.pages.pages.components.layout.tag-title', ['blockNumber' => 57])
            </div>
            <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box">
                @include('admin.pages.pages.components.layout.title', ['blockNumber' => 57])
                @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 57])
                @include('admin.pages.pages.components.layout.description', ['blockNumber' => 57])
            </div>
            <!--end::Input group-->
        </div>
        @for($y = 1; $y <= 3; $y++)
            <div class="tab-pane fade" id="layout-57-{{ $y }}" role="tabpanel">
                <h2 class="fw-bold text-dark mb-6">Fundo</h2>
                <!--begin::Input group-->
                <div class="colors-parent-box mb-12">
                    @include('admin.pages.pages.components.layout.background', ['blockNumber' => 57, 'tabNumber' => $y])
                    @include('admin.pages.pages.components.layout.icon', ['blockNumber' => 57, 'tabNumber' => $y])
                </div>
                <!--end::Input group-->
                <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
                <!--begin::Input group-->
                <div class="colors-parent-box">
                    @include('admin.pages.pages.components.layout.title', ['blockNumber' => 57, 'tabNumber' => $y])
                    @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 57, 'tabNumber' => $y, 'titleLabel' => 'Descrição'])
                </div>
                <!--end::Input group-->
            </div>
        @endfor
    </div>
</div>
<!--end::LAYOUT 57-->
