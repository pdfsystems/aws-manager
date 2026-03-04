<?php

namespace App\Models;

use App\Contracts\HasFluxVariant;
use App\Enums\Protocol;
use App\Enums\TargetState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class TargetGroup extends Model implements Auditable, HasFluxVariant
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'display_name',
        'arn',
        'vpc',
        'protocol',
        'port',
    ];

    protected $casts = [
        'protocol' => Protocol::class,
    ];

    public function targets(): HasMany
    {
        return $this->hasMany(Target::class);
    }

    public function isHealthy(): bool
    {
        return $this->targets->where('state', '=', TargetState::Healthy)->isNotEmpty();
    }

    public function getFluxVariant(): string
    {
        if ($this->targets->where('state', '=', TargetState::Healthy)->isEmpty()) {
            return 'danger';
        } elseif ($this->targets->where('state', '!=', TargetState::Healthy)->isNotEmpty()) {
            return 'warning';
        } else {
            return 'success';
        }
    }
}
