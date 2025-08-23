<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ config('app.deskripsi') }}">
    <meta name="keywords" content="skripsi, laravel, livewire">
    <meta name="author" content="{{ config('app.programmer') }}">
    <title>{{ $title ?? config('app.name') }}</title>
    @include('components.layouts.style')
    @include('components.layouts.script')
</head>

<body class="layout-top-nav" style="height: auto;">
    <div class="wrapper">
        <x-layouts.front.navbar />
        <div class="content-wrapper" style="min-height: 440px;">
            <x-layouts.front.content-header />
            <div class="content">
                <div class="container">
                    {{ $slot }}
                </div>
            </div>
        </div>
        <x-layouts.footer />
    </div>
</body>

</html>
