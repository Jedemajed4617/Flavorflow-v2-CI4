<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/index.css" />
    <link rel="stylesheet" href="./css/order.css" />
    <link rel="stylesheet" href="./css/profile.css" />
    <link rel="stylesheet" href="./css/restaurants.css" />
    <link rel="stylesheet" href="./css/notification-error.css" />
    <link rel="stylesheet" href="./css/password-change.css" />
    <link rel="stylesheet" href="./css/login.css" />
    <script src="./js/functions.js" defer></script>
    <script src="./js/main.js" defer></script>
    <title>Flavorflow - De beste online bestel-app</title>
    <link rel="shortcut icon" href="./img/F-logo.png" type="image/x-icon" />
</head>
<body>
    <script>
        function submitLoginForm(event) {
            event.preventDefault();

            let formData = {
                email: $("#email").val(),
                password: $("#password").val(),
            };

            $.ajax({
                url: "<?= site_url('account/process') ?>", 
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
                    showCustomMessage("Er is een fout opgetreden, probeel later opnieuw", false);
                }
            });
        }
    </script>
    <br>
    <br>
    <main class="logincaontainer">
        <div class="login">
            <form class="loginform" onsubmit="submitLoginForm(event)" method="POST" autocomplete="on">
                <label for="" class="login-social">
                    <div class="login-google">
                        <button class="login-socialbutton">Inloggen met Google</button>
                        <i class="fas fa-brands fa-facebook loginicon"></i>
                    </div>
                    <div class="login-facebook">
                        <button class="login-socialbutton">Inloggen met Facebook</button>
                        <i class="fas fa-brands fa-google loginicon"></i>
                    </div>
                </label>
                <div class="order-seperator sep">
                    <figure class="line"></figure>
                    <p class="order-seperatortext">OF</p>
                    <figure class="line"></figure>
                </div>
                <label for="email" class="order-phone seper">
                    <input class="order-input" type="email" name="email" id="email" placeholder="janjansen@voorbeeld.com" autocomplete="email" required>
                    <p class="label">E-mail</p>
                </label>
                <label for="password" class="order-phone">
                    <input class="order-input" type="password" name="password" id="password" placeholder="••••••••••" autocomplete="current-password" required>
                    <p class="label">Wachtwoord</p>
                </label>
                <div class="login-forgot">
                    <a href="">Wachtwoord vergeten?</a>
                </div>
                <div class="login-button">
                    <button type="submit">Inloggen</button>
                </div>
                <div class="order-seperator">
                    <figure class="line"></figure>
                    <p class="order-seperatortext">Nog niet geregistreerd?</p>
                    <figure class="line"></figure>
                </div>
                <label for="" class="login-makeaccount">
                    <button onclick="window.location.href='<?= site_url('account/register') ?>'">Account aanmaken</button>
                </label>
                <div class="login-privacy">
                    <p>Door in te loggen bevestig je dat je instemt met onze privacyverklaring, algemene voorwaarden en ons cookiebeleid.</p>
                </div>
            </form>
        </div>
    </main>
</body>
</html>