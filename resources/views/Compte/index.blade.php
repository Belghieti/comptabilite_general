@extends('layouts.master')

@section('title', 'Liste des Comptes')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h2><i class="fas fa-list-alt"></i> Sélectionner des Comptes</h2>
            @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first('message') }}
                <a href="{{ route('entreprises.index') }}">select entreprise</a>  

            </div>
            @endif
           
            
            
        </div>
        <div class="card-body">
            <form action="{{ route('comptes.show') }}" method="GET">
                <div class="form-group">
                    <label for="compte_id">Sélectionner le premier compte :</label>
                    <select name="compte_id" id="compte_id" class="form-control" required>
                        <option value="" disabled selected>Choisir un compte...</option>
                        @foreach ($planComptables as $planComptable)
                            <option value="{{ $planComptable->id }}">{{ $planComptable->numero_compte }} : {{ $planComptable->nom_compte }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mt-4">
                    <label for="compte_id1">Sélectionner le deuxième compte :</label>
                    <select name="compte_id1" id="compte_id1" class="form-control" required>
                        <option value="" disabled selected>Choisir un compte...</option>
                        @foreach ($planComptables as $planComptable)
                            <option value="{{ $planComptable->id }}">{{ $planComptable->numero_compte }} : {{ $planComptable->nom_compte }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success btn-block mt-4">
                    <i class="fas fa-eye"></i> Voir l'état des comptes
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
