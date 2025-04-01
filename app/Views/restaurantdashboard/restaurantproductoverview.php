<?php

$session = session();

if ($session->get('logged_in')) {
    $fname = $session->get('fname');
    $lname = $session->get('lname');
    $fullname = $fname . ' ' . $lname;
    $username = $session->get('username');
    $email = $session->get('email');
    $phone = $session->get('phone');
    $checkbirthdate = $session->get('birthdate');
    $gender = $session->get('gender');
    $profileimg = $session->get('profile_img_src');
    $standardaddress = $session->get('standardaddress');
    $rank = $session->get('user_type');
}

if (empty($checkbirthdate)) {
    $birthdate = "Niet ingesteld";
} else {
    $birthdate = $checkbirthdate;
}

$restaurant_id = $session->get('restaurant_id');

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="/css/index.css" />
    <link rel="stylesheet" href="/css/order.css" />
    <link rel="stylesheet" href="/css/profile.css" />
    <link rel="stylesheet" href="/css/restaurants.css" />
    <link rel="stylesheet" href="/css/notification-error.css" />
    <link rel="stylesheet" href="/css/admin-modal.css" />
    <link rel="stylesheet" href="/css/password-change.css" />
    <link rel="stylesheet" href="/css/login.css" />
    <script src="/js/functions.js" defer></script>
    <script src="/js/main.js" defer></script>
    <title>Flavorflow - De beste online bestel-app</title>
    <link rel="shortcut icon" href="/img/F-logo.png" type="image/x-icon" />
</head>

<body>
    <script>
        $(document).ready(function() {
            const $modal = $(".moreinfocontainer");
            const $modalContent = $(".moreinfo");
            const $openButtons = $(".product-info-listitem > a");
            const $closeButtons = $(".close-moreinfo");

            if (!$modal.length || !$modalContent.length) {
                console.warn("Error: Modal elements not found.");
                return;
            }

            function openModal(event) {
                event.preventDefault();

                // Populate the modal with dish data
                const $button = $(this);
                const dishId = $button.data("id");
                const dishName = $button.data("name");
                const dishPrice = $button.data("price");
                const dishCategory = $button.data("category");
                const dishCreated = $button.data("created");
                const dishDiscount = $button.data("discount");
                const dishCreatedBy = $button.data("createdBy");
                const dishStatus = $button.data("status");
                const dishDescription = $button.data("description");
                const dishPriceVat = (dishPrice * 0.79).toFixed(2);
                const dishImage = $button.data("pimage");

                $("#show_dish_id").val("#" + dishId);
                $("#show_dish_name").val(dishName);
                $("#show_dish_price").val("€ " + dishPrice);
                $("#dish_category2").val(dishCategory);
                $("#show_when_created").val(dishCreated);
                $("#show_created_by").val(dishCreatedBy);
                $("#show_discount").val(dishDiscount);
                $("#show_status").val(dishStatus);
                $("#show_dish_desc").val(dishDescription);
                $("#show_dish_pricevat").val("€ " + dishPriceVat);
                $("#show_dish_img").attr("src", dishImage);

                // Open modal
                $modal.css("display", "flex");

                // Ensure animation triggers after display change
                setTimeout(() => {
                    $modal.addClass("open");
                }, 0);

                $("body").css("overflow", "hidden");
            }

            function closeModal() {
                $modal.addClass("closing");
                setTimeout(() => {
                    $modal.removeClass("open closing");
                    $modal.css("display", "none"); // Hide modal after animation
                    $("body").css("overflow", "auto");
                }, 300); // Match CSS transition time
            }

            $openButtons.on("click", openModal);
            $closeButtons.on("click", closeModal);

            $(document).on("keydown", function(event) {
                if (event.key === "Escape" && $modal.hasClass("open")) {
                    closeModal();
                }
            });
        });
    </script>
    <script>
        $(function() { // Shorthand for $(document).ready()
            const $searchBar = $("#dish_category");
            const $dataList = $("#productcategorielist");

            if (!$searchBar.length || !$dataList.length) {
                return console.warn("Elements not found: #dish_category or #productcategorielist");
            }

            // Debounce the input handler to prevent excessive AJAX calls
            let debounceTimer;
            $searchBar.on("input", function() {
                clearTimeout(debounceTimer);
                const query = $(this).val().trim();

                if (query.length > 1) {
                    debounceTimer = setTimeout(() => fetchCategories(query), 300);
                } else {
                    $dataList.addClass("hidden").empty();
                }
            });

            // Handle category selection
            $dataList.on("click", "li", function() {
                $searchBar.val($(this).text()).trigger("focus");
                $dataList.addClass("hidden");
            });

            // Hide dropdown on outside click or Enter key
            $(document).on("click keydown", function(e) {
                if (e.type === "click" && !isChildOf(e.target, $searchBar) && !isChildOf(e.target, $dataList)) {
                    $dataList.addClass("hidden");
                } else if (e.type === "keydown" && e.key === "Enter") {
                    $dataList.addClass("hidden");
                }
            });

            // Fetch categories via AJAX
            function fetchCategories(query) {
                $.ajax({
                    url: "<?= site_url('products/getcategories') ?>",
                    method: "POST",
                    data: {
                        query: query
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $dataList.removeClass("hidden").empty().append(
                            $("<li>").text("Loading...").addClass("loading")
                        );
                    },
                    success: function(data) {
                        if (!Array.isArray(data)) {
                            return showError("Invalid response format");
                        }

                        $dataList.empty();

                        if (data.length) {
                            $.each(data, function(_, category) {
                                $dataList.append(
                                    $("<li>").text(category.category_name)
                                );
                            });
                        } else {
                            showNoResults();
                        }
                    },
                    error: function(xhr, status, error) {
                        showError("Error fetching categories: " + error);
                    }
                });
            }

            function showNoResults() {
                $dataList.append(
                    $("<li>").text("Geen resultaten gevonden").addClass("no-results")
                );
            }

            function showError(message) {
                console.error(message);
                $dataList.empty().append(
                    $("<li>").text("Error loading results").addClass("error")
                );
            }

            function isChildOf(child, parent) {
                return parent.has(child).length || parent.is(child);
            }
        });

        $(function() { // Shorthand for $(document).ready()
            const $searchBar = $("#dish_category2");
            const $dataList = $("#productcategorielist2");

            if (!$searchBar.length || !$dataList.length) {
                return console.warn("Elements not found: #dish_category or #productcategorielist");
            }

            // Debounce the input handler to prevent excessive AJAX calls
            let debounceTimer;
            $searchBar.on("input", function() {
                clearTimeout(debounceTimer);
                const query = $(this).val().trim();

                if (query.length > 1) {
                    debounceTimer = setTimeout(() => fetchCategories(query), 300);
                } else {
                    $dataList.addClass("hidden").empty();
                }
            });

            // Handle category selection
            $dataList.on("click", "li", function() {
                $searchBar.val($(this).text()).trigger("focus");
                $dataList.addClass("hidden");
            });

            // Hide dropdown on outside click or Enter key
            $(document).on("click keydown", function(e) {
                if (e.type === "click" && !isChildOf(e.target, $searchBar) && !isChildOf(e.target, $dataList)) {
                    $dataList.addClass("hidden");
                } else if (e.type === "keydown" && e.key === "Enter") {
                    $dataList.addClass("hidden");
                }
            });

            // Fetch categories via AJAX
            function fetchCategories(query) {
                $.ajax({
                    url: "<?= site_url('products/getcategories') ?>",
                    method: "POST",
                    data: {
                        query: query
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $dataList.removeClass("hidden").empty().append(
                            $("<li>").text("Loading...").addClass("loading")
                        );
                    },
                    success: function(data) {
                        if (!Array.isArray(data)) {
                            return showError("Invalid response format");
                        }

                        $dataList.empty();

                        if (data.length) {
                            $.each(data, function(_, category) {
                                $dataList.append(
                                    $("<li>").text(category.category_name)
                                );
                            });
                        } else {
                            showNoResults();
                        }
                    },
                    error: function(xhr, status, error) {
                        showError("Error fetching categories: " + error);
                    }
                });
            }

            function showNoResults() {
                $dataList.append(
                    $("<li>").text("Geen resultaten gevonden").addClass("no-results")
                );
            }

            function showError(message) {
                console.error(message);
                $dataList.empty().append(
                    $("<li>").text("Error loading results").addClass("error")
                );
            }

            function isChildOf(child, parent) {
                return parent.has(child).length || parent.is(child);
            }
        });

        function permDeleteDishShowText(dishStatus) {
            const deleteDishText = $("#permdel");

            // Convert to number if it's a string "0" or "1"
            const status = typeof dishStatus === 'string' ? parseInt(dishStatus) : dishStatus;

            if (status === 0 || dishStatus === "Actief") {
                deleteDishText.text("Weet u zeker dat u dit product wilt de-activeren?");
            } else {
                deleteDishText.text("Weet u zeker dat u dit product permanent wilt verwijderen?");
            }
        }

        function openDeleteDish() {
            const dishStatus = $("#show_status").val();
            permDeleteDishShowText(dishStatus);
            openPopup("deleteproductcontainer", "close-deleteproduct");
        }

        function submitDeletedish() {
            let dishId = $("#show_dish_id").val();
        
            if (dishId.startsWith("#")) {
                dishId = dishId.substring(1);
            }

            if (dishId.trim() === "") {
                showCustomMessage("Product niet gevonden", false);
                return;
            }

            let filteredDishID = dishId.trim();

            let formData = {
                dishid: filteredDishID
            };

            $.ajax({
                url: "<?= site_url('products/deleteproduct') ?>",
                method: "POST",
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        showCustomMessage(response.message, true);
                        closePopup('deleteproductcontainer', 'close-deleteproduct');
                        setTimeout(() => location.reload(), 2000);
                    } else {
                        showCustomMessage(response.message, true); 
                        closePopup('deleteproductcontainer', 'close-deleteproduct');
                        setTimeout(() => location.reload(), 2000);
                    }
                },
                error: function() {
                    showCustomMessage("Er is een fout opgetreden.", false);
                }
            });
        }

        function submitDishstatus(event) {
            event.preventDefault();

            let dishId = $("#show_dish_id").val();
            const status = $('input[name="status"]:checked').val();
            let showNewStatus = $("#show_status");

            const statuscontainer = $(".status");

            if (!status) {
                showCustomMessage("Kies een status voor het gerecht.", false);
                return;
            }

            if (dishId.startsWith("#")) {
                dishId = dishId.substring(1);
            }

            if (dishId.trim() === "") {
                showCustomMessage("Product niet gevonden", false);
                return;
            }

            let formData = {
                status: status,
                dishid: dishId
            };

            $.ajax({
                url: "<?= site_url('products/changeproductstatus') ?>",
                method: "POST",
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response['status'] == 'success') {
                        console.log('Helemaal piem');
                        closePopup('statuscontainer', 'close-status');
                        showCustomMessage("Status van het product is veranderd.", true);
                        newStatus = response['newstatus'];
                        showNewStatus.val(newStatus == 0 ? "Actief" : "Non-actief");
                    } else {
                        showCustomMessage(response['message'], false);
                        formData.reset();
                        return;
                    }
                },
                error: function() {
                    showCustomMessage("Er is een fout opgetreden. Probeer het later opnieuw", false);
                }
            });
        }

        function submitChangeDishname(){
            let dishId = $("#show_dish_id").val();
            let dishName = $("#show_dish_name").val();

            if (!dishName && $dishName < 2) {
                showCustomMessage("Geen geldige naam opgegeven.", false);
                return;
            }

            if (dishId.startsWith("#")) {
                dishId = dishId.substring(1);
            }

            if (dishId.trim() === "") {
                showCustomMessage("Product niet gevonden", false);
                return;
            }

            let formData = {
                dishname: dishName,
                dishid: dishId
            };

            $.ajax({
                url: "<?= site_url('products/changedishname') ?>",
                method: "POST",
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response['status'] == 'success') {
                        console.log('Helemaal piem');
                        showCustomMessage("Status van het product is veranderd.", true);
                        newDishname = response['newdishname'];
                        dishName.val(newDishname);
                    } else {
                        showCustomMessage(response['message'], false);
                        formData.reset();
                        return;
                    }
                },
                error: function() {
                    showCustomMessage("Er is een fout opgetreden. Probeer het later opnieuw", false);
                }
            });
        }

        function submitChangedishprice(){
            let dishId = $("#show_dish_id").val();
            let dishPrice = $("#show_dish_price").val();

            if (!dishPrice) {
                showCustomMessage("Geen pijs ontvangen.", false);
                return;
            }

            if (dishPrice.startsWith("€")) {
                dishPrice = dishPrice.substring(1); // Remove the euro sign
            }

            if (dishId.startsWith("#")) {
                dishId = dishId.substring(1);
            }

            if (dishId.trim() === "") {
                showCustomMessage("Product niet gevonden", false);
                return;
            }

            let formData = {
                dishprice: dishPrice,
                dishid: dishId
            };

            $.ajax({
                url: "<?= site_url('products/changedishprice') ?>",
                method: "POST",
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response['status'] == 'success') {
                        console.log('Helemaal piem');
                        showCustomMessage("Prijs van het product is veranderd.", true);
                        newDishprice = response['newdishprice'];
                        dishPrice.val(newDishname);
                    } else {
                        showCustomMessage(response['message'], false);
                        formData.reset();
                        return;
                    }
                },
                error: function() {
                    showCustomMessage("Er is een fout opgetreden. Probeer het later opnieuw", false);
                }
            });
        }

        function submitChangeDesc(){
            let dishId = $("#show_dish_id").val();
            let dishDesc = $("#show_dish_desc").val();

            if (!dishDesc) {
                showCustomMessage("Geen beschrijving ontvangen.", false);
                return;
            }

            if (dishId.startsWith("#")) {
                dishId = dishId.substring(1);
            }

            if (dishId.trim() === "") {
                showCustomMessage("Product niet gevonden", false);
                return;
            }

            let formData = {
                dishdesc: dishDesc,
                dishid: dishId
            };

            $.ajax({
                url: "<?= site_url('products/changedishdesc') ?>",
                method: "POST",
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response['status'] == 'success') {
                        console.log('Helemaal piem');
                        showCustomMessage("Beschrijving van het product is veranderd.", true);
                        newDishdesc = response['newdishdescription'];
                        dishDesc.val(newDishdesc);
                    } else {
                        showCustomMessage(response['message'], false);
                        formData.reset();
                        return;
                    }
                },
                error: function() {
                    showCustomMessage("Er is een fout opgetreden. Probeer het later opnieuw", false);
                }
            });
        }

        function submitChangeCategorie(){
            let dishId = $("#show_dish_id").val();
            let dishCategory = $("#dish_category2").val();

            if (!dishCategory) {
                showCustomMessage("Veld mag niet leeg zijn", false);
                return;
            }

            if (dishId.startsWith("#")) {
                dishId = dishId.substring(1);
            }

            if (dishId.trim() === "") {
                showCustomMessage("Product niet gevonden", false);
                return;
            }

            let formData = {
                dishcategory: dishCategory,
                dishid: dishId
            };

            $.ajax({
                url: "<?= site_url('products/changedishcategory') ?>",
                method: "POST",
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response['status'] == 'success') {
                        console.log('Helemaal piem');
                        showCustomMessage("Beschrijving van het product is veranderd.", true);
                        newDishCategory = response['newdishcategory'];
                        dishCategory.val(newDishCategory);
                    } else {
                        showCustomMessage(response['message'], false);
                        formData.reset();
                        return;
                    }
                },
                error: function() {
                    showCustomMessage("Er is een fout opgetreden. Probeer het later opnieuw", false);
                }
            });
        }

        function submitAddDiscount(event){
            event.preventDefault();

            let dishId = $("#show_dish_id").val();
            let discount = $("#discountmenu").val();
            let showNewDiscount = $("#show_discount");  

            if (!discount) {
                showCustomMessage("Geen korting ontvangen.", false);
                return;
            }

            if (dishId.startsWith("#")) {
                dishId = dishId.substring(1);
            }

            if (dishId.trim() === "") {
                showCustomMessage("Product niet gevonden", false);
                return;
            }

            let formData = {
                discount: discount,
                dishid: dishId
            };

            $.ajax({
                url: "<?= site_url('products/setproductdiscount') ?>",
                method: "POST",
                data: formData,
                dataType: "json",
                success: function(response) {
                    if (response['status'] == 'success') {
                        console.log('Helemaal piem');
                        showCustomMessage("De korting is toegepast.", true);
                        newDiscount = response['newdishdiscount'];
                        showNewDiscount.val(newDiscount);
                        closePopup('discountcontainer', 'close-discount');
                    } else {
                        showCustomMessage(response['message'], false);
                        formData.reset();
                        return;
                    }
                },
                error: function() {
                    showCustomMessage("Er is een fout opgetreden. Probeer het later opnieuw", false);
                }
            });

        }

        function submitChangeProductImage(event){
            event.preventDefault();

            let dishId = $("#show_dish_id").val();
            let fileInput = $("#product_image_change")[0];

            if (fileInput.files.length === 0) {
                showCustomMessage("Geen afbeelding geselecteerd.", false);
                return;
            }

            if (dishId.startsWith("#")) {
                dishId = dishId.substring(1);
            }

            if (dishId.trim() === "") {
                showCustomMessage("Product niet gevonden", false);
                return;
            }

            let formData = new FormData();
            formData.append('dishid', dishId);
            formData.append('restaurant_id', $('#restaurantid').val());

            if ($('#product_image_change')[0].files[0]) {
                if (fileInput.files.length > 1) {
                    showCustomMessage("U kunt slechts één bestand uploaden.", false);
                    return;
                }
                formData.append('dishimage', fileInput.files[0]);
            }

            $.ajax({
                url: "<?= site_url('products/changeproductimage') ?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false, 
                dataType: "json",
                success: function(response) {
                    if (response.status == 'success') {
                        console.log('Helemaal piem');
                        showCustomMessage("Product afbeelding vernaderd.", true);
                        closePopup('productimagecontainer', 'close-productimage');
                        setTimeout(() => location.reload(), 2000);
                    } else {
                        showCustomMessage(response.message || "Er is een fout opgetreden", false);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                    showCustomMessage("Er is een fout opgetreden, probeer later opnieuw", false);
                }
            });

        }

        function submitAddProduct(event) {
            event.preventDefault();
            const calender = $(".addproduct");

            // Create FormData object to properly handle file uploads
            const formData = new FormData();
            formData.append('dishname', $('#dish_name').val());
            formData.append('dishprice', $('#dish_price').val());
            formData.append('dishdesc', $('#dish_desc').val());
            formData.append('dishcategory', $('#dish_category').val());
            formData.append('restaurant_id', $('#resid').val());
            formData.append('fullname', $('#fullname').val());

            // Append file if selected
            if ($('#dish_img')[0].files[0]) {
                const fileInput = $('#dish_img')[0];
                if (fileInput.files.length > 1) {
                    showCustomMessage("U kunt slechts één bestand uploaden.", false);
                    return;
                }
                formData.append('dishimage', fileInput.files[0]);
            }

            $.ajax({
                url: "<?= site_url('products/addproduct') ?>",
                type: "POST",
                data: formData,
                processData: false, // Prevent jQuery from automatically transforming the data into a query string
                contentType: false, // Prevent jQuery from setting the content type
                dataType: "json",
                success: function(response) {
                    if (response.status == 'success') {
                        console.log('Helemaal piem');
                        showCustomMessage("Product toegevoegd.", true);
                        closePopup('addproductcontainer', 'close-addproduct');
                        setTimeout(() => location.reload(), 2000);
                    } else {
                        showCustomMessage(response.message || "Er is een fout opgetreden", false);
                        // Reset form if needed
                        $('.addproduct form')[0].reset();
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                    showCustomMessage("Er is een fout opgetreden, probeer later opnieuw", false);
                }
            });
        }
    </script>
    <div class="moreinfocontainer">
        <div class="deleteproductcontainer">
            <div class="deleteproduct popup">
                <header class="calenderheader">
                    <i class="fas fa-times close-deleteproduct"></i>
                </header>
                <div class="gender-form">
                    <h2 id="permdel"></h2>
                    <button onclick="submitDeletedish()">Verwijder dit product</button>
                </div>
            </div>
        </div>
        <div class="statuscontainer">
            <div class="status popup">
                <header class="calenderheader">
                    <i class="fas fa-times close-status"></i>
                </header>
                <form class="gender-form" onsubmit="return submitDishstatus(event);">
                    <h2>Verander de status van het gerecht</h2>
                    <div class="status-checkbox">
                        <input type="radio" name="status" id="status_active" value="0"> Actief
                    </div>
                    <div class="status-checkbox">
                        <input type="radio" name="status" id="status_non_active" value="1"> Non-actief
                    </div>
                    <button type="submit">Verander status</button>
                </form>
            </div>
        </div>
        <div class="discountcontainer">
            <div class="discount popup">
                <header class="calenderheader">
                    <i class="fas fa-times close-discount"></i>
                </header>
                <form class="gender-form" onsubmit="return submitAddDiscount(event);">
                    <h2>Welk percentage wilt u toepassen?</h2>
                    <select name="discountmenu" id="discountmenu">
                        <option value="">Selecteer een korting</option>
                        <option value="0">Geen korting</option>
                        <option value="5">5% korting</option>
                        <option value="10">10% korting</option>
                        <option value="15">15% korting</option>
                        <option value="20">20% korting</option>
                        <option value="25">25% korting</option>
                        <option value="30">30% korting</option>
                        <option value="35">35% korting</option>
                        <option value="40">40% korting</option>
                        <option value="45">45% korting</option>
                        <option value="50">50% korting</option>
                        <option value="55">55% korting</option>
                        <option value="60">60% korting</option>
                        <option value="65">65% korting</option>
                        <option value="70">70% korting</option>
                        <option value="75">75% korting</option>
                        <option value="80">80% korting</option>
                        <option value="85">85% korting</option>
                        <option value="90">90% korting</option>
                        <option value="95">95% korting</option>
                        <option value="100">Gratis (100%)</option>
                    </select>
                    <button type="submit">Verander status</button>
                </form>
            </div>
        </div>
        <div class="productimagecontainer">
            <div class="productimage popup">
                <header class="calenderheader">
                    <i class="fas fa-times close-productimage"></i>
                </header>
                <form class="gender-form" onsubmit="return submitChangeProductImage(event);">
                    <h2>Verander de afbeelding van het product</h2>
                    <input class="order-input" style="padding-top: 0.7rem;" type="file" name="product_image_change" id="product_image_change">
                    <input type="text" name="restaurantid" id="restaurantid" value="<?php echo $restaurant_id; ?>" hidden>
                    <button type="submit">Verander Afbeelding</button>
                </form>
            </div>
        </div>
        <div class="moreinfo">
            <header class="moreinfo-header">
                <h1>Product Gegevens</h1>
                <i class="fas fa-times close-moreinfo"></i>
            </header>
            <div class="moreinfo-content">
                <aside class="moreinfo-aside">
                    <figure class="moreinfo-figure">
                        <!-- Product img + bewerken -->
                        <img id="show_dish_img" src="" alt="Product img">
                        <div class="moreinfo-figureicon" onclick="openPopup('productimagecontainer', 'close-productimage');">
                            <i class="fas fa-camera"></i>
                        </div>
                    </figure>
                </aside>
                <ul class="moreinfo-list">
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="show_dish_name" id="show_dish_name" value="" required>
                            <p class="label">Naam gerecht</p>
                            <i onclick="submitChangeDishname();" class="fas fa-save profile-icon"></i>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="show_dish_id" id="show_dish_id" value="" required disabled>
                            <p class="label">Dish ID</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="show_dish_category" id="dish_category2" value="" required>
                            <p class="label">Categorie</p>
                            <i onclick="submitChangeCategorie();" class="fas fa-save profile-icon"></i>
                            <ul id="productcategorielist2" class="hidden"></ul>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="show_restaurant_name" id="show_restaurant_name" value="<?php echo $info['restaurant_name']; ?>" required disabled>
                            <p class="label">Restaurant naam</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="show_created_by" id="show_created_by" value="" required disabled>
                            <p class="label">Aangemaakt door</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="show_discount" id="show_discount" value="" required disabled>
                            <p class="label">Afgeprijsd</p>
                            <i onclick="openPopup('discountcontainer', 'close-discount')" class="fas fa-pen profile-icon"></i>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="show_when_created" id="show_when_created" value="" required disabled>
                            <p class="label">Aangemaakt op</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" style="color: green !important;" type="text" value="" name="show_status" id="show_status" required disabled>
                            <p class="label">Status</p>
                            <i onclick="openPopup('statuscontainer', 'close-status');" class="fas fa-pen profile-icon"></i>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="show_dish_desc" id="show_dish_desc" value="" required>
                            <p class="label">Beschrijving</p>
                            <i onclick="submitChangeDesc();" class="fas fa-save profile-icon"></i>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="show_dish_toppings" id="show_dish_toppings" value="" required disabled>
                            <p class="label">Toppings</p>
                        </label>
                    </li>
                </ul>
            </div>
            <footer class="moreinfo-footer">
                <ul class="moreinfo-footerlist">
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="show_dish_price" id="show_dish_price" value="" placeholder="like this: 12.34" required>
                            <p class="label">Prijs incl.</p>
                            <i onclick="submitChangeDishname();" class="fas fa-save profile-icon"></i>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="show_dish_pricevat" id="show_dish_pricevat" value="" required disabled>
                            <p class="label">Prijs excl.</p>
                        </label>
                        <div class="order-phone">
                            <div class="login-makeaccount" style="padding-top: 0 !important;">
                                <button onclick="openDeleteDish();">Verwijder product</button>
                            </div>
                        </div>
                    </li>
                </ul>
            </footer>
        </div>
    </div>

    <!-- Website: -->
    <main class="profile">
        <aside class="profile-navigation">
            <div class="profile-container">
                <header class="profile-header">
                    <h1>Welkom <p style="text-transform: capitalize;"><?php echo $fname; ?></p>
                    </h1>
                </header>
                <ul class="profile-list">
                    <li class="profile-listitem">
                        <div class="profile-listitem-container">
                            <i class="fas fa-user"></i>
                            <a href="<?= site_url('profile'); ?>">Mijn Profiel</a>
                        </div>
                    </li>
                    <li class="profile-listitem">
                        <div class="profile-listitem-container">
                            <i class="fas fa-bag-shopping"></i>
                            <a href="<?= site_url('profile/orders'); ?>">Mijn Bestellingen</a>
                        </div>
                    </li>
                    <li class="profile-listitem">
                        <div class="profile-listitem-container">
                            <i class="fas fa-bell"></i>
                            <a href="<?= site_url('profile/notifications'); ?>">Mijn Meldingen</a>
                        </div>
                    </li>
                    <li class="profile-listitem">
                        <div class="profile-listitem-container">
                            <i class="fas fa-location-dot"></i>
                            <a href="<?= site_url('profile/addresses'); ?>">Mijn Adressen</a>
                        </div>
                    </li>
                    <li class="profile-listitem">
                        <div class="profile-listitem-container">
                            <i class="fas fa-tags"></i>
                            <a href="<?= site_url('profile/stamps'); ?>">Stempelkaart</a>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- Alleen een restauranteigenaar kan dit zien: -->
            <?php
            if ($rank == "res_owner" && !is_null($restaurant_id)) {
            ?>
                <div class="profile-container admin">
                    <header class="profile-header">
                        <h1>Mijn Restaurant</h1>
                    </header>
                    <ul class="profile-list">
                        <li class="profile-listitem">
                            <div class="profile-listitem-container">
                                <i class="fas fa-chart-line"></i>
                                <a href="<?= site_url('dashboard/orderoverview/' . $restaurant_id) ?>">Order overzicht</a>
                            </div>
                        </li>
                        <li class="profile-listitem">
                            <div class="profile-listitem-container active">
                                <i class="fas fa-list-ul"></i>
                                <a href="<?= site_url('dashboard/productoverview/' . $restaurant_id) ?>">Producten</a>
                            </div>
                        </li>
                        <li class="profile-listitem">
                            <div class="profile-listitem-container">
                                <i class="fas fa-gear"></i>
                                <a href="<?= site_url('dashboard/restaurantsettings/' . $restaurant_id) ?>">Instellingen</a>
                            </div>
                        </li>
                    </ul>
                </div>
            <?php
            } else {
                echo "";
            }
            ?>
            <!-- Alleen een admin kan dit zien: -->
            <?php
            if ($rank == "admin") {
            ?>
                <div class="profile-container admin">
                    <header class="profile-header">
                        <h1>Mijn Dashboard</h1>
                    </header>
                    <ul class="profile-list">
                        <li class="profile-listitem">
                            <div class="profile-listitem-container">
                                <i class="fas fa-chart-line"></i>
                                <a href="<?= site_url('dashboard/adminorders') ?>">Alle orders</a>
                            </div>
                        </li>
                        <li class="profile-listitem">
                            <div class="profile-listitem-container">
                                <i class="fas fa-list-ul"></i>
                                <a href="<?= site_url('dashboard/adminrestaurants') ?>">Restaurants</a>
                            </div>
                        </li>
                    </ul>
                </div>
            <?php
            } else {
                echo "";
            }
            ?>
        </aside>
        <div class="addproductcontainer">
            <div class="addproduct popup">
                <header class="calenderheader">
                    <i class="fas fa-times close-addproduct"></i>
                </header>
                <form onsubmit="return submitAddProduct(event);" class="gender-form">
                    <h2>Maak een nieuw product aan</h2>

                    <label for="" class="order-phone seper">
                        <input class="order-input" type="text" name="dish_name" id="dish_name" placeholder="Max 55 karakters" required>
                        <p class="label">Productnaam</p>
                    </label>
                    <label for="" class="order-phone seper">
                        <input class="order-input" type="text" name="dish_price" id="dish_price" placeholder="Zoals dit: 12.34" required>
                        <p class="label">Prijs</p>
                    </label>
                    <label for="" class="order-phone seper">
                        <input class="order-input" type="text" name="dish_desc" id="dish_desc" placeholder="Max 255 karakters" required>
                        <p class="label">Beschrijving</p>
                    </label>
                    <label for="dish_img" class="order-phone seper">
                        <input class="order-input" type="file" name="dish_img" id="dish_img" accept="image/*" style="padding: 1rem;" required>
                        <p class="label">Product afbeelding</p>
                    </label>
                    <label for="" class="order-address">
                        <input class="order-input" type="text" id="dish_category" name="dish_category" placeholder="Zoek naar een categorie (max 1 per product)" required>
                        <p class="label">Categorie</p>
                        <ul id="productcategorielist" class="hidden"></ul>
                    </label>
                    <!-- add toppings later, now i dont know how to do this -->
                    <input type="text" name="fullname" id="fullname" value="<?php echo $fullname; ?>" hidden>
                    <input type="text" name="resid" id="resid" value="<?php echo $restaurant_id; ?>" hidden>
                    <button type="submit">Opslaan</button>
                </form>
            </div>
        </div>

        <section class="profile-content">
            <span class="adminnotvisiblemsg">Pagina's niet beschikbaar voor telefoon! <small>Open de website op een tablet of pc of ga verder door de navigatie te klikken</small></span>
            <div class="profile-info admindisplaynoneby1000px">
                <header class="profile-headercontainer">
                    <div class="profile-headerheading">
                        <h1>Producten overzicht</h1>
                        <p>Alle producten op een rij</p>
                    </div>
                    <ul class="order-filters">
                        <li class="searchbar">
                            <input type="text" name="search" id="search" placeholder="Zoeken naar producten" />
                            <i class="fas fa-search inputicon"></i>
                        </li>
                        <li class="refreshcontainer">
                            <button onclick="refresh();" class="refresh"><i class="fas fa-refresh"></i></button>
                        </li>
                        <li class="refreshcontainer">
                            <button onclick="openPopup('addproductcontainer', 'close-addproduct');" class="refresh"><i class="fas fa-plus"></i></button>
                        </li>
                        <li class="order-filtercontainer">
                            <select class="order-filter" name="status-filter" id="status-filter">
                                <option class="order-filteritem" value="all">Alle</option>
                                <option class="order-filteritem" value="active">Actief</option>
                                <option class="order-filteritem" value="notactive">Non-actief</option>
                            </select>
                        </li>
                    </ul>
                </header>
                <ul class="product-info-headers">
                    <li class="product-info-header">
                        <b>Product ID</b>
                    </li>
                    <li class="product-info-header">
                        <b>Categorie</b>
                    </li>
                    <li class="product-info-header">
                        <b>Naam</b>
                    </li>
                    <li class="product-info-header">
                        <b>Prijs</b>
                    </li>
                    <li class="product-info-header">
                        <b>Orders</b>
                    </li>
                    <li class="product-info-header">
                        <b>Afgeprijsd</b>
                    </li>
                    <li class="product-info-header">
                        <b>Datum</b>
                    </li>
                    <li class="product-info-header">
                        <b>Status</b>
                    </li>
                </ul>
                <ul class="profile-info-list" id="dishes-list">
                    <?php if (!empty($products)): ?>
                        <?php
                        foreach ($products as $product) {
                            $order_amount = is_null($product['order_amount']) ? "0" : $product['order_amount'];
                            $active_discount = !empty($product['active_discount']) ? $product['active_discount'] . "%" : "Nee";
                            $product_img_src = !empty($product['dish_img_src']) ? $product['dish_img_src'] : './img/logo-res.jpg';
                            echo "<li class='product-info-listitem'>";
                            echo "<p>#{$product['dish_id']}</p>";
                            echo "<p>{$product['category_name']}</p>";
                            echo "<p>{$product['dish_name']}</p>";
                            echo "<p>{$product['discounted_price']}</p>";
                            echo "<p>{$order_amount}</p>";
                            echo "<p>{$active_discount}</p>";
                            $created_at = explode(' ', $product['created_at']);
                            echo "<p>{$created_at[0]}<small>om {$created_at[1]}</small></p>";
                            echo "<p id='show_new_status'>" . ($product['offline'] == 0 ? 'Actief' : 'Non-actief') . "</p>";
                            echo "<a href='' class='change-dish-del' 
                                data-id='{$product['dish_id']}' 
                                data-name='{$product['dish_name']}' 
                                data-price='{$product['discounted_price']}' 
                                data-category='{$product['category_name']}' 
                                data-created='{$product['created_at']}'
                                data-discount='{$active_discount}'
                                data-created-by='{$product['created_by']}' 
                                data-status='" . ($product['offline'] == 0 ? 'Actief' : 'Non-actief') . "' 
                                data-description='{$product['dish_desc']}' 
                                data-pimage='{$product_img_src}'
                                data-delstatus='{$product['offline']}'
                                >Veranderen</a>";
                            echo "</li>";
                        }
                        ?>
                    <?php else: ?>
                        <p>Geen producten gevonden.</p>
                    <?php endif; ?>
                </ul>
            </div>
        </section>
    </main>

    <main class="phone-profile">
        <header class="phone-profile-header">
            <i onclick="window.location.href = '<?= site_url('/') ?>'" class="fas fa-chevron-left"></i>
            <h1>Mijn Profiel</h1>
            <i class="fas fa-gear"></i>
        </header>
        <section class="phone-profile-info">
            <ul class="phone-profile-info-list">
                <li class="phone-profile-info-listitem">
                    <figure class="phone-profile-info-figure">
                        <?php
                        if (!empty($profileimg)) {
                            echo '<img src="' . $profileimg . '" alt="">';
                        } else {
                            echo '<i class="fas fa-user profile-edit-icon"></i>';
                        }
                        ?>
                        <div class="phone-profile-info-figureicon" onclick="openPopup('profileimgcontainer', 'close-profileimg');">
                            <i class="fa-solid fa-camera"></i>
                        </div>
                    </figure>
                </li>
                <li class="phone-profile-info-listitem">
                    <b><?php echo $fullname; ?></b>
                    <p><?php echo $email; ?></p>
                    <button onclick="window.location.href = '<?= site_url('profile/editprofile') ?>'">Bewerk profiel</button>
                </li>
            </ul>
        </section>
        <ul class="phone-profile-navigation">
            <li class="phone-profile-navigation-item">
                <div class="phone-profile-itemcontent">
                    <i class="fas fa-bag-shopping"></i>
                    <a href="<?= site_url('profile/orders'); ?>">Mijn Bestellingen</a>
                </div>
                <i class="fas fa-arrow-right"></i>
            </li>
            <li class="phone-profile-navigation-item">
                <div class="phone-profile-itemcontent">
                    <i class="fas fa-bell"></i>
                    <a href="<?= site_url('profile/notifications'); ?>">Mijn Meldingen</a>
                </div>
                <i class="fas fa-arrow-right"></i>
            </li>
            <li class="phone-profile-navigation-item">
                <div class="phone-profile-itemcontent">
                    <i class="fas fa-location-pin"></i>
                    <a href="<?= site_url('profile/addresses'); ?>">Mijn Adressen</a>
                </div>
                <i class="fas fa-arrow-right"></i>
            </li>
            <li class="phone-profile-navigation-item">
                <div class="phone-profile-itemcontent">
                    <i class="fas fa-tags"></i>
                    <a href="<?= site_url('profile/stamps'); ?>">Stempelkaart</a>
                </div>
                <i class="fas fa-arrow-right"></i>
            </li>
        </ul>
        <br>
        <div class="navbar-logoutcontainer">
            <a href="<?= site_url('account/logout') ?>" class="navbar-logoutbutton">Uitloggen</a>
        </div>
    </main>
</body>

</html>