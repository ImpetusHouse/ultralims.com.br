<div class="row {{ $margin }}">
    <!--begin::Label-->
    <label class="fs-6 fw-semibold {{ $required }} mb-2">Layout (Botão)</label>
    <!--end::Label-->
    <!--begin::Input-->
    <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="type_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" name="type_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}">
        <option></option>
        <option value="1">Layout 1</option>
        <option value="2">Layout 2</option>
        <option value="3">Layout 3</option>
        <option value="4">Layout 4</option>
    </select>
    <!--end::Input-->
</div>
