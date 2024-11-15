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

        th,td{
            font-size: 10px;
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
    <img src="{{ public_path('Images/Masayon Auto Klinik Logo.png') }}" alt="Masayon Logo" width="100">
    <div class="header">
        <h1>Customer Registration Report ({{ $interval }})</h1>
        <p>Date Generated: {{ \Carbon\Carbon::now()->format('F j, Y') }}</p>
    </div>

    <table width="100%">
        <thead>
            <tr>
                <th>Fullname</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Username</th>
                <th>Date Registered</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
            <tr>
                <td>{{ $customer->fullname }}</td>
                <td>{{ $customer->email }}</td>
                <td>+63{{ $customer->phone_number }}</td>
                <td>{{ $customer->username }}</td>
                <td>{{ $customer->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
