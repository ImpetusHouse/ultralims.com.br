<?php

namespace App\Http\Controllers\Admin\Pages;

use App\Http\Controllers\Controller;
use App\Models\Pages\Block;
use App\Models\Pages\Block_Tab;
use Buglinjo\LaravelWebp\Webp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BlocksController extends Controller
{
    public function edit(Block $block){

        if ($block->tabs){
            $block->tabs();
        }
        return $block;
    }

    public function store(Request $request){
        $json = $this->save(new Block(), $request, 'store');
        return $json;
    }

    public function update(Block $block, Request $request){
        $json = $this->save($block, $request, 'update');
        return $json;
    }

    public function destroy(Block $block){
        $block->delete();
        return response()->json([
            'success' => true,
            'message' => 'Bloco removido com sucesso!'
        ]);
    }

    public function save($block, $request, $action){
        if ($action == 'store'){
            $block->block_title = 'Bloco '.$request->layout;

            $lastBlock = Block::where('page_id', $request->page_id)->orderBy('display_order', 'desc')->first();
            if ($lastBlock == null){
                $display_order = 1;
            }else{
                $display_order = $lastBlock->display_order + 1;
            }
            $block->display_order = $display_order;
        }

        //$storage_service = new \App\Services\StorageService();

        DB::beginTransaction();
        try {
            $block->fill($request->input());
            $block = $this->setDataBlock($block, $request);
            $block->save();

            $directory = '/pages/bloco/' . $block->id;
            // Verifica se a pasta já existe, se não, cria com permissão 755
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory, 0755, true);
            }

            if ($request->has('image_' . $request->layout)) {
                $file = $request->file('image_' . $request->layout);
                $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '_' . date('Ymd_His');
                $extension = $file->getClientOriginalExtension();
                $path = 'storage/'.$file->storeAs($directory, $filename . '.' . $extension, 'public');
            } else {
                $path = $block->image;
            }

            if ($request->has('video_' . $request->layout)) {
                $file = $request->file('video_' . $request->layout);
                $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '_' . date('Ymd_His');
                $extension = $file->getClientOriginalExtension();
                $video = 'storage/'.$file->storeAs($directory, $filename . '.' . $extension, 'public');
            } else {
                $video = $block->video;
            }

            if ($request->has('pdf_' . $request->layout)) {
                $file = $request->file('pdf_' . $request->layout);
                $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '_' . date('Ymd_His');
                $extension = $file->getClientOriginalExtension();
                $pdf = 'storage/'.$file->storeAs($directory, $filename . '.' . $extension, 'public');
            } else {
                $pdf = $block->pdf;
            }

            if ($request->has('logo_' . $request->layout)) {
                $file = $request->file('logo_' . $request->layout);
                $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '_' . date('Ymd_His');
                $extension = $file->getClientOriginalExtension();
                $logo = 'storage/'.$file->storeAs($directory, $filename . '.' . $extension, 'public');
            } else {
                $logo = $block->logo;
            }

            $block->image = $path;
            $block->video = $video;
            $block->pdf = $pdf;
            $block->logo = $logo;
            $block->save();

            for ($i = 1; $i <= 6; $i++){
                $this->setDataTab($block, $request, $i);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => "Bloco salvo com sucesso"
            ]);
        }catch(\Exception $e){
            DB::rollback();
            if (isset($path)){
                if($path != null){
                    Storage::delete($path);
                }
            }
            if (isset($video)){
                if($video != null){
                    Storage::delete($video);
                }
            }
            if (isset($pdf)){
                if($pdf != null){
                    Storage::delete($pdf);
                }
            }
            if (isset($logo)){
                if($logo != null){
                    Storage::delete($logo);
                }
            }
            return response()->json([
                'success' => false,
                'message' => "Falha ao editar o bloco, tente novamente",
                'e' => $e->getMessage()
            ]);
        }
    }

    public function setDataBlock($block, $request){
        $block->margin_top = $request->input('margin_top_'.$request->layout);
        $block->margin_bottom = $request->input('margin_bottom_'.$request->layout);
        $block->title = $request->input('title_'.$request->layout);
        $block->title_color = $request->input('title_color_'.$request->layout);
        $block->subtitle = $request->input('subtitle_'.$request->layout);
        $block->subtitle_color = $request->input('subtitle_color_'.$request->layout);
        $block->tag = $request->input('tag_'.$request->layout);
        $block->tag_color = $request->input('tag_color_'.$request->layout);
        $block->tag_title_color = $request->input('tag_title_color_'.$request->layout);
        $block->content = $request->input('content_'.$request->layout);
        $block->content_color = $request->input('content_color_'.$request->layout);
        $block->content_type = $request->input('content_type_'.$request->layout);
        $block->display_content = $request->input('display_content_'.$request->layout);
        $block->content_alignment = $request->input('content_alignment_'.$request->layout);
        $block->content_link = $request->input('content_link_'.$request->layout);
        $block->proportion = $request->input('proportion_'.$request->layout);
        $block->background_color = $request->input('background_color_'.$request->layout);
        $block->button_display = $request->input('button_display_'.$request->layout);
        $block->button_title = $request->input('button_title_'.$request->layout);
        $block->button_title_color = $request->input('button_title_color_'.$request->layout);
        $block->button_border_color = $request->input('button_border_color_'.$request->layout);
        $block->button_color = $request->input('button_color_'.$request->layout);
        $block->button_type = $request->input('button_type_'.$request->layout);
        if ($request->input('button_type_'.$request->layout) == 'inner_page') {
            $block->button_link = $request->input('button_pagina_'.$request->layout);
        }
        if ($request->input('button_type_'.$request->layout) == 'link') {
            $block->button_link = $request->input('button_url_'.$request->layout);
        }
        if ($request->input('button_link_'.$request->layout)) {
            $block->button_link = $request->input('button_link_'.$request->layout);
        }
        $block->button_display_1 = $request->input('button_display1_'.$request->layout);
        $block->button_title_1 = $request->input('button_title1_'.$request->layout);
        $block->button_title_color_1 = $request->input('button_title_color1_'.$request->layout);
        $block->button_border_color_1 = $request->input('button_border_color1_'.$request->layout);
        $block->button_color_1 = $request->input('button_color1_'.$request->layout);
        $block->button_type_1 = $request->input('button_type1_'.$request->layout);
        if ($request->input('button_type1_'.$request->layout) == 'inner_page') {
            $block->button_link_1 = $request->input('button_pagina1_'.$request->layout);
        }
        if ($request->input('button_type1_'.$request->layout) == 'link') {
            $block->button_link_1 = $request->input('button_url1_'.$request->layout);
        }
        $block->divider = $request->input('divider_'.$request->layout);
        $block->divider_color = $request->input('divider_color_'.$request->layout);
        $block->date = $request->input('date_'.$request->layout);
        $block->date_color = $request->input('date_color_'.$request->layout);
        $block->primary_color = $request->input('primary_color_'.$request->layout);
        $block->page_value_of = $request->input('value_of_'.$request->layout);
        $block->page_value_of_color = $request->input('value_of_color_'.$request->layout);
        $block->page_value_by = $request->input('value_by_'.$request->layout);
        $block->page_value_by_color = $request->input('value_by_color_'.$request->layout);
        $block->initial_value = $request->input('initial_value_'.$request->layout);
        $block->final_value = $request->input('final_value_'.$request->layout);
        $block->display_pdf = $request->input('display_pdf_'.$request->layout);
        $block->pdf_title = $request->input('pdf_title_'.$request->layout);
        $block->pdf_title_color = $request->input('pdf_title_color_'.$request->layout);
        $block->pdf_color = $request->input('pdf_color_'.$request->layout);
        $block->logo_display = $request->input('logo_display_'.$request->layout);
        $block->logo_title = $request->input('logo_title_'.$request->layout);
        $block->logo_title_color = $request->input('logo_title_color_'.$request->layout);
        $block->logo_background_color = $request->input('logo_background_color_'.$request->layout);
        $block->blogs_model = $request->input('blogs_model_'.$request->layout);
        $block->blog_category = $request->input('blog_category_'.$request->layout);
        $block->blogs = $request->input('blogs_'.$request->layout);
        $block->testimonial_category = $request->input('testimonial_category_'.$request->layout);
        if ($request->input('testimonials_'.$request->layout)) {
            $block->testimonials = json_encode($request->input('testimonials_'.$request->layout));
        }else{
            $block->testimonials = json_encode([0]);
        }
        $block->faq_category = $request->input('faq_category_'.$request->layout);
        if ($request->input('faqs_'.$request->layout)) {
            $block->faqs = json_encode($request->input('faqs_'.$request->layout));
        }
        $block->is_topic = $request->input('is_topic_'.$request->layout);
        $block->topic_category = $request->input('topic_category_'.$request->layout);
        $block->topics_categories = $request->input('topics_categories_'.$request->layout);
        $block->topics = $request->input('topics_'.$request->layout);
        $block->topics_color = $request->input('topics_color_'.$request->layout);
        if ($request->input('logos_category_'.$request->layout)) {
            $block->logos_category = json_encode($request->input('logos_category_'.$request->layout));
        }
        if ($request->input('events_'.$request->layout)) {
            $block->events = json_encode($request->input('events_'.$request->layout));
        }
        if ($request->input('galleries_'.$request->layout)) {
            $block->galleries = json_encode($request->input('galleries_'.$request->layout));
        }
        if ($request->input('alerts_'.$request->layout)) {
            $block->alerts = json_encode($request->input('alerts_'.$request->layout));
        }
        if ($request->input('cards_categories_'.$request->layout)) {
            $block->cards_categories = json_encode($request->input('cards_categories_'.$request->layout));
        }
        $block->type = $request->input('type_'.$request->layout);
        if ($request->input('pages_'.$request->layout)) {
            $block->pages = json_encode($request->input('pages_'.$request->layout));
        }
        $block->email = $request->input('email_'.$request->layout);
        if ($request->input('portfolios_categories_'.$request->layout)) {
            $block->portfolios_categories = json_encode($request->input('portfolios_categories_'.$request->layout));
        }
        if ($request->input('portfolios_'.$request->layout)) {
            $block->portfolios = json_encode($request->input('portfolios_'.$request->layout));
        }
        $block->font_title = $request->input('font_title_'.$request->layout);
        $block->font_subtitle = $request->input('font_subtitle_'.$request->layout);
        $block->font_description = $request->input('font_description_'.$request->layout);
        $block->font_button = $request->input('font_button_'.$request->layout);
        return $block;
    }

    public function setDataTab($block, $request, $tab_number){
        //$storage_service = new \App\Services\StorageService();
        if (strlen($request->input('title_'.$request->layout.'_'.$tab_number)) > 0
            || strlen($request->input('subtitle_'.$request->layout.'_'.$tab_number)) > 0
            || strlen($request->input('content_'.$request->layout.'_'.$tab_number)) > 0
            || strlen($request->input('button_display_'.$request->layout.'_'.$tab_number)) > 0
            || strlen($request->input('display_content_'.$request->layout.'_'.$tab_number)) > 0
            || strlen($request->input('content_type_'.$request->layout.'_'.$tab_number)) > 0
        ){
            $tab = Block_Tab::where('block_id', $block->id)->where('tab', $tab_number)->first();
            if ($tab == null){
                $tab = new Block_Tab();
                $tab->block_id = $block->id;
                $tab->tab = $tab_number;
            }
            $tab->title = $request->input('title_'.$request->layout.'_'.$tab_number);
            $tab->title_color = $request->input('title_color_'.$request->layout.'_'.$tab_number);
            $tab->subtitle = $request->input('subtitle_'.$request->layout.'_'.$tab_number);
            $tab->subtitle_color = $request->input('subtitle_color_'.$request->layout.'_'.$tab_number);
            $tab->content = $request->input('content_'.$request->layout.'_'.$tab_number);
            $tab->content_alignment = $request->input('content_alignment_'.$request->layout.'_'.$tab_number);
            $tab->content_color = $request->input('content_color_'.$request->layout.'_'.$tab_number);
            $tab->content_type = $request->input('content_type_'.$request->layout.'_'.$tab_number);
            $tab->display_content = $request->input('display_content_'.$request->layout.'_'.$tab_number);
            $tab->content_link = $request->input('content_link_'.$request->layout.'_'.$tab_number);
            if ($request->has('image_'.$request->layout.'_'.$tab_number)) {
                $directory = '/pages/bloco/' . $block->id;
                // Verifica se a pasta já existe, se não, cria com permissão 755
                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory, 0755, true);
                }

                $file = $request->file('image_'.$request->layout.'_'.$tab_number);
                $path = 'storage/'.$file->storeAs($directory, Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '_' . date('Ymd_His').'.'.$file->getClientOriginalExtension(), 'public');
            } else {
                $path = $tab->image;
            }
            $tab->image = $path;
            if ($request->has('video_'.$request->layout.'_'.$tab_number)) {
                $directory = '/pages/bloco/' . $block->id;
                // Verifica se a pasta já existe, se não, cria com permissão 755
                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory, 0755, true);
                }

                $file = $request->file('video_'.$request->layout.'_'.$tab_number);
                $video = 'storage/'.$file->storeAs($directory, Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '_' . date('Ymd_His').'.'.$file->getClientOriginalExtension(), 'public');
            } else {
                $video = $tab->video;
            }
            $tab->video = $video;
            $tab->display_image = $request->input('display_image_'.$request->layout.'_'.$tab_number);
            $tab->background_color = $request->input('background_color_'.$request->layout.'_'.$tab_number);
            $tab->button_display = $request->input('button_display_'.$request->layout.'_'.$tab_number);
            $tab->button_title = $request->input('button_title_'.$request->layout.'_'.$tab_number);
            $tab->button_title_color = $request->input('button_title_color_'.$request->layout.'_'.$tab_number);
            $tab->button_border_color = $request->input('button_border_color_'.$request->layout.'_'.$tab_number);
            $tab->button_color = $request->input('button_color_'.$request->layout.'_'.$tab_number);
            $tab->button_type = $request->input('button_type_'.$request->layout.'_'.$tab_number);
            if ($request->input('button_type_'.$request->layout.'_'.$tab_number) == 'inner_page') {
                $tab->button_link = $request->input('button_pagina_'.$request->layout.'_'.$tab_number);
            }
            if ($request->input('button_type_'.$request->layout.'_'.$tab_number) == 'link') {
                $tab->button_link = $request->input('button_url_'.$request->layout.'_'.$tab_number);
            }
            if ($request->input('button_link_'.$request->layout.'_'.$tab_number)) {
                $tab->button_link = $request->input('button_link_'.$request->layout.'_'.$tab_number);
            }
            $tab->button_display_1 = $request->input('button_display1_'.$request->layout.'_'.$tab_number);
            $tab->button_title_1 = $request->input('button_title1_'.$request->layout.'_'.$tab_number);
            $tab->button_title_color_1 = $request->input('button_title_color1_'.$request->layout.'_'.$tab_number);
            $tab->button_border_color_1 = $request->input('button_border_color1_'.$request->layout.'_'.$tab_number);
            $tab->button_color_1 = $request->input('button_color1_'.$request->layout.'_'.$tab_number);
            $tab->button_type_1 = $request->input('button_type1_'.$request->layout.'_'.$tab_number);
            if ($request->input('button_type1_'.$request->layout.'_'.$tab_number) == 'inner_page') {
                $tab->button_link_1 = $request->input('button_pagina1_'.$request->layout.'_'.$tab_number);
            }
            if ($request->input('button_type1_'.$request->layout.'_'.$tab_number) == 'link') {
                $tab->button_link_1 = $request->input('button_url1_'.$request->layout.'_'.$tab_number);
            }
            $tab->date = $request->input('date_'.$request->layout.'_'.$tab_number);
            $tab->hour = $request->input('hour_'.$request->layout.'_'.$tab_number);
            $tab->month = $request->input('month_'.$request->layout.'_'.$tab_number);
            $tab->icon = $request->input('icon_'.$request->layout.'_'.$tab_number);
            $tab->icon_color = $request->input('icon_color_'.$request->layout.'_'.$tab_number);
            $tab->number = $request->input('number_'.$request->layout.'_'.$tab_number);
            $tab->number_color = $request->input('number_color_'.$request->layout.'_'.$tab_number);
            $tab->divider = $request->input('divider_'.$request->layout.'_'.$tab_number);
            $tab->divider_color = $request->input('divider_color_'.$request->layout.'_'.$tab_number);
            $tab->page_value_of = $request->input('value_of_'.$request->layout.'_'.$tab_number);
            $tab->page_value_by = $request->input('value_by_'.$request->layout.'_'.$tab_number);
            $tab->page_value_of_color = $request->input('value_of_color_'.$request->layout.'_'.$tab_number);
            $tab->page_value_by_color = $request->input('value_by_color_'.$request->layout.'_'.$tab_number);
            if ($request->input('cards_categories_'.$request->layout.'_'.$tab_number)) {
                if ($request->input('cards_categories_'.$request->layout.'_'.$tab_number) == 0){
                    $tab->cards_categories = null;
                }else{
                    $tab->cards_categories = json_encode($request->input('cards_categories_'.$request->layout.'_'.$tab_number));
                }
            }
            $tab->type = $request->input('type_'.$request->layout.'_'.$tab_number);
            $tab->font_title = $request->input('font_title_'.$request->layout.'_'.$tab_number);
            $tab->font_subtitle = $request->input('font_subtitle_'.$request->layout.'_'.$tab_number);
            $tab->font_description = $request->input('font_description_'.$request->layout.'_'.$tab_number);
            $tab->font_button = $request->input('font_button_'.$request->layout.'_'.$tab_number);
            $tab->save();
        }else{
            if ($tab_number > 1){
                $tab = Block_Tab::where('block_id', $block->id)->where('tab', $tab_number)->first();
                if ($tab != null){
                    $tab->delete();
                }
            }else{
                $tab = Block_Tab::where('block_id', $block->id)->where('tab', $tab_number)->first();
                if ($tab != null) {
                    if($request->layout == 18){
                        $tab->delete();
                    }else{
                        $tab->button_display = $request->input('button_display_' . $request->layout . '_' . $tab_number);
                        $tab->save();
                    }
                }
            }
        }
    }

    public function validateBloco(Request $request){
        $validator = Validator::make($request->all(), [
            'layout' => 'required'
        ],[
            'layout.required' => 'O layout do bloco é obrigatório'
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }

        return response()->json([
            'success' => true,
            'layout' => $request->layout
        ]);
    }

    public function validateContent(Request $request){
        if ($request->layout == '1') {
            $validator = Validator::make($request->all(), [
                'title_1' => 'required',
                'content_1' => 'required',
                'title_1_1' => 'required',
                'subtitle_1_1' => 'required',
                'title_1_2' => 'required',
                'subtitle_1_2' => 'required',
                'title_1_3' => 'required',
                'subtitle_1_3' => 'required',
            ], [
                'title_1.required' => 'O título é obrigatório',
                'content_1.required' => 'O conteúdo é obrigatório',
                'title_1_1.required' => 'O título da primeira aba é obrigatório',
                'subtitle_1_1.required' => 'O subtítulo da primeira aba é obrigatório',
                'title_1_2.required' => 'O título da segunda aba é obrigatório',
                'subtitle_1_2.required' => 'O subtítulo da segunda aba é obrigatório',
                'title_1_3.required' => 'O título da terceira aba é obrigatório',
                'subtitle_1_3.required' => 'O subtítulo da terceira aba é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            if ($request->title_1_4 || $request->subtitle_1_4 || $request->content_link_1_4){
                $validator = Validator::make($request->all(), [
                    'title_1_4' => 'required',
                    'subtitle_1_4' => 'required',
                ],[
                    'title_1_4.required' => 'O título da quarta aba é obrigatório',
                    'subtitle_1_4.required' => 'O subtítulo da quarta aba é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }

            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_1_1' => 'required',
                    'image_1_2' => 'required',
                    'image_1_3' => 'required',
                ],[
                    'image_1_1.required' => 'A imagem da primeira aba é obrigatória',
                    'image_1_2.required' => 'A imagem da segunda aba é obrigatória',
                    'image_1_3.required' => 'A imagem da terceira aba é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }

                if ($request->title_1_4 || $request->subtitle_1_4 || $request->content_link_1_4){
                    $validator = Validator::make($request->all(), [
                        'image_1_4' => 'required',
                    ],[
                        'image_1_4.required' => 'A imagem da quarta aba é obrigatória',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        if ($request->layout == '2') {
            $validator = Validator::make($request->all(), [
                'title_2' => 'required',
                'content_2' => 'required',
                'title_2_1' => 'required',
                'subtitle_2_1' => 'required',
                'title_2_2' => 'required',
                'subtitle_2_2' => 'required',
                'title_2_3' => 'required',
                'subtitle_2_3' => 'required',
                'title_2_4' => 'required',
                'subtitle_2_4' => 'required',
            ], [
                'title_2.required' => 'O título é obrigatório',
                'content_2.required' => 'O conteúdo é obrigatório',
                'title_2_1.required' => 'O título da primeira aba é obrigatório',
                'subtitle_2_1.required' => 'O subtítulo da primeira aba é obrigatório',
                'title_2_2.required' => 'O título da segunda aba é obrigatório',
                'subtitle_2_2.required' => 'O subtítulo da segunda aba é obrigatório',
                'title_2_3.required' => 'O título da terceira aba é obrigatório',
                'subtitle_2_3.required' => 'O subtítulo da terceira aba é obrigatório',
                'title_2_4.required' => 'O título da quarta aba é obrigatório',
                'subtitle_2_4.required' => 'O subtítulo da quarta aba é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_2_1' => 'required',
                    'image_2_2' => 'required',
                    'image_2_3' => 'required',
                    'image_2_4' => 'required',
                ],[
                    'image_2_1.required' => 'A imagem da primeira aba é obrigatório',
                    'image_2_2.required' => 'A imagem da segunda aba é obrigatório',
                    'image_2_3.required' => 'A imagem da terceira aba é obrigatório',
                    'image_2_4.required' => 'A imagem da quarta aba é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
        }

        if ($request->layout == '3') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                'content_type_3' => 'required',
                //'title_3' => 'required',
            ], [
                'content_type_3.required' => 'O tipo do conteúdo é obrigatório',
                //'title_3.required' => 'O título é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
            //Valida se for enviado a imagem ou o vídeo de acordo com qual tipo de conteúdo foi selecionado
            if (!$request->block_id){
                if ($request->content_type_3 == 'image'){
                    $validator = Validator::make($request->all(), [
                        'image_3' => 'required',
                    ],[
                        'image_3.required' => 'A imagem é obrigatória',
                    ]);
                }elseif ($request->content_type_3 == 'video'){
                    $validator = Validator::make($request->all(), [
                        'video_3' => 'required',
                    ],[
                        'video_3.required' => 'O vídeo é obrigatório',
                    ]);
                }
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
            //Valida as informações necessárias caso seja selecionado para exibir o botão 1
            if ($request->button_display_3 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type_3' => 'required',
                ],[
                    'button_type_3.required' => 'O destino do botão 1 é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type_3 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_3' => 'required',
                    ],[
                        'button_pagina_3.required' => 'A página do botão 1 é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type_3 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_3' => 'required',
                    ],[
                        'button_url_3.required' => 'O link do botão 1 é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
            //Valida as informações necessárias caso seja selecionado para exibir o botão 2
            if ($request->button_display_3_1 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type_3_1' => 'required',
                ],[
                    'button_type_3_1.required' => 'O destino do botão 2 é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type_3_1 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_3_1' => 'required',
                    ],[
                        'button_pagina_3_1.required' => 'A página do botão 2 é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type_3_1 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_3_1' => 'required',
                    ],[
                        'button_url_3_1.required' => 'O link do botão 2 é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        if ($request->layout == '4') {
            $validator = Validator::make($request->all(), [
                'title_4' => 'required',
                'content_4' => 'required',
            ], [
                'title_4.required' => 'O título é obrigatório',
                'content_4.required' => 'O conteúdo é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_4' => 'required',
                ],[
                    'image_4.required' => 'A imagem é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }

            //Valida as informações necessárias caso seja selecionado para exibir o botão
            if ($request->button_display_4 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type_4' => 'required',
                ],[
                    'button_type_4.required' => 'O destino do botão é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type_4 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_4' => 'required',
                    ],[
                        'button_pagina_4.required' => 'A página do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type_4 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_4' => 'required',
                    ],[
                        'button_url_4.required' => 'O link do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        if ($request->layout == '5') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                'title_5' => 'required',
                'content_5' => 'required',
                'display_content_5_1' => 'required',
                'display_content_5_2' => 'required',
                'display_content_5_3' => 'required',
                'display_content_5_4' => 'required',
            ], [
                'title_5.required' => 'O título é obrigatório',
                'content_5.required' => 'O conteúdo é obrigatório',
                'display_content_5_1.required' => 'É obrigatório selecionar se será exibido o conteúdo da primeira aba',
                'display_content_5_2.required' => 'É obrigatório selecionar se será exibido o conteúdo da segunda aba',
                'display_content_5_3.required' => 'É obrigatório selecionar se será exibido o conteúdo da terceira aba',
                'display_content_5_4.required' => 'É obrigatório selecionar se será exibido o conteúdo da quarta aba',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
            //Valida se foi selecionado o tipo de conteúdo caso tenha sido marcado que ele deva ser exibido
            if ($request->display_content_5_1 == '1'){
                $validator = Validator::make($request->all(), [
                    'content_type_5_1' => 'required',
                ],[
                    'content_type_5_1.required' => 'O tipo de conteúdo da primeira aba é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                //Valida se for enviado a imagem ou o vídeo de acordo com qual tipo de conteúdo foi selecionado
                if (!$request->block_id) {
                    if ($request->content_type_5_1 == 'image') {
                        $validator = Validator::make($request->all(), [
                            'image_5_1' => 'required',
                        ], [
                            'image_5_1.required' => 'A imagem da primeira aba é obrigatória',
                        ]);
                    }
                    if ($request->content_type_5_1 == 'video'){
                        $validator = Validator::make($request->all(), [
                            'video_5_1' => 'required',
                        ],[
                            'video_5_1.required' => 'O vídeo da primeira aba é obrigatório',
                        ]);
                    }
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
            if ($request->display_content_5_2 == '1'){
                $validator = Validator::make($request->all(), [
                    'content_type_5_2' => 'required',
                ],[
                    'content_type_5_2.required' => 'O tipo de conteúdo da segunda aba é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                //Valida se for enviado a imagem ou o vídeo de acordo com qual tipo de conteúdo foi selecionado
                if (!$request->block_id) {
                    if ($request->content_type_5_2 == 'image') {
                        $validator = Validator::make($request->all(), [
                            'image_5_2' => 'required',
                        ], [
                            'image_5_2.required' => 'A imagem da segunda aba é obrigatória',
                        ]);
                    }
                    if ($request->content_type_5_2 == 'video'){
                        $validator = Validator::make($request->all(), [
                            'video_5_2' => 'required',
                        ],[
                            'video_5_2.required' => 'O vídeo da segunda aba é obrigatório',
                        ]);
                    }
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
            if ($request->display_content_5_3 == '1'){
                $validator = Validator::make($request->all(), [
                    'content_type_5_3' => 'required',
                ],[
                    'content_type_5_3.required' => 'O tipo de conteúdo da terceira aba é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                //Valida se for enviado a imagem ou o vídeo de acordo com qual tipo de conteúdo foi selecionado
                if (!$request->block_id) {
                    if ($request->content_type_5_3 == 'image') {
                        $validator = Validator::make($request->all(), [
                            'image_5_3' => 'required',
                        ], [
                            'image_5_3.required' => 'A imagem da terceira aba é obrigatória',
                        ]);
                    }
                    if ($request->content_type_5_3 == 'video'){
                        $validator = Validator::make($request->all(), [
                            'video_5_3' => 'required',
                        ],[
                            'video_5_3.required' => 'O vídeo da terceira aba é obrigatório',
                        ]);
                    }
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
            if ($request->display_content_5_4 == '1'){
                $validator = Validator::make($request->all(), [
                    'content_type_5_4' => 'required',
                ],[
                    'content_type_5_4.required' => 'O tipo de conteúdo da quarta aba é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                //Valida se for enviado a imagem ou o vídeo de acordo com qual tipo de conteúdo foi selecionado
                if (!$request->block_id) {
                    if ($request->content_type_5_4 == 'image') {
                        $validator = Validator::make($request->all(), [
                            'image_5_4' => 'required',
                        ], [
                            'image_5_4.required' => 'A imagem da quarta aba é obrigatória',
                        ]);
                    }
                    if ($request->content_type_5_4 == 'video'){
                        $validator = Validator::make($request->all(), [
                            'video_5_4' => 'required',
                        ],[
                            'video_5_4.required' => 'O vídeo da quarta aba é obrigatório',
                        ]);
                    }
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        if ($request->layout == '6') {
            $validator = Validator::make($request->all(), [
                'title_6' => 'required',
                'content_6' => 'required',
                'title_6_1' => 'required',
                'subtitle_6_1' => 'required',
                'title_6_2' => 'required',
                'subtitle_6_2' => 'required',
                'title_6_3' => 'required',
                'subtitle_6_3' => 'required',
            ], [
                'title_6.required' => 'O título é obrigatório',
                'content_6.required' => 'O conteúdo é obrigatório',
                'title_6_1.required' => 'O título da primeira aba é obrigatório',
                'subtitle_6_1.required' => 'O subtítulo da primeira aba é obrigatório',
                'title_6_2.required' => 'O título da segunda aba é obrigatório',
                'subtitle_6_2.required' => 'O subtítulo da segunda aba é obrigatório',
                'title_6_3.required' => 'O título da terceira aba é obrigatório',
                'subtitle_6_3.required' => 'O subtítulo da terceira aba é obrigatório',
            ]);
            //Valida os dados do bloco
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
            //Valida se as imagens foram enviadas
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_6' => 'required',
                    'image_6_1' => 'required',
                    'image_6_2' => 'required',
                    'image_6_3' => 'required',
                ],[
                    'image_6.required' => 'A imagem é obrigatória',
                    'image_6_1.required' => 'A imagem da primeira aba é obrigatória',
                    'image_6_2.required' => 'A imagem da segunda aba é obrigatória',
                    'image_6_3.required' => 'A imagem da terceira aba é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
            //Valida as informações necessárias caso seja selecionado para exibir o botão 1
            if ($request->button_display_6 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type_6' => 'required',
                ],[
                    'button_type_6.required' => 'O destino do botão é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type_6 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_6' => 'required',
                    ],[
                        'button_pagina_6.required' => 'A página do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type_6 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_6' => 'required',
                    ],[
                        'button_url_6.required' => 'O link do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        if ($request->layout == '7') {
            $validator = Validator::make($request->all(), [
                'title_7_1' => 'required',
                'subtitle_7_1' => 'required',
                'title_7_2' => 'required',
                'subtitle_7_2' => 'required',
                'title_7_3' => 'required',
                'subtitle_7_3' => 'required',
                'title_7_4' => 'required',
                'subtitle_7_4' => 'required',
            ], [
                'title_7_1.required' => 'O título da primeira aba é obrigatório',
                'subtitle_7_1.required' => 'O subtítulo da primeira aba é obrigatório',
                'title_7_2.required' => 'O título da segunda aba é obrigatório',
                'subtitle_7_2.required' => 'O subtítulo da segunda aba é obrigatório',
                'title_7_3.required' => 'O título da terceira aba é obrigatório',
                'subtitle_7_3.required' => 'O subtítulo da terceira aba é obrigatório',
                'title_7_4.required' => 'O título da quarta aba é obrigatório',
                'subtitle_7_4.required' => 'O subtítulo da quarta aba é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_7_1' => 'required',
                    'image_7_2' => 'required',
                    'image_7_3' => 'required',
                    'image_7_4' => 'required',
                ],[
                    'image_7_1.required' => 'A imagem da primeira aba é obrigatório',
                    'image_7_2.required' => 'A imagem da segunda aba é obrigatório',
                    'image_7_3.required' => 'A imagem da terceira aba é obrigatório',
                    'image_7_4.required' => 'A imagem da quarta aba é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
        }

        if ($request->layout == '8') {
            $validator = Validator::make($request->all(), [
                'title_8' => 'required',
                'content_8' => 'required',
                'title_8_1' => 'required',
                'subtitle_8_1' => 'required',
                'title_8_2' => 'required',
                'subtitle_8_2' => 'required',
                'title_8_3' => 'required',
                'subtitle_8_3' => 'required',
            ], [
                'title_8.required' => 'O título é obrigatório',
                'content_8.required' => 'O conteúdo é obrigatório',
                'title_8_1.required' => 'O título da primeira aba é obrigatório',
                'subtitle_8_1.required' => 'O subtítulo da primeira aba é obrigatório',
                'title_8_2.required' => 'O título da segunda aba é obrigatório',
                'subtitle_8_2.required' => 'O subtítulo da segunda aba é obrigatório',
                'title_8_3.required' => 'O título da terceira aba é obrigatório',
                'subtitle_8_3.required' => 'O subtítulo da terceira aba é obrigatório',
            ]);
            //Valida os dados do bloco
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
            //Valida se as imagens foram enviadas
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_8_1' => 'required',
                    'image_8_2' => 'required',
                    'image_8_3' => 'required',
                ],[
                    'image_8_1.required' => 'A imagem da primeira aba é obrigatória',
                    'image_8_2.required' => 'A imagem da segunda aba é obrigatória',
                    'image_8_3.required' => 'A imagem da terceira aba é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
            //Valida as informações necessárias caso seja selecionado para exibir o botão 1
            if ($request->button_display_8 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type_8' => 'required',
                ],[
                    'button_type_8.required' => 'O destino do botão é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type_8 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_8' => 'required',
                    ],[
                        'button_pagina_8.required' => 'A página do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type_8 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_8' => 'required',
                    ],[
                        'button_url_8.required' => 'O link do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        if ($request->layout == '9') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                'title_9' => 'required',
                'content_9' => 'required',
                'testimonials_9' => 'required',
            ], [
                'title_9.required' => 'O título é obrigatório',
                'content_9.required' => 'O conteúdo é obrigatório',
                'testimonials_9.required' => 'É obrigatório selecionar pelo menos um depoimento',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '10') {
            $validator = Validator::make($request->all(), [
                'title_10' => 'required',
                'content_10' => 'required',
                'title_10_1' => 'required',
                'subtitle_10_1' => 'required',
                'title_10_2' => 'required',
                'subtitle_10_2' => 'required',
                'title_10_3' => 'required',
                'subtitle_10_3' => 'required',
            ], [
                'title_10.required' => 'O título é obrigatório',
                'content_10.required' => 'O conteúdo é obrigatório',
                'title_10_1.required' => 'O título da primeira aba é obrigatório',
                'subtitle_10_1.required' => 'O subtítulo da primeira aba é obrigatório',
                'title_10_2.required' => 'O título da segunda aba é obrigatório',
                'subtitle_10_2.required' => 'O subtítulo da segunda aba é obrigatório',
                'title_10_3.required' => 'O título da terceira aba é obrigatório',
                'subtitle_10_3.required' => 'O subtítulo da terceira aba é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            //Valida as informações necessárias caso seja selecionado para exibir o link da aba 1
            if ($request->button_display_10_1 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type_10_1' => 'required',
                ],[
                    'button_type_10_1.required' => 'O destino da primeira aba é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type_10_1 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_10_1' => 'required',
                    ],[
                        'button_pagina_10_1.required' => 'A página da primeira aba é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type_10_1 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_10_1' => 'required',
                    ],[
                        'button_url_10_1.required' => 'O link da primeira aba é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
            //Valida as informações necessárias caso seja selecionado para exibir o link da aba 2
            if ($request->button_display_10_2 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type_10_2' => 'required',
                ],[
                    'button_type_10_2.required' => 'O destino da segunda aba é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type_10_2 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_10_2' => 'required',
                    ],[
                        'button_pagina_10_2.required' => 'A página da segunda aba é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type_10_2 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_10_2' => 'required',
                    ],[
                        'button_url_10_2.required' => 'O link da segunda aba é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
            //Valida as informações necessárias caso seja selecionado para exibir o link da aba 3
            if ($request->button_display_10_3 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type_10_3' => 'required',
                ],[
                    'button_type_10_3.required' => 'O destino da terceira aba é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type_10_3 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_10_3' => 'required',
                    ],[
                        'button_pagina_10_3.required' => 'A página da terceira aba é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type_10_3 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_10_3' => 'required',
                    ],[
                        'button_url_10_3.required' => 'O link da terceira aba é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }

            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_10_1' => 'required',
                    'image_10_2' => 'required',
                    'image_10_3' => 'required',
                ],[
                    'image_10_1.required' => 'A imagem da primeira aba é obrigatória',
                    'image_10_2.required' => 'A imagem da segunda aba é obrigatória',
                    'image_10_3.required' => 'A imagem da terceira aba é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }

            if ($request->title_10_4 || $request->subtitle_10_4 || $request->image_10_4 || $request->button_display_10_4 == '1'){
                $validator = Validator::make($request->all(), [
                    'title_10_4' => 'required',
                    'subtitle_10_4' => 'required',
                ], [
                    'title_10_4.required' => 'O título da quarta aba é obrigatório',
                    'subtitle_10_4.required' => 'O subtítulo da quarta aba é obrigatório'
                ]);
                if ($validator->fails()) {
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                //Valida as informações necessárias caso seja selecionado para exibir o link da aba 4
                if ($request->button_display_10_4 == '1'){
                    $validator = Validator::make($request->all(), [
                        'button_type_10_4' => 'required',
                    ],[
                        'button_type_10_4.required' => 'O destino da quarta aba é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                    if ($request->button_type_10_4 == 'inner_page'){
                        $validator = Validator::make($request->all(), [
                            'button_pagina_10_4' => 'required',
                        ],[
                            'button_pagina_10_4.required' => 'A página da quarta aba é obrigatório',
                        ]);
                        if($validator->fails()){
                            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                        }
                    }
                    if ($request->button_type_10_4 == 'link'){
                        $validator = Validator::make($request->all(), [
                            'button_url_10_4' => 'required',
                        ],[
                            'button_url_10_4.required' => 'O link da quarta aba é obrigatório',
                        ]);
                        if($validator->fails()){
                            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                        }
                    }
                }
                if (!$request->block_id){
                    $validator = Validator::make($request->all(), [
                        'image_10_4' => 'required',
                    ],[
                        'image_10_4.required' => 'A imagem da quarta aba é obrigatória',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }

            if ($request->title_10_5 || $request->subtitle_10_5 || $request->image_10_5 || $request->button_display_10_5 == '1'){
                $validator = Validator::make($request->all(), [
                    'title_10_5' => 'required',
                    'subtitle_10_5' => 'required',
                ], [
                    'title_10_5.required' => 'O título da quinta aba é obrigatório',
                    'subtitle_10_5.required' => 'O subtítulo da quinta aba é obrigatório'
                ]);
                if ($validator->fails()) {
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                //Valida as informações necessárias caso seja selecionado para exibir o link da aba 4
                if ($request->button_display_10_5 == '1'){
                    $validator = Validator::make($request->all(), [
                        'button_type_10_5' => 'required',
                    ],[
                        'button_type_10_5.required' => 'O destino da quinta aba é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                    if ($request->button_type_10_5 == 'inner_page'){
                        $validator = Validator::make($request->all(), [
                            'button_pagina_10_5' => 'required',
                        ],[
                            'button_pagina_10_5.required' => 'A página da quinta aba é obrigatório',
                        ]);
                        if($validator->fails()){
                            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                        }
                    }
                    if ($request->button_type_10_5 == 'link'){
                        $validator = Validator::make($request->all(), [
                            'button_url_10_5' => 'required',
                        ],[
                            'button_url_10_5.required' => 'O link da quinta aba é obrigatório',
                        ]);
                        if($validator->fails()){
                            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                        }
                    }
                }
                if (!$request->block_id){
                    $validator = Validator::make($request->all(), [
                        'image_10_5' => 'required',
                    ],[
                        'image_10_5.required' => 'A imagem da quinta aba é obrigatória',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }

            if ($request->title_10_6 || $request->subtitle_10_6 || $request->image_10_6 || $request->button_display_10_6 == '1'){
                $validator = Validator::make($request->all(), [
                    'title_10_6' => 'required',
                    'subtitle_10_6' => 'required',
                ], [
                    'title_10_6.required' => 'O título da sexta aba é obrigatório',
                    'subtitle_10_6.required' => 'O subtítulo da sexta aba é obrigatório'
                ]);
                if ($validator->fails()) {
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                //Valida as informações necessárias caso seja selecionado para exibir o link da aba 4
                if ($request->button_display_10_6 == '1'){
                    $validator = Validator::make($request->all(), [
                        'button_type_10_6' => 'required',
                    ],[
                        'button_type_10_6.required' => 'O destino da sexta aba é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                    if ($request->button_type_10_6 == 'inner_page'){
                        $validator = Validator::make($request->all(), [
                            'button_pagina_10_6' => 'required',
                        ],[
                            'button_pagina_10_6.required' => 'A página da sexta aba é obrigatório',
                        ]);
                        if($validator->fails()){
                            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                        }
                    }
                    if ($request->button_type_10_6 == 'link'){
                        $validator = Validator::make($request->all(), [
                            'button_url_10_6' => 'required',
                        ],[
                            'button_url_10_6.required' => 'O link da sexta aba é obrigatório',
                        ]);
                        if($validator->fails()){
                            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                        }
                    }
                }
                if (!$request->block_id){
                    $validator = Validator::make($request->all(), [
                        'image_10_6' => 'required',
                    ],[
                        'image_10_6.required' => 'A imagem da sexta aba é obrigatória',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        if ($request->layout == '11') {
            $validator = Validator::make($request->all(), [
                'title_11' => 'required',
                'content_11' => 'required',
            ], [
                'title_11.required' => 'O título é obrigatório',
                'content_11.required' => 'O conteúdo é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '12') {
            $validator = Validator::make($request->all(), [
                'title_12' => 'required',
                'content_12' => 'required',
                'email_12' => 'required',
                'button_link_12' => 'required',
            ], [
                'title_12.required' => 'O título é obrigatório',
                'content_12.required' => 'O conteúdo é obrigatório',
                'email_12.required' => 'O layout de e-mail é obrigatório',
                'button_link_12.required' => 'O link dos termos é obrigatório',
            ]);
            //Valida os dados do bloco
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
            //Valida se as imagens foram enviadas
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_12_1' => 'required',
                ],[
                    'image_12_1.required' => 'A imagem da primeira aba é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
        }

        if ($request->layout == '13') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                'content_type_13' => 'required',
                'title_13' => 'required',
                'content_13' => 'required',
            ], [
                'content_type_13.required' => 'O tipo de conteúdo é obrigatório',
                'title_13.required' => 'O título é obrigatório',
                'content_13.required' => 'O conteúdo é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
            //Valida se for enviado a imagem ou o vídeo de acordo com qual tipo de conteúdo foi selecionado
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_13' => 'required',
                ],[
                    'image_13.required' => 'A imagem é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
            //Valida as informações necessárias caso seja selecionado o tipo de conteúdo como youtube_embed
            if ($request->content_type_13 == 'youtube_embed'){
                $validator = Validator::make($request->all(), [
                    'content_link_13' => 'required',
                ],[
                    'content_link_13.required' => 'O link do vídeo é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
            //Valida as informações necessárias caso seja selecionado para exibir o botão
            if ($request->button_display_13 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type_13' => 'required',
                ],[
                    'button_type_13.required' => 'O destino do botão é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type_13 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_13' => 'required',
                    ],[
                        'button_pagina_13.required' => 'A página do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type_13 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_13' => 'required',
                    ],[
                        'button_url_13.required' => 'O link do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        if ($request->layout == '14') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                'content_type_14' => 'required',
                'title_14' => 'required',
                'content_14' => 'required',
            ], [
                'content_type_14.required' => 'O tipo do conteúdo é obrigatório',
                'title_14.required' => 'O título é obrigatório',
                'content_14.required' => 'O conteúdo é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
            //Valida se for enviado a imagem ou o vídeo de acordo com qual tipo de conteúdo foi selecionado
            if (!$request->block_id){
                if ($request->content_type_14 == 'image'){
                    $validator = Validator::make($request->all(), [
                        'image_14' => 'required',
                    ],[
                        'image_14.required' => 'A imagem é obrigatória',
                    ]);
                }elseif ($request->content_type_3 == 'video'){
                    $validator = Validator::make($request->all(), [
                        'video_14' => 'required',
                    ],[
                        'video_14.required' => 'O vídeo é obrigatório',
                    ]);
                }
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
            //Valida as informações necessárias caso seja selecionado para exibir o botão 1
            if ($request->button_display_14 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type_14' => 'required',
                ],[
                    'button_type_14.required' => 'O destino do botão 1 é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type_14 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_14' => 'required',
                    ],[
                        'button_pagina_14.required' => 'A página do botão 1 é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type_14 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_14' => 'required',
                    ],[
                        'button_url_14.required' => 'O link do botão 1 é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
            //Valida as informações necessárias caso seja selecionado para exibir o botão 2
            if ($request->button_display_14_1 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type_14_1' => 'required',
                ],[
                    'button_type_14_1.required' => 'O destino do botão 2 é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type_14_1 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_14_1' => 'required',
                    ],[
                        'button_pagina_14_1.required' => 'A página do botão 2 é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type_14_1 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_14_1' => 'required',
                    ],[
                        'button_url_14_1.required' => 'O link do botão 2 é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        if ($request->layout == '15') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                'title_15' => 'required',
                'content_15' => 'required',
                'content_type_15_1' => 'required',
                'content_type_15_2' => 'required',
                'content_type_15_3' => 'required',
                'content_type_15_4' => 'required',
            ], [
                'title_15.required' => 'O título é obrigatório',
                'content_15.required' => 'O conteúdo é obrigatório',
                'content_type_15_1.required' => 'O tipo de conteúdo da primeira aba é obrigatório',
                'content_type_15_2.required' => 'O tipo de conteúdo da segunda aba é obrigatório',
                'content_type_15_3.required' => 'O tipo de conteúdo da terceira aba é obrigatório',
                'content_type_15_4.required' => 'O tipo de conteúdo da quarta aba é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
            //Valida se as imagens foram enviadas na criação do bloco
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_15_1' => 'required',
                    'image_15_2' => 'required',
                    'image_15_3' => 'required',
                    'image_15_4' => 'required',
                ],[
                    'image_15_1.required' => 'A imagem da primeira aba é obrigatória',
                    'image_15_2.required' => 'A imagem da segunda aba é obrigatória',
                    'image_15_3.required' => 'A imagem da terceira aba é obrigatória',
                    'image_15_4.required' => 'A imagem da quarta aba é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
            //Valida as informações necessárias caso seja selecionado para exibir o botão
            if ($request->button_display_15 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type_15' => 'required',
                ],[
                    'button_type_15.required' => 'O destino do botão é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type_15 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_15' => 'required',
                    ],[
                        'button_pagina_15.required' => 'A página do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type_15 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_15' => 'required',
                    ],[
                        'button_url_15.required' => 'O link do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
            //Valida as informações necessárias caso seja selecionado o tipo de conteúdo como youtube_embed na aba 1
            if ($request->content_type_15_1 == 'youtube_embed'){
                $validator = Validator::make($request->all(), [
                    'content_link_15_1' => 'required',
                ],[
                    'content_link_15_1.required' => 'O link do vídeo da primeira aba é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
            //Valida as informações necessárias caso seja selecionado o tipo de conteúdo como youtube_embed na aba 2
            if ($request->content_type_15_2 == 'youtube_embed'){
                $validator = Validator::make($request->all(), [
                    'content_link_15_2' => 'required',
                ],[
                    'content_link_15_2.required' => 'O link do vídeo da segunda aba é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
            //Valida as informações necessárias caso seja selecionado o tipo de conteúdo como youtube_embed na aba 3
            if ($request->content_type_15_3 == 'youtube_embed'){
                $validator = Validator::make($request->all(), [
                    'content_link_15_3' => 'required',
                ],[
                    'content_link_15_3.required' => 'O link do vídeo da terceira aba é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
            //Valida as informações necessárias caso seja selecionado o tipo de conteúdo como youtube_embed na aba 4
            if ($request->content_type_15_4 == 'youtube_embed'){
                $validator = Validator::make($request->all(), [
                    'content_link_15_4' => 'required',
                ],[
                    'content_link_15_4.required' => 'O link do vídeo da quarta aba é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
        }

        if ($request->layout == '16') {
            $validator = Validator::make($request->all(), [
                'title_16' => 'required',
                'content_16' => 'required',
                'content_link_16' => 'required',
                'title_16_1' => 'required',
            ], [
                'title_16.required' => 'O título é obrigatório',
                'content_16.required' => 'O conteúdo é obrigatório',
                'content_link_16.required' => 'O subtítulo é obrigatório',
                'title_16_1.required' => 'O título da primeira aba é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_16' => 'required',
                ],[
                    'image_16.required' => 'A imagem é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
        }

        if ($request->layout == '17') {
            $validator = Validator::make($request->all(), [
                'type_17' => 'required',
                'title_17' => 'required',
                'email_17' => 'required',
                'button_title_17' => 'required',
            ], [
                'type_17.required' => 'O tipo de layout é obrigatório',
                'title_17.required' => 'O título é obrigatório',
                'email_17.required' => 'O layout de e-mail é obrigatório',
                'button_title_17.required' => 'O texto do botão é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '18') {
            $validator = Validator::make($request->all(), [
                'type_18' => 'required',
                'title_18' => 'required',
                'font_title_18' => 'required',
                'content_18' => 'required',
                'font_description_18' => 'required',
                'email_18' => 'required',
                'button_display_18' => 'required',
                'button_title_18' => 'required',
                'font_button_18' => 'required',
                'button_type_18' => 'required',
            ], [
                'type_18.required' => 'O tipo de layout é obrigatório',
                'title_18.required' => 'O título é obrigatório',
                'font_title_18.required' => 'O perfil do título é obrigatório',
                'content_18.required' => 'O conteúdo é obrigatório',
                'font_description_18.required' => 'O perfil do conteúdo é obrigatório',
                'email_18.required' => 'O layout de e-mail é obrigatório',
                'button_display_18.required' => 'É orbrigatório marcar o redirecionamento',
                'button_title_18.required' => 'O texto do botão é obrigatório',
                'font_button_18.required' => 'O perfil do texto do botão é obrigatório',
                'button_type_18.required' => 'O redirecionamento do formulário é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
            if ($request->subtitle_18){
                $validator = Validator::make($request->all(), [
                    'font_subtitle_18' => 'required',
                ], [
                    'font_subtitle_18.required' => 'O perfil do subtítulo é obrigatório',
                ]);
                if ($validator->fails()) {
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
            if ($request->button_type_18 == 'inner_page'){
                $validator = Validator::make($request->all(), [
                    'button_pagina_18' => 'required',
                ],[
                    'button_pagina_18.required' => 'A página do redirecionamento do formulário é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
            if ($request->button_type_18 == 'link'){
                $validator = Validator::make($request->all(), [
                    'button_url_18' => 'required',
                ],[
                    'button_url_18.required' => 'O link do redirecionamento do formulário é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }

            for ($i = 1; $i <= 1; $i++){
                if ($request->input('title_18_'.$i) || $request->input('subtitle_18_'.$i) || $request->input('content_link_18_'.$i) || $request->input('image_18_'.$i)){
                    $validator = Validator::make($request->all(), [
                        'title_18_'.$i => 'required',
                        'subtitle_18_'.$i => 'required',
                    ], [
                        'title_18_'.$i.'.required' => 'O título da aba '.$i.' é obrigatório',
                        'subtitle_18_'.$i.'.required' => 'O subtítulo da aba '.$i.' é obrigatório',
                    ]);
                    if ($validator->fails()) {
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                    if (!$request->block_id){
                        $validator = Validator::make($request->all(), [
                            'image_18_'.$i => 'required',
                        ],[
                            'image_18_'.$i.'.required' => 'A imagem da aba '.$i.' é obrigatória',
                        ]);
                        if($validator->fails()){
                            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                        }
                    }
                }
            }
        }

        if ($request->layout == '19') {
            $validator = Validator::make($request->all(), [
                'title_19' => 'required',
                'content_19' => 'required',
                'title_19_1' => 'required',
                'content_19_1' => 'required',
                'title_19_2' => 'required',
                'content_19_2' => 'required',
                'title_19_3' => 'required',
                'content_19_3' => 'required',
            ], [
                'title_19.required' => 'O título é obrigatório',
                'content_19.required' => 'O conteúdo é obrigatório',
                'title_19_1.required' => 'O título da primeira aba é obrigatório',
                'content_19_1.required' => 'A descrição da primeira aba é obrigatória',
                'title_19_2.required' => 'O título da segunda aba é obrigatório',
                'content_19_2.required' => 'A descrição da segunda aba é obrigatória',
                'title_19_3.required' => 'O título da terceira aba é obrigatório',
                'content_19_3.required' => 'A descrição da terceira aba é obrigatória',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_19' => 'required',
                ],[
                    'image_19.required' => 'A imagem é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
        }

        if ($request->layout == '20') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                'content_type_20' => 'required',
                'title_20' => 'required',
                'content_20' => 'required',
            ], [
                'content_type_20.required' => 'O tipo de conteúdo é obrigatório',
                'title_20.required' => 'O título é obrigatório',
                'content_20.required' => 'O conteúdo é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
            //Valida se for enviado a imagem ou o vídeo de acordo com qual tipo de conteúdo foi selecionado
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_20' => 'required',
                ],[
                    'image_20.required' => 'A imagem é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
            //Valida as informações necessárias caso seja selecionado o tipo de conteúdo como youtube_embed
            if ($request->content_type_20 == 'youtube_embed'){
                $validator = Validator::make($request->all(), [
                    'content_link_20' => 'required',
                ],[
                    'content_link_20.required' => 'O link do vídeo é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
            //Valida as informações necessárias caso seja selecionado para exibir o botão
            if ($request->button_display_20 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type_20' => 'required',
                ],[
                    'button_type_20.required' => 'O destino do botão é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type_20 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_20' => 'required',
                    ],[
                        'button_pagina_20.required' => 'A página do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type_20 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_20' => 'required',
                    ],[
                        'button_url_20.required' => 'O link do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        if ($request->layout == '21') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                'title_21' => 'required',
                'content_21' => 'required',
            ], [
                'title_21.required' => 'O título é obrigatório',
                'content_21.required' => 'O conteúdo é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '22') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                'title_22' => 'required',
                'content_22' => 'required',
            ], [
                'title_22.required' => 'O título é obrigatório',
                'content_22.required' => 'O conteúdo é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '23') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                'title_23' => 'required',
                'content_23' => 'required',
            ], [
                'title_23.required' => 'O título é obrigatório',
                'content_23.required' => 'O conteúdo é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '24') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                'title_24' => 'required',
                'content_24' => 'required',
            ], [
                'title_24.required' => 'O título é obrigatório',
                'content_24.required' => 'O conteúdo é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_24' => 'required',
                ],[
                    'image_24.required' => 'A imagem é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
            //Valida as informações necessárias caso seja selecionado para exibir o botão
            if ($request->button_display_24 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type_24' => 'required',
                ],[
                    'button_type_24.required' => 'O destino do botão é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type_24 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_24' => 'required',
                    ],[
                        'button_pagina_24.required' => 'A página do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type_24 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_24' => 'required',
                    ],[
                        'button_url_24.required' => 'O link do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        if ($request->layout == '25') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                'title_25' => 'required',
                'content_25' => 'required',
                'events_25' => 'required',
            ], [
                'title_25.required' => 'O título é obrigatório',
                'content_25.required' => 'O conteúdo é obrigatório',
                'events_25.required' => 'É obrigatório selecionar ao menos 1 evento',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '26') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                //'title_26' => 'required',
                //'content_26' => 'required',
                'galleries_26' => 'required',
            ], [
                //'title_26.required' => 'O título é obrigatório',
                //'content_26.required' => 'O conteúdo é obrigatório',
                'galleries_26.required' => 'É obrigatório selecionar ao menos 1 galeria',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '27') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                'type_27' => 'required',
                'title_27' => 'required',
                'content_27' => 'required',
                'alerts_27' => 'required',
            ], [
                'type_27.required' => 'É obrigatório informar se deverá exibir ou não o título e a descrição do comunicado',
                'title_27.required' => 'O título é obrigatório',
                'content_27.required' => 'O conteúdo é obrigatório',
                'alerts_27.required' => 'É obrigatório selecionar ao menos 1 galeria',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '28') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                'events_28' => 'required',
            ], [
                'events_28.required' => 'É obrigatório selecionar ao menos 1 evento',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '29') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                //'title_29' => 'required',
                //'content_29' => 'required',
                'cards_categories_29' => 'required',
            ], [
                //'title_29.required' => 'O título é obrigatório',
                //'content_29.required' => 'O conteúdo é obrigatório',
                'cards_categories_29.required' => 'É obrigatório selecionar ao menos 1 categoria',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '30') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                'title_30' => 'required',
                'content_30' => 'required',
            ], [
                'title_30.required' => 'O título é obrigatório',
                'content_30.required' => 'O conteúdo é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '32') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                'title_32_1' => 'required',
                'content_32_1' => 'required',
            ], [
                'title_32_1.required' => 'O título é obrigatório',
                'content_32_1.required' => 'O conteúdo é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
            if ($request->title_32_2 || $request->content_32_2){
                $validator = Validator::make($request->all(), [
                    'title_32_2' => 'required',
                    'content_32_2' => 'required',
                ], [
                    'title_32_2.required' => 'O título da segunda aba é obrigatório',
                    'content_32_2.required' => 'O conteúdoda segunda aba  é obrigatório',
                ]);
                if ($validator->fails()) {
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
            if ($request->title_32_3 || $request->content_32_3){
                $validator = Validator::make($request->all(), [
                    'title_32_3' => 'required',
                    'content_32_3' => 'required',
                ], [
                    'title_32_3.required' => 'O título da terceira aba é obrigatório',
                    'content_32_3.required' => 'O conteúdo da terceira aba é obrigatório',
                ]);
                if ($validator->fails()) {
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
            if ($request->title_32_4 || $request->content_32_4){
                $validator = Validator::make($request->all(), [
                    'title_32_4' => 'required',
                    'content_32_4' => 'required',
                ], [
                    'title_32_4.required' => 'O título da quarta aba é obrigatório',
                    'content_32_4.required' => 'O conteúdo da quarta aba é obrigatório',
                ]);
                if ($validator->fails()) {
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
            if ($request->title_32_5 || $request->content_32_5){
                $validator = Validator::make($request->all(), [
                    'title_32_5' => 'required',
                    'content_32_5' => 'required',
                ], [
                    'title_32_5.required' => 'O título da quinta aba é obrigatório',
                    'content_32_5.required' => 'O conteúdo da quinta aba é obrigatório',
                ]);
                if ($validator->fails()) {
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
            if ($request->title_32_6 || $request->content_32_6){
                $validator = Validator::make($request->all(), [
                    'title_32_6' => 'required',
                    'content_32_6' => 'required',
                ], [
                    'title_32_6.required' => 'O título da sexta aba é obrigatório',
                    'content_32_6.required' => 'O conteúdo da sexta aba é obrigatório',
                ]);
                if ($validator->fails()) {
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
        }

        if ($request->layout == '34') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                'pages_34' => 'required',
            ], [
                'pages_34.required' => 'É obrigatório selecionar ao menos 1 página',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '37') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                'title_37' => 'required',
                'content_37' => 'required',
                'faq_category_37' => 'required',
            ], [
                'title_37.required' => 'O título é obrigatório',
                'content_37.required' => 'O conteúdo é obrigatório',
                'faq_category_37' => 'É obrigatório selecionar uma categoria de faq',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '38') {
            $validator = Validator::make($request->all(), [
                'tag_38' => 'required',
                'title_38' => 'required',
                'content_38' => 'required',
                'email_38' => 'required',
            ], [
                'tag_38.required' => 'O título do formulário é brigatório',
                'title_38.required' => 'O título é obrigatório',
                'content_38.required' => 'O conteúdo é obrigatório',
                'email_38.required' => 'O layout de e-mail é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            //Valida se for enviado a imagem
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_38' => 'required',
                ],[
                    'image_38.required' => 'A imagem é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }

            //Valida as informações necessárias caso seja selecionado para exibir o botão
            if ($request->button_display_38 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type_38' => 'required',
                ],[
                    'button_type_38.required' => 'O destino do botão é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type_38 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_38' => 'required',
                    ],[
                        'button_pagina_38.required' => 'A página do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type_38 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_38' => 'required',
                    ],[
                        'button_url_38.required' => 'O link do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }

            //Valida as informações necessárias caso seja selecionado para exibir o botão 2
            if ($request->button_display1_38 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type1_38' => 'required',
                ],[
                    'button_type1_38.required' => 'O destino do botão 2 é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type1_38 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina1_38' => 'required',
                    ],[
                        'button_pagina1_38.required' => 'A página do botão 2 é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type1_38 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url1_38' => 'required',
                    ],[
                        'button_url1_38.required' => 'O link do botão 2 é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        if ($request->layout == '39') {
            $validator = Validator::make($request->all(), [
                'title_39' => 'required',
                'content_39' => 'required',
            ], [
                'title_39.required' => 'O título é obrigatório',
                'content_39.required' => 'O conteúdo é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            //Valida se for enviado a imagem
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_39_1' => 'required',
                    'image_39_2' => 'required',
                    'image_39_3' => 'required',
                    'image_39_4' => 'required',
                ],[
                    'image_39_1.required' => 'A imagem da primeira aba é obrigatória',
                    'image_39_2.required' => 'A imagem da primeira segunda é obrigatória',
                    'image_39_3.required' => 'A imagem da primeira terceira é obrigatória',
                    'image_39_4.required' => 'A imagem da primeira quarta é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }

            //Valida as informações necessárias caso seja selecionado para exibir o botão
            if ($request->button_display_39 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type_39' => 'required',
                ],[
                    'button_type_39.required' => 'O destino do botão é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type_39 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_39' => 'required',
                    ],[
                        'button_pagina_39.required' => 'A página do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type_39 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_39' => 'required',
                    ],[
                        'button_url_39.required' => 'O link do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }

            //Valida as informações necessárias caso seja selecionado para exibir o botão 2
            if ($request->button_display1_39 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type1_39' => 'required',
                ],[
                    'button_type1_39.required' => 'O destino do botão 2 é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type1_39 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina1_39' => 'required',
                    ],[
                        'button_pagina1_39.required' => 'A página do botão 2 é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type1_39 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url1_39' => 'required',
                    ],[
                        'button_url1_39.required' => 'O link do botão 2 é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        if ($request->layout == '40') {
            $validator = Validator::make($request->all(), [
                'title_40' => 'required',
                'content_40' => 'required',
            ], [
                'title_40.required' => 'O título é obrigatório',
                'content_40.required' => 'O conteúdo é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            //Valida se for enviado a imagem
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_40' => 'required',
                ],[
                    'image_40.required' => 'A imagem é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }

            for ($i = 1; $i <= 4; $i++){
                if ($request->input('display_image_40_'.$i) && !$request->block_id){
                    $validator = Validator::make($request->all(), [
                        'image_40_'.$i => 'required',
                    ],[
                        'image_40_'.$i.'.required' => 'A imagem da aba '.$i.' é obrigatória',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }

            //Valida as informações necessárias caso seja selecionado para exibir o botão
            if ($request->button_display_40 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type_40' => 'required',
                ],[
                    'button_type_40.required' => 'O destino do botão é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type_40 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_40' => 'required',
                    ],[
                        'button_pagina_40.required' => 'A página do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type_40 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_40' => 'required',
                    ],[
                        'button_url_40.required' => 'O link do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }

            //Valida as informações necessárias caso seja selecionado para exibir o botão 2
            if ($request->button_display1_40 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type1_40' => 'required',
                ],[
                    'button_type1_40.required' => 'O destino do botão 2 é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type1_40 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina1_40' => 'required',
                    ],[
                        'button_pagina1_40.required' => 'A página do botão 2 é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type1_40 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url1_40' => 'required',
                    ],[
                        'button_url1_40.required' => 'O link do botão 2 é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        if ($request->layout == '41') {
            $validator = Validator::make($request->all(), [
                'title_41' => 'required',
                'content_41' => 'required',
                'title_41_1' => 'required',
                'subtitle_41_1' => 'required',
                'title_41_2' => 'required',
                'subtitle_41_2' => 'required',
                'title_41_3' => 'required',
                'subtitle_41_3' => 'required',
                'title_41_4' => 'required',
                'subtitle_41_4' => 'required',
            ], [
                'title_41.required' => 'O título é obrigatório',
                'content_41.required' => 'O conteúdo é obrigatório',
                'title_41_1.required' => 'O título da aba 1 é obrigatório',
                'subtitle_41_1.required' => 'O conteúdo da aba 1 é obrigatório',
                'title_41_2.required' => 'O título da aba 2 é obrigatório',
                'subtitle_41_2.required' => 'O conteúdo da aba 2 é obrigatório',
                'title_41_3.required' => 'O título da aba 3 é obrigatório',
                'subtitle_41_3.required' => 'O conteúdo da aba 3 é obrigatório',
                'title_41_4.required' => 'O título da aba 4 é obrigatório',
                'subtitle_41_4.required' => 'O conteúdo da aba 4 é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            //Valida se for enviado a imagem
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_41_1' => 'required',
                    'image_41_2' => 'required',
                    'image_41_3' => 'required',
                    'image_41_4' => 'required',
                ],[
                    'image_41_1.required' => 'A imagem da aba 1 é obrigatória',
                    'image_41_2.required' => 'A imagem da aba 2 é obrigatória',
                    'image_41_3.required' => 'A imagem da aba 3 é obrigatória',
                    'image_41_4.required' => 'A imagem da aba 4 é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
        }

        if ($request->layout == '42') {
            $validator = Validator::make($request->all(), [
                'title_42' => 'required',
            ], [
                'title_42.required' => 'O título é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '43') {
            $validator = Validator::make($request->all(), [
                'title_43' => 'required',
                'logos_category_43' => 'required',
            ], [
                'title_43.required' => 'O título é obrigatório',
                'logos_category_43.required' => 'A categoria de logos é obrigatória',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '44') {
            $validator = Validator::make($request->all(), [
                'title_44' => 'required',
                'portfolios_categories_44' => 'required',
            ], [
                'title_44.required' => 'O título é obrigatório',
                'portfolios_categories_44.required' => 'É obrigatório selecionar ao menos uma categoria de portfólio',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '45') {
            $validator = Validator::make($request->all(), [
                'title_45' => 'required',
                'portfolios_45' => 'required',
            ], [
                'title_45.required' => 'O título é obrigatório',
                'portfolios_45.required' => 'É obrigatório selecionar ao menos um portfólio',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '46') {
            $validator = Validator::make($request->all(), [
                'testimonials_46' => 'required',
            ], [
                'testimonials_46.required' => 'É obrigatório selecionar ao menos um depoimento',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '47') {
            $validator = Validator::make($request->all(), [
                'title_47' => 'required',
                'title_47_1' => 'required',
                'subtitle_47_1' => 'required',
                'title_47_2' => 'required',
                'subtitle_47_2' => 'required',
                'title_47_3' => 'required',
                'subtitle_47_3' => 'required',
                'title_47_4' => 'required',
                'subtitle_47_4' => 'required',
                'title_47_5' => 'required',
                'subtitle_47_5' => 'required',
                'title_47_6' => 'required',
                'subtitle_47_6' => 'required',
            ], [
                'title_47.required' => 'O título é obrigatório',
                'title_47_1.required' => 'O título da aba 1 é obrigatório',
                'subtitle_47_1.required' => 'O conteúdo da aba 1 é obrigatório',
                'title_47_2.required' => 'O título da aba 2 é obrigatório',
                'subtitle_47_2.required' => 'O conteúdo da aba 2 é obrigatório',
                'title_47_3.required' => 'O título da aba 3 é obrigatório',
                'subtitle_47_3.required' => 'O conteúdo da aba 3 é obrigatório',
                'title_47_4.required' => 'O título da aba 4 é obrigatório',
                'subtitle_47_4.required' => 'O conteúdo da aba 4 é obrigatório',
                'title_47_5.required' => 'O título da aba 5 é obrigatório',
                'subtitle_47_5.required' => 'O conteúdo da aba 5 é obrigatório',
                'title_47_6.required' => 'O título da aba 6 é obrigatório',
                'subtitle_47_6.required' => 'O conteúdo da aba 6 é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '48') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                'content_type_48' => 'required',
                'title_48' => 'required',
            ], [
                'content_type_48.required' => 'O tipo de conteúdo é obrigatório',
                'title_48.required' => 'O título é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
            //Valida se for enviado a imagem ou o vídeo de acordo com qual tipo de conteúdo foi selecionado
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_48' => 'required',
                ],[
                    'image_48.required' => 'A imagem é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
            //Valida as informações necessárias caso seja selecionado o tipo de conteúdo como youtube_embed
            if ($request->content_type_48 == 'youtube_embed'){
                $validator = Validator::make($request->all(), [
                    'content_link_48' => 'required',
                ],[
                    'content_link_48.required' => 'O link do vídeo é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
            //Valida as informações necessárias caso seja selecionado para exibir o botão
            if ($request->button_display_48 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type_48' => 'required',
                ],[
                    'button_type_48.required' => 'O destino do botão é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type_48 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_48' => 'required',
                    ],[
                        'button_pagina_48.required' => 'A página do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type_48 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_48' => 'required',
                    ],[
                        'button_url_48.required' => 'O link do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
            //Valida as informações necessárias caso seja selecionado para exibir o botão 2
            if ($request->button_display1_48 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type1_48' => 'required',
                ],[
                    'button_type1_48.required' => 'O destino do botão 2 é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type1_48 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina1_48' => 'required',
                    ],[
                        'button_pagina1_48.required' => 'A página do botão 2 é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type1_48 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url1_48' => 'required',
                    ],[
                        'button_url1_48.required' => 'O link do botão 2 é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        if ($request->layout == '49') {
            $validator = Validator::make($request->all(), [
                'title_49' => 'required',
                'content_49' => 'required',
            ], [
                'title_49.required' => 'O título é obrigatório',
                'content_49.required' => 'O conteúdo é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            //Valida se for enviado a imagem
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_49' => 'required',
                    'image_49_1' => 'required',
                ],[
                    'image_49.required' => 'A imagem de fundo é obrigatória',
                    'image_49_1.required' => 'A imagem é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }

            //Valida as informações necessárias caso seja selecionado para exibir o botão
            if ($request->button_display_49 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type_49' => 'required',
                ],[
                    'button_type_49.required' => 'O destino do botão é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type_49 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_49' => 'required',
                    ],[
                        'button_pagina_49.required' => 'A página do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type_49 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_49' => 'required',
                    ],[
                        'button_url_49.required' => 'O link do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }

            //Valida as informações necessárias caso seja selecionado para exibir o botão 2
            if ($request->button_display1_49 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type1_49' => 'required',
                ],[
                    'button_type1_49.required' => 'O destino do botão 2 é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type1_49 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina1_49' => 'required',
                    ],[
                        'button_pagina1_49.required' => 'A página do botão 2 é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type1_49 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url1_49' => 'required',
                    ],[
                        'button_url1_49.required' => 'O link do botão 2 é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        if ($request->layout == '50') {
            $validator = Validator::make($request->all(), [
                'title_50' => 'required',
                'content_50' => 'required',
            ], [
                'title_50.required' => 'O título é obrigatório',
                'content_50.required' => 'O conteúdo é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            //Valida se for enviado a imagem
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_50' => 'required',
                ],[
                    'image_50.required' => 'A imagem é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }

            //Valida as informações necessárias caso seja selecionado para exibir o botão
            if ($request->button_display_50 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type_50' => 'required',
                ],[
                    'button_type_50.required' => 'O destino do botão é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type_50 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_50' => 'required',
                    ],[
                        'button_pagina_50.required' => 'A página do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type_50 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_50' => 'required',
                    ],[
                        'button_url_50.required' => 'O link do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        if ($request->layout == '51') {
            $validator = Validator::make($request->all(), [
                'title_51' => 'required',
                'content_51' => 'required',
            ], [
                'title_51.required' => 'O título é obrigatório',
                'content_51.required' => 'O conteúdo é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            //Valida se for enviado a imagem
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_51' => 'required',
                ],[
                    'image_51.required' => 'A imagem é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
        }

        if ($request->layout == '52') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                'title_52' => 'required',
                'content_52' => 'required',
            ], [
                'title_52.required' => 'O título é obrigatório',
                'content_52.required' => 'O conteúdo é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
            //Valida se for enviado a imagem ou o vídeo de acordo com qual tipo de conteúdo foi selecionado
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_52' => 'required',
                ],[
                    'image_52.required' => 'A imagem é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
            //Valida as informações necessárias caso seja selecionado para exibir o botão 1
            if ($request->button_display_52 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type_52' => 'required',
                ],[
                    'button_type_52.required' => 'O destino do botão é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type_52 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_52' => 'required',
                    ],[
                        'button_pagina_52.required' => 'A página do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type_52 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_52' => 'required',
                    ],[
                        'button_url_52.required' => 'O link do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        if ($request->layout == '53') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                'title_53' => 'required',
                'faqs_53' => 'required',
            ], [
                'title_53.required' => 'O título é obrigatório',
                'faqs_53' => 'É obrigatório selecionar uma categoria de faq',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '54') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                'title_54' => 'required',
                'content_54' => 'required',
                'testimonials_54' => 'required',
            ], [
                'title_54.required' => 'O título é obrigatório',
                'content_54.required' => 'O conteúdo é obrigatório',
                'testimonials_54.required' => 'É obrigatório selecionar ao menos um depoimento',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '55') {
            //Valida as infomações obrigatórias do bloco
            $validator = Validator::make($request->all(), [
                'title_55' => 'required',
                'content_55' => 'required',
                'title_55_1' => 'required',
            ], [
                'title_55.required' => 'O título é obrigatório',
                'content_55.required' => 'A desrição é obrigatória',
                'title_55_1.required' => 'O título da aba 1 é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
            //Valida se for enviado a imagem ou o vídeo de acordo com qual tipo de conteúdo foi selecionado
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_55_1' => 'required',
                ],[
                    'image_55_1.required' => 'A imagem da aba 1 é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }

            //Valida as informações necessárias caso seja selecionado para exibir o botão
            if ($request->button_display_55_1 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type_55_1' => 'required',
                ],[
                    'button_type_55_1.required' => 'O destino do botão é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type_55_1 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_55_1' => 'required',
                    ],[
                        'button_pagina_55_1.required' => 'A página do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type_55_1 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_55_1' => 'required',
                    ],[
                        'button_url_55_1.required' => 'O link do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }

            for ($i = 2; $i <= 3; $i++){
                if ($request->input('title_55_'.$i) || $request->input('subtitle_55_'.$i) || $request->input('tag_55_'.$i) || $request->input('image_55_'.$i) || $request->input('button_display_55_'.$i)){
                    $validator = Validator::make($request->all(), [
                        'title_55_' . $i => 'required',
                    ], [
                        'title_55_' . $i . '.required' => 'O título da aba ' . $i . ' é obrigatório',
                    ]);
                    if ($validator->fails()) {
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                    //Valida se for enviado a imagem ou o vídeo de acordo com qual tipo de conteúdo foi selecionado
                    if (!$request->block_id) {
                        $validator = Validator::make($request->all(), [
                            'image_55_' . $i => 'required',
                        ], [
                            'image_55_' . $i . '.required' => 'A imagem da aba ' . $i . ' é obrigatória',
                        ]);
                        if ($validator->fails()) {
                            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                        }
                    }
                    //Valida as informações necessárias caso seja selecionado para exibir o botão
                    if ($request->input('button_display_55_' . $i) == '1') {
                        $validator = Validator::make($request->all(), [
                            'button_type_55_' . $i => 'required',
                        ], [
                            'button_type_55_' . $i . '.required' => 'O destino do botão da aba ' . $i . ' é obrigatório',
                        ]);
                        if ($validator->fails()) {
                            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                        }
                        if ($request->input('button_type_55_' . $i) == 'inner_page') {
                            $validator = Validator::make($request->all(), [
                                'button_pagina_55_' . $i => 'required',
                            ], [
                                'button_pagina_55_' . $i . '.required' => 'A página do botão da aba ' . $i . ' é obrigatório',
                            ]);
                            if ($validator->fails()) {
                                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                            }
                        }
                    }
                }
            }
        }

        if ($request->layout == '56') {
            $validator = Validator::make($request->all(), [
                'title_56' => 'required',
                'content_56' => 'required',
                'title_56_1' => 'required',
                'subtitle_56_1' => 'required',
                'title_56_2' => 'required',
                'subtitle_56_2' => 'required',
                'title_56_3' => 'required',
                'subtitle_56_3' => 'required',
                'title_56_4' => 'required',
                'subtitle_56_4' => 'required',
            ], [
                'title_56.required' => 'O título é obrigatório',
                'content_56.required' => 'O conteúdo é obrigatório',
                'title_56_1.required' => 'O título da aba 1 é obrigatório',
                'subtitle_56_1.required' => 'O conteúdo da aba 1 é obrigatório',
                'title_56_2.required' => 'O título da aba 2 é obrigatório',
                'subtitle_56_2.required' => 'O conteúdo da aba 2 é obrigatório',
                'title_56_3.required' => 'O título da aba 3 é obrigatório',
                'subtitle_56_3.required' => 'O conteúdo da aba 3 é obrigatório',
                'title_56_4.required' => 'O título da aba 4 é obrigatório',
                'subtitle_56_4.required' => 'O conteúdo da aba 4 é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            //Valida se for enviado a imagem
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_56_1' => 'required',
                    'image_56_2' => 'required',
                    'image_56_3' => 'required',
                    'image_56_4' => 'required',
                ],[
                    'image_56_1.required' => 'A imagem da aba 1 é obrigatória',
                    'image_56_2.required' => 'A imagem da aba 2 é obrigatória',
                    'image_56_3.required' => 'A imagem da aba 3 é obrigatória',
                    'image_56_4.required' => 'A imagem da aba 4 é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }

            //Valida as informações necessárias caso seja selecionado para exibir o botão 1
            if ($request->button_display_56 == '1'){
                $validator = Validator::make($request->all(), [
                    'button_type_56' => 'required',
                ],[
                    'button_type_56.required' => 'O destino do botão é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->button_type_56 == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_56' => 'required',
                    ],[
                        'button_pagina_56.required' => 'A página do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->button_type_56 == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_56' => 'required',
                    ],[
                        'button_url_56.required' => 'O link do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        if ($request->layout == '57') {
            $validator = Validator::make($request->all(), [
                'title_57' => 'required',
                'content_57' => 'required',
                'title_57_1' => 'required',
                'subtitle_57_1' => 'required',
                'title_57_2' => 'required',
                'subtitle_57_2' => 'required',
                'title_57_3' => 'required',
                'subtitle_57_3' => 'required',
            ], [
                'title_57.required' => 'O título é obrigatório',
                'content_57.required' => 'O conteúdo é obrigatório',
                'title_57_1.required' => 'O título da aba 1 é obrigatório',
                'subtitle_57_1.required' => 'O conteúdo da aba 1 é obrigatório',
                'title_57_2.required' => 'O título da aba 2 é obrigatório',
                'subtitle_57_2.required' => 'O conteúdo da aba 2 é obrigatório',
                'title_57_3.required' => 'O título da aba 3 é obrigatório',
                'subtitle_57_3.required' => 'O conteúdo da aba 3 é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            //Valida se for enviado a imagem
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_57_1' => 'required',
                    'image_57_2' => 'required',
                    'image_57_3' => 'required',
                ],[
                    'image_57_1.required' => 'A imagem da aba 1 é obrigatória',
                    'image_57_2.required' => 'A imagem da aba 2 é obrigatória',
                    'image_57_3.required' => 'A imagem da aba 3 é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }
        }

        if ($request->layout == '58') {
            $validator = Validator::make($request->all(), [
                'title_58' => 'required',
            ], [
                'title_58.required' => 'O título é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '59') {
            $validator = Validator::make($request->all(), [
                'topic_category_59' => 'required',
            ], [
                'topic_category_59.required' => 'A categoria de tópicos é obrigatória',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '60') {
            $validator = Validator::make($request->all(), [
                'title_60_1' => 'required',
                'title_60_2' => 'required',
            ], [
                'title_60_1.required' => 'O título da aba 1 é obrigatório',
                'title_60_2.required' => 'O título da aba 2 é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            //Valida se for enviado a imagem
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_60_1' => 'required',
                    'image_60_2' => 'required',
                ],[
                    'image_60_1.required' => 'A imagem da aba 1 é obrigatória',
                    'image_60_2.required' => 'A imagem da aba 2 é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }

            for ($i = 1; $i <= 2; $i++){
                //Valida as informações necessárias caso seja selecionado para exibir o botão 1
                if ($request->input('button_display_60_'.$i) == '1'){
                    $validator = Validator::make($request->all(), [
                        'button_title_60_'.$i => 'required',
                        'button_type_60_'.$i => 'required',
                    ],[
                        'button_title_60_'.$i.'.required' => 'O título do botão da aba '.$i.' é obrigatório',
                        'button_type_60_'.$i.'.required' => 'O destino do botão da aba '.$i.' é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                    if ($request->input('button_type_60_'.$i) == 'inner_page'){
                        $validator = Validator::make($request->all(), [
                            'button_pagina_60_'.$i => 'required',
                        ],[
                            'button_pagina_60_'.$i.'.required' => 'A página do botão da aba '.$i.' é obrigatório',
                        ]);
                        if($validator->fails()){
                            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                        }
                    }
                    if ($request->input('button_type_60_'.$i) == 'link'){
                        $validator = Validator::make($request->all(), [
                            'button_url_60_'.$i => 'required',
                        ],[
                            'button_url_60_'.$i.'.required' => 'O link do botão da aba '.$i.' é obrigatório',
                        ]);
                        if($validator->fails()){
                            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                        }
                    }
                }
            }
        }

        if ($request->layout == '61') {
            $validator = Validator::make($request->all(), [
                'topic_category_61' => 'required',
            ], [
                'topic_category_61.required' => 'A categoria de tópicos é obrigatória',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '62') {
            $validator = Validator::make($request->all(), [
                'title_62' => 'required',
                'content_62' => 'required',
            ], [
                'title_62.required' => 'O título é obrigatório',
                'content_62.required' => 'A descrição é obrigatória',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            //Valida se for enviado a imagem
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_62' => 'required',
                ],[
                    'image_62.required' => 'A imagem é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }

            //Valida as informações necessárias caso seja selecionado para exibir o botão 1
            if ($request->input('button_display_62') == '1'){
                $validator = Validator::make($request->all(), [
                    'button_title_62' => 'required',
                    'button_type_62' => 'required',
                ],[
                    'button_title_62.required' => 'O título do botão é obrigatório',
                    'button_type_62.required' => 'O destino do botão é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->input('button_type_62') == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_62' => 'required',
                    ],[
                        'button_pagina_62.required' => 'A página do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->input('button_type_62') == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_62' => 'required',
                    ],[
                        'button_url_62.required' => 'O link do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        if ($request->layout == '63') {
            $validator = Validator::make($request->all(), [
                'title_63' => 'required',
                'content_63' => 'required',
            ], [
                'title_63.required' => 'O título é obrigatório',
                'content_63.required' => 'A descrição é obrigatória',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            //Valida se for enviado a imagem
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_63' => 'required',
                ],[
                    'image_63.required' => 'A imagem é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }

            //Valida as informações necessárias caso seja selecionado para exibir o botão 1
            if ($request->input('button_display_63') == '1'){
                $validator = Validator::make($request->all(), [
                    'button_title_63' => 'required',
                    'button_type_63' => 'required',
                ],[
                    'button_title_63.required' => 'O título do botão é obrigatório',
                    'button_type_63.required' => 'O destino do botão é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->input('button_type_63') == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_63' => 'required',
                    ],[
                        'button_pagina_63.required' => 'A página do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->input('button_type_63') == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_63' => 'required',
                    ],[
                        'button_url_63.required' => 'O link do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        if ($request->layout == '64') {
            $validator = Validator::make($request->all(), [
                'topic_category_64' => 'required',
            ], [
                'topic_category_64.required' => 'A categoria de tópicos é obrigatória',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '65') {
            $validator = Validator::make($request->all(), [
                'title_65' => 'required',
                'logos_category_65' => 'required',
            ], [
                'title_65.required' => 'O título é obrigatório',
                'logos_category_65.required' => 'A categoria de logos é obrigatória',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '66') {
            $validator = Validator::make($request->all(), [
                'title_66_1' => 'required',
                'content_66_1' => 'required',
            ], [
                'title_66_1.required' => 'O título da aba 1 é obrigatório',
                'content_66_1.required' => 'A descrição da aba 1 é obrigatória',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            //Valida se for enviado a imagem
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_66_1' => 'required',
                ],[
                    'image_66_1.required' => 'A imagem da aba 1 é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }

            for ($i = 1; $i <= 5; $i++){
                if ($request->input('title_66_'.$i) || $request->input('subtitle_66_'.$i) || $request->input('content_66_'.$i) || $request->input('image_66_'.$i)){
                    $validator = Validator::make($request->all(), [
                        'title_66_'.$i => 'required',
                        'content_66_'.$i => 'required',
                    ], [
                        'title_66_'.$i.'.required' => 'O título da aba 1 é obrigatório',
                        'content_66_'.$i.'.required' => 'A descrição da aba 1 é obrigatória',
                    ]);
                    if ($validator->fails()) {
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }

                    //Valida se for enviado a imagem
                    if (!$request->block_id){
                        $validator = Validator::make($request->all(), [
                            'image_66_'.$i => 'required',
                        ],[
                            'image_66_'.$i.'.required' => 'A imagem da aba 1 é obrigatória',
                        ]);
                        if($validator->fails()){
                            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                        }
                    }
                }

                //Valida as informações necessárias caso seja selecionado para exibir o botão 1
                if ($request->input('button_display_66_'.$i) == '1'){
                    $validator = Validator::make($request->all(), [
                        'button_title_66_'.$i => 'required',
                        'button_type_66_'.$i => 'required',
                    ],[
                        'button_title_66_'.$i.'.required' => 'O título do botão da aba '.$i.' é obrigatório',
                        'button_type_66_'.$i.'.required' => 'O destino do botão da aba '.$i.' é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                    if ($request->input('button_type_66_'.$i) == 'inner_page'){
                        $validator = Validator::make($request->all(), [
                            'button_pagina_66_'.$i => 'required',
                        ],[
                            'button_pagina_66_'.$i.'.required' => 'A página do botão da aba '.$i.' é obrigatório',
                        ]);
                        if($validator->fails()){
                            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                        }
                    }
                    if ($request->input('button_type_66_'.$i) == 'link'){
                        $validator = Validator::make($request->all(), [
                            'button_url_66_'.$i => 'required',
                        ],[
                            'button_url_66_'.$i.'.required' => 'O link do botão da aba '.$i.' é obrigatório',
                        ]);
                        if($validator->fails()){
                            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                        }
                    }
                }

                //Valida as informações necessárias caso seja selecionado para exibir o botão 1
                if ($request->input('button_display_66_'.$i) == '1'){
                    $validator = Validator::make($request->all(), [
                        'button_title1_66_'.$i => 'required',
                        'button_type1_66_'.$i => 'required',
                    ],[
                        'button_title1_66_'.$i.'.required' => 'O título do botão da aba '.$i.' é obrigatório',
                        'button_type1_66_'.$i.'.required' => 'O destino do botão da aba '.$i.' é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                    if ($request->input('button_type1_66_'.$i) == 'inner_page'){
                        $validator = Validator::make($request->all(), [
                            'button_pagina1_66_'.$i => 'required',
                        ],[
                            'button_pagina1_66_'.$i.'.required' => 'A página do botão da aba '.$i.' é obrigatório',
                        ]);
                        if($validator->fails()){
                            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                        }
                    }
                    if ($request->input('button_type1_66_'.$i) == 'link'){
                        $validator = Validator::make($request->all(), [
                            'button_url1_66_'.$i => 'required',
                        ],[
                            'button_url1_66_'.$i.'.required' => 'O link do botão da aba '.$i.' é obrigatório',
                        ]);
                        if($validator->fails()){
                            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                        }
                    }
                }
            }
        }

        if ($request->layout == '67') {
            $validator = Validator::make($request->all(), [
                'title_67_1' => 'required',
                'subtitle_67_1' => 'required',
            ], [
                'title_67_1.required' => 'O título da aba 1 é obrigatório',
                'subtitle_67_1.required' => 'A descrição da aba 1 é obrigatória',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            //Valida se for enviado a imagem
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_67_1' => 'required',
                ],[
                    'image_67_1.required' => 'O ícone da aba 1 é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }

            for ($i = 2; $i <= 4; $i++){
                if ($request->input('title_67_'.$i) || $request->input('subtitle_67_'.$i) || $request->input('image_67_'.$i)){
                    $validator = Validator::make($request->all(), [
                        'title_67_'.$i => 'required',
                        'subtitle_67_'.$i => 'required',
                    ], [
                        'title_67_'.$i.'.required' => 'O título da aba 1 é obrigatório',
                        'subtitle_67_'.$i.'.required' => 'A descrição da aba 1 é obrigatória',
                    ]);
                    if ($validator->fails()) {
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }

                    //Valida se for enviado a imagem
                    if (!$request->block_id){
                        $validator = Validator::make($request->all(), [
                            'image_67_'.$i => 'required',
                        ],[
                            'image_67_'.$i.'.required' => 'O ícone da aba 1 é obrigatória',
                        ]);
                        if($validator->fails()){
                            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                        }
                    }
                }
            }
        }

        if ($request->layout == '68') {
            $validator = Validator::make($request->all(), [
                'title_68' => 'required',
                'content_68' => 'required',
            ], [
                'title_68.required' => 'O título é obrigatório',
                'content_68.required' => 'A descrição é obrigatória',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            //Valida se for enviado a imagem
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_68' => 'required',
                ],[
                    'image_68.required' => 'A imagem é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }

            //Valida as informações necessárias caso seja selecionado para exibir o botão 1
            if ($request->input('button_display_68') == '1'){
                $validator = Validator::make($request->all(), [
                    'button_title_68' => 'required',
                    'button_type_68' => 'required',
                ],[
                    'button_title_68.required' => 'O título do botão é obrigatório',
                    'button_type_68.required' => 'O destino do botão é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->input('button_type_68') == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_68' => 'required',
                    ],[
                        'button_pagina_68.required' => 'A página do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->input('button_type_68') == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_68' => 'required',
                    ],[
                        'button_url_68.required' => 'O link do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        if ($request->layout == '69') {
            $validator = Validator::make($request->all(), [
                'title_69' => 'required',
                'content_69' => 'required',
            ], [
                'title_69.required' => 'O título é obrigatório',
                'content_69.required' => 'A descrição é obrigatória',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            //Valida se for enviado a imagem
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_69' => 'required',
                ],[
                    'image_69.required' => 'A imagem é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }

            //Valida as informações necessárias caso seja selecionado para exibir o botão 1
            if ($request->input('button_display_69') == '1'){
                $validator = Validator::make($request->all(), [
                    'button_title_69' => 'required',
                    'button_type_69' => 'required',
                ],[
                    'button_title_69.required' => 'O título do botão é obrigatório',
                    'button_type_69.required' => 'O destino do botão é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->input('button_type_69') == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_69' => 'required',
                    ],[
                        'button_pagina_69.required' => 'A página do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->input('button_type_69') == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_69' => 'required',
                    ],[
                        'button_url_69.required' => 'O link do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        if ($request->layout == '70') {
            $validator = Validator::make($request->all(), [
                'title_70' => 'required',
                'content_70' => 'required',
            ], [
                'title_70.required' => 'O título é obrigatório',
                'content_70.required' => 'A descrição é obrigatória',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '72') {
            $validator = Validator::make($request->all(), [
                'title_72' => 'required',
            ], [
                'title_72.required' => 'O título é obrigatório',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '73') {
            $validator = Validator::make($request->all(), [
                'title_73' => 'required',
                'content_73' => 'required',
            ], [
                'title_73.required' => 'O título é obrigatório',
                'content_73.required' => 'A descrição é obrigatória',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }

            //Valida se for enviado a imagem
            if (!$request->block_id){
                $validator = Validator::make($request->all(), [
                    'image_73' => 'required',
                ],[
                    'image_73.required' => 'A imagem é obrigatória',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
            }

            //Valida as informações necessárias caso seja selecionado para exibir o botão 1
            if ($request->input('button_display_73') == '1'){
                $validator = Validator::make($request->all(), [
                    'button_title_73' => 'required',
                    'button_type_73' => 'required',
                ],[
                    'button_title_73.required' => 'O título do botão é obrigatório',
                    'button_type_73.required' => 'O destino do botão é obrigatório',
                ]);
                if($validator->fails()){
                    return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                }
                if ($request->input('button_type_73') == 'inner_page'){
                    $validator = Validator::make($request->all(), [
                        'button_pagina_73' => 'required',
                    ],[
                        'button_pagina_73.required' => 'A página do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
                if ($request->input('button_type_73') == 'link'){
                    $validator = Validator::make($request->all(), [
                        'button_url_73' => 'required',
                    ],[
                        'button_url_73.required' => 'O link do botão é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        return response()->json([
            'success' => true,
            'layout' => $request->layout
        ]);
    }

    public function validateLayout(Request $request){
        if ($request->layout == '6'){
            $validator = Validator::make($request->all(), [
                'content_alignment_6' => 'required',
            ],[
                'content_alignment_6.required' => 'O alinhamento da imagem é obrigatório',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '8'){
            $validator = Validator::make($request->all(), [
                'content_alignment_8' => 'required',
            ],[
                'content_alignment_8.required' => 'O alinhamento dos tópicos é obrigatório',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '11'){
            $validator = Validator::make($request->all(), [
                'content_alignment_11' => 'required',
            ],[
                'content_alignment_11.required' => 'O alinhamento das publicações é obrigatório',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '12'){
            $validator = Validator::make($request->all(), [
                'content_alignment_12' => 'required',
            ],[
                'content_alignment_12.required' => 'O alinhamento do formulário é obrigatório',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '13'){
            $validator = Validator::make($request->all(), [
                'content_alignment_13' => 'required',
            ],[
                'content_alignment_13.required' => 'O alinhamento da imagem é obrigatório',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '14'){
            $validator = Validator::make($request->all(), [
                'content_alignment_14' => 'required',
            ],[
                'content_alignment_14.required' => 'O alinhamento da imagem é obrigatório',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '16'){
            $validator = Validator::make($request->all(), [
                'content_alignment_16' => 'required',
            ],[
                'content_alignment_16.required' => 'O alinhamento da imagem é obrigatório',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '18'){
            $validator = Validator::make($request->all(), [
                'content_alignment_18' => 'required',
                'content_type_18' => 'required',
            ],[
                'content_alignment_18.required' => 'O alinhamento do formulário é obrigatório',
                'content_type_18.required' => 'É obrigatório selecionar o tipo de conteúdo',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '19'){
            $validator = Validator::make($request->all(), [
                'content_alignment_19' => 'required',
                'type_19' => 'required',
                'display_content_19' => 'required',
                'display_content_19_1' => 'required',
            ],[
                'content_alignment_19.required' => 'O alinhamento da imagem é obrigatório',
                'type_19.required' => 'É obrigatório selecionar se o accordion deve ficar aberto ou fechado',
                'display_content_19.required' => 'É obrigatório selecionar se o pattern será exibido',
                'display_content_19_1.required' => 'É obrigatório selecionar se a imagem será exibida no mobile',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '20'){
            $validator = Validator::make($request->all(), [
                'content_alignment_20' => 'required',
            ],[
                'content_alignment_20.required' => 'O alinhamento da imagem é obrigatório',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '26'){
            $validator = Validator::make($request->all(), [
                'type_26' => 'required',
            ],[
                'type_26.required' => 'É obrigatório selecionar se irá exibir ou não o botão',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '24'){
            $validator = Validator::make($request->all(), [
                'content_alignment_24' => 'required',
            ],[
                'content_alignment_24.required' => 'O alinhamento da imagem é obrigatório',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '29'){
            $validator = Validator::make($request->all(), [
                'type_29' => 'required',
            ],[
                'type_29.required' => 'O tamanho do título é obrigatório',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '38'){
            $validator = Validator::make($request->all(), [
                'content_alignment_38' => 'required',
                'type_38' => 'required',
            ],[
                'content_alignment_38.required' => 'O alinhamento do formulário é obrigatório',
                'type_38.required' => 'O layout do botão é obrigatório',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '39'){
            $validator = Validator::make($request->all(), [
                'content_alignment_39' => 'required',
                'type_39' => 'required',
                'display_content_39_1' => 'required',
            ],[
                'content_alignment_39.required' => 'O alinhamento das imagens é obrigatório',
                'type_39.required' => 'O layout do botão é obrigatório',
                'display_content_39_1.required' => 'É obrigatório selecionar se o pattern será exibido',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '40'){
            $validator = Validator::make($request->all(), [
                'content_alignment_40' => 'required',
                'type_40' => 'required',
                'display_content_40_1' => 'required',
                'display_content_40' => 'required',
            ],[
                'content_alignment_40.required' => 'O alinhamento da imagem é obrigatório',
                'type_40.required' => 'O layout do botão é obrigatório',
                'display_content_40_1.required' => 'É obrigatório selecionar se o pattern será exibido',
                'display_content_40.required' => 'É obrigatório selecionar se a imagem será exibida no mobile',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '41'){
            $validator = Validator::make($request->all(), [
                'content_alignment_41' => 'required',
            ],[
                'content_alignment_41.required' => 'O alinhamento das imagens é obrigatório',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '49'){
            $validator = Validator::make($request->all(), [
                'content_alignment_49' => 'required',
                'type_49' => 'required',
                'display_content_49_1' => 'required',
            ],[
                'content_alignment_49.required' => 'O alinhamento das imagens é obrigatório',
                'type_49.required' => 'O layout do botão é obrigatório',
                'display_content_49_1.required' => 'É obrigatório selecionar se o pattern será exibido',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '50'){
            $validator = Validator::make($request->all(), [
                'type_50' => 'required',
                'display_content_50_1' => 'required',
                'display_content_50_2' => 'required',
            ],[
                'type_50.required' => 'O layout do botão é obrigatório',
                'display_content_50_1.required' => 'É obrigatório selecionar se o pattern da esquerda será exibido',
                'display_content_50_2.required' => 'É obrigatório selecionar se o pattern da direita será exibido',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '51'){
            $validator = Validator::make($request->all(), [
                'content_alignment_51' => 'required',
            ],[
                'content_alignment_51.required' => 'O alinhamento da imagem é obrigatório',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '52'){
            $validator = Validator::make($request->all(), [
                'content_alignment_52' => 'required',
                'type_52' => 'required',
            ],[
                'content_alignment_52.required' => 'O alinhamento da imagem é obrigatório',
                'type_52.required' => 'O layout do botão é obrigatório',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '55'){
            for ($i = 1; $i <= 3; $i++){
                if ($request->input('button_display_55_'.$i)){
                    $validator = Validator::make($request->all(), [
                        'type_55_'.$i => 'required',
                    ],[
                        'type_55_'.$i.'.required' => 'O layout do botão da aba '.$i.' é obrigatório',
                    ]);
                    if($validator->fails()){
                        return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
                    }
                }
            }
        }

        if ($request->layout == '56'){
            $validator = Validator::make($request->all(), [
                'display_content_56_1' => 'required',
                'content_alignment_56' => 'required',
                'type_56' => 'required',
            ],[
                'display_content_56_1.required' => 'É obrigatório selecionar se o pattern deve ou não ser exibido',
                'content_alignment_56.required' => 'O alinhamento das imagens é obrigatório',
                'type_56.required' => 'O layout do botão é obrigatório',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '57'){
            $validator = Validator::make($request->all(), [
                'content_alignment_57' => 'required',
            ],[
                'content_alignment_57.required' => 'O alinhamento dos ícones é obrigatório',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '62'){
            $validator = Validator::make($request->all(), [
                'content_alignment_62' => 'required',
                'display_content_62' => 'required',
                'display_content_62_1' => 'required',
            ],[
                'content_alignment_62.required' => 'O alinhamento dos ícones é obrigatório',
                'display_content_62.required' => 'É obrigatório selecionar se o pattern será exibido',
                'display_content_62_1.required' => 'É obrigatório selecionar se a imagem será exibida no mobile',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        if ($request->layout == '70'){
            $validator = Validator::make($request->all(), [
                'content_alignment_70' => 'required'
            ],[
                'content_alignment_70.required' => 'O alinhamento do conteúdo é obrigatório',
            ]);
            if($validator->fails()){
                return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
            }
        }

        return response()->json([
            'success' => true,
            'layout' => $request->layout
        ]);
    }

    public function changeTitle(Request $request){
        DB::beginTransaction();
        try{
            $block = Block::findOrFail($request->id);
            $block->block_title = $request->block_title;
            $block->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Título do bloco editado com sucesso',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao editar título do bloco!".$e->getMessage()
            ]);
        }
    }

    public function displayOrder(Request $request){
        DB::beginTransaction();
        try{
            $i = 1;
            foreach ($request->ids as $id){
                $block = Block::findOrFail($id);
                $block->display_order = $i;
                $block->save();
                $i++;
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Ordem de exibição editada com sucesso',
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao editar ordem de exibição".$e->getMessage()
            ]);
        }
    }

    public function copy(Block $block){
        DB::beginTransaction();
        try{
            $new_block = $block->replicate();
            $new_block->push();
            $new_block->block_title = $new_block->block_title.' - Cópia';

            $lastBlock = Block::where('page_id', $block->page_id)->orderBy('display_order', 'desc')->first();
            $new_block->display_order = $lastBlock->display_order + 1;

            $new_block->save();
            $new_block->hashId = $new_block->hash_id;

            foreach ($block->tabs as $tab){
                $new_tab = $tab->replicate();
                $new_tab->push();
                $new_tab->block_id = $new_block->id;
                $new_tab->save();
            }

            DB::commit();
            return response()->json([
                'success' => true
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao copiar bloco: ".$e->getMessage()
            ]);
        }
    }

    public function makeTemplate(Request $request){
        $block = Block::findOrFail($request->block_id);
        DB::beginTransaction();
        try{
            $new_block = $block->replicate();
            $new_block->push();
            $new_block->page_id  = 0;
            $new_block->block_title = $request->title;
            $new_block->is_template = true;
            $new_block->save();
            foreach ($block->tabs as $tab){
                $new_tab = $tab->replicate();
                $new_tab->push();
                $new_tab->block_id = $new_block->id;
                $new_tab->save();
            }
            DB::commit();
            return response()->json([
                'success' => true
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao criar template de bloco: ".$e->getMessage()
            ]);
        }
    }

    public function useTemplate(Request $request){
        $validator = Validator::make($request->all(), [
            'block_id' => 'required'
        ],[
            'block_id.required' => 'O template do bloco é obrigatório'
        ]);
        if($validator->fails()){
            return response()->json(['success' => false, 'message' => $validator->errors()->first()]);
        }
        $block = Block::findOrFail($request->block_id);
        DB::beginTransaction();
        try{
            $new_block = $block->replicate();
            $new_block->page_id = $request->page_id;
            $new_block->push();
            $new_block->is_template = false;

            $lastBlock = Block::where('page_id', $block->page_id)->orderBy('display_order', 'desc')->first();
            $new_block->display_order = $lastBlock->display_order + 1;

            $new_block->save();

            foreach ($block->tabs as $tab){
                $new_tab = $tab->replicate();
                $new_tab->push();
                $new_tab->block_id = $new_block->id;
                $new_tab->save();
            }

            DB::commit();
            return response()->json([
                'success' => true
            ]);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => "Falha ao usar template de bloco: ".$e->getMessage()
            ]);
        }
    }
}
