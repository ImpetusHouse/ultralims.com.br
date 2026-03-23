<!--begin::CONTEÚDO 71-->
<div id="content-71" class="w-100 mw-600px" style="display: none">
    @include('admin.pages.pages.components.title', ['blockNumber' => 71, 'required' => 'required', 'margin' => 'mb-9'])
    @include('admin.pages.pages.components.description', ['blockNumber' => 71, 'required' => 'required', 'margin' => 'mb-9'])
    <!--begin::Input group-->
    <div class="fv-row mb-9">
        <!--begin::Label-->
        <label class="fs-6 fw-semibold required mb-2">E-mail</label>
        <!--end::Label-->
        <!--begin::Input-->
        <select class="form-select" data-control="select2" data-placeholder="Selecione uma categoria" name="email_71" id="email_71">
            <option></option>
            @foreach(\App\Models\Settings\Email::orderBy('title')->where('status', true)->get() as $email)
                <option value="{{ $email->id }}">{{ $email->title }}</option>
            @endforeach
        </select>
        <!--end::Input-->
    </div>
    <!--end::Input group-->
    @include('admin.pages.pages.components.button', ['blockNumber' => 71, 'titleBtn' => 'Redirecionamento'])
</div>
<!--end::CONTEÚDO 71-->
