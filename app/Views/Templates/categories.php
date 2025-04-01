<div class="category-container">
    <section class="category-section">
        <header class="category-header">
            <h1 class="category-heading">Meest bekeken categorieën: </h1>
            <p class="category-subheading">Bekijk ons meest bezochte categorieën: </p>
        </header>
        <ul class="category-list" id="category-list"></ul>
        <div class="category-dots">
            <figure class="dot active"></figure>
            <figure class="dot"></figure>
            <figure class="dot"></figure>
        </div>
        <div class="category-linecontainer">
            <figure class="category-line"></figure>
        </div>
    </section>
</div>
<br>
<br>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const categories = [
            { "name": "Boodschappen", "image": "/img/productimg/grocery-basket.jpg" },
            { "name": "Burgers", "image": "/img/productimg/burger.jpg" },
            { "name": "Snacks", "image": "/img/productimg/snacks.jpg" },
            { "name": "Sushi", "image": "/img/productimg/sushi.jpg" },
            { "name": "Kip", "image": "/img/productimg/friedchicken.avif" },
            { "name": "Vers", "image": "/img/productimg/veggies.jpg" },
            { "name": "Döner", "image": "/img/productimg/doner.avif" },
            { "name": "Pizza", "image": "/img/productimg/pizza.jpg" },
            { "name": "Grill", "image": "/img/productimg/grill.webp" },
            { "name": "Drinken", "image": "/img/productimg/redbull.jpg" }
        ];

        const categoryList = document.getElementById("category-list");
        if (!categoryList) {
            console.warn("Category list not found");
            return;
        }

        categoryList.innerHTML = categories
            .map(
                (category) => `
            <li class="category">
                <figure class="category-figure">
                    <img class="category-img" src="${category.image}" alt="${category.name}">
                </figure>
                <figcaption class="category-caption">
                    <p class="category-text">${category.name}</p>
                </figcaption>
            </li>
        `
            )
            .join("");
    });
</script>
