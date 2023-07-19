<?php

namespace App\Models;

use App\Traits\HasTimestamps;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Appeal extends Model
{

    // TODO: Shame
    public static array $sources = [
        "Главная",
        "Акции",
        "Мероприятия",
        "Детям",
        "Выездной квест",
        "Франшиза",
        "Шоу-игра",
        "Спектакли",
        "Сертификаты",
        "Нет",
        "Нет",
        "Нет",
        "Нет",
    ];

    // TODO: Shame
    public static array $forms = [
        "Заявка на мероприятие",
        "Форма обратной связи",
        "Оставить заявку",
        "Нет",
        "Нет",
        "Нет",
        "Нет",
        "Нет",
        "Нет",
        "Нет",
        "Нет",
    ];


    public static array $statuses = [
        "Новый",
        "В работе",
        "Забронирован",
        "Отменен"
    ];

    public function sourceId(): Attribute
    {
        return Attribute::make(
            get: static fn(int $value) => self::$sources[$value]
        );
    }

    public function formId(): Attribute
    {
        return Attribute::make(
            get: static fn(int $value) => self::$forms[$value]
        );
    }

    public function status(): Attribute
    {
        return Attribute::make(
            get: static fn(int $value) => self::$statuses[$value]
        );
    }


    protected $fillable = [
        "name",
        "phone",
        "email",
        "text",
        "status",
        "location_id",
        "source_url",
        "captcha_score",
        "source_id",
        "form_id",
        "admin_comment",
        "entity_id",
    ];
}
