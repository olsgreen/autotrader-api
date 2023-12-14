<?php

namespace Olsgreen\AutoTrader\Api\Enums;

class LifecycleStates extends AbstractEnum
{
    const DUE_IN = 'DUE_IN';

    const FORECOURT = 'FORECOURT';

    const SALE_IN_PROGRESS = 'SALE_IN_PROGRESS';

    const SOLD = 'SOLD';

    const WASTEBIN = 'WASTEBIN';

    const DELETED = 'DELETED';
}
