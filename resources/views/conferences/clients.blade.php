<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <h1 class="text-2xl font-semibold mb-4">Clients</h1>

                    <!-- Clients Table -->
                @if($users->isNotEmpty())
                    <table class="w-full border-collapse">
                        <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2 border">Name</th>
                            <th class="px-4 py-2 border">Surname</th>
                            <th class="px-4 py-2 border">Email Address</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="border px-4 py-2">{{ $user->name }}</td>
                                <td class="border px-4 py-2">{{ $user->surname }}</td>
                                <td class="border px-4 py-2">{{ $user->email }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400">No users available.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
