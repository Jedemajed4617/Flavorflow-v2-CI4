<div class="cartcontainer">
    <div class="cart popup">
        <header class="cart-title">
            <h1 style="user-select: none;">Flavorflow.</h1>
            <p style="color: lightgrey; font-size: 1.5rem; user-select: none;">Winkelwagen <?php // echo $restaurant_name; ?></p>
        </header>
        <div class="cart-closecontainer">
            <i class="fas fa-xmark close-cart"></i>
        </div>
        <div class="cart-content">
            <ul class="cart-list">
                <!-- Cart items will be added here dynamically by js -->
            </ul>
            <footer class="cart-footercontainer">
                <div class="cart-footer">
                    <div class="cart-footercontainer">
                        <p>Subtotaal</p>
                        <p>€ 0,00</p>
                    </div>
                    <div class="cart-footercontainer">
                        <p>Bezorgkosten</p>
                        <p>€ 0,00</p>
                    </div>
                    <figure>
                        <!-- Seperator line -->
                    </figure>
                    <div class="cart-footercontainer">
                        <p>Totaal</p>
                        <p>€ 0,00</p>
                    </div>
                    <br>
                    <div class="cart-footerbutton">
                        <a href="<?= site_url('order') ?>">Afrekenen <p>( € 0,00)</p></a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        renderCart(); // pagina laad dan cart rendered
    });

    function addToCart(dishId, event, dishName, dishPrice, dishImgSrc) {
        event.preventDefault();

        let cart = getCartFromCookies();

        // Check if the item already exists in the cart
        const existingItem = cart.find(item => item.id === dishId);

        if (existingItem) {
            // Item exists, increment quantity
            existingItem.quantity = (existingItem.quantity || 1) + 1; // Increment or initialize to 1
        } else {
            // Item doesn't exist, add it to the cart
            const dish = {
                id: dishId,
                name: dishName,
                price: dishPrice,
                imgSrc: dishImgSrc,
                quantity: 1 // Initialize quantity to 1
            };
            cart.push(dish);
        }

        setCartToCookies(cart);
        showCustomMessage("Toegevoegd aan de winkelwagen.", true);
        console.log("Cart Cookie Value: ", getCartFromCookies());
    }

    // Helper function to get the cart from cookies
    function getCartFromCookies() {
        let cart = [];
        // Get all cookies
        let cookies = document.cookie.split(";");

        // Loop through cookies to find the cart cookie
        for (let i = 0; i < cookies.length; i++) {
            let cookie = cookies[i].trim();
            if (cookie.startsWith("cart=")) {
                // Parse the cookie value (assumed to be a JSON string)
                cart = JSON.parse(cookie.substring("cart=".length));
                break;
            }
        }

        return cart;
    }

    // Helper function to set the cart in cookies
    function setCartToCookies(cart) {
        let cartString = JSON.stringify(cart);

        // Set the cart cookie with an expiration of 30 days
        let expirationDate = new Date();
        expirationDate.setTime(expirationDate.getTime() + (30 * 24 * 60 * 60 * 1000)); // met 30 dagen verloopt
        document.cookie = "cart=" + cartString + "; expires=" + expirationDate.toUTCString() + "; path=/";

        renderCart(); // Refresh the UI dynamically
    }

    // Function to update cart quantity
    function updateCartQuantity(event) {
        const itemId = event.target.getAttribute("data-id");
        let newQuantity = parseInt(event.target.value);

        let cart = getCartFromCookies();
        cart = cart.map(item =>
            item.id == itemId ? {
                ...item,
                quantity: newQuantity
            } : item
        );

        setCartToCookies(cart); // Update cookies and UI
    }

    // Function to remove item from cart dynamically
    function removeFromCart(event) {
        const itemId = event.target.getAttribute("data-id");

        let cart = getCartFromCookies();
        cart = cart.filter(item => item.id != itemId);

        setCartToCookies(cart); // Update cookies and UI
        showCustomMessage("Item verwijderd uit de winkelwagen.", false);
    }

    // showing the cart items from cookies
    function renderCart() {
        const cartList = document.querySelector(".cart-list");
        let cartData = getCartFromCookies();
        const subtotalElement = document.querySelector(".cart-footercontainer:nth-child(1) p:nth-child(2)"); // Subtotal element
        const totalElement = document.querySelector(".cart-footercontainer:nth-child(4) p:nth-child(2), .totalprice-order"); // Total element
        const checkoutButtonPrice = document.querySelector(".cart-footerbutton p"); //checkout button price

        cartList.innerHTML = "";

        if (!cartData || cartData.length === 0) {
            cartList.innerHTML = "<p>Winkelwagen leeg.</p>";
            subtotalElement.textContent = "€ 0.00";
            totalElement.textContent = "€ 0.00";
            checkoutButtonPrice.textContent = "(€ 0.00)";
            return;
        }

        let subtotal = 0;

        cartData.forEach(item => {
            const cartItem = document.createElement("li");
            cartItem.classList.add("cart-item");
            cartItem.innerHTML = `
            <div class="cart-itemcontainer">
                <div class="cart-itemdelete">
                    <i class="fas fa-xmark delete-item" data-id="${item.id}"></i>
                </div>
                <figure class="cart-itemfigure">
                    <img src="${item.imgSrc}" alt="${item.name}">
                </figure>
            </div>
            <div class="cart-itemcontent">
                <h1>${item.name}</h1>
                <p>€ ${parseFloat(item.price).toFixed(2)}</p>
            </div>
            <ul class="cart-extras">
                <li>Kaassaus</li>
            </ul>
            <div class="cart-notebutton">
                <button class="cart-note">Opmerking</button>
            </div>
            <div class="cart-itembuttons">
                <input type="number" class="cart-quantity" value="${item.quantity || 1}" min="1" data-id="${item.id}">
            </div>
        `;
            cartList.appendChild(cartItem);

            // Calculate subtotal
            subtotal += item.price * (item.quantity || 1);
        });

        const deliveryCost = 0; // Placeholder for delivery cost (to be added later)
        const total = subtotal + deliveryCost;

        subtotalElement.textContent = "€ " + subtotal.toFixed(2);
        totalElement.textContent = "€ " + total.toFixed(2);
        checkoutButtonPrice.textContent = "(€ " + total.toFixed(2) + ")";

        const totalPriceElements = document.querySelectorAll(".totalprice-order");
        totalPriceElements.forEach(element => {
            element.textContent = `(€ ${total.toFixed(2)})`;
        });

        document.querySelectorAll(".cart-quantity").forEach(input => {
            input.addEventListener("change", updateCartQuantity);
        });

        document.querySelectorAll(".delete-item").forEach(button => {
            button.addEventListener("click", removeFromCart);
        });
    }
</script>