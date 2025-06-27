<x-guest-layout>
    <div class="container" id="container">

        <!-- Register Form -->
        <div class="form-container sign-up">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <h1>Create Account</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>or use your email for registration</span>

                <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required>
                @error('name') <p class="error">{{ $message }}</p> @enderror

                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                @error('email') <p class="error">{{ $message }}</p> @enderror

                <input type="password" name="password" placeholder="Password" required>
                @error('password') <p class="error">{{ $message }}</p> @enderror

                <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

                <button type="submit">Sign Up</button>
            </form>
        </div>

        <!-- Login Form -->
        <div class="form-container sign-in">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <h1>Sign In</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>or use your email and password</span>
                @error('email') <p class="error">{{ $message }}</p> @enderror
                @error('password') <p class="error">{{ $message }}</p> @enderror
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                

                <input type="password" name="password" placeholder="Password" required>
                

                <div class="rememberme">
                    
                        <input type="checkbox" id="remember" name="remember"> 
                        <label style="font-size:small;">Remember me
                    </label>
                </div>

                <a href="{{ route('password.request') }}">Forgot your password?</a>

                <button type="submit">Login</button>
            </form>
        </div>

        <!-- Toggle Buttons -->
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Already registered?</p>
                    <button class="" id="login">Login</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Don’t have an account?</p>
                    <button class="" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const container = document.getElementById('container');
        const registerBtn = document.getElementById('register');
        const loginBtn = document.getElementById('login');

        if (registerBtn) {
            registerBtn.addEventListener('click', (e) => {
                e.preventDefault();
                container.classList.add("active");
            });
        }

        if (loginBtn) {
            loginBtn.addEventListener('click', (e) => {
                e.preventDefault();
                container.classList.remove("active");
            });
        }
    </script>
    @endpush
</x-guest-layout>
