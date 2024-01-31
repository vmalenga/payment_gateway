<?php

namespace App\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'symbol',
        'abbreviation',
        'altenative',
        'description',
        'country_id',
    ];

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
