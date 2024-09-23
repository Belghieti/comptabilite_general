@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Ajouter une nouvelle écriture</h4>
                    @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first('message') }}
                <a href="{{ route('entreprises.index') }}">select entreprise</a>  

            </div>
            @endif
                </div>
                <div class="card-body">
                    <form action="{{ route('ecritures.store') }}" method="POST">

                        @csrf
                        <!-- Champ caché pour l'ID de l'entreprise -->
                        <input type="hidden" name="entreprise_id" value="{{ session('entreprise_id') }}">

                        <div class="form-group mb-3">
                            <label for="date" class="form-label">Date :</label>
                            <input type="date" name="date" id="date" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="libelle" class="form-label">Libellé :</label>
                            <input type="text" name="libelle" id="libelle" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="compte_id" class="form-label">Compte :</label>
                            <select name="compte_id" id="compte_id" class="form-select" required>
                                <option value="" disabled selected>Choisir un compte</option>
                                @foreach($comptes as $compte)
                                    <option value="{{ $compte->id }}">{{ $compte->numero_compte }} - {{ $compte->nom_compte }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="montant" class="form-label">Montant :</label>
                            <input type="number" name="montant" id="montant" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="type" class="form-label">Type :</label>
                            <select name="type" id="type" class="form-select" required>
                                <option value="debit">Débit</option>
                                <option value="credit">Crédit</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="reference" class="form-label">Référence :</label>
                            <input type="text" name="reference" id="reference" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="Associe_autre_compt" class="form-label">Associer un autre compte :</label>
                            <select name="Associe_autre_compt" id="Associe_autre_compt" class="form-select" required>
                                <option value="Oui">Oui</option>
                                <option value="Non">Non</option>
                            </select>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-success">Enregistrer</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
