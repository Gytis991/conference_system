<div class="container">

    <!-- Button to open modal -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#newConferenceModal">
        New Conference
    </button>

    <!-- Modal -->
    <div class="modal fade" id="newConferenceModal" tabindex="-1" aria-labelledby="newConferenceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('conferences.create') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Create New Conference</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Conference') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <x-input-label for="title" :value="__('Title')" />
                    <input type="text" name="title" class="mt-1 block w-full" required>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <x-input-label for="organizer" :value="__('Organizer')" />
                    <input type="text" name="organizer" class="mt-1 block w-full" required>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea name="description" class="mt-1 block w-full"></textarea>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <x-input-label for="start_date" :value="__('Start Date')" />
                    <input type="date" name="start_date" class="mt-1 block w-full" required>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <x-input-label for="end_date" :value="__('End Date')" />
                    <input type="date" name="end_date" class="mt-1 block w-full" required>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
