<?php

namespace App\Http\Controllers;

use App\Models\PlanComptable;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;


class BalanceController extends Controller
{
    public function index()
    {
        // Récupérer l'ID de l'entreprise sélectionnée dans la session
        $entrepriseId = session('entreprise_id');
        if (!$entrepriseId) {
            return back()->withErrors(['message' => 'ops!!Vous devez choisir une entreprise.pour continuer ..']);
        }
        // Récupérer les comptes de classe 1 à 7 depuis PlanComptable
        $comptes = PlanComptable::where('numero_compte', '>=', 100000)
                                ->orderBy('numero_compte')
                                ->get();

        // Vérifiez si des comptes sont récupérés

        // Initialisation des totaux
        $totalMovDebit = 0;
        $totalMovCredit = 0;
        $totalSoldeDebit = 0;
        $totalSoldeCredit = 0;

        // Calcul des mouvements pour chaque compte
        $balanceData = $comptes->map(function ($compte) use ($entrepriseId, &$totalMovDebit, &$totalMovCredit, &$totalSoldeDebit, &$totalSoldeCredit) {
            // Filtrer les écritures par entreprise
            $movDebitTotal = $compte->ecriture()->where('entreprise_id', $entrepriseId)->sum('debit');
            $movCreditTotal = $compte->ecriture()->where('entreprise_id', $entrepriseId)->sum('credit');

            // Calcul du solde
            $solde = $movDebitTotal - $movCreditTotal;
            $soldeDebit = $solde > 0 ? $solde : 0;
            $soldeCredit = $solde < 0 ? abs($solde) : 0;

            // Ajouter aux totaux
            $totalMovDebit += $movDebitTotal;
            $totalMovCredit += $movCreditTotal;
            $totalSoldeDebit += $soldeDebit;
            $totalSoldeCredit += $soldeCredit;

            return [
                'compte' => $compte->numero_compte,
                'nom_compte' => $compte->nom_compte,
                'mov_debit_total' => $movDebitTotal,
                'mov_credit_total' => $movCreditTotal,
                'solde_debit' => $soldeDebit,
                'solde_credit' => $soldeCredit,
            ];
        });

        // Vérifiez si des données de balance sont récupérées
        // dd($balanceData); // Vérifiez si des données sont affichées ici

        return view('balance.index', [
            'balanceData' => $balanceData,
            'totalMovDebit' => $totalMovDebit,
            'totalMovCredit' => $totalMovCredit,
            'totalSoldeDebit' => $totalSoldeDebit,
            'totalSoldeCredit' => $totalSoldeCredit,
        ]);
    }
    public function exportPdf()
    {
        // Récupérer l'ID de l'entreprise sélectionnée dans la session
        $entrepriseId = session('entreprise_id');
        if (!$entrepriseId) {
            return back()->withErrors(['message' => 'Ops!! Vous devez choisir une entreprise pour continuer.']);
        }

        // Récupérer les comptes de classe 1 à 7 depuis PlanComptable
        $comptes = PlanComptable::where('numero_compte', '>=', 100000)
                                ->orderBy('numero_compte')
                                ->get();

        // Initialisation des totaux
        $totalMovDebit = 0;
        $totalMovCredit = 0;
        $totalSoldeDebit = 0;
        $totalSoldeCredit = 0;

        // Calcul des mouvements pour chaque compte
        $balanceData = $comptes->map(function ($compte) use ($entrepriseId, &$totalMovDebit, &$totalMovCredit, &$totalSoldeDebit, &$totalSoldeCredit) {
            $movDebitTotal = $compte->ecriture()->where('entreprise_id', $entrepriseId)->sum('debit');
            $movCreditTotal = $compte->ecriture()->where('entreprise_id', $entrepriseId)->sum('credit');

            $solde = $movDebitTotal - $movCreditTotal;
            $soldeDebit = $solde > 0 ? $solde : 0;
            $soldeCredit = $solde < 0 ? abs($solde) : 0;

            $totalMovDebit += $movDebitTotal;
            $totalMovCredit += $movCreditTotal;
            $totalSoldeDebit += $soldeDebit;
            $totalSoldeCredit += $soldeCredit;

            return [
                'compte' => $compte->numero_compte,
                'nom_compte' => $compte->nom_compte,
                'mov_debit_total' => $movDebitTotal,
                'mov_credit_total' => $movCreditTotal,
                'solde_debit' => $soldeDebit,
                'solde_credit' => $soldeCredit,
            ];
        });

        // Charger la vue PDF
        $pdf = FacadePdf::loadView('balance.pdf', [
            'balanceData' => $balanceData,
            'totalMovDebit' => $totalMovDebit,
            'totalMovCredit' => $totalMovCredit,
            'totalSoldeDebit' => $totalSoldeDebit,
            'totalSoldeCredit' => $totalSoldeCredit,
        ]);

        // Télécharger le fichier PDF
        return $pdf->download('balance_comptable.pdf');
    }
}
