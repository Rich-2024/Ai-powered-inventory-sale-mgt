<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SmartBiz - Terms & Conditions</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-50 font-sans">

  <!-- Header -->
  <header class="bg-blue-900 text-white p-5 sticky top-0 z-50 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-2xl font-bold">smartbiz</h1>

      <button id="menu-toggle" class="md:hidden focus:outline-none text-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <nav id="mobile-menu"
        class="hidden absolute top-full left-0 w-full bg-blue-900 md:static md:flex md:space-x-6 md:items-center md:w-auto md:bg-transparent">
        <a href="/" class="block px-4 py-2 hover:text-blue-300">Home</a>
        {{-- <a href="{{ route('price') }}" class="block px-4 py-2 hover:text-blue-300">Pricing</a> --}}
        <a href="{{ route('login') }}"
          class="block px-4 py-2 bg-white text-blue-900 rounded hover:bg-blue-100 transition md:bg-white md:inline">Login</a>
      </nav>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="bg-blue-100 py-20 text-center">
    <h2 class="text-4xl font-bold text-blue-900 animate__animated animate__fadeInDown">Terms & Conditions</h2>
    <p class="text-lg text-gray-700 mt-4 max-w-3xl mx-auto animate__animated animate__fadeInUp">
      At Smartbiz, we are committed to protecting your data, ensuring compliance, and delivering trustworthy financial solutions. Explore the foundation of our service agreement.
    </p>
  </section>

  <!-- Main Terms Section -->
  <section class="py-16 px-6 max-w-5xl mx-auto animate__animated animate__fadeIn">
    <div class="bg-white shadow-lg rounded-lg p-8 text-gray-700 leading-relaxed">
      <h3 class="text-2xl font-semibold text-blue-800 mb-4">1. Legal Compliance</h3>
      <p class="mb-6">
        FinanceHubTracker operates under the regulatory framework of the Uganda Communications Commission (UCC) and is fully compliant with the Uganda Data Protection and Privacy Act, 2019. Your data is handled with integrity and confidentiality.
      </p>

      <h3 class="text-2xl font-semibold text-blue-800 mb-4">2. Data Protection & Privacy</h3>
      <p class="mb-6">
        We value your trust. All personal data collected through this platform is securely encrypted and stored. It is never sold or shared with third parties without your explicit consent. You remain in control of your data — always.
      </p>

      <h3 class="text-2xl font-semibold text-blue-800 mb-4">3. Transparency You Can Trust</h3>
      <p class="mb-6">
        Our pricing is straightforward, with no hidden fees. You can start with a free trial and upgrade only when you're confident. We believe that trust is built on honesty and clarity.
      </p>

      <h3 class="text-2xl font-semibold text-blue-800 mb-4">4. User Responsibilities</h3>
      <p class="mb-6">
        Users are expected to maintain the confidentiality of their login credentials. Any misuse of the platform may result in suspension or termination of access. We reserve the right to take necessary legal actions for abusive behavior or fraud.
      </p>

      <h3 class="text-2xl font-semibold text-blue-800 mb-4">5. Commitment to Excellence</h3>
      <p class="mb-6">
        We are more than just a financial tool. Smartbiz empowers businesses to manage loans efficiently, make data-driven decisions, and foster long-term financial growth. You can count on us for continuous innovation and support.
      </p>

      <h3 class="text-2xl font-semibold text-blue-800 mb-4">6. Revisions</h3>
      <p class="mb-6">
        We may update these terms occasionally to reflect policy changes, new laws, or system improvements. We’ll notify users of major updates to ensure ongoing clarity and transparency.
      </p>

      <h3 class="text-2xl font-semibold text-blue-800 mb-4">7. Contact Us</h3>
      <p>
        If you have questions, feedback, or need clarity on any term, feel free to reach out to us at
        <a href="mailto:support@financehubtracker.com" class="text-blue-600 underline">support@financehubtracker.com</a>.
      </p>
    </div>

    <!-- Convincing CTA -->
    <div class="text-center mt-12">
      <h3 class="text-2xl font-bold text-blue-900 mb-4 animate__animated animate__fadeInUp">Your trust. Our priority.</h3>
      <p class="text-lg text-gray-700 mb-6 max-w-xl mx-auto">
        Join hundreds of smart businesses already using smartBiz to simplify their business processes and improve cash flow.
      </p>
     <div class="text-center mt-6 text-sm text-gray-600">
  By clicking <strong> Start Now</strong>, you agree to our
  <a href="{{ route('tot') }}" class="text-blue-700 underline hover:text-blue-900">Terms & Conditions</a>.
</div>

<a href="{{ route('register') }}"
   class="mt-4 inline-block bg-blue-700 text-white px-6 py-3 rounded-full hover:bg-blue-800 transition animate__animated animate__pulse animate__infinite">
  Start Now
</a>

  </section>

  <!-- Footer -->
  <footer class="bg-blue-900 text-white py-6 text-center mt-16">
    <p>&copy; 2025 FinanceHubTracker. All rights reserved.</p>
  </footer>

  <!-- Mobile Menu Script -->
  <script>
    const toggleBtn = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    toggleBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      mobileMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
      const isInside = mobileMenu.contains(e.target) || toggleBtn.contains(e.target);
      if (!isInside && !mobileMenu.classList.contains('hidden')) {
        mobileMenu.classList.add('hidden');
      }
    });

    mobileMenu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => mobileMenu.classList.add('hidden'));
    });
  </script>

</body>
</html>
