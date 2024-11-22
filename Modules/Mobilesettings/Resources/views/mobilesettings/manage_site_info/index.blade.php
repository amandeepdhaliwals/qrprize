@extends('backend.layouts.app')

@section('title') 
    {{ __($module_title) }} 
@endsection

@section('breadcrumbs')
    <x-backend-breadcrumbs>
        <x-backend-breadcrumb-item route='{{ route("backend.mobilesettings.site_info") }}' icon='{{ $module_icon }}'>
            {{ __($module_title) }}
        </x-backend-breadcrumb-item>

    </x-backend-breadcrumbs>
@endsection
<style>
.cke_notifications_area
{
    display:none;
}
</style>
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="{{ $module_icon }}"></i> {{ __($module_title) }}
        </h3>
    </div>

    <div class="card-body">
        <form action="{{ route('backend.mobilesettings.update_site_info') }}" method="POST">
            @csrf

            <!-- About Us -->
            <div class="form-group">
                <label for="about_us" class="form-label">{{ __('About Us') }}</label>
                <textarea name="about_us" id="about_us" class="form-control text-editor @error('about_us') is-invalid @enderror" required>{{ old('about_us', $aboutUs->content ?? '') }}</textarea>
                @error('about_us')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <!-- Privacy Policy -->
            <div class="form-group">
                <label for="privacy_policy" class="form-label">{{ __('Privacy Policy') }}</label>
                <textarea name="privacy_policy" id="privacy_policy" class="form-control text-editor @error('privacy_policy') is-invalid @enderror" required>{{ old('privacy_policy', $privacyPolicy->content ?? '') }}</textarea>
                @error('privacy_policy')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <!-- Help Support Mobile -->
            <div class="form-group">
                <label for="mobile" class="form-label">{{ __('Help & Support Mobile') }}</label>
                <input type="text" name="mobile" id="mobile" class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile', $helpSupport->mobile ?? '') }}" required>
                @error('mobile')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>

            <!-- Help Support Email -->
            <div class="form-group">
                <label for="email" class="form-label">{{ __('Help & Support Email') }}</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $helpSupport->email ?? '') }}" required>
                @error('email')
                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                @enderror
            </div>
            <br>
            <div class="form-group">
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
            <a href="{{ route('backend.mobilesettings.site_info') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('after-scripts')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('about_us');
    CKEDITOR.replace('privacy_policy');
</script>
@endpush
