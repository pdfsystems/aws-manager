<?php

namespace App\Models;

use App\Contracts\HasFluxVariant;
use App\Enums\InstanceState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Instance extends Model implements Auditable, HasFluxVariant
{
    use HasFactory, \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'architecture',
        'type',
        'cpu_cores',
        'memory_bytes',
        'state',
    ];

    protected $casts = [
        'cpu_cores' => 'integer',
        'state' => InstanceState::class,
    ];

    public function getFluxVariant(): string
    {
        return $this->state === InstanceState::Running ? 'success' : 'danger';
    }
}
