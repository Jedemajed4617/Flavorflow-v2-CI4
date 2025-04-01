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
    <link rel="stylesheet" href="/css/index.css" />
    <link rel="stylesheet" href="/css/order.css" />
    <link rel="stylesheet" href="/css/profile.css" />
    <link rel="stylesheet" href="/css/restaurants.css" />
    <link rel="stylesheet" href="/css/notification-error.css" />
    <link rel="stylesheet" href="/css/password-change.css" />
    <link rel="stylesheet" href="/css/admin-modal.css" />
    <link rel="stylesheet" href="/css/login.css" />
    <script src="/js/functions.js" defer></script>
    <script src="/js/main.js" defer></script>
    <title>Flavorflow - De beste online bestel-app</title>
    <link rel="shortcut icon" href="/img/F-logo.png" type="image/x-icon" />
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
                            <div class="profile-listitem-container active">
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
            <div class="emailcontainer">
                <div class="email">
                    <header class="calenderheader">
                        <i class="fas fa-times close-email"></i>
                    </header>
                    <form onsubmit="return changeName(event);" class="gender-form">
                        <h2>Verander uw e-mail</h2>
                        <label for="" class="order-phone seper">
                            <input class="order-input" type="text" name="email" id="email" value="<?php echo $email; ?>" required>
                            <p class="label">E-mail</p>
                            <i onclick="changeEmail();" class="fas fa-save profile-icon"></i>
                        </label>
                    </form>
                </div>
            </div>
            <span class="adminnotvisiblemsg">Pagina's niet beschikbaar voor telefoon! <small>Open de website op een tablet of pc of ga verder door de navigatie te klikken</small></span>
            <div class="profile-info admindisplaynoneby1000px">
                <div class="profile-headerheading">
                    <h1>Instellingen voor <?php echo $info['restaurant_name']; ?></h1>
                    <p>Bekijk en bewerk uw restaurant</p>
                </div>
                <ul class="profile-info-list">
                    <li class="profile-info-listitem">
                        <h3>Naam restaurant</h3>
                        <p style="text-transform: capitalize;"><?php echo $info['restaurant_name']; ?></p>
                        <a onclick="openRestaurantName();">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>Adres</h3>
                        <p>Adres van het restaurant</p>
                        <a onclick="openRestaurantAddress();">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>Restaurant eigenaar</h3>
                        <p><?php echo $fullname; ?></p>
                        <a onclick=""></a>
                    </li>
                </ul>
            </div>
            <div class="profile-settings admindisplaynoneby1000px">
                <header class="profile-headercontainer">
                    <div class="profile-headerheading">
                        <h1>Andere instellingen</h1>
                        <p>Overige instellingen</p>
                    </div>
                </header>
                <ul class="profile-info-list">
                    <li class="profile-info-listitem">
                        <h3>Automatische tijdzone</h3>
                        <input class="input-slider" type="checkbox" name="" id="" checked>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>Verwijder restaurant</h3>
                        <p></p>
                        <a onclick="openDeleteRestaurant();">Verwijderen</a>
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