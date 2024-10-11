<?php

namespace Dev\Ticksify\Models;

use Dev\ACL\Models\User;
use Dev\Base\Enums\BaseStatusEnum;
use Dev\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Message extends BaseModel
{
    protected $table = 'fob_ticket_messages';

    protected $fillable = [
        'sender_id',
        'sender_type',
        'ticket_id',
        'content',
        'status',
    ];

    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    public function sender(): MorphTo
    {
        return $this->morphTo();
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    protected function isStaff(): Attribute
    {
        return Attribute::get(fn () => $this->sender_type === User::class);
    }
}
