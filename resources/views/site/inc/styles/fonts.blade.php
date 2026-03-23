<style>
    @php
        /** @var TYPE_NAME $block */
        /** @var TYPE_NAME $tab */

        $titleFont = null;
        if ($block->id > 0 || $tab->id > 0){
            if ($block->id > 0 && $tab->id > 0){
                $titleFont = \App\Models\Settings\Font::where('id', $tab->font_title)->first();
            }else{
                $titleFont = \App\Models\Settings\Font::where('id', $block->font_title)->first();
            }
        }
        if (!$titleFont){
            $titleFont = \App\Models\Settings\Font::where('default', true)->where('type', 'title')->first();
        }

        $subtitleFont = null;
        if ($block->id > 0 || $tab->id > 0){
            if ($block->id > 0 && $tab->id > 0){
                $subtitleFont = \App\Models\Settings\Font::where('id', $tab->font_subtitle)->first();
            }else{
                $subtitleFont = \App\Models\Settings\Font::where('id', $block->font_subtitle)->first();
            }
        }
        if (!$subtitleFont){
            $subtitleFont = \App\Models\Settings\Font::where('default', true)->where('type', 'title')->first();
        }

        $descriptionFont = null;
        if ($block->id > 0 || $tab->id > 0){
            if ($block->id > 0 && $tab->id > 0){
                $descriptionFont = \App\Models\Settings\Font::where('id', $tab->font_description)->first();
            }else{
                $descriptionFont = \App\Models\Settings\Font::where('id', $block->font_description)->first();
            }
        }
        if (!$descriptionFont){
            $descriptionFont = \App\Models\Settings\Font::where('default', true)->where('type', 'description')->first();
        }

        $buttonFont = null;
        if ($block->id > 0 || $tab->id > 0){
            if ($block->id > 0 && $tab->id > 0){
                $buttonFont = \App\Models\Settings\Font::where('id', $tab->font_button)->first();
            }else{
                $buttonFont = \App\Models\Settings\Font::where('id', $block->font_button)->first();
            }
        }
        if (!$buttonFont){
            $buttonFont = \App\Models\Settings\Font::where('default', true)->where('type', 'button')->first();
        }
    @endphp
    {{-- SM --}}
    .block-title{{ $block->id > 0 ? '-'.$block->id:'' }}{{ $tab->id > 0 ? '-'.$tab->id:'' }}{
        font-size: {{ $titleFont->mobile }}px !important;
        line-height: {{ $titleFont->line_spacing }};
        @if($titleFont->is_bold)
            font-weight: black;
        @else
            font-weight: normal;
        @endif
    }
    .block-subtitle{{ $block->id > 0 ? '-'.$block->id:'' }}{{ $tab->id > 0 ? '-'.$tab->id:'' }}{
        font-size: {{ $subtitleFont->mobile }}px !important;
        line-height: {{ $subtitleFont->line_spacing }};
        @if($subtitleFont->is_bold)
            font-weight: black;
        @else
            font-weight: normal;
        @endif
    }
    .block-description{{ $block->id > 0 ? '-'.$block->id:'' }}{{ $tab->id > 0 ? '-'.$tab->id:'' }}{
        font-size: {{ $descriptionFont->mobile }}px !important;
        line-height: {{ $descriptionFont->line_spacing }};
        @if($descriptionFont->is_bold)
            font-weight: black;
        @else
            font-weight: normal;
        @endif
    }
    .block-button-title{{ $block->id > 0 ? '-'.$block->id:'' }}{{ $tab->id > 0 ? '-'.$tab->id:'' }}{
        font-size: {{ $buttonFont->mobile }}px !important;
        line-height: {{ $buttonFont->line_spacing }};
        @if($buttonFont->is_bold)
            font-weight: 600;
        @else
            font-weight: normal;
        @endif
    }
    @media (min-width: 640px) {
        .block-title{{ $block->id > 0 ? '-'.$block->id:'' }}{{ $tab->id > 0 ? '-'.$tab->id:'' }}{
            font-size: {{ $titleFont->mobile }}px !important;
        }
        .block-subtitle{{ $block->id > 0 ? '-'.$block->id:'' }}{{ $tab->id > 0 ? '-'.$tab->id:'' }}{
            font-size: {{ $subtitleFont->mobile }}px !important;
        }
        .block-description{{ $block->id > 0 ? '-'.$block->id:'' }}{{ $tab->id > 0 ? '-'.$tab->id:'' }}{
            font-size: {{ $descriptionFont->mobile }}px !important;
        }
        .block-button-title{{ $block->id > 0 ? '-'.$block->id:'' }}{{ $tab->id > 0 ? '-'.$tab->id:'' }}{
            font-size: {{ $buttonFont->mobile }}px !important;
        }
    }
    {{-- MD --}}
    @media (min-width: 768px) {
        .block-title{{ $block->id > 0 ? '-'.$block->id:'' }}{{ $tab->id > 0 ? '-'.$tab->id:'' }}{
            font-size: {{ $titleFont->desktop }}px !important;
        }
        .block-subtitle{{ $block->id > 0 ? '-'.$block->id:'' }}{{ $tab->id > 0 ? '-'.$tab->id:'' }}{
            font-size: {{ $subtitleFont->desktop }}px !important;
        }
        .block-description{{ $block->id > 0 ? '-'.$block->id:'' }}{{ $tab->id > 0 ? '-'.$tab->id:'' }}{
            font-size: {{ $descriptionFont->desktop }}px !important;
        }
        .block-button-title{{ $block->id > 0 ? '-'.$block->id:'' }}{{ $tab->id > 0 ? '-'.$tab->id:'' }}{
            font-size: {{ $buttonFont->desktop }}px !important;
        }
    }
    {{-- LG --}}
    @media (min-width: 1024px) {
        .block-title{{ $block->id > 0 ? '-'.$block->id:'' }}{{ $tab->id > 0 ? '-'.$tab->id:'' }}{
            font-size: {{ $titleFont->desktop }}px !important;
        }
        .block-subtitle{{ $block->id > 0 ? '-'.$block->id:'' }}{{ $tab->id > 0 ? '-'.$tab->id:'' }}{
            font-size: {{ $subtitleFont->desktop }}px !important;
        }
        .block-description{{ $block->id > 0 ? '-'.$block->id:'' }}{{ $tab->id > 0 ? '-'.$tab->id:'' }}{
            font-size: {{ $descriptionFont->desktop }}px !important;
        }
        .block-button-title{{ $block->id > 0 ? '-'.$block->id:'' }}{{ $tab->id > 0 ? '-'.$tab->id:'' }}{
            font-size: {{ $buttonFont->desktop }}px !important;
        }
    }
    {{-- XL --}}
    @media (min-width: 1140px) {
        .block-title{{ $block->id > 0 ? '-'.$block->id:'' }}{{ $tab->id > 0 ? '-'.$tab->id:'' }}{
            font-size: {{ $titleFont->desktop }}px !important;
        }
        .block-subtitle{{ $block->id > 0 ? '-'.$block->id:'' }}{{ $tab->id > 0 ? '-'.$tab->id:'' }}{
            font-size: {{ $subtitleFont->desktop }}px !important;
        }
        .block-description{{ $block->id > 0 ? '-'.$block->id:'' }}{{ $tab->id > 0 ? '-'.$tab->id:'' }}{
            font-size: {{ $descriptionFont->desktop }}px !important;
        }
        .block-button-title{{ $block->id > 0 ? '-'.$block->id:'' }}{{ $tab->id > 0 ? '-'.$tab->id:'' }}{
            font-size: {{ $buttonFont->desktop }}px !important;
        }
    }
</style>
