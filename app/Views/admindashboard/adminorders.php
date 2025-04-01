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
    $checkforgender = $session->get('gender');
    $profileimg = $session->get('profile_img_src');
    $standardaddress = $session->get('standardaddress');
    $rank = $session->get('user_type');
}

$standardaddress = "Niet ingesteld";

if (empty($checkforgender && $checkbirthdate)) {
    $gender = "Niet ingesteld";
    $birthdate = "Niet ingesteld";
} else {
    $gender = ($checkforgender === 'male') ? 'Man' : (($checkforgender === 'female') ? 'Vrouw' : $checkforgender);
    $birthdate = $checkbirthdate;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/css/index.css" />
    <link rel="stylesheet" href="/css/order.css" />
    <link rel="stylesheet" href="/css/profile.css" />
    <link rel="stylesheet" href="/css/restaurants.css" />
    <link rel="stylesheet" href="/css/notification-error.css" />
    <link rel="stylesheet" href="/css/password-change.css" />
    <link rel="stylesheet" href="/css/login.css" />
    <link rel="stylesheet" href="/css/admin-modal.css">
    <script src="/js/functions.js" defer></script>
    <script src="/js/main.js" defer></script>
    <title>Flavorflow - De beste online bestel-app</title>
    <link rel="shortcut icon" href="./img/F-logo.png" type="image/x-icon" />
</head>

<body>
    <div class="moreinfocontainer">
        <div class="moreinfo">
            <header class="moreinfo-header">
                <h1>Gegevens overzicht</h1>
                <i class="fas fa-times close-moreinfo"></i>
            </header>
            <div class="moreinfo-content">
                <aside class="moreinfo-aside">
                    <figure class="moreinfo-figure">
                        <img src="./img/map.jpg" alt="">
                    </figure>
                </aside>
                <ul class="moreinfo-list">
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="fullname" id="fullname" value="text" required>
                            <p class="label">Voornaam & Achternaam</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="user" id="user" value="text" required>
                            <p class="label">Gebruikersnaam</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="email" id="email" value="text" required>
                            <p class="label">E-mail</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="dateofbirth" id="dateofbirth" value="text" required>
                            <p class="label">Geboortedatum</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="orderid" id="orderid" value="text" required>
                            <p class="label">Order-ID</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="resname" id="resname" value="text" required>
                            <p class="label">Naam Restaurant</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="orderdate" id="orderdate" value="text" required>
                            <p class="label">Datum & tijd</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" style="color: green !important;" type="text" value="text" name="deliverystatus" id="deliverystatus" required>
                            <p class="label">Status bezorging</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="useradres" id="useradres" value="text" required>
                            <p class="label">Adres</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="paymethod" id="paymethod" value="text" required>
                            <p class="label">Betaalmethode</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="deliverynote" id="deliverynote" value="text" required>
                            <p class="label">Opmerking voor bezorger</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="foodnote" id="foodnote" value="text" required>
                            <p class="label">Opmerking voor eten</p>
                        </label>
                    </li>
                </ul>
            </div>
            <footer class="moreinfo-footer">
                <ul class="moreinfo-footerlist">
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="bill" id="bill" value="text" required>
                            <p class="label">Download factuur</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="exportexcel" id="exportexcel" value="text" required>
                            <p class="label">Exporteer naar excel</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="priceincl" id="priceincl" value="text" required>
                            <p class="label">Prijs incl.</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="priceexcl" id="priceexcl" value="text" required>
                            <p class="label">Prijs excl.</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" style="color: orange;" type="text" name="paystatus" id="paystatus" value="text" required>
                            <p class="label">Status betaling</p>
                        </label>
                    </li>
                </ul>
            </footer>
        </div>
    </div>

    <!-- Website: -->
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
                            <div class="profile-listitem-container">
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
                            <div class="profile-listitem-container active">
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
            <div class="profile-info">
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
                <ul class="admin-info-headers">
                    <li class="admin-info-header">
                        <b>Order ID</b>
                    </li>
                    <li class="admin-info-header">
                        <b>Restaurant</b>
                    </li>
                    <li class="admin-info-header">
                        <b>Datum & tijd</b>
                    </li>
                    <li class="admin-info-header">
                        <b>Naam</b>
                    </li>
                    <li class="admin-info-header">
                        <b>Status</b>
                    </li>
                    <li class="admin-info-header">
                        <b>Adres</b>
                    </li>
                    <li class="admin-info-header">
                        <b>Bedrag</b>
                    </li>
                </ul>
                <ul class="profile-info-list">
                    <li class="admin-info-listitem">
                        <p>#0006</p>
                        <p>Eetcafe de Kwikkel</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                        <p>Afgeleverd</p>
                        <p>Kruistraat 14, Amsterdam</p>
                        <p>€ 37,98</p>
                        <a href="">Veranderen</a>
                    </li>
                    <li class="admin-info-listitem">
                        <p>#0005</p>
                        <p>Rumours</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                        <p>Afgeleverd</p>
                        <p>Kruistraat 14, Amsterdam</p>
                        <p>€ 37,98</p>
                        <a href="">Veranderen</a>
                    </li>
                    <li class="admin-info-listitem">
                        <p>#0004</p>
                        <p>New York pizza</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                        <p>Afgeleverd</p>
                        <p>Kruistraat 14, Amsterdam</p>
                        <p>€ 37,98</p>
                        <a href="">Veranderen</a>
                    </li>
                    <li class="admin-info-listitem">
                        <p>#0003</p>
                        <p>New York pizza</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                        <p>Afgeleverd</p>
                        <p>Kruistraat 14, Amsterdam</p>
                        <p>€ 37,98</p>
                        <a href="">Veranderen</a>
                    </li>
                    <li class="admin-info-listitem">
                        <p>#0002</p>
                        <p>New York pizza</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                        <p>Afgeleverd</p>
                        <p>370</p>
                        <p>€ 37,98</p>
                        <a href="">Veranderen</a>
                    </li>
                    <li class="admin-info-listitem">
                        <p>#0001</p>
                        <p>New York pizza</p>
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