@extends('layouts.admin.app')

@section('content')

<div class="w-full p-3 mx-auto">

    <div class="justify-between flex w-full p-4 bg-white shadow-soft-xl rounded-xl dark:bg-gray-800 sm:flex pb-2">
    <div class="flex w-full flex-wrap -mx-3">
        <div class="w-full max-w-full px-3 shrink-0 lg:flex-0 lg:w-6/12">
            <h4 class="dark:text-white mx-3 mb-4 text-lg">All Users</h4>
        </div>
    </div>
    <div>
        <a href="{{route('newUser')}}" class="whitespace-nowrap inline-block px-8 py-2 font-bold text-center uppercase align-middle transition-all bg-transparent border-solid rounded-lg shadow-none cursor-pointer active:opacity-85 leading-pro text-xs ease-soft-in tracking-tight-soft bg-150 bg-x-25 hover:scale-102 active:shadow-soft-xs border border-cyan-700 text-cyan-500 hover:text-cyan-500 hover:opacity-75 hover:shadow-none active:scale-100 active:border-orange-500 active:bg-orange-500 active:text-white hover:active:border-orange-500 hover:active:bg-transparent hover:active:text-orange-500 hover:active:opacity-75"><i class="fas fa-plus mr-2"></i> New User</a>
    </div>
    
      <div class="flex">
      <div class="p-2">
        @if($errors->any())
            <div class="bg-red-300 text-white rounded-3 p-6 my-5">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
      </div>
      </div>
    </div>

    <div class="flex flex-wrap mt-3   -mx-3">
      <div class="w-full max-w-full px-3 flex-0">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 dark:bg-gray-800 p-3 dark:shadow-soft-dark-xl shadow-soft-xl rounded-xl bg-clip-border">
            <div class="overflow-x-auto w-full dark:border-neutral-700 dark:shadow-gray-900">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                    <!-- Table Head -->
                    <thead class="bg-gray-50 dark:bg-neutral-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">ID</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">User Name</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">Email</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">Phone Number</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">Roles</th>
                            <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">Action</th>
                        </tr>
                    </thead>
            
                    <!-- Table Body -->
                    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                        @foreach($users as $user)
                        <tr>
                            <!-- User ID -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">
                                {{ $user->id }}
                            </td>
            
                            <!-- User Name -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">
                                {{ $user->name }}
                            </td>
            
                            <!-- Email -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                {{ $user->email }}
                            </td>
            
                            <!-- Phone Number -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                {{ $user->phone }}
                            </td>
            
                            <!-- Roles -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($user->roles as $role)
                                        <span class="py-1 px-3 text-xs rounded-md font-bold uppercase leading-none 
                                            {{ $role->name === 'Admin' ? 'bg-gray-200 text-gray-800' : 'bg-cyan-200 text-blue-600' }}">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
            
                            <!-- Action Buttons -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex justify-end gap-3">
                                <!-- Edit Button -->
                                <a href="{{ route('getUpdateUser', $user->id) }}"
                                    class="text-gray-900  dark:text-white/70 active:bg-gray-900/20 transition-all rounded-lg">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
            
                                <!-- Delete Button -->
                                <form action="{{ route('deleteUser', $user->id) }}" id="delete-form-{{ $user->id }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="ConfirmDelete(event, {{ $user->id }})"
                                        class="text-gray-900  dark:text-red-400 active:bg-gray-900/20 transition-all rounded-lg">
                                        <i class="fa-solid fa-trash text-red-600"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
      </div>

    </div>

          

</div>
    
@endsection