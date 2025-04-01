<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('css/index.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/restaurant.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cart.css') ?>">
    <link rel="stylesheet" href="./css/password-change.css">
    <script src="<?= base_url('js/functions.js') ?>" defer></script>
    <script src="<?= base_url('js/main.js') ?>" defer></script>
    <title>Flavorflow - De beste online bestel-app</title>
    <link rel="shortcut icon" href="<?= base_url('img/f-logo.png') ?>" type="image/x-icon">
</head>

<body>
    <style>
        :root {
            --accent-color: #A21C10;
            --accent-color-lighter: rgba(162, 28, 16, 0.7);
            --accent-color-lightest: rgba(162, 28, 16, 0.5);
            --accent-color-background-light: rgba(162, 28, 16, 0.18);
            --subheading-color: #747474;
            --subheading-color-lighter: #939393;
            --shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            --button-green: #1BA210;
            --button-green-lighter: #1ca210c2;
        }

        .container {
            width: 100%;
            height: auto;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 0.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        h2 {
            font-size: 2.2rem;
            margin-bottom: 1rem;
            color: var(--accent-color);
        }

        .order-details,
        .items-list {
            margin-bottom: 1.5rem;
        }

        .order-details {
            font-size: 1.4rem;
        }

        .order-details p,
        .items-list p {
            margin: 0.5rem 0;
        }

        .item {
            display: flex;
            justify-content: space-between;
            padding: 1rem;
            background: var(--accent-color-background-light);
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            color: black;
            font-size: 1.5rem;
        }

        .item-font {
            font-size: 1.5rem;
        }

        .total {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .buttons {
            width: 100%;
            height: auto;
            display: flex;
            gap: 2rem;
            font-size: 1.4rem;
        }

        .btn {
            display: block;
            width: 100%;
            text-align: center;
            padding: 0.75rem;
            background: var(--accent-color);
            color: white;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            text-decoration: none;
        }

        h3 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: var(--accent-color);
        }

        .btn:hover {
            background: var(--accent-color-lighter);
        }

        .status-container {
            width: 100%;
            height: auto;
            margin: 2rem 0;
            display: flex;
            flex-direction: column;
        }

        .status-d {
            width: 100%;
            display: flex;
            justify-content: space-between;
            gap: 5rem;
        }

        .image-container {
            width: 30%;
            height: auto;
            border-radius: 2rem;
        }

        .image-container img {
            width: 100%;
            height: auto;
            border-radius: 2rem;
        }

        .order-status {
            width: 70%;
            height: auto;
        }

        .order-status p {
            font-size: 1.5rem;
            margin: 1rem 0;
            background-color: var(--accent-color-background-light);
            padding: 1rem;
            color: black;
            display: flex;
            justify-content: space-between;
            border-radius: 0.5rem;
        }

        .header {
            width: 100%;
            height: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem;
        }

        .header>p {
            font-size: 1.5rem;
            margin: 0.5rem 0;
            color: var(--subheading-color);
            text-align: center;
        }

        .header>h1 {
            font-size: 2.5rem;
            margin: 0.5rem 0;
            color: var(--accent-color);
        }

        @media screen and (max-width: 990px){
            .status-d {
                flex-direction: column;
                gap: 0;
            }
        }

        @media screen and (max-width: 750px){
            .image-container{
                width: 100%;
                max-height: 200px;
            }

            .image-container img{
                width: 100%;
                max-height: 200px;
                object-fit: cover;
                object-position: 25% 75%;
            }

            .order-status{
                width: 100%;
            }

            .status-container{
                flex-direction: column;
            }
        }

        @media (max-width: 40rem) {
            .container {
                padding: 1.5rem;
            }
        }

        @media screen and (max-width: 500px){
            .order-status > p{
                font-size: 1.2rem;
            }

            .item-font{
                font-size: 1.2rem;
            }
        }

        @media screen and (max-width: 425px){
            .header > h1{
                font-size: 2rem;
            }

            .header > p{
                font-size: 1.2rem;
            }

            .order-status > p, .order-details > p{
                flex-direction: column;
            }

            .buttons{
                display: block;
            }
        }
    </style>
    <div class="restaurant-container">
        <main class="restaurant">
            <div class="header">
                <h1>Bedankt voor uw bestelling!</h1>
                <p>Uw bestelling is succesvol geplaatst. U ontvangt een bevestigingsmail met de details van uw bestelling.</p>
                <p>Als u vragen heeft, neem dan gerust contact met ons op.</p>
            </div>
            <div class="container">
                <div>
                    <h2>Bestellingsoverzicht:</h2>
                    <div class="order-details">
                        <?php if (!empty($orderdata)): ?>
                            <p><strong>Order ID:</strong> #<?= esc($orderdata['order_id']) ?></p>
                            <p><strong>Naam:</strong> <?= esc($orderdata['fname']) ?> <?= esc($orderdata['lname']) ?></p>
                            <p><strong>Email:</strong> <?= esc($orderdata['email']) ?></p>
                            <p><strong>Telefoonnummer:</strong> <?= esc($orderdata['phone']) ?></p>
                            <p><strong>Bezorgmethode:</strong> <?= esc($orderdata['delivery_method']) ?></p>
                            <p><strong>Betaalmethode:</strong> <?= esc($orderdata['payment_method']) ?></p>
                            <p><strong>Opmerking voor bezorger:</strong> <?= esc($orderdata['order_delivery_note']) ?></p>
                            <p><strong>Adres:</strong> <?= esc($orderdata['address']) ?></p>
                            <p><strong>Datum:</strong> <?= esc($orderdata['order_date']) ?></p>
                        <?php else: ?>
                            <p>Geen informatie gevonden.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <h2>Info Restaurant:</h2>
                    <div class="order-details">
                        <?php if (!empty($orderdata)): ?>
                            <p><strong>Naam Restaurant:</strong> <?= esc($orderdata['restaurant_name']) ?></p>
                            <p><strong>Adres Restaurant:</strong> Nieuwstraat 57, 1671CG Medemblik</p>
                        <?php else: ?>
                            <p>Geen informatie gevonden.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <h2>Uw bestelling:</h2>
                    <div class="items-list">
                        <?php if (!empty($orderdata['cart'])): ?>
                            <?php foreach ($orderdata['cart'] as $item): ?>
                                <div class="item">
                                    <span class="item-font"><?= esc($item['name']) ?> <small>x<?= esc($item['quantity']) ?></small></span>
                                    <span class="item-font">€<?= number_format($item['price'], 2) ?></span>
                                </div>
                            <?php endforeach; ?>
                            <div class="item total">
                                <span class="item-font">Totaal</span>
                                <span class="item-font">
                                    €<?= number_format(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $orderdata['cart'])), 2) ?>
                                </span>
                            </div>
                        <?php else: ?>
                            <p>Geen items in de bestelling.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="status-container">
                    <h2>Bezorginformatie:</h2>
                    <div class="status-d">
                        <div class="image-container">
                            <img src="img/map.jpg" alt="">
                        </div>
                        <?php if (!empty($orderdata)): ?>
                            <div class="order-status">
                                <p><strong>Bezorgadres:</strong> <?= esc($orderdata['address']) ?></p>
                                <p><strong>Bezorgmethode:</strong> <?= esc($orderdata['delivery_method']) ?></p>
                                <p><strong>Bezorgkosten:</strong> €2.50</p>
                                <p><strong>Bezorgstatus:</strong> Voorbereiden</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="buttons">
                    <a href="<?= site_url('/'); ?>" class="btn">Ga terug naar de homepagina</a>
                    <br>
                    <a href="<?= site_url('account/register') ?>" class="btn">Registreer een account</a>
                </div>
            </div>
        </main>
    </div>
</body>

</html>