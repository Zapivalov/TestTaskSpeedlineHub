<?php

declare(strict_types=1);

namespace App\Enum;

enum UserStatus: int
{
    case active = 0;
    case removed = 1;
}
