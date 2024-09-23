<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'date_debut_exercise',
        'date_fin_exercise',
        'user_id'
    ];

    protected $dates = [
        'date_debut_exercise',
        'date_fin_exercise',
    ];

   

  
    

   

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function ecritures()
    {
        return $this->hasMany(Ecriture::class);
    }

}
