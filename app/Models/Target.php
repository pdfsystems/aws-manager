<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Target extends Model
{
    use HasFactory;

    protected $fillable = [
        'target_group_id',
        'instance',
        'state',
    ];

    public function targetGroup(): BelongsTo
    {
        return $this->belongsTo(TargetGroup::class);
    }
}
