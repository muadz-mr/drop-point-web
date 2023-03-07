<?php

namespace App\Enums;

use App\Enums\BaseEnum;

final class StorageLocationStatus extends BaseEnum
{
    const Unavailable = 0;
    const Available = 1;
    const Full = 2;
}
