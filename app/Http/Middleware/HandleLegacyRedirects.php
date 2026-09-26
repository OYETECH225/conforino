<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Sert les 301 configurées dans l'admin (table `redirects`) avant même que le
 * routeur ne tente de résoudre l'URL — indispensable pour ne perdre aucun
 * positionnement lors de la migration des anciennes URLs de conforino.fr.
 */
class HandleLegacyRedirects
{
    public function handle(Request $request, Closure $next): Response
    {
        $path = '/'.ltrim($request->path(), '/');

        $redirect = Redirect::query()
            ->where('from_path', $path)
            ->where('is_active', true)
            ->first();

        if ($redirect) {
            $redirect->increment('hits');

            $to = str_starts_with($redirect->to_path, 'http')
                ? $redirect->to_path
                : url($redirect->to_path);

            return redirect($to, $redirect->status_code);
        }

        return $next($request);
    }
}
