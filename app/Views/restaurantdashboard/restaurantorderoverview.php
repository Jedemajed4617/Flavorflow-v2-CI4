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
            const $openButtons = $(".res-info-listitem > a");
            const $closeButtons = $(".close-moreinfo");

            if (!$modal.length || !$modalContent.length) {
                console.warn("Error: Modal elements not found.");
                return;
            }

            function openModal(event) {
                event.preventDefault();

                // Populate the modal with dish data
                const $button = $(this);
                const dishId = $button.data("id");
                const dishName = $button.data("name");
                const dishPrice = $button.data("price");
                const dishCategory = $button.data("category");
                const dishCreated = $button.data("created");
                const dishDiscount = $button.data("discount");
                const dishCreatedBy = $button.data("createdBy");
                const dishStatus = $button.data("status");
                const dishDescription = $button.data("description");
                const dishPriceVat = (dishPrice * 0.79).toFixed(2);
                const dishImage = $button.data("pimage");

                $("#show_dish_id").val("#" + dishId);
                $("#show_dish_name").val(dishName);
                $("#show_dish_price").val("€ " + dishPrice);
                $("#dish_category2").val(dishCategory);
                $("#show_when_created").val(dishCreated);
                $("#show_created_by").val(dishCreatedBy);
                $("#show_discount").val(dishDiscount);
                $("#show_status").val(dishStatus);
                $("#show_dish_desc").val(dishDescription);
                $("#show_dish_pricevat").val("€ " + dishPriceVat);
                $("#show_dish_img").attr("src", dishImage);

                // Open modal
                $modal.css("display", "flex");

                // Ensure animation triggers after display change
                setTimeout(() => {
                    $modal.addClass("open");
                }, 0);

                $("body").css("overflow", "hidden");
            }

            function closeModal() {
                $modal.addClass("closing");
                setTimeout(() => {
                    $modal.removeClass("open closing");
                    $modal.css("display", "none"); // Hide modal after animation
                    $("body").css("overflow", "auto");
                }, 300); // Match CSS transition time
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
                                <a href="<?= site_url('dashboard/orderoverview/' . $restaurant_id)?>">Order overzicht</a>
                            </div>
                        </li>
                        <li class="profile-listitem">
                            <div class="profile-listitem-container">
                                <i class="fas fa-list-ul"></i>
                                <a href="<?= site_url('dashboard/productoverview/' . $restaurant_id)?>">Producten</a>
                            </div>
                        </li>
                        <li class="profile-listitem">
                            <div class="profile-listitem-container">
                                <i class="fas fa-gear"></i>
                                <a href="<?= site_url('dashboard/restaurantsettings/' . $restaurant_id)?>">Instellingen</a>
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
                        <b>Status</b>
                    </li>
                    <li class="res-info-header">
                        <b>Adres</b>
                    </li>
                    <li class="res-info-header">
                        <b>Bedrag</b>
                    </li>
                </ul>
                <ul class="profile-info-list">
                    <li class="res-info-listitem">
                        <p>#0006</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                        <p>Afgeleverd</p>
                        <p>Kruistraat 14, Amsterdam</p>
                        <p>€ 37,98</p>
                        <a href="">Veranderen</a>
                    </li>
                    <li class="res-info-listitem">
                        <p>#0005</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                        <p>Afgeleverd</p>
                        <p>Kruistraat 14, Amsterdam</p>
                        <p>€ 37,98</p>
                        <a href="">Veranderen</a>
                    </li>
                    <li class="res-info-listitem">
                        <p>#0004</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                        <p>Afgeleverd</p>
                        <p>Kruistraat 14, Amsterdam</p>
                        <p>€ 37,98</p>
                        <a href="">Veranderen</a>
                    </li>
                    <li class="res-info-listitem">
                        <p>#0003</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                        <p>Afgeleverd</p>
                        <p>Kruistraat 14, Amsterdam</p>
                        <p>€ 37,98</p>
                        <a href="">Veranderen</a>
                    </li>
                    <li class="res-info-listitem">
                        <p>#0002</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                        <p>Afgeleverd</p>
                        <p>Kruistraat 14, Amsterdam</p>
                        <p>€ 37,98</p>
                        <a href="">Veranderen</a>
                    </li>
                    <li class="res-info-listitem">
                        <p>#0001</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                        <p>Afgeleverd</p>
                        <p>Kruistraat 14, Amsterdam</p>
                        <p>€ 37,98</p>
                        <a href="">Veranderen</a>
                    </li>
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