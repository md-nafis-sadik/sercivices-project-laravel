<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $plan->name }} Details</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])


        <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans antialiased">

<header id="header" class="px-32 py-5 shadow-md">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="#hero" class="logo flex items-center">
        <img src="/assets/img/logo.png" alt="" class="h-[25px]">
        <h1 class="text-[29px] font-semibold text-blue-700 ml-3">FlexStart</h1>
      </a>

  </header>

    <div class="max-w-full mx-auto p-12 md:px-32 py-10">
        <div class=" block md:flex justify-between">
            <div>
                <a href="/" class="mb-8 text-blue-700">< Back to home</a>
            <h1 class="text-4xl font-semibold text-gray-800 mt-8 mb-4">Checkout</h1>
            <p class="text-md text-gray-500 mb-6">Click on proceed to payment to go to next page</p>

            <div class="text-lg text-gray-700 mb-4">
                <p><strong>Name:</strong> {{ $plan->name }}</p>

                <p><strong>Duration:</strong> {{ $plan->duration }} days</p>
            </div>

            <div class="text-md text-gray-600 mb-6">
                <p><strong>Description:</strong></p>
                @foreach($plan->features as $feature)
                    <div class="mb-3">{!! html_entity_decode($feature->description) !!}</div>
                @endforeach
            </div>

            </div>

            <div class="bg-white p-6 rounded-sm shadow-lg flex flex-col justify-between w-72">
<div class="bg-gradient-to-t rounded-sm from-blue-500 to-blue-400 p-8 flex flex-col justify-start h-20 mb-3">
<p class="text-white">{{ $plan->name }}</p>
</div>
<div class="text-md font-semibold py-2 border-b mb-6">Payment Details</div>

<span class="text-3xl text-center mb-4">1 item</span>
<div class="flex justify-between w-full py-2 text-sm"><span>Total</span> <span> ${{ $plan->price }}</span></div>
<div class="flex justify-between w-full py-2 mb-4 text-sm"><span>Discount</span> <span> $0 </span></div>
<div class="flex justify-between w-full py-4 border-t"><span class="text-lg">Total</span> <span class="text-2xl"> ${{ $plan->price }}</span></div>

                <a href="{{ route('packages.payment', $plan->id) }}" class="inline-block px-6 py-3 text-md font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-sm shadow-md transition duration-300">
                    Proceed to Payment
                </a>
            </div>
        </div>
    </div>

</body>
</html>
