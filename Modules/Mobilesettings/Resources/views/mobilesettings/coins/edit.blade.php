@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item route='{{ route("backend.mobilesettings.coins") }}' icon='{{ $module_icon }}'>
        {{ __($module_title) }}
    </x-backend-breadcrumb-item>
    <x-backend-breadcrumb-item type="active">{{ __($module_action) }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="{{ $module_icon }}"></i> {{ __($module_title) }} <small class="text-muted">{{ __($module_action) }}</small>
        </h3>
    </div>

    <div class="card-body">
       <form action="{{ route('backend.mobilesettings.coins.update', $coin->id) }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="category" class="form-label">{{ __('Category') }}</label>
                <input type="text" disabled name="category" id="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category', $coin->category) }}" required>
                @error('category')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="coins_per_category" class="form-label">{{ __('Coins Per Category') }}</label>
                <input type="number" name="coins_per_category" id="coins_per_category" class="form-control @error('coins_per_category') is-invalid @enderror" value="{{ old('coins_per_category', $coin->coins_per_category) }}" required>
                @error('coins_per_category')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                <a href="{{ route('backend.mobilesettings.coins') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
