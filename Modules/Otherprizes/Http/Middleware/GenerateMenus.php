<?php

namespace Modules\Otherprizes\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // \Menu::make('admin_sidebar', function ($menu) {
        //     // advertisement
        //     $menu->add('<i class="nav-icon fa-solid fa-ticket"></i> '.__('Other Prize images'), [
        //         'route' => 'backend.otherprizes.index',
        //         'class' => 'nav-item',
        //     ])
        //         ->data([
        //             'order' => 99, // Change the order if necessary
        //             'activematches' => ['admin/otherprizes*'], // Adjust the URL pattern if necessary
        //             'permission' => ['view_advertisements'], // Add necessary permissions
        //         ])
        //         ->link->attr([
        //             'class' => 'nav-link',
        //         ]);
        // })->sortBy('order');

        return $next($request);
    }
}
