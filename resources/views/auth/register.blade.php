<x-guest-layout>
    <div class="container" id="container">
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

        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Already registered?</p>
                    <a href="{{ route('login') }}">
                        <button class="hidden" id="login">Login</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
