<!--begin::CONTEÚDO 18-->
<div id="content-18" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item text-center" style="width: 50%">
            <a class="nav-link active" data-bs-toggle="tab" href="#content-18-0">Geral</a>
        </li>
        @for($y = 1; $y <= 1; $y++)
            <li class="nav-item text-center" style="width: 50%">
                <a class="nav-link" data-bs-toggle="tab" href="#content-18-{{ $y }}">Aba {{ $y }}</a>
            </li>
        @endfor
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="content-18-0" role="tabpanel">
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Layout</label>
                <!--end::Label-->
                <!--begin::Input-->
                <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="type_18" name="type_18">
                    <option></option>
                    <option value="1">Contato</option>
                    <option value="3">Contato (Texto)</option>
                    <option value="2">CTA</option>
                </select>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            @include('admin.pages.pages.components.tag', ['blockNumber' => 18, 'required' => null, 'margin' => 'mb-9'])
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">Título (Ticket)</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control" name="button_title1_18" id="button_title1_18" />
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            @include('admin.pages.pages.components.title', ['blockNumber' => 18, 'required' => 'required', 'margin' => 'mb-9'])
            @include('admin.pages.pages.components.description', ['blockNumber' => 18, 'required' => 'required', 'margin' => 'mb-9'])
            @include('admin.pages.pages.components.testimonials', ['blockNumber' => 18, 'required' => null, 'margin' => 'mb-9'])
            <!--begin::Input group-->
            <div class="fv-row mb-9">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold required mb-2">E-mail</label>
                <!--end::Label-->
                <!--begin::Input-->
                <select class="form-select" data-control="select2" data-placeholder="Selecione uma categoria" name="email_18" id="email_18">
                    <option></option>
                    @foreach(\App\Models\Settings\Email::orderBy('title')->where('status', true)->get() as $email)
                        <option value="{{ $email->id }}">{{ $email->title }}</option>
                    @endforeach
                </select>
                <!--end::Input-->
            </div>
            <!--end::Input group-->
            @include('admin.pages.pages.components.button', ['blockNumber' => 18, 'titleBtn' => 'Redireciona',])
        </div>
        @for($y = 1; $y <= 1; $y++)
            <div class="tab-pane fade" id="content-18-{{ $y }}" role="tabpanel">
                @include('admin.pages.pages.components.title-single', ['blockNumber' => 18, 'tabNumber' => $y, 'required' => null, 'margin' => 'mb-9'])
                @include('admin.pages.pages.components.subtitle', ['blockNumber' => 18, 'tabNumber' => $y, 'required' => null, 'margin' => 'mb-9'])
                @include('admin.pages.pages.components.content_link', ['blockNumber' => 18, 'tabNumber' => $y, 'required' => null, 'margin' => 'mb-9'])
                @include('admin.pages.pages.components.image', ['blockNumber' => 18, 'tabNumber' => $y, 'required' => null, 'margin' => null])
            </div>
        @endfor
    </div>
</div>
<!--end::CONTEÚDO 18-->
