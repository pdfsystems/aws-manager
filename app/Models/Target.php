<?php

namespace App\Models;

use App\Contracts\HasColor;
use App\Contracts\HasIcon;
use App\Enums\TargetState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Target extends Model implements HasColor, HasIcon
{
    use HasFactory;

    protected $fillable = [
        'target_group_id',
        'instance',
        'state',
    ];

    protected $casts = [
        'state' => TargetState::class,
    ];

    public function targetGroup(): BelongsTo
    {
        return $this->belongsTo(TargetGroup::class);
    }

    public function getIcon(): ?string
    {
        return $this->state === TargetState::Healthy ? 'check-circle' : 'x-circle';
    }

    public function getColor(): ?string
    {
        return $this->state === TargetState::Healthy ? 'green' : 'red';
    }
}
