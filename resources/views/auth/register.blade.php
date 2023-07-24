
<x-guest-layout>
    <div class="register-page">
        <div class="register-box">
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
            <div class="register-logo">
                <a href="/"><b>Admin</b>Passport</a>
            </div>
            <div class="card">
                <div class="card-body register-card-body">
                    <p class="login-box-msg">Register a new membership</p>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <x-input id="name" class="form-control" type="text" name="name" placeholder="Full name" :value="old('name')" required autofocus />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <x-input id="email" class="form-control" placeholder="Email" type="email" name="email" :value="old('email')" required />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <x-input id="password" class="form-control" placeholder="Password" type="password" name="password" required autocomplete="new-password" />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <x-input id="password_confirmation" class="form-control" type="password" placeholder="{{ __('Confirm Password') }}" name="password_confirmation" required />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8" style="display: flex; align-items: center;">
                                <a href="{{ route('login') }}" class="text-center">{{ __('Already registered?') }}</a>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">{{ __('Register') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Validation Errors -->
</x-guest-layout>