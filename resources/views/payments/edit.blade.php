<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Payment') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8 px-12">
        <h1 class="text-2xl font-semibold text-gray-700 mb-6">Edit Payment</h1>

        @if (session('success'))
            <div class="p-4 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
                {{ session('success') }}
            </div>
        @endif

        {!! Form::model($payment, ['route' => ['payments.update', $payment->id], 'method' => 'PUT']) !!}

        <!-- Order -->
        <div class="mb-4">
            {!! Form::label('order_id', 'Order ID', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::select('order_id', $orders->pluck('id', 'id'), old('order_id', $payment->order_id), ['class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md', 'required' => 'required']) !!}
            @error('order_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Amount -->
        <div class="mb-4">
            {!! Form::label('amount', 'Amount', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::number('amount', old('amount', $payment->amount), ['class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md', 'required' => 'required', 'step' => '0.01']) !!}
            @error('amount')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Transaction ID -->
        <div class="mb-4">
            {!! Form::label('transaction_id', 'Transaction ID', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::text('transaction_id', old('transaction_id', $payment->transaction_id), ['class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md']) !!}
            @error('transaction_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Payment Method -->
        <div class="mb-4">
            {!! Form::label('payment_method', 'Payment Method', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::text('payment_method', old('payment_method', $payment->payment_method), ['class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md', 'required' => 'required']) !!}
            @error('payment_method')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status -->
        <div class="mb-4">
            {!! Form::label('status', 'Status', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::select('status', ['pending' => 'Pending', 'completed' => 'Completed', 'failed' => 'Failed'], old('status', $payment->status), ['class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md', 'required' => 'required']) !!}
            @error('status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="mb-4">
            {!! Form::submit('Update Payment', ['class' => 'bg-blue-500 text-white p-2 rounded-md']) !!}
        </div>

        {!! Form::close() !!}
    </div>
</x-app-layout>
