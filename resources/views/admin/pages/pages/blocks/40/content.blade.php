<!--begin::CONTEÚDO 40-->
<div id="content-40" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link active" data-bs-toggle="tab" href="#content-40-0">Geral</a>
        </li>
        @for($y = 1; $y <= 4; $y++)
            <li class="nav-item text-center" style="width: 20%">
                <a class="nav-link" data-bs-toggle="tab" href="#content-40-{{ $y }}">Aba {{ $y }}</a>
            </li>
        @endfor
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="content-40-0" role="tabpanel">
            @include('admin.pages.pages.components.title', ['blockNumber' => 40, 'required' => 'required', 'margin' => 'mb-9'])
            @include('admin.pages.pages.components.description', ['blockNumber' => 40, 'required' => 'required', 'margin' => 'mb-9'])
            <div class="row">
                <div class="col-6">
                    @include('admin.pages.pages.components.image', ['blockNumber' => 40, 'required' => 'required', 'margin' => 'mb-9'])
                </div>
                <div class="col-6">
                    @include('admin.pages.pages.components.logo', ['blockNumber' => 40, 'required' => null, 'margin' => 'mb-9', 'titleLabel' => 'Fundo'])
                </div>
            </div>
            @include('admin.pages.pages.components.button', ['blockNumber' => 40, 'margin' => 'mb-9'])
            @include('admin.pages.pages.components.button', ['blockNumber' => 40, 'buttonOne' => true, 'titleBtn' => 'Botão 2'])
        </div>
        @for($y = 1; $y <= 4; $y++)
            <div class="tab-pane fade" id="content-40-{{ $y }}" role="tabpanel">
                <input type="hidden" value="Aba {{ $y }}" name="title_40_{{ $y }}">
                <!--begin::Input group-->
                <div class="fv-row mb-9">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2">Exibir imagem?</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção"
                            id="display_image_40_{{ $y }}" name="display_image_40_{{ $y }}">
                        <option></option>
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
                @include('admin.pages.pages.components.image', ['blockNumber' => 40, 'tabNumber' => $y, 'required' => 'required', 'margin' => null])
            </div>
        @endfor
    </div>
</div>
<!--end::CONTEÚDO 40-->
