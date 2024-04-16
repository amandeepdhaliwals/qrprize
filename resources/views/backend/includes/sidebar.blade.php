<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <a href="{{route('backend.dashboard')}}">
          <!-- <img class="sidebar-brand-full" src="{{asset('img/backend-logo.jpg')}}" height="46" alt="{{ app_name() }}">
            <img class="sidebar-brand-narrow" src="{{asset('img/backend-logo-square.jpg')}}" height="46" alt="{{ app_name() }}">  -->

            <div class="sidebar-brand-full">
            <span style="display: inline-block; width: 100px; height: 46px; background-color: #ccc; text-align: center; line-height: 46px;">Qr Code</span>
            </div>
            <!-- <div class="sidebar-brand-narrow">
            <span style="display: inline-block; width: 46px; height: 46px; background-color: #ccc; text-align: center; line-height: 46px;">Your Logo</span>
            </div> -->
        </a>
    </div>

    {!! $admin_sidebar->asUl( ['class' => 'sidebar-nav', 'data-coreui'=>'navigation', 'data-simplebar'], ['class' => 'nav-group-items'] ) !!}

    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>