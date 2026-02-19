<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogAudit
{
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    public static function log(
        ?int $userId,
        string $action,
        string $entityType = null,
        int $entityId = null,
        array $oldValues = null,
        array $newValues = null,
        Request $request = null
    ): void {
        AuditLog::create([
            'user_id' => $userId,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
        ]);
    }
}
