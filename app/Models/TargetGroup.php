<?php

namespace App\Models;

use App\Enums\Protocol;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetGroup extends Model
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
}
