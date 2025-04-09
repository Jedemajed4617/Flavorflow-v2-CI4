<?php

$session = session();

if ($session->get('logged_in')) {
    $fname = $session->get('fname');
    $lname = $session->get('lname');
    $fullname = $fname . ' ' . $lname;
    $username = $session->get('username');
    $email = $session->get('email');
    $phone = $session->get('phone');
    $checkbirthdate = $session->get('birthdate');
    $gender = $session->get('gender');
    $profileimg = $session->get('profile_img_src');
    $address = $session->get('address');
    $rank = $session->get('user_type');
    $user_id = $session->get('user_id');
    if (!empty($activeaddress)) {
        $fulladdress = $activeaddress['street_name'] . ' ' . $activeaddress['street_number'] . $activeaddress['street_number_addition'] . ', ' . $activeaddress['postal_code'] . ' ' . $activeaddress['city'] . ', ' . $activeaddress['province'];
    } else {
        $fulladdress = "";
    }
}



if (empty($checkbirthdate)) {
    $birthdate = "Niet ingesteld";
} else {
    $birthdate = $checkbirthdate;
}

$restaurant_id = $session->get('restaurant_id');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover user-scalable=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://kit.fontawesome.com/5a883bd754.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= base_url('css/index.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/restaurant.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cart.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/password-change.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/order.css') ?>">
    <script src="<?= base_url('js/functions.js') ?>" defer></script>
    <script src="<?= base_url('js/cart-logic.js') ?>" defer></script>
    <script src="<?= base_url('js/main.js') ?>" defer></script>
    <title>Flavorflow - De beste online bestel-app</title>
    <link rel="shortcut icon" href="<?= base_url('img/F-logo.png') ?>" type="image/x-icon">
</head>

<body>
    <main class="ordercontainer">
        <div class="order-wrapper">
            <div class="order-form-left">
                <header class="order-header">
                    <h1>Vul uw gegevens in</h1>
                    <p class="order-subheader">
                        Controleer uw gegevens voor de bestelling.
                    </p>
                </header>
                <div class="order-form">
                    <div class="order-form-group">
                        <label class="order-name" for="fname">
                            <input class="order-input" type="text" name="fname" id="fname"
                                value="<?php echo isset($fname) ? $fname : ''; ?>" required>
                            <span class="label">Voornaam</span>
                        </label>
                        <label class="order-name" for="lname">
                            <input class="order-input" type="text" name="lname" id="lname"
                                value="<?php echo isset($lname) ? $lname : ''; ?>" required>
                            <span class="label">Achternaam</span>
                        </label>
                    </div>
                    <label class="order-email" for="email">
                        <input class="order-input" type="email" name="email" id="email"
                            value="<?php echo isset($email) ? $email : ''; ?>" required>
                        <span class="label">E-mail</span>
                    </label>
                    <label class="order-phone" for="phone">
                        <input class="order-input valued-input" type="text" name="phone" id="phone"
                            value="<?php echo isset($phone) ? $phone : '+316 '; ?>" placeholder="+316" required>
                        <span class="label">Telefoon</span>
                    </label>
                    <label class="order-address" for="searchBargoogle">
                        <input class="order-input" type="text" id="searchBargoogle"
                            value="<?php echo isset($fulladdress) ? $fulladdress : ''; ?>" required>
                        <span class="label">Adres</span>
                        <ul id="customDatalist" class="hidden"></ul>
                    </label>
                </div>
            </div>

            <div class="order-form-right">
                <div class="order-delivery-options order-form">
                    <h2 class="order-form-title">Bezorging of afhalen</h2>
                    <div class="order-delivery" id="bezorgen">
                        <button type="button" class="order-deliverybutton">Bezorgen</button>
                        <i class="fas fa-circle-check check"></i>
                    </div>
                    <div class="order-seperator">
                        <figure class="line"></figure>
                        <p class="order-seperatortext">OF</p>
                        <figure class="line"></figure>
                    </div>
                    <div class="order-delivery" id="afhalen">
                        <button type="button" class="order-deliverybutton">Afhalen</button>
                        <i class="fas fa-circle-check check"></i>
                    </div>
                </div>

                <div class="order-note-section order-form">
                    <h2 class="order-form-title">Opmerking</h2>
                    <div class="order-notecontainer">
                        <textarea class="order-note" name="ordernote" id="ordernote" rows="4"
                            placeholder="Opmerkingen voor de bezorger..."></textarea>
                        <span class="label">Opmerking</span>
                    </div>
                </div>

                <div class="order-checkout-section order-form">
                    <button type="button" onclick="return saveOrderToCookie(event);" class="order-submit">
                        Betaalmethode selecteren <span class="totalprice-order">(€ 0,00)</span>
                    </button>
                </div>
            </div>
        </div>
        <input type="hidden" id="selectedDelivery" name="deliveryMethod" value="">
        <input type="hidden" name="restaurantId" id="restaurantId" value="<?php echo $restaurant_id; ?>">
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- 1. Get the element to update ---
            const priceElement = document.querySelector('.order-submit .totalprice-order');
            if (!priceElement) {
                console.error("Order button price element not found.");
                return;
            }

            // --- 2. Ensure the function to get cart data exists ---
            // This assumes getCartFromCookies() is defined globally by cart-logic.js
            if (typeof getCartFromCookies !== 'function') {
                console.error("getCartFromCookies function is not available.");
                priceElement.textContent = "(Error)"; // Indicate a problem
                return;
            }

            // --- 3. Get Cart Data ---
            const cartData = getCartFromCookies();

            // --- 4. Calculate Subtotal ---
            let subtotal = 0;
            if (cartData && cartData.length > 0) {
                cartData.forEach(item => {
                    const price = parseFloat(item.price) || 0;
                    const quantity = parseInt(item.quantity, 10) || 1;
                    subtotal += price * quantity;
                });
            } else {
                // Optional: Handle case where user somehow lands here with an empty cart
                console.warn("Cart is empty on order page.");
                // You might want to disable the submit button or redirect
                // document.querySelector('.order-submit').disabled = true;
            }

            // --- 5. Calculate Delivery and Total ---
            // IMPORTANT: Use the EXACT SAME logic/values as in your renderCart function
            let deliveryCost = 0.00;
            const minimumOrderAmount = 15.00; // Use the same value as in renderCart
            const deliveryFee = 3.50; // Use the same value as in renderCart

            if (subtotal > 0 && subtotal < minimumOrderAmount) {
                deliveryCost = deliveryFee;
            }
            const total = subtotal + deliveryCost;

            // --- 6. Update Button Text ---
            priceElement.textContent = `(€ ${total.toFixed(2)})`;

        });
    </script>
    <script>
        function saveOrderToCookie(event) {
            event.preventDefault();

            const fname = document.getElementById("fname").value;
            const lname = document.getElementById("lname").value;
            const email = document.getElementById("email").value;
            const phone = document.getElementById("phone").value;
            const address = document.getElementById("searchBargoogle").value;
            const ordernote = document.getElementById("ordernote").value;
            const deliveryMethod = document.getElementById("selectedDelivery").value;
            const restaurantId = document.getElementById("restaurantId").value;

            if (!fname || !lname || !email || !phone || !address || !deliveryMethod) {
                showCustomMessage("Niet alle velden zijn ingevuld.", false);
                return false;
            }

            const orderData = {
                fname: fname,
                lname: lname,
                email: email,
                phone: phone,
                address: address,
                ordernote: ordernote,
                deliveryMethod: deliveryMethod,
                restaurantId: restaurantId
            };

            document.cookie = `orderData=${JSON.stringify(orderData)}; max-age=${7 * 24 * 60 * 60}; path=/`;

            window.location.href = `<?= site_url('/payment') ?>`;
            return true;
        }
    </script>
</body>

</html>