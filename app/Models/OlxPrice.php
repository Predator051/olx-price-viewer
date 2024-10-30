<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OlxPrice extends Model
{
    use HasFactory;

    public $fillable = [
        'link',
        'price'
    ];

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(OlxPriceSubscriber::class);
    }
}
