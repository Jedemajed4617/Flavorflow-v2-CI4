<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/restaurants.css">
    <link rel="stylesheet" href="./css/password-change.css">
    <script src="./js/functions.js" defer></script>
    <script src="./js/main.js" defer></script>
    <title>Flavorflow - De beste online bestel-app</title>
    <link rel="shortcut icon" href="./img/F-logo.png" type="image/x-icon">
</head>

<body>
    <div id="message-container" class="message-container"></div>
    <div class="restaurants-container">
        <main class="restaurants">
            <header class="restaurants-header">
                <div class="restaurants-header-container">
                    <div class="restaurants-header-iconcontainer">
                        <i class="fas fa-list" id="open-filter"></i>
                    </div>
                    <h1>9 Beschikbaar</h1>
                </div>
                <div class="restaurants-search">
                    <input type="text" placeholder="Zoeken" required>
                    <button><i class="fas fa-search"></i></button>
                </div>
                <div class="filter-container">
                    <button class="filter-button">Beste match</button>
                    <button class="filter-button-active" onclick="toggleDropdown()">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-links" href="#">Option 1</a>
                        <a class="dropdown-links" href="#">Option 2</a>
                        <a class="dropdown-links" href="#">Option 3</a>
                    </div>
                </div>
            </header>
            <div class="restaurant-content">
                <aside class="restaurants-aside" id="restaurants-aside">
                    <ul class="restaurants-aside-list">
                        <button>
                            <p>Nu geopend</p><input class="input-slider" type="checkbox" name="" id="">
                        </button>
                        <button>
                            <p>Nieuw</p><input class="input-slider" type="checkbox" name="" id="">
                        </button>
                        <button>
                            <p>Gratis bezorging</p><input class="input-slider" type="checkbox" name="" id="">
                        </button>
                    </ul>
                    <div class="restaurants-aside-filter">
                        <header class="restaurants-aside-header">
                            <h1>Min. bestelbedrag</h1>
                        </header>
                        <ul class="restaurants-aside-list">
                            <button><input class="restaurant-inputs" type="checkbox" id="all">
                                <p>Toon alles (9)</p>
                            </button>
                            <button><input class="restaurant-inputs" type="checkbox" id="less10">
                                <p>€ 10,00 of minder (2)</p>
                            </button>
                            <button><input class="restaurant-inputs" type="checkbox" id="less15">
                                <p>€ 15,00 of minder (5)</p>
                            </button>
                            <button><input class="restaurant-inputs" type="checkbox" id="less25">
                                <p>€ 25,00 of minder (3)</p>
                            </button>
                        </ul>
                    </div>
                    <div class="restaurants-aside-filter">
                        <header class="restaurants-aside-header">
                            <h1>Dieetwens</h1>
                        </header>
                        <ul class="restaurants-aside-list">
                            <button><input type="checkbox" id="all">
                                <p>Halal</p>
                            </button>
                            <button><input type="checkbox" id="less10">
                                <p>Vegan</p>
                            </button>
                            <button><input type="checkbox" id="less15">
                                <p>Vegatarisch</p>
                            </button>
                            <button><input type="checkbox" id="less25">
                                <p>Lactose-vrij</p>
                            </button>
                            <button><input type="checkbox" id="less25">
                                <p>Noten-vrij</p>
                            </button>
                        </ul>
                    </div>
                    <div class="restaurants-aside-filter">
                        <header class="restaurants-aside-header">
                            <h1>Andere</h1>
                        </header>
                        <ul class="restaurants-aside-list">
                            <button><input type="checkbox" id="all">
                                <p>Aanbieding</p>
                            </button>
                            <button><input type="checkbox" id="less10">
                                <p>Stempelkaart</p>
                            </button>
                        </ul>
                    </div>
                </aside>
                <section class="restaurants-section">
                    <ul class="restaurants-list">
                        <?php if (!empty($restaurants)): ?>
                            <ul class="restaurants-list">
                                <?php foreach ($restaurants as $restaurant): ?>
                                    <?php
                                    // Check if the restaurant logo is available, otherwise use the default logo
                                    $logo_src = !empty($restaurant['restaurant_logo_src']) ? $restaurant['restaurant_logo_src'] : './img/logo-res.jpg';
                                    ?>
                                    <li class="restaurants-item">
                                        <figure class="restaurants-imgcontainer">
                                            <img src="<?= esc($logo_src) ?>" alt="Logo of <?= esc($restaurant['restaurant_name']) ?>">
                                        </figure>
                                        <div class="restaurants-contentcontainer">
                                            <div class="restaurants-content">
                                                <h1><?= esc($restaurant['restaurant_name']) ?></h1>
                                                <div class="restaurants-rating">
                                                    <i class="fas fa-star"></i>
                                                    <p>4.2 (23 reviews)</p>
                                                </div>
                                                <div class="restaurants-deliverytime">
                                                    <i class="fas fa-clock"></i>
                                                    <p>15-35m gemiddelde levertijd</p>
                                                </div>
                                            </div>
                                            <div class="restaurants-buttoncontainer">
                                                <a href="<?= site_url('restaurants/order/' . $restaurant['restaurant_id']) ?>" class="restaurants-button">
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>No restaurants available.</p>
                        <?php endif; ?>
                    </ul>
                </section>
            </div>
        </main>
    </div>
</body>

</html>