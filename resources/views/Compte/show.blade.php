@extends('layouts.master')

@section('content')
    <div class="container mt-5">
        @foreach ($comptes as $compte)
            <div class="card mb-5 shadow-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h3>Compte : {{ $compte->numero_compte }} - {{ $compte->nom_compte }}</h3>
                    <a href="{{ route('comptes.exportPDF', ['compte_id' => $compteId, 'compte_id1' => $compteId1]) }}" class="btn btn-primary">
                        Exporter en PDF
                    </a>
                    
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-hover text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th>Date</th>
                                <th>Libellé</th>
                                <th>Débit</th>
                                <th>Crédit</th>
                                <th>Solde</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $soldeCompte = 0; 
                                $ecrituresCompte = $ecritures->where('plan_comptable_id', $compte->id);
                            @endphp
                            @foreach ($ecrituresCompte as $ecriture)
                                @php 
                                    $soldeCompte += ($ecriture->debit - $ecriture->credit); 
                                @endphp
                                <tr>
                                    <td>{{ $ecriture->date }}</td>
                                    <td>{{ $ecriture->libelle }}</td>
                                    <td>{{ $ecriture->debit != 0 ? number_format($ecriture->debit, 2) : '-' }}</td>
                                    <td>{{ $ecriture->credit != 0 ? number_format($ecriture->credit, 2) : '-' }}</td>
                                    <td>{{ number_format($soldeCompte, 2) }}</td>
                                </tr>
                            @endforeach
                            @if($ecrituresCompte->count() > 0)
                                <tr class="font-weight-bold">
                                    <td colspan="4"><strong>Solde pour le compte {{ $compte->numero_compte }}</strong></td>
                                    <td>{{ $soldeCompte > 0 ? 'Débiteur' : ($soldeCompte < 0 ? 'Créditeur' : 'Nul') }}: {{ number_format(abs($soldeCompte), 2) }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="5">Aucune écriture trouvée pour ce compte.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
@endsection
