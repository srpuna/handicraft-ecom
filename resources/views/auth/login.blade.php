@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-16">
    <div class="flex justify-center">
        <div class="w-full max-w-md">
            <div class="bg-cream shadow-lg rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-[#F5F2EA] border-b border-truffle-medium/30">
                    <h1 class="text-xl font-semibold text-truffle-extra-dark">{{ __('Admin Login') }}</h1>
                </div>

                <div class="px-6 py-8">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-6">
                            <label for="email" class="block text-truffle-extra-dark text-sm font-bold mb-2">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="shadow-sm appearance-none border rounded-md w-full py-3 px-4 text-truffle-extra-dark leading-tight focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-premium @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="password" class="block text-truffle-extra-dark text-sm font-bold mb-2">{{ __('Password') }}</label>
                            <input id="password" type="password" class="shadow-sm appearance-none border rounded-md w-full py-3 px-4 text-truffle-extra-dark mb-3 leading-tight focus:outline-none focus:ring-2 focus:ring-green-200 focus:border-green-premium @error('password') border-red-500 @enderror" name="password" required autocomplete="current-password">
                            @error('password')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6 flex items-center justify-between">
                            <div class="flex items-center">
                                <input class="h-4 w-4 text-green-premium focus:ring-green-400 border-truffle-medium/30 rounded" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="ml-2 block text-sm text-truffle-extra-dark" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="inline-block align-baseline font-bold text-sm text-green-premium hover:text-green-premium" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>

                        <div>
                            <button type="submit" class="w-full bg-green-premium hover:bg-green-800 text-white font-bold py-3 px-4 rounded-md focus:outline-none focus:shadow-outline transition-colors duration-200">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
