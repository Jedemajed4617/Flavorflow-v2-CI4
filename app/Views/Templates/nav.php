<script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
<script src="https://kit.fontawesome.com/5a883bd754.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    /* Phone nav menu styling */
    .menu {
        position: fixed;
        top: 0;
        left: 0;
        width: 80vw;
        height: 100vh;
        background-color: white;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        z-index: 9999;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        box-shadow: 0 2px 600px rgba(0, 0, 0, 0.5);
    }

    .menu-container {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .menu-header {
        width: 100%;
        height: 10%;
        padding: 0.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid var(--subheading-color-lighter);
    }

    .menu-header>h1 {
        font-size: 2.5rem;
        color: var(--accent-color-lighter);
        padding-left: 1rem;
        text-transform: uppercase;
    }

    .menu-header>i {
        font-size: 2rem;
        color: var(--accent-color);
        padding-right: 0.5rem;
    }

    .menu-header>button {
        font-size: 2rem;
        color: var(--accent-color-lighter);
        padding-right: 1rem;
    }

    .menu-header>button:hover {
        color: var(--accent-color-lighter);
    }

    .menu.open {
        transform: translateX(0);
    }

    .menu-content {
        width: 100%;
        height: 90%;
        display: flex;
        flex-direction: column;
        gap: 3rem;
        font-family: "Oswald", sans-serif;
    }

    .menu-content>ul {
        width: 100%;
        height: auto;
        display: flex;
        flex-direction: column;
        padding-top: 1rem;
    }

    .menu-content>ul>li {
        width: 100%;
        display: flex;
        justify-content: space-between;
        height: auto;
        align-items: center;
        padding: 1rem;
    }

    .menu-content>ul>li>a {
        display: block;
        color: black;
        text-decoration: none;
        text-align: left;
        font-size: 1.7rem;
    }

    .menu-content>ul>li>i {
        font-size: 2rem;
        color: var(--accent-color);
    }

    .menu-content>ul>li>a:hover {
        background-color: #555;
    }

    .menu-footercontainer {
        width: 100%;
        height: auto;
        display: flex;
        align-items: flex-end;
    }

    .menu-footer {
        width: 100%;
        height: auto;
        display: flex;
        flex-direction: column;
        border-top: 1px solid var(--subheading-color-lighter);
        justify-content: end;
    }

    .menu-footer>li {
        width: 100%;
        height: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
    }

    .menu-link {
        width: 100%;
        height: auto;
        font-size: 1.7rem;
    }

    .menu-footer>li>i {
        font-size: 2rem;
        color: var(--accent-color);
    }
</style>

<div id="message-container" class="message-container"></div>

<nav class="menu" id="menu">
    <div class="menu-container">
        <header class="menu-header">
            <h1 onclick="window.location.href = '<?= site_url('/') ?>'">Flavorflow.</h1>
            <i class="fa-solid fa-xmark close-menu" id="close-menu"></i>
        </header>
        <div class="menu-content">
            <ul>
                <li><a href="<?= site_url('/') ?>" class="menu-link">Home</a><i class="fas fa-arrow-right"></i></li>
                <li><a href="<?= site_url('restaurants') ?>" class="menu-link">Restaurants</a><i class="fas fa-arrow-right"></i></li>
                <li><a href="#" class="menu-link">About</a><i class="fas fa-arrow-right"></i></li>
                <li><a href="#" class="menu-link">F.A.Q</a><i class="fas fa-arrow-right"></i></li>
                <li><a href="#" class="menu-link">Klantenservice</a><i class="fas fa-arrow-right"></i></li>
                <li><a href="#" class="menu-link">Algemene voorwaarden</a><i class="fas fa-arrow-right"></i></li>
                <li><a href="#" class="menu-link">Privacybeleid</a><i class="fas fa-arrow-right"></i></li>
                <li><a href="#" class="menu-link">Cookieverklaring</a><i class="fas fa-arrow-right"></i></li>
            </ul>
            <footer class="menu-footercontainer">
                <ul class="menu-footer">
                    <?php
                    if (isset($_SESSION['username'])) {
                        echo "<li><a href='site_url('profile')' class='menu-link'>Account</a><i class='fas fa-arrow-right'></i></li>";
                        echo "<li><a href='base_url('logout')' class='menu-link'>Logout</a><i class='fas fa-arrow-right'></i></li>";
                    } else {
                        echo "<li><a href='site_url('account/index')' class='menu-link'>Login</a><i class='fas fa-arrow-right'></i></li>";
                        echo "<li><a href='site_url('account/register')' class='menu-link'>Register</a><i class='fas fa-arrow-right'></i></li>";
                    }
                    ?>
                    <li><a href="#" class="menu-link">Nederlands</a><i class="fas fa-arrow-right"></i></li>
                </ul>
            </footer>
        </div>
    </div>
</nav>
<header class="header">
    <div class="navbar-container">
        <nav class="navbar">
            <div class="logo">
                <h1 onclick="window.location.href = '<?= site_url('/') ?>'">Flavorflow.</h1>
            </div>
            <ul class="nav-links">
                <li><a href="<?= site_url('/'); ?>">Home</a></li>
                <li>|</li>
                <li><a href="#">About</a></li>
                <li>|</li>
                <li><a href="<?= site_url('restaurants'); ?>">Restaurants</a></li>
                <li>|</li>
                <li><a href="#">F.A.Q</a></li>
            </ul>
            <div class="account">
                <figure class="flag">
                    <img class="flag-img" src="./img/dutchflag.png" alt="Image of the dutch flag">
                </figure>
                <div class="account-icon">
                    <?php
                    if (!isset($_SESSION['username'])) {
                        echo "<a class='icon-container' href='" . site_url('account') . "'><i class='fas fa-user icon'></i></a>";
                    } else {
                        echo "<a class='icon-container' href='" . site_url('profile') . "'><i class='fas fa-user icon'></i></a>";
                    }
                    ?>
                </div>
                <div class="account-bars" id="menu-icon">
                    <figure class="bar"></figure>
                    <figure class="bar"></figure>
                    <figure class="bar"></figure>
                </div>
            </div>
        </nav>
    </div>
    <div class="navbar-underlinecontainer">
        <figure class="navbar-underline"></figure>
    </div>
    <div class="header-container-redesigned">
        <div class="header-background">
            <img class="header-background-image" src="<?= base_url('img/banner-food.webp') ?>" alt="Food Banner">
            <div class="header-overlay"></div>
            <div class="header-overlay-figure"></div>
            <div class="header-overlay-figure2"></div>
        </div>
        <div class="header-content-redesigned">
            <div class="header-text-redesigned">
                <h1>Ontdek de mogelijkheden.</h1>
                <p>Zoek hier uw adres en begin met bestellen.</p>
            </div>
            <div class="header-search-container">
                <input type="text" class="header-search-input" placeholder="Zoek naar restaurants of gerechten" required>
                <button onclick="window.location.href = '<?= site_url('restaurants') ?>'" class="header-search-button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</header>

<div class="navbar-underlinecontainer">
    <figure class="navbar-underline"></figure>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const menuIcon = document.getElementById("menu-icon");
        const menu = document.getElementById("menu");
        const menuContainer = document.getElementById("menu-container");
        const closeMenu = document.getElementById("close-menu");

        let isOpen = false;

        if (menuIcon && menu) {
            menuIcon.addEventListener("click", function() {
                isOpen = !isOpen;
                menu.classList.toggle("open", isOpen);
                document.body.style.overflow = isOpen ? "hidden" : "auto";
            });
        }

        if (closeMenu && menu) {
            closeMenu.addEventListener("click", function() {
                isOpen = false;
                menu.classList.remove("open");
                document.body.style.overflow = "auto";
            });
        }

        if (menuContainer && menuIcon && menu) {
            document.addEventListener("click", function(event) {
                if (!menuContainer.contains(event.target) && event.target !== menuIcon) {
                    isOpen = false;
                    menu.classList.remove("open");
                    document.body.style.overflow = "auto";
                }
            });
        }
    });
</script>