<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Admin') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8 px-6 max-w-4xl">
        <h1 class="text-2xl font-semibold text-gray-700 mb-6">Edit Admin</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="p-4 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Admin Edit Form -->
        {!! Form::model($admin, ['route' => ['admin.update', $admin->id], 'method' => 'PUT', 'id' => 'admin-form']) !!}
        @csrf

        <!-- Name -->
        <div class="mb-6">
            {!! Form::label('name', 'Name', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::text('name', old('name'), ['id' => 'name', 'class' => 'mt-1 block w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500', 'required' => 'required', 'placeholder' => 'Enter admin name']) !!}
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-6">
            {!! Form::label('email', 'Email', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::email('email', old('email'), ['id' => 'email', 'class' => 'mt-1 block w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500', 'required' => 'required', 'placeholder' => 'Enter admin email']) !!}
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-6">
            {!! Form::label('password', 'Password', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::password('password', ['id' => 'password', 'class' => 'mt-1 block w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500', 'placeholder' => 'Enter new password (optional)']) !!}
            <p class="text-sm text-gray-500 mt-1">Leave blank if you don't want to change the password.</p>
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="mb-6">
            <button type="submit" class="bg-blue-500 text-white font-medium py-2 px-4 rounded-lg hover:bg-blue-600 focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">
                Update Admin
            </button>
        </div>

        {!! Form::close() !!}
    </div>

    <!-- Frontend Form Validation -->
    <script>
    document.getElementById('admin-form').addEventListener('submit', function (event) {
        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();

        let errors = [];

        if (!name) {
            errors.push('Name is required.');
        }
        if (!email) {
            errors.push('Email is required.');
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            errors.push('Please enter a valid email address.');
        }
        if (password && password.length < 8) {
            errors.push('Password must be at least 8 characters long.');
        }

        if (errors.length > 0) {
            event.preventDefault();
            alert(errors.join('\n'));
        }
    });
</script>

</x-app-layout>
