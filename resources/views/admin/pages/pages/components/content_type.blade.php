<div class="row mb-9">
    <div class="col-6">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold {{ $required ?? 'required' }} mb-2">Tipo do conteúdo</label>
        <!--end::Label-->
        <!--begin::Input-->
        <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="content_type_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" name="content_type_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" onchange="changeContentType({{ $blockNumber }}, this {!! isset($tabNumber) ? ', '.$tabNumber:'' !!})">
            <option></option>
            <option value="image">Imagem</option>
            <option value="youtube_embed">Youtube</option>
        </select>
        <!--end::Input-->
    </div>
    <div class="col-6">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2" id="label_content_type_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}">Imagem</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="file" accept="image/*" class="form-control" name="image_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" id="image_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" />
        <input type="file" accept="video/*" class="form-control" name="video_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" id="video_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}" />
        <!--end::Input-->
    </div>
</div>
