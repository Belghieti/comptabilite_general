@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h2>{{ $entreprise->nom }}</h2>
        </div>
        <div class="card-body">
            <h5 class="card-title text-center">Informations sur l'Entreprise</h5>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <p class="card-text mb-4">
                        <strong>Propriétaire :</strong> {{ $entreprise->user->name }}<br> <!-- Affichage du nom de l'utilisateur -->
                        <strong>Date de début d'exercice :</strong> {{ $entreprise->date_debut_exercise }}<br>
                        <strong>Date de fin d'exercice :</strong> {{ $entreprise->date_fin_exercise }}
                    </p>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-4 gap-3">
                <a href="{{ route('entreprises.index') }}" class="btn btn-secondary px-4 py-2">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                </a>
                <a href="{{ route('entreprises.edit', $entreprise->id) }}" class="btn btn-warning px-4 py-2">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <form action="{{ route('entreprises.destroy', $entreprise->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-4 py-2">
                        <i class="fas fa-trash-alt"></i> Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
