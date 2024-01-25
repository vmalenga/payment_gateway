<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zone extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'code',
        'name',
        'differs',
        'aheadUTC',
        'created_by',
        'updated_by'
    ];

    public function countries(): HasMany
    {
        return $this->hasMany(Country::class);
    }
}
