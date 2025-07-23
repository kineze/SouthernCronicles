<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/nextep-icon.webp')}}" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/nextep-icon.webp') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Brussels - ALF</title>

    <link href="{{asset('/assets/css/theme.css')}}" rel="stylesheet" />
    
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>

  