<?php

namespace App\Models;

use App\Contracts\IncidentSource;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Incident extends Model
{
    use HasFactory, SoftDeletes;

    public function source(): MorphTo
    {
        return $this->morphTo();
    }

    public function getDurationAttribute(): ?CarbonInterval
    {
        if (! $this->trashed()) {
            return null;
        }

        return CarbonInterval::instance($this->created_at->diff($this->deleted_at));
    }

    public function getSourceDescriptionAttribute(): string
    {
        if ($this->source instanceof IncidentSource) {
            return $this->source->getIncidentDescription();
        } else {
            return "$this->source_type/$this->source_id";
        }
    }
}
