<?php

namespace App\Http\Controllers;

use App\Models\Ecriture;
use App\Models\PlanComptable;
use Illuminate\Http\Request;

class EcritureController extends Controller
{
    // Afficher toutes les écritures pour l'entreprise sélectionnée
    public function index()
    {
        $entreprise_id = session('entreprise_id'); // Récupérer l'entreprise sélectionnée dans la session

        // Vérifier si l'entreprise est bien définie dans la session
        if (!$entreprise_id) {
            return back()->withErrors(['message' => 'ops!!Vous devez choisir une entreprise.pour continuer ..']);
        }
        

        $ecritures = Ecriture::with('planComptable')
            ->where('entreprise_id', $entreprise_id)
            ->get();

        return view('Ecriture.index', compact('ecritures'));
    }

    // Afficher le formulaire pour saisir une nouvelle écriture
    public function create()
    {
        $comptes = PlanComptable::all();
        return view('Ecriture.create', compact('comptes'));
    }

    // Enregistrer une nouvelle écriture
    public function store(Request $request)
    {
        $entreprise_id = session('entreprise_id'); // Récupérer l'entreprise sélectionnée dans la session

        // Vérifier si l'entreprise est bien définie dans la session
        if (!$entreprise_id) {
            return back()->withErrors(['message' => 'ops!!Vous devez choisir une entreprise.pour continuer ..']);
        }
        

        // Valider les champs du formulaire
        $request->validate([
            'date' => 'required|date',
            'libelle' => 'required|string',
            'compte_id' => 'required|exists:plan_comptable,id',
            'montant' => 'required|numeric|min:0',
            'type' => 'required|in:debit,credit',
            'reference' => 'required|string',
            'Associe_autre_compt' => 'required|in:Oui,Non'
        ]);

        // Créer la première écriture pour l'entreprise sélectionnée
        $ecriture = Ecriture::create([
            'plan_comptable_id' => $request->input('compte_id'),
            'entreprise_id' => $entreprise_id,
            'date' => $request->input('date'),
            'libelle' => $request->input('libelle'),
            'debit' => $request->input('type') === 'debit' ? $request->input('montant') : 0,
            'credit' => $request->input('type') === 'credit' ? $request->input('montant') : 0,
            'reference' => $request->input('reference')
        ]);

        // Rediriger l'utilisateur pour qu'il saisisse la deuxième écriture (compte associé)
        if ($request->input('Associe_autre_compt') === 'Oui') {
            return redirect()->route('ecritures.createAssocie', ['reference' => $ecriture->reference]);
        } else {
            return redirect()->route('ecritures.index')->with('success', 'Les écritures sont équilibrées et enregistrées.');
        }
    }

    // Afficher le formulaire pour saisir l'écriture associée
    public function createAssocie($reference)
    {
        $comptes = PlanComptable::all();
        return view('Ecriture.createAssocie', compact('comptes', 'reference'));
    }

    // Enregistrer l'écriture associée (pour équilibrer)
    public function storeAssocie(Request $request, $reference)
    {
        $entreprise_id = session('entreprise_id'); // Récupérer l'entreprise sélectionnée dans la session

        // Vérifier si l'entreprise est bien définie dans la session
        if (!$entreprise_id) {
            return back()->withErrors(['message' => 'ops!!Vous devez choisir une entreprise.pour continuer ..']);
        }
        
        // Valider les champs du formulaire
        $request->validate([
            'date' => 'required|date',
            'libelle' => 'required|string',
            'compte_id' => 'required|exists:plan_comptable,id',
            'montant' => 'required|numeric|min:0',
            'type' => 'required|in:debit,credit',
            'Associe_autre_compt' => 'required|in:Oui,Non'
        ]);

        // Enregistrer l'écriture associée pour l'entreprise sélectionnée
        Ecriture::create([
            'plan_comptable_id' => $request->input('compte_id'),
            'entreprise_id' => $entreprise_id,
            'date' => $request->input('date'),
            'libelle' => $request->input('libelle'),
            'debit' => $request->input('type') === 'debit' ? $request->input('montant') : 0,
            'credit' => $request->input('type') === 'credit' ? $request->input('montant') : 0,
            'reference' => $reference
        ]);

        // Vérifier si l'utilisateur souhaite associer un autre compte
        if ($request->input('Associe_autre_compt') === 'Oui') {
            return redirect()->route('ecritures.createAssocie', ['reference' => $reference]);
        }

        // Si non, redirection vers l'index des écritures avec un message de succès
        return redirect()->route('ecritures.index')->with('success', 'Les écritures sont équilibrées et enregistrées.');
    }
}
