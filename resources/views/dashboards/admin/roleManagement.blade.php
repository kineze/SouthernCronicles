@extends('layouts.admin.app')

@section('content')

<div class="w-full px-3 mx-auto">
    {{-- new user form  --}}
    <form class="relative" enctype="multipart/form-data" id="main-form"  action="{{ route('storeRole') }}" method="post">
        @csrf

        <div class="flex flex-wrap mt-3 -mx-3">
            <div class="w-full max-w-full px-3 mt-6 shrink-0 lg:flex-0 lg:mt-0">
                <div class="relative flex flex-col min-w-0 break-words bg-white border-0 dark:bg-gray-800 dark:shadow-soft-dark-xl shadow-soft-xl rounded-xl bg-clip-border">
                    <div class="flex-auto p-6">
                        <h5 class="font-bold dark:text-white">User Roles</h5>
                        
                        <div class="flex flex-wrap mt-6 -mx-3">
                            <!-- Role Name Input -->
                            <div class="w-full max-w-full px-3 mt-4 flex-0 sm:w-10/12 sm:mt-0">
                                <div class="relative z-0">
                                    <input type="text" id="roleName" name="roleName" value="{{ old('roleName') }}" required
                                        class="peer block w-full py-2.5 px-0 text-sm text-gray-900 bg-transparent border-0 border-b-2 {{ $errors->has('roleName') ? 'border-red-500' : 'border-gray-300' }} appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600"
                                        placeholder=" " />
                                    <label for="roleName"
                                        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Role Name
                                    </label>
                                </div>
                                @error('roleName')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        
                            <!-- Create Role Button -->
                            <div class="w-full max-w-full px-3 flex items-end sm:w-2/12 sm:mt-0">
                                <button type="submit"
                                    class="inline-block float-right px-8 py-3 mb-0 font-bold text-white uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 hover:shadow-soft-xs dark:bg-gradient-to-tl dark:from-blue-500 dark:to-cyan-400 bg-gradient-to-tl from-cyan-500 to-blue-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25">
                                    Create Role
                                </button>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div> 
        </div> 
    </form>

</div>


  <div class="flex flex-wrap mt-3">
    <div class="w-full max-w-full px-3 flex-0">
      <div class="relative flex flex-col min-w-0 break-words bg-white border-0 dark:bg-gray-800 p-3 dark:shadow-soft-dark-xl shadow-soft-xl rounded-xl bg-clip-border">
        <div class="w-full overflow-hidden dark:border-neutral-700 dark:shadow-gray-900">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                <!-- Table Head -->
                <thead class="bg-gray-50 dark:bg-neutral-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">ID</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">Role Name</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs flex justify-end font-medium text-gray-500 uppercase dark:text-neutral-400">Action</th>
                    </tr>
                </thead>
        
                <!-- Table Body -->
                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                    @foreach($roles as $role)
                    <tr>
                        <!-- Role ID -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">
                            {{ $role->id }}
                        </td>
        
                        <!-- Role Name -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">
                            {{ $role->name }}
                        </td>
        
                        <!-- Action Buttons -->
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium flex justify-end gap-3">
                            <!-- View Button -->
                            <a href="{{ route('viewRole', $role->id) }}" class="text-gray-900 hover:bg-gray-900/10 dark:text-white/70 active:bg-gray-900/20 transition-all rounded-lg p-2">
                                <i class="fas fa-eye"></i>
                            </a>
        
                            <!-- Delete Button -->
                            <form action="{{ route('deleteRole', $role->id) }}" id="delete-form-{{ $role->id }}" method="POST">
                                @csrf
                                <button type="submit" onclick="ConfirmDelete(event, {{ $role->id }})" 
                                    class="text-gray-900 hover:bg-gray-900/10 dark:text-red-400 active:bg-gray-900/20 transition-all rounded-lg p-2">
                                    <i class="fas fa-trash text-red-600"></i>
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