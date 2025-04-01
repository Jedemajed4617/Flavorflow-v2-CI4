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
    <link rel="shortcut icon" href="/img/F-logo.png" type="image/x-icon" />
</head>

<body>
    <script>
        // Helper function to format date to DD-MM-YYYY
        function formatDateEU(dateString) {
            if (!dateString) return ""; // Handle empty input
            let parts = dateString.split("-"); // Split YYYY-MM-DD
            if (parts.length !== 3) return dateString; // If incorrect format, return original

            return `${parts[2]}-${parts[1]}-${parts[0]}`; // Convert to DD-MM-YYYY
        }

        function submitChangePassword(event) {
            event.preventDefault();
            const calender = document.querySelector(".password");

            let formData = {
                old_psw: $("#old-psw").val(),
                new_psw: $("#new-psw").val(),
                confirm_new_psw: $("#confirm-new-psw").val(),
            };

            $.ajax({
                url: "<?= site_url('account/changepassword') ?>", 
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if(response['status'] == 'success'){
                        console.log('Helemaal piem');
                        showCustomMessage("Wachtwoord is veranderd.", true);
                        calender.classList.remove("open");
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

        function submitChangeEmail() {
            const calender = document.querySelector(".email");
            let newemail = document.getElementById("updateemail");

            let formData = {
                email: $("#email").val(),
            };

            $.ajax({
                url: "<?= site_url('account/changeemail') ?>", 
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if(response['status'] == 'success'){
                        console.log('Helemaal piem');
                        newemail.innerHTML = response['newemail'];
                        showCustomMessage("E-mail is veranderd.", true);
                        calender.classList.remove("open");
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

        function submitChangeFirstName() {
            const calender = document.querySelector(".fullname");

            let formData = {
                fname: $("#fname").val(),
            };

            $.ajax({
                url: "<?= site_url('account/changefirstname') ?>", 
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if(response['status'] == 'success'){
                        console.log('Helemaal piem');
                        showCustomMessage("Voornaam is veranderd.", true);
                        calender.classList.remove("open");
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

        function submitChangeLastName() {
            const calender = document.querySelector(".fullname");

            let formData = {
                lname: $("#lname").val(),
            };

            $.ajax({
                url: "<?= site_url('account/changelastname') ?>", 
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if(response['status'] == 'success'){
                        console.log('Helemaal piem');
                        showCustomMessage("Achternaam veranderd.", true);
                        calender.classList.remove("open");
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

        function submitChangeUsername() {
            const calender = document.querySelector(".username");
            let newusername = document.getElementById("updateusername");

            let formData = {
                username: $("#username").val(),
            };

            $.ajax({
                url: "<?= site_url('account/changeusername') ?>", 
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if(response['status'] == 'success'){
                        console.log('Helemaal piem');
                        newusername.innerHTML = response['newusername'];
                        showCustomMessage("Gebruikersnaam veranderd.", true);
                        calender.classList.remove("open");
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

        function submitChangePhone() {
            const calender = document.querySelector(".phone");
            let newphone = document.getElementById("updatephone");

            let formData = {
                phone: $("#phone").val(),
            };

            $.ajax({
                url: "<?= site_url('account/changephone') ?>", 
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if(response['status'] == 'success'){
                        console.log('Helemaal piem');
                        newphone.innerHTML = response['newphone'];
                        showCustomMessage("Telefoonnummer veranderd.", true);
                        calender.classList.remove("open");
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

        function submitChangeGender(event) {
            event.preventDefault();
            const calender = document.querySelector(".gender");
            let newgender = document.getElementById("updategender");

            let formData = {
                gender: $('input[name="gender"]:checked').val(),
            };

            $.ajax({
                url: "<?= site_url('account/changegender') ?>", 
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if(response['status'] == 'success'){
                        console.log('Helemaal piem');
                        newgender.innerHTML = response['newgender'];
                        showCustomMessage("Geslacht veranderd naar " + response['newgender'] + ".", true);
                        calender.classList.remove("open");
                        $(".gender-form").reset(); 
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

        function submitChangebirthdate(event) {
            event.preventDefault();
            const calender = document.querySelector(".calender");
            let newbdate = document.getElementById("updatebdate");
            let rawDate = $('#birthdate').val(); // Get date in YYYY-MM-DD format
            let formattedDate = formatDateEU(rawDate); // Convert to DD-MM-YYYY

            let formData = {
                birthdate: formattedDate,
            };

            $.ajax({
                url: "<?= site_url('account/changebirthdate') ?>", 
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if(response['status'] == 'success'){
                        console.log('Helemaal piem');
                        newbdate.innerHTML = response['newbdate'];
                        showCustomMessage("Geboortedatum veranderd naar " + response['newbdate'] + ".", true);
                        calender.classList.remove("open");
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
            <div class="calendercontainer">
                <div class="calender popup">
                    <header class="calenderheader">
                        <i class="fas fa-times close-calender"></i>
                    </header>
                    <form onsubmit="return submitChangebirthdate(event);" method="POST" class="birthdate-form">
                        <h2>Selecteer jouw geboortedatum</h2>

                        <input type="date" name="birthdate" id="birthdate" required>

                        <button type="submit">Opslaan</button>
                    </form>
                </div>
            </div>
            <div class="gendercontainer">
                <div class="gender popup">
                    <header class="calenderheader">
                        <i class="fas fa-times close-gender"></i>
                    </header>
                    <form onsubmit="return submitChangeGender(event);" class="gender-form">
                        <h2>Selecteer jouw geslacht</h2>

                        <label>
                            <input type="radio" name="gender" value="Man" required> Man
                        </label>

                        <label>
                            <input type="radio" name="gender" value="Vrouw" required> Vrouw
                        </label>

                        <button type="submit">Opslaan</button>
                    </form>
                </div>
            </div>
            <div class="fullnamecontainer">
                <div class="fullname popup">
                    <header class="calenderheader">
                        <i class="fas fa-times close-fullname"></i>
                    </header>
                    <form onsubmit="return changeName(event);" class="gender-form">
                        <h2>Verander uw voor of achternaam</h2>
                        <label for="" class="order-phone seper">
                            <input style="text-transform: capitalize;" class="order-input" type="text" name="fname" id="fname" value="<?php echo $fname; ?>" required>
                            <p class="label">Voornaam</p>
                            <i onclick="submitChangeFirstName();" class="fas fa-save profile-icon"></i>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" style="text-transform: capitalize;" type="text" name="lname" id="lname" value="<?php echo $lname; ?>" required>
                            <p class="label">Achternaam</p>
                            <i onclick="submitChangeLastName();" class="fas fa-save profile-icon"></i>
                        </label>
                    </form>
                </div>
            </div>
            <div class="passwordcontainer">
                <div class="password popup">
                    <header class="calenderheader">
                        <i class="fas fa-times close-password"></i>
                    </header>
                    <form onsubmit="submitChangePassword(event);" class="gender-form" autocomplete="on">
                        <h2>Verander uw wachtwoord</h2>
                        <label for="" class="order-phone seper">
                            <input class="order-input" type="password" name="old-psw" id="old-psw" autocomplete="current-password" required>
                            <p class="label">Oude wachtwoord</p>
                        </label>
                        <label for="" class="order-phone seper">
                            <input class="order-input" type="password" name="new-psw" id="new-psw" autocomplete="new-password" required>
                            <p class="label">Nieuw wachtwoord</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="password" name="confirm-new-psw" id="confirm-new-psw" autocomplete="new-password" required>
                            <p class="label">Herhaal nieuwe wachtwoord</p>
                        </label>
                        <input type="hidden" name="username" value="<?php echo $username; ?>" autocomplete="username">
                        <button type="submit">Verander wachtwoord</button>
                    </form>
                </div>
            </div>
            <div class="usernamecontainer">
                <div class="username popup">
                    <header class="calenderheader">
                        <i class="fas fa-times close-username"></i>
                    </header>
                    <form onsubmit="return changeName(event);" class="gender-form">
                        <h2>Verander uw voor of achternaam</h2>
                        <label for="" class="order-phone seper">
                            <input class="order-input" type="text" name="username" id="username" value="<?php echo $username; ?>" required>
                            <p class="label">Gebruikersnaam</p>
                            <i onclick="submitChangeUsername();" class="fas fa-save profile-icon"></i>
                        </label>
                    </form>
                </div>
            </div>
            <div class="emailcontainer">
                <div class="email popup">
                    <header class="calenderheader">
                        <i class="fas fa-times close-email"></i>
                    </header>
                    <form onsubmit="return changeName(event);" class="gender-form">
                        <h2>Verander uw e-mail</h2>
                        <label for="" class="order-phone seper">
                            <input class="order-input" type="text" name="email" id="email" value="<?php echo $email; ?>" required>
                            <p class="label">E-mail</p>
                            <i onclick="submitChangeEmail();" class="fas fa-save profile-icon"></i>
                        </label>
                    </form>
                </div>
            </div>
            <div class="phonecontainer">
                <div class="phone popup">
                    <header class="calenderheader">
                        <i class="fas fa-times close-phone"></i>
                    </header>
                    <form onsubmit="return changeName(event);" class="gender-form">
                        <h2>Verander uw telefoonnummer</h2>
                        <label for="" class="order-phone seper">
                            <input class="order-input" type="text" name="phone" id="phone" value="<?php echo $phone; ?>" required>
                            <p class="label">Telefoonnummer</p>
                            <i onclick="submitChangePhone();" class="fas fa-save profile-icon"></i>
                        </label>
                    </form>
                </div>
            </div>
            <div class="profile-info">
                <div class="profile-headerheading">
                    <h1>Mijn Profiel</h1>
                    <p>Bekijk of bewerk uw gegevens.</p>
                </div>
                <ul class="profile-info-list">
                    <li class="profile-info-listitem">
                        <h3>Volledige naam</h3>
                        <p style="text-transform: capitalize;"><?php echo $fullname; ?></p>
                        <a onclick="openPopup('fullnamecontainer', 'close-fullname');">Veranderen</a>
                    </li>   
                    <li class="profile-info-listitem">
                        <h3>Gebruikersnaam</h3>
                        <p id="updateusername"><?php echo $username; ?></p>
                        <a onclick="openPopup('usernamecontainer', 'close-username');">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>E-mailadres</h3>
                        <p id="updateemail"><?php echo $email; ?></p>
                        <a onclick="openPopup('emailcontainer', 'close-email');">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>Wachtwoord</h3>
                        <p>********</p>
                        <a onclick="openPopup('passwordcontainer', 'close-password');">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>Geboortedatum</h3>
                        <p id="updatebdate"><?php echo $birthdate; ?></p>
                        <a onclick="openPopup('calendercontainer', 'close-calender');">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>Telefoonnummer</h3>
                        <p id="updatephone"><?php echo $phone; ?></p>
                        <a onclick="openPopup('phonecontainer', 'close-phone');">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>Geslacht</h3>
                        <p id="updategender"><?php if(empty($gender)){ echo "Niet aangegeven"; } else { echo $gender; } ?></p>
                        <a onclick="openPopup('gendercontainer', 'close-gender');">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>Bezorgadres</h3>
                        <p id="updateaddress"><?php echo !empty($standardaddress) ? $standardaddress : 'Geen adres gevonden'; ?></p>
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
                        <input class="input-slider" type="checkbox" name="" id="" checked>
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