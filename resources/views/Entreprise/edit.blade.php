@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h3>Modifier l'entreprise</h3>
                </div>
                <div class="card-body">
                    <!-- Afficher les erreurs s'il y en a -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('entreprises.update', $entreprise->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom de l'entreprise</label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $entreprise->nom) }}" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date_debut_exercise" class="form-label">Date de début d'exercice</label>
                            <input type="date" class="form-control @error('date_debut_exercise') is-invalid @enderror" id="date_debut_exercise" name="date_debut_exercise" value="{{ old('date_debut_exercise', $entreprise->date_debut_exercise) }}" required>
                            @error('date_debut_exercise')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date_fin_exercise" class="form-label">Date de fin d'exercice</label>
                            <input type="date" class="form-control @error('date_fin_exercise') is-invalid @enderror" id="date_fin_exercise" name="date_fin_exercise" value="{{ old('date_fin_exercise', $entreprise->date_fin_exercise) }}" required>
                            @error('date_fin_exercise')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success px-4 py-2">
                                <i class="fas fa-save"></i> Mettre à jour
                            </button>
                            <a href="{{ route('entreprises.index') }}" class="btn btn-secondary px-4 py-2">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
