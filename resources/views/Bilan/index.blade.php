@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <div class="card mb-5 shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h3><i class="fas fa-balance-scale"></i> Bilan Comptable</h3>
            @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first('message') }}
                <a href="{{ route('entreprises.index') }}">select entreprise</a>  

            </div>
            @endif
            <a href="{{ route('bilan.pdf') }}" class="btn btn-primary">Exporter en PDF</a>

        </div>
        <div class="card-body">
            <div class="row">
                <!-- Actif -->
                <div class="col-md-6">
                    <h4 class="text-primary"><i class="fas fa-briefcase"></i> Actif</h4>
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Numéro de Compte</th>
                                <th>Nom du Compte</th>
                                <th>Solde</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Classe 2 : Immobilisations -->
                            <tr class="bg-light">
                                <td colspan="3" class="font-weight-bold">Classe 2 : Immobilisations</td>
                            </tr>
                            @foreach ($actifClasse2 as $compte)
                                @if($compte->solde != 0)
                                    <tr>
                                        <td>{{ $compte->numero_compte }}</td>
                                        <td>{{ $compte->nom_compte }}</td>
                                        <td>{{ number_format($compte->solde, 2) }}</td>
                                    </tr>
                                @endif
                            @endforeach

                            <!-- Classe 3 : Stocks -->
                            <tr class="bg-light">
                                <td colspan="3" class="font-weight-bold">Classe 3 : Stocks</td>
                            </tr>
                            @foreach ($actifClasse3 as $compte)
                                @if($compte->solde != 0)
                                    <tr>
                                        <td>{{ $compte->numero_compte }}</td>
                                        <td>{{ $compte->nom_compte }}</td>
                                        <td>{{ number_format($compte->solde, 2) }}</td>
                                    </tr>
                                @endif
                            @endforeach
                            <!-- Classe 5 : Financiers -->
                            <tr class="bg-light">
                                <td colspan="3" class="font-weight-bold">Classe 5 : Tresorie</td>
                            </tr>
                            @foreach ($passifClasse5 as $compte)
                                @if($compte->solde != 0)
                                    <tr>
                                        <td>{{ $compte->numero_compte }}</td>
                                        <td>{{ $compte->nom_compte }}</td>
                                        <td>{{ number_format($compte->solde, 2) }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Passif -->
                <div class="col-md-6">
                    <h4 class="text-danger"><i class="fas fa-dollar-sign"></i> Passif</h4>
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Numéro de Compte</th>
                                <th>Nom du Compte</th>
                                <th>Solde</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Classe 1 : Capitaux -->
                            <tr class="bg-light">
                                <td colspan="3" class="font-weight-bold">Classe 1 : Capitaux</td>
                            </tr>
                            @foreach ($passifClasse1 as $compte)
                                @if($compte->solde != 0)
                                    <tr>
                                        <td>{{ $compte->numero_compte }}</td>
                                        <td>{{ $compte->nom_compte }}</td>
                                        <td>{{ number_format($compte->solde, 2) }}</td>
                                    </tr>
                                @endif
                            @endforeach

                            <!-- Classe 4 : Tiers -->
                            <tr class="bg-light">
                                <td colspan="3" class="font-weight-bold">Classe 4 : Pssif cirulant</td>
                            </tr>
                            @foreach ($passifClasse4 as $compte)
                                @if($compte->solde != 0)
                                    <tr>
                                        <td>{{ $compte->numero_compte }}</td>
                                        <td>{{ $compte->nom_compte }}</td>
                                        <td>{{ number_format($compte->solde, 2) }}</td>
                                    </tr>
                                @endif
                            @endforeach

                            
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Total Actif</h4>
                        <p>{{ number_format($totalActif, 2) }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading">Total Passif</h4>
                        <p>{{ number_format(-1*$totalPassif, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
