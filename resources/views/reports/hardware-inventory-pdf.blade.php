<!DOCTYPE html>
<html>
<head>
    <title>Hardware Inventory Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4e73df; color: white; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Hardware Inventory Report</h1>
        <p>Generated: {{ date('Y-m-d H:i:s') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Asset Tag</th>
                <th>Name</th>
                <th>Category</th>
                <th>Vendor</th>
                <th>Status</th>
                <th>Assigned To</th>
                <th>Purchase Date</th>
                <th>Purchase Cost</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assets as $asset)
            <tr>
                <td>{{ $asset->asset_tag }}</td>
                <td>{{ $asset->name }}</td>
                <td>{{ $asset->category?->name }}</td>
                <td>{{ $asset->vendor?->name }}</td>
                <td>{{ ucfirst($asset->status) }}</td>
                <td>{{ $asset->assignedEmployee?->full_name ?? 'Unassigned' }}</td>
                <td>{{ $asset->purchase_date?->format('Y-m-d') }}</td>
                <td>{{ $asset->purchase_cost ? '$' . number_format($asset->purchase_cost, 2) : 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
