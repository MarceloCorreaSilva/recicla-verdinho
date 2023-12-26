<?php

namespace App\Enums;

enum StatusType: string
{
    case INPUT = 'input';
    case OUTPUT = 'output';

    public static function getValues(): array
    {
        return array_column(StatusType::cases(), 'value');
    }


    public static function getKeyValues(): array
    {
        return array_column(StatusType::cases(), 'value', 'value');
    }
}
