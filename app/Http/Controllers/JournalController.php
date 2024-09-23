<?php

namespace App\Http\Controllers;

use App\Models\Ecriture;
use App\Models\PlanComptable;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    // Afficher la page de sélection des comptes
    public function index()
    {
        $planComptables = PlanComptable::all();
        return view('Journal.index', compact('planComptables'));
    }

    // Afficher le journal d'un compte pour une entreprise sélectionnée
    public function show(Request $request)
    {
        // Récupérer l'ID du compte sélectionné
        $compteId = $request->input('compte_id');

        // Récupérer l'ID de l'entreprise sélectionnée dans la session
        $entrepriseId = session('entreprise_id');

        // Récupérer le compte sélectionné
        $compte = PlanComptable::findOrFail($compteId);

        // Récupérer toutes les écritures principales associées au compte et à l'entreprise sélectionnés
        $ecrituresPrincipales = Ecriture::where('plan_comptable_id', $compteId)
            ->where('entreprise_id', $entrepriseId)
            ->get();

        // Récupérer les références associées à ces écritures principales
        $references = $ecrituresPrincipales->pluck('reference')->filter();

        // Récupérer toutes les écritures liées aux mêmes références (y compris les principales)
        $ecrituresAssociees = Ecriture::whereIn('reference', $references)
            ->orWhere('plan_comptable_id', $compteId)
            ->where('entreprise_id', $entrepriseId) // Filtrer par entreprise
            ->orderBy('reference')  // Organiser par référence
            ->orderBy('date')       // Puis organiser par date
            ->get();

        // Calculer le total débit et crédit
        $totalDebit = $ecrituresAssociees->sum('debit');
        $totalCredit = $ecrituresAssociees->sum('credit');

        // Retourner les données à la vue
        return view('journal.show', compact('compte', 'ecrituresAssociees', 'totalDebit', 'totalCredit', 'ecrituresPrincipales'));
    }
}
