<?php

namespace Dev\AuditLog\Models;

use Dev\ACL\Models\User;
use Dev\Base\Models\BaseModel;
use Dev\Base\Models\BaseQueryBuilder;
use Dev\Setting\Enums\DataRetentionPeriod;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

class AuditHistory extends BaseModel
{
    use MassPrunable;

    protected $table = 'audit_histories';

    protected $fillable = [
        'user_agent',
        'ip_address',
        'module',
        'action',
        'user_id',
        'reference_user',
        'reference_id',
        'reference_name',
        'type',
        'request',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function prunable(): Builder|BaseQueryBuilder
    {
        $days = setting('audit_log_data_retention_period', DataRetentionPeriod::ONE_MONTH);

        if ($days === DataRetentionPeriod::NEVER) {
            return $this->query()->where('id', '<', 0);
        }

        return $this->query()->where('created_at', '<', Carbon::now()->subDays($days));
    }
}
