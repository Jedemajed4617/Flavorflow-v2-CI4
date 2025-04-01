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
    <div id="message-container" class="message-container"></div>
    <div class="restaurant-container">
        <main class="restaurant">
            <section class="restaurant-heading">
                <div class="restaurant-headercontainer">
                    <div class="restaurant-header">
                        <h1><?php echo $restaurant['restaurant_name']; ?></h1>
                    </div>
                    <div class="restaurant-info">
                        <ul class="restaurant-infolist">
                            <li>
                                <i class="fas fa-star"></i>
                                <p>4,2 (23) reviews</p>
                            </li>
                            <li>
                                <i class="fas fa-bag-shopping"></i>
                                <p>Min. € 15,00</p>
                            </li>
                        </ul>
                        <ul class="restaurant-infolist">
                            <li>
                                <i class="fas fa-clock"></i>
                                <p>15-35 min. levertijd</p>
                            </li>
                            <li>
                                <i class="fas fa-truck"></i>
                                <p>€ 0,00 - € 3,50 bezorgkosten</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="restaurant-buttons">
                    <div class="product-search">
                        <input type="text" placeholder="Zoek naar gerechten">
                        <button><i class="fas fa-search"></i></button>
                    </div>
                    <div class="restaurant-basket" onclick="openCart();">
                        <i class="fa-solid fa-basket-shopping"></i>
                    </div>
                </div>
            </section>
            <section class="restaurant-slider">
                <div class="restaurant-sliderheader">
                    <h1>Populair bij ons:</h1>
                </div>
                <div class="restaurant-slidercontainer">
                    <ul class="restaurant-sliderlist">
                        <li class="restaurant-slideritem">
                            <figure class="restaurant-sliderfigure">
                                <img src="<?= base_url('img/productimg/friedchicken.avif') ?>" alt="">
                            </figure>
                            <p>Crispy Chicken</p>
                            <button><i class="fas fa-circle-plus"></i></button>
                        </li>
                        <li class="restaurant-slideritem">
                            <figure class="restaurant-sliderfigure">
                                <img src="<?= base_url('img/productimg/pizza.jpg') ?>" alt="">
                            </figure>
                            <p>Pizza Margherita</p>
                            <button><i class="fas fa-circle-plus"></i></button>
                        </li>
                        <li class="restaurant-slideritem">
                            <figure class="restaurant-sliderfigure">
                                <img src="<?= base_url('img/productimg/burger.jpg') ?>" alt="">
                            </figure>
                            <p>Cheeseburger</p>
                            <button><i class="fas fa-circle-plus"></i></button>
                        </li>
                        <li class="restaurant-slideritem">
                            <figure class="restaurant-sliderfigure">
                                <img src="<?= base_url('img/productimg/sushiroll.jpeg') ?>" alt="">
                            </figure>
                            <p>Sushi Roll 6st.</p>
                            <button><i class="fas fa-circle-plus"></i></button>
                        </li>
                        <li class="restaurant-slideritem">
                            <figure class="restaurant-sliderfigure">
                                <img src="<?= base_url('img/productimg/berehap.png') ?>" alt="">
                            </figure>
                            <p>Berehap Pinda</p>
                            <button><i class="fas fa-circle-plus"></i></button>
                        </li>
                        <li class="restaurant-slideritem">
                            <figure class="restaurant-sliderfigure">
                                <img src="<?= base_url('img/productimg/patat.webp') ?>" alt="">
                            </figure>
                            <p>Patat 4p.</p>
                            <button><i class="fas fa-circle-plus"></i></button>
                        </li>
                        <li class="restaurant-slideritem">
                            <figure class="restaurant-sliderfigure">
                                <img src="<?= base_url('img/productimg/redbull.jpg') ?>" alt="">
                            </figure>
                            <p>Redbull 250ml</p>
                            <button><i class="fas fa-circle-plus"></i></button>
                        </li>
                        <li class="restaurant-slideritem">
                            <figure class="restaurant-sliderfigure">
                                <img src="<?= base_url('img/productimg/spareribs.jpeg') ?>" alt="">
                            </figure>
                            <p>Spare-ribs 750gr.</p>
                            <button><i class="fas fa-circle-plus"></i></button>
                        </li>
                        <li class="restaurant-slideritem">
                            <figure class="restaurant-sliderfigure">
                                <img src="<?= base_url('img/productimg/grill.webp') ?>" alt="">
                            </figure>
                            <p>Mixed Grill</p>
                            <button><i class="fas fa-circle-plus"></i></button>
                        </li>
                        <li class="restaurant-slideritem">
                            <figure class="restaurant-sliderfigure">
                                <img src="<?= base_url('img/productimg/broodjedoner.jpg') ?>" alt="">
                            </figure>
                            <p>Broodje Doner</p>
                            <button><i class="fas fa-circle-plus"></i></button>
                        </li>
                    </ul>
                </div>
            </section>
            <ul class="products-itemlist">
                <?php if (!empty($dishes)): ?>
                    <?php foreach ($dishes as $dish): 
                        if (isset($dish['active_discount']) && $dish['active_discount'] !== null) {
                            if ($dish['active_discount'] == 100) {
                                $dish['discounted_price'] = 'Gratis';
                            } elseif ($dish['active_discount'] == 0) {
                                $dish['discounted_price'] = number_format($dish['dish_price'], 2);
                            } else {
                                $discount = ($dish['dish_price'] * $dish['active_discount']) / 100;
                                $dish['discounted_price'] = number_format($dish['dish_price'] - $discount, 2);
                            }
                        } else {
                            $dish['discounted_price'] = number_format($dish['dish_price'], 2);
                        }
                    ?>
                        <?php
                        // Retrieve dish details
                        $dish_name = $dish['dish_name'];
                        $dish_price = $dish['discounted_price'];
                        $dish_img_src = !empty($dish['dish_img_src']) ? $dish['dish_img_src'] : './img/logo-res.jpg'; // Default image if not set
                        ?>
                        <li class="products-item">
                            <figure class="products-imgcontainer">
                                <img src="<?= esc($dish_img_src) ?>" alt="<?= esc($dish_name) ?>"> <!-- Dish image -->
                            </figure>
                            <div class="products-contentcontainer">
                                <div class="products-content">
                                    <h1><?= esc($dish_name) ?></h1> <!-- Dish name -->
                                    <div class="products-rating">
                                        <p>Vanaf € <?= esc($dish_price) ?></p> <!-- Dish price -->
                                    </div>
                                </div>
                                <div class="products-buttoncontainer">
                                    <a onclick="addToCart(<?= esc($dish['dish_id']) ?>, event, '<?= esc($dish['dish_name']) ?>', '<?= esc($dish['dish_price']) ?>', '<?= esc($dish['dish_img_src']) ?>'); return false;" class="products-button">
                                        <i class="fas fa-circle-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Geen gerechten beschikbaar.</p>
                <?php endif; ?>
            </ul>
        </main>
    </div>
</body>

</html>