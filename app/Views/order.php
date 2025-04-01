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
    $standardaddress = $session->get('standardaddress');
    $rank = $session->get('user_type'); 
    $user_id = $session->get('user_id');
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://kit.fontawesome.com/5a883bd754.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/restaurant.css">
    <link rel="stylesheet" href="./css/cart.css">
    <link rel="stylesheet" href="./css/order.css">
    <link rel="stylesheet" href="./css/password-change.css">
    <script src="./js/functions.js" defer></script>
    <script src="./js/main.js" defer></script>
    <title>Flavorflow - De beste online bestel-app</title>
    <link rel="shortcut icon" href="./img/F-logo.png" type="image/x-icon">
</head>

<body>  
    <main class="ordercontainer">
        <form class="order" onsubmit="return saveOrderToCookie(event);">
            <div class="order-form">
                <header class="order-header">
                    <h1>Vul hier uw gegevens in.</h1>
                </header>
                <label class="order-names" for="">
                    <div class="order-name">
                        <input class="order-input" style="text-transform: capitalize;" type="text" name="fname" id="fname" placeholder="Jan" value="<?php echo isset($fname) ? $fname : ''; ?>" required>
                        <p class="label">Voornaam</p>
                    </div>
                    <div class="order-name">
                        <input class="order-input" style="text-transform: capitalize;" type="text" name="lname" id="lname" placeholder="Jansen" value="<?php echo isset($lname) ? $lname : ''; ?>" required>
                        <p class="label">Achternaam</p>
                    </div>
                </label>
                <label for="" class="order-email">
                    <input class="order-input" style="text-transform: lowercase;" type="text" name="email" id="email" placeholder="janjansen@voorbeeld.nl" value="<?php echo isset($email) ? $email : ''; ?>" required>
                    <p class="label">E-mail</p>
                </label>
                <label for="" class="order-phone">
                    <input class="order-input valued-input" type="text" name="phone" id="phone" value="<?php echo isset($phone) ? $phone : '+316 '; ?>" placeholder="+316 12345678" required>
                    <p class="label">Telefoon</p>
                </label>
                <label for="" class="order-address">
                    <input class="order-input" type="text" id="searchBargoogle" placeholder="Zoek uw adres..." value="<?php //echo isset($fulladdress) ? $fulladdress : ''; ?>" required>
                    <ul id="customDatalist" class="hidden"></ul>
                </label>
            </div>
            <input type="hidden" id="selectedDelivery" name="deliveryMethod" value="">
            <input type="hidden" name="restaurantId" id="restaurantId" value="<?php echo $restaurant_id; ?>">
            <div class="order-form">
                <label for="" class="order-delivery">
                    <div class="order-deliverycontainer" id="bezorgen">
                        <button class="order-deliverybutton">Bezorgen</button>
                        <i class="fas fa-circle-check check"></i>
                    </div>
                    <div class="order-seperator">
                        <figure class="line"></figure>
                        <p class="order-seperatortext">OF</p>
                        <figure class="line"></figure>
                    </div>
                    <div class="order-deliverycontainer" id="afhalen">
                        <button class="order-deliverybutton">Afhalen</button>
                        <i class="fas fa-circle-check check"></i>
                    </div>
                </label>
                <figure class="line"></figure>
                <div class="order-notecontainer">
                    <textarea class="order-note" name="ordernote" id="ordernote" rows="10" placeholder="Laat hier een bericht achter voor de bezorger"></textarea>
                    <p class="label">Opmerking voor bezorger</p>
                </div>
                <button type="submit" class="order-submit">Betaalmethode selecteren <p class="totalprice-order"> ( € 0,00)</p></a>
            </div>
        </form>
    </main>
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