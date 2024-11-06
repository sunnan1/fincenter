<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sectors extends Model
{
    protected $guarded = [];

    public function scrips() {
        return $this->hasMany(Scrips::class , 'sector_id','id');
    }
}
