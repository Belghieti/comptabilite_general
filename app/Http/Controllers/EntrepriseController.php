<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entreprise;
use App\Models\User; 
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class EntrepriseController extends Controller
{
    // Afficher la liste des entreprises de l'utilisateur connecté
    public function index()
    {
        // Récupère toutes les entreprises de l'utilisateur connecté
        $entreprises = Auth::user()->entreprises;

        return view('Entreprise.index', compact('entreprises'));
    }

    // Afficher le formulaire de création d'une nouvelle entreprise
    public function create()
    {
        return view('Entreprise.create');
    }

    // Enregistrer une nouvelle entreprise
    public function store(Request $request): RedirectResponse
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'date_debut_exercise' => 'required|date',
            'date_fin_exercise' => 'required|date|after:date_debut_exercise',
        ]);

        // Création de l'entreprise pour l'utilisateur connecté
        $user = Auth::user(); // Récupération de l'utilisateur connecté
        if ($user instanceof User) {
            // Créer l'entreprise et l'associer à l'utilisateur
            $user->entreprises()->create($validatedData);
        } else {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour créer une entreprise.');
        }

        // Redirection avec un message de succès
        return redirect()->route('entreprises.index')->with('success', 'Entreprise créée avec succès.');
    }

    // Afficher une entreprise spécifique
    public function show($id)
    {
        // Récupère l'entreprise par son ID et vérifie si elle appartient à l'utilisateur connecté
        $entreprise = Entreprise::findOrFail($id);

        if ($entreprise->user_id !== Auth::id()) {
            return redirect()->route('entreprises.index')->withErrors('Accès non autorisé.');
        }

        return view('Entreprise.show', compact('entreprise'));
    }

    // Afficher le formulaire d'édition d'une entreprise
    public function edit(Entreprise $entreprise)
    {
        // Vérifier que l'entreprise appartient à l'utilisateur connecté
        if ($entreprise->user_id !== Auth::id()) {
            return redirect()->route('entreprises.index')->withErrors('Accès non autorisé.');
        }

        return view('Entreprise.edit', compact('entreprise'));
    }

    // Mettre à jour les informations d'une entreprise
    public function update(Request $request, Entreprise $entreprise): RedirectResponse
    {
        // Vérifier que l'entreprise appartient à l'utilisateur connecté
        if ($entreprise->user_id !== Auth::id()) {
            return redirect()->route('entreprises.index')->withErrors('Accès non autorisé.');
        }

        // Validation des données entrantes
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'date_debut_exercise' => 'required|date',
            'date_fin_exercise' => 'required|date|after:date_debut_exercise',
        ]);

        // Mise à jour de l'entreprise
        $entreprise->update($validatedData);

        // Redirection avec un message de succès
        return redirect()->route('entreprises.index')->with('success', 'Entreprise mise à jour avec succès.');
    }

    // Supprimer une entreprise
    public function destroy(Entreprise $entreprise): RedirectResponse
    {
        // Vérifier que l'entreprise appartient à l'utilisateur connecté
        if ($entreprise->user_id !== Auth::id()) {
            return redirect()->route('entreprises.index')->withErrors('Accès non autorisé.');
        }

        // Suppression de l'entreprise
        $entreprise->delete();

        // Redirection avec un message de succès
        return redirect()->route('entreprises.index')->with('success', 'Entreprise supprimée avec succès.');
    }
    public function select(Request $request, $id)
    {
        // Stocker l'ID de l'entreprise sélectionnée dans la session
        $request->session()->put('entreprise_id', $id);

        // Rediriger avec un message de succès
        return redirect()->route('ecritures.index')->with('success', 'Entreprise sélectionnée.');
    }
}
