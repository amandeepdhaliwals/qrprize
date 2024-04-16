<?php

namespace Modules\Coupons\Http\Middleware;

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
            // Coupons
            $menu->add('<i class="nav-icon fa-solid fa-ticket"></i> '.__('Coupons'), [
                'route' => 'backend.coupons.index',
                'class' => 'nav-item',
            ])
                ->data([
                    'order' => 99, // Change the order if necessary
                    'activematches' => ['admin/coupons*'], // Adjust the URL pattern if necessary
                    'permission' => ['view_coupons'], // Add necessary permissions
                ])
                ->link->attr([
                    'class' => 'nav-link',
                ]);
        })->sortBy('order');

        return $next($request);
    }
}
