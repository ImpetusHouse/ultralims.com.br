<div class="row {{ $margin }}">
    <!--begin::Label-->
    <label class="fs-6 fw-semibold {{ $required }} mb-2">{{ $titleLabel ?? 'Exibir conteúdo' }}</label>
    <!--end::Label-->
    <!--begin::Input-->
    <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="display_content_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" name="display_content_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}">
        <option></option>
        <option value="1">Sim</option>
        <option value="0">Não</option>
    </select>
    <!--end::Input-->
</div>
