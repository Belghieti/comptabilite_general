<?php

namespace App\Http\Controllers;

use App\Models\PlanComptable;
use App\Models\Ecriture;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;


class CPCController extends Controller
{
    public function index()
    {
        // Récupérer l'ID de l'entreprise depuis la session
        $entrepriseId = session('entreprise_id');

        if (!$entrepriseId) {
            return back()->withErrors(['message' => 'ops!!Vous devez choisir une entreprise.pour continuer ..']);
        }

        // Produits d'exploitation (comptes 7111 à 71984)
        $produitExploitation = PlanComptable::whereBetween('numero_compte', [71110000, 71984000])
            ->get()
            ->sum(function ($planComptable) use ($entrepriseId) {
                return Ecriture::where('plan_comptable_id', $planComptable->id)
                    ->where('entreprise_id', $entrepriseId)
                    ->sum('credit');
            });

        // Charges d'exploitation (comptes 6111 à 6198)
        $chargeExploitation = PlanComptable::whereBetween('numero_compte', [61110000, 61980000])
            ->get()
            ->sum(function ($planComptable) use ($entrepriseId) {
                return Ecriture::where('plan_comptable_id', $planComptable->id)
                    ->where('entreprise_id', $entrepriseId)
                    ->sum('debit');
            });

        // Résultat d'exploitation
        $resultatExploitation = $produitExploitation - $chargeExploitation;

        // Produits financiers (comptes 73.. à 7308)
        $produitFinancier = PlanComptable::whereBetween('numero_compte', [73000000, 73080000])
            ->get()
            ->sum(function ($planComptable) use ($entrepriseId) {
                return Ecriture::where('plan_comptable_id', $planComptable->id)
                    ->where('entreprise_id', $entrepriseId)
                    ->sum('credit');
            });

        // Charges financières (comptes 63.. à 6308)
        $chargeFinancier = PlanComptable::whereBetween('numero_compte', [63000000, 63080000])
            ->get()
            ->sum(function ($planComptable) use ($entrepriseId) {
                return Ecriture::where('plan_comptable_id', $planComptable->id)
                    ->where('entreprise_id', $entrepriseId)
                    ->sum('debit');
            });

        // Résultat financier
        $resultatFinancier = $produitFinancier - $chargeFinancier;

        // Résultat courant
        $resultatCourant = $resultatExploitation + $resultatFinancier;

        // Produits non courants (comptes 75.. à 7508)
        $produitNonCourant = PlanComptable::whereBetween('numero_compte', [75000000, 75080000])
            ->get()
            ->sum(function ($planComptable) use ($entrepriseId) {
                return Ecriture::where('plan_comptable_id', $planComptable->id)
                    ->where('entreprise_id', $entrepriseId)
                    ->sum('credit');
            });

        // Charges non courantes (comptes 65.. à 6708)
        $chargeNonCourant = PlanComptable::whereBetween('numero_compte', [65000000, 67080000])
            ->get()
            ->sum(function ($planComptable) use ($entrepriseId) {
                return Ecriture::where('plan_comptable_id', $planComptable->id)
                    ->where('entreprise_id', $entrepriseId)
                    ->sum('debit');
            });

        // Résultat non courant
        $resultatNonCourant = $produitNonCourant - $chargeNonCourant;

        // Résultat avant impôt
        $resultatAvantImpot = $resultatCourant + $resultatNonCourant;

        // Impôt sur les résultats (supposons que TVA soit un taux donné, par exemple 20%)
        $tva = 0.2; // Remplacez par votre taux réel
        $impotResultat = $tva * $resultatAvantImpot;

        // Résultat net
        $resultatNet = $resultatAvantImpot - $impotResultat;

        return view('cpc.index', [
            'produitExploitation' => $produitExploitation,
            'chargeExploitation' => $chargeExploitation,
            'resultatExploitation' => $resultatExploitation,
            'produitFinancier' => $produitFinancier,
            'chargeFinancier' => $chargeFinancier,
            'resultatFinancier' => $resultatFinancier,
            'resultatCourant' => $resultatCourant,
            'produitNonCourant' => $produitNonCourant,
            'chargeNonCourant' => $chargeNonCourant,
            'resultatNonCourant' => $resultatNonCourant,
            'resultatAvantImpot' => $resultatAvantImpot,
            'impotResultat' => $impotResultat,
            'resultatNet' => $resultatNet,
        ]);
    }
    public function exportPdf()
    {
        // Récupérer l'ID de l'entreprise depuis la session
        $entrepriseId = session('entreprise_id');

        if (!$entrepriseId) {
            return back()->withErrors(['message' => 'ops!!Vous devez choisir une entreprise.pour continuer ..']);
        }

        // Reprenez les mêmes calculs de la méthode index()
        // Produits d'exploitation (comptes 7111 à 71984)
        $produitExploitation = PlanComptable::whereBetween('numero_compte', [71110000, 71984000])
            ->get()
            ->sum(function ($planComptable) use ($entrepriseId) {
                return Ecriture::where('plan_comptable_id', $planComptable->id)
                    ->where('entreprise_id', $entrepriseId)
                    ->sum('credit');
            });

        // Charges d'exploitation (comptes 6111 à 6198)
        $chargeExploitation = PlanComptable::whereBetween('numero_compte', [61110000, 61980000])
            ->get()
            ->sum(function ($planComptable) use ($entrepriseId) {
                return Ecriture::where('plan_comptable_id', $planComptable->id)
                    ->where('entreprise_id', $entrepriseId)
                    ->sum('debit');
            });

        // Résultat d'exploitation
        $resultatExploitation = $produitExploitation - $chargeExploitation;

        // Produits financiers (comptes 73.. à 7308)
        $produitFinancier = PlanComptable::whereBetween('numero_compte', [73000000, 73080000])
            ->get()
            ->sum(function ($planComptable) use ($entrepriseId) {
                return Ecriture::where('plan_comptable_id', $planComptable->id)
                    ->where('entreprise_id', $entrepriseId)
                    ->sum('credit');
            });

        // Charges financières (comptes 63.. à 6308)
        $chargeFinancier = PlanComptable::whereBetween('numero_compte', [63000000, 63080000])
            ->get()
            ->sum(function ($planComptable) use ($entrepriseId) {
                return Ecriture::where('plan_comptable_id', $planComptable->id)
                    ->where('entreprise_id', $entrepriseId)
                    ->sum('debit');
            });

        // Résultat financier
        $resultatFinancier = $produitFinancier - $chargeFinancier;

        // Résultat courant
        $resultatCourant = $resultatExploitation + $resultatFinancier;

        // Produits non courants (comptes 75.. à 7508)
        $produitNonCourant = PlanComptable::whereBetween('numero_compte', [75000000, 75080000])
            ->get()
            ->sum(function ($planComptable) use ($entrepriseId) {
                return Ecriture::where('plan_comptable_id', $planComptable->id)
                    ->where('entreprise_id', $entrepriseId)
                    ->sum('credit');
            });

        // Charges non courantes (comptes 65.. à 6708)
        $chargeNonCourant = PlanComptable::whereBetween('numero_compte', [65000000, 67080000])
            ->get()
            ->sum(function ($planComptable) use ($entrepriseId) {
                return Ecriture::where('plan_comptable_id', $planComptable->id)
                    ->where('entreprise_id', $entrepriseId)
                    ->sum('debit');
            });

        // Résultat non courant
        $resultatNonCourant = $produitNonCourant - $chargeNonCourant;

        // Résultat avant impôt
        $resultatAvantImpot = $resultatCourant + $resultatNonCourant;

        // Impôt sur les résultats
        $tva = 0.2; // Taux d'impôt
        $impotResultat = $tva * $resultatAvantImpot;

        // Résultat net
        $resultatNet = $resultatAvantImpot - $impotResultat;

        // Préparer les données pour la vue PDF
        $data = [
            'produitExploitation' => $produitExploitation,
            'chargeExploitation' => $chargeExploitation,
            'resultatExploitation' => $resultatExploitation,
            'produitFinancier' => $produitFinancier,
            'chargeFinancier' => $chargeFinancier,
            'resultatFinancier' => $resultatFinancier,
            'resultatCourant' => $resultatCourant,
            'produitNonCourant' => $produitNonCourant,
            'chargeNonCourant' => $chargeNonCourant,
            'resultatNonCourant' => $resultatNonCourant,
            'resultatAvantImpot' => $resultatAvantImpot,
            'impotResultat' => $impotResultat,
            'resultatNet' => $resultatNet,
        ];

        // Générer le PDF à partir de la vue
        $pdf = FacadePdf::loadView('cpc.pdf', $data);

        // Télécharger le PDF
        return $pdf->download('cpc.pdf');
    }
}
