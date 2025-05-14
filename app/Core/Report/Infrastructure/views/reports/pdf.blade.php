<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport des Projets</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }

        h1, h2 {
            text-align: center;
            color: #333;
            margin-bottom: 10px;
        }

        h1 {
            font-size: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            vertical-align: top;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #555;
        }

        td {
            color: #333;
        }

        .task-list {
            margin: 0;
            padding-left: 15px;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            color: #888;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<h1>Rapport des Projets</h1>

@if( request('startDate')  &&   request('endDate'))
    <h2>Période : {{ request('startDate') }} au {{ request('endDate') }}</h2>
@endif
<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Nom du Projet</th>
        <th>Année</th>
        <th>Propriétaire</th>
        <th>Participants</th>
        <th>Tâches</th>
    </tr>
    </thead>
    <tbody>
    @foreach($reports as $index => $report)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $report['projectName'] }}</td>
            <td>{{ $report['year'] }}</td>
            <td>{{ $report['owner'] ?? 'N/A' }}</td>
            <td>{{ implode(', ', $report['participants']) }}</td>
            <td>
                <ul class="task-list">
                    @foreach(json_decode($report['tasks']) as $task)
                        <li>{{ $task }}</li>
                    @endforeach
                </ul>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="footer">
    Rapport généré automatiquement le {{ now()->format('d/m/Y à H:i') }}
</div>
</body>
</html>
