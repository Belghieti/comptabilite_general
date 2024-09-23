@extends('layouts.master')

@section('content')


<div class="container mt-5">
    <div class="card mb-5 shadow-lg">
     

        <div class="card-header bg-primary text-white text-center">
            <h3>Liste des écritures</h3>
            @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first('message') }}
              <a href="{{ route('entreprises.index') }}">select entreprise</a>  
            </div>
            @endif
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            <!-- Bouton pour ajouter une nouvelle écriture -->
            <div class="mb-3 text-right">
                <a href="{{ route('ecritures.create') }}" class="btn btn-primary">
                    Ajouter une écriture
                </a>
            </div>

            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Date</th>
                        <th>Libellé</th>
                        <th>Compte</th>
                        <th>Débit</th>
                        <th>Crédit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ecritures as $ecriture)
                        <tr>
                            <td>{{ $ecriture->date }}</td>
                            <td>{{ $ecriture->libelle }}</td>
                            <td>{{ $ecriture->planComptable->numero_compte }} - {{ $ecriture->planComptable->nom_compte }}</td>
                            <td>{{ number_format($ecriture->debit, 2) }}</td>
                            <td>{{ number_format($ecriture->credit, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
