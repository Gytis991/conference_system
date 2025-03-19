<x-app-layout>
    <!-- Main container -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <h1 class="text-2xl font-semibold mb-4">Conference Management</h1>

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

                <!-- Create Conference Button -->
                <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4" onclick="showModal('createConferenceModal')">
                    + Create Conference
                </button>

                <!-- Conferences Table -->
                <table class="table-auto w-full border-collapse">
                    <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2 border">Title</th>
                        <th class="px-4 py-2 border">Organizer</th>
                        <th class="px-4 py-2 border">Start Date</th>
                        <th class="px-4 py-2 border">End Date</th>
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">Actions</th>
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
                                    <span class="inline-block px-2 py-1 rounded text-white
                                               {{ $conference->status === 'cancelled' ? 'bg-gray-500' : 'bg-green-500' }}">
                                        {{ ucfirst($conference->status) }}
                                    </span>
                            </td>
                            <td class="border px-4 py-2 space-x-2">
                                <!-- View Details -->
                                <a href="{{ route('conferences.getOne', $conference->id) }}" class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded">
                                    View
                                </a>

                                <!-- Edit Button -->
                                <button type="button" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded"
                                        onclick="
                                            fillEditModal(
                                                {{ $conference->id }},
                                                '{{ $conference->title }}',
                                                '{{ $conference->organizer }}',
                                                '{{ $conference->description }}',
                                                '{{ $conference->start_date }}',
                                                '{{ $conference->end_date }}'
                                            );
                                            showModal('editConferenceModal');
                                        "
                                >
                                    Edit
                                </button>

                                <!-- Cancel Button -->
                                <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded"
                                        onclick="
                                            prepareCancelModal({{ $conference->id }});
                                            showModal('cancelConferenceModal');
                                        "
                                >
                                    Cancel
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $conferences->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Create Conference Modal -->
    <div id="createConferenceModal" class="fixed inset-0 hidden items-center justify-center bg-gray-500 bg-opacity-75 z-50">
        <div class="bg-white w-full max-w-md rounded shadow-lg">
            <div class="flex items-center justify-between p-4 border-b">
                <h5 class="text-lg font-semibold">Create New Conference</h5>
                <button class="text-gray-500 hover:text-gray-700" onclick="hideModal('createConferenceModal')">
                    &times;
                </button>
            </div>
            <form action="{{ route('conferences.create') }}" method="POST">
                @csrf
                <div class="p-4">
                    <div class="mb-4">
                        <label for="title" class="block font-medium text-sm text-gray-700">
                            Title
                        </label>
                        <input type="text" name="title" id="title" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    </div>
                    <div class="mb-4">
                        <label for="organizer" class="block font-medium text-sm text-gray-700">
                            Organizer
                        </label>
                        <input type="text" name="organizer" id="organizer" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block font-medium text-sm text-gray-700">
                            Description
                        </label>
                        <textarea name="description" id="description" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200 focus:ring-opacity-50" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="start_date" class="block font-medium text-sm text-gray-700">
                            Start Date
                        </label>
                        <input type="date" name="start_date" id="start_date" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    </div>
                    <div class="mb-4">
                        <label for="end_date" class="block font-medium text-sm text-gray-700">
                            End Date
                        </label>
                        <input type="date" name="end_date" id="end_date" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    </div>
                </div>
                <div class="flex items-center justify-end p-4 border-t">
                    <button type="button" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2" onclick="hideModal('createConferenceModal')">
                        Close
                    </button>
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Create Conference
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Conference Modal -->
    <div id="editConferenceModal" class="fixed inset-0 hidden items-center justify-center bg-gray-500 bg-opacity-75 z-50">
        <div class="bg-white w-full max-w-md rounded shadow-lg">
            <div class="flex items-center justify-between p-4 border-b">
                <h5 class="text-lg font-semibold">Edit Conference</h5>
                <button class="text-gray-500 hover:text-gray-700" onclick="hideModal('editConferenceModal')">
                    &times;
                </button>
            </div>
            <form id="editConferenceForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="p-4">
                    <input type="hidden" id="edit_conference_id">
                    <div class="mb-4">
                        <label for="edit_title" class="block font-medium text-sm text-gray-700">
                            Title
                        </label>
                        <input type="text" name="title" id="edit_title" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    </div>
                    <div class="mb-4">
                        <label for="edit_organizer" class="block font-medium text-sm text-gray-700">
                            Organizer
                        </label>
                        <input type="text" name="organizer" id="edit_organizer" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    </div>
                    <div class="mb-4">
                        <label for="edit_description" class="block font-medium text-sm text-gray-700">
                            Description
                        </label>
                        <textarea name="description" id="edit_description" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200 focus:ring-opacity-50" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="edit_start_date" class="block font-medium text-sm text-gray-700">
                            Start Date
                        </label>
                        <input type="date" name="start_date" id="edit_start_date" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    </div>
                    <div class="mb-4">
                        <label for="edit_end_date" class="block font-medium text-sm text-gray-700">
                            End Date
                        </label>
                        <input type="date" name="end_date" id="edit_end_date" class="mt-1 block w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    </div>
                </div>
                <div class="flex items-center justify-end p-4 border-t">
                    <button type="button" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2" onclick="hideModal('editConferenceModal')">
                        Close
                    </button>
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Cancel Conference Modal -->
    <div id="cancelConferenceModal"
         class="fixed inset-0 hidden items-center justify-center bg-gray-500 bg-opacity-75 z-50">
        <div class="bg-white w-full max-w-md rounded shadow-lg">
            <div class="flex items-center justify-between p-4 border-b">
                <h5 class="text-lg font-semibold">Cancel Conference</h5>
                <button class="text-gray-500 hover:text-gray-700" onclick="hideModal('cancelConferenceModal')">
                    &times;
                </button>
            </div>
            <form id="cancelConferenceForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="p-4">
                    <p>Are you sure you want to cancel this conference?</p>
                </div>
                <div class="flex items-center justify-end p-4 border-t">
                    <button type="button" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2" onclick="hideModal('cancelConferenceModal')">
                        Close
                    </button>
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Yes, Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function hideModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        function prepareCancelModal(conferenceId) {
            document.getElementById('cancelConferenceForm').action = `/conferences/${conferenceId}/cancel`;
        }

        function fillEditModal(id, title, organizer, description, startDate, endDate) {
            document.getElementById('edit_conference_id').value = id;
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_organizer').value = organizer;
            document.getElementById('edit_description').value = description;
            document.getElementById('edit_start_date').value = startDate;
            document.getElementById('edit_end_date').value = endDate;
            document.getElementById('editConferenceForm').action = `/conferences/${id}`;
        }
    </script>
</x-app-layout>
