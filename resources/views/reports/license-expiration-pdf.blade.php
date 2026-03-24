<!DOCTYPE html>
<html>
<head>
    <title>License Expiration Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #e74a3b; color: white; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>License Expiration Report</h1>
        <p>Generated: {{ date('Y-m-d H:i:s') }}</p>
    </div>
    
    <h3>Expired ({{ $expired->count() }})</h3>
    <table>
        <thead>
            <tr>
                <th>Software Name</th>
                <th>Vendor</th>
                <th>Expiration Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expired as $license)
            <tr>
                <td>{{ $license->software_name }}</td>
                <td>{{ $license->vendor?->name }}</td>
                <td>{{ $license->expiration_date?->format('Y-m-d') }}</td>
                <td>Expired</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <h3>Expiring Soon ({{ $expiringSoon->count() }})</h3>
    <table>
        <thead>
            <tr>
                <th>Software Name</th>
                <th>Vendor</th>
                <th>Expiration Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expiringSoon as $license)
            <tr>
                <td>{{ $license->software_name }}</td>
                <td>{{ $license->vendor?->name }}</td>
                <td>{{ $license->expiration_date?->format('Y-m-d') }}</td>
                <td>Expiring Soon</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <h3>Valid ({{ $valid->count() }})</h3>
    <table>
        <thead>
            <tr>
                <th>Software Name</th>
                <th>Vendor</th>
                <th>Expiration Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($valid as $license)
            <tr>
                <td>{{ $license->software_name }}</td>
                <td>{{ $license->vendor?->name }}</td>
                <td>{{ $license->expiration_date?->format('Y-m-d') }}</td>
                <td>Valid</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
