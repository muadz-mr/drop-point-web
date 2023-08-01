<?php

namespace App\Enums;

use App\Enums\BaseEnum;

final class PackageStatus extends BaseEnum
{
    const Arrived = 1;
    const Stored = 2;
    const Collected = 3;
}
