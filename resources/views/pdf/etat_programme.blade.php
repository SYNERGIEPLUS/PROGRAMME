<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ $groupe }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        .header {
            margin-bottom: 20px;
        }

        .header p {
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>{{ $groupe }}</h1>
        <p>Date d'impression : {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>CTX</th>
                <th>Vérif</th>
                <th>Service Générale</th>
            </tr>
        </thead>
        <tbody>
            @foreach($planning as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item['date'])->format('d/m/Y') }}</td>
                    <td>{{ $item['ctx'] }}</td>
                    <td>{{ $item['verif'] }}</td>
                    <td>
                        @if(is_array($item['generale']))
                            {{ implode(', ', $item['generale']) }}
                        @else
                            {{ $item['generale'] }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
