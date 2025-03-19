<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <h1 class="text-2xl font-semibold mb-4">My Conferences</h1>

                @if (session('success'))
                    <div class="mb-4 border-l-4 border-green-500 bg-green-50 p-4 rounded" role="alert">
                        <p class="text-green-700 font-bold">Success</p>
                        <p class="text-green-700">{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 border-l-4 border-red-500 bg-red-50 p-4 rounded" role="alert">
                        <p class="text-red-700 font-bold">Error</p>
                        <p class="text-red-700">{{ session('error') }}</p>
                    </div>
                @endif

                @if($conferences->isNotEmpty())
                    <!-- Conferences Table -->
                    <table class="w-full border-collapse">
                        <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2 border">Title</th>
                            <th class="px-4 py-2 border">Organizer</th>
                            <th class="px-4 py-2 border">Start Date</th>
                            <th class="px-4 py-2 border">End Date</th>
                            <th class="px-4 py-2 border">Registration status</th>
                            <th class="px-4 py-2 border">Cancel</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($conferences as $conference)
                            <tr>
                                <td class="border px-4 py-2">{{ $conference->title }}</td>
                                <td class="border px-4 py-2">{{ $conference->organizer }}</td>
                                <td class="border px-4 py-2">{{ $conference->start_date }}</td>
                                <td class="border px-4 py-2">{{ $conference->end_date }}</td>
                                <td class="border px-4 py-2">
                                        <span class="inline-block px-2 py-1 rounded text-white {{ $conference->pivot->status === 'cancelled' ? 'bg-gray-500' : 'bg-green-500' }}">
                                            {{ ucfirst($conference->pivot->status) }}
                                        </span>
                                </td>
                                <td class="border px-4 py-2">
                                    <!-- Cancel Button -->
                                    <form action="{{ route('registrations.cancel', $conference->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
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
