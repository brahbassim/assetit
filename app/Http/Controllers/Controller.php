<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\AuditLog;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function logAudit(string $action, $model = null, ?string $description = null): void
    {
        AuditLog::log(
            $action,
            $model ? get_class($model) : null,
            $model?->id,
            $description
        );
    }
}
