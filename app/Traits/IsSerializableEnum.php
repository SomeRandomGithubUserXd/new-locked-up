<?php

namespace App\Traits;

use ReflectionException;

trait  IsSerializableEnum
{
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::values(), self::names());
    }

    /**
     * @throws ReflectionException
     */
    public static function getArray(): array
    {
        $enums = [];
        foreach (self::array() as $enum) {
            $self = (new \ReflectionEnum(self::class))->getCase($enum);
            $enums[] = $self->getValue()->toArray();
        }
        return $enums;
    }
}
