<!DOCTYPE html>
<html>
<head>
    <title>Assets by Department</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #36b9cc; color: white; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Assets by Department Report</h1>
        <p>Generated: {{ date('Y-m-d H:i:s') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Department</th>
                <th>Employee Count</th>
                <th>Asset Count</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($departments as $department)
            <tr>
                <td>{{ $department->name }}</td>
                <td>{{ $department->employees->count() }}</td>
                <td>{{ $department->employees->sum(fn($e) => $e->hardwareAssets->count()) }}</td>
                <td>{{ $department->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
