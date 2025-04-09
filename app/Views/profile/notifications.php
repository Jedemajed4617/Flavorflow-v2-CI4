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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover user-scalable=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/css/index.css" />
    <link rel="stylesheet" href="/css/order.css" />
    <link rel="stylesheet" href="/css/profile.css" />
    <link rel="stylesheet" href="/css/restaurants.css" />
    <link rel="stylesheet" href="/css/notification-error.css" />
    <link rel="stylesheet" href="/css/password-change.css" />
    <link rel="stylesheet" href="/css/login.css" />
    <script src="/js/functions.js" defer></script>
    <script src="/js/main.js" defer></script>
    <title>Flavorflow - De beste online bestel-app</title>
    <link rel="shortcut icon" href="./img/F-logo.png" type="image/x-icon" />
</head>

<body>
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
                        <div class="profile-listitem-container active">
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
            <div class="profile-info">
                <header class="profile-headercontainer">
                    <div class="profile-headerheading">
                        <h1>Mijn Meldingen</h1>
                        <p>Deze informatie is alleen zichtbaar voor jou.</p>
                    </div>
                </header>
                <ul class="notification-info-headers">
                    <li class="notification-info-header">
                        <b>ID</b>
                    </li>
                    <li class="notification-info-header">
                        <b>Datum</b>
                    </li>
                    <li class="notification-info-header">
                        <b>Titel</b>
                    </li>
                    <li class="notification-info-header">
                        <b>Bericht</b>
                    </li>
                </ul>
                <ul class="profile-info-list">
                    <li class="notification-info-listitem">
                        <p>4</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Een hele mooie titel</p>
                        <p>Een heel kort maar mooi bericht</p>
                        <a href="">Meer info</a>
                    </li>
                    <li class="notification-info-listitem">
                        <p>3</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Een hele mooie titel</p>
                        <p>Een heel kort maar mooi bericht</p>
                        <a href="">Meer info</a>
                    </li>
                    <li class="notification-info-listitem">
                        <p>2</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Een hele mooie titel</p>
                        <p>Een heel kort maar mooi bericht</p>
                        <a href="">Meer info</a>
                    </li>
                    <li class="notification-info-listitem">
                        <p>1</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Een hele mooie titel</p>
                        <p>Een heel kort maar mooi bericht</p>
                        <a href="">Meer info</a>
                    </li>
                </ul>
            </div>
        </section>
    </main>

    <main class="phone-profile">
        <div class="phone-profile-headerbewerk">
            <i onclick="window.location.href = '<?= site_url('/profile') ?>'" class="fas fa-chevron-left"></i>
            <div class="phone-profile-contentcontainer">
                <div class="phone-profile-imagecontainer">
                    <figure class="phone-profile-image">
                        <?php
                            if (!empty($profileimg)) {
                                echo '<img src="' . $profileimg . '" alt="">';
                            } else {
                                echo '<img src="' . base_url("img/default.png") . '" alt="">';
                            }
                        ?>
                    </figure>
                </div>
                <header class="phone-profile-headeredit">
                    <h1>Mijn Medelingen</h1>
                    <div class="phone-profile-headereditcontainer">
                        <select class="order-filter" style="height: 2.2rem !important; font-size: 1rem; padding: 0; gap: 0; width: 7rem;" name="status-filter" id="status-filter">
                            <option class="order-filteritem" value="all">Alle</option>
                            <option class="order-filteritem" value="delivered">Afgeleverd</option>
                            <option class="order-filteritem" value="pending">Onderweg</option>
                            <option class="order-filteritem" value="cancelled">Geannuleerd</option>
                        </select>
                    </div>
                </header>
                <ul class="phone-info-headers">
                    <li class="phone-info-header">
                        <b>Type</b>
                    </li>
                    <li class="phone-info-header">
                        <b>Titel</b>
                    </li>
                    <li class="phone-info-header">
                        <b>Bericht</b>
                    </li>
                    <li class="phone-info-header">
                        <b>Datum</b>
                    </li>
                </ul>
                <ul class="profile-info-list">
                    <li class="phone-info-listitem">
                        <p>Order</p>
                        <p>Eetcafe de Kwikkel</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                    </li>
                    <li class="phone-info-listitem">
                        <p>Reclame</p>
                        <p>Rumours</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                    </li>
                    <li class="phone-info-listitem">
                        <p>Reclame</p>
                        <p>New York pizza</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                    </li>
                    <li class="phone-info-listitem">
                        <p>#0003</p>
                        <p>New York pizza</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                    </li>
                    <li class="phone-info-listitem">
                        <p>#0002</p>
                        <p>New York pizza</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                    </li>
                    <li class="phone-info-listitem">
                        <p>#0001</p>
                        <p>New York pizza</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                    </li>
                </ul>
            </div>
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