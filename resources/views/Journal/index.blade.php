@extends('layouts.master')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h3>Sélectionnez un compte pour voir le journal</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('journaux.show') }}" method="GET">
                    <div class="form-group">
                        <label for="compte_id">Sélectionner un compte :</label>
                        <select name="compte_id" id="compte_id" class="form-control" required>
                            <option value="" disabled selected>-- Choisir un compte --</option>
                            @foreach ($planComptables as $planComptable)
                                <option value="{{ $planComptable->id }}">
                                    {{ $planComptable->numero_compte }} - {{ $planComptable->nom_compte }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Voir le Journal</button>
                </form>
            </div>
        </div>
    </div>
@endsection
