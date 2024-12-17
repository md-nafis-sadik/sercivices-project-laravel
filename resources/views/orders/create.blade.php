<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Order') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8 px-12">
        <h1 class="text-2xl font-semibold text-gray-700 mb-6">Add Order</h1>

        @if (session('success'))
            <div class="p-4 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
                {{ session('success') }}
            </div>
        @endif

        {!! Form::open(['route' => 'orders.store', 'method' => 'POST']) !!}
        @csrf

        <!-- User -->
        <div class="mb-4">
            {!! Form::label('user_id', 'Customer', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::select('user_id', $users->pluck('name', 'id'), old('user_id'), ['class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md', 'required' => 'required']) !!}
            @error('user_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Plan -->
        <div class="mb-4">
            {!! Form::label('plan_id', 'Plan', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::select('plan_id', $plans->pluck('name', 'id'), old('plan_id'), ['class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md', 'required' => 'required']) !!}
            @error('plan_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Payment Status -->
        <div class="mb-4">
            {!! Form::label('payment_status', 'Payment Status', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::select('payment_status', ['pending' => 'Pending', 'completed' => 'Completed', 'failed' => 'Failed'], old('payment_status'), ['class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md', 'required' => 'required']) !!}
            @error('payment_status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Order Date -->
        <div class="mb-4">
            {!! Form::label('order_date', 'Order Date', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::date('order_date', old('order_date'), ['class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md']) !!}
            @error('order_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Expiry Date -->
        <div class="mb-4">
            {!! Form::label('expiry_date', 'Expiry Date', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::date('expiry_date', old('expiry_date'), ['class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md']) !!}
            @error('expiry_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Delivery Method -->
        <div class="mb-4">
            {!! Form::label('delivery_method', 'Delivery Method', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::select('delivery_method', ['by_air' => 'By Air', 'by_road' => 'By Road', 'by_ship' => 'By Ship'], old('delivery_method'), ['class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md', 'required' => 'required']) !!}
            @error('delivery_method')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Flight Number -->
        <div class="mb-4">
            {!! Form::label('flight_number', 'Flight Number', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::text('flight_number', old('flight_number'), ['class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md']) !!}
            @error('flight_number')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Departure Date -->
        <div class="mb-4">
            {!! Form::label('departure_date', 'Departure Date', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::date('departure_date', old('departure_date'), ['class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md']) !!}
            @error('departure_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Vehicle Number -->
        <div class="mb-4">
            {!! Form::label('vehicle_number', 'Vehicle Number', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::text('vehicle_number', old('vehicle_number'), ['class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md']) !!}
            @error('vehicle_number')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Driver Name -->
        <div class="mb-4">
            {!! Form::label('driver_name', 'Driver Name', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::text('driver_name', old('driver_name'), ['class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md']) !!}
            @error('driver_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Estimated Arrival -->
        <div class="mb-4">
            {!! Form::label('estimated_arrival', 'Estimated Arrival', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::date('estimated_arrival', old('estimated_arrival'), ['class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md']) !!}
            @error('estimated_arrival')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Home Delivery -->
        <div class="mb-4">
            {!! Form::label('home_delivery', 'Home Delivery', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::select('home_delivery', ['yes' => 'Yes', 'no' => 'No'], old('home_delivery', 'no'), ['class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md']) !!}
            @error('home_delivery')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Home Address -->
        <div class="mb-4">
            {!! Form::label('home_address', 'Home Address', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::text('home_address', old('home_address'), ['class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md']) !!}
            @error('home_address')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Ship Name -->
        <div class="mb-4">
            {!! Form::label('ship_name', 'Ship Name', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::text('ship_name', old('ship_name'), ['class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md']) !!}
            @error('ship_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Port of Origin -->
        <div class="mb-4">
            {!! Form::label('port_of_origin', 'Port of Origin', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::text('port_of_origin', old('port_of_origin'), ['class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md']) !!}
            @error('port_of_origin')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Port of Destination -->
        <div class="mb-4">
            {!! Form::label('port_of_destination', 'Port of Destination', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::text('port_of_destination', old('port_of_destination'), ['class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md']) !!}
            @error('port_of_destination')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- By Agency -->
        <div class="mb-4">
            {!! Form::label('by_agency', 'By Agency', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::select('by_agency', ['yes' => 'Yes', 'no' => 'No'], old('by_agency', 'no'), ['class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md']) !!}
            @error('by_agency')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Agency Name -->
        <div class="mb-4">
            {!! Form::label('agency_name', 'Agency Name', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::text('agency_name', old('agency_name'), ['class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md']) !!}
            @error('agency_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Agency Contact -->
        <div class="mb-4">
            {!! Form::label('agency_contact', 'Agency Contact', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::text('agency_contact', old('agency_contact'), ['class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md']) !!}
            @error('agency_contact')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="mb-4">
            {!! Form::submit('Save Order', ['class' => 'bg-blue-500 text-white p-2 rounded-md']) !!}
        </div>

        {!! Form::close() !!}
    </div>
</x-app-layout>
