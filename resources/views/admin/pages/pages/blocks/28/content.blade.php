<!--begin::CONTEÚDO 28-->
<div id="content-28" class="w-100 mw-600px" style="display: none">
    <!--begin::Input group-->
    <div class="fv-row">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">Comunicados</label>
        <!--end::Label-->
        <!--begin::Input-->
        <select class="form-select" data-control="select2" data-placeholder="Selecione um evento" multiple="multiple" name="events_28[]" id="events_28">
            <option></option>
            @foreach(\App\Models\General\Events\Event::orderBy('title')->get() as $event)
                <option value="{{ $event->id }}">{{ $event->title }}</option>
            @endforeach
        </select>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
</div>
<!--end::CONTEÚDO 28-->
