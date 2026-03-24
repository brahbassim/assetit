<!DOCTYPE html>
<html>
<head>
    <title>@lang('app.warranty_expiring')</title>
</head>
<body>
    <h2>{{ $isExpired ? __('app.warranty_expired_notification') : __('app.warranty_expiring_notification') }}</h2>
    
    <p>@lang('app.hello')</p>
    
    <p>@lang('app.this_is_notification') @lang('app.the_warranty') {{ $isExpired ? __('app.warranty_has_expired') : __('app.warranty_is_expiring') }}:</p>
    
    <table>
        <tr>
            <td><strong>@lang('app.asset_tag'):</strong></td>
            <td>{{ $asset->asset_tag }}</td>
        </tr>
        <tr>
            <td><strong>@lang('app.name'):</strong></td>
            <td>{{ $asset->name }}</td>
        </tr>
        <tr>
            <td><strong>@lang('app.category'):</strong></td>
            <td>{{ $asset->category?->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>@lang('app.serial_number'):</strong></td>
            <td>{{ $asset->serial_number ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td><strong>@lang('app.warranty_expiry'):</strong></td>
            <td>{{ $asset->warranty_expiry?->format('Y-m-d') }}</td>
        </tr>
        <tr>
            <td><strong>@lang('app.status'):</strong></td>
            <td>{{ $isExpired ? __('app.expired') : __('app.expiring_soon') }}</td>
        </tr>
    </table>
    
    <p>@lang('app.please_take_action')</p>
    
    <p>@lang('app.best_regards'),<br>@lang('app.it_asset_management')</p>
</body>
</html>
