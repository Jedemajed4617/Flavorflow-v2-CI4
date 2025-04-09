<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('css/index.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/restaurant.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/cart.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/password-change.css') ?>">
    <script src="<?= base_url('js/functions.js') ?>" defer></script>
    <script src="<?= base_url('js/cart-logic.js') ?>" defer></script>
    <script src="<?= base_url('js/main.js') ?>" defer></script>
    <title>Flavorflow - De beste online bestel-app</title>
    <link rel="shortcut icon" href="<?= base_url('img/f-logo.png') ?>" type="image/x-icon">
</head>

<body>
    <style>
        .header-text-redesigned2{
            display: none !important;
        }
    </style>
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
                        <figure><p></p></figure>
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
                    <?php foreach ($dishes as $dish): ?>
                        <?php
                        $dish_price_original = (float)($dish['dish_price'] ?? 0);
                        $discount_percentage = isset($dish['active_discount']) ? (int)$dish['active_discount'] : 0;
                        $dish_price_final = $dish_price_original; 
                        $display_price_text = number_format($dish_price_original, 2);

                        if ($discount_percentage > 0 && $discount_percentage <= 100) {
                            if ($discount_percentage == 100) {
                                $dish_price_final = 0.00;
                                $display_price_text = 'Gratis';
                            } else {
                                $discount_amount = ($dish_price_original * $discount_percentage) / 100;
                                $dish_price_final = $dish_price_original - $discount_amount;
                                $display_price_text = number_format($dish_price_final, 2); 
                            }
                        }
                        $dish_id_js = esc($dish['dish_id'] ?? '', 'js');
                        $dish_name_js = esc($dish['dish_name'] ?? 'Unknown Dish', 'js');
                        // Pass the FINAL calculated numeric price to JS
                        $dish_price_js = esc($dish_price_final, 'js');
                        $dish_img_src_js = esc(!empty($dish['dish_img_src']) ? base_url($dish['dish_img_src']) : base_url('img/logo-res.jpg'), 'js');

                        // Prepare data for HTML display
                        $dish_name_html = esc($dish['dish_name'] ?? 'Unknown Dish');
                        $dish_img_src_html = esc(!empty($dish['dish_img_src']) ? base_url($dish['dish_img_src']) : base_url('img/logo-res.jpg'), 'attr');
                        $price_display_html = ($display_price_text === 'Gratis') ? 'Gratis' : 'Vanaf € ' . $display_price_text;

                        ?>
                        <li class="products-item">
                            <figure class="products-imgcontainer">
                                <img src="<?= $dish_img_src_html ?>" alt="<?= $dish_name_html ?>"> </figure>
                            <div class="products-contentcontainer">
                                <div class="products-content">
                                    <h1><?= $dish_name_html ?></h1> <div class="products-rating">
                                         <p><?= $price_display_html ?></p>
                                    </div>
                                </div>
                                <div class="products-buttoncontainer">
                                    <a href="#" onclick="addToCart('<?= $dish_id_js ?>', event, '<?= $dish_name_js ?>', '<?= $dish_price_js ?>', '<?= $dish_img_src_js ?>'); return false;" class="products-button">
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