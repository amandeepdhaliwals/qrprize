<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <a href="{{route('backend.dashboard')}}">
            <img class="sidebar-brand-full" src="{{asset('img/backend-logo.jpg')}}" height="46" alt="{{ app_name() }}">
            <img class="sidebar-brand-narrow" src="{{asset('img/backend-logo-square.jpg')}}" height="46" alt="{{ app_name() }}">
        </a>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="init">
        <div class="simplebar-wrapper" style="margin: 0px;">
            <div class="simplebar-height-auto-observer-wrapper">
                <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
                <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                    <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden;">
                        <div class="simplebar-content" style="padding: 0px;">
                            <li class="nav-item active show"><a class="nav-link active" href="{{ route('customerbackend.dashboard') }}"><i class="nav-icon fa-solid fa-cubes"></i> Dashboard</a></li>
                            <li class="nav-item active show"><a class="nav-link active" href="{{ route('customerbackend.campaigns_index') }}"><i class="nav-icon fa-solid fa-cubes"></i> Campaigns</a></li>
                            <li class="nav-item active show"><a class="nav-link active" href="{{ route('customerbackend.history') }}"><i class="nav-icon fa-solid fa-cubes"></i> History</a></li>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simplebar-placeholder" style="width: 256px; height: 51px;"></div>
        </div>
        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
            <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
        </div>
        <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
            <div class="simplebar-scrollbar" style="height: 0px; display: none;"></div>
        </div>
    </ul>

    <!-- {!! $admin_sidebar->asUl( ['class' => 'sidebar-nav', 'data-coreui'=>'navigation', 'data-simplebar'], ['class' => 'nav-group-items'] ) !!} -->

    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>