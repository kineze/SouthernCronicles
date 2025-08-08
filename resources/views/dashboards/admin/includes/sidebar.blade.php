<aside id="sidebar" class="fixed top-0 left-0 h-full w-60 bg-white dark:bg-slate-900 shadow-lg transition-all duration-300 z-50 overflow-hidden transform -translate-x-full lg:translate-x-0">

  <div class="flex items-center justify-center px-3 h-24 border-b border-gray-500 dark:border-gray-700">
    <a href="{{ url('/') }}" class="relative flex justify-center w-full items-center">

      <img src="/assets/img/logo.webp" alt="logo" class="sidebar-logo sidebar-logo-full block h-24 w-auto dark:hidden transition-opacity duration-200" loading="lazy" />

      <img src="/assets/img/logo.webp" alt="logo" class="sidebar-logo sidebar-logo-full hidden dark:block h-16 w-auto transition-opacity duration-200" loading="lazy" />

      <img src="/assets/img/logo.webp" alt="logo Icon" class="sidebar-logo sidebar-logo-icon hidden h-14 w-14 transition-opacity duration-200" loading="lazy" />
    </a>
  </div>

  <!-- Nav -->
  <nav class="mt-4 space-y-1 px-3">

    
    
    @can('Manage Bookings')

      <div class="relative sidebar-dropdown"
          data-subtitle="Manage Bookings"
          data-links='[
            {"label":"Time Slots","href":"{{ route('manageTimeSlots') }}"},
            {"label":"Bookings","href":"{{ route('manageBookings') }}"},
            {"label":"Memory Submission","href":"{{ route('memorySubmission') }}"}
          ]'>

        <button class="dropdown-toggle w-full flex items-center gap-3 p-2 rounded-lg dark:hover:bg-slate-800 transition-all">
          <div class="sidebar-icon-box">
            <i class="fa-solid fa-calendar-check"></i>
            <span class="sr-only test-black">Manage Bookings</span>
          </div>
          <span class="sidebar-label flex-1 text-sm font-medium text-black dark:text-white text-left">
            Manage Bookings
          </span>
          <i class="fas fa-chevron-down text-xs text-black sidebar-label"></i>
        </button>

        <div class="expanded-only hidden py-1 space-y-1">

          <a href="{{ route('manageTimeSlots') }}" class="block px-4 py-2 text-xs font-semibold text-black dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-md">
           Time Slots
          </a>

          <a href="{{ route('manageBookings') }}" class="block px-4 py-2 text-xs font-semibold text-black dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-md">
            Bookings
          </a>

          <a href="{{ route('memorySubmission') }}" class="block px-4 py-2 text-xs font-semibold text-black dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-md">
            Memory Submission
          </a>

        </div>
      </div>

    @endcan

    @can('Manage Teams')

      <div class="relative sidebar-dropdown"
          data-subtitle="Manage Teams"
          data-links='[
            {"label":"All Teams","href":"{{ url('/manage-teams') }}"}
          ]'>

        <button class="dropdown-toggle w-full flex items-center gap-3 p-2 rounded-lg dark:hover:bg-slate-800 transition-all">
          <div class="sidebar-icon-box">
            <i class="fa-solid fa-people-group"></i>
            <span class="sr-only test-black">Manage Teams</span>
          </div>
          <span class="sidebar-label flex-1 text-sm font-medium text-black dark:text-white text-left">
            Manage Teams
          </span>
          <i class="fas fa-chevron-down text-xs text-black sidebar-label"></i>
        </button>

        <div class="expanded-only hidden py-1 space-y-1">

          <a href="{{ url('/manage-teams') }}" class="block px-4 py-2 text-xs font-semibold text-black dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-md">
           All Teams
          </a>

        </div>
      </div>

    @endcan

    @can('Manage Events')

      <div class="relative sidebar-dropdown"
          data-subtitle="Manage Events"
          data-links='[
            {"label":"All Events","href":"{{ url('/manage-events') }}"}
          ]'>

        <button class="dropdown-toggle w-full flex items-center gap-3 p-2 rounded-lg dark:hover:bg-slate-800 transition-all">
          <div class="sidebar-icon-box">
            <i class="fa-regular fa-bookmark"></i>
            <span class="sr-only test-black">Manage Events</span>
          </div>
          <span class="sidebar-label flex-1 text-sm font-medium text-black dark:text-white text-left">
            Manage Events
          </span>
          <i class="fas fa-chevron-down text-xs text-black sidebar-label"></i>
        </button>

        <div class="expanded-only hidden py-1 space-y-1">

          <a href="{{ url('/manage-events') }}" class="block px-4 py-2 text-xs font-semibold text-black dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-md">
            All Events
          </a>

        </div>
      </div>

    @endcan

    @can('Manage Partners')

      <div class="relative sidebar-dropdown"
          data-subtitle="Partners"
          data-links='[
            {"label":"All Partners","href":"{{ url('/partners') }}"},
            {"label":"All Usefull Links","href":"{{ url('/usefull-links') }}"}
          ]'>

        <button class="dropdown-toggle w-full flex items-center gap-3 p-2 rounded-lg dark:hover:bg-slate-800 transition-all">
          <div class="sidebar-icon-box">
            <i class="fa-solid fa-handshake"></i>
            <span class="sr-only test-black">Partners</span>
          </div>
          <span class="sidebar-label flex-1 text-sm font-medium text-black dark:text-white text-left">
            Partners
          </span>
          <i class="fas fa-chevron-down text-xs text-black sidebar-label"></i>
        </button>

        <div class="expanded-only hidden py-1 space-y-1">

          <a href="{{ url('/partners') }}" class="block px-4 py-2 text-xs font-semibold text-black dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-md">
            All Partners
          </a>

          <a href="{{ url('/usefull-links') }}" class="block px-4 py-2 text-xs font-semibold text-black dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-md">
            All Usefull Links
          </a>

        </div>
      </div>

    @endcan

    @can('Manage Festivals')
      <div class="relative sidebar-dropdown"
          data-subtitle="Festivals"
          data-links='[
            {"label":"All Festivals","href":"{{ url('/all-festivals') }}"},
            {"label":"Speaker Types","href":"{{ url('/speaker-types') }}"},
            {"label":"Speakers","href":"{{ url('/all-speakers') }}"}

          ]'>

        <button class="dropdown-toggle w-full flex items-center gap-3 p-2 rounded-lg dark:hover:bg-slate-800 transition-all">
          <div class="sidebar-icon-box">
            <i class="fa-solid fa-pen-fancy"></i>
            <span class="sr-only test-black">Festivals</span>
          </div>
          <span class="sidebar-label flex-1 text-sm font-medium text-black dark:text-white text-left">
            Festivals
          </span>
          <i class="fas fa-chevron-down text-xs text-black sidebar-label"></i>
        </button>

        <div class="expanded-only hidden py-1 space-y-1">
          <a href="{{ url('/all-festivals') }}" class="block px-4 py-2 text-xs font-semibold text-black dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-md">
            All Festivals
          </a>

          <a href="{{ url('/speaker-types') }}" class="block px-4 py-2 text-xs font-semibold text-black dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-md">
            Speaker Types
          </a>

          <a href="{{ url('/all-speakers') }}" class="block px-4 py-2 text-xs font-semibold text-black dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-md">
            All Speakers
          </a>

        </div>
      </div>
    @endcan

    @can('Manage Users')
      <div class="relative sidebar-dropdown"
          data-subtitle="Users"
          data-links='[
          {"label":"Volunteers","href":"{{ url('/volunteers') }}"},
            {"label":"Registered list","href":"{{ url('registered-list') }}"},
            {"label":"Roles & Permissions","href":"{{ url('role-management') }}"},
            {"label":"System Managers","href":"{{ url('system-users') }}"}
          ]'>

        <button class="dropdown-toggle w-full flex items-center gap-3 p-2 rounded-lg dark:hover:bg-slate-800 transition-all">
          <div class="sidebar-icon-box">
            <i class="fas fa-users " aria-hidden="true"></i>
            <span class="sr-only">Users</span>
          </div>
          <span class="sidebar-label flex-1 text-sm font-medium text-black dark:text-white text-left">
            Users
          </span>
          <i class="fas fa-chevron-down text-xs text-gray-500 sidebar-label"></i>
        </button>

        <div class="expanded-only hidden py-1 space-y-1">

          <a href="{{ url('/volunteers') }}" class="block px-4 py-2 text-xs font-semibold text-black dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-md">
            Volunteers
          </a>

          <a href="{{ url('registered-list') }}" class="block px-4 py-2 text-xs font-semibold text-black dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-md">
           Registered list
          </a>

          <a href="{{ url('role-management') }}" class="block px-4 py-2 text-xs font-semibold text-black dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-md">
            Roles & Permissions
          </a>

          <a href="{{ url('system-users') }}" class="block px-4 py-2 text-xs font-semibold text-black dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-md">
            System Managers
          </a>
        </div>
      </div>
    @endcan

  </nav>
</aside>

<!-- Shared Sub Sidebar (Mini Mode) -->
<div id="subSidebar"
     class="fixed left-20 w-56 bg-white dark:bg-slate-800 shadow-xl border border-gray-200 dark:border-slate-700
            hidden flex-col z-[200] overflow-y-auto rounded-lg transition-all duration-200">
  <div class="px-4 py-3 border-b border-gray-200 dark:border-slate-700 flex items-center justify-between">
    <h3 id="subSidebarTitle" class="text-sm font-semibold text-black dark:text-white"></h3>
    <button id="closeSubSidebar" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xs">
      <i class="fas fa-times"></i>
    </button>
  </div>
  <div id="subSidebarLinks" class="py-2 max-h-[calc(100vh-60px)] overflow-y-auto"></div>
</div>


