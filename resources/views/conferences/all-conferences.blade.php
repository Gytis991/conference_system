<x-app-layout>
    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-6 bg-white dark:bg-gray-800 dark:border dark:border-gray-700 shadow sm:rounded-lg">
                <h1 class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">All Conferences</h1>

                @if (session('success'))
                    <div class="mb-4 border-l-4 border-green-500 dark:border-green-400  bg-green-50 dark:bg-green-900 p-4 rounded" role="alert">
                        <p class="text-green-700 dark:text-green-200 font-bold">Success</p>
                        <p class="text-green-700 dark:text-green-100">{{ session('success') }}</p>
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 border-l-4 border-red-500 dark:border-red-400 bg-red-50 dark:bg-red-900 p-4 rounded" role="alert">
                        <p class="text-red-700 dark:text-red-200 font-bold">Error</p>
                        <p class="text-red-700 dark:text-red-100">{{ session('error') }}</p>
                    </div>
                @endif

                @if($conferences->isNotEmpty())
                    <!-- Conferences Table -->
                    <table class="table-auto w-full border-collapse dark:border dark:border-gray-700">
                        <thead>
                        <tr class="bg-gray-200 dark:bg-gray-700">
                            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">Title</th>
                            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">Organizer</th>
                            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">Start Date</th>
                            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">End Date</th>
                            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">Status</th>
                            <th class="px-4 py-2 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($conferences as $conference)
                            <tr>
                                <td class="border px-4 py-2 border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">
                                    {{ $conference->title }}
                                </td>
                                <td class="border px-4 py-2 border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">
                                    {{ $conference->organizer }}
                                </td>
                                <td class="border px-4 py-2 border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">
                                    {{ $conference->start_date }}
                                </td>
                                <td class="border px-4 py-2 border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100">
                                    {{ $conference->end_date }}
                                </td>
                                <td class="border px-4 py-2 border-gray-200 dark:border-gray-600">
                                        <span class="inline-block px-2 py-1 rounded text-white{{ $conference->status === 'cancelled'? 'bg-gray-500 dark:bg-gray-600' : 'bg-green-500 dark:bg-green-600' }}">
                                            {{ ucfirst($conference->status) }}
                                        </span>
                                </td>
                                <td class="border px-4 py-2 border-gray-200 dark:border-gray-600">
                                    <!-- Register Button -->
                                    <form action="{{ route('registrations.create') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="conference_id" value="{{ $conference->id }}">
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700dark:bg-blue-600 dark:hover:bg-blue-800   text-white font-bold py-2 px-4 rounded">
                                            Register
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
