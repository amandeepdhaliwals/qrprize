<?php

namespace App\Http\Middleware;

use Closure;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        \Menu::make('admin_sidebar', function ($menu) {
            // Dashboard
            $menu->add('<i class="nav-icon fa-solid fa-cubes"></i> '.__('Dashboard'), [
                'route' => 'backend.dashboard',
                'class' => 'nav-item',
            ])
                ->data([
                    'order' => 1,
                    'activematches' => 'admin/dashboard*',
                ])
                ->link->attr([
                    'class' => 'nav-link',
                ]);

                \Menu::make('admin_sidebar', function ($menu) {
                    // gallery images
                    $accessControl = $menu->add('<i class="nav-icon fa-solid fas fa-photo-video"></i> Gallery', [
                        'class' => 'nav-group',
                    ])
                        ->data([
                            'order' => 2,
                            'activematches' => [
                                'admin/gallery*',
                            ],
                            'permission' => ['view_gallery'],
                        ]);
                    $accessControl->link->attr([
                        'class' => 'nav-link nav-group-toggle',
                        'href' => '#',
                    ]);
        
                    $accessControl->add('<i class="nav-icon fa-solid fa-image"></i> Images', [
                        'route' => 'backend.gallery.index',
                        'class' => 'nav-item',
                    ])
                        ->data([
                            'order' => 2,
                            'activematches' => 'admin/gallery*',
                            'permission' => ['view_gallery'],
                        ])
                            ->link->attr([
                                'class' => 'nav-link',
                            ]);
                
                    /// Submenu Videos
                    $accessControl->add('<i class="nav-icon fa-solid fa-video"></i> Videos', [
                        'route' => 'backend.videos.index',
                        'class' => 'nav-item',
                    ])
                        ->data([
                            'order' => 3,
                            'activematches' => 'admin/videos*',
                            'permission' => ['view_videos'],
                        ])
                        ->link->attr([
                            'class' => 'nav-link',
                        ]);  
                    
                    /// Submenu Other Prize
                    $accessControl->add('<i class="nav-icon fa-solid fa-image"></i> Other Prize Images', [
                        'route' => 'backend.otherprizes.index',
                        'class' => 'nav-item',
                    ])
                        ->data([
                            'order' => 3,
                            'activematches' => 'admin/otherprizes*',
                            'permission' => ['view_otherprizes'],
                        ])
                        ->link->attr([
                            'class' => 'nav-link',
                     ]);
                            
                    })->sortBy('order'); 

                    \Menu::make('admin_sidebar', function ($menu) {
                        // Main group: Customer
                        $accessControl = $menu->add('<i class="nav-icon fa-solid fas fa-users"></i> Customer', [
                            'class' => 'nav-group',
                        ])
                            ->data([
                                'order' => 100,
                                'activematches' => [
                                    'admin/customers*',
                                ],
                                'permission' => ['view_customers'],
                            ]);
                    
                        $accessControl->link->attr([
                            'class' => 'nav-link nav-group-toggle',
                            'href' => '#',
                        ]);
                    
                        // Submenu: Statistics
                        $accessControl->add('<i class="nav-icon fa-solid fa-bar-chart"></i> Statistics', [
                            'route' => 'backend.customers.stats',
                            'class' => 'nav-item',
                        ])
                            ->data([
                                'order' => 101,
                                'activematches' => [
                                    'admin/customers/stats',
                                ],
                                'permission' => ['view_customers'],
                            ])
                            ->link->attr([
                                'class' => 'nav-link',
                            ]);
                    
                        // Submenu: Visitor Activity
                        $accessControl->add('<i class="nav-icon fa-solid fa-bar-chart"></i> Visitor Activity', [
                            'route' => 'backend.customers.visitor',
                            'class' => 'nav-item',
                        ])
                            ->data([
                                'order' => 102,
                                'activematches' => [
                                    'admin/customers/visitor',
                                ],
                                'permission' => ['view_visitor'],
                            ])
                            ->link->attr([
                                'class' => 'nav-link',
                            ]);
                    
                        // Submenu: List
                        $accessControl->add('<i class="nav-icon fa-solid fa-list"></i> List', [
                            'route' => 'backend.customers.index',
                            'class' => 'nav-item',
                        ])
                            ->data([
                                'order' => 103,
                                'activematches' => [
                                    'admin/customers/index',
                                ],
                                'permission' => ['view_customers'],
                            ])
                            ->link->attr([
                                'class' => 'nav-link',
                            ]);
                    
                        // Submenu: Claimed
                        $accessControl->add('<i class="nav-icon fa-solid fa-list"></i> Claimed', [
                            'route' => 'backend.customers.claimed',
                            'class' => 'nav-item',
                        ])
                            ->data([
                                'order' => 104,
                                'activematches' => [
                                    'admin/customers/claimed',
                                ],
                                'permission' => ['view_claimed'],
                            ])
                            ->link->attr([
                                'class' => 'nav-link',
                            ]);
                    })->sortBy('order');
                    
                    \Menu::make('admin_sidebar', function ($menu) {
                        // Main group: Mobile App Settings
                        $accessControl = $menu->add('<i class="nav-icon fa-solid fa-mobile-alt"></i> Mobile App Settings', [
                            'class' => 'nav-group',
                        ])
                        ->data([
                            'order' => 101,
                            'activematches' => [
                                'admin/mobilesetting*',
                            ],
                            'permission' => ['view_mobilesettings'],
                        ]);
                    
                        $accessControl->link->attr([
                            'class' => 'nav-link nav-group-toggle',
                            'href' => '#',
                        ]);
                    
                        // Submenu: Coins
                        $accessControl->add('<i class="nav-icon fa-solid fa-bar-chart"></i> Coins', [
                            'route' => 'backend.mobilesettings.coins',
                            'class' => 'nav-item',
                        ])
                        ->data([
                            'order' => 102,
                            'activematches' => [
                                'admin/mobilesetting/coins',
                            ],
                            'permission' => ['view_mobilesettings'],
                        ])
                        ->link->attr([
                            'class' => 'nav-link',
                        ]);
                    
                        // New Submenu: Site Info
                        $accessControl->add('<i class="nav-icon fa-solid fa-info-circle"></i> Site Info', [
                            'route' => 'backend.mobilesettings.site_info',
                            'class' => 'nav-item',
                        ])
                        ->data([
                            'order' => 103,
                            'activematches' => [
                                'admin/mobilesetting/site-info',
                            ],
                            'permission' => ['view_mobilesettings'],
                        ])
                        ->link->attr([
                            'class' => 'nav-link',
                        ]);

                        $accessControl->add('<i class="nav-icon fa-solid fa-ad"></i> Manage Ads', [
                            'route' => 'backend.mobilesettings.manage-ads',  // Update the route for managing ads
                            'class' => 'nav-item',
                        ])
                        ->data([
                            'order' => 104,  // Change the order if necessary
                            'activematches' => [
                                'admin/mobilesetting/manage-ads',  // Match the active route for manage ads
                            ],
                            'permission' => ['view_manageads'],  // Adjust permission as needed
                        ])
                        ->link->attr([
                            'class' => 'nav-link',
                        ]);

                    
                    })->sortBy('order');
                    
                                          
             // // Notifications
             // $menu->add('<i class="nav-icon fas fa-bell"></i> Notifications', [
            //     'route' => 'backend.notifications.index',
            //     'class' => 'nav-item',
            // ])
            //     ->data([
            //         'order' => 99,
            //         'activematches' => 'admin/notifications*',
            //         'permission' => [],
            //     ])
            //     ->link->attr([
            //         'class' => 'nav-link',
            //     ]);


            // Separator: Access Management
            $menu->add('Management', [
                'class' => 'nav-title',
            ])
                ->data([
                    'order' => 101,
                    'permission' => ['edit_settings', 'view_backups', 'view_users', 'view_roles', 'view_logs'],
                ]);

            // Settings
            $menu->add('<i class="nav-icon fas fa-cogs"></i> Settings', [
                'route' => 'backend.settings',
                'class' => 'nav-item',
            ])
                ->data([
                    'order' => 102,
                    'activematches' => 'admin/settings*',
                    'permission' => ['edit_settings'],
                ])
                ->link->attr([
                    'class' => 'nav-link',
                ]);

            // Backup
            $menu->add('<i class="nav-icon fas fa-archive"></i> Backups', [
                'route' => 'backend.backups.index',
                'class' => 'nav-item',
            ])
                ->data([
                    'order' => 103,
                    'activematches' => 'admin/backups*',
                    'permission' => ['view_backups'],
                ])
                ->link->attr([
                    'class' => 'nav-link',
                ]);

            // Access Control Dropdown
            $accessControl = $menu->add('<i class="nav-icon fa-solid fa-user-gear"></i> Access Control', [
                'class' => 'nav-group',
            ])
                ->data([
                    'order' => 104,
                    'activematches' => [
                        'admin/users*',
                        'admin/roles*',
                    ],
                    'permission' => ['view_users', 'view_roles'],
                ]);
            $accessControl->link->attr([
                'class' => 'nav-link nav-group-toggle',
                'href' => '#',
            ]);

            // Submenu: Users
            $accessControl->add('<i class="nav-icon fa-solid fa-user-group"></i> Users', [
                'route' => 'backend.users.index',
                'class' => 'nav-item',
            ])
                ->data([
                    'order' => 105,
                    'activematches' => 'admin/users*',
                    'permission' => ['view_users'],
                ])
                ->link->attr([
                    'class' => 'nav-link',
                ]);

            // Submenu: Roles
            $accessControl->add('<i class="nav-icon fa-solid fa-user-shield"></i> Roles', [
                'route' => 'backend.roles.index',
                'class' => 'nav-item',
            ])
                ->data([
                    'order' => 106,
                    'activematches' => 'admin/roles*',
                    'permission' => ['view_roles'],
                ])
                ->link->attr([
                    'class' => 'nav-link',
                ]);

            // Log Viewer
            // Log Viewer Dropdown
            $accessControl = $menu->add('<i class="nav-icon fa-solid fa-list-check"></i> Log Viewer', [
                'class' => 'nav-group',
            ])
                ->data([
                    'order' => 107,
                    'activematches' => [
                        'log-viewer*',
                    ],
                    'permission' => ['view_logs'],
                ]);
            $accessControl->link->attr([
                'class' => 'nav-link nav-group-toggle',
                'href' => '#',
            ]);

            // Submenu: Log Viewer Dashboard
            $accessControl->add('<i class="nav-icon fa-solid fa-list"></i> Dashboard', [
                'route' => 'log-viewer::dashboard',
                'class' => 'nav-item',
            ])
                ->data([
                    'order' => 108,
                    'activematches' => 'admin/log-viewer',
                ])
                ->link->attr([
                    'class' => 'nav-link',
                ]);

            // Submenu: Log Viewer Logs by Days
            $accessControl->add('<i class="nav-icon fa-solid fa-list-ol"></i> Logs by Days', [
                'route' => 'log-viewer::logs.list',
                'class' => 'nav-item',
            ])
                ->data([
                    'order' => 109,
                    'activematches' => 'admin/log-viewer/logs*',
                ])
                ->link->attr([
                    'class' => 'nav-link',
                ]);

            // Access Permission Check
            $menu->filter(function ($item) {
                if ($item->data('permission')) {
                    if (auth()->check()) {
                        if (auth()->user()->hasRole('super admin')) {
                            return true;
                        }
                        if (auth()->user()->hasAnyPermission($item->data('permission'))) {
                            return true;
                        }
                    }

                    return false;
                }

                return true;
            });

            // Set Active Menu
            $menu->filter(function ($item) {
                if ($item->activematches) {
                    $activematches = is_string($item->activematches) ? [$item->activematches] : $item->activematches;
                    foreach ($activematches as $pattern) {
                        if (request()->is($pattern)) {
                            $item->active();
                            $item->link->active();
                            if ($item->hasParent()) {
                                $item->parent()->active();
                            }
                        }
                    }
                }

                return true;
            });
        })->sortBy('order');

        return $next($request);
    }
}
