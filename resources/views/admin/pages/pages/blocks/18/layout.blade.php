<!--begin::LAYOUT 18-->
<div id="div-layout-18" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item text-center" style="width: 50%">
            <a class="nav-link active" data-bs-toggle="tab" href="#layout-18-0">Geral</a>
        </li>
        @for($y = 1; $y <= 1; $y++)
            <li class="nav-item text-center" style="width: 50%">
                <a class="nav-link" data-bs-toggle="tab" href="#layout-18-{{ $y }}">Aba {{ $y }}</a>
            </li>
        @endfor
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="layout-18-0" role="tabpanel">
            @include('admin.pages.pages.components.layout.margin', ['blockNumber' => 18, 'required' => 'required', 'margin' => 'mb-9'])
            <div class="row">
                <div class="col-md-6">
                    @include('admin.pages.pages.components.layout.content_alignment', ['blockNumber' => 18, 'required' => 'required', 'margin' => 'mb-9', 'titleLabel' => 'Alinhamento (Formulário)'])
                </div>
                <div class="col-md-6">
                    <!--begin::Input group-->
                    <div class="fv-row mb-9">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold required mb-2">Conteúdo</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select class="form-select mb-2" data-control="select2" data-hide-search="true" data-placeholder="Selecione uma opção" id="content_type_18" name="content_type_18">
                            <option></option>
                            <option value="image">Depoimento</option>
                            <option value="video">Informações</option>
                        </select>
                        <!--end::Input-->
                    </div>
                    <!--end::Input group-->
                </div>
            </div>
            <h2 class="fw-bold text-dark mb-6">Fundo</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box mb-12">
                @include('admin.pages.pages.components.layout.background', ['blockNumber' => 18])
                @include('admin.pages.pages.components.layout.primary_color', ['blockNumber' => 18, 'titleLabel' => 'Formulário'])
            </div>
            <!--end::Input group-->
            <h2 class="fw-bold text-dark mb-6">Tag</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box mb-12">
                @include('admin.pages.pages.components.layout.tag', ['blockNumber' => 18])
                @include('admin.pages.pages.components.layout.tag-title', ['blockNumber' => 18])
            </div>
            <!--end::Input group-->
            <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box mb-12">
                @include('admin.pages.pages.components.layout.title', ['blockNumber' => 18])
                @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 18])
                @include('admin.pages.pages.components.layout.description', ['blockNumber' => 18])
            </div>
            <!--end::Input group-->
            <h2 class="fw-bold text-dark mb-6">Formulário</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box mb-12">
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>
                            Bordas
                        </p>
                        <div class="color-select" style="background-color: #151624" id="button_color1_18"></div>
                        <div class="colors-box">
                            @foreach($colors as $color)
                                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>
                            Texto
                        </p>
                        <div class="color-select" style="background-color: {{ $contentColor->color }}" id="button_title_color1_18"></div>
                        <div class="colors-box">
                            @foreach($colors as $color)
                                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Input group-->
            <h2 class="fw-bold text-dark mb-6">Depoimento</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box mb-12">
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>
                            Nome
                        </p>
                        <div class="color-select" style="background-color: {{$titleColor->color}}" id="pdf_title_color_18"></div>
                        <div class="colors-box">
                            @foreach($colors as $color)
                                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>
                            Subtítulo
                        </p>
                        <div class="color-select" style="background-color: {{ $contentColor->color }}" id="pdf_color_18"></div>
                        <div class="colors-box">
                            @foreach($colors as $color)
                                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="color-box-parent">
                    <div class="color-box">
                        <p>
                            Depoimento
                        </p>
                        <div class="color-select" style="background-color: {{ $contentColor->color }}" id="divider_color_18"></div>
                        <div class="colors-box">
                            @foreach($colors as $color)
                                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Input group-->
            <h2 class="fw-bold text-dark mb-6">Botão</h2>
            <!--begin::Input group-->
            <div class="colors-parent-box">
                @include('admin.pages.pages.components.layout.button', ['blockNumber' => 18])
                @include('admin.pages.pages.components.layout.button-text', ['blockNumber' => 18])
            </div>
            <!--end::Input group-->
        </div>
        @for($y = 1; $y <= 1; $y++)
            <div class="tab-pane fade" id="layout-18-{{ $y }}" role="tabpanel">
                <h2 class="fw-bold text-dark mb-6">Tipografia</h2>
                <!--begin::Input group-->
                <div class="colors-parent-box">
                    @include('admin.pages.pages.components.layout.title', ['blockNumber' => 18, 'tabNumber' => $y])
                    @include('admin.pages.pages.components.layout.subtitle', ['blockNumber' => 18, 'tabNumber' => $y, 'titleLabel' => 'Descrição'])
                </div>
                <!--end::Input group-->
            </div>
        @endfor
    </div>
</div>
<!--end::LAYOUT 18-->
