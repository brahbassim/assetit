<!DOCTYPE html>
<html>
<head>
    <title>Maintenance Cost Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f6c23e; color: white; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Maintenance Cost Report - {{ $year }}</h1>
        <p>Generated: {{ date('Y-m-d H:i:s') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Asset</th>
                <th>Type</th>
                <th>Description</th>
                <th>Vendor</th>
                <th>Date</th>
                <th>Cost</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
            <tr>
                <td>{{ $record->asset?->name }}</td>
                <td>{{ ucfirst($record->maintenance_type) }}</td>
                <td>{{ $record->description }}</td>
                <td>{{ $record->vendor?->name }}</td>
                <td>{{ $record->maintenance_date?->format('Y-m-d') }}</td>
                <td>{{ $record->cost ? '$' . number_format($record->cost, 2) : 'N/A' }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="5" style="text-align: right;"><strong>Total:</strong></td>
                <td><strong>${{ number_format($totalCost, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
