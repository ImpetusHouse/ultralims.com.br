<div class="color-box-parent">
    <div class="color-box">
        <p>
            {{ $titleLabel ?? 'Ícone' }}
        </p>
        <div class="color-select" style="background-color: {{ $contentColor->color }}" id="icon_color_{{ $blockNumber }}{{ isset($tabNumber) ? '_'.$tabNumber:'' }}"></div>
        <div class="colors-box">
            @foreach($colors as $color)
                <div class="color-input" style="background-color: {!! $color->color !!}"></div>
            @endforeach
        </div>
    </div>
</div>
