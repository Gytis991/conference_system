<x-app-layout>
    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-6 bg-white dark:bg-gray-800 dark:border dark:border-gray-700 shadow sm:rounded-lg">
                <h1 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">My Conferences</h1>

                @if (session('success'))
                    <div class="mb-4 border-l-4 border-green-500 dark:border-green-400 bg-green-50 dark:bg-green-900 p-4 rounded" role="alert">
                        <p class="font-bold text-green-700 dark:text-green-200">Success</p>
                        <p class="text-green-700 dark:text-green-100">{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 border-l-4 border-red-500 dark:border-red-400 bg-red-50 dark:bg-red-900 p-4 rounded" role="alert">
                        <p class="font-bold text-red-700 dark:text-red-200">Error</p>
                        <p class="text-red-700 dark:text-red-100">{{ session('error') }}</p>
                    </div>
                @endif

                @if($conferences->isNotEmpty())
                    <!-- Conferences Table -->
                    <table class="w-full border-collapse">
                        <thead>
                        <tr class="bg-gray-200 dark:bg-gray-700">
                            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-200">Title</th>
                            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-200">Organizer</th>
                            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-200">Start Date</th>
                            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-200">End Date</th>
                            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-200">Registration status</th>
                            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-200">Cancel</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($conferences as $conference)
                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-gray-800 dark:even:bg-gray-700">
                                <td class="border border-gray-200 dark:border-gray-600 px-4 py-2 text-gray-900 dark:text-gray-100">{{ $conference->title }}</td>
                                <td class="border border-gray-200 dark:border-gray-600 px-4 py-2 text-gray-900 dark:text-gray-100">{{ $conference->organizer }}</td>
                                <td class="border border-gray-200 dark:border-gray-600 px-4 py-2 text-gray-900 dark:text-gray-100">{{ $conference->start_date }}</td>
                                <td class="border border-gray-200 dark:border-gray-600 px-4 py-2 text-gray-900 dark:text-gray-100">{{ $conference->end_date }}</td>
                                <td class="border border-gray-200 dark:border-gray-600 px-4 py-2">
                                        <span class="inline-block px-2 py-1 rounded text-white {{ $conference->pivot->status === 'cancelled' ? 'bg-gray-500 dark:bg-gray-600' : 'bg-green-500 dark:bg-green-600' }}">
                                            {{ ucfirst($conference->pivot->status) }}
                                        </span>
                                </td>
                                <td class="border border-gray-200 dark:border-gray-600 px-4 py-2">
                                    <!-- Cancel Button -->
                                    <form action="{{ route('registrations.cancel', $conference->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="font-bold py-2 px-4 rounded bg-red-500 hover:bg-red-700 dark:bg-red-600 dark:hover:bg-red-800 text-white">
                                            Cancel registration
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $conferences->links() }}
                    </div>
                @else
                    <p class="text-gray-500 dark:text-gray-400">No conferences available.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
