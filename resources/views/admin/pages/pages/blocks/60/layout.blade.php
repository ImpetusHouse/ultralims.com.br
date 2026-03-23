<!--begin::LAYOUT 60-->
<div id="div-layout-60" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item text-center" style="width: 33.33%">
            <a class="nav-link active" data-bs-toggle="tab" href="#layout-60-0">Geral</a>
        </li>
        @for($y = 1; $y <= 2; $y++)
            <li class="nav-item text-center" style="width: 33.33%">
                <a class="nav-link" data-bs-toggle="tab" href="#layout-60-{{ $y }}">Aba {{ $y }}</a>
            </li>
        @endfor
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="layout-60-0" role="tabpanel">
            @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 60, 'required' => 'required', 'margin' => 'mb-9'])
            <h2 class="fw-bold text-dark mb-6">Fundo</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box mb-12">
                @include('admin.pages.pages.components.layout.background', ['blockNumber' => 60])
            </div>
            <!--end::Input group-->
        </div>
        @for($y = 1; $y <= 2; $y++)
            <div class="tab-pane fade" id="layout-60-{{ $y }}" role="tabpanel">
                <h2 class="fw-bold text-dark mb-6">Fundo</h2>
                <!--begin::Input group-->
                <div class="colors-parent-box mb-12">
                    @include('admin.pages.pages.components.layout.background', ['blockNumber' => 60, 'tabNumber' => $y])
                </div>
                <!--end::Input group-->
                <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
                <!--begin::Input group-->
                <div class="colors-parent-box mb-12">
                    @include('admin.pages.pages.components.layout.title', ['blockNumber' => 60, 'tabNumber' => $y])
                </div>
                <!--end::Input group-->
                <h2 class="fw-bold text-dark mb-6">Botão</h2>
                <!--begin::Input group-->
                <div class="colors-parent-box">
                    @include('admin.pages.pages.components.layout.button', ['blockNumber' => 60, 'tabNumber' => $y])
                </div>
                <!--end::Input group-->
            </div>
        @endfor
    </div>
</div>
<!--end::LAYOUT 60-->
