<!--begin::Input group-->
<div class="row {{ isset($margin) ? $margin:'' }}">
    <div class="col-2">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold mb-2">{{ isset($titleBtn) ? $titleBtn:'Botão' }}</label>
        <!--end::Label-->
        <!--begin::Input-->
        <label class="form-check form-switch form-check-custom form-check-solid">
            <input class="form-check-input" type="checkbox" value="1" onchange="changeButtonDisplay(this, {{ $blockNumber }}, {{ isset($tabNumber) ? $tabNumber: 0 }}, {{ isset($buttonOne) }})" name="button_display{{ isset($buttonOne) }}_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber : '' }}" id="button_display{{ isset($buttonOne) }}_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}">
        </label>
        <!--end::Input-->
    </div>
    @if(!isset($hideTitle))
        <div class="col-10" id="div{{ isset($buttonOne) }}-button-title-{{ $blockNumber }}{{ isset($tabNumber) ? '-'.$tabNumber:'' }}" style="display: none">
            <!--begin::Label-->
            <div class="w-full d-flex justify-content-between">
                <label class="fs-6 fw-semibold required mb-2 d-flex justify-content-between">
                    Titulo
                    <span id="selected-font-button_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" class="ml-2"></span>
                </label>
                <div class="d-flex align-items-center">
                    @include('admin.pages.pages.components.font', ['blockNumber' => $blockNumber, 'tabNumber' => ($tabNumber ?? null), 'type' => 'button', 'input' => 'button'])
                </div>
            </div>
            <!--end::Label-->
            <!--begin::Input-->
            <input class="form-control mb-2" name="button_title{{ isset($buttonOne) }}_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" id="button_title{{ isset($buttonOne) }}_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}">
            <!--end::Input-->
        </div>
        <div class="col-2">
        </div>
    @endif
    <div class="col-5" id="div{{ isset($buttonOne) }}-button-type-{{ $blockNumber }}{{ isset($tabNumber) ? '-'.$tabNumber:'' }}" style="display: none">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Destino</label>
        <!--end::Label-->
        <!--begin::Input-->
        <select class="form-select mb-2" data-control="select2"
                onchange="changeButtonType(this, {{ $blockNumber }}, {{ isset($tabNumber) ? $tabNumber: 0 }}, {{ isset($buttonOne) }})"
                data-hide-search="true" data-placeholder="Selecione uma opção"
                name="button_type{{ isset($buttonOne) }}_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" id="button_type{{ isset($buttonOne) }}_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}">
            <option></option>
            <option value="inner_page">Página interna</option>
            <option value="link">URL</option>
            <option value="cta">CTA</option>
        </select>
        <!--end::Input-->
    </div>
    <div class="col-5" id="div{{ isset($buttonOne) }}-button-link-{{ $blockNumber }}{{ isset($tabNumber) ? '-'.$tabNumber:'' }}" style="display: none">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Página</label>
        <!--end::Label-->
        <!--begin::Input-->
        <select class="form-select mb-2" data-control="select2"
                data-hide-search="true" data-placeholder="Selecione uma opção"
                name="button_pagina{{ isset($buttonOne) }}_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" id="button_pagina{{ isset($buttonOne) }}_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}">
            <option></option>
            @foreach($pages as $itemPage)
                <option value="{{ $itemPage->id }}">{{ $itemPage->title }}</option>
            @endforeach
        </select>
        <!--end::Input-->
    </div>
    <div class="col-5" id="div{{ isset($buttonOne) }}-url-link-{{ $blockNumber }}{{ isset($tabNumber) ? '-'.$tabNumber:'' }}" style="display: none">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Link</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control"
               name="button_url{{ isset($buttonOne) }}_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" id="button_url{{ isset($buttonOne) }}_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}">
        <!--end::Input-->
    </div>
</div>
<!--end::Input group-->
