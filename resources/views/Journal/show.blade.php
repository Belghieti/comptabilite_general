@extends('layouts.master')

@section('content')
    <div class="container mt-5">
        <div class="card mb-5 shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h3>Journal du compte : {{ $compte->numero_compte }} - {{ $compte->nom_compte }}</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th>Date</th>
                            <th>Compte associé</th>
                            <th>Débit</th>
                            <th>Crédit</th>
                            {{-- <th>Solde</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $soldeCompte = 0; 
                        @endphp
                        @foreach ($ecrituresAssociees as $ecriture)
                            @php 
                                $soldeCompte += ($ecriture->debit - $ecriture->credit); 
                            @endphp
                            <tr>
                                <td>{{ $ecriture->date }}</td>
                                <td>
                                    @if($ecriture->compteAssocie)
                                        {{ $ecriture->compteAssocie->numero_compte }} - {{ $ecriture->compteAssocie->nom_compte }}
                                    @else
                                        Aucun compte associé
                                    @endif
                                </td>
                                
                                <td>{{ number_format($ecriture->debit, 2, ',', ' ') }}</td>
                                <td>{{ number_format($ecriture->credit, 2, ',', ' ') }}</td>
                                {{-- <td>{{ number_format($soldeCompte, 2, ',', ' ') }}</td> --}}
                            </tr>
                        @endforeach
                        <tr class="font-weight-bold">
                            <td colspan="2"><strong>Total</strong></td>
                            <td>{{ number_format($totalDebit, 2, ',', ' ') }}</td>
                            <td>{{ number_format($totalCredit, 2, ',', ' ') }}</td>
                            {{-- <td>{{ $soldeCompte > 0 ? 'Débiteur' : 'Créditeur' }}: {{ number_format(abs($soldeCompte), 2, ',', ' ') }}</td> --}}
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
