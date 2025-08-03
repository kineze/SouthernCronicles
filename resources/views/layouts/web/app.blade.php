<!DOCTYPE html>
<html lang="en">

    @include('web.includes.headerlinks')

  <body class="m-0 font-sans antialiased font-normal text-left leading-default text-base dark:bg-slate-950 bg-white text-slate-500 dark:text-white/80">
    <!-- sidenav -->


    <main id="app" class="mt-0 transition-all duration-200 p-3 ease-soft-in-out">
      
      @include('web.includes.nav')


        @yield('content')

          @if (!Route::is('writingLab'))
            <a href="{{ route('writingLab') }}" class="animate-fade-up hidden fixed bottom-6 right-6 z-[1000] bg-black text-white w-14 lg:inline-flex items-center justify-center h-14 rounded-full shadow-lg hover:bg-black hover:text-white transition-all duration-500">
              <i class="fa-solid fa-file-pen text-xl"></i>
              {{-- <svg class="w-6 h-6" version="1.1" id="Uploaded to svgrepo.com" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" xml:space="preserve" fill="#ffffff" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .blueprint_een{fill:#ffffff;} </style> <path class="blueprint_een" d="M30.707,9.293L26,4.586V1c0-0.552-0.448-1-1-1H3C2.448,0,2,0.448,2,1v30c0,0.552,0.448,1,1,1 h22c0.552,0,1-0.448,1-1V15.414l4.707-4.707C31.098,10.317,31.098,9.683,30.707,9.293z M11.921,17.628l4.452,4.452l-5.194,0.742 L11.921,17.628z M17.146,21.439l-4.586-4.586l8.293-8.293l4.586,4.586L17.146,21.439z M26.146,12.439l-4.586-4.586L24,5.414v0 L28.586,10L26.146,12.439z M4,30V2h20v2l-4,4H8v1h11l-2,2H8v1h8l-2,2H8v1h5l-1.764,1.764c-0.069,0.069-0.124,0.15-0.17,0.236H8v1 h2.857l-0.286,2H8v1h2.429l-0.286,2H8v1h2l6.67-0.953c0.214-0.031,0.413-0.13,0.566-0.283L24,16v14H4z"></path> </g></svg> --}}
            </a>
        @endif
        
        @include('web.includes.footer')

    </main>
    
    @stack('scripts')
    
  </body>

  @include('web.includes.footerlinks')
  @stack('scripts')
  
</html>