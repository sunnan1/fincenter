<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scrips extends Model
{
    protected $guarded = [];

    public function latest() {
        return $this->hasOne(ScripData::class, 'scrip_id', 'id')->latestOfMany('updated_at');
    }

    public function getTechnicalDayAttribute() {
        return ucfirst(str_replace("_" , " ", $this->attributes['technical_day']));
    }
    public function getTechnicalWeekAttribute() {
        return ucfirst(str_replace("_" , " ", $this->attributes['technical_week']));
    }

    public function getTechnicalMonthAttribute() {
        return ucfirst(str_replace("_" , " ", $this->attributes['technical_month']));
    }

    public function getTechnicalHourAttribute() {
        return ucfirst(str_replace("_" , " ", $this->attributes['technical_hour']));
    }
}
