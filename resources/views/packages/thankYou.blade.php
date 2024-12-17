<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
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
<body class="bg-gray-50 font-sans">

<header id="header" class="px-32 py-5 shadow-md">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="#hero" class="logo flex items-center">
        <img src="/assets/img/logo.png" alt="" class="h-[25px]">
        <h1 class="text-[29px] font-semibold text-blue-700 ml-3">FlexStart</h1>
      </a>

  </header>

    <div class="container mx-auto px-8 py-12">
        <div class="bg-white px-6 py-8 rounded-lg shadow-md max-w-xl mx-auto">
            <h1 class="text-3xl font-semibold text-center text-blue-600 mb-6">Thank You for Your Order!</h1>

            <p class="text-lg text-gray-800 mb-4">Your order for the <span class="font-semibold">{{ $order->plan->name }}</span> plan has been successfully processed.</p>

            <div class="mb-4">
                <p class="text-gray-600">Order ID: <span class="font-semibold">{{ $order->id }}</span></p>
                <p class="text-gray-600">Payment Status: <span class="font-semibold text-blue-500">{{ $order->payment_status }}</span></p>
                <p class="text-gray-600">Transaction ID: <span class="font-semibold">{{ $order->payment->transaction_id }}</span></p>
                <p class="text-gray-600">Transaction Method: <span class="font-semibold">{{ $order->payment->payment_method }}</span></p>
                <p class="text-gray-600">Amount: <span class="font-semibold">${{ $order->payment->amount }}</span></p>
                <p class="text-gray-600">Expiry Date: <span class="font-semibold">{{ $order->expiry_date }}</span></p>
            </div>

            <div class=" mt-8">
                <a href="/" class="px-6 py-3 text-md font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-sm shadow-md transition duration-300  focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Back to Packages
                </a>
            </div>
        </div>
    </div>

</body>
</html>
