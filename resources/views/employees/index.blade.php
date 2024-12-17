<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Employees') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="container mx-auto p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-700">Employees</h1>
                        <a href="{{ route('employees.create') }}"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Add Employee
                        </a>
                    </div>

                    <div class=" overflow-x-auto">
                        <table id="employees-table" class="min-w-full table-auto w-full border-collapse">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left">ID</th>
                                    <th class="px-4 py-2 text-left">Name</th>
                                    <th class="px-4 py-2 text-left">Position</th>
                                    <th class="px-4 py-2 text-left">Salary</th>
                                    <th class="px-4 py-2 text-left">Image</th>
                                    <th class="px-4 py-2 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <!-- DataTable will populate this -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script>
       $('#employees-table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true, // Enable responsiveness
    ajax: {
        url: '{{ route('employees.data') }}',
        type: 'GET',
    },
    columns: [
        { data: 'id' },
        { data: 'name' },
        { data: 'position' },
        { data: 'salary' },
        {
            data: 'image',
            render: function(data) {
                return data ? '<img src="{{ asset('storage') }}/' + data + '" alt="Employee Image" width="50" height="50">' : 'No Image';
            }
        },
        {
            data: 'action',
            orderable: false,
            searchable: false
        }
    ]
});

    </script>
</x-app-layout>
