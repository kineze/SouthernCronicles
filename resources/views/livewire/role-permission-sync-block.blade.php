<div class="flex-auto p-4">
    <ul class="flex flex-wrap w-full pl-0 mb-0 rounded-lg">
        @foreach ($permissions as $permission)
            <li class="relative block lg:w-4/12  px-1 py-2 border-0 rounded-t-lg text-inherit">
                <div class="min-h-6 mb-0.5 block pl-0">
                    <!-- Replace checkbox with the toggle switch UI -->
                    <label class="inline-flex items-center cursor-pointer">
                        <input
                            wire:click="togglePermission({{ $permission->id }})"
                            type="checkbox"
                            value=""
                            class="sr-only peer"
                            id="{{ 'permission_' . $permission->id }}"
                            {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                        >
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>
                        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $permission->name }}</span>
                    </label>
                </div>
            </li>
        @endforeach
    </ul>
</div>
