@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white text-center">
            <h2 class="mb-0">Liste des Entreprises</h2>
        </div>
        <div class="card-body">

            <!-- Afficher les messages de succès -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Afficher les erreurs s'il y en a -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Bouton de création d'une nouvelle entreprise -->
            <div class="d-flex justify-content-between mb-4">
                <a class="btn btn-primary rounded-pill py-3 px-5" href="{{ route('entreprises.create') }}">
                    <i class="fas fa-plus-circle"></i> Créer une Entreprise
                </a>
            </div>

            <!-- Table des entreprises -->
            <table class="table table-hover table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Date de Début d'Exercice</th>
                        <th>Date de Fin d'Exercice</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($entreprises as $entreprise)
                        <tr>
                            <td>{{ $entreprise->id }}</td>
                            <td>{{ $entreprise->nom }}</td>
                            <td>{{ $entreprise->date_debut_exercise }}</td>
                            <td>{{ $entreprise->date_fin_exercise }}</td>
                            <td class="d-flex justify-content-center gap-2">
                                <!-- Bouton Voir -->
                                <a href="{{ route('entreprises.show', $entreprise->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Voir
                                </a>

                                <!-- Bouton Modifier -->
                                <a href="{{ route('entreprises.edit', $entreprise->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>

                                <!-- Formulaire Supprimer -->
                                <form action="{{ route('entreprises.destroy', $entreprise->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i> Supprimer
                                    </button>
                                </form>

                                <!-- Formulaire Sélectionner -->
                                <form action="{{ route('entreprises.select', $entreprise->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-check-circle"></i> Sélectionner
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection
