<div class="fv-row {{ $margin }}">
    <!--begin::Label-->
    <div class="w-full d-flex justify-content-between">
        <label class="fs-6 fw-semibold {{ $required }} mb-2 d-flex align-items-center">
            Descrição
            <span id="selected-font-subtitle_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" class="ml-2"></span>
        </label>
        <div>
            <div class="d-flex align-items-center">
                @include('admin.pages.pages.components.font', ['blockNumber' => $blockNumber, 'tabNumber' => ($tabNumber ?? null), 'type' => 'description', 'input' => 'description'])
            </div>
        </div>
    </div>
    <!--begin::Input-->
    <textarea rows="3" class="form-control resize-none" name="subtitle_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" id="subtitle_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}"></textarea>
    <!--end::Input-->
</div>
