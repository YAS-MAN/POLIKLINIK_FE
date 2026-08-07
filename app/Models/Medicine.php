<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicine extends Model
{
    protected $guarded = [];

    public function procurements(): HasMany
    {
        return $this->hasMany(Procurement::class);
    }
}
