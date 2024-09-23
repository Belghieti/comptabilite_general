<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ecriture extends Model
{
    use HasFactory;
    protected $fillable = [
        'plan_comptable_id',
        'date',
        'libelle',
        'debit',
        'credit',
        'reference', 
        'ecriture_associee_id',
        'entreprise_id'
    ];
  
    

   /* public function compte()
    {
        return $this->belongsTo(Compte::class);
    }*/
    public function compte()
{
    return $this->belongsTo(PlanComptable::class, 'plan_comptable_id');
}

    public function ecritureAssociee()
    {
        return $this->belongsTo(Ecriture::class, 'ecriture_associee_id');
    }
    public function planComptable()
    {
        return $this->belongsTo(PlanComptable::class, 'plan_comptable_id');
    }
    


    public function compteAssocie()
    {
        return $this->belongsTo(PlanComptable::class, 'plan_comptable_id', 'id');
    }
    


}
