<!--begin::CONTEÚDO 57-->
<div id="content-57" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item text-center" style="width: 25%">
            <a class="nav-link active" data-bs-toggle="tab" href="#content-57-0">Geral</a>
        </li>
        @for($y = 1; $y <= 3; $y++)
            <li class="nav-item text-center" style="width: 25%">
                <a class="nav-link" data-bs-toggle="tab" href="#content-57-{{ $y }}">Aba {{ $y }}</a>
            </li>
        @endfor
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="content-57-0" role="tabpanel">
            @include('admin.pages.pages.components.tag', ['blockNumber' => 57, 'required' => null, 'margin' => 'mb-9'])
            @include('admin.pages.pages.components.title', ['blockNumber' => 57, 'required' => 'required', 'margin' => 'mb-9'])
            @include('admin.pages.pages.components.description', ['blockNumber' => 57, 'required' => 'required', 'margin' => null])
        </div>
        @for($y = 1; $y <= 3; $y++)
            <div class="tab-pane fade" id="content-57-{{ $y }}" role="tabpanel">
                @include('admin.pages.pages.components.title-single', ['blockNumber' => 57, 'tabNumber' => $y, 'required' => 'required', 'margin' => 'mb-9'])
                @include('admin.pages.pages.components.subtitle-textarea', ['blockNumber' => 57, 'tabNumber' => $y, 'required' => 'required', 'margin' => 'mb-9'])
                @include('admin.pages.pages.components.image', ['blockNumber' => 57, 'tabNumber' => $y, 'required' => 'required', 'margin' => null, 'titleLabel' => 'Ícone'])
            </div>
        @endfor
    </div>
</div>
<!--end::CONTEÚDO 57-->
