<x-app-layout>
    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-6 bg-white dark:bg-gray-800 dark:border dark:border-gray-700 shadow sm:rounded-lg text-gray-900 dark:text-gray-100">
                <h1 class="text-2xl font-semibold mb-4">Conference Details</h1>

                <p class="py-1"><strong>Title:</strong> {{ $conference->title }}</p>
                <p class="py-1"><strong>Organizer:</strong> {{ $conference->organizer }}</p>
                <p class="py-1"><strong>Description:</strong> {{ $conference->description }}</p>
                <p class="py-1"><strong>Start Date:</strong> {{ $conference->start_date }}</p>
                <p class="py-1"><strong>End Date:</strong> {{ $conference->end_date }}</p>
                <p class="py-1"><strong>Status:</strong>
                    <span class="inline-block px-2 py-1 rounded text-white{{ $conference->status === 'cancelled' ? 'bg-gray-500 dark:bg-gray-600' : 'bg-green-500 dark:bg-green-600' }}">
                        {{ ucfirst($conference->status) }}
                    </span>
                </p>

                <h2 class="text-xl font-semibold mt-6">Registered Attendees</h2>
                <ul class="list-disc list-inside ml-4">
                    @foreach ($conference->confirmedUsers as $user)
                        <li class="py-1">{{ $user->name }} ({{ $user->email }})</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
