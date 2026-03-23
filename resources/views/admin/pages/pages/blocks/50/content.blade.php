<!--begin::CONTEÚDO 50-->
<div id="content-50" class="w-100 mw-600px" style="display: none">
    @include('admin.pages.pages.components.title', ['blockNumber' => 50, 'required' => 'required', 'margin' => 'mb-9'])
    @include('admin.pages.pages.components.description', ['blockNumber' => 50, 'required' => 'required', 'margin' => 'mb-9'])
    @include('admin.pages.pages.components.image', ['blockNumber' => 50, 'required' => 'required', 'margin' => 'mb-9'])
    <!--begin::Input group-->
    <div class="row mb-9">
        <div class="col-6">
            @include('admin.pages.pages.components.image', ['blockNumber' => 50, 'tabNumber' => 1, 'required' => null, 'margin' => 'mb-9', 'titleLabel' => 'Pattern (Esquerda)'])
        </div>
        <div class="col-6">
            @include('admin.pages.pages.components.image', ['blockNumber' => 50, 'tabNumber' => 2, 'required' => null, 'margin' => 'mb-9', 'titleLabel' => 'Pattern (Direita)'])
        </div>
    </div>
    <!--end::Input group-->
    @include('admin.pages.pages.components.button', ['blockNumber' => 50])
</div>
<!--end::CONTEÚDO 50-->
