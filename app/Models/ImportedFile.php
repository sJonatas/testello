<?php

namespace App\Models;

use App\Enum\Statuses;
use Illuminate\Database\Eloquent\Model;

class ImportedFile extends Model
{
    public $fillable = [
        'id',
        'filename',
        'size',
        'status',
        'failure',
    ];

    public $casts = [
        'status' => Statuses::class,
    ];
}
