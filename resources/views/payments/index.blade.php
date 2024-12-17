<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Payments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="container mx-auto p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-700">Payments</h1>
                        <a href="{{ route('payments.create') }}"
                            class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Add Payment
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table id="payments-table" class="min-w-full table-auto w-full border-collapse">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left">SL</th>
                                    <th class="px-4 py-2 text-left">Order ID</th>
                                    <th class="px-4 py-2 text-left">Amount</th>
                                    <th class="px-4 py-2 text-left">Payment Method</th>
                                    <th class="px-4 py-2 text-left">Payment Date</th>
                                    <th class="px-4 py-2 text-left">Status</th>
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
            $('#payments-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '{{ route('payments.data') }}',
                    type: 'GET',
                },
                columns: [
                    { data: 'id', render: (data, type, row, meta) => meta.row + 1 },
                    { data: 'order_id' },
                    { data: 'amount', render: (data) => `$${data}` },
                    { data: 'payment_method' },
                    { data: 'payment_date', render: (data) => new Date(data).toLocaleString() },
                    {
                        data: 'status',
                        render: function (data) {
                            if (data === 'pending') {
                                return '<i class="fas fa-clock text-yellow-500 mr-2"></i> Pending';
                            } else if (data === 'completed') {
                                return '<i class="fas fa-check-circle text-green-500 mr-2"></i> Completed';
                            } else if (data === 'failed') {
                                return '<i class="fas fa-times-circle text-red-500 mr-2"></i> Failed';
                            } else {
                                return '<i class="fas fa-question-circle text-gray-500 mr-2"></i> Unknown';
                            }
                        }
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
</x-app-layout>
