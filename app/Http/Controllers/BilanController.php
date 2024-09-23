<?php

namespace App\Http\Controllers;

use App\Models\PlanComptable;
use App\Models\Ecriture;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Dompdf\Adapter\PDFLib;
use Illuminate\Http\Request;
use PDF;

class BilanController extends Controller
{
    public function index()
    {
        // Récupérer l'ID de l'entreprise sélectionnée dans la session
        $entrepriseId = session('entreprise_id');
        if (!$entrepriseId) {
            return back()->withErrors(['message' => 'ops!!Vous devez choisir une entreprise.pour continuer ..']);
        }
        // Récupérer les comptes par classe en filtrant par entreprise
        $actifClasse2 = PlanComptable::where('numero_compte', 'like', '2%')->get(); // Classe 2 : Immobilisations
        $actifClasse3 = PlanComptable::where('numero_compte', 'like', '3%')->get(); // Classe 3 : Stocks

        $passifClasse1 = PlanComptable::where('numero_compte', 'like', '1%')->get(); // Classe 1 : Capitaux
        $passifClasse4 = PlanComptable::where('numero_compte', 'like', '4%')->get(); // Classe 4 : Tiers
        $passifClasse5 = PlanComptable::where('numero_compte', 'like', '5%')->get(); // Classe 5 : Financiers

        // Calculer les soldes des comptes à partir des écritures en filtrant par entreprise
        $totalActif = 0;
        $totalPassif = 0;

        // Filtrer et calculer le solde des comptes pour l'actif
        $actifClasse2 = $actifClasse2->filter(function ($compte) use (&$totalActif, $entrepriseId) {
            $solde = $this->calculerSoldeCompte($compte->id, $entrepriseId);
            if ($solde != 0) {
                $compte->solde = $solde;
                $totalActif += $solde;
                return true; // Garde le compte si le solde est différent de 0
            }
            return false; // Sinon, on ignore ce compte
        });

        $actifClasse3 = $actifClasse3->filter(function ($compte) use (&$totalActif, $entrepriseId) {
            $solde = $this->calculerSoldeCompte($compte->id, $entrepriseId);
            if ($solde != 0) {
                $compte->solde = $solde;
                $totalActif += $solde;
                return true;
            }
            return false;
        });

        // Filtrer et calculer le solde des comptes pour le passif
        $passifClasse1 = $passifClasse1->filter(function ($compte) use (&$totalPassif, $entrepriseId) {
            $solde = $this->calculerSoldeCompte($compte->id, $entrepriseId);
            if ($solde != 0) {
                $compte->solde = $solde;
                $totalPassif += $solde;
                return true;
            }
            return false;
        });

        $passifClasse4 = $passifClasse4->filter(function ($compte) use (&$totalPassif, $entrepriseId) {
            $solde = $this->calculerSoldeCompte($compte->id, $entrepriseId);
            if ($solde != 0) {
                $compte->solde = $solde;
                $totalPassif += $solde;
                return true;
            }
            return false;
        });

        $passifClasse5 = $passifClasse5->filter(function ($compte) use (&$totalPassif, $entrepriseId) {
            $solde = $this->calculerSoldeCompte($compte->id, $entrepriseId);
            if ($solde != 0) {
                $compte->solde = $solde;
                $totalPassif += $solde;
                return true;
            }
            return false;
        });

        // Retourner la vue avec les comptes filtrés et les totaux
        return view('bilan.index', compact('actifClasse2', 'actifClasse3', 'passifClasse1', 'passifClasse4', 'passifClasse5', 'totalActif', 'totalPassif'));
    }
    public function exportPdf()
    {
        // Récupérer l'ID de l'entreprise sélectionnée dans la session
        $entrepriseId = session('entreprise_id');
        if (!$entrepriseId) {
            return back()->withErrors(['message' => 'ops!!Vous devez choisir une entreprise.pour continuer ..']);
        }
        // Récupérer les comptes par classe en filtrant par entreprise
        $actifClasse2 = PlanComptable::where('numero_compte', 'like', '2%')->get();
        $actifClasse3 = PlanComptable::where('numero_compte', 'like', '3%')->get();
        $passifClasse1 = PlanComptable::where('numero_compte', 'like', '1%')->get();
        $passifClasse4 = PlanComptable::where('numero_compte', 'like', '4%')->get();
        $passifClasse5 = PlanComptable::where('numero_compte', 'like', '5%')->get();

        // Calcul des soldes pour l'actif et le passif
        $totalActif = 0;
        $totalPassif = 0;

        // Calculer les soldes pour l'actif
        $actifClasse2 = $actifClasse2->filter(function ($compte) use (&$totalActif, $entrepriseId) {
            $solde = $this->calculerSoldeCompte($compte->id, $entrepriseId);
            if ($solde != 0) {
                $compte->solde = $solde;
                $totalActif += $solde;
                return true;
            }
            return false;
        });

        $actifClasse3 = $actifClasse3->filter(function ($compte) use (&$totalActif, $entrepriseId) {
            $solde = $this->calculerSoldeCompte($compte->id, $entrepriseId);
            if ($solde != 0) {
                $compte->solde = $solde;
                $totalActif += $solde;
                return true;
            }
            return false;
        });

        // Calculer les soldes pour le passif
        $passifClasse1 = $passifClasse1->filter(function ($compte) use (&$totalPassif, $entrepriseId) {
            $solde = $this->calculerSoldeCompte($compte->id, $entrepriseId);
            if ($solde != 0) {
                $compte->solde = $solde;
                $totalPassif += $solde;
                return true;
            }
            return false;
        });

        $passifClasse4 = $passifClasse4->filter(function ($compte) use (&$totalPassif, $entrepriseId) {
            $solde = $this->calculerSoldeCompte($compte->id, $entrepriseId);
            if ($solde != 0) {
                $compte->solde = $solde;
                $totalPassif += $solde;
                return true;
            }
            return false;
        });

        $passifClasse5 = $passifClasse5->filter(function ($compte) use (&$totalPassif, $entrepriseId) {
            $solde = $this->calculerSoldeCompte($compte->id, $entrepriseId);
            if ($solde != 0) {
                $compte->solde = $solde;
                $totalPassif += $solde;
                return true;
            }
            return false;
        });

        // Générer le PDF en utilisant les données récupérées
        $pdf = FacadePdf::loadView('bilan.pdf', [
            'actifClasse2' => $actifClasse2,
            'actifClasse3' => $actifClasse3,
            'passifClasse1' => $passifClasse1,
            'passifClasse4' => $passifClasse4,
            'passifClasse5' => $passifClasse5,
            'totalActif' => $totalActif,
            'totalPassif' => $totalPassif,
        ]);

        // Retourner le PDF pour téléchargement
        return $pdf->download('bilan.pdf');
    }

    private function calculerSoldeCompte($compteId, $entrepriseId)
    {
        // Récupérer toutes les écritures liées au compte et à l'entreprise
        $ecritures = Ecriture::where('plan_comptable_id', $compteId)
            ->where('entreprise_id', $entrepriseId)
            ->get();

        // Calculer le solde en fonction des débits et crédits
        $solde = 0;
        foreach ($ecritures as $ecriture) {
            $solde += ($ecriture->debit - $ecriture->credit);
        }

        return $solde;
    }
}
