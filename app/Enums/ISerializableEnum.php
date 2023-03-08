<?php

namespace App\Enums;

interface ISerializableEnum
{
    public static function names(): array;

    public static function values(): array;

    public static function array(): array;

    public static function getArray(): array;

    public function toArray(): array;
}
