<?php

namespace App\Services;

use App\Enums\ChangeEventEnum;

class ChangeEventItem
{
    protected ChangeEventEnum $type;

    protected string $fieldChanged;

    protected string $previousValue;

    protected string $givenValue;

    public function __construct(ChangeEventEnum $type, string|null $fieldChanged = '', string|null $previousValue = '', string|null $givenValue = '')
    {
        $this->type = $type;
        $this->fieldChanged = $fieldChanged ?: '';
        $this->previousValue = $previousValue ?: '';
        $this->givenValue = $givenValue ?: '';
    }

    public function getType(): ChangeEventEnum
    {
        return $this->type;
    }

    public function getGivenValue(): string
    {
        return $this->givenValue;
    }

    public function getPreviousValue(): string
    {
        return $this->previousValue;
    }

    public function toString(): string
    {
        $stringComposition = $this->type->getName();
        if ($this->type->needsDescription()) {
            $stringComposition .= ' ' . $this->fieldChanged . ': ' . $this->previousValue . ' -> ' . $this->givenValue;
        }
        return $stringComposition;
    }
}
