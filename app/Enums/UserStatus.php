<?php declare(strict_types=1);

namespace App\Enums;

use App\Enums\BaseEnum;

final class UserStatus extends BaseEnum
{
    const Inactive = 0;
    const Active = 1;
    const Blocked = 2;
}
