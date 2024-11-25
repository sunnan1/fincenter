<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FundScrip extends Model
{

    protected $fillable = ['fund_id' , 'scrip_id' , 'equity_per' , 'is_active'];

    public function scrip()
    {
        return $this->belongsTo(Scrips::class , 'scrip_id');
    }

    public function scripdata() {
        return $this->hasOne(ScripData::class , 'scrip_id')->latestOfMany('updated_at');
    }
}
