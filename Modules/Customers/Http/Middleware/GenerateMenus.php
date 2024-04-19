<?php

namespace Modules\Customers\Http\Middleware;

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
            // Customers
            $menu->add('<i class="nav-icon fa-solid fa-ticket"></i> '.__('Customers'), [
                'route' => 'backend.customers.index',
                'class' => 'nav-item',
            ])
                ->data([
                    'order' => 100, // Change the order if necessary
                    'activematches' => ['admin/customers*'], // Adjust the URL pattern if necessary
                    'permission' => ['view_customers'], // Add necessary permissions
                ])
                ->link->attr([
                    'class' => 'nav-link',
                ]);
        })->sortBy('order');

        return $next($request);
    }
}
