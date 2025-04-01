<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/css/order.css">
    <link rel="stylesheet" href="/css/payment.css">
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="<?= base_url('css/index.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/restaurant.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cart.css') ?>">
    <script src="<?= base_url('js/functions.js') ?>" defer></script>
    <script src="<?= base_url('js/main.js') ?>" defer></script>
    <link rel="shortcut icon" href="<?= base_url('img/f-logo.png') ?>" type="image/x-icon">
    <title>Flavorflow - De beste online bestel-app</title>
</head>
<body>
    <script>
        function submitRegisterForm(event) {
            event.preventDefault();

            let formData = {
                fname: $("#fname").val(),
                lname: $("#lname").val(),
                email: $("#email").val(),
                password: $("#password").val(),
                pswrepeat: $("#pswrepeat").val(),
                username: $("#username").val(),
                phone: $("#phone").val()
            };

            $.ajax({
                url: "<?= site_url('account/create') ?>", // Adjust to your correct endpoint
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if(response['status'] == 'success'){
                        console.log('Helemaal prima');
                        window.location.href = "<?= site_url('profile') ?>";
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
    <br>
    <br>
    <main class="logincaontainer">
        <div class="login">
            <form class="loginform" id="registerForm" onsubmit="submitRegisterForm(event)" autocomplete="on">
                <label for="" class="login-social">
                    <div class="login-google">
                        <button class="login-socialbutton">Registreer met Google</button>
                        <i class="fas fa-brands fa-facebook loginicon"></i>
                    </div>
                    <div class="login-facebook">
                        <button class="login-socialbutton">Registreer met Facebook</button>
                        <i class="fas fa-brands fa-google loginicon"></i>
                    </div>
                </label>
                <div class="order-seperator sep">
                    <figure class="line"></figure>
                    <p class="order-seperatortext">OF</p>
                    <figure class="line"></figure>
                </div>
                <label for="fname" class="order-phone seper">
                    <input class="order-input" type="text" name="fname" id="fname" placeholder="Jan" required autocomplete="given-name">
                    <p class="label">Voornaam</p>
                </label>
                <label for="lname" class="order-phone seper">
                    <input class="order-input" type="text" name="lname" id="lname" placeholder="Jansen" required autocomplete="family-name">
                    <p class="label">Achternaam</p>
                </label>
                <label for="email" class="order-phone seper">
                    <input class="order-input" type="email" name="email" id="email" placeholder="janjansen@voorbeeld.com" autocomplete="email" required>
                    <p class="label">E-mail</p>
                </label>
                <label for="password" class="order-phone seper">
                    <input class="order-input" type="password" name="password" id="password" placeholder="••••••••••" autocomplete="new-password" required>
                    <p class="label">Wachtwoord</p>
                </label>
                <label for="pswrepeat" class="order-phone seper">
                    <input class="order-input" type="password" name="pswrepeat" id="pswrepeat" placeholder="••••••••••" autocomplete="new-password" required>
                    <p class="label">Herhaal Wachtwoord</p>
                </label>
                <label for="username" class="order-phone seper">
                    <input class="order-input" type="text" name="username" id="username" placeholder="janjansen12" autocomplete="username" required>
                    <p class="label">Gebruikersnaam</p>
                </label>
                <label for="phone" class="order-phone seper">
                    <input class="order-input valued-input" type="text" name="phone" id="phone" value="+3106 " required autocomplete="tel">
                    <p class="label">Telefoon</p>
                </label>
                <label for="submitbuttonregister" class="login-button">
                    <button id="submitbuttonregister" type="submit">Registreren</button>
                </label>
                
                <div class="order-seperator">
                    <figure class="line"></figure>
                    <p class="order-seperatortext">Al een account bij ons?</p>
                    <figure class="line"></figure>
                </div>
                <label for="" class="login-makeaccount">
                    <button onclick="window.location.href='<?= site_url('account/index') ?>'">Inloggen</button>
                </label>
                <div class="login-privacy">
                    <p>Door te registreren bevestig je dat je instemt met onze privacyverklaring, algemene voorwaarden en ons cookiebeleid.</p>
                </div>
            </form>
        </div>
    </main>
</body>
</html>