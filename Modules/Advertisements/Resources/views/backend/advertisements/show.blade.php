@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection
@php
    $data = $$module_name_singular;
    if($data['media_type'] == 'Image' || $data['media_type'] == 'image'){
        $data['media'] = url('/storage').'/'.$data['media'];
    }else if($data['media_type'] == 'Video' || $data['media_type'] == 'video'){ 
        $mediaUrl = url('/storage').'/'.$data['media'];
        $data['media'] = '<video width="380" height="240" controls>';
        $data['media'] .= '<source src="' . $mediaUrl . '" type="video/mp4">';
        $data['media'] .= '</video>';
    }
    else if($data['media_type'] == 'Youtube' || $data['media_type'] == 'youtube'){ 
        $mediaUrl = $data['media'];
        $data['media'] = ' <iframe width="380" height="240" src="'. $mediaUrl .'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';    
    }
    else if($data['media_type'] == 'Vimeo' || $data['media_type'] == 'vimeo'){ 
        $mediaUrl = $data['media'];
        $data['media'] = '  <iframe src="'. $mediaUrl .'" width="380" height="240" frameborder="0" allowfullscreen></iframe>';
    }
@endphp

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item route='{{route("backend.$module_name.index")}}' icon='{{ $module_icon }}'>
        {{ __($module_title) }}
    </x-backend-breadcrumb-item>
    <x-backend-breadcrumb-item type="active">{{ __($module_action) }}</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<x-backend.layouts.show :data="$data" :module_name="$module_name" :module_path="$module_path" :module_title="$module_title" :module_icon="$module_icon" :module_action="$module_action" />
@endsection