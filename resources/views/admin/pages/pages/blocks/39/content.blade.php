<!--begin::CONTEÚDO 39-->
<div id="content-39" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link active" data-bs-toggle="tab" href="#content-39-0">Geral</a>
        </li>
        @for($y = 1; $y <= 4; $y++)
            <li class="nav-item text-center" style="width: 20%">
                <a class="nav-link" data-bs-toggle="tab" href="#content-39-{{ $y }}">Aba {{ $y }}</a>
            </li>
        @endfor
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="content-39-0" role="tabpanel">
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Título 1</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="title_39" id="title_39" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">Título 2</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="subtitle_39" id="subtitle_39" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2 required">Descrição</label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea class="form-control resize-none" name="content_39" id="content_39" rows="4" style="resize: none"></textarea>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">Fundo</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="file" accept="image/*" class="form-control" name="image_39" id="image_39" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            @include('admin.pages.pages.components.button', ['blockNumber' => 39, 'margin' => 'mb-9'])
            @include('admin.pages.pages.components.button', ['blockNumber' => 39, 'buttonOne' => true, 'titleBtn' => 'Botão 2'])
        </div>
        @for($y = 1; $y <= 4; $y++)
            <div class="tab-pane fade" id="content-39-{{ $y }}" role="tabpanel">
                <input type="hidden" value="Aba {{ $y }}" name="title_39_{{ $y }}">
                <!--begin::Input group-->
                <div class="fv-row mb-9">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold required mb-2">Imagem</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="file" accept="image/*" class="form-control" name="image_39_{{ $y }}" id="image_39_{{ $y }}" />
                    <!--end::Input-->
                </div>
                <!--end::Input group-->
            </div>
        @endfor
    </div>

</div>
<!--end::CONTEÚDO 39-->
