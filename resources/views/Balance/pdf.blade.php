<!DOCTYPE html>
<html>
<head>
    <title>Balance Comptable</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Balance Comptable</h2>
    <table>
        <thead>
            <tr>
                <th>Compte</th>
                <th>Nom du Compte</th>
                <th>Mouvement Débit Total</th>
                <th>Mouvement Crédit Total</th>
                <th>Solde Débit</th>
                <th>Solde Crédit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($balanceData as $data)
                <tr>
                    <td>{{ $data['compte'] }}</td>
                    <td>{{ $data['nom_compte'] }}</td>
                    <td>{{ number_format($data['mov_debit_total'], 2) }}</td>
                    <td>{{ number_format($data['mov_credit_total'], 2) }}</td>
                    <td>{{ number_format($data['solde_debit'], 2) }}</td>
                    <td>{{ number_format($data['solde_credit'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Totaux</th>
                <th>{{ number_format($totalMovDebit, 2) }}</th>
                <th>{{ number_format($totalMovCredit, 2) }}</th>
                <th>{{ number_format($totalSoldeDebit, 2) }}</th>
                <th>{{ number_format($totalSoldeCredit, 2) }}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
