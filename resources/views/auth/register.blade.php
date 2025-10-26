<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register User – SmartBiz Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
      /* Reset & base */
      * {
        box-sizing: border-box;
      }

      body, html {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        position: relative;
      }

      body::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background:
          radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
          radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.15) 0%, transparent 50%),
          radial-gradient(circle at 40% 40%, rgba(120, 119, 198, 0.2) 0%, transparent 50%);
        pointer-events: none;
      }

      /* Container for the form */
      .register-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        padding: 3rem;
        border-radius: 24px;
        box-shadow:
          0 25px 50px -12px rgba(0, 0, 0, 0.25),
          0 0 0 1px rgba(255, 255, 255, 0.2);
        max-width: 480px;
        width: 100%;
        margin: 2rem;
        position: relative;
        z-index: 1;
        border: 1px solid rgba(255, 255, 255, 0.2);
      }
body {
  padding-bottom: 80px; /* Make room for the footer */
}

      .logo-container {
        text-align: center;
        margin-bottom: 2rem;
      }

      .logo {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        box-shadow: 0 8px 32px rgba(102, 126, 234, 0.4);
      }

      .logo::after {
        content: '🏢';
        font-size: 28px;
        filter: brightness(0) invert(1);
      }

      h2 {
        color: #1e293b;
        font-size: 2rem;
        font-weight: 700;
        text-align: center;
        margin: 0 0 0.5rem 0;
        letter-spacing: -0.025em;
      }

      .subtext {
        text-align: center;
        font-size: 1rem;
        color: #64748b;
        margin-bottom: 2.5rem;
        font-weight: 400;
      }

      .form-group {
        margin-bottom: 1.5rem;
        position: relative;
      }

      label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #374151;
        font-size: 0.875rem;
        letter-spacing: 0.025em;
      }

      input[type="text"],
      input[type="email"],
      input[type="password"] {
        width: 100%;
        padding: 0.875rem 1rem;
        font-size: 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        transition: all 0.2s ease;
        background: #ffffff;
        font-family: inherit;
      }

      input:focus {
        border-color: #667eea;
        outline: none;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        transform: translateY(-1px);
      }

      input:hover:not(:focus) {
        border-color: #cbd5e1;
      }

      .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
      }

      .error-message::before {
        content: '⚠️';
        font-size: 0.75rem;
      }

      button {
        width: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 1rem;
        font-weight: 600;
        font-size: 1rem;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: inherit;
        letter-spacing: 0.025em;
        position: relative;
        overflow: hidden;
      }

      button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
      }

      button:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
      }

      button:hover::before {
        left: 100%;
      }

      button:active {
        transform: translateY(0);
      }

      .toggle-password {
        position: absolute;
        top: 42px;
        right: 16px;
        cursor: pointer;
        user-select: none;
        font-size: 1.25rem;
        color: #64748b;
        transition: color 0.2s ease;
        padding: 4px;
        border-radius: 6px;
      }

      .toggle-password:hover {
        color: #667eea;
        background: rgba(102, 126, 234, 0.1);
      }

      /* Password strength indicator */
      .password-strength {
        margin-top: 0.5rem;
        height: 4px;
        background: #e2e8f0;
        border-radius: 2px;
        overflow: hidden;
      }

      .password-strength-fill {
        height: 100%;
        transition: all 0.3s ease;
        border-radius: 2px;
      }

      .strength-weak { background: #ef4444; width: 25%; }
      .strength-fair { background: #f59e0b; width: 50%; }
      .strength-good { background: #10b981; width: 75%; }
      .strength-strong { background: #059669; width: 100%; }

      /* Full width footer at bottom */
      footer {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(255, 255, 255, 0.9);
  backdrop-filter: blur(10px);
  border-top: 1px solid rgba(0, 0, 0, 0.1);
  padding: 1rem 0;
  text-align: center;
  font-size: 0.85rem;
  color: #6b7280;
  z-index: 10;
}


      /* Responsive design */
      @media (max-width: 640px) {
        .register-container {
          margin: 1rem;
          padding: 2rem;
          border-radius: 20px;
        }

        h2 {
          font-size: 1.75rem;
        }

        body {
          padding-bottom: 80px;
        }
      }

      /* Loading state */
      .loading {
        opacity: 0.7;
        pointer-events: none;
      }

      .loading button {
        background: #94a3b8;
      }

      /* Success state */
      .success-message {
        background: #dcfce7;
        color: #166534;
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 1rem;
        border: 1px solid #bbf7d0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
      }

      .success-message::before {
        content: '✅';
      }
    </style>
  </head>
  <body>

    <div class="register-container">
      <div class="logo-container">
        <div class="logo"></div>
        <h2>SmartBiz Admin</h2>
        <p class="subtext">Create your user account now</p>
      </div>

      <form method="POST" action="{{ route('store') }}" id="registerForm">
        @csrf

        <div class="form-group">
          <label for="name">Full Name</label>
          <input name="name" id="name" type="text" value="{{ old('name') }}" required autocomplete="name">
          @error('name') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
          <label for="username">Username</label>
          <input name="username" id="username" type="text" value="{{ old('username') }}" required autocomplete="username">
          @error('username') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
          <label for="email">Email Address</label>
          <input name="email" id="email" type="email" value="{{ old('email') }}" required autocomplete="email">
          @error('email') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input name="password" id="password" type="password" required autocomplete="new-password">
          <span class="toggle-password" onclick="toggleVisibility('password', this)">👁️</span>
          <div class="password-strength">
            <div class="password-strength-fill" id="passwordStrength"></div>
          </div>
          @error('password') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
          <label for="password_confirmation">Confirm Password</label>
          <input name="password_confirmation" id="password_confirmation" type="password" required autocomplete="new-password">
          <span class="toggle-password" onclick="toggleVisibility('password_confirmation', this)">👁️</span>
        </div>

        <input type="hidden" name="admin_id" value="{{ auth()->id() }}">

        <button type="submit">Create Account</button>
        <div class="login-info">
  Already have an account?
  <a href="{{ route('login') }}">Login</a>
</div>
<style>
    .login-info {
  margin-top: 1.5rem;
  font-size: 0.85rem;
  color: #6b7280;
  text-align: center;
}

.login-info a {
  color: #2563eb;
  text-decoration: none;
  font-weight: 500;
}

.login-info a:hover {
  text-decoration: underline;
}

</style>
      </form>

    </div>

     <footer>
        &copy; 2025 SmartBiz Admin. All rights reserved.
    </footer>

    <!-- Enhanced JavaScript -->
    <script>
      function toggleVisibility(fieldId, icon) {
        const input = document.getElementById(fieldId);
        if (input.type === "password") {
          input.type = "text";
          icon.textContent = "🙈";
        } else {
          input.type = "password";
          icon.textContent = "👁️";
        }
      }

      // Password strength indicator
      document.getElementById('password').addEventListener('input', function(e) {
        const password = e.target.value;
        const strengthIndicator = document.getElementById('passwordStrength');

        let strength = 0;
        if (password.length >= 8) strength++;
        if (/[a-z]/.test(password)) strength++;
        if (/[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^A-Za-z0-9]/.test(password)) strength++;

        strengthIndicator.className = 'password-strength-fill';
        if (strength >= 1) strengthIndicator.classList.add('strength-weak');
        if (strength >= 2) strengthIndicator.classList.add('strength-fair');
        if (strength >= 3) strengthIndicator.classList.add('strength-good');
        if (strength >= 4) strengthIndicator.classList.add('strength-strong');
      });

      // Form submission with loading state
      document.getElementById('registerForm').addEventListener('submit', function() {
        this.classList.add('loading');
      });

      // Keep session alive every 5 minutes
      setInterval(() => {
        fetch("/keep-alive", {
          method: "GET",
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        });
      }, 5 * 60 * 1000);

      // Add subtle animations on load
      window.addEventListener('load', function() {
        document.querySelector('.register-container').style.opacity = '0';
        document.querySelector('.register-container').style.transform = 'translateY(20px)';

        setTimeout(() => {
          document.querySelector('.register-container').style.transition = 'all 0.6s ease';
          document.querySelector('.register-container').style.opacity = '1';
          document.querySelector('.register-container').style.transform = 'translateY(0)';
        }, 100);
      });
    </script>

  </body>
</html>
