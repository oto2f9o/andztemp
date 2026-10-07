<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.settings.name') }}</title>
    {!! config('app.settings.global.header') !!}
    @if(config('app.settings.favicon') && Illuminate\Support\Facades\Storage::disk('local')->has(config('app.settings.favicon')))
    <link rel="icon" href="{{ url('storage/' . config('app.settings.favicon')) }}">
    @elseif(Illuminate\Support\Facades\Storage::disk('local')->has('public/images/custom-favicon.png'))
    <link rel="icon" href="{{ url('storage/images/custom-favicon.png') }}" type="image/png">
    @else
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    @endif
    <link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" onload="this.onload=null;this.rel='stylesheet'" />
    <link rel="preload" as="style" href="{{ asset('css/vendor.css') }}" onload="this.onload=null;this.rel='stylesheet'">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    @livewireStyles
    {!! config('app.settings.global.css') !!}
    @if(!isset($page))
    {!! config('app.settings.app_header') !!}
    @endif
    @include('frontend.common.header')
    <style>
        input:focus {
            box-shadow: none !important;
            border-color: #8c8c8c !important;
        }
    </style>
</head>
<body style="background-color: {{ config('app.settings.colors.primary') }}">
    <div class="container mx-auto">
        <div class="flex h-screen">
            <div class="m-auto">
                <div class="flex justify-center my-10">
                    @if(config('app.settings.logo') && Illuminate\Support\Facades\Storage::disk('local')->has(config('app.settings.logo')))
                    <img class="w-logo" src="{{ url('storage/' . config('app.settings.logo')) }}" alt="logo">
                    @elseif(Illuminate\Support\Facades\Storage::disk('local')->has('public/images/custom-logo.png'))
                    <img class="max-w-logo" src="{{ url('storage/images/custom-logo.png') }}" alt="logo">
                    @else
                    <img class="max-w-logo" src="{{ asset('images/logo.png') }}" alt="logo">
                    @endif
                </div>
                <div class="bg-white rounded-lg p-10">
                    @if (Session::has('error'))
                    <div class="bg-red-50 w-full flex justify-between items-center rounded-lg px-4 py-3 text-sm mb-5">
                        <div class="flex justify-start items-center space-x-3">
                            <div class="text-red-400">
                               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                </svg>
                            </div>
                            <p class="text-sm text-red-400 font-medium">{{ Session::get('error') }}</p>
                        </div>
                    </div>
                    @endif
                    {!! config('app.settings.lock.text') !!}
                    <form action="{{ route('unlock') }}" class="flex justify-center items-center gap-2" method="post">
                        @csrf
                        <input type="password" name="password" id="password" class="flex-1 w-full rounded-md px-4 py-2 text-sm outline-none border-1 border-gray-200 focus:border-gray-200 focus:shadow-none" placeholder="{{ __('Password') }}">
                        <button type="submit" class="rounded-md px-4 py-2 text-sm border-1 text-white" style="border-color: {{ config('app.settings.colors.secondary') }}; background-color: {{ config('app.settings.colors.secondary') }}">{{ __('Unlock') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>