@extends('site.layout')
@section('content')
    @php
        if (isset($_GET['fonte'])){
            $page = \App\Models\Pages\Page::where('slug', $_GET['fonte'])->first();
        }else{
            $page = null;
        }
        if ($page){
            $blockLast = \App\Models\Pages\Block::where('page_id', $page->id)->where('layout', '18')->first();
        }else{
            $blockLast = null;
        }

        /** @var TYPE_NAME $analysisGroup */
        $analysisGroupName = $analysisGroup->name;
        // Explode the string into an array of words
        $words = explode(' ', $analysisGroupName);
        // Check if there are more than 4 words
        if (count($words) > 4) {
            // Extract the last 3 words as subtitle
            $subtitle = implode(' ', array_slice($words, -3));
            // Extract the remaining words as title
            $title = implode(' ', array_slice($words, 0, -3));
        } else {
            // If there are 4 or fewer words, use the entire name as title
            $title = $analysisGroupName;
            $subtitle = '';
        }

        $block = new \App\Models\Pages\Block();
        $block->id = 99999;
        $block->layout = 18;
        $block->font_title = 5;
        $block->font_subtitle = 5;
        $block->font_description = 3;
        $block->font_button = 4;

        $block->margin_top = 15;
        $block->margin_bottom = 15;
        $block->background_color = 'rgb(41, 63, 87)';
        $block->primary_color = 'rgb(21, 32, 44)';
        $block->content_alignment = 'right';

        $block->email = '1';
        $block->button_title_1 = $analysisGroup->name;
        $block->type = '3';

        $block->tag = 'Análises';
        $block->tag_color = 'rgb(230, 158, 46)';
        $block->tag_title_color = 'rgb(255, 255, 255)';

        $block->title = $title;
        $block->title_color = 'rgb(255, 255, 255)';
        $block->subtitle = $subtitle;
        $block->subtitle_color = 'rgb(96, 167, 170)';
        $block->content = 'Preencha o formulário e em breve um de nossos especialistas entrará em contato com você. Se preferir, você pode nos chamar via whatsapp.';
        $block->content_color = 'rgb(255, 255, 255)';

        $block->button_display = $blockLast ? $blockLast->button_display : 1;
        $block->button_type = $blockLast ? $blockLast->button_type : 'link';
        $block->button_link = $blockLast ? $blockLast->button_link : '/obrigado';

        $block->button_title = 'Enviar';
        $block->button_color = 'rgb(230, 158, 46)';
        $block->button_title_color = 'rgb(255, 255, 255)';

        $block->button_color_1 = 'rgb(41, 63, 87)';
        $block->button_title_color_1 = 'rgb(255, 255, 255)';

        $block->testimonials = json_encode([]);
    @endphp
    @include('site.inc.blocos.bloco_' . $block->layout . '.index', ['i' => 1])
    @php
        /** @var TYPE_NAME $analysisGroup */
        $block = new \App\Models\Pages\Block();
        $block->layout = 31;
        $block->margin_top = 60;
        $block->margin_bottom = 60;
        $block->background_color = '#FFF';
        $block->title_color = '#737276';
        $block->content_color = '#737276';
        $block->title = $analysisGroup->name;
        $block->content = $analysisGroup->content;
    @endphp
    @include('site.inc.blocos.bloco_' . $block->layout . '.index', ['i' => 2])
@endsection
