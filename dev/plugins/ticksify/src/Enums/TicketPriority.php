<?php

namespace Dev\Ticksify\Enums;

use Dev\Base\Facades\BaseHelper;
use Dev\Base\Supports\Enum;
use Illuminate\Support\HtmlString;

class TicketPriority extends Enum
{
    public const LOW = 'low';

    public const MEDIUM = 'medium';

    public const HIGH = 'high';

    public const CRITICAL = 'critical';

    protected static $langPath = 'plugins/ticksify::ticksify.enums.priorities';

    public function toHtml(): HtmlString|string
    {
        $color = match ($this->value) {
            self::LOW => 'info',
            self::MEDIUM => 'warning',
            self::HIGH, self::CRITICAL => 'danger',
            default => 'secondary',
        };

        return BaseHelper::renderBadge($this->label(), $color);
    }
}
