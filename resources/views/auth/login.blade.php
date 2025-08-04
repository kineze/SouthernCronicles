@extends('auth.layouts.app')

@section('content')
<div class="w-full h-screen flex px-4 flex-col items-center justify-center bg-cover bg-center">

<div class="lg:w-4/12 md:w-7/12">
        <div class=" bg-white dark:border-neutral-700 dark:border w-full md:shadow-xl dark:shadow-none p-6 shadow-gray-300 dark:shadow-neutral-800">

        <div class="w-full flex flex-col p-6 items-center justify-center">
        <img src="{{asset('assets/img/logo.webp')}}" class="inline-block  max-w-full transition-all duration-200 ease-soft-in-out h-24 dark:hidden" alt="main_logo" />
        <img src="{{asset('assets/img/logo.webp')}}" class="hidden  max-w-full transition-all duration-200 ease-soft-in-out h-20 dark:inline-block" alt="main_logo" />
        <h4 class="font-bold inline-flex flex-col space-y-2 leading-3 text-xl dark:text-white text-center uppercase text-black mb-0">The Asian <br> <span class=" text-xl">Literary Festival - Brussels</span></h4>

        </div>

        <div class="w-full flex px-3 py-6 items-center flex-col justify-center">

                <form method="POST" action="{{ route('login') }}" class="w-full flex gap-4 flex-col py-3">
                    @csrf

                    @error('email')
                    <div class="w-full p-3 bg-red-50 rounded-sm">
                        <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p>
                    </div>
                    @enderror

                    <div class="relative w-full">
                        <input type="text" id="email" name="email" value="{{ old('email') }}" required autofocus class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-700 peer pr-10" placeholder=" " />
                        
                        <label for="email" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-gray-700 peer-focus:dark:text-gray-700 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">Email</label>
                        
                        <!-- Font Awesome Email Icon -->
                        <i class="fa-solid fa-envelope absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 dark:text-gray-400 peer-focus:text-gray-700"></i>
                    </div>

                    <div class="relative w-full">
                        <input type="password" id="password" name="password"  required class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-700 peer pr-10" placeholder=" " />
                        
                        <label for="password" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] start-2.5 peer-focus:text-gray-700 peer-focus:dark:text-gray-700 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4">Password</label>
                        
                        <!-- Password Toggle Icon -->
                        <i id="togglePassword" class="fa-solid fa-eye absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 dark:text-gray-400 cursor-pointer"></i>
                    </div>

                    <div class="block mt-6">
                        <label for="remember_me" class="flex items-center">
                            <x-checkbox id="remember_me" name="remember" />
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        {{-- @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('student.forgot.password') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif --}}
        

                        <button class=" dark:bg-blue-600 mb-0 font-semibold text-sm text-white py-2 px-4 ml-2 shadow-lg flex items-center gap-3 bg-black">
                            {{ __('Log in') }}

                            {{-- <i class="fa-solid fa-arrow-right"></i> --}}
                        </button>
                    </div>
                </form>
        </div>

        

    </div>

    <div class="bg-black p-2 w-full"></div>
</div>
    

   
</div>

@endsection