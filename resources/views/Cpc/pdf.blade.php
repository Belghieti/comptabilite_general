<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte de Produits et Charges (CPC)</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f4f7f9;
        }
        h2 {
            text-align: center;
            text-transform: uppercase;
            font-size: 24px;
            color: #2c3e50;
            margin-bottom: 40px;
        }
        .section {
            margin-bottom: 20px;
        }
        .block {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            border-left: 4px solid #2980b9;
        }
        .block h3 {
            font-size: 18px;
            color: #2980b9;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table th, table td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #2980b9;
            color: #fff;
            font-size: 14px;
            text-transform: uppercase;
        }
        table td {
            font-size: 14px;
            color: #2c3e50;
        }
        .totaux {
            font-weight: bold;
            font-size: 16px;
            color: #27ae60;
        }
        .block-footer {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h2>Compte de Produits et Charges</h2>

<!-- Bloc Produits et Charges d'Exploitation -->
<div class="block">
    <h3>Produits et Charges d'Exploitation</h3>
    <table>
        <tr>
            <th>Type</th>
            <th>Montant </th>
        </tr>
        <tr>
            <td>Produits d'exploitation</td>
            <td>{{ number_format($produitExploitation, 2, ',', ' ') }}</td>
        </tr>
        <tr>
            <td>Charges d'exploitation</td>
            <td>{{ number_format($chargeExploitation, 2, ',', ' ') }}</td>
        </tr>
    </table>
    <div class="block-footer">
        <p class="totaux">Résultat d'exploitation : {{ number_format($resultatExploitation, 2, ',', ' ') }} </p>
    </div>
</div>

<!-- Bloc Produits et Charges Financières -->
<div class="block">
    <h3>Produits et Charges Financières</h3>
    <table>
        <tr>
            <th>Type</th>
            <th>Montant </th>
        </tr>
        <tr>
            <td>Produits financiers</td>
            <td>{{ number_format($produitFinancier, 2, ',', ' ') }}</td>
        </tr>
        <tr>
            <td>Charges financières</td>
            <td>{{ number_format($chargeFinancier, 2, ',', ' ') }}</td>
        </tr>
    </table>
    <div class="block-footer">
        <p class="totaux">Résultat financier : {{ number_format($resultatFinancier, 2, ',', ' ') }} </p>
    </div>
</div>

<!-- Bloc Résultat Courant -->
<div class="block">
    <h3>Résultat Courant</h3>
    <div class="block-footer">
        <p class="totaux">Résultat courant : {{ number_format($resultatCourant, 2, ',', ' ') }} </p>
    </div>
</div>

<!-- Bloc Produits et Charges Non Courants -->
<br><br>
<div class="block">
    <h3>Produits et Charges Non Courants</h3>
    <table>
        <tr>
            <th>Type</th>
            <th>Montant</th>
        </tr>
        <tr>
            <td>Produits non courants</td>
            <td>{{ number_format($produitNonCourant, 2, ',', ' ') }}</td>
        </tr>
        <tr>
            <td>Charges non courantes</td>
            <td>{{ number_format($chargeNonCourant, 2, ',', ' ') }}</td>
        </tr>
    </table>
    <div class="block-footer">
        <p class="totaux">Résultat non courant : {{ number_format($resultatNonCourant, 2, ',', ' ') }} </p>
    </div>
</div>

<!-- Bloc Résultat Avant Impôt -->
<div class="block">
    <h3>Résultat Avant Impôt</h3>
    <div class="block-footer">
        <p class="totaux">Résultat avant impôt : {{ number_format($resultatAvantImpot, 2, ',', ' ') }} </p>
    </div>
</div>

<!-- Bloc Impôt sur les Résultats -->
<div class="block">
    <h3>Impôt sur les Résultats</h3>
    <div class="block-footer">
        <p class="totaux">Impôt sur les résultats : {{ number_format($impotResultat, 2, ',', ' ') }} </p>
    </div>
</div>

<!-- Bloc Résultat Net -->
<div class="block">
    <h3>Résultat Net</h3>
    <div class="block-footer">
        <p class="totaux">Résultat net : {{ number_format($resultatNet, 2, ',', ' ') }} </p>
    </div>
</div>

</body>
</html>
