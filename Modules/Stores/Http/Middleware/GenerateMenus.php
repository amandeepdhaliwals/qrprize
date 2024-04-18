<?php

namespace Modules\Stores\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        \Menu::make('admin_sidebar', function ($menu) {
            // Stores
            $menu->add('<i class="nav-icon fa-solid fa-ticket"></i> '.__('Stores'), [
                'route' => 'backend.stores.index',
                'class' => 'nav-item',
            ])
                ->data([
                    'order' => 99, // Change the order if necessary
                    'activematches' => ['admin/stores*'], // Adjust the URL pattern if necessary
                    'permission' => ['view_stores'], // Add necessary permissions
                ])
                ->link->attr([
                    'class' => 'nav-link',
                ]);
        })->sortBy('order');

        return $next($request);
    }
}
