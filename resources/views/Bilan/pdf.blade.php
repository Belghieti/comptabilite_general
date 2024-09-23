<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bilan Comptable</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .section-header {
            background-color: #d9d9d9;
            font-weight: bold;
            text-align: left;
            padding-left: 10px;
        }
        .totaux {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h1 style="text-align: center;">Bilan Comptable</h1>

    <table>
        <thead>
            <tr>
                <th>Numéro de Compte</th>
                <th>Nom du Compte</th>
                <th>Solde</th>
            </tr>
        </thead>
        <tbody>
            <!-- Actif Section -->
            <tr>
                <td colspan="3" class="section-header">Actif</td>
            </tr>
            @foreach ($actifClasse2 as $compte)
                <tr>
                    <td>{{ $compte->numero_compte }}</td>
                    <td>{{ $compte->nom_compte }}</td>
                    <td>{{ number_format($compte->solde, 2) }} €</td>
                </tr>
            @endforeach
            @foreach ($actifClasse3 as $compte)
                <tr>
                    <td>{{ $compte->numero_compte }}</td>
                    <td>{{ $compte->nom_compte }}</td>
                    <td>{{ number_format($compte->solde, 2) }} €</td>
                </tr>
            @endforeach
            
            <!-- Passif Section -->
            <tr>
                <td colspan="3" class="section-header">Passif</td>
            </tr>
            @foreach ($passifClasse1 as $compte)
                <tr>
                    <td>{{ $compte->numero_compte }}</td>
                    <td>{{ $compte->nom_compte }}</td>
                    <td>{{ number_format($compte->solde, 2) }} €</td>
                </tr>
            @endforeach
            @foreach ($passifClasse4 as $compte)
                <tr>
                    <td>{{ $compte->numero_compte }}</td>
                    <td>{{ $compte->nom_compte }}</td>
                    <td>{{ number_format($compte->solde, 2) }} €</td>
                </tr>
            @endforeach
            @foreach ($passifClasse5 as $compte)
                <tr>
                    <td>{{ $compte->numero_compte }}</td>
                    <td>{{ $compte->nom_compte }}</td>
                    <td>{{ number_format($compte->solde, 2) }} €</td>
                </tr>
            @endforeach
            
            <!-- Totaux -->
            <tr>
                <td colspan="2" class="totaux">Total Actif</td>
                <td class="totaux">{{ number_format($totalActif, 2) }} </td>
            </tr>
            <tr>
                <td colspan="2" class="totaux">Total Passif</td>
                <td class="totaux">{{ number_format($totalPassif, 2) }} </td>
            </tr>
        </tbody>
    </table>

</body>
</html>
