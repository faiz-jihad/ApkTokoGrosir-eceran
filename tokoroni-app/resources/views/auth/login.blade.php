<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Roni - Log In</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
        }

        body {
            background-color: #f8fafc;
            color: #333;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .brand-section {
            flex: 1;
            background:
                linear-gradient(rgba(16, 15, 43, 0.85), rgba(29, 45, 98, 0.9)),
                url('/images/bglogin.jpg') no-repeat center center/cover;
            color: white;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
        }

        .logo-icon {
            font-size: 28px;
            font-weight: 700;
            margin-right: 10px;
        }

        .logo-text {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .tagline {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .features {
            margin-top: 40px;
        }

        .feature {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .feature-icon {
            width: 24px;
            height: 24px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 12px;
        }

        .feature-text {
            font-size: 14px;
        }

        .login-section {
            flex: 1;
            padding: 50px 40px;
        }

        .login-header {
            margin-bottom: 30px;
        }

        .login-title {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .login-subtitle {
            color: #64748b;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #475569;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .checkbox {
            margin-right: 10px;
            width: 16px;
            height: 16px;
            accent-color: #2a21dc;
        }

        .checkbox-label {
            font-size: 14px;
            color: #475569;
        }

        .forgot-password {
            display: block;
            text-align: right;
            font-size: 14px;
            color: #1e188a;
            text-decoration: none;
            margin-bottom: 25px;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            background-color: #221c90;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 14px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-bottom: 25px;
        }

        .login-button:hover {
            background-color: #281ca9;
        }

        .divider {
            text-align: center;
            position: relative;
            margin: 25px 0;
            color: #94a3b8;
            font-size: 14px;
        }

        .divider::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background-color: #e2e8f0;
            z-index: 1;
        }

        .divider-text {
            background-color: white;
            padding: 0 15px;
            position: relative;
            z-index: 2;
            display: inline-block;
        }

        .social-login {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .social-button {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background-color: white;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .social-button:hover {
            background-color: #f8fafc;
        }

        .google-button {
            color: #475569;
        }

        .google-icon {
            margin-right: 10px;
            width: 18px;
            height: 18px;
        }

        .signup-link {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: #64748b;
        }

        .signup-link a {
            color: #140d9d;
            text-decoration: none;
            font-weight: 500;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                max-width: 450px;
            }

            .brand-section {
                padding: 30px;
            }

            .login-section {
                padding: 30px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- Brand Section -->
        <div class="brand-section">
            <div class="logo">
                <div class="logo-icon">▶</div>
                <div class="logo-text">Toko Roni Juntinyuat</div>
            </div>
            <p class="tagline">
                Toko Roni Juntinyuat Management System
            </p>
            <h2>Management.<br>Create Anywhere.</h2>

            <div class="features">
                <div class="feature">
                    <div class="feature-icon">✓</div>
                    <div class="feature-text">Management</div>
                </div>
                <div class="feature">
                    <div class="feature-icon">✓</div>
                    <div class="feature-text">Cassier</div>
                </div>
                <div class="feature">
                    <div class="feature-icon">✓</div>
                    <div class="feature-text">Development</div>
                </div>
            </div>
        </div>

        <!-- Login Form Section -->
        <div class="login-section">
            <div class="login-header">
                <h1 class="login-title">Welcome Back!</h1>
                <p class="login-subtitle">Log in To Toko Roni.</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}"
                        placeholder="Input your email" required autofocus>
                    @error('email')
                        <small style="color:red">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-input"
                        placeholder="Input your password" required>
                    @error('password')
                        <small style="color:red">{{ $message }}</small>
                    @enderror
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" name="remember" id="remember" class="checkbox">
                    <label for="remember" class="checkbox-label">Remember Me</label>
                </div>

                <a href="{{ route('password.request') }}" class="forgot-password">
                    Forgot Password?
                </a>

                <button type="submit" class="login-button">
                    Login
                </button>
            </form>


            <div class="divider">
                <span class="divider-text">Or continue with</span>
            </div>

            <div class="social-login">
                <button class="social-button google-button">
                    <svg class="google-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="#4285F4"
                            d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                        <path fill="#34A853"
                            d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                        <path fill="#FBBC05"
                            d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                        <path fill="#EA4335"
                            d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                    </svg>
                    Continue with Google
                </button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // Simple validation
            if (!email || !password) {
                alert('Please fill in both email and password fields.');
                return;
            }

            // In a real application, this would be an API call
            console.log('Login attempt with:', {
                email,
                password
            });
            alert('Login functionality would connect to backend in a real application.');
        });

        document.querySelector('.google-button').addEventListener('click', function() {
            alert('Google authentication would be implemented in a real application.');
        });
    </script>
</body>

</html>
