<!--begin::CONTEÚDO 56-->
<div id="content-56" class="w-100 mw-600px" style="display: none">
    <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
        <li class="nav-item text-center" style="width: 20%">
            <a class="nav-link active" data-bs-toggle="tab" href="#content-56-0">Geral</a>
        </li>
        @for($y = 1; $y <= 4; $y++)
            <li class="nav-item text-center" style="width: 20%">
                <a class="nav-link" data-bs-toggle="tab" href="#content-56-{{ $y }}">Aba {{ $y }}</a>
            </li>
        @endfor
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="content-56-0" role="tabpanel">
            @include('admin.pages.pages.components.tag', ['blockNumber' => 56, 'required' => null, 'margin' => 'mb-9'])
            @include('admin.pages.pages.components.title', ['blockNumber' => 56, 'required' => 'required', 'margin' => 'mb-9'])
            @include('admin.pages.pages.components.description', ['blockNumber' => 56, 'required' => 'required', 'margin' => 'mb-9'])
            @include('admin.pages.pages.components.image', ['blockNumber' => 56, 'required' => null, 'margin' => 'mb-9', 'titleLabel' => 'Pattern'])
            @include('admin.pages.pages.components.button', ['blockNumber' => 56])
        </div>
        @for($y = 1; $y <= 4; $y++)
            <div class="tab-pane fade" id="content-56-{{ $y }}" role="tabpanel">
                @include('admin.pages.pages.components.title-single', ['blockNumber' => 56, 'tabNumber' => $y, 'required' => 'required', 'margin' => 'mb-9'])
                @include('admin.pages.pages.components.subtitle-textarea', ['blockNumber' => 56, 'tabNumber' => $y, 'required' => 'required', 'margin' => 'mb-9'])
                @include('admin.pages.pages.components.image', ['blockNumber' => 56, 'tabNumber' => $y, 'required' => 'required', 'margin' => null])
            </div>
        @endfor
    </div>
</div>
<!--end::CONTEÚDO 56-->
