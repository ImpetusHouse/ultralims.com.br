<!--begin::LAYOUT 67-->
<div id="div-layout-67" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link active" data-bs-toggle="tab" href="#layout-67-0">Geral</a>
        </li>
        @for($y = 1; $y <= 4; $y++)
            <li class="nav-item text-center" style="width: 20%">
                <a class="nav-link" data-bs-toggle="tab" href="#layout-67-{{ $y }}">Aba {{ $y }}</a>
            </li>
        @endfor
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="layout-67-0" role="tabpanel">
            @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 67, 'required' => 'required', 'margin' => 'mb-9'])
            <h2 class="fw-bold text-dark mb-6">Fundo</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box mb-12">
                @include('admin.pages.pages.components.layout.background', ['blockNumber' => 67])
            </div>
            <!--end::Input group-->
        </div>
        @for($y = 1; $y <= 4; $y++)
            <div class="tab-pane fade" id="layout-67-{{ $y }}" role="tabpanel">
                <h2 class="fw-bold text-dark mb-6">Fundo</h2>
                <!--begin::Input group-->
                <div class="colors-parent-box mb-12">
                    @include('admin.pages.pages.components.layout.background', ['blockNumber' => 67, 'tabNumber' => $y])
                </div>
                <!--end::Input group-->
                <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
                <!--begin::Input group-->
                <div class="colors-parent-box">
                    @include('admin.pages.pages.components.layout.icon', ['blockNumber' => 67, 'tabNumber' => $y])
                    @include('admin.pages.pages.components.layout.title', ['blockNumber' => 67, 'tabNumber' => $y, 'titleLabel' => 'Título'])
                    @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 67, 'tabNumber' => $y, 'titleLabel' => 'Descrição'])
                </div>
                <!--end::Input group-->
            </div>
        @endfor
    </div>
</div>
<!--end::LAYOUT 67-->
