<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = [
        'show_lang_selector',
        'vk_widget_text',
        'vk_widget_text_en',
        'vk_community_link',
        'fb_link',
        'inst_link',
        'contact_email',
        'main_questions_email',
        'ads_email',
        'commercial_email',
        'copyrights',
        'copyrights_en',
        'phone',
        'phone_formatted',
        'address',
        'address_en',
        'ceo_text',
        'ceo_text_en',
        'auto_enable_christmas_schedule',
        'acquiring_enabled',
        'certificates_acquiring_enabled'
    ];
}
