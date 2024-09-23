@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Saisir l'écriture associée</h4>
                </div>
                <div class="card-body">

                    {{-- Affichage des erreurs de validation --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('ecritures.storeAssocie', ['reference' => $reference]) }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="date" class="form-label">Date :</label>
                            <input type="date" name="date" id="date" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="libelle" class="form-label">Libellé :</label>
                            <input type="text" name="libelle" id="libelle" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="compte_id" class="form-label">Compte associé :</label>
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
