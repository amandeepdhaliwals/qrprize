<?php

namespace Modules\Gallery\Http\Middleware;

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
        //     $accessControl = $menu->add('<i class="nav-icon fa-solid fas fa-photo-video"></i> Gallery', [
        //         'class' => 'nav-group',
        //     ])
        //         ->data([
        //             'order' => 99,
        //             'activematches' => [
        //                 'admin/gallery*',
        //             ],
        //             'permission' => ['view_gallery'],
        //         ]);
        //     $accessControl->link->attr([
        //         'class' => 'nav-link nav-group-toggle',
        //         'href' => '#',
        //     ]);

        //     $accessControl->add('<i class="nav-icon fa-solid fa-video"></i> Videos', [
        //         'url' => route('backend.gallery.index') . '?type=videos',
        //         'class' => 'nav-item',
        //     ])
        //         ->data([
        //             'order' => 99,
        //             'activematches' => 'admin/gallery?type=videos',
        //             'permission' => ['view_gallery'],
        //         ])
        //         ->link->attr([
        //             'class' => 'nav-link' . (request()->is('admin/gallery') && request()->query('type') == 'videos' ? ' active' : ''),
        //         ]);
                
        //         // Submenu: Images
        //         $accessControl->add('<i class="nav-icon fa-solid fa-image"></i> Images', [
        //             'url' => route('backend.gallery.list-gallery', ['type' => 'images']), // Set query parameter here
        //             'class' => 'nav-item',
        //         ])
        //         ->data([
        //             'order' => 99,
        //             'activematches' => 'admin/gallery?type=images', // Exact URL with query parameter
        //             'permission' => ['view_gallery'],
        //         ])
        //         ->link->attr([
        //             'class' => 'nav-link' . (request()->is('admin/gallery') && request()->query('type') == 'images' ? ' active' : ''),
        //         ]);
             

        // })->sortBy('order');

        return $next($request);
    }
}

