<x-app-layout>
    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-6 bg-white dark:bg-gray-800 dark:border dark:border-gray-700 shadow sm:rounded-lg text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-semibold mb-4">Clients</h1>

                    <!-- Clients Table -->
                @if($users->isNotEmpty())
                    <table class="w-full border-collapse dark:border dark:border-gray-700">
                        <thead>
                        <tr class="bg-gray-200 dark:bg-gray-700">
                            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">Name</th>
                            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">Surname</th>
                            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">Email Address</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="border px-4 py-2 border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">
                                    {{ $user->name }}
                                </td>
                                <td class="border px-4 py-2 border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">
                                    {{ $user->surname }}
                                </td>
                                <td class="border px-4 py-2 border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">
                                    {{ $user->email }}
                                </td>
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
