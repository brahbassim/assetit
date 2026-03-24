# API Documentation

AssetIT currently uses web routes with Blade templates. This guide covers adding REST API support.

## Adding API Support

### Step 1: Install Laravel Sanctum

```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

### Step 2: Configure Sanctum

Add to your `config/sanctum.php`:

```php
return [
    'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
        '%s%s',
        'localhost,localhost:3000,localhost:8080,127.0.0.1,127.0.0.1:8000,::1',
        env('APP_URL') ? ',' . parse_url(env('APP_URL'), PHP_URL_HOST) : ''
    ))),
    'guard' => ['web'],
    'expiration' => null,
    'token_prefix' => env('SANCTUM_TOKEN_PREFIX', ''),
    'middleware' => [
        'authenticate_session' => Laravel\Sanctum\Http\Middleware\AuthenticateSession::class,
        'encrypt_cookies' => Illuminate\Cookie\Middleware\EncryptCookies::class,
        'validate_csrf_token' => Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
    ],
];
```

### Step 3: Update User Model

Add `HasApiTokens` trait to User model:

```php
<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    // ...
}
```

## API Routes

Create API routes in `routes/api.php`:

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HardwareAssetController;
use App\Http\Controllers\Api\SoftwareLicenseController;

Route::middleware('auth:sanctum')->group(function () {
    // Hardware Assets
    Route::apiResource('hardware-assets', HardwareAssetController::class);
    
    // Software Licenses
    Route::apiResource('software-licenses', SoftwareLicenseController::class);
    
    // Dashboard Stats
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
});
```

## Example Controllers

### HardwareAssetController

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HardwareAsset;
use Illuminate\Http\Request;

class HardwareAssetController extends Controller
{
    public function index()
    {
        return response()->json(HardwareAsset::with(['category', 'vendor', 'employee'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:asset_categories,id',
            'manufacturer' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date',
            'purchase_cost' => 'nullable|numeric',
            'status' => 'required|in:Active,In Repair,Retired',
        ]);

        $asset = HardwareAsset::create($validated);
        return response()->json($asset, 201);
    }

    public function show(HardwareAsset $hardwareAsset)
    {
        return response()->json($hardwareAsset->load(['category', 'vendor', 'employee']));
    }

    public function update(Request $request, HardwareAsset $hardwareAsset)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'category_id' => 'sometimes|exists:asset_categories,id',
            'manufacturer' => 'sometimes|string|max:255',
            'model' => 'sometimes|string|max:255',
            'serial_number' => 'sometimes|string|max:255',
            'purchase_date' => 'sometimes|date',
            'purchase_cost' => 'sometimes|numeric',
            'status' => 'sometimes|in:Active,In Repair,Retired',
        ]);

        $hardwareAsset->update($validated);
        return response()->json($hardwareAsset);
    }

    public function destroy(HardwareAsset $hardwareAsset)
    {
        $hardwareAsset->delete();
        return response()->json(null, 204);
    }
}
```

## Authentication

### Login

```bash
POST /api/login
Content-Type: application/json

{
    "email": "admin@assetit.com",
    "password": "password"
}
```

Response:

```json
{
    "token": "1|a1b2c3d4e5f6g7h8i9j0...",
    "user": {
        "id": 1,
        "name": "Admin User",
        "email": "admin@assetit.com"
    }
}
```

### Using the Token

```bash
GET /api/hardware-assets
Authorization: Bearer 1|a1b2c3d4e5f6g7h8i9j0...
```

### Logout

```bash
POST /api/logout
Authorization: Bearer 1|a1b2c3d4e5f6g7h8i9j0...
```

## API Response Format

### Success

```json
{
    "success": true,
    "data": { ... },
    "message": "Operation successful"
}
```

### Error

```json
{
    "success": false,
    "message": "Error message",
    "errors": { ... }
}
```

## Rate Limiting

Laravel Sanctum includes rate limiting. Configure in `config/sanctum.php`:

```php
'limiter' => function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
},
```

## CORS Configuration

Update `config/cors.php`:

```php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:3000'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];
```
