<?php

namespace Dev\Ticksify\Enums;

use Dev\Base\Facades\BaseHelper;
use Dev\Base\Supports\Enum;
use Illuminate\Support\HtmlString;

class TicketStatus extends Enum
{
    public const OPEN = 'open';

    public const IN_PROGRESS = 'in_progress';

    public const ON_HOLD = 'on_hold';

    public const CLOSED = 'closed';

    protected static $langPath = 'plugins/ticksify::ticksify.enums.statuses';

    public function toHtml(): HtmlString|string
    {
        $color = match ($this->value) {
            self::OPEN => 'primary',
            self::IN_PROGRESS => 'info',
            self::ON_HOLD => 'warning',
            self::CLOSED => 'success',
            default => 'secondary',
        };

        return BaseHelper::renderBadge($this->label(), $color);
    }
}
