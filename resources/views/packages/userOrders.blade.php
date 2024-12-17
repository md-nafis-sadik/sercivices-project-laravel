<x-tap-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container mx-auto p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">Orders</h1>
                    </div>

                    <!-- Orders Table -->
                    <div class="shadow-md rounded-md overflow-x-auto">
                        <table id="orders-table" class="min-w-full table-auto w-full border-collapse">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left">SL</th>
                                    <th class="px-4 py-2 text-left">Customer</th>
                                    <th class="px-4 py-2 text-left">Plan</th>
                                    <th class="px-4 py-2 text-left">Payment Status</th>
                                    <th class="px-4 py-2 text-left">Delivery Status</th>
                                    <th class="px-4 py-2 text-left">Expiry Date</th>
                                    <th class="px-4 py-2 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800">
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
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#orders-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '{{ route('packages.data') }}',
                    type: 'GET',
                },
                columns: [
                    { data: 'id' },
                    { data: 'user.name', name: 'user.name' },
                    { data: 'plan.name', name: 'plan.name' },
                    { data: 'payment_status',
                        render: function(data) {
                            return data.charAt(0).toUpperCase() + data.slice(1);
                        }
                    },
                    {
                        data: 'delivery_status',
                        render: function(data) {
                            let icons = {
                                'yet_to_deliver': '<i class="fas fa-clock text-yellow-500 mr-2"></i> Yet to Deliver',
                                'in_transit': '<i class="fas fa-shipping-fast text-blue-500 mr-2"></i> Shipped',
                                'delivered': '<i class="fas fa-check-circle text-green-500 mr-2"></i> Delivered',
                                'unknown': '<i class="fas fa-question-circle text-gray-500 mr-2"></i> Unknown Status'
                            };
                            return icons[data] || icons['unknown'];
                        }
                    },
                    {
                        data: 'expiry_date',
                        render: function(data) {
                            return data ? new Date(data).toISOString().split('T')[0] : 'N/A';
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
</x-tap-layout>
