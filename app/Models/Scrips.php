<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scrips extends Model
{
    protected $guarded = [];

    public function today() {
        return $this->hasMany(ScripData::class, 'scrip_id', 'id')->latest('scrip_date');
    }
}
