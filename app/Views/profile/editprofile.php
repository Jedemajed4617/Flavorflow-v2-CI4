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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
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
                        <div class="profile-listitem-container active">
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
                <div class="profile-headerheading">
                    <h1>Mijn Profiel</h1>
                    <p>Deze informatie is zichtbaar voor iedereen.</p>
                </div>
                <ul class="profile-info-list">
                    <li class="profile-info-listitem">
                        <h3>Volledige naam</h3>
                        <p style="text-transform: capitalize;"><?php echo $fullname; ?></p>
                        <a onclick="openPopup('fullnamecontainer', 'close-fullname');">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>Gebruikersnaam</h3>
                        <p><?php echo $username; ?></p>
                        <a onclick="openPopup('usernamecontainer', 'close-username');">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>E-mailadres</h3>
                        <p><?php echo $email; ?></p>
                        <a onclick="openPopup('emailcontainer', 'close-email');">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>Wachtwoord</h3>
                        <p>********</p>
                        <a onclick="openPopup('passwordcontainer', 'close-password');">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>Geboortedatum</h3>
                        <p><?php echo $birthdate; ?></p>
                        <a onclick="openPopup('calendercontainer', 'close-calender');">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>Telefoonnummer</h3>
                        <p><?php echo $phone; ?></p>
                        <a onclick="openPopup('phonecontainer', 'close-phone');">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>Geslacht</h3>
                        <p><?php echo $gender; ?></p>
                        <a onclick="openPopup('gendercontainer', 'close-gender');">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>Bezorgadres</h3>
                        <p><?php echo !empty($standardaddress) ? $standardaddress : 'Geen adres gevonden'; ?></p>
                        <a href="<?= site_url('profile/addresses') ?>">Veranderen</a>
                    </li>
                </ul>
            </div>
            <div class="profile-settings">
                <header class="profile-headercontainer">
                    <div class="profile-headerheading">
                        <h1>Talen & Datums</h1>
                        <p>Kies welke taal of datumformaat u wilt gebruiken.</p>
                    </div>
                </header>
                <ul class="profile-info-list">
                    <li class="profile-info-listitem">
                        <h3>Taal</h3>
                        <p>Nederlands</p>
                        <a href="">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>Datum formaat</h3>
                        <p>DD/MM/YYYY</p>
                        <a href="">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>Automatische tijdzone</h3>
                        <input class="input-slider" type="checkbox" name="" id="">
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
                    <h1>Bewerk Profiel</h1>
                </header>
                <div id="message-container" class="message-container"></div>
                <ul class="phone-profile-inputlist">
                    <label for="" class="order-phone">
                        <input style="text-transform: capitalize;" class="order-input" type="text" name="fname" id="fname" value="<?php echo $fname; ?>" required>
                        <p class="label">Voornaam</p>
                        <i onclick="changeFirstname();" class="fas fa-save profile-icon"></i>
                    </label>
                    <label for="" class="order-phone">
                        <input class="order-input" style="text-transform: capitalize;" type="text" name="lname" id="lname" value="<?php echo $lname; ?>" required>
                        <p class="label">Achternaam</p>
                        <i onclick="changeLastname();" class="fas fa-save profile-icon"></i>
                    </label>
                    <label for="" class="order-phone">
                        <input style="text-transform: capitalize;" class="order-input" type="text" name="username" id="username" value="<?php echo $username; ?>" required>
                        <p class="label">Gebruikersnaam</p>
                        <i onclick="changeUsername();" class="fas fa-save profile-icon"></i>
                    </label>
                    <label for="" class="order-phone">
                        <input class="order-input" type="text" name="email" id="email" value="<?php echo $email; ?>" required>
                        <p class="label">E-mail</p>
                        <i onclick="changeEmail();" class="fas fa-save profile-icon"></i>
                    </label>
                    <label for="" class="order-phone">
                        <input class="order-input" type="text" name="" id="" value="••••••••••" required disabled>
                        <p class="label">Wachtwoord</p>
                        <i onclick="openPopup('passwordcontainer', 'close-password');" class="fas fa-pen profile-icon"></i>
                    </label>
                    <label for="" class="order-phone">
                        <input class="order-input" type="text" name="phone" id="phone" value="<?php echo $phone; ?>" required>
                        <p class="label">Telefoon</p>
                        <i onclick="changePhone();" class="fas fa-save profile-icon"></i>
                    </label>
                    <label for="" class="order-phone">
                        <input class="order-input" type="text" name="" id="" value="<?php echo $birthdate; ?>" required disabled>
                        <p class="label">Geboortedatum</p>
                        <i onclick="openPopup('calendercontainer', 'close-calender');" class="fas fa-pen profile-icon"></i>
                    </label>
                    <label for="" class="order-phone">
                        <input class="order-input" type="text" name="" id="" value="<?php echo $gender; ?>" required disabled>
                        <p class="label">Geslacht</p>
                        <i onclick="openPopup('gendercontainer', 'close-gender');" ; class="fas fa-pen profile-icon"></i>
                    </label>
                </ul>
                <br>
                <br>
                <form class="navbar-logoutcontainer" action="./controllers/account_controller.php?type=logout" method="POST">
                    <button class="navbar-logoutbutton" type="submit">Uitloggen</button>
                </form>
                <div class="calendercontainer">
                    <div class="calender popup">
                        <header class="calenderheader">
                            <i class="fas fa-times close-calender"></i>
                        </header>
                        <form action="./controllers/account_controller.php?type=setorchangebirthdate" method="POST" class="birthdate-form">
                            <h2>Selecteer jouw geboortedatum</h2>

                            <input type="date" name="birthdate" id="birthdate" required>

                            <button type="submit">Save Birthdate</button>
                        </form>
                    </div>
                </div>
                <div class="gendercontainer">
                    <div class="gender popup">
                        <header class="calenderheader">
                            <i class="fas fa-times close-gender"></i>
                        </header>
                        <form onsubmit="return changeGender(event);" class="gender-form">
                            <h2>Selecteer jouw geslacht</h2>

                            <label>
                                <input type="radio" name="gender" value="male" required> Man
                            </label>

                            <label>
                                <input type="radio" name="gender" value="female" required> Vrouw
                            </label>

                            <button type="submit">Opslaan</button>
                        </form>
                    </div>
                </div>
                <div class="passwordcontainer">
                    <div class="password popup">
                        <header class="calenderheader">
                            <i class="fas fa-times close-password"></i>
                        </header>
                        <form onsubmit="return changePassword(event);" class="gender-form">
                            <h2>Verander uw wachtwoord</h2>
                            <label for="" class="order-phone seper">
                                <input class="order-input" type="password" name="old-psw" id="old-psw" required>
                                <p class="label">Oude wachtwoord</p>
                            </label>
                            <label for="" class="order-phone seper">
                                <input class="order-input" type="password" name="new-psw" id="new-psw" required>
                                <p class="label">Nieuw wachtwoord</p>
                            </label>
                            <label for="" class="order-phone">
                                <input class="order-input" type="password" name="confirm-new-psw" id="confirm-new-psw" required>
                                <p class="label">Herhaal nieuwe wachtwoord</p>
                            </label>
                            <button type="submit">Verander wachtwoord</button>
                        </form>
                    </div>
                </div>
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