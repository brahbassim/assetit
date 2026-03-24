<!DOCTYPE html>
<html>
<head>
    <title>@lang('app.license_expiring')</title>
</head>
<body>
    <h2>@lang('app.license_expiring_notification')</h2>
    
    <p>@lang('app.hello')</p>
    
    <p>@lang('app.this_is_notification')</p>
    
    <table>
        <tr>
            <td><strong>@lang('app.software_name'):</strong></td>
            <td>{{ $license->software_name }}</td>
        </tr>
        <tr>
            <td><strong>@lang('app.vendor'):</strong></td>
            <td>{{ $license->vendor?->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>@lang('app.total_seats'):</strong></td>
            <td>{{ $license->total_seats }}</td>
        </tr>
        <tr>
            <td><strong>@lang('app.expiration_date'):</strong></td>
            <td>{{ $license->expiration_date?->format('Y-m-d') }}</td>
        </tr>
        <tr>
            <td><strong>@lang('app.days_until_expiration'):</strong></td>
            <td>{{ $daysUntilExpiration }}</td>
        </tr>
    </table>
    
    <p>@lang('app.please_renew_license')</p>
    
    <p>@lang('app.best_regards'),<br>@lang('app.it_asset_management')</p>
</body>
</html>
