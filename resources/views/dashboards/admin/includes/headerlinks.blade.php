<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="gmaps-key" content="{{ config('services.google_maps.key') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('/assets/img/logo.webp')}}" />
    <link rel="icon" type="image/png" href="{{ asset('/assets/img/logo.webp') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>The Asian Literary Festival</title>

    <link href="{{asset('/assets/css/theme.css')}}" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  