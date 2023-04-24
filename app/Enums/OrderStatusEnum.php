<?php

namespace App\Enums;
use App\Traits\IsSerializableEnum;

enum OrderStatusEnum: int implements ISerializableEnum
{
    use IsSerializableEnum;

    case not_viewed = 0;

    case to_call_1 = 1;

    case to_call_2 = 2;

    case rescheduled = 3;

    case canceled = 4;

    case deleted = 5;

    case done = 6;

    case in_progress = 7;


    public function getName(): string
    {
        return match ($this) {
            self::not_viewed => 'Не обработан',
            self::to_call_1 => 'Прозвон 1',
            self::to_call_2 => 'Прозвон 2',
            self::rescheduled => 'Перенос',
            self::canceled => 'Отменен',
            self::deleted => 'Удален',
            self::done => 'Проведен',
            self::in_progress => 'В работе',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::not_viewed => 'red',
            self::to_call_1, self::rescheduled => 'rgb(220,220,95)',
            self::to_call_2, self::done => 'green',
            self::canceled, self::deleted => 'orange',
            self::in_progress => 'lightblue',
        };
    }

    public static function getArray(): array
    {
        $enums = [];
        foreach (self::array() as $enum) {
            $self = (new \ReflectionEnum(self::class))->getCase($enum);
            $enums[] = $self->getValue()->toArray();
        }
        return $enums;
    }

    public function toArray(): array
    {
        return [
            'key' => $this->value,
            'name' => $this->getName(),
            'color' => $this->getColor()
        ];
    }
}
