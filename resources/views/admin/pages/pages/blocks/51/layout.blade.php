<!--begin::LAYOUT 51-->
<div id="div-layout-51" class="w-100 mw-600px" style="display: none">
    @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 51, 'required' => 'required', 'margin' => 'mb-9'])
    @include('admin.pages.pages.components.layout.content_alignment', ['blockNumber' => 51, 'required' => 'required', 'margin' => 'mb-9', 'titleLabel' => 'Alinhamento (Imagem)'])
    <h2 class="fw-bold text-dark mb-6">Fundo</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.background', ['blockNumber' => 51])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.title', ['blockNumber' => 51])
        @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 51])
        @include('admin.pages.pages.components.layout.description', ['blockNumber' => 51])
    </div>
    <!--end::Input group-->
    <h2 class="fw-bold text-dark mb-6">Depoimento</h2>
    <!--begin::Input group-->
    <div class="colors-parent-box mb-12">
        @include('admin.pages.pages.components.layout.primary_color', ['blockNumber' => 51, 'titleLabel' => 'Nome'])
        @include('admin.pages.pages.components.layout.tag', ['blockNumber' => 51, 'titleLabel' => 'Subtítulo'])
        @include('admin.pages.pages.components.layout.tag-title', ['blockNumber' => 51, 'titleLabel' => 'Depoimento'])
    </div>
    <!--end::Input group-->
</div>
<!--end::LAYOUT 9-->
