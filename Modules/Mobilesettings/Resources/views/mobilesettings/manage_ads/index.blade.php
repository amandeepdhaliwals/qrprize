@extends('backend.layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4">Manage Advertisements</h1>

    <ul class="nav nav-tabs" id="adsTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="trending-tab" data-bs-toggle="tab" data-bs-target="#trending" type="button" role="tab" aria-controls="trending" aria-selected="true">Trending Ads</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="new-tab" data-bs-toggle="tab" data-bs-target="#new" type="button" role="tab" aria-controls="new" aria-selected="false">New Ads</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="day-tab" data-bs-toggle="tab" data-bs-target="#day" type="button" role="tab" aria-controls="day" aria-selected="false">Ads for the Day</button>
        </li>
    </ul>

    <div class="tab-content mt-4" id="adsTabContent">
        <!-- Trending Ads Tab -->
        <div class="tab-pane fade show active" id="trending" role="tabpanel" aria-labelledby="trending-tab">
            @include('mobilesettings::mobilesettings.manage_ads.tab', ['type' => 'Trending Ads', 'adsMetaField' => 'is_trending_ad'])
        </div>

        <!-- New Ads Tab -->
        <div class="tab-pane fade" id="new" role="tabpanel" aria-labelledby="new-tab">
            @include('mobilesettings::mobilesettings.manage_ads.tab', ['type' => 'New Ads', 'adsMetaField' => 'is_new_ad'])
        </div>

        <!-- Ads for the Day Tab -->
        <div class="tab-pane fade" id="day" role="tabpanel" aria-labelledby="day-tab">
            @include('mobilesettings::mobilesettings.manage_ads.tab', ['type' => 'Ad of the Day', 'adsMetaField' => 'is_ad_of_the_day'])
        </div>
    </div>
</div>
@endsection
