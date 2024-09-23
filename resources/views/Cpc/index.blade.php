@extends('layouts.master')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Compte de Produits et Charges (CPC)</h2>

        <div class="card mb-5 shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h3>Produits et Charges d'Exploitation</h3>
                @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first('message') }}
                    <a href="{{ route('entreprises.index') }}">select entreprise</a>  
    
                </div>
                @endif
                <a href="{{ route('cpc.export-pdf') }}" class="btn btn-primary">Exporter en PDF</a>

            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>Type</th>
                            <th>Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Produits d'Exploitation</td>
                            <td>{{ number_format($produitExploitation, 2, ',', ' ') }} </td>
                        </tr>
                        <tr>
                            <td>Charges d'Exploitation</td>
                            <td>{{ number_format($chargeExploitation, 2, ',', ' ') }} </td>
                        </tr>
                        <tr class="font-weight-bold">
                            <td>Résultat d'Exploitation</td>
                            <td>{{ number_format($resultatExploitation, 2, ',', ' ') }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mb-5 shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h3>Produits et Charges Financiers</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>Type</th>
                            <th>Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Produits Financiers</td>
                            <td>{{ number_format($produitFinancier, 2, ',', ' ') }} </td>
                        </tr>
                        <tr>
                            <td>Charges Financières</td>
                            <td>{{ number_format($chargeFinancier, 2, ',', ' ') }} </td>
                        </tr>
                        <tr class="font-weight-bold">
                            <td>Résultat Financier</td>
                            <td>{{ number_format($resultatFinancier, 2, ',', ' ') }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mb-5 shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h3>Résultat Courant</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>Description</th>
                            <th>Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Résultat Courant</td>
                            <td>{{ number_format($resultatCourant, 2, ',', ' ') }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mb-5 shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h3>Produits et Charges Non Courants</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>Type</th>
                            <th>Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Produits Non Courants</td>
                            <td>{{ number_format($produitNonCourant, 2, ',', ' ') }} </td>
                        </tr>
                        <tr>
                            <td>Charges Non Courantes</td>
                            <td>{{ number_format($chargeNonCourant, 2, ',', ' ') }} </td>
                        </tr>
                        <tr class="font-weight-bold">
                            <td>Résultat Non Courant</td>
                            <td>{{ number_format($resultatNonCourant, 2, ',', ' ') }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mb-5 shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h3>Résultat Avant Impôt</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>Description</th>
                            <th>Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Résultat Avant Impôt</td>
                            <td>{{ number_format($resultatAvantImpot, 2, ',', ' ') }} </td>
                        </tr>
                        <tr>
                            <td>Impôt sur les Résultats</td>
                            <td>{{ number_format($impotResultat, 2, ',', ' ') }} </td>
                        </tr>
                        <tr class="font-weight-bold">
                            <td>Résultat Net</td>
                            <td>{{ number_format($resultatNet, 2, ',', ' ') }} </td>
                        </tr>
                        <tr class="font-weight-bold">
                            <td colspan="2">
                                @if ($resultatNet > 0)
                                    <span class="text-success">L'entreprise a un bénéfice</span>
                                @elseif ($resultatNet < 0)
                                    <span class="text-danger">L'entreprise a une perte</span>
                                @else
                                    <span class="text-warning">L'entreprise est à l'équilibre</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
