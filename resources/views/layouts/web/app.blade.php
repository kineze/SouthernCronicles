<!DOCTYPE html>
<html lang="en">

    @include('web.includes.headerlinks')

  <body class="m-0 font-sans antialiased font-normal text-left leading-default text-base dark:bg-slate-950 bg-white text-slate-500 dark:text-white/80">
    <!-- sidenav -->


    <main id="app" class="mt-0 transition-all duration-200 ease-soft-in-out">
      
      @include('web.includes.nav')


        @yield('content')

    </main>

    @include('web.includes.footer')
  </body>

  @include('web.includes.footerlinks')
  @stack('scripts')
  
</html>