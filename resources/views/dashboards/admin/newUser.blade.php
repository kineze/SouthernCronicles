@extends('layouts.admin.app')

@section('content')

<div class="w-full px-3 mx-auto">
    {{-- new user form  --}}
    <form class="relative" enctype="multipart/form-data" id="main-form"  action="{{ route('storeUser') }}" method="post">
        @csrf
        
        <div class="flex flex-wrap mt-3 -mx-3">
            <div class="w-full max-w-full px-3 mt-6 shrink-0 lg:flex-0 lg:w-8/12 lg:mt-0">
                <div class="relative flex flex-col min-w-0 break-words bg-white border-0 dark:bg-gray-800 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="flex-auto p-6">
                        <h5 class="font-bold dark:text-white">User Information</h5>
                        <div class="flex flex-wrap -mx-3">
                            <!-- User Name -->
                            <div class="w-full mt-6 max-w-full px-3 flex-0">
                                <div class="relative z-0">
                                    <input type="text" id="UserName" name="UserName" value="{{ old('UserName') }}" required
                                        class="peer block w-full py-2.5 px-0 text-sm text-gray-900 bg-transparent border-0 border-b-2 {{ $errors->has('UserName') ? 'border-red-500' : 'border-gray-300' }} appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600"
                                        placeholder=" " />
                                    <label for="UserName"
                                        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        User Name
                                    </label>
                                </div>
                                @error('UserName')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap mt-6 -mx-3">
                            <!-- Email -->
                            <div class="w-full max-w-full px-3 mt-4 flex-0 sm:w-6/12 sm:mt-0">
                                <div class="relative z-0">
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                        class="peer block w-full py-2.5 px-0 text-sm text-gray-900 bg-transparent border-0 border-b-2 {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600"
                                        placeholder=" " />
                                    <label for="email"
                                        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Email
                                    </label>
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        
                            <!-- Phone -->
                            <div class="w-full max-w-full px-3 flex-0 sm:w-6/12">
                                <div class="relative z-0">
                                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required
                                        class="peer block w-full py-2.5 px-0 text-sm text-gray-900 bg-transparent border-0 border-b-2 {{ $errors->has('phone') ? 'border-red-500' : 'border-gray-300' }} appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600"
                                        placeholder=" " />
                                    <label for="phone"
                                        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Phone
                                    </label>
                                </div>
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="flex mt-6 flex-wrap -mx-3">
                            <!-- Password -->
                            <div class="w-full max-w-full px-3 mt-4 flex-0 sm:w-6/12 sm:mt-0">
                                <div class="relative z-0">
                                    <input type="password" id="password" name="password" required
                                        class="peer block w-full py-2.5 px-0 text-sm text-gray-900 bg-transparent border-0 border-b-2 {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600"
                                        placeholder=" " />
                                    <label for="password"
                                        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Password
                                    </label>
                                </div>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        
                            <!-- Confirm Password -->
                            <div class="w-full max-w-full px-3 flex-0 sm:w-6/12">
                                <div class="relative z-0">
                                    <input type="password" id="password_confirmation" name="password_confirmation" required
                                        class="peer block w-full py-2.5 px-0 text-sm text-gray-900 bg-transparent border-0 border-b-2 {{ $errors->has('password_confirmation') ? 'border-red-500' : 'border-gray-300' }} appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600"
                                        placeholder=" " />
                                    <label for="password_confirmation"
                                        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Confirm Password
                                    </label>
                                </div>
                            </div>
                        </div>
                        

                        {{-- <div class="flex flex-wrap -mx-3">
                            <div class="w-full max-w-full px-3 mt-4 flex-0 sm:mt-0">
                                <label class="mt-3">
                                    <input id="reset-password" name="reset_password" type="checkbox"  value="1" class="w-5 h-5 ease-soft text-base mr-4 rounded-1.4 checked:bg-gradient-to-tl checked:from-gray-900 checked:to-slate-800 after:text-xxs after:font-awesome after:duration-250 after:ease-soft-in-out duration-250 relative float-left mt-1 cursor-pointer appearance-none border border-solid border-slate-150 bg-white bg-contain bg-center bg-no-repeat align-top transition-all after:absolute after:flex after:h-full after:w-full after:items-center after:justify-center after:text-white after:opacity-0 after:transition-all after:content-['\f00c'] checked:border-0 checked:border-transparent checked:bg-transparent checked:after:opacity-100" />
                                    <label for="reset-password" class="cursor-pointer select-none dark:text-slate-100 text-slate-700">Ask user to reset password when first login</label>
                                </label>
                            </div>
                        </div> --}}
                    
                        <div class="flex flex-wrap -mx-3">
                            <div class=" w-full max-w-full px-3 mt-4 flex-0 sm:mt-0">
                                <label class="mt-3">
                                    <input id="send-password-email" name="send_password_email" value="1" type="checkbox" class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded-xl focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" />
                                    <label for="send-password-email" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Send Password Via Email?</label>
                                </label>
                            </div>
                        </div>

                        <div class="">
                            <h5 class="mt-6 dark:text-white">Password requirements</h5>
                            <p class="mb-2 text-slate-500 dark:text-slate-100">Please follow this guide for a strong password:</p>
                            <ul class="float-left pl-6 mb-0 list-disc text-slate-500">
                            <li>
                                <span class="leading-normal dark:text-slate-100 text-sm">One special characters</span>
                            </li>
                            <li>
                                <span class="leading-normal dark:text-slate-100 text-sm">Min 6 characters</span>
                            </li>
                            <li>
                                <span class="leading-normal dark:text-slate-100 text-sm">One number (2 are recommended)</span>
                            </li>
                        
                            </ul>
                            <button type="submit" href="javascript:;" class="inline-block float-right px-8 py-2 mt-16 mb-0 font-bold text-right text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 hover:shadow-soft-xs dark:bg-gradient-to-tl dark:from-cyan-500 dark:to-blue-400 bg-gradient-to-tl from-cyan-500 to-blue-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25">Create User</button>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="w-full max-w-full shrink-0 lg:w-4/12 sm:flex-0">
                <div class=" relative flex flex-col min-w-0 break-words bg-white border-0 dark:bg-gray-800 dark:shadow-soft-dark-xl shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-6">
                    <h5 class="font-bold dark:text-white">Access Levels</h5>

                    @if ($errors->has('roles'))
                        <p class="text-red-500 text-xs mt-1">{{ $errors->first('roles') }}</p>
                    @endif
                    
                    <div class="grid h-fit w-full sm:grid-cols-1 gap-2">

                        @foreach ($roles as $role)
                            <div class="relative {{ $errors->has('roles') ? 'border-red-500' : 'border-gray-300' }} flex flex-col h-fit bg-white  dark:text-white p-5 rounded-lg border-0.4 border-gray-300 dark:border-gray-600 dark:bg-gray-850 cursor-pointer">
                                <label>
                                    <input id="checkbox-{{$role->id}}" name="roles[]" value="{{$role->name}}" class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded-xl focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" type="checkbox" />
                                    <label for="checkbox-{{$role->id}}" class="cursor-pointer uppercase select-none dark:text-white ml-3 text-slate-700">{{$role->name}}</label>
                                </label>
                            </div>
                        @endforeach
                        
                    </div>
        
                </div>
                </div>
        
            </div>
        
        </div>

        
    </form>

  </div>
@endsection