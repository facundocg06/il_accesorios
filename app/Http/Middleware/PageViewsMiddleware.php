<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\PageView;
use Illuminate\Support\Facades\Route;

class PageViewsMiddleware
{
    public function handle($request, Closure $next)
    {
        // Obtener la URL de la página actual
        $pageUrl = Route::current()->uri();

        // Buscar o crear una entrada para esta URL
        $pageView = PageView::where('page_url', $pageUrl)->first();

        if (!$pageView) {
            // Si no existe, crear una nueva entrada
            $pageView = PageView::create([
                'page_url' => $pageUrl,
                'visits' => 1,
            ]);
        } else {
            // Si existe, incrementar el contador de visitas
            $pageView->increment('visits');
        }

        return $next($request);
    }
}
