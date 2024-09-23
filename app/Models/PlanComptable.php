<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanComptable extends Model
{
    use HasFactory;

    protected $table = 'plan_comptable';
    
    public function ecriture(){
       
        return $this->hasMany(Ecriture::class, 'plan_comptable_id');

    }
}


