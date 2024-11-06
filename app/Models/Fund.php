<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    protected $guarded = [];

    public function latestperformance() {
        return $this->hasOne(FundPerformance::class, 'fund_id')->latest('validity_date');
    }
}
