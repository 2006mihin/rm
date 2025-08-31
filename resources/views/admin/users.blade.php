<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Add/Update Form -->
            <div class="bg-white p-6 rounded shadow-md mb-10">
                <h3 class="text-xl font-semibold mb-4">
                    {{ isset($editUser) ? 'Update User' : 'Add New User' }}
                </h3>

                <form method="POST" action="{{ isset($editUser) ? route('admin.users.update', $editUser) : route('admin.users.store') }}">
                    @csrf
                    @if(isset($editUser))
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label class="block mb-1 font-medium">Name</label>
                            <input type="text" name="name" value="{{ old('name', $editUser->name ?? '') }}"
                                   class="w-full border rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label class="block mb-1 font-medium">Email</label>
                            <input type="email" name="email" value="{{ old('email', $editUser->email ?? '') }}"
                                   class="w-full border rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label class="block mb-1 font-medium">
                                {{ isset($editUser) ? 'New Password (optional)' : 'Password' }}
                            </label>
                            <input type="password" name="password"
                                   class="w-full border rounded px-3 py-2" {{ isset($editUser) ? '' : 'required' }}>
                        </div>

                        <div>
                            <label class="block mb-1 font-medium">Role</label>
                            <select name="role" class="w-full border rounded px-3 py-2" required>
                                <option value="admin" {{ (isset($editUser) && $editUser->role=='admin') ? 'selected' : '' }}>Admin</option>
                                <option value="client" {{ (isset($editUser) && $editUser->role=='client') ? 'selected' : '' }}>Client</option>
                            </select>
                        </div>

                    </div>

                    <button type="submit" class="mt-4 bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                        {{ isset($editUser) ? 'Update User' : 'Add User' }}
                    </button>
                </form>
            </div>

            <!-- Users Table -->
            <div class="bg-white p-6 rounded shadow-md overflow-x-auto">
                <h3 class="text-xl font-semibold mb-4">All Users</h3>
                <table class="min-w-full table-auto text-sm border">
                    <thead class="bg-gray-100 text-left font-medium">
                        <tr>
                            <th class="px-4 py-2 border">#</th>
                            <th class="px-4 py-2 border">Name</th>
                            <th class="px-4 py-2 border">Email</th>
                            <th class="px-4 py-2 border">Role</th>
                            <th class="px-4 py-2 border text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 border">{{ $user->name }}</td>
                                <td class="px-4 py-2 border">{{ $user->email }}</td>
                                <td class="px-4 py-2 border capitalize">{{ $user->role }}</td>
                                <td class="px-4 py-2 border text-center space-x-2">
                                    <a href="{{ route('admin.users.index', ['edit' => $user->id]) }}" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">Edit</a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure?')"
                                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                            Delete
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
</x-app-layout>
