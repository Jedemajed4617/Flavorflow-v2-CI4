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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="/css/index.css" />
    <link rel="stylesheet" href="/css/order.css" />
    <link rel="stylesheet" href="/css/profile.css" />
    <link rel="stylesheet" href="/css/restaurants.css" />
    <link rel="stylesheet" href="/css/notification-error.css" />
    <link rel="stylesheet" href="/css/admin-modal.css" />
    <link rel="stylesheet" href="/css/password-change.css" />
    <link rel="stylesheet" href="/css/login.css" />
    <script src="/js/functions.js" defer></script>
    <script src="/js/main.js" defer></script>
    <title>Flavorflow - De beste online bestel-app</title>
    <link rel="shortcut icon" href="/img/F-logo.png" type="image/x-icon" />
</head>

<body>
    <script>
        $(document).ready(function() {
            const $modal = $(".moreinfocontainer");
            const $modalContent = $(".moreinfo");
            const $openButtons = $(".res-info-listitem > a.edit-order-link");
            const $closeButtons = $(".close-moreinfo");

            if (!$modal.length) {
                console.warn("Error: Order Modal container (.moreinfocontainer) not found.");
                return;
            }
            if (!$openButtons.length) {
                // console.warn("Warning: No order edit links (.edit-order-link) found on page load.");
            }

            function openModal(event) {
                event.preventDefault();

                const $button = $(this);

                const orderId = $button.data("id");
                const orderDate = $button.data("order-date");
                const userName = $button.data("user-name");
                const paymentMethod = $button.data("payment-method");
                const address = $button.data("address");
                const totalPrice = $button.data("total-price");
                const userUsername = $button.data("user-username");
                const userEmail = $button.data("user-email");
                const deliveryStatus = $button.data("delivery-status");
                const phone = $button.data("phone");
                const deliveryNote = $button.data("delivery-note");
                const foodNote = $button.data("food-note");
                const restaurantName = $button.data("restaurantname");
                const birthDate = $button.data("birthdate");
                

                $("#orderid").val(orderId ? "#" + orderId : '');
                $("#orderdate").val(orderDate || '');
                $("#fullname").val(userName || '');
                $("#paymethod").val(paymentMethod || '');
                $("#useradres").val(address || '');
                $("#user").val(userUsername || '');
                $("#email").val(userEmail || '');
                $("#deliverystatus").val(deliveryStatus || '');
                $("#deliverynote").val(deliveryNote || '');
                $("#foodnote").val(foodNote || '');
                $("#resname").val(restaurantName || '');
                $("#dateofbirth").val(birthDate || '');

                const totalPriceFormatted = parseFloat(totalPrice || 0).toFixed(2);
                const totalPriceFormattedminustax = (parseFloat(totalPrice) - parseFloat(totalPrice * 0.21)).toFixed(2);
                $("#priceincl").val(totalPriceFormatted);
                $("#priceexcl").val(totalPriceFormattedminustax);

                $modal.css("display", "flex");
                setTimeout(() => {
                    $modal.addClass("open");
                }, 0);
                $("body").css("overflow", "hidden");
            }

            function closeModal() {
                $modal.addClass("closing");
                setTimeout(() => {
                    $modal.removeClass("open closing");
                    $modal.css("display", "none");
                    $("body").css("overflow", "auto");
                }, 300);
            }

            $openButtons.on("click", openModal);

            $closeButtons.on("click", closeModal);

            $(document).on("keydown", function(event) {
                if (event.key === "Escape" && $modal.hasClass("open")) {
                    closeModal();
                }
            });

        });
    </script>
    <div class="moreinfocontainer">
        <div class="moreinfo">
            <header class="moreinfo-header">
                <h1>Gegevens bestelling</h1>
                <i class="fas fa-times close-moreinfo"></i>
            </header>
            <div class="moreinfo-content">
                <aside class="moreinfo-aside">
                    <figure class="moreinfo-figure">
                        <img src="/img/map.jpg" alt="">
                    </figure>
                </aside>
                <ul class="moreinfo-list">
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="fullname" id="fullname" style="text-transform: capitalize;" value="Jan Jansen" required>
                            <p class="label">Voornaam & Achternaam</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="user" id="user" value="Janjansen12" required>
                            <p class="label">Gebruikersnaam</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="email" id="email" value="janjansen@voorbeeld.com" required>
                            <p class="label">E-mail</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="dateofbirth" id="dateofbirth" value="22/02/2003" required>
                            <p class="label">Geboortedatum</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="orderid" id="orderid" value="#1" required>
                            <p class="label">Order-ID</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="resname" id="resname" value="Bakkerij Raat" required>
                            <p class="label">Naam Restaurant</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="orderdate" id="orderdate" value="12/34/2000" required>
                            <p class="label">Datum & tijd</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" style="color: green !important;" type="text" value="Onderweg" name="deliverystatus" id="deliverystatus" required>
                            <p class="label">Status bezorging</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="useradres" id="useradres" value="Koningshof 25, 1671AM Medemblik" required>
                            <p class="label">Adres</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="paymethod" id="paymethod" value="iDeal" required>
                            <p class="label">Betaalmethode</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="deliverynote" id="deliverynote" value="Hele mooie opmerking" required>
                            <p class="label">Opmerking voor bezorger</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="foodnote" id="foodnote" value="Hele mooie opmerking" required>
                            <p class="label">Opmerking voor eten</p>
                        </label>
                    </li>
                </ul>
            </div>
            <footer class="moreinfo-footer">
                <ul class="moreinfo-footerlist">
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="bill" id="bill" value="Download" required>
                            <p class="label">Download factuur</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="exportexcel" id="exportexcel" value="Exporteer" required>
                            <p class="label">Exporteer naar excel</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="priceincl" id="priceincl" value="14.99" required>
                            <p class="label">Prijs incl.</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="priceexcl" id="priceexcl" value="12.99" required>
                            <p class="label">Prijs excl.</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" style="color: orange;" type="text" name="paystatus" id="paystatus" value="Pending" required>
                            <p class="label">Status betaling</p>
                        </label>
                    </li>
                </ul>
            </footer>
        </div>
    </div>
    <main class="profile">
        <aside class="profile-navigation">
            <div class="profile-container">
                <header class="profile-header">
                    <h1>Welkom <p style="text-transform: capitalize;"><?php echo $fname; ?></p>
                    </h1>
                </header>
                <ul class="profile-list">
                    <li class="profile-listitem">
                        <div class="profile-listitem-container">
                            <i class="fas fa-user"></i>
                            <a href="<?= site_url('profile'); ?>">Mijn Profiel</a>
                        </div>
                    </li>
                    <li class="profile-listitem">
                        <div class="profile-listitem-container">
                            <i class="fas fa-bag-shopping"></i>
                            <a href="<?= site_url('profile/orders'); ?>">Mijn Bestellingen</a>
                        </div>
                    </li>
                    <li class="profile-listitem">
                        <div class="profile-listitem-container">
                            <i class="fas fa-bell"></i>
                            <a href="<?= site_url('profile/notifications'); ?>">Mijn Meldingen</a>
                        </div>
                    </li>
                    <li class="profile-listitem">
                        <div class="profile-listitem-container">
                            <i class="fas fa-location-dot"></i>
                            <a href="<?= site_url('profile/addresses'); ?>">Mijn Adressen</a>
                        </div>
                    </li>
                    <li class="profile-listitem">
                        <div class="profile-listitem-container">
                            <i class="fas fa-tags"></i>
                            <a href="<?= site_url('profile/stamps'); ?>">Stempelkaart</a>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- Alleen een restauranteigenaar kan dit zien: -->
            <?php
            if ($rank == "res_owner" && !is_null($restaurant_id)) {
            ?>
                <div class="profile-container admin">
                    <header class="profile-header">
                        <h1>Mijn Restaurant</h1>
                    </header>
                    <ul class="profile-list">
                        <li class="profile-listitem">
                            <div class="profile-listitem-container active">
                                <i class="fas fa-chart-line"></i>
                                <a href="<?= site_url('dashboard/orderoverview/' . $restaurant_id) ?>">Order overzicht</a>
                            </div>
                        </li>
                        <li class="profile-listitem">
                            <div class="profile-listitem-container">
                                <i class="fas fa-list-ul"></i>
                                <a href="<?= site_url('dashboard/productoverview/' . $restaurant_id) ?>">Producten</a>
                            </div>
                        </li>
                        <li class="profile-listitem">
                            <div class="profile-listitem-container">
                                <i class="fas fa-gear"></i>
                                <a href="<?= site_url('dashboard/restaurantsettings/' . $restaurant_id) ?>">Instellingen</a>
                            </div>
                        </li>
                    </ul>
                </div>
            <?php
            } else {
                echo "";
            }
            ?>
            <!-- Alleen een admin kan dit zien: -->
            <?php
            if ($rank == "admin") {
            ?>
                <div class="profile-container admin">
                    <header class="profile-header">
                        <h1>Mijn Dashboard</h1>
                    </header>
                    <ul class="profile-list">
                        <li class="profile-listitem">
                            <div class="profile-listitem-container">
                                <i class="fas fa-chart-line"></i>
                                <a href="<?= site_url('dashboard/adminorders') ?>">Alle orders</a>
                            </div>
                        </li>
                        <li class="profile-listitem">
                            <div class="profile-listitem-container">
                                <i class="fas fa-list-ul"></i>
                                <a href="<?= site_url('dashboard/adminrestaurants') ?>">Restaurants</a>
                            </div>
                        </li>
                    </ul>
                </div>
            <?php
            } else {
                echo "";
            }
            ?>
        </aside>
        <section class="profile-content">
            <span class="adminnotvisiblemsg">Pagina's niet beschikbaar voor telefoon! <small>Open de website op een tablet of pc of ga verder door de navigatie te klikken</small></span>
            <div class="profile-info admindisplaynoneby1000px">
                <header class="profile-headercontainer">
                    <div class="profile-headerheading">
                        <h1>Order overzicht</h1>
                        <p>Alle orders op een rij</p>
                    </div>
                    <ul class="order-filters">
                        <li class="searchbar">
                            <input type="text" name="search" id="search" placeholder="Zoeken naar orders" />
                            <i class="fas fa-search inputicon"></i>
                        </li>
                        <li class="refreshcontainer">
                            <button class="refresh"><i class="fas fa-refresh"></i></button>
                        </li>
                        <li class="order-filtercontainer">
                            <select class="order-filter" name="status-filter" id="status-filter">
                                <option class="order-filteritem" value="all">Alle</option>
                                <option class="order-filteritem" value="delivered">Afgeleverd</option>
                                <option class="order-filteritem" value="pending">Onderweg</option>
                                <option class="order-filteritem" value="cancelled">Geannuleerd</option>
                            </select>
                        </li>
                    </ul>
                </header>
                <ul class="res-info-headers">
                    <li class="res-info-header">
                        <b>ID</b>
                    </li>
                    <li class="res-info-header">
                        <b>Datum</b>
                    </li>
                    <li class="res-info-header">
                        <b>Naam</b>
                    </li>
                    <li class="res-info-header">
                        <b>Methode</b>
                    </li>
                    <li class="res-info-header">
                        <b>Adres</b>
                    </li>
                    <li class="res-info-header">
                        <b>Bedrag</b>
                    </li>
                </ul>
                <ul class="profile-info-list">
                    <?php
                    // Assuming $orders comes from the updated getAllRestaurantOrdersWithTotals
                    foreach ($orders as $order) {
                        // --- Standard Order Data ---
                        $order_id = $order['order_id'];
                        $order_date = $order['order_date'] ?? 'N/A';
                        $customer_name = trim(($order['fname'] ?? '') . ' ' . ($order['lname'] ?? ''));
                        if(empty($customer_name)) $customer_name = 'N/A';

                        $payment_method = $order['payment_method'] ?? 'Er is iets misgegaan';
                        $address = $order['address'] ?? 'N/A';
                        $total_price_raw = $order['total_order_price'] ?? 0;
                        $total_price_formatted = number_format($total_price_raw, 2, ',', '.');
                        $email = $order['email'] ?? 'N/A';
                        $delivery_method = $order['delivery_method'] ?? 'Geen bezorgmethode gekozen';
                        $phone = $order['phone'] ?? 'N/A';
                        $delivery_note = $order['order_delivery_note'] ?? 'Geen bericht achtergelaten';
                        $food_note = $order['order_food_note'] ?? 'Geen bericht achtergelaten';

                        $restaurant_name = $order['restaurant_name'] ?? 'Geen restaurant gevonden';

                        $user_id = $order['user_id'];
                        $user_username = $order['username'] ?? "Geen account gevonden";
                        $birthdate = $order['date_of_birth'] ?? "Geen account gevonden";

                        echo '<li class="res-info-listitem">';
                        echo '<p>' . htmlspecialchars($order_id) . '</p>';
                        echo '<p>' . htmlspecialchars($order_date) . '</p>';
                        echo '<p>' . htmlspecialchars($customer_name) . '</p>';
                        echo '<p>' . htmlspecialchars(ucfirst($payment_method)) . '</p>';
                        echo '<p>' . htmlspecialchars($address) . '</p>';
                        echo '<p>€ ' . $total_price_formatted . '</p>';

                        // --- Link with Data Attributes ---
                        // Now $restaurant_name (correct spelling) is used here
                        echo '<a href="#" class="edit-order-link"
                                data-id="' . htmlspecialchars($order_id) . '"
                                data-restaurantname="' . htmlspecialchars($restaurant_name) . '"
                                data-order-date="' . htmlspecialchars($order_date) . '"
                                data-user-name="' . htmlspecialchars($customer_name) . '" ' .
                                'data-payment-method="' . htmlspecialchars($payment_method) . '"
                                data-address="' . htmlspecialchars($address) . '"
                                data-total-price="' . htmlspecialchars($total_price_raw) . '"
                                data-user-username="' . htmlspecialchars($user_username ?? '') . '" ' .
                                'data-user-email="' . htmlspecialchars($email) . '" ' .
                                'data-delivery-status="' . htmlspecialchars($delivery_method) . '" ' .
                                'data-phone="' . htmlspecialchars($phone) . '" ' .
                                'data-delivery-note="' . htmlspecialchars($delivery_note) . '"
                                data-food-note="' . htmlspecialchars($food_note) . '"
                                data-birthdate="' . htmlspecialchars($birthdate ?? '') . '" ' .
                                '>Bekijken</a>';
                        echo '</li>';
                    }
                    ?>
                </ul>
            </div>
        </section>
    </main>

    <main class="phone-profile">
        <header class="phone-profile-header">
            <i onclick="window.location.href = '<?= site_url('/') ?>'" class="fas fa-chevron-left"></i>
            <h1>Mijn Profiel</h1>
            <i class="fas fa-gear"></i>
        </header>
        <section class="phone-profile-info">
            <ul class="phone-profile-info-list">
                <li class="phone-profile-info-listitem">
                    <figure class="phone-profile-info-figure">
                        <?php
                        if (!empty($profileimg)) {
                            echo '<img src="' . $profileimg . '" alt="">';
                        } else {
                            echo '<i class="fas fa-user profile-edit-icon"></i>';
                        }
                        ?>
                        <div class="phone-profile-info-figureicon" onclick="openPopup('profileimgcontainer', 'close-profileimg');">
                            <i class="fa-solid fa-camera"></i>
                        </div>
                    </figure>
                </li>
                <li class="phone-profile-info-listitem">
                    <b><?php echo $fullname; ?></b>
                    <p><?php echo $email; ?></p>
                    <button onclick="window.location.href = '<?= site_url('profile/editprofile') ?>'">Bewerk profiel</button>
                </li>
            </ul>
        </section>
        <ul class="phone-profile-navigation">
            <li class="phone-profile-navigation-item">
                <div class="phone-profile-itemcontent">
                    <i class="fas fa-bag-shopping"></i>
                    <a href="<?= site_url('profile/orders'); ?>">Mijn Bestellingen</a>
                </div>
                <i class="fas fa-arrow-right"></i>
            </li>
            <li class="phone-profile-navigation-item">
                <div class="phone-profile-itemcontent">
                    <i class="fas fa-bell"></i>
                    <a href="<?= site_url('profile/notifications'); ?>">Mijn Meldingen</a>
                </div>
                <i class="fas fa-arrow-right"></i>
            </li>
            <li class="phone-profile-navigation-item">
                <div class="phone-profile-itemcontent">
                    <i class="fas fa-location-pin"></i>
                    <a href="<?= site_url('profile/addresses'); ?>">Mijn Adressen</a>
                </div>
                <i class="fas fa-arrow-right"></i>
            </li>
            <li class="phone-profile-navigation-item">
                <div class="phone-profile-itemcontent">
                    <i class="fas fa-tags"></i>
                    <a href="<?= site_url('profile/stamps'); ?>">Stempelkaart</a>
                </div>
                <i class="fas fa-arrow-right"></i>
            </li>
        </ul>
        <br>
        <div class="navbar-logoutcontainer">
            <a href="<?= site_url('account/logout') ?>" class="navbar-logoutbutton">Uitloggen</a>
        </div>
    </main>

    <div class="footer-container">
        <div class="footer-copyright" style="width: 100%;">
            <figure class="copyright-line"></figure>
            <p class="footer-copyrighttext">© 2025 Flavorflow. Alle rechten voorbehouden.</p>
        </div>
    </div>
</body>

</html>