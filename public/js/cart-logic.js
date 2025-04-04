function getCartFromCookies() {
    let cart = [];
    const cookies = document.cookie.split(";");
    for (let i = 0; i < cookies.length; i++) {
        let cookie = cookies[i].trim();
        if (cookie.startsWith("cart=")) {
            try {
                cart = JSON.parse(cookie.substring("cart=".length));
                if (!Array.isArray(cart)) {
                    console.warn("Cart cookie data is not an array, resetting.");
                    cart = [];
                }
            } catch (e) {
                console.error("Error parsing cart cookie:", e);
                cart = []; 
                document.cookie = "cart=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            }
            break; 
        }
    }
    return cart;
}

function setCartToCookies(cart) {
    const cartToSave = Array.isArray(cart) ? cart : [];
    let cartString = JSON.stringify(cartToSave);

    let expirationDate = new Date();
    expirationDate.setTime(expirationDate.getTime() + 30 * 24 * 60 * 60 * 1000);
    document.cookie = "cart=" + cartString + "; expires=" + expirationDate.toUTCString() + "; path=/; SameSite=Lax"; // Added SameSite attribute

    renderCart(); 
    showCartQuantity(); 
}

function showCartQuantity() {
    const currentCart = getCartFromCookies(); // Get fresh cart data
    const totalQuantity = currentCart.reduce((sum, item) => sum + (item.quantity || 1), 0);

    // Select the figure element (the red circle)
    const quantityFigureElement = document.querySelector(".restaurant-basket > figure");
    // Select the p tag inside the figure where the number goes
    const showQuantityTextElement = quantityFigureElement?.querySelector("p"); // Use optional chaining

    // Check if the main figure element exists
    if (quantityFigureElement) {
        if (totalQuantity > 0) {
            quantityFigureElement.style.display = 'flex';

            if (showQuantityTextElement) {
                showQuantityTextElement.textContent = String(totalQuantity); 
            } else {
                 console.warn("Element 'p' inside '.restaurant-basket > figure' not found for quantity text.");
            }
        } else {
            quantityFigureElement.style.display = 'none';
        }
    } else {
        console.warn("Element '.restaurant-basket > figure' not found for quantity indicator.");
    }
}

function renderCart() {
    const cartList = document.querySelector(".cart-list");
    const subtotalElement = document.getElementById("subtotal");
    const deliveryCostElement = document.getElementById("deliverycost");
    const totalElement = document.getElementById("total");
    const checkoutButton = document.querySelector("#checkout-button");
    const checkoutButtonPrice = checkoutButton?.querySelector("p");

    if (!cartList || !subtotalElement || !deliveryCostElement || !totalElement || !checkoutButton || !checkoutButtonPrice) {
        return;
    }
    
    const orderUrl = checkoutButton.getAttribute('data-order-url'); 

    let cartData = getCartFromCookies();
    cartList.innerHTML = "";
    let subtotal = 0;

    if (!cartData || cartData.length === 0) {
        cartList.innerHTML = "<p>Winkelwagen leeg.</p>";
        subtotalElement.textContent = "€ 0.00";
        deliveryCostElement.textContent = "€ 0.00";
        totalElement.textContent = "€ 0.00";
        checkoutButtonPrice.textContent = "(€ 0.00)";

        checkoutButton.classList.add('disabled');
        checkoutButton.setAttribute('href', 'javascript:void(0)'); // Prevent click
        checkoutButton.setAttribute('title', 'Uw winkelwagen is leeg.');

        return; 
    }

    checkoutButton.classList.remove('disabled');
    checkoutButton.setAttribute('href', orderUrl); 
    checkoutButton.setAttribute('title', 'Ga naar afrekenen'); 

    // Render cart items
    cartData.forEach(item => {
        const cartItem = document.createElement("li");
        cartItem.classList.add("cart-item");
        const imgSrc = item.imgSrc || '../img/default.png'; 
        const price = parseFloat(item.price) || 0;

        cartItem.innerHTML = `
            <div class="cart-itemcontainer">
                <div class="cart-itemdelete">
                    <i class="fas fa-xmark delete-item" data-id="${item.id}"></i>
                </div>
                <figure class="cart-itemfigure">
                    <img src="${imgSrc}" alt="${item.name || 'Product'}">
                </figure>
            </div>
            <div class="cart-itemcontent">
                <h1>${item.name || 'Unnamed Item'}</h1>
                <p>€ ${price.toFixed(2)}</p>
            </div>
            <div class="cart-itembuttons">
                <input type="number" class="cart-quantity" value="${item.quantity || 1}" min="1" data-id="${item.id}">
            </div>
        `;
        cartList.appendChild(cartItem);
        subtotal += price * (item.quantity || 1);
    });

    // Calculate totals
    let deliveryCost = 0.00;
    const minimumOrderAmount = 15.00;
    const deliveryFee = 3.50;
    if (subtotal > 0 && subtotal < minimumOrderAmount) {
        deliveryCost = deliveryFee;
    }
    const total = subtotal + deliveryFee;

    // Update display
    subtotalElement.textContent = "€ " + subtotal.toFixed(2);
    deliveryCostElement.textContent = "€ " + deliveryFee.toFixed(2);
    totalElement.textContent = "€ " + total.toFixed(2);
    checkoutButtonPrice.textContent = "(€ " + total.toFixed(2) + ")";

    attachCartEventListeners();
}

function addToCart(dishId, event, dishName, dishPrice, dishImgSrc) {
    if (event) {
        event.preventDefault(); 
        event.stopPropagation(); 
    }

    console.log(`Adding to cart: ID=${dishId}, Name=${dishName}, Price=${dishPrice}, Img=${dishImgSrc}`); 

    let cart = getCartFromCookies();
    const existingItem = cart.find((item) => String(item.id) === String(dishId)); 

    const price = parseFloat(dishPrice);
    if (isNaN(price)) {
        console.error("Invalid price provided for item:", dishName, dishPrice);
        alert("Error: Kon item niet toevoegen (ongeldige prijs)."); 
        return;
    }

    if (existingItem) {
        existingItem.quantity = (existingItem.quantity || 1) + 1;
    } else {
        cart.push({
            id: String(dishId),
            name: dishName,
            price: price.toFixed(2), 
            imgSrc: dishImgSrc || '<?= base_url("img/logo-res.jpg") ?>', 
            quantity: 1,
        });
    }

    setCartToCookies(cart);

    if (typeof showCustomMessage === "function") {
        showCustomMessage(dishName + " toegevoegd aan winkelwagen.", true);
    } else {
        console.warn("showCustomMessage function not found.");
    }
    console.log("Cart updated (add):", getCartFromCookies());
}

function updateCartQuantity(event) {
    const inputElement = event.target;
    const itemId = inputElement.getAttribute("data-id");
    let newQuantity = parseInt(inputElement.value, 10);

    if (isNaN(newQuantity) || newQuantity < 1) {
        newQuantity = 1;
        inputElement.value = newQuantity; 
    }

    let cart = getCartFromCookies();
    cart = cart.map((item) => {
        if (String(item.id) === String(itemId)) {
            return { ...item, quantity: newQuantity };
        }
        return item;
    });

    // Save changes and update UI
    setCartToCookies(cart);
    console.log("Cart updated (update quantity):", getCartFromCookies());
}

function removeFromCart(event) {
    const targetElement = event.target.closest("[data-id]");
    if (!targetElement) {
        console.error("Could not find item ID for removal.");
        return;
    }
    const itemId = targetElement.getAttribute("data-id");

    let cart = getCartFromCookies();
    const itemToRemove = cart.find((item) => String(item.id) === String(itemId));
    cart = cart.filter((item) => String(item.id) !== String(itemId));

    setCartToCookies(cart);

    if (typeof showCustomMessage === "function" && itemToRemove) {
        showCustomMessage(itemToRemove.name + " verwijderd uit winkelwagen.", false);
    } else if (!itemToRemove) {
        console.warn("Tried to remove item not found in cart data:", itemId);
    }

    console.log("Cart updated (remove):", getCartFromCookies());
}

function attachCartEventListeners() {
    const cartList = document.querySelector(".cart-list");
    if (cartList) {
        cartList.removeEventListener("change", handleCartChange);
        cartList.removeEventListener("click", handleCartClick);

        cartList.addEventListener("change", handleCartChange);
        cartList.addEventListener("click", handleCartClick);
    }
}

function handleCartChange(event) {
    if (event.target.classList.contains("cart-quantity")) {
        updateCartQuantity(event);
    }
}

function handleCartClick(event) {
    if (event.target.closest(".delete-item")) {
        removeFromCart(event);
    }
}

function openCart() {
    const cartContainer = document.querySelector('.cartcontainer');
    const cartPopup = cartContainer?.querySelector('.cart.popup'); 

    if (!cartContainer || !cartPopup) {
        console.error("Cannot open cart: container or popup element not found.");
        return;
    }

    renderCart();
    cartContainer.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    setTimeout(() => {
        cartPopup.classList.add('open');
    }, 10); // Small delay allows display change to render first

    console.log("Cart Opening Initiated");
}

function closeCart() {
    const cartContainer = document.querySelector('.cartcontainer');
    const cartPopup = cartContainer?.querySelector('.cart.popup');

    if (!cartContainer || !cartPopup || cartContainer.style.display === 'none') {
        return;
    }

    cartPopup.classList.remove('open');

    setTimeout(() => {
        cartContainer.style.display = 'none';
        document.body.style.overflow = 'auto';

        console.log("Cart Closed Completely");
    }, 300); 

    console.log("Cart Closing Initiated");
}

document.addEventListener("DOMContentLoaded", function() {
    console.log("DOM Loaded. Initializing Cart Logic & Listeners...");

    showCartQuantity(); 
    renderCart();       
    attachCartEventListeners(); 

    const basketIcon = document.querySelector(".restaurant-basket");
    const cartContainer = document.querySelector('.cartcontainer');
    const closeButton = document.querySelector(".close-cart");

    if (basketIcon) {
        basketIcon.addEventListener('click', (event) => {
            event.stopPropagation(); 
            openCart();
        });
    } else {
        console.error("Basket icon (.restaurant-basket) not found.");
    }

    if (closeButton) {
        closeButton.addEventListener('click', (event) => {
            event.stopPropagation();
            closeCart();
        });
    } else {
        console.error("Close button (.close-cart) not found.");
    }

    if (cartContainer) {
        cartContainer.addEventListener('click', (event) => {
            if (event.target === cartContainer) {
                closeCart();
            }
        });
    } else {
        console.error("Cart container not found (for overlay click listener).");
    }

    document.addEventListener('keydown', (event) => {
        if (cartContainer && cartContainer.style.display !== 'none' && event.key === 'Escape') {
            closeCart();
        }
    });
});

window.addToCart = addToCart;
