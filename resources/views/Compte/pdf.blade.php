<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border: 1px solid black;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .totaux {
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>Détails des Comptes Sélectionnés</h2>

@foreach ($comptes as $compte)
    <h3>Compte : {{ $compte->numero_compte }} - {{ $compte->nom_compte }}</h3>
    <table>
        <thead>
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
                    <td>{{ $ecriture->debit != 0 ? number_format($ecriture->debit, 2, ',', ' ') : '-' }}</td>
                    <td>{{ $ecriture->credit != 0 ? number_format($ecriture->credit, 2, ',', ' ') : '-' }}</td>
                    <td>{{ number_format($soldeCompte, 2, ',', ' ') }}</td>
                </tr>
            @endforeach
            @if($ecrituresCompte->count() > 0)
                <tr class="totaux">
                    <td colspan="4"><strong>Solde pour le compte {{ $compte->numero_compte }}</strong></td>
                    <td>{{ $soldeCompte > 0 ? 'Débiteur' : ($soldeCompte < 0 ? 'Créditeur' : 'Nul') }}: {{ number_format(abs($soldeCompte), 2, ',', ' ') }}</td>
                </tr>
            @else
                <tr>
                    <td colspan="5">Aucune écriture trouvée pour ce compte.</td>
                </tr>
            @endif
        </tbody>
    </table>
@endforeach

<p class="totaux">Solde global : {{ number_format($soldeGlobal, 2, ',', ' ') }} </p>

</body>
</html>
