<?php

namespace App\Models;

use App\Enum\Statuses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'status',
        'email',
        'user_id',
    ];

    protected $casts = [
        'status' => Statuses::class,
    ];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
