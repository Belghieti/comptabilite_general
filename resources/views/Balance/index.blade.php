@extends('layouts.master')

@section('title', 'Balance Comptable')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h3>Balance Comptable</h3>
                @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first('message') }}
                <a href="{{ route('entreprises.index') }}">select entreprise</a>  

            </div>

            @endif
            <a href="{{ route('balance.exportPdf') }}" class="btn btn-primary">Exporter en PDF</a>

            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Compte</th>
                            <th>Nom du Compte</th>
                            <th>Mov. Débit Total</th>
                            <th>Mov. Crédit Total</th>
                            <th>Solde Débit</th>
                            <th>Solde Crédit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($balanceData as $data)
                            <!-- Vérifier si Mov Débit Total et Mov Crédit Total ne sont pas égaux à zéro -->
                            @if($data['mov_debit_total'] != 0 || $data['mov_credit_total'] != 0)
                                <tr>
                                    <td>{{ $data['compte'] }}</td>
                                    <td>{{ $data['nom_compte'] }}</td>
                                    <td>{{ number_format($data['mov_debit_total'], 2) }}</td>
                                    <td>{{ number_format($data['mov_credit_total'], 2) }}</td>
                                    @if($data['solde_debit'] > 0)
                                        <td>{{ number_format($data['solde_debit'], 2) }}</td>
                                        <td></td>
                                    @else
                                        <td></td>
                                        <td>{{ number_format($data['solde_credit'], 2) }}</td>
                                    @endif
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><strong>Total</strong></td>
                            <td><strong>{{ number_format($totalMovDebit, 2) }}</strong></td>
                            <td><strong>{{ number_format($totalMovCredit, 2) }}</strong></td>
                            <td><strong>{{ number_format($totalSoldeDebit, 2) }}</strong></td>
                            <td><strong>{{ number_format($totalSoldeCredit, 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
