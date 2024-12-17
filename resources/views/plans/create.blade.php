<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Plan') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8 px-12">
        <h1 class="text-2xl font-semibold text-gray-700 mb-6">Add Plan</h1>

        @if (session('success'))
            <div class="p-4 mb-4 text-green-700 bg-green-100 border border-green-400 rounded">
                {{ session('success') }}
            </div>
        @endif

        {!! Form::open(['route' => 'plans.store', 'method' => 'POST', 'id' => 'plan-form', 'enctype' => 'multipart/form-data']) !!}
        @csrf

        <!-- Name -->
        <div class="mb-4">
            {!! Form::label('name', 'Name', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::text('name', old('name'), ['id' => 'name', 'class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md', 'required' => 'required']) !!}
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Price -->
        <div class="mb-4">
            {!! Form::label('price', 'Price', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::number('price', old('price'), ['id' => 'price', 'class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md', 'required' => 'required', 'min' => '0', 'max' => '1000000', 'step' => '0.01']) !!}
            @error('price')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Icon -->
        <div class="mb-4">
            {!! Form::label('icon', 'Icon', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::text('icon', old('icon'), ['id' => 'icon', 'class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md', 'placeholder' => 'e.g., bi bi-box', 'required' => 'required']) !!}
            @error('icon')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Color -->
        <div class="mb-4">
            {!! Form::label('color', 'Color', ['class' => 'block text-sm font-medium text-gray-700']) !!}
            {!! Form::text('color', old('color'), ['id' => 'color', 'class' => 'mt-1 block w-full p-2 border border-gray-300 rounded-md', 'placeholder' => '#20c997']) !!}
            @error('color')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
    {!! Form::label('features', 'Features', ['class' => 'block text-sm font-medium text-gray-700']) !!}
    <div id="features-container">
        <div class="feature-group">
            <label for="features[0][description]" class="block text-sm font-medium text-gray-700">Feature Description</label>
            <textarea name="features[0][description]" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required></textarea>
        </div>
    </div>
    @error('features')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>


        <!-- Display Errors -->
        @if ($errors->any())
            <div class="p-4 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Submit Button -->
        <div class="mb-4">
            {!! Form::submit('Save Plan', ['class' => 'bg-blue-500 text-white p-2 rounded-md']) !!}
        </div>

        {!! Form::close() !!}
    </div>

    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/jtf6xt4qh84pd4uojuda81y7h31wuzwti4hpipgg80w2qb9u/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

<!-- Place the following <script> and <textarea> tags your HTML's <body> -->
<script>
  tinymce.init({
    selector: 'textarea',
    plugins: [
      'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
    ],
    toolbar: 'undo redo | bold italic underline | link image media | align | numlist bullist | removeformat',
    tinycomments_mode: 'embedded',
    tinycomments_author: 'Author name',

    // Sync content before submission
    setup: function (editor) {
      editor.on('init', function () {
        // Sync the content when the editor is initialized
        editor.setContent(document.querySelector('textarea').value || '');
      });

      editor.on('change', function () {
        // Update the original textarea on change
        editor.save();
      });

      const form = document.getElementById('plan-form');
      if (form) {
        form.addEventListener('submit', function (e) {
          // Sync content before form submission
          editor.save();
        });
      }
    }
  });


  document.addEventListener('DOMContentLoaded', () => {
    // Initialize CKEditor for the feature description textarea
    let editorInstance;

    // Function to initialize CKEditor for dynamic features
    function initEditorForFeature(featureIndex) {
        const featureTextarea = document.querySelector(`#feature_description_${featureIndex}`);
        if (featureTextarea) {
            ClassicEditor.create(featureTextarea).then(editor => {
                editorInstance = editor;
            }).catch(error => {
                console.error(error);
            });
        }
    }

    // Initialize CKEditor for the first feature
    initEditorForFeature(0);

    // Add Event listener to dynamically add new features
    document.getElementById('add-feature').addEventListener('click', () => {
        const featureIndex = document.querySelectorAll('.feature-group').length;

        // Create new feature group
        const newFeatureGroup = document.createElement('div');
        newFeatureGroup.classList.add('feature-group');
        newFeatureGroup.innerHTML = `
            <label for="features[${featureIndex}][description]" class="block text-sm font-medium text-gray-700">Feature Description</label>
            <textarea id="feature_description_${featureIndex}" name="features[${featureIndex}][description]" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required></textarea>
        `;

        document.getElementById('features-container').appendChild(newFeatureGroup);

        // Initialize CKEditor for the newly added feature
        initEditorForFeature(featureIndex);
    });

    // Before form submission, sync CKEditor content back to the textarea
    const form = document.getElementById('plan-form');
    form.addEventListener('submit', (e) => {
        const name = document.getElementById('name').value.trim();
        const price = document.getElementById('price').value.trim();
        let valid = true;

        // Validate if name and price are valid
        if (!name || !price || isNaN(price) || price <= 0) {
            valid = false;
            alert("Please fill out the name and price correctly.");
        }

        // Validate feature descriptions
        const featureDescriptions = document.querySelectorAll('[name^="features["][name$="][description]"]');
        featureDescriptions.forEach((textarea, index) => {
            const editorData = editorInstance ? editorInstance.getData() : textarea.value.trim();
            if (!editorData) {
                valid = false;
                alert(`Please fill out the feature description for feature ${index + 1}.`);
            }
        });

        if (!valid) {
            e.preventDefault();
        }
    });
});

function scriptStripper(input) {
            return input.replace(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi, '');
        }
</script>


</x-app-layout>
