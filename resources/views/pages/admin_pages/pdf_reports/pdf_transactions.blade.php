<!-- resources/views/pages/admin_pages/admin_reports_pdf.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
            text-align: left;
        }
        h1 {
            text-align: center;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Maintenance Transactions Report ({{ $interval }})</h1>
        <p>Date Generated: {{ \Carbon\Carbon::now()->format('F j, Y') }}</p>
    </div>

    <table width="100%">
        <thead>
            <tr>
                <th>Vehicle</th>
                <th>Owner</th>
                <th>Maintenance Type</th>
                <th>Cost</th>
                <th>Date Performed</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction as $item)
            <tr>
                <td>{{ $item->vehicle }}</td>
                <td>{{ $item->owner }}</td>
                <td>{{ $item->maintenance_type }}</td>
                <td>₱{{ number_format($item->cost, 2) }}</td>
                <td>{{ \Carbon\Carbon::parse($item->date_performed)->format('F j, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
