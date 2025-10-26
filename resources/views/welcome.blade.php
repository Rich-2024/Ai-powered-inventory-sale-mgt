<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SmartBiz – Advanced Business Management System</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    * {
      font-family: 'Inter', sans-serif;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-20px); }
    }

    @keyframes pulse-glow {
      0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.3); }
      50% { box-shadow: 0 0 40px rgba(59, 130, 246, 0.6); }
    }

    @keyframes slide-in-left {
      from { opacity: 0; transform: translateX(-50px); }
      to { opacity: 1; transform: translateX(0); }
    }

    @keyframes slide-in-right {
      from { opacity: 0; transform: translateX(50px); }
      to { opacity: 1; transform: translateX(0); }
    }

    @keyframes fade-in-up {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes scale-in {
      from { opacity: 0; transform: scale(0.8); }
      to { opacity: 1; transform: scale(1); }
    }

    @keyframes gradient-shift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .animate-float { animation: float 6s ease-in-out infinite; }
    .animate-pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }
    .animate-slide-in-left { animation: slide-in-left 0.8s ease-out forwards; }
    .animate-slide-in-right { animation: slide-in-right 0.8s ease-out forwards; }
    .animate-fade-in-up { animation: fade-in-up 0.8s ease-out forwards; }
    .animate-scale-in { animation: scale-in 0.6s ease-out forwards; }
    .animate-gradient { animation: gradient-shift 8s ease infinite; }

    .gradient-bg {
      background: linear-gradient(-45deg, #667eea, #764ba2, #f093fb, #f5576c);
      background-size: 400% 400%;
    }

    .glass-effect {
      backdrop-filter: blur(20px);
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .card-hover {
      transition: all 0.3s ease;
    }

    .card-hover:hover {
      transform: translateY(-10px) scale(1.02);
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }

    .text-gradient {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .btn-gradient {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      transition: all 0.3s ease;
    }

    .btn-gradient:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    }

    .feature-icon {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .mobile-menu {
      transform: translateX(100%);
      transition: transform 0.3s ease-in-out;
    }

    .mobile-menu.open {
      transform: translateX(0);
    }

    .overlay {
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }

    .overlay.active {
      opacity: 1;
      visibility: visible;
    }

    .stats-counter {
      font-variant-numeric: tabular-nums;
    }

    .workflow-step {
      opacity: 0;
      transform: translateY(20px);
      transition: all 0.6s ease;
    }

    .workflow-step.visible {
      opacity: 1;
      transform: translateY(0);
    }
  </style>
</head>
<body class="min-h-screen bg-gray-50">
  <!-- Navigation -->
  <nav class="fixed w-full z-50 bg-white/95 backdrop-blur-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <div class="flex items-center space-x-3">
          <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
            <i class="bi bi-graph-up text-white text-xl"></i>
          </div>
          <span class="text-2xl font-bold text-gradient">SmartBiz</span>
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center space-x-8">
          <a href="#home" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Home</a>
          <a href="#features" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Features</a>
          <a href="#workflow" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Workflow</a>
          <a href="#pricing" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Pricing</a>
          <a href="#contact" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Contact</a>
<a href="{{ route('register') }}" class="btn-gradient text-white px-6 py-2 rounded-lg font-semibold text-center inline-block">
  Get Started
</a>
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>
    </div>
  </nav>

  <!-- Mobile Menu Overlay -->
  <div id="mobile-overlay" class="overlay fixed inset-0 bg-black/50 z-40 md:hidden"></div>

  <!-- Mobile Menu Sidebar -->
  <div id="mobile-menu" class="mobile-menu fixed top-0 right-0 h-full w-80 bg-white shadow-2xl z-50 md:hidden">
    <div class="p-6">
      <div class="flex items-center justify-between mb-8">
        <div class="flex items-center space-x-3">
          <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
            <i class="bi bi-graph-up text-white text-lg"></i>
          </div>
          <span class="text-xl font-bold text-gradient">SmartBiz</span>
        </div>
        <button id="close-menu" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>

      <nav class="space-y-4">
        <a href="#home" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 transition-colors">
          <i class="bi bi-house text-blue-600"></i>
          <span class="font-medium">Home</span>
        </a>
        <a href="#features" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 transition-colors">
          <i class="bi bi-star text-blue-600"></i>
          <span class="font-medium">Features</span>
        </a>
        <a href="#workflow" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 transition-colors">
          <i class="bi bi-diagram-3 text-blue-600"></i>
          <span class="font-medium">Workflow</span>
        </a>
        <a href="#pricing" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 transition-colors">
          <i class="bi bi-currency-dollar text-blue-600"></i>
          <span class="font-medium">Pricing</span>
        </a>
        <a href="#contact" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-100 transition-colors">
          <i class="bi bi-envelope text-blue-600"></i>
          <span class="font-medium">Contact</span>
        </a>
      </nav>

      <div class="mt-8 pt-8 border-t border-gray-200">
<a href="{{ route('register') }}" class="w-full btn-gradient text-white py-3 rounded-lg font-semibold text-center block">
  Get Started
</a>
      </div>
    </div>
  </div>

  <!-- Hero Section -->
  <section id="home" class="pt-20 pb-16 gradient-bg animate-gradient min-h-screen flex items-center">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid lg:grid-cols-2 gap-12 items-center">
        <div class="text-center lg:text-left">
          <div class="animate-fade-in-up">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-7 leading-tight">
              Transform Your
              <span class="block text-yellow-300">Business Operations</span>
            </h1>
            <p class="text-xl text-white/90 mb-8 leading-relaxed">
              SmartBiz revolutionizes how small businesses manage sales, inventory, and analytics with our intelligent, user-friendly platform designed for modern entrepreneurs.
            </p>
          </div>

          <div class="animate-slide-in-left flex flex-col sm:flex-row gap-4 mb-12">
             <a href="{{ route('tot') }}" class="bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-100 transition-all duration-300 transform hover:scale-105 flex items-center justify-center">
    <i class="bi bi-play-circle mr-2"></i>
     Terms & condition
  </a>

             <a href="{{ route('login') }}" class="glass-effect text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-white/20 transition-all duration-300 flex items-center justify-center">
    <i class="bi bi-camera-video mr-2"></i>
    Login
  </a>>
          </div>

          <!-- Stats -->
          <div class="animate-slide-in-right grid grid-cols-3 gap-8 text-center">
            <div>
              <div class="text-3xl font-bold text-white stats-counter" data-target="10000">0</div>
              <div class="text-white/80 text-sm">Active Users</div>
            </div>
            <div>
              <div class="text-3xl font-bold text-white stats-counter" data-target="99">0</div>
              <div class="text-white/80 text-sm">Uptime %</div>
            </div>
            <div>
              <div class="text-3xl font-bold text-white stats-counter" data-target="24">0</div>
              <div class="text-white/80 text-sm">Support Hours</div>
            </div>
          </div>
        </div>

        <div class="animate-float">
          <div class="relative">
            <div class="glass-effect rounded-2xl p-8 animate-pulse-glow">
              <div class="bg-white rounded-xl p-6 shadow-2xl">
                <div class="flex items-center justify-between mb-6">
  <h3 class="text-xl font-bold text-gray-800 mb-4">Sales Dashboard Overview</h3>
                  <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                </div>
                <div class="space-y-4">
               <div class="flex justify-between items-center">
  <span class="text-gray-600">Today's Sales</span>
  <span class="font-bold text-green-600">2m</span>
</div>

<div class="flex justify-between items-center mt-2">
  <span class="text-gray-600">Products Sold</span>
  <span class="font-bold text-blue-600">156</span>
</div>

<div class="mt-4">
  <span class="text-gray-600 block mb-2">Most Sold Products</span>
  <ul class="list-disc list-inside text-purple-600 font-bold space-y-1">
    <li>Hisense 32 inches – 23 units</li>
    <li>Hoofers inches – 50 units</li>
    <li>iPhone 14 Pro Max – 13 units</li>
  </ul>
</div>

                  <div class="bg-gray-200 rounded-full h-2 mt-4">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2 rounded-full w-3/4"></div>
                  </div>
                  <p class="text-sm text-gray-500">75% of monthly goal achieved</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section id="features" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16 animate-fade-in-up">
        <h2 class="text-4xl font-bold text-gray-900 mb-4">Powerful Features for Modern Business</h2>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">Discover how SmartBiz streamlines your operations with cutting-edge tools designed for efficiency and growth.</p>
      </div>

      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="card-hover bg-white p-8 rounded-2xl shadow-lg border border-gray-100 animate-scale-in">
          <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6">
            <i class="bi bi-cart-check-fill text-white text-2xl"></i>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-4">Smart Sales Recording</h3>
          <p class="text-gray-600 mb-6">Effortlessly record sales with intelligent auto-calculations, barcode scanning, and comprehensive transaction histories.</p>
          <ul class="space-y-2 text-sm text-gray-500">
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-2"></i>Barcode scanning</li>
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-2"></i>Auto-calculations</li>
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-2"></i>Transaction history</li>
          </ul>
        </div>

        <div class="card-hover bg-white p-8 rounded-2xl shadow-lg border border-gray-100 animate-scale-in" style="animation-delay: 0.2s;">
          <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6">
            <i class="bi bi-box-seam-fill text-white text-2xl"></i>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-4">Inventory Management</h3>
          <p class="text-gray-600 mb-6">Manage your products with real-time stock tracking, automated reorder alerts, and comprehensive product catalogs.</p>
          <ul class="space-y-2 text-sm text-gray-500">
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-2"></i>Real-time tracking</li>
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-2"></i>Low stock alerts</li>
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-2"></i>Product categories</li>
          </ul>
        </div>

        <div class="card-hover bg-white p-8 rounded-2xl shadow-lg border border-gray-100 animate-scale-in" style="animation-delay: 0.4s;">
          <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6">
            <i class="bi bi-bar-chart-line-fill text-white text-2xl"></i>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-4">Advanced Analytics</h3>
          <p class="text-gray-600 mb-6">Generate detailed reports with interactive charts, trend analysis, and performance insights to drive business growth.</p>
          <ul class="space-y-2 text-sm text-gray-500">
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-2"></i>Interactive charts</li>
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-2"></i>Trend analysis</li>
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-2"></i>Custom reports</li>
          </ul>
        </div>

        <div class="card-hover bg-white p-8 rounded-2xl shadow-lg border border-gray-100 animate-scale-in" style="animation-delay: 0.6s;">
          <div class="w-16 h-16 bg-gradient-to-r from-red-500 to-red-600 rounded-2xl flex items-center justify-center mb-6">
            <i class="bi bi-people-fill text-white text-2xl"></i>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-4">Team Management</h3>
          <p class="text-gray-600 mb-6">Manage employee access, track individual performance, and streamline team communication with built-in messaging.</p>
          <ul class="space-y-2 text-sm text-gray-500">
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-2"></i>Role-based access</li>
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-2"></i>Performance tracking</li>
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-2"></i>Internal messaging</li>
          </ul>
        </div>

        <div class="card-hover bg-white p-8 rounded-2xl shadow-lg border border-gray-100 animate-scale-in" style="animation-delay: 0.8s;">
          <div class="w-16 h-16 bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl flex items-center justify-center mb-6">
            <i class="bi bi-shield-check-fill text-white text-2xl"></i>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-4">Security & Backup</h3>
          <p class="text-gray-600 mb-6">Enterprise-grade security with encrypted data storage, automated backups, and comprehensive audit trails.</p>
          <ul class="space-y-2 text-sm text-gray-500">
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-2"></i>Data encryption</li>
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-2"></i>Auto backups</li>
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-2"></i>Audit trails</li>
          </ul>
        </div>

        <div class="card-hover bg-white p-8 rounded-2xl shadow-lg border border-gray-100 animate-scale-in" style="animation-delay: 1s;">
          <div class="w-16 h-16 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-6">
            <i class="bi bi-phone-fill text-white text-2xl"></i>
          </div>
          <h3 class="text-2xl font-bold text-gray-900 mb-4">Mobile Ready</h3>
          <p class="text-gray-600 mb-6">Access your business data anywhere with our responsive design and dedicated mobile apps for iOS and Android.</p>
          <ul class="space-y-2 text-sm text-gray-500">
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-2"></i>Responsive design</li>
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-2"></i>Mobile apps</li>
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-2"></i>Offline mode</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- Workflow Section -->
  <section id="workflow" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="text-4xl font-bold text-gray-900 mb-4">Streamlined Workflow Process</h2>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">Follow our simple 5-step process to transform your business operations and boost productivity.</p>
      </div>

      <div class="relative">
        <!-- Workflow Steps -->
        <div class="space-y-12">
          <div class="workflow-step flex items-center">
            <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-xl mr-8">
              1
            </div>
            <div class="flex-1 bg-white p-8 rounded-2xl shadow-lg">
              <div class="flex items-start">
                <div class="mr-6">
                  <i class="bi bi-person-fill-check text-4xl text-blue-600"></i>
                </div>
                <div>
                  <h3 class="text-2xl font-bold text-gray-900 mb-3">Admin Setup & Configuration</h3>
                  <p class="text-gray-600 text-lg leading-relaxed">Administrators create employee accounts, configure system settings, and upload comprehensive product catalogs with pricing and inventory details.</p>
                </div>
              </div>
            </div>
          </div>

          <div class="workflow-step flex items-center flex-row-reverse">
            <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-r from-purple-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-xl ml-8">
              2
            </div>
            <div class="flex-1 bg-white p-8 rounded-2xl shadow-lg">
              <div class="flex items-start flex-row-reverse">
                <div class="ml-6">
                  <i class="bi bi-person-lines-fill text-4xl text-purple-600"></i>
                </div>
                <div class="text-right">
                  <h3 class="text-2xl font-bold text-gray-900 mb-3">Employee Authentication</h3>
                  <p class="text-gray-600 text-lg leading-relaxed">Team members securely log in using their assigned credentials with role-based access controls and personalized dashboards.</p>
                </div>
              </div>
            </div>
          </div>

          <div class="workflow-step flex items-center">
            <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-r from-green-500 to-green-600 rounded-full flex items-center justify-center text-white font-bold text-xl mr-8">
              3
            </div>
            <div class="flex-1 bg-white p-8 rounded-2xl shadow-lg">
              <div class="flex items-start">
                <div class="mr-6">
                  <i class="bi bi-pencil-square text-4xl text-green-600"></i>
                </div>
                <div>
                  <h3 class="text-2xl font-bold text-gray-900 mb-3">Intuitive Sales Entry</h3>
                  <p class="text-gray-600 text-lg leading-relaxed">Record sales transactions through our user-friendly interface with barcode scanning, automatic calculations, and instant inventory updates.</p>
                </div>
              </div>
            </div>
          </div>

          <div class="workflow-step flex items-center flex-row-reverse">
            <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-r from-red-500 to-red-600 rounded-full flex items-center justify-center text-white font-bold text-xl ml-8">
              4
            </div>
            <div class="flex-1 bg-white p-8 rounded-2xl shadow-lg">
              <div class="flex items-start flex-row-reverse">
                <div class="ml-6">
                  <i class="bi bi-graph-up-arrow text-4xl text-red-600"></i>
                </div>
                <div class="text-right">
                  <h3 class="text-2xl font-bold text-gray-900 mb-3">Real-time Analytics</h3>
                  <p class="text-gray-600 text-lg leading-relaxed">Administrators access comprehensive reports, performance metrics, and business insights with interactive charts and trend analysis.</p>
                </div>
              </div>
            </div>
          </div>

          <div class="workflow-step flex items-center">
            <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-xl mr-8">
              5
            </div>
            <div class="flex-1 bg-white p-8 rounded-2xl shadow-lg">
              <div class="flex items-start">
                <div class="mr-6">
                  <i class="bi bi-envelope-paper text-4xl text-indigo-600"></i>
                </div>
                <div>
                  <h3 class="text-2xl font-bold text-gray-900 mb-3">Seamless Communication</h3>
                  <p class="text-gray-600 text-lg leading-relaxed">Built-in messaging system enables direct communication between employees and administrators for requests, updates, and collaboration.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Pricing Section -->
  <section id="pricing" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="text-4xl font-bold text-gray-900 mb-4">Choose Your Plan</h2>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">Flexible pricing options designed to grow with your business needs.</p>
      </div>

      <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-200 card-hover">
          <div class="text-center mb-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Starter</h3>
<div class="text-4xl font-bold text-gray-900 mb-2">
  20,000 UGX<span class="text-lg text-gray-500">/month</span>
  <div class="text-sm text-gray-500">(≈ $5.26 USD)</div>
</div>
            <p class="text-gray-600">Perfect for small businesses</p>
          </div>
          <ul class="space-y-4 mb-8">
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-3"></i>Up to 5 employees</li>
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-3"></i>Basic reporting</li>
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-3"></i>Email support</li>
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-3"></i>Acess full time anywhere you Go</li>
          </ul>
<a href="{{ route('register') }}" class="w-full bg-gray-900 text-white py-3 rounded-lg font-semibold hover:bg-gray-800 transition-colors text-center block">
  Get Started
</a>
        </div>

        <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-8 rounded-2xl shadow-2xl text-white card-hover relative">
          <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-yellow-400 text-gray-900 px-4 py-1 rounded-full text-sm font-semibold">
            Most Popular
          </div>
          <div class="text-center mb-8">
            <h3 class="text-2xl font-bold mb-2">Professional</h3>
<div class="text-4xl font-bold mb-2">
  240,000 UGX<span class="text-lg opacity-80">/month</span>
  <div class="text-sm text-gray-500">(≈ $63.00 USD)</div>
</div>
            <p class="opacity-90">Ideal for growing businesses</p>
          </div>
          <ul class="space-y-4 mb-8">
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-yellow-400 mr-3"></i>Up to 25 employees</li>
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-yellow-400 mr-3"></i>Advanced analytics</li>
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-yellow-400 mr-3"></i>Priority support</li>
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-yellow-400 mr-3"></i>API access</li>
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-yellow-400 mr-3"></i>Full Time Acess Right</li>
          </ul>
<a href="{{ route('register') }}" class="w-full bg-white text-blue-600 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors text-center block">
  Get Started
</a>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-200 card-hover">
          <div class="text-center mb-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Enterprise</h3>
<div class="text-4xl font-bold text-gray-900 mb-2">
  250,000 UGX<span class="text-lg text-gray-500">/month</span>
  <div class="text-sm text-gray-500">(≈ $66 USD)</div>
</div>
            <p class="text-gray-600">For large organizations</p>
          </div>
          <ul class="space-y-4 mb-8">
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-3"></i>Unlimited employees</li>
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-3"></i>Custom reporting</li>
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-3"></i>24/7 phone support</li>
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-3"></i>White-label options</li>
            <li class="flex items-center"><i class="bi bi-check-circle-fill text-green-500 mr-3"></i>Dedicated account manager</li>
          </ul>
          <button class="w-full bg-gray-900 text-white py-3 rounded-lg font-semibold hover:bg-gray-800 transition-colors">Contact Sales</button>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-16">
        <h2 class="text-4xl font-bold text-gray-900 mb-4">Get in Touch</h2>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">Ready to transform your business? Contact our team for a personalized demo and consultation.</p>
      </div>

      <div class="grid lg:grid-cols-2 gap-12">
        <div>
          <div class="bg-white p-8 rounded-2xl shadow-lg">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Send us a message</h3>
            <form class="space-y-6">
              <div class="grid md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                  <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                  <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Company</label>
                <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                <textarea rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
              </div>
              <button type="submit" class="w-full btn-gradient text-white py-3 rounded-lg font-semibold">Send Message</button>
            </form>
          </div>
        </div>

        <div class="space-y-8">
          <div class="bg-white p-6 rounded-2xl shadow-lg">
            <div class="flex items-start space-x-4">
              <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-envelope text-blue-600 text-xl"></i>
              </div>
              <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-1">Email Us</h4>
                <p class="text-gray-600">richardogwal97@gmail.com</p>
                <p class="text-gray-600">support@smartbiz.com</p>
              </div>
            </div>
          </div>

          <div class="bg-white p-6 rounded-2xl shadow-lg">
            <div class="flex items-start space-x-4">
              <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-telephone text-green-600 text-xl"></i>
              </div>
              <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-1">Call Us</h4>
                <p class="text-gray-600">+256787860378</p>
                <p class="text-gray-600">Mon-Fri 9AM-6PM EST</p>
              </div>
            </div>
          </div>

          <div class="bg-white p-6 rounded-2xl shadow-lg">
            <div class="flex items-start space-x-4">
              <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-geo-alt text-purple-600 text-xl"></i>
              </div>
              <div>
                <h4 class="text-lg font-semibold text-gray-900 mb-1">Visit Us</h4>
                <p class="text-gray-600"> along Makerere University Rd </p>
                <p class="text-gray-600">Kampala Uganda</p>
              </div>
            </div>
          </div>

          <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-6 rounded-2xl text-white">
            <h4 class="text-lg font-semibold mb-2">Ready to get started?</h4>
            <p class="mb-4 opacity-90">Join thousands of businesses already using SmartBiz to streamline their operations.</p>
            <button class="bg-white text-blue-600 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
              Start Free Trial
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid md:grid-cols-4 gap-8 mb-8">
        <div>
          <div class="flex items-center space-x-3 mb-4">
            <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
              <i class="bi bi-graph-up text-white text-xl"></i>
            </div>
            <span class="text-2xl font-bold">SmartBiz</span>
          </div>
          <p class="text-gray-400 mb-4">Empowering small businesses with intelligent management solutions for the modern world.</p>
          <div class="flex space-x-4">
            <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-blue-600 transition-colors">
              <i class="bi bi-facebook"></i>
            </a>
            <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-blue-600 transition-colors">
              <i class="bi bi-twitter"></i>
            </a>
            <a href="#" class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-blue-600 transition-colors">
              <i class="bi bi-linkedin"></i>
            </a>
          </div>
        </div>

        <div>
          <h4 class="text-lg font-semibold mb-4">Product</h4>
          <ul class="space-y-2 text-gray-400">
            <li><a href="#" class="hover:text-white transition-colors">Features</a></li>
            <li><a href="#" class="hover:text-white transition-colors">Pricing</a></li>
            <li><a href="#" class="hover:text-white transition-colors">Security</a></li>
            <li><a href="#" class="hover:text-white transition-colors">Integrations</a></li>
          </ul>
        </div>

        <div>
          <h4 class="text-lg font-semibold mb-4">Company</h4>
          <ul class="space-y-2 text-gray-400">
            <li><a href="#" class="hover:text-white transition-colors">About</a></li>
            <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
            <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
            <li><a href="#" class="hover:text-white transition-colors">Press</a></li>
          </ul>
        </div>

        <div>
          <h4 class="text-lg font-semibold mb-4">Support</h4>
          <ul class="space-y-2 text-gray-400">
            <li><a href="#" class="hover:text-white transition-colors">Help Center</a></li>
            <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
            <li><a href="#" class="hover:text-white transition-colors">Status</a></li>
            <li><a href="#" class="hover:text-white transition-colors">API Docs</a></li>
          </ul>
        </div>
      </div>

      <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
        <p class="text-gray-400 text-sm">&copy; 2024 SmartBiz. All rights reserved.</p>
        <div class="flex space-x-6 mt-4 md:mt-0">
          <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Privacy Policy</a>
          <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Terms of Service</a>
          <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Cookie Policy</a>
        </div>
      </div>
    </div>
  </footer>

  <script>
    // Mobile menu functionality
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileOverlay = document.getElementById('mobile-overlay');
    const closeMenu = document.getElementById('close-menu');

    function openMobileMenu() {
      mobileMenu.classList.add('open');
      mobileOverlay.classList.add('active');
      document.body.style.overflow = 'hidden';
    }

    function closeMobileMenu() {
      mobileMenu.classList.remove('open');
      mobileOverlay.classList.remove('active');
      document.body.style.overflow = '';
    }

    mobileMenuBtn.addEventListener('click', openMobileMenu);
    closeMenu.addEventListener('click', closeMobileMenu);
    mobileOverlay.addEventListener('click', closeMobileMenu);

    // Close menu when clicking on links
    document.querySelectorAll('#mobile-menu a').forEach(link => {
      link.addEventListener('click', closeMobileMenu);
    });

    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });

    // Stats counter animation
    function animateCounter(element, target) {
      let current = 0;
      const increment = target / 100;
      const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
          current = target;
          clearInterval(timer);
        }
        element.textContent = Math.floor(current).toLocaleString();
      }, 20);
    }

    // Intersection Observer for animations
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          // Stats counter animation
          if (entry.target.classList.contains('stats-counter')) {
            const target = parseInt(entry.target.getAttribute('data-target'));
            animateCounter(entry.target, target);
          }

          // Workflow steps animation
          if (entry.target.classList.contains('workflow-step')) {
            entry.target.classList.add('visible');
          }

          observer.unobserve(entry.target);
        }
      });
    }, observerOptions);

    // Observe elements
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('.stats-counter').forEach(el => observer.observe(el));
      document.querySelectorAll('.workflow-step').forEach(el => observer.observe(el));
    });

    // Add scroll effect to navigation
    window.addEventListener('scroll', () => {
      const nav = document.querySelector('nav');
      if (window.scrollY > 100) {
        nav.classList.add('bg-white/95');
        nav.classList.remove('bg-white/90');
      } else {
        nav.classList.add('bg-white/90');
        nav.classList.remove('bg-white/95');
      }
    });
  </script>
</body>
</html>
