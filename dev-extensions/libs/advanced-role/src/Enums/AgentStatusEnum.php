<?php

namespace Dev\AdvancedRole\Enums;

use Dev\Base\Supports\Enum;
use Dev\Base\Facades\Html;
use Illuminate\Support\HtmlString;

/**
 * @method static AgentStatusEnum ACTIVE()
 * @method static AgentStatusEnum DISBALED()
 * @method static AgentStatusEnum PENDING()
 */
class AgentStatusEnum extends Enum
{
    public const ACTIVE = 'active';
    public const DISBALED = 'disable';
    public const PENDING = 'pending';

    public static $langPath = 'libs/advanced-role::advanced-role.agent-status';

    public function toHtml(): string|HtmlString
    {
        return match ($this->value) {
            self::ACTIVE => Html::tag('span', self::ACTIVE()->label(), ['class' => 'label-info status-label'])
                ->toHtml(),
            self::PENDING => Html::tag('span', self::PENDING()->label(), ['class' => 'label-warning status-label'])
                ->toHtml(),
            self::DISBALED => Html::tag('span', self::DISBALED()->label(), ['class' => 'label-success status-label'])
                ->toHtml(),
            default => parent::toHtml(),
        };
    }
}
