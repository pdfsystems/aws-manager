<?php

namespace App\Models;

use App\Contracts\HasFluxVariant;
use App\Enums\Protocol;
use App\Enums\TargetState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TargetGroup extends Model implements HasFluxVariant
{
    use HasFactory;

    protected $fillable = [
        'name',
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
        return $this->targets()->where('state', '!=', TargetState::Healthy)->doesntExist();
    }

    public function getFluxVariant(): string
    {
        return $this->isHealthy() ? 'success' : 'danger';
    }
}
