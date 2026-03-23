<?php

namespace App\Models\Pages;

use App\Models\General\Courses\Course;
use App\Models\General\Courses\Showcase;
use App\Traits\Hashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Block extends Model
{
    use HasFactory, SoftDeletes, Hashid;

    protected $table = 'blocks';

    protected $fillable = [
        'is_template', 'page_id',
        'block_title', 'layout', 'display_order', 'spacing', 'margin_top', 'margin_bottom',
        'title', 'title_color',
        'subtitle', 'subtitle_color',
        'tag', 'tag_color', 'tag_title_color',
        'content', 'content_color', 'content_type', 'display_content', 'content_alignment', 'content_link', 'image', 'video', 'proportion',
        'background_color',
        'button_display', 'button_title', 'button_title_color', 'button_border_color', 'button_color', 'button_type', 'button_link',
        'button_display_1', 'button_title_1', 'button_title_color_1', 'button_border_color_1', 'button_color_1', 'button_type_1', 'button_link_1',
        'divider', 'divider_color',
        'date', 'date_color',
        'primary_color',
        'page_value_of', 'page_value_by', 'page_value_of_color', 'page_value_by_color', 'initial_value', 'final_value',
        'display_pdf', 'pdf', 'pdf_title', 'pdf_title_color', 'pdf_color',
        'logo_display', 'logo', 'logo_title', 'logo_title_color', 'logo_background_color',
        'blogs_model', 'blog_category', 'blogs',
        'testimonial_category', 'testimonials',
        'faq_category', 'faqs',
        'is_topic', 'topic_category', 'topics_categories', 'topics', 'topics_color',
        'logos_category',
        'events', 'galleries',
        'alerts',
        'cards_categories',
        'type',
        'pages',
        'email',
        'portfolios', 'portfolios_categories',
        'font_title', 'font_subtitle', 'font_description', 'font_button'
    ];

    public function page(){
        return $this->belongsTo(Page::class);
    }

    public function tabs(){
        return $this->hasMany(Block_Tab::class, 'block_id', 'id');
    }
}
