<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8" />
  <title>{{ config('app.name', 'SmartBiz') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Favicon -->
  <link rel="icon" href="data:;base64,iVBORw0KGgo=">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
<!-- Add in your layout.blade.php inside <head> -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  @yield('head')

<style>
  /* Sidebar transitions for mobile */
  #sidebar {
    transition: transform 0.3s ease-in-out;
    transform: translateX(-100%);
    width: 16rem; /* 64 */
    flex-shrink: 0;
  }
  #sidebar.open {
    transform: translateX(0);
  }
  @media (min-width: 768px) {
    #sidebar {
      transform: none !important;
      position: relative !important;
    }
  }

  /* Scrollable main content */
  #mainContent {
    overflow-y: auto;
    max-height: calc(100vh - 64px - 48px); /* Adjust header/footer height as needed */
  }
</style>

</head>

<body class="bg-white text-gray-800">
  <div class="flex min-h-screen">

    <!-- Sidebar -->
    <nav id="sidebar"
         class="fixed top-0 left-0 h-screen bg-blue-900 text-white z-50 flex flex-col px-4 py-6 md:relative md:translate-x-0">

      <!-- Branding -->
      <div class="text-2xl font-bold text-center mb-6 mt-3 mr-6 tracking-wide">
        <h2>SmartBiz</h2>
      </div>

      <ul class="space-y-6 flex-grow">
        @auth
        @php $role = Auth::user()->role; @endphp

        @if($role === 'admin')
        <li>
          <h4 class="text-sm uppercase text-blue-200 font-semibold mb-2 px-2">Mr.{{ Auth::user()->name }}'s Menu</h4>
          <ul class="space-y-2">

            <!-- Dashboard -->
            <li>
              <a href="{{ route('admin.dashboard') }}"
                 class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-800' : '' }}">
                <i class="fas fa-chart-line w-5"></i> Dashboard
              </a>
            </li>

            <!-- Inventory -->
            <li>
              <div class="px-4 text-blue-100 text-xs uppercase font-semibold mt-4 mb-2">Inventory</div>
              <ul class="space-y-1 pl-4 border-l border-blue-700">
                <li>
                  <a href="{{ route('inventory.upload.form') }}"
                     class="flex items-center gap-3 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('inventory.upload.form') ? 'bg-blue-800' : '' }}">
                    <i class="fas fa-file-upload w-5"></i> Upload Inventory
                  </a>
                </li>
                <li>
                  <a href="/inventory/listings"
                     class="flex items-center gap-3 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('inventory.list') ? 'bg-blue-800' : '' }}">
                    <i class="fas fa-boxes w-5"></i> Inventory Listings
                  </a>
                </li>
                <li>
                  <a href="{{ route('inventory.adjust.form') }}"
                     class="flex items-center gap-3 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('inventory.adjust.form') ? 'bg-blue-800' : '' }}">
                    <i class="fas fa-edit w-5"></i> Adjust Inventory
                  </a>
                </li>
                <li>
                  <a href="{{ route('inventory.history') }}"
                     class="flex items-center gap-3 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('inventory.history') ? 'bg-blue-800' : '' }}">
                    <i class="fas fa-history w-5"></i> Inventory History
                  </a>
                </li>
              </ul>
            </li>

            <!-- Employees -->
            <li>
              <a href="{{ route('admin.employees.create') }}"
                 class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('admin.employees.create') ? 'bg-blue-800' : '' }}">
                <i class="fas fa-users w-5"></i> Employees
              </a>
            </li>

              <li>
              <a href="{{ route('admin.sales.create') }}"
                 class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('admin.sales.create') ? 'bg-blue-800' : '' }}">
                <i class="fas fa-plus-circle w-5"></i> Record Sale
              </a>
        <li>
  <a href="{{ route('credit.sales.index') }}"
     class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('credit.sales.index') ? 'bg-blue-800 text-white' : 'text-gray-200' }}">
    <i class="bi bi-plus-circle-fill text-lg"></i>
    <span>Credit Sale</span>
  </a>
</li>

{{-- <li>
  <a href="{{ route('admin.stocks.purchase') }}"
     class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('admin.stock.create') ? 'bg-blue-800 text-white' : 'text-white/80' }}">
    <i class="fas fa-boxes-stacked w-5"></i>
    Record New Stock
  </a>
</li> --}}
<li>
  <a href="/report-dashboard"
     class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('reports.admins') ? 'bg-blue-800 text-white' : 'text-white/80' }}">
    <i class="fas fa-boxes-stacked w-5"></i>
Business Reports
  </a>
</li>

            <!-- Sales Report -->
        <li>
              <a href="/admin/operational-costs"
                 class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('admin.sales') ? 'bg-blue-800' : '' }}">
                <i class="fas fa-receipt w-5"></i>Record business cost
              </a>
            </li> 
<li>

</li>
            <!-- View Messages -->
            <li>
              <a href="{{ route('admin.messages.index') }}"
                 class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('employee.messages.create') ? 'bg-blue-800' : '' }}">
                <i class="fas fa-envelope w-5"></i> View Messages
              </a>
            </li>
          </ul>
        </li>

        @elseif($role === 'employee')
        <li>
          <h4 class="text-sm uppercase text-blue-200 font-semibold mb-2 px-2">Employee Menu</h4>
          <ul class="space-y-2">
            <li>
              <a href="{{ route('employee.dashboard') }}"
                 class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('employee.dashboard') ? 'bg-blue-800' : '' }}">
                <i class="fas fa-chart-pie w-5"></i> Dashboard
              </a>
            </li>
            <li>
              <a href="{{ route('employee.sales.create') }}"
                 class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('employee.sales.create') ? 'bg-blue-800' : '' }}">
                <i class="fas fa-plus-circle w-5"></i> Record Sale
              </a>
            </li>
            <li>
              <a href="{{ route('employee.sales.history') }}"
                 class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('employee.sales.history') ? 'bg-blue-800' : '' }}">
                <i class="fas fa-history w-5"></i> Sales History
              </a>
            </li>
            <li>
              <a href="{{ route('employee.prices') }}"
                 class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('employee.prices') ? 'bg-blue-800' : '' }}">
                <i class="fas fa-tags w-5"></i> Product Prices
              </a>
            </li>
            <li>
              <a href="{{ route('chat.index') }}"
                 class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('employee.messages.create') ? 'bg-blue-800' : '' }}">
                <i class="fas fa-envelope w-5"></i> Send Message
              </a>
            </li>
          </ul>
        </li>
        @endif

        @else
        <!-- Guest -->
        <li>
          <h4 class="text-sm uppercase text-blue-200 font-semibold mb-2 px-2">Guest</h4>
          <a href="{{ route('login') }}"
             class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800">
            <i class="fas fa-sign-in-alt w-5"></i> Login
          </a>
        </li>
        @endauth
      </ul>
    </nav>

  <!-- Main content area with flex-grow to fill remaining space -->
<div class="flex-1 flex flex-col min-h-screen">

  <!-- Header -->
  <header class="flex items-center justify-between px-6 py-4 border-b bg-white shadow-sm sticky top-0 z-40">
    <div class="flex items-center gap-4">

      <!-- Hamburger menu for mobile -->
      <button id="sidebarToggle" class="md:hidden text-gray-700 hover:text-gray-900 focus:outline-none" aria-label="Toggle Sidebar">
        <i class="fas fa-bars text-xl"></i>
      </button>

      <div class="text-xl font-semibold">SmartBiz</div>
    </div>

    <div class="flex items-center justify-end w-full gap-4">
      <!-- Dark mode toggle button -->
      <button id="darkModeToggle" title="Toggle Dark Mode"
              class="text-xl text-gray-600 hover:text-gray-900 focus:outline-none">
        <i class="fas fa-moon"></i>
      </button>

      @auth
      <!-- Removed hidden sm:inline to always show username -->
      <span class="text-sm text-gray-700">{{ Auth::user()->name }}</span>

      <form action="{{ route('logout') }}" method="POST" class="inline">
        @csrf
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
          Logout
        </button>
      </form>
      @else
      <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
        Login
      </a>
      @endauth
    </div>
  </header>

  <!-- Content -->
  <main id="mainContent" class="flex-grow p-6 bg-gray-50 transition-colors duration-300">
    @yield('content')
  </main>
  <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 text-center text-sm text-gray-600 dark:text-gray-300 py-4">
        <div class="container mx-auto px-4">
          &copy; {{ date('Y') }} SmartBiz. All rights reserved.
        </div>
      </footer>
</div>


  <!-- Scripts -->
  <script>
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainContent = document.getElementById('mainContent');

    // Toggle sidebar open/close on small screens
    sidebarToggle.addEventListener('click', (e) => {
      e.stopPropagation(); // Prevent event bubbling
      sidebar.classList.toggle('open');
    });

    // Close sidebar when clicking outside on small screens
    document.addEventListener('click', (e) => {
      // If sidebar is open and click is outside sidebar & toggle button
      if (sidebar.classList.contains('open') && !sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
        sidebar.classList.remove('open');
      }
    });

    // Dark mode toggle for content area only
    document.getElementById('darkModeToggle').addEventListener('click', () => {
      if(mainContent.classList.contains('bg-gray-900')) {
        // Switch to light mode
        mainContent.classList.remove('bg-gray-900', 'text-white');
        mainContent.classList.add('bg-gray-50', 'text-gray-900');
      } else {
        // Switch to dark mode
        mainContent.classList.remove('bg-gray-50', 'text-gray-900');
        mainContent.classList.add('bg-gray-900', 'text-white');
      }
    });
  </script>
  <!-- Add this before </body> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>


{{--

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>{{ config('app.name', 'SmartBiz') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Favicon -->
  <link rel="icon" href="data:;base64,iVBORw0KGgo="> <!-- Placeholder favicon -->

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <!-- Hide Alpine.js elements until loaded -->
  <style>
    [x-cloak] { display: none; }
  </style>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Blade Section for Child Views -->
  @yield('head')
</head>


<body class="bg-white text-gray-800" data-theme="light">
  <div class="flex mr-0 min-h-screen">

    <!-- Overlay for Mobile Sidebar -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-30 z-40 hidden md:hidden" onclick="closeSidebar()"></div>

    <!-- Sidebar -->
    <nav id="sidebar"
         class="fixed md:relative top-0 left-0 h-screen w-64 bg-blue-900 text-white transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50 flex flex-col px-4 py-6">

      <!-- Branding -->
      <div class="text-2xl font-bold text-center mb-6 mt-3 mr-6 tracking-wide">
        <h2>SmartBiz</h2>
      </div>

      <ul class="space-y-6 flex-grow">
        @auth
        @php $role = Auth::user()->role; @endphp

        @if($role === 'admin')
        <li>
          <h4 class="text-sm uppercase text-blue-200 font-semibold mb-2 px-2">Admin Menu</h4>
          <ul class="space-y-2">

            <!-- Dashboard -->
            <li>
              <a onclick="closeSidebar()" href="{{ route('admin.dashboard') }}"
                 class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-800' : '' }}">
                <i class="fas fa-chart-line w-5"></i> Dashboard
              </a>
            </li>

            <!-- Inventory -->
            <li>
              <div class="px-4 text-blue-100 text-xs uppercase font-semibold mt-4 mb-2">Inventory</div>
              <ul class="space-y-1 pl-4 border-l border-blue-700">
                <li>
                  <a onclick="closeSidebar()" href="{{ route('inventory.upload.form') }}"
                     class="flex items-center gap-3 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('inventory.upload.form') ? 'bg-blue-800' : '' }}">
                    <i class="fas fa-file-upload w-5"></i> Upload Inventory
                  </a>
                </li>
                <li>
                  <a onclick="closeSidebar()" href="/inventory/listings"
                     class="flex items-center gap-3 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('inventory.index') ? 'bg-blue-800' : '' }}">
                    <i class="fas fa-boxes w-5"></i> Inventory Listings
                  </a>
                </li>
                <li>
                  <a onclick="closeSidebar()" href="{{ route('inventory.adjust.form') }}"
                     class="flex items-center gap-3 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('inventory.adjust.form') ? 'bg-blue-800' : '' }}">
                    <i class="fas fa-edit w-5"></i> Adjust Inventory
                  </a>
                </li>
                <li>
                  <a onclick="closeSidebar()" href="{{ route('inventory.history') }}"
                     class="flex items-center gap-3 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('inventory.history') ? 'bg-blue-800' : '' }}">
                    <i class="fas fa-history w-5"></i> Inventory History
                  </a>
                </li>
              </ul>
            </li>

            <!-- Employees -->
            <li>
              <a onclick="closeSidebar()" href="{{ route('admin.employees.create') }}"
                 class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('admin.employees') ? 'bg-blue-800' : '' }}">
                <i class="fas fa-users w-5"></i> Employees
              </a>
            </li>

            <!-- Sales Report -->
            <li>
              <a onclick="closeSidebar()" href="{{ route('sales.report') }}"
                 class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('admin.sales') ? 'bg-blue-800' : '' }}">
                <i class="fas fa-receipt w-5"></i> Sales Report
              </a>
            </li>

            <!-- View Messages -->
            <li>
              <a onclick="closeSidebar()" href="{{ route('admin.messages.index') }}"
                 class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('employee.messages.create') ? 'bg-blue-800' : '' }}">
                <i class="fas fa-envelope w-5"></i> View Messages
              </a>
            </li>
          </ul>
        </li>

        @elseif($role === 'employee')
        <li>
          <h4 class="text-sm uppercase text-blue-200 font-semibold mb-2 px-2">Employee Menu</h4>
          <ul class="space-y-2">
            <li>
              <a onclick="closeSidebar()" href="{{ route('employee.dashboard') }}"
                 class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('employee.dashboard') ? 'bg-blue-800' : '' }}">
                <i class="fas fa-chart-pie w-5"></i> Dashboard
              </a>
            </li>
            <li>
              <a onclick="closeSidebar()" href="{{ route('employee.sales.create') }}"
                 class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('employee.sales.create') ? 'bg-blue-800' : '' }}">
                <i class="fas fa-plus-circle w-5"></i> Record Sale
              </a>
            </li>
            <li>
              <a onclick="closeSidebar()" href="{{ route('employee.sales.history') }}"
                 class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('employee.sales.history') ? 'bg-blue-800' : '' }}">
                <i class="fas fa-history w-5"></i> Sales History
              </a>
            </li>
            <li>
              <a onclick="closeSidebar()" href="{{ route('employee.prices') }}"
                 class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('employee.prices') ? 'bg-blue-800' : '' }}">
                <i class="fas fa-tags w-5"></i> Product Prices
              </a>
            </li>
            <li>
              <a onclick="closeSidebar()" href="{{ route('chat.index') }}"
                 class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800 {{ request()->routeIs('employee.messages.create') ? 'bg-blue-800' : '' }}">
                <i class="fas fa-envelope w-5"></i> Send Message
              </a>
            </li>
          </ul>
        </li>
        @endif

        @else
        <!-- Guest -->
        <li>
          <h4 class="text-sm uppercase text-blue-200 font-semibold mb-2 px-2">Guest</h4>
          <a onclick="closeSidebar()" href="{{ route('login') }}"
             class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-blue-800">
            <i class="fas fa-sign-in-alt w-5"></i> Login
          </a>
        </li>
        @endauth
      </ul>
    </nav>

    <!-- Main content -->
    <div class="flex-1 ml-0 md:ml-64 flex flex-col min-h-screen">

      <!-- Header -->
      <header class="flex items-center justify-between px-6 py-4 border-b bg-white shadow-sm">
        <button class="text-2xl md:hidden text-gray-700" onclick="toggleSidebar()">
          <i class="fas fa-bars"></i>
        </button>

        <div class="flex items-center justify-end w-full gap-4">
          <button onclick="toggleTheme()" title="Toggle Dark Mode"
                  class="text-xl text-gray-600 hover:text-gray-900">
            <i class="fas fa-moon"></i>
          </button>

          @auth
          <span class="text-sm text-gray-700 hidden sm:inline">Welcome, {{ Auth::user()->name }}</span>
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
              Logout
            </button>
          </form>
          @else
          <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
            Login
          </a>
          @endauth
        </div>
      </header>

      <!-- Content -->
      <main class="flex-1 p-6 bg-gray-50">
        @yield('content')
      </main>
    </div>
  </div>

  <!-- Scripts -->
  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const overlay = document.getElementById('overlay');
      const isOpen = sidebar.classList.contains('-translate-x-full');
      sidebar.classList.toggle('-translate-x-full');
      overlay.classList.toggle('hidden', !isOpen);
    }

    function closeSidebar() {
      document.getElementById('sidebar').classList.add('-translate-x-full');
      document.getElementById('overlay').classList.add('hidden');
    }

    function toggleTheme() {
      const body = document.body;
      const current = body.getAttribute('data-theme');
      const isDark = current === 'dark';
      body.setAttribute('data-theme', isDark ? 'light' : 'dark');
      body.classList.toggle('bg-white', isDark);
      body.classList.toggle('bg-gray-900', !isDark);
      body.classList.toggle('text-gray-800', isDark);
      body.classList.toggle('text-white', !isDark);
    }
  </script>
</body>
</html> --}}
