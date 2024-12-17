<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Plans') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="container mx-auto p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-700">Plans</h1>
                        <a href="{{ route('plans.create') }}"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Add Plan
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table id="plans-table" class="min-w-full table-auto w-full border-collapse">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left">SL</th>
                                    <th class="px-4 py-2 text-left">Name</th>
                                    <th class="px-4 py-2 text-left">Price</th>
                                    <th class="px-4 py-2 text-left">Icon</th>
                                    <th class="px-4 py-2 text-left">Color</th>
                                    <th class="px-4 py-2 text-left">Features</th>
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
        $(document).ready(function () {
            $('#plans-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true, // Enable responsiveness
                ajax: {
                    url: '{{ route('plans.data') }}',
                    type: 'GET',
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'price', name: 'price', render: function(data) {
                        return '৳' + parseFloat(data).toFixed(1);
                    } },
                    { data: 'icon', name: 'icon' },
                    { data: 'color', name: 'color' },
                    {
                        data: 'features',
                        name: 'features',
                        render: function(data) {
                            return data.map(feature => `<div class='truncate w-40'>${feature.description}</div>`).join('');
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                                <a href="/plans/${row.id}/edit" class="text-blue-600">Edit</a> |
                                <form action="/plans/${row.id}" method="POST" onsubmit="return confirmDelete()" class="inline">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="text-red-600">Delete</button>
                                </form>`;
                        }
                    }
                ]
            });
        });

        function confirmDelete() {
            return confirm("Are you sure you want to delete this plan?");
        }
    </script>
</x-app-layout>
