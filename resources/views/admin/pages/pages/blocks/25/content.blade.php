<!--begin::CONTEÚDO 25-->
<div id="content-25" class="w-100 mw-600px" style="display: none">
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Título 1</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="title_25" id="title_25" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold mb-2">Título 2</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input type="text" class="form-control" name="subtitle_25" id="subtitle_25" />
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Descrição</label>
        <!--end::Label-->
        <!--begin::Input-->
        <textarea class="form-control resize-none" name="content_25" id="content_25" rows="4" style="resize: none"></textarea>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    <!--begin::Input group-->
    <div class="fv-row">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Eventos</label>
        <!--end::Label-->
        <!--begin::Input-->
        <select class="form-select" data-control="select2" data-placeholder="Selecione um evento" multiple="multiple" name="events_25[]" id="events_25">
            <option></option>
            @foreach(\App\Models\General\Events\Event::orderBy('title')->get() as $event)
                <option value="{{ $event->id }}">{{ $event->title }}</option>
            @endforeach
        </select>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
</div>
<!--end::CONTEÚDO 25-->
