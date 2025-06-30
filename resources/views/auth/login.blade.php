<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')"/>
    <div class="login-container">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="login-logo">
        <h2 class="login-title">Login</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf


            <div style="border: solid black; width:25%; margin-bottom: 7px"></div>

            <!-- Email Address -->

            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" type="email" name="email" class="form-input" value="{{ old('email') }}" required
                       autofocus autocomplete="username">
                <x-input-error :messages="$errors->get('email')" class="error-message"/>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" type="password" name="password" class="form-input" required
                       autocomplete="current-password">
                <x-input-error :messages="$errors->get('password')" class="error-message"/>
            </div>


            <!-- Remember Me -->
            <div class="form-group checkbox-group">
                <label class="checkbox-label">
                    <input id="remember_me" type="checkbox" name="remember" class="checkbox-input">
                    {{ __('Remember me') }}
                </label>
            </div>

            <!-- Forgot Password and Login Button -->
            <div class="form-actions">
                @if (Route::has('password.request'))
                    <a class="forgot-password" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
                <button type="submit" class="btn-primary login-button">{{ __('Log in') }}</button>
            </div>
        </form>
    </div>
</x-guest-layout>
