<!DOCTYPE html>
<html lang="pt-br" theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $page['props']['siteconfig']['site_title'] ?? config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="/images/favicon.png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @include('script.styles')

        @include('script.metas')

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans">
        @inertia

        @include('script.scripts')
    </body>
</html>
