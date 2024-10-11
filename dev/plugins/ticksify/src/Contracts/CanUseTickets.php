<?php

namespace Dev\Ticksify\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface CanUseTickets
{
    public function tickets(): MorphMany;
}
