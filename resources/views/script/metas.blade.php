@if(\Illuminate\Support\Facades\Route::currentRouteNamed('index'))
    <link rel="preload" as="image" href="{{ !empty($page['props']['raffles'][0]['new_banner']) ? $page['props']['raffles'][0]['new_banner'] : '' }}" type="image/webp" fetchpriority="high">
@endif

@if(\Illuminate\Support\Facades\Route::currentRouteNamed('raffle'))
    <link rel="preload" as="image" href="{{ $page['props']['raffle']['galery'][0]->img }}" type="image/webp" fetchpriority="high">
@endif

@if(\Illuminate\Support\Facades\Route::currentRouteNamed('index') || \Illuminate\Support\Facades\Route::currentRouteNamed('raffle'))
    <meta head-key="description" name="description" content="{{ $meta['description'] ?? $page['props']['siteconfig']['meta_description'] }}"/>
    <meta head-key="keywords" name="keywords" content="{{ $meta['keywords'] ?? $page['props']['siteconfig']['meta_keywords'] }}"/>

    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">

    <meta name="author" content="L8 Digital"/>
    <link rel="canonical" href="{{url()->current()}}"/>
    <link rel="alternate" media="only screen and (max-width: 640px)" href="{{url()->current()}}">

    <meta property="og:image" content="{{ $meta['image'] ?? $page['props']['siteconfig']['meta_image'] }}" />
    <meta property="og:image:secure_url" content="{{ $meta['image'] ?? $page['props']['siteconfig']['meta_image'] }}" />
    <meta property="og:image:type" content="image/webp" />
    <meta property="og:image:width" content="{{ config('app.width') }}"/>
    <meta property="og:image:height" content="{{ config('app.height') }}"/>

    <meta name="og:title" property="og:title" content="{{ $meta['title'] ?? $page['props']['siteconfig']['site_title'] }}"/>
    <meta name="og:description" property="og:description" content="{{$meta['description'] ??  $page['props']['siteconfig']['meta_description'] }}"/>
    <meta name="og:url" property="og:url" content="{{ url()->current() }}"/>
    <meta name="og:width" property="og:width" content="{{ config('app.width') }}"/>
    <meta name="og:height" property="og:height" content="{{ config('app.height') }}"/>
    <meta name="og:locale" property="og:locale" content="pt_BR" />
    <meta property="og:type" content="website"/>

    <meta name="twitter:title" property="twitter:title" content="{{ $meta['title'] ?? $page['props']['siteconfig']['site_title'] }}"/>
    <meta name="twitter:description" property="twitter:description" content="{{ $meta['description'] ?? $page['props']['siteconfig']['meta_description'] }}"/>
    <meta name="twitter:image" property="twitter:image" content="{{$meta['image'] ?? $page['props']['siteconfig']['meta_image'] }}"/>
    <meta name="twitter:image:src" property="twitter:image:src" content="{{$meta['image'] ?? $page['props']['siteconfig']['meta_image'] }}"/>
    <meta name="twitter:card" property="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" property="twitter:site" content="L8 Digital" />
    <meta name="twitter:creator" property="twitter:creator" content="@l8digital"/>
    <meta name="twitter:url" property="twitter:url" content="{{url()->full()}}"/>

    <script type="application/ld+json">
    {
       "@type":"WebSite",
       "@context":"https://schema.org",
       "name":"{{$page['props']['siteconfig']['site_title'] ?? ''}}",
       "description":"{{$page['props']['siteconfig']['meta_description'] ?? ''}}",
       "url":"{{url()->current()}}",
       "logo":"{{$page['props']['siteconfig']['logo'] ?? ''}}",
       "sameAs": [
        "{{$page['props']['siteconfig']['instagram'] ?? ''}}"
      ]
  }
</script>
@endif
