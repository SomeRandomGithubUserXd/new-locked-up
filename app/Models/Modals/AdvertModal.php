<?php

namespace App\Models\Modals;

use Illuminate\Database\Eloquent\Model;

class AdvertModal extends Model
{
    public $timestamps = false;

    protected $fillable =  [
        'title_ru',
        'title_en',
        'lead_ru',
        'lead_en',
        'text_ru',
        'text_en',
        'img_path',
        'img_base_url',
        'button_text_ru',
        'button_text_en',
        'button_url_ru',
        'button_url_en',
        'enabled',
    ];

    protected $table = 'advert_modals';

    protected $casts = [
        'enabled' => 'bool',
    ];
}
