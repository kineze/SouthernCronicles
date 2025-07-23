<aside id="sidebar"
       class="fixed top-0 left-0 h-full w-60 bg-white dark:bg-slate-900 shadow-xl
              transition-all duration-300 z-[100] overflow-hidden
              transform -translate-x-full lg:translate-x-0">

  <!-- Top Brand -->
  <div class="flex items-center justify-center px-3 h-20 border-b border-gray-500 dark:border-gray-700">
    <a href="{{ url('/') }}" class="relative flex items-center">
      <!-- Expanded: Light Logo -->
      <img
        src="/assets/img/nextep-logo.webp"
        alt="Nextep"
        class="sidebar-logo sidebar-logo-full block h-12 w-auto dark:hidden transition-opacity duration-200"
        loading="lazy"
      />
      <!-- Expanded: Dark Logo -->
      <img
        src="/assets/img/nextep-logo-dark.webp"
        alt="Nextep"
        class="sidebar-logo sidebar-logo-full hidden dark:block h-12 w-auto transition-opacity duration-200"
        loading="lazy"
      />
      <!-- Mini: Icon -->
      <img
        src="/assets/img/nextep-icon.webp"
        alt="Nextep Icon"
        class="sidebar-logo sidebar-logo-icon hidden h-9 w-9 transition-opacity duration-200"
        loading="lazy"
      />
    </a>
  </div>

  <!-- Nav -->
  <nav class="mt-4 space-y-1 px-3">


    @can('Manage Users')
    <!-- Users -->
    <div class="relative sidebar-dropdown"
         data-subtitle="Users"
         data-links='[
           {"label":"Roles & Permissions","href":"{{ url('role-management') }}"},
           {"label":"Teams & Groups","href":"{{ url('teams') }}"},
           {"label":"System Managers","href":"{{ url('system-users') }}"}
         ]'>

      <button class="dropdown-toggle w-full flex items-center gap-3 p-2 rounded-lg dark:hover:bg-slate-800 transition-all">
        <div class="sidebar-icon-box">
          <i class="fas fa-cog" aria-hidden="true"></i>
          <span class="sr-only">Users</span>
        </div>
        <span class="sidebar-label flex-1 text-sm font-medium text-gray-700 dark:text-white text-left">
          Users
        </span>
        <i class="fas fa-chevron-down text-xs text-gray-500 sidebar-label"></i>
      </button>

      <div class="expanded-only hidden py-1 space-y-1">
        <a href="{{ url('role-management') }}" class="block px-4 py-2 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-md">
          Roles & Permissions
        </a>
        <a href="{{ url('teams') }}" class="block px-4 py-2 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-md">
          Teams & Groups
        </a>
        <a href="{{ url('system-users') }}" class="block px-4 py-2 text-xs font-semibold text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-md">
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
    <h3 id="subSidebarTitle" class="text-sm font-semibold text-gray-700 dark:text-white"></h3>
    <button id="closeSubSidebar" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 text-xs">
      <i class="fas fa-times"></i>
    </button>
  </div>
  <div id="subSidebarLinks" class="py-2 max-h-[calc(100vh-60px)] overflow-y-auto"></div>
</div>


