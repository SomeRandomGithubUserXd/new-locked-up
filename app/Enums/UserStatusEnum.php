<?php

namespace App\Enums;

enum UserStatusEnum: int
{
    case banned = 1;

    case active = 2;

    case idle = 3;
}
