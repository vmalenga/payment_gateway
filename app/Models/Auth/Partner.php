<?php

namespace App\Models\Auth;

use App\Models\System\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'abbreviation',
        'country_id',
        'client_id',
        'client_token',
        'token',
        'expires_in',
        'created_by',
        'updated_by',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
