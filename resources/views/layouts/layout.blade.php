<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
 {!!   config('google.google_tag.head') !!}
    <meta name="csrf-token" content="{{{ csrf_token() }}}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite([
    'resources/css/app.css',
    'resources/js/app.js',
    ])
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    @livewireStyles
    <title>@yield('title', config('seo.seo.title'))</title>
    <meta name="description" content="@yield('description',  config('seo.seo.description'))"/>
    <meta name="keywords" content="@yield('keywords',  config('seo.seo.keywords'))"/>
    @hasSection('canonical')
    <link rel="canonical" href="@yield('canonical')"/>
    @endif
    @hasSection('noindex')
    <meta name="robots" content="noindex, nofollow"/>
    @endif
</head>
<body>
<div id="scrollTopBtn"></div>
  {!!  config('google.google_tag.body') !!}
    <div class="content_  @yield('class')  {{ route_name() }}" >
        <x-message.message/>
        <x-message.message_error/>
@yield('content')
</div><!--.content_-->
 @include('templates.axeld.footer')
    @livewireScripts
</body>
</html>

