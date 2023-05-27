@extends('layouts.navigation')
@section('title','Login')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center ">
        <div class="col-md-4    ">
            <div class="rounded-3 border">
                <div class="bg-white ">
                    <div class="d-flex justify-content-center">
                        <img class="mt-5" style="width: 5rem;" src="https://itc.edu.kh/wp-content/uploads/2021/02/logoitc.png" alt="">
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <div class="d-flex row">
                            <h3 class="d-flex justify-content-center">Inventory Management!</h3>
                            <span class="d-flex justify-content-center text-secondary">Login to your account</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-1">
                            <label for="password" class="ps-5 col-form-label text-md-start">{{ __('Email') }}</label>
                            <div class="mx-5">
                                <input id="email" placeholder="admin@admin.com" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="ps-5 col-form-label text-md-start">{{ __('Password') }}</label>
                            <div class="mx-5">
                                <input id="password" placeholder="P@assword" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            </div>

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>

                        <!-- <div class="mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> -->
                        <div class="d-flex justify-content-center mb-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                <!-- @if (Route::has('password.request'))
                                 <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                @endif -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection