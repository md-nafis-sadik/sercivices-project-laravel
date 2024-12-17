<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment for {{ $plan->name }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script>
        function showDeliveryDetails() {
            var deliveryMethod = document.querySelector('input[name="delivery_method"]:checked').value;
            var deliveryDetails = document.getElementById("delivery_details");

            if (deliveryMethod === "by_air") {
                deliveryDetails.innerHTML = `
                    <label for="flight_number" class="block text-sm font-medium text-gray-700">Flight Number:</label>
                    <input type="text" name="flight_number" id="flight_number" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" placeholder="Enter flight number">

                    <label for="departure_date" class="block text-sm font-medium text-gray-700 mt-4">Departure Date:</label>
                    <input type="date" name="departure_date" id="departure_date" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                `;
            } else if (deliveryMethod === "by_road") {
                deliveryDetails.innerHTML = `
                    <label for="vehicle_number" class="block text-sm font-medium text-gray-700">Vehicle Number:</label>
                    <input type="text" name="vehicle_number" id="vehicle_number" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" placeholder="Enter vehicle number">

                    <label for="driver_name" class="block text-sm font-medium text-gray-700 mt-4">Driver's Name:</label>
                    <input type="text" name="driver_name" id="driver_name" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" placeholder="Enter driver's name">

                    <label for="estimated_arrival" class="block text-sm font-medium text-gray-700 mt-4">Estimated Arrival Date:</label>
                    <input type="date" name="estimated_arrival" id="estimated_arrival" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700">Home Delivery:</label>
                        <label>
                            <input type="radio" name="home_delivery" value="yes" onclick="toggleHomeDelivery(true)"> Yes
                        </label>
                        <label>
                            <input type="radio" name="home_delivery" value="no" onclick="toggleHomeDelivery(false)" checked> No
                        </label>
                    </div>
                    <div id="home_delivery_details" class="mt-4"></div>
                `;
            } else if (deliveryMethod === "by_ship") {
                deliveryDetails.innerHTML = `
                    <label for="ship_name" class="block text-sm font-medium text-gray-700">Ship Name:</label>
                    <input type="text" name="ship_name" id="ship_name" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" placeholder="Enter ship name">

                    <label for="port_of_origin" class="block text-sm font-medium text-gray-700 mt-4">Port of Origin:</label>
                    <input type="text" name="port_of_origin" id="port_of_origin" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" placeholder="Enter port of origin">

                    <label for="port_of_destination" class="block text-sm font-medium text-gray-700 mt-4">Port of Destination:</label>
                    <input type="text" name="port_of_destination" id="port_of_destination" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" placeholder="Enter port of destination">

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700">By Agency:</label>
                        <label>
                            <input type="radio" name="by_agency" value="yes" onclick="toggleAgencyDetails(true)"> Yes
                        </label>
                        <label>
                            <input type="radio" name="by_agency" value="no" onclick="toggleAgencyDetails(false)" checked> No
                        </label>
                    </div>
                    <div id="agency_details" class="mt-4"></div>
                `;
            }
        }

        function toggleHomeDelivery(show) {
            var homeDeliveryDetails = document.getElementById("home_delivery_details");
            if (show) {
                homeDeliveryDetails.innerHTML = `
                    <label for="home_address" class="block text-sm font-medium text-gray-700">Home Address:</label>
                    <input type="text" name="home_address" id="home_address" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" placeholder="Enter home address">
                `;
            } else {
                homeDeliveryDetails.innerHTML = "";
            }
        }

        function toggleAgencyDetails(show) {
            var agencyDetails = document.getElementById("agency_details");
            if (show) {
                agencyDetails.innerHTML = `
                    <label for="agency_name" class="block text-sm font-medium text-gray-700">Agency Name:</label>
                    <input type="text" name="agency_name" id="agency_name" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" placeholder="Enter agency name">

                    <label for="agency_contact" class="block text-sm font-medium text-gray-700 mt-4">Agency Contact:</label>
                    <input type="text" name="agency_contact" id="agency_contact" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" placeholder="Enter agency contact details">
                `;
            } else {
                agencyDetails.innerHTML = "";
            }
        }

        // Set default delivery method to "By Road" and show relevant fields on page load
        window.onload = function() {
            document.getElementById("by_road").checked = true;
            showDeliveryDetails();
        };
    </script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">
<header id="header" class="px-32 py-5 shadow-md">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">
        <a href="#hero" class="logo flex items-center">
            <img src="/assets/img/logo.png" alt="" class="h-[25px]">
            <h1 class="text-[29px] font-semibold text-blue-700 ml-3">FlexStart</h1>
        </a>
    </div>
</header>

<div class="container mx-auto px-8 py-16">
    <div class="bg-white p-6 rounded-lg shadow-md max-w-xl mx-auto">
        <form action="{{ route('packages.store', $plan->id) }}" method="POST">
            @csrf

            <!-- Payment Method -->
            <div class="mb-6">
                <label for="payment_method" class="block text-lg font-medium text-gray-700">Payment Method:</label>
                <select name="payment_method" id="payment_method" class="mt-4 p-2 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="dummy_paypal">PayPal</option>
                    <option value="dummy_stripe">Stripe</option>
                    <option value="dummy_credit_card">Credit Card</option>
                </select>
            </div>

            <!-- Amount -->
            <div class="mb-6">
                <label for="amount" class="block text-lg font-medium text-gray-700">Amount:</label>
                <p id="amount" class="font-semibold text-xl text-gray-900">$ {{ $plan->price }}</p>
            </div>

            <!-- Delivery Method -->
            <div class="mb-6">
                <label class="block text-lg font-medium text-gray-700">Delivery Method:</label>
                <div class="mt-2 space-y-4">
                <label>
                        <input type="radio" name="delivery_method" id="by_road" value="by_road" onclick="showDeliveryDetails()"> By Road
                    </label>
                    <label>
                        <input type="radio" name="delivery_method" value="by_air" onclick="showDeliveryDetails()"> By Air
                    </label>

                    <label>
                        <input type="radio" name="delivery_method" value="by_ship" onclick="showDeliveryDetails()"> By Ship
                    </label>
                </div>
            </div>

            <!-- Delivery Details -->
            <div id="delivery_details" class="mb-6"></div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="px-6 py-3 text-md font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-sm shadow-md transition duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Complete Order
                </button>
            </div>

            <script>
    document.querySelector('form').onsubmit = function(event) {
        console.log('Form data:', new FormData(this));
        return true; // Remove this line if you want the form to submit.
    };
</script>
        </form>
    </div>
</div>
</body>
</html>
