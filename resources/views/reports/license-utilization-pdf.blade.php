<!DOCTYPE html>
<html>
<head>
    <title>License Utilization Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #1cc88a; color: white; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>License Utilization Report</h1>
        <p>Generated: {{ date('Y-m-d H:i:s') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Software Name</th>
                <th>Vendor</th>
                <th>Total Seats</th>
                <th>Assigned</th>
                <th>Available</th>
                <th>Utilization %</th>
                <th>Expiration</th>
            </tr>
        </thead>
        <tbody>
            @foreach($licenses as $license)
            <tr>
                <td>{{ $license->software_name }}</td>
                <td>{{ $license->vendor?->name }}</td>
                <td>{{ $license->total_seats }}</td>
                <td>{{ $license->assignedSeats() }}</td>
                <td>{{ $license->availableSeats() }}</td>
                <td>{{ $license->total_seats > 0 ? round(($license->assignedSeats() / $license->total_seats) * 100, 2) : 0 }}%</td>
                <td>{{ $license->expiration_date?->format('Y-m-d') ?? 'Perpetual' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
