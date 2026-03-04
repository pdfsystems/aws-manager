<?php

namespace App\Models;

use App\Contracts\HasColor;
use App\Contracts\HasIcon;
use App\Contracts\IncidentSource;
use App\Enums\TargetState;
use App\Observers\TargetObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use OwenIt\Auditing\Contracts\Auditable;

#[ObservedBy([TargetObserver::class])]
class Target extends Model implements Auditable, HasColor, HasIcon, IncidentSource
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'target_group_id',
        'instance_id',
        'state',
    ];

    protected $casts = [
        'state' => TargetState::class,
    ];

    public function targetGroup(): BelongsTo
    {
        return $this->belongsTo(TargetGroup::class);
    }

    public function instance(): BelongsTo
    {
        return $this->belongsTo(Instance::class);
    }

    public function incidents(): MorphMany
    {
        return $this->morphMany(Incident::class, 'source');
    }

    public function getInstanceName(): string
    {
        if (! is_null($this->instance)) {
            return $this->instance->display_name ?: $this->instance->name;
        } else {
            return $this->instance_id;
        }
    }

    public function getIcon(): ?string
    {
        return match ($this->state) {
            TargetState::Healthy => 'check-circle',
            TargetState::Unhealthy => 'x-circle',
            default => null,
        };
    }

    public function getColor(): ?string
    {
        return match ($this->state) {
            TargetState::Healthy => 'green',
            TargetState::Unhealthy => 'red',
            default => 'gray',
        };
    }

    public function generateTags(): array
    {
        return $this->isDirty('state') ? ['health'] : [];
    }

    public function getIncidentDescription(): string
    {
        return "{$this->targetGroup->name}/{$this->getInstanceName()}";
    }
}
