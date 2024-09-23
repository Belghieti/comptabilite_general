<?php

namespace App\Http\Controllers;

use App\Models\Ecriture;
use App\Models\PlanComptable;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;


class CompteController extends Controller
{
    // Affichage de la liste des comptes
    public function index()
    {
        // Récupère tous les comptes dans la table plan_comptable
        $planComptables = PlanComptable::all();
       
        // Passe les données à la vue
        return view('Compte.index', compact('planComptables'));
    }

    // Affichage des détails d'un ou plusieurs comptes
    public function show(Request $request)
    {
        // Récupérer l'id du premier et du dernier compte sélectionné par l'utilisateur
        $compteId = $request->input('compte_id');
        $compteId1 = $request->input('compte_id1');

        // Récupérer l'ID de l'entreprise depuis la session
        $entrepriseId = session('entreprise_id');

        // Vérifie que l'ID de l'entreprise est défini dans la session
       /* if (!$entrepriseId) {
           // abort(404, 'vous devez selectionner une entreprise.');
           return view('error.404');
        }*/

        // Si le même compte est sélectionné, ne récupérer qu'un seul compte
        if ($compteId == $compteId1) {
            $comptes = PlanComptable::where('id', $compteId)
                                    ->get();
        } else {
            // Récupérer tous les comptes compris entre ces deux ID
            $comptes = PlanComptable::whereBetween('id', [$compteId, $compteId1])
                                    ->get();
        }

        // Récupérer toutes les écritures associées à ces comptes pour l'entreprise sélectionnée
        $ecritures = Ecriture::whereIn('plan_comptable_id', $comptes->pluck('id'))
                             ->where('entreprise_id', $entrepriseId)
                             ->get();

        // Calculer le solde pour chaque compte
        $soldeGlobal = 0;
        foreach ($comptes as $compte) {
            $soldeCompte = 0;
            $ecrituresCompte = $ecritures->where('plan_comptable_id', $compte->id);
            foreach ($ecrituresCompte as $ecriture) {
                $soldeCompte += ($ecriture->debit - $ecriture->credit);
            }
            $compte->solde = $soldeCompte; // On stocke le solde dans l'objet compte pour l'utiliser dans la vue
            $soldeGlobal += $soldeCompte;  // Solde global pour tous les comptes
        }

        return view('Compte.show', compact('comptes', 'ecritures', 'soldeGlobal', 'compteId', 'compteId1'));
    }

    public function exportPDF(Request $request)
    {
        // Récupérer les données comme dans la méthode show
        $compteId = $request->input('compte_id');
        $compteId1 = $request->input('compte_id1');
    
        // Vérifie si les IDs sont présents
        if (!$compteId || !$compteId1) {
            return redirect()->back()->with('error', 'Les identifiants de compte sont requis.');
        }
    
        $entrepriseId = session('entreprise_id');
    
        if ($compteId == $compteId1) {
            $comptes = PlanComptable::where('id', $compteId)->get();
        } else {
            $comptes = PlanComptable::whereBetween('id', [$compteId, $compteId1])->get();
        }
    
        $ecritures = Ecriture::whereIn('plan_comptable_id', $comptes->pluck('id'))
                             ->where('entreprise_id', $entrepriseId)
                             ->get();
    
        $soldeGlobal = 0;
        foreach ($comptes as $compte) {
            $soldeCompte = 0;
            $ecrituresCompte = $ecritures->where('plan_comptable_id', $compte->id);
            foreach ($ecrituresCompte as $ecriture) {
                $soldeCompte += ($ecriture->debit - $ecriture->credit);
            }
            $compte->solde = $soldeCompte;
            $soldeGlobal += $soldeCompte;
        }
    
        // Créer le PDF en passant les données à la vue
        $pdf = FacadePdf::loadView('Compte.pdf', compact('comptes', 'ecritures', 'soldeGlobal'));
    
        // Télécharger le PDF
        return $pdf->download('compte.pdf');
    }
    
}
