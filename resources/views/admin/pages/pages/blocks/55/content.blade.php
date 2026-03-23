<!--begin::CONTEÚDO 55-->
<div id="content-55" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item text-center" style="width: 25%">
            <a class="nav-link active" data-bs-toggle="tab" href="#content-55-0">Geral</a>
        </li>
        @for($y = 1; $y <= 3; $y++)
            <li class="nav-item text-center" style="width: 25%">
                <a class="nav-link" data-bs-toggle="tab" href="#content-55-{{ $y }}">Aba {{ $y }}</a>
            </li>
        @endfor
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="content-55-0" role="tabpanel">
            @include('admin.pages.pages.components.tag', ['blockNumber' => 55, 'required' => 'required', 'margin' => 'mb-9'])
            @include('admin.pages.pages.components.title', ['blockNumber' => 55, 'required' => 'required', 'margin' => 'mb-9'])
            @include('admin.pages.pages.components.description', ['blockNumber' => 55, 'required' => 'required', 'margin' => null])
        </div>
        @for($y = 1; $y <= 3; $y++)
            <div class="tab-pane fade" id="content-55-{{ $y }}" role="tabpanel">
                @include('admin.pages.pages.components.title-single', ['blockNumber' => 55, 'tabNumber' => $y, 'required' => ($y == 1 ? 'required':''), 'margin' => 'mb-9'])
                @include('admin.pages.pages.components.subtitle-textarea', ['blockNumber' => 55, 'tabNumber' => $y, 'required' => 'required', 'margin' => 'mb-9'])
                @include('admin.pages.pages.components.number', ['blockNumber' => 55, 'tabNumber' => $y, 'required' => null, 'margin' => 'mb-9', 'titleLabel' => 'Subtítulo'])
                @include('admin.pages.pages.components.image', ['blockNumber' => 55, 'tabNumber' => $y, 'required' => ($y == 1 ? 'required':''), 'margin' => 'mb-9'])
                @include('admin.pages.pages.components.button', ['blockNumber' => 55, 'tabNumber' => $y])
            </div>
        @endfor
    </div>
</div>
<!--end::CONTEÚDO 55-->
