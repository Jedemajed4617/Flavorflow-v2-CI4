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
    <script>
        function submitAddaddress(event) {
            event.preventDefault();
            const calender = document.querySelector(".newaddress");

            let formData = {
                province: $("#province").val(),
                city: $("#city").val(),
                streetname: $("#streetname").val(),
                housenumber: $("#housenumber").val(),
                housenumberaddition: $("#housenumberaddition").val(),
                postalcode: $("#postalcode").val(),
                addresstype: $("#addresstype").val(),
                country: $("#country").val(),
            };

            $.ajax({
                url: "<?= site_url('account/addaddress') ?>", 
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if(response['status'] == 'success'){
                        console.log('Helemaal piem');
                        showCustomMessage("Address toegevoegd en als actief gemarkeerd.", true);
                        calender.classList.remove("open");
                        setTimeout(() => location.reload(), 2000);
                    }else{
                        showCustomMessage(response['message'], false);
                        formData.reset();
                        return;
                    }
                },
                error: function () {
                    showCustomMessage("Er is een fout opgetreden, probeer later opnieuw", false);
                }
            });
        }
    </script>
    <div class="newaddresscontainer">
        <div class="newaddress popup">
            <header class="calenderheader">
                <i class="fas fa-times close-newaddress"></i>
            </header>
            <form onsubmit="return submitAddaddress(event);" class="gender-form" autocomplete="on">
                <h2>Voeg een nieuw adres toe</h2>
                <label for="province" class="order-phone seper">
                    <select class="order-input" name="province" id="province" required>
                        <option value="" disabled selected>Selecteer een provincie</option>
                        <option value="Drenthe">Drenthe</option>
                        <option value="Flevoland">Flevoland</option>
                        <option value="Friesland">Friesland</option>
                        <option value="Gelderland">Gelderland</option>
                        <option value="Groningen">Groningen</option>
                        <option value="Limburg">Limburg</option>
                        <option value="Noord-Brabant">Noord-Brabant</option>
                        <option value="Noord-Holland">Noord-Holland</option>
                        <option value="Overijssel">Overijssel</option>
                        <option value="Utrecht">Utrecht</option>
                        <option value="Zeeland">Zeeland</option>
                        <option value="Zuid-Holland">Zuid-Holland</option>
                    </select>
                    <p class="label">Provincie</p>
                </label>
                <label for="" class="order-phone seper">
                    <input class="order-input" type="text" name="city" id="city" autocomplete="address-level2" placeholder="Amsterdam" required>
                    <p class="label">Plaatsnaam</p>
                </label>
                <label for="" class="order-phone seper">
                    <input class="order-input" type="text" name="streetname" id="streetname" autocomplete="address-line1" placeholder="Kerkstraat" required>
                    <p class="label">Straatnaam</p>
                </label>
                <label for="" class="order-phone seper">
                    <input class="order-input" type="text" name="housenumber" id="housenumber" autocomplete="address-line2" placeholder="1" required>
                    <p class="label">Huisnummer</p>
                </label>
                <label for="" class="order-phone seper">
                    <input class="order-input" type="text" name="housenumberaddition" id="housenumberaddition" autocomplete="address-line3" placeholder="A">
                    <p class="label">Huisnummer toevoeging</p>
                </label>
                <label for="" class="order-phone seper">
                    <input class="order-input" type="text" name="postalcode" id="postalcode" autocomplete="postal-code" placeholder="1234 AB" required>
                    <p class="label">Postcode</p>
                </label>
                <label for="" class="order-phone seper">
                    <select class="order-input" name="addresstype" id="addresstype" required>
                        <option value="" disabled selected>Selecteer een type adress</option>
                        <option value="factuuradres">Factuuradres</option>
                        <option value="bezorgadres">Bezorgadres</option>
                    </select>
                    <p class="label">Adrestype</p>
                </label>
                <input type="text" name="country" id="country" value="Nederland" hidden>
                <button type="submit">Toevoegen</button>
            </form>
        </div>
    </div>

    <div class="usernamecontainer">
        <div class="username popup">
            <header class="calenderheader">
                <i class="fas fa-times close-username"></i>
            </header>
            <form class="gender-form" onsubmit="return deleteAddress(event);">
                <h2 id="permdel">Weet je zeker dat je dit adres permanent wil verwijderen?</h2>
                <input type="text" name="addressid" id="addressid" value="" hidden>
                <button type="submit">Verwijder dit product</button>
            </form>
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
                        <div class="profile-listitem-container active">
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
                <div class="address-headerheading" style="padding-bottom: 0.5rem;">
                    <div class="address-headertext">
                        <h1>Mijn Adressen</h1>
                        <p>Bekijk of bewerk uw adresgegevens.</p>
                    </div>
                    <div class="address-headericon" onclick="openPopup('newaddresscontainer', 'close-newaddress');">
                        <i class="fas fa-circle-plus"></i>
                    </div>
                </div>
                <ul class="profile-info-list" style="border-top: 1px solid #939393;">
                    <div class="adres-container">
                        <header class="adres-header">
                            <h1>Alle bezorgadressen:</h1>
                        </header>
                        <div class="adres-deliverycontainer">
                            <?php
                            if ($user_id) {
                                if (!empty($deliveryaddress)) {
                                    foreach ($deliveryaddress as $address) { // Renamed iteration variable
                            ?>
                                        <li class="adres-listitem">
                                            <div class="adres-listitem-header">
                                                <b>Bezorgadres:</b>
                                            </div>
                                            <div class="adres-listdata">
                                                <p><?= esc($address['street_name']) . " " . esc($address['street_number']) . (!empty($address['street_number_addon']) ? " " . esc($address['street_number_addon']) : ""); ?></p>
                                                <p><?= esc($address['city']) . ", " . esc($address['province']); ?></p>
                                                <p style="text-transform: uppercase;"><?= esc($address['postal_code']); ?></p>
                                            </div>
                                            <button class="adres-listbutton" onclick="openDeleteAddress(<?= esc($address['address_id']); ?>);">
                                                Verwijder
                                            </button>
                                        </li>
                            <?php
                                    }
                                } else {
                                    echo "<p>Geen bezorgadressen gevonden.</p>";
                                }
                            } else {
                                echo "<p>Gebruiker niet ingelogd.</p>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="adres-container">
                        <header class="adres-header">
                            <h1>Alle factuuradressen:</h1>
                        </header>
                        <div class="adres-billcontainer">
                        <?php
                            if ($user_id) {
                                if (!empty($billingaddress)) {
                                    foreach ($billingaddress as $address) { // Renamed iteration variable
                            ?>
                                        <li class="adres-listitem">
                                            <div class="adres-listitem-header">
                                                <b>Factuuradres:</b>
                                            </div>
                                            <div class="adres-listdata">
                                                <p><?= esc($address['street_name']) . " " . esc($address['street_number']) . (!empty($address['street_number_addon']) ? " " . esc($address['street_number_addon']) : ""); ?></p>
                                                <p><?= esc($address['city']) . ", " . esc($address['province']); ?></p>
                                                <p style="text-transform: uppercase;"><?= esc($address['postal_code']); ?></p>
                                            </div>
                                            <button class="adres-listbutton" onclick="openDeleteAddress(<?= esc($address['address_id']); ?>);">
                                                Verwijder
                                            </button>
                                        </li>
                            <?php
                                    }
                                } else {
                                    echo "<p>Geen factuuradressen gevonden.</p>";
                                }
                            } else {
                                echo "<p>Gebruiker niet ingelogd.</p>";
                            }
                            ?>
                        </div>
                    </div>
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
                    <h1>Bewerk adressen</h1>
                    <div class="address-headericon" onclick="openPopup('newaddresscontainer', 'close-newaddress');">
                        <i class="fas fa-circle-plus"></i>
                    </div>
                </header>
                <div id="message-container" class="message-container"></div>
                <div class="adres-container">
                    <header class="adres-header">
                        <h1>Alle bezorgadressen:</h1>
                    </header>
                    <div class="adres-deliverycontainer">
                        <?php
                            if ($user_id) {
                                if (!empty($deliveryaddress)) {
                                    foreach ($deliveryaddress as $address) { // Renamed iteration variable
                            ?>
                                        <li class="adres-listitem">
                                            <div class="adres-listitem-header">
                                                <b>Bezorgadres:</b>
                                            </div>
                                            <div class="adres-listdata">
                                                <p><?= esc($address['street_name']) . " " . esc($address['street_number']) . (!empty($address['street_number_addon']) ? " " . esc($address['street_number_addon']) : ""); ?></p>
                                                <p><?= esc($address['city']) . ", " . esc($address['province']); ?></p>
                                                <p style="text-transform: uppercase;"><?= esc($address['postal_code']); ?></p>
                                            </div>
                                            <button class="adres-listbutton" onclick="openDeleteAddress(<?= esc($address['address_id']); ?>);">
                                                Verwijder
                                            </button>
                                        </li>
                            <?php
                                    }
                                } else {
                                    echo "<p>Geen bezorgadressen gevonden.</p>";
                                }
                            } else {
                                echo "<p>Gebruiker niet ingelogd.</p>";
                            }
                            ?>
                    </div>
                </div>
                <div class="adres-container">
                    <header class="adres-header">
                        <h1>Alle factuuradressen:</h1>
                    </header>
                    <div class="adres-billcontainer">
                        <?php
                            if ($user_id) {
                                if (!empty($billingaddress)) {
                                    foreach ($billingaddress as $address) { // Renamed iteration variable
                            ?>
                                        <li class="adres-listitem">
                                            <div class="adres-listitem-header">
                                                <b>Factuuradres:</b>
                                            </div>
                                            <div class="adres-listdata">
                                                <p><?= esc($address['street_name']) . " " . esc($address['street_number']) . (!empty($address['street_number_addon']) ? " " . esc($address['street_number_addon']) : ""); ?></p>
                                                <p><?= esc($address['city']) . ", " . esc($address['province']); ?></p>
                                                <p style="text-transform: uppercase;"><?= esc($address['postal_code']); ?></p>
                                            </div>
                                            <button class="adres-listbutton" onclick="openDeleteAddress(<?= esc($address['address_id']); ?>);">
                                                Verwijder
                                            </button>
                                        </li>
                            <?php
                                    }
                                } else {
                                    echo "<p>Geen factuuradressen gevonden.</p>";
                                }
                            } else {
                                echo "<p>Gebruiker niet ingelogd.</p>";
                            }
                            ?>
                    </div>
                </div>
                <br>
                <br>
                <div class="navbar-logoutcontainer">
                    <a href="<?= site_url('account/logout') ?>" class="navbar-logoutbutton">Uitloggen</a>
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