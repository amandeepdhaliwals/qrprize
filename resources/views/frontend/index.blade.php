@extends('frontend.layouts.app')

@section('title') {{app_name()}} @endsection

@section('content')

<section class="bg-gray-100 mb-20">
    <div class="container mx-auto flex px-1 sm:px-20 py-20 md:flex-row flex-col items-center">
        <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6 mb-10 md:mb-0">
            <img class="object-cover object-center rounded" alt="hero" src="{{ asset('img/logo-square.jpg') }}">
        </div>
        <div class="lg:flex-grow md:w-1/2 px-4 lg:pl-24 md:pl-16 flex flex-col md:items-start md:text-left items-center text-center">
            <h1 class="title-font sm:text-8xl text-5xl mb-4 font-medium text-gray-800">
                {{ app_name() }}
            </h1>
            <p class="mb-8 sm:text-4xl text-3xl">
                {!! setting('meta_description') !!}
            </p>

            @include('frontend.includes.messages')

        </div>
    </div>
</section>


@endsection