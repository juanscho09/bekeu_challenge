<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use SoftDeletes;
    
    public function State(){
        return $this->hasOne("App\Models\State", "id", "state_id");
    }

    public function getCreatedAtAttribute($date){
        return Carbon::parse($date)->setTimezone('America/Argentina/Buenos_Aires')->format('d/m/Y H:i:s');
    }

    public function getUpdatedAtAttribute($date) {
        return Carbon::parse($date)->setTimezone('America/Argentina/Buenos_Aires')->format('d/m/Y H:i:s');
    }
}
