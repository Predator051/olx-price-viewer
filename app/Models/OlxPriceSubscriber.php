<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OlxPriceSubscriber extends Model
{
    use HasFactory;

    public $fillable = [
        'email',
        'olx_price_id'
    ];

    public function prices(): BelongsToMany
    {
        return $this->belongsToMany(OlxPrice::class);
    }
}
