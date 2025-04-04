// error msg custom
function showCustomMessage(message, isSuccess = true) {
    const messageContainer = document.getElementById("message-container");

    // Set the message text and background color based on success or failure
    messageContainer.textContent = message;
    messageContainer.style.backgroundColor = isSuccess ? "#1ca210c2" : "rgba(162, 28, 16, 0.8)"; // Green for success, Red for error

    // Add the class to show the message
    messageContainer.classList.add("show-message");

    // Remove the show-message class after 2 seconds to start fading out
    setTimeout(() => {
        messageContainer.classList.add("fade-out");
    }, 1500);

    // Remove the message from the DOM after the fade-out animation is done (3 seconds total)
    setTimeout(() => {
        messageContainer.classList.remove("show-message", "fade-out");
    }, 1500);
}

// Animdation cards inladen
document.querySelectorAll('.adres-listitem').forEach((item, index) => {
    item.style.setProperty('--index', index + 1);
});

// refresh page
function refresh(){
    location.reload();
}

// Search dropdown orderpage with google api
document.addEventListener("DOMContentLoaded", function () {
    const searchBar = document.getElementById("searchBargoogle");
    const dataList = document.getElementById("customDatalist");

    // --- Function to attempt parsing and filling the address form ---
    function tryFillAddressForm(description) {
        // Get references to the specific form fields, ONLY if they exist on the current page
        const provinceSelect = document.getElementById('province');
        const cityInput = document.getElementById('city');
        const streetnameInput = document.getElementById('streetname');
        const housenumberInput = document.getElementById('housenumber');
        const housenumberadditionInput = document.getElementById('housenumberaddition');
        const postalcodeInput = document.getElementById('postalcode');

        // --- Reset fields first (optional, prevents partial data if parsing fails) ---
        // We only reset if they exist
        // if (provinceSelect) provinceSelect.value = ""; // Don't reset dropdown usually
        if (cityInput) cityInput.value = "";
        if (streetnameInput) streetnameInput.value = "";
        if (housenumberInput) housenumberInput.value = "";
        if (housenumberadditionInput) housenumberadditionInput.value = "";
        if (postalcodeInput) postalcodeInput.value = "";

        // --- Attempt to extract Postal Code (NNNN AA format) ---
        let postalCode = null;
        if (postalcodeInput) {
            const postalCodeMatch = description.match(/(\d{4}\s?[A-Z]{2})/);
            if (postalCodeMatch) {
                postalCode = postalCodeMatch[1].replace(/\s/, ''); // Remove space for consistency
                postalcodeInput.value = postalCode;
            }
        }

        // --- !! Very Basic Attempt to Extract Other Parts - HIGHLY UNRELIABLE !! ---
        // This part is prone to errors due to varying address formats. Use with caution.

        // Try finding number (and maybe addition) often before a comma or postal code
        let houseNumber = null;
        let houseNumberAddition = null;
        if (housenumberInput) {
             // Regex looks for digits (\d+) possibly followed by space/letter ([A-Za-z]?)
             // before a comma or the postal code (if found)
            const numberRegex = new RegExp(`(\\d+)\\s?([A-Za-z])?(?=,\\s|\\s+${postalCode ? postalCode.substring(0,4) : ''})`);
            const numberMatch = description.match(numberRegex);
            if (numberMatch) {
                houseNumber = numberMatch[1];
                housenumberInput.value = houseNumber;
                if (housenumberadditionInput && numberMatch[2]) {
                    houseNumberAddition = numberMatch[2];
                    housenumberadditionInput.value = houseNumberAddition;
                }
            }
        }

        // Try getting street - often text before house number
        if (streetnameInput && houseNumber) {
            // Take text before the found house number, trim whitespace/commas
            const streetRegex = new RegExp(`^(.*?)(?=\\s+${houseNumber})`);
            const streetMatch = description.match(streetRegex);
             if (streetMatch && streetMatch[1]) {
                 streetnameInput.value = streetMatch[1].replace(/,$/, '').trim();
             }
        }

         // Try getting city - often text after postal code (if found) or before ", Netherlands"
        if (cityInput) {
            let cityMatch = null;
            if (postalCode) {
                 // Look for text between postal code and ", Netherlands" or end of string
                 const cityRegex = new RegExp(`${postalCode}\\s+([^,]+)`);
                 cityMatch = description.match(cityRegex);
            } else {
                 // Look for text before ", Netherlands" if no postal code found
                 cityMatch = description.match(/([^,]+),\s+Netherlands$/);
            }
             if (cityMatch && cityMatch[1]) {
                cityInput.value = cityMatch[1].trim();
             }
        }

        // Province is almost impossible to parse reliably from description string.
        // Leave the dropdown for the user to select.
    }


    // --- Main Event Listener Logic ---
    if (searchBar && dataList) {
        searchBar.addEventListener("input", function () {
            let query = searchBar.value;

            // Clear specific address fields whenever the user types in the main search bar
            // Check if the fields exist before trying to clear
             const fieldsToClear = ['province', 'city', 'streetname', 'housenumber', 'housenumberaddition', 'postalcode'];
             fieldsToClear.forEach(id => {
                 const field = document.getElementById(id);
                 // Don't clear province dropdown selection, just text inputs
                 if (field && field.type === 'text') {
                     field.value = '';
                 }
             });


            if (query.length > 2) {
                // Use your existing API endpoint
                fetch(`/api/get-address-suggestions?query=${encodeURIComponent(query)}`)
                    .then(response => {
                        // Basic error check for the fetch itself
                        if (!response.ok) {
                             throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                     })
                    .then(data => {
                        dataList.innerHTML = ""; // Clear previous suggestions

                        if (data.predictions && data.predictions.length > 0) {
                            data.predictions.forEach(prediction => {
                                const li = document.createElement("li");
                                li.textContent = prediction.description;
                                // No need to store place_id if not using Place Details API
                                // li.dataset.placeId = prediction.place_id;

                                li.addEventListener("click", function () {
                                    const selectedDescription = this.textContent;
                                    searchBar.value = selectedDescription; // Set main search bar value
                                    dataList.classList.add("hidden"); // Hide list

                                    // --- Call the function to try filling the form ---
                                    tryFillAddressForm(selectedDescription);
                                });
                                dataList.appendChild(li);
                            });
                            dataList.classList.remove("hidden");
                        } else {
                            const noResults = document.createElement("li");
                            noResults.textContent = "Geen resultaten gevonden";
                            noResults.classList.add("no-results");
                            dataList.appendChild(noResults);
                            dataList.classList.remove("hidden");
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching address suggestions:", error);
                        // Display error in the datalist
                         dataList.innerHTML = '<li class="no-results">Fout bij ophalen adressen</li>';
                         dataList.classList.remove("hidden");
                    });
            } else {
                dataList.classList.add("hidden");
            }
        });

        document.addEventListener("click", (e) => {
            if (searchBar && dataList && !searchBar.contains(e.target) && !dataList.contains(e.target)) {
                dataList.classList.add("hidden");
            }
        });

        searchBar.addEventListener("keydown", function(event){
            if(event.key === "Enter"){
                 if (dataList && !dataList.classList.contains("hidden")) {
                      event.preventDefault(); // Stop potential form submission
                      dataList.classList.add("hidden");
                 }
            }
        });
    } else {
        // Only warn if the primary search bar/datalist are missing
        if (!searchBar) console.warn("Element not found: #searchBargoogle");
        if (!dataList) console.warn("Element not found: #customDatalist");
    }
});

// Select all function inputs
document.addEventListener("DOMContentLoaded", function () {
    const headerCheckbox = document.querySelector(".products-info-header > input");

    if (!headerCheckbox) return;

    headerCheckbox.addEventListener("change", function () {
        const allInputs = document.querySelectorAll(".products-info-listitem > input");

        allInputs.forEach((input) => {
            input.checked = this.checked;
        });
    });
});


// Declare buttons before using them
const bezorgenButton = document.getElementById("bezorgen");
const afhalenButton = document.getElementById("afhalen");

// Default selection
toggleSelection("bezorgen");

function toggleSelection(selected) {
    if (bezorgenButton && afhalenButton) {
        // Set the value of the hidden input based on selection
        const selectedInput = document.getElementById("selectedDelivery");

        if (selected === "bezorgen") {
            bezorgenButton.classList.add("enabled");
            bezorgenButton.classList.remove("disabled");
            afhalenButton.classList.add("disabled");
            afhalenButton.classList.remove("enabled");

            selectedInput.value = "bezorgen"; // Store selected option
        } else if (selected === "afhalen") {
            afhalenButton.classList.add("enabled");
            afhalenButton.classList.remove("disabled");
            bezorgenButton.classList.add("disabled");
            bezorgenButton.classList.remove("enabled");

            selectedInput.value = "afhalen"; // Store selected option
        }
    } else {
        console.warn("Buttons not found: 'bezorgen' or 'afhalen'");
    }
}

// Add event listeners (no need to declare variables again)
if (bezorgenButton) {
    bezorgenButton.addEventListener("click", () => toggleSelection("bezorgen"));
}

if (afhalenButton) {
    afhalenButton.addEventListener("click", () => toggleSelection("afhalen"));
}

// Dropdown filter function
function toggleDropdown() {
    const dropdownMenu = document.querySelector(".dropdown-menu");
    const filterButtonActive = document.querySelector(".filter-button-active");
    const filterButton = document.querySelector(".filter-button");
    const closeMenuAfterLinkClick = document.querySelector(".dropdown-links");

    dropdownMenu.classList.toggle("show");

    if (dropdownMenu.classList.contains("show")) {
        filterButtonActive.style.borderBottomRightRadius = "0";
        filterButton.style.borderBottomLeftRadius = "0";
    } else {
        filterButtonActive.style.borderBottomRightRadius = "";
        filterButton.style.borderBottomLeftRadius = "";
    }

    closeMenuAfterLinkClick.addEventListener("click", function () {
        filterButtonActive.style.borderBottomRightRadius = "";
        filterButton.style.borderBottomLeftRadius = "";
        dropdownMenu.classList.remove("show");
    });
}

// Input handling button
document.querySelectorAll(".restaurants-aside-list button").forEach((button) => {
    button.addEventListener("click", function (e) {
        if (e.target.tagName !== "INPUT") {
            const checkbox = this.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
        }
    });
});

// Toggle filters on phone
document.addEventListener("DOMContentLoaded", function () {
    const menuIcon = document.getElementById("open-filter");
    const menu = document.getElementById("restaurants-aside");
    const closeMenu = document.getElementById("close-filter");

    let isOpen = false;

    // Check if the elements exist before adding event listeners to prevent errors
    if (menuIcon) {
        menuIcon.addEventListener("click", function () {
            isOpen = !isOpen;
            if (menu) {
                menu.style.display = isOpen ? "block" : "none";
                menu.style.transform = isOpen ? "translateX(0)" : "translateX(-100%)";
            }
        });
    }

    if (closeMenu) {
        closeMenu.addEventListener("click", function () {
            isOpen = false;
            if (menu) {
                menu.style.display = "none";
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const slider = document.querySelector(".restaurant-sliderlist");
    const catSlider = document.querySelector(".category-list");

    let isDown = false;
    let startX;
    let scrollLeft;

    function handleMouseDown(e, element) {
        if (window.innerWidth <= 1000) return;
        isDown = true;
        element.classList.add("active");
        startX = e.pageX - element.offsetLeft;
        scrollLeft = element.scrollLeft;
    }

    function handleMouseLeave(element) {
        if (window.innerWidth <= 1000) return;
        isDown = false;
        element.classList.remove("active");
    }

    function handleMouseUp(element) {
        if (window.innerWidth <= 1000) return;
        isDown = false;
        element.classList.remove("active");
    }

    function handleMouseMove(e, element) {
        if (window.innerWidth <= 1000 || !isDown) return;
        e.preventDefault();
        const x = e.pageX - element.offsetLeft;
        const walk = (x - startX) * 2; // Adjust drag speed
        element.scrollLeft = scrollLeft - walk;
    }

    function handleTouchStart(e, element) {
        if (window.innerWidth <= 1000) return;
        startX = e.touches[0].clientX;
        scrollLeft = element.scrollLeft;
    }

    function handleTouchMove(e, element) {
        if (window.innerWidth <= 1000) return;
        const x = e.touches[0].clientX;
        const walk = (x - startX) * 2;
        element.scrollLeft = scrollLeft - walk;
    }

    function addEventListeners(element) {
        if (!element) return;
        element.addEventListener("mousedown", (e) => handleMouseDown(e, element));
        element.addEventListener("mouseleave", () => handleMouseLeave(element));
        element.addEventListener("mouseup", () => handleMouseUp(element));
        element.addEventListener("mousemove", (e) => handleMouseMove(e, element));
        element.addEventListener("touchstart", (e) => handleTouchStart(e, element), { passive: true });
        element.addEventListener("touchmove", (e) => handleTouchMove(e, element), { passive: true });
    }

    // Attach event listeners
    addEventListeners(slider);
    addEventListeners(catSlider);
});

// Go back function
function goBack() {
    if (window.history.length > 1) {
        window.location.href = "../index.php";
    } else {
        window.location.href = "../index.php";
    }
}


// Check if the element exists before proceeding
document.addEventListener("DOMContentLoaded", function () {
    const valuedInput = document.querySelector(".valued-input");
    if (valuedInput) {
        const defaultValue = valuedInput.value;

        // Listen for the keydown event to prevent deleting
        valuedInput.addEventListener("keydown", function (event) {
            // Check if the key pressed is one that would delete (Backspace, Delete, or any other ways to remove characters)
            if (event.key === "Backspace" || event.key === "Delete") {
                if (valuedInput.value === defaultValue) {
                    event.preventDefault(); // Prevent the keydown event if the input value is the default value
                }
            }
        });
    } else {
        console.warn("Element '.valued-input' not found.");
    }
});

// payment method selection coloring function
document.addEventListener("DOMContentLoaded", function () {
    const paymentMethods = document.querySelectorAll(".paymentmethod");
    const paymentButton = document.querySelector(".payment-button");

    function updatePaymentButtonState() {
        if (!paymentButton) return; // Ensure paymentButton exists

        const selectedMethod = document.querySelector(".paymentmethod.selected");
        if (selectedMethod) {
            paymentButton.classList.add("active");
            paymentButton.disabled = false;
            paymentButton.style.pointerEvents = "auto";
        } else {
            paymentButton.classList.remove("active");
            paymentButton.disabled = true;
            paymentButton.style.pointerEvents = "none";
        }
    }

    function savePaymentMethodToCookie(method) {
        // Save the selected payment method to a cookie
        try {
            document.cookie = `selectedPaymentMethod=${method}; path=/; max-age=31536000`; // 1 year expiry
            console.log("Payment method saved to cookie:", method);
        } catch (error) {
            console.error("Error saving payment method to cookie:", error);
        }
    }

    paymentMethods.forEach((method) => {
        method.addEventListener("click", function () {
            if (this.classList.contains("selected")) {
                this.classList.remove("selected");

                const paymentIcon = this.querySelector(".payment-content i");
                const paymentText = this.querySelector(".payment-content h1");
                const paymentContainerIcon = this.querySelector(".payment-iconcontainer i");

                if (paymentIcon) {
                    paymentIcon.classList.remove("selected");
                    paymentIcon.style.display = "none";
                }
                if (paymentText) paymentText.classList.remove("selected");
                if (paymentContainerIcon) paymentContainerIcon.classList.remove("selected");
            } else {
                paymentMethods.forEach((item) => {
                    item.classList.remove("selected");

                    const paymentIcon = item.querySelector(".payment-content i");
                    const paymentText = item.querySelector(".payment-content h1");
                    const paymentContainerIcon = item.querySelector(".payment-iconcontainer i");

                    if (paymentIcon) {
                        paymentIcon.classList.remove("selected");
                        paymentIcon.style.display = "none";
                    }
                    if (paymentText) paymentText.classList.remove("selected");
                    if (paymentContainerIcon) paymentContainerIcon.classList.remove("selected");
                });

                this.classList.add("selected");

                const paymentIcon = this.querySelector(".payment-content i");
                const paymentText = this.querySelector(".payment-content h1");
                const paymentContainerIcon = this.querySelector(".payment-iconcontainer i");

                if (paymentIcon) {
                    paymentIcon.classList.add("selected");
                    paymentIcon.style.display = "block";
                }
                if (paymentText) paymentText.classList.add("selected");
                if (paymentContainerIcon) paymentContainerIcon.classList.add("selected");
            }

            updatePaymentButtonState();
        });
    });

    if (paymentButton) {
        paymentButton.addEventListener("click", function () {
            const selectedMethod = document.querySelector(".paymentmethod.selected");
            if (selectedMethod) {
                try {
                    // Save the selected payment method to the cookie
                    const methodName = selectedMethod.dataset.method; // assuming you use data-method for payment method identifier
                    savePaymentMethodToCookie(methodName);
                    
                    // Save the order to the database
                    saveOrderToDatabase();
                } catch (error) {
                    console.error("Error processing payment:", error);
                }
            } else {
                console.error("No payment method selected");
            }
        });

        updatePaymentButtonState(); // Initialize button state only if it exists
    }
});


// new function for all popups
function openPopup(containerClass, closeButtonClass, extraCallback = null) {
    const container = document.querySelector(`.${containerClass}`);
    const popup = container?.querySelector(".popup"); // Assuming `.popup` is inside each container
    const closeButton = document.querySelector(`.${closeButtonClass}`);

    if (!container || !closeButton) return;

    container.style.display = "flex"; // Ensure container is visible

    setTimeout(() => {
        popup?.classList.add("open");
    }, 10);

    closeButton.addEventListener("click", function () {
        popup?.classList.remove("open");

        setTimeout(() => {
            container.style.display = "none";
        }, 300); // Matches CSS transition duration

    });

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            closePopup(containerClass, closeButtonClass);
        }
    });

    // If an extra function needs to run when opening the popup
    if (extraCallback) extraCallback();
}

// apart voor popup zodat je in andere functies alleen de close aan kan roepen
function closePopup(containerClass, closeButtonClass) {
    const container = document.querySelector(`.${containerClass}`);
    const popup = container?.querySelector(".popup");

    if (!container) return;

    popup?.classList.remove("open");

    setTimeout(() => {
        container.style.display = "none";
    }, 300); // Matches CSS transition duration

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            closePopup(containerClass, closeButtonClass);
        }
    });
}

function openDeleteAddress(addressId) {
    if (!addressId) {
        showCustomMessage("Geen adres geselecteerd.", false);
        return;
    }

    document.getElementById("addressid").value = addressId; // Set hidden input value

    openPopup("usernamecontainer", "close-username");
}

function changeOrAddProfileImg(event) {
    event.preventDefault(); 
    const formData = new FormData();
    const fileInput = document.querySelector("#profile_img"); 
    const calender = document.querySelector(".profileimgcontainer");

    if (!fileInput.files.length) {
        showCustomMessage("Selecteer een afbeelding.", false);
        return false;
    }

    formData.append("profileimg", fileInput.files[0]);

    fetch("./controllers/account_controller.php?type=changeoraddprofileimg", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json()) 
        .then((data) => {
            if (data.success) {
                showCustomMessage(data.message, true); 
                calender.classList.remove("open");
                setTimeout(() => location.reload(), 1000); 
            } else {
                showCustomMessage(data.message, false); 
                calender.classList.remove("open");
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            showCustomMessage("Er is iets misgegaan.", false);
            calender.classList.remove("open");
        });

    calender.classList.remove("open");
    return false; 
}

// Function to change the dishstuff
function changeDishName() {
    const dishname = document.querySelector('[name="show_dish_name"]').value;
    let dishId = document.getElementById("show_dish_id").value; 

    if (dishId.startsWith("#")) {
        dishId = dishId.substring(1);
    }

    if (dishId.trim() === "") {
        showCustomMessage("Product niet gevonden", false);
        return;
    }

    if (dishname.trim() !== "") {
        const formData = new FormData();
        formData.append("dish_name", dishname); 
        formData.append("dish_id", dishId); 

        fetch("./controllers/product_controller.php?type=changedishname", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    showCustomMessage(data.message, true);
                    document.querySelector('[name="show_dish_name"]').value = dishname;
                } else {
                    showCustomMessage(data.message, false);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                showCustomMessage("Er is een fout opgetreden.", false); 
            });
    } else {
        showCustomMessage("Vul alstublieft een productnaam in.", false);
    }
}

function changeDishDesc() {
    const dishdesc = document.querySelector('[name="show_dish_desc"]').value;
    let dishId = document.getElementById("show_dish_id").value; 

    if (dishId.startsWith("#")) {
        dishId = dishId.substring(1);
    }

    if (dishId.trim() === "") {
        showCustomMessage("Product niet gevonden", false);
        return;
    }

    if (dishdesc.trim() !== "") {
        const formData = new FormData();
        formData.append("dish_desc", dishdesc); 
        formData.append("dish_id", dishId); 

        fetch("./controllers/product_controller.php?type=changedishdesc", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    showCustomMessage(data.message, true);
                    document.querySelector('[name="show_dish_desc"]').value = dishdesc;
                } else {
                    showCustomMessage(data.message, false);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                showCustomMessage("Er is een fout opgetreden.", false); 
            });
    } else {
        showCustomMessage("Vul alstublieft een beschrijving in.", false);
    }
}

function changeProductCategory() {
    const dishCategory = document.querySelector('[name="show_dish_category"]').value;
    let dishId = document.getElementById("show_dish_id").value;

    if (dishId.startsWith("#")) {
        dishId = dishId.substring(1);
    }

    if (dishId.trim() === "") {
        showCustomMessage("Product niet gevonden", false);
        return;
    }

    if (dishCategory.trim() !== "") {
        const formData = new FormData();
        formData.append("dish_category", dishCategory);
        formData.append("dish_id", dishId);

        fetch("./controllers/product_controller.php?type=changeproductcategory", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    showCustomMessage(data.message, true);
                    document.querySelector('[name="show_dish_category"]').value = dishCategory;
                } else {
                    showCustomMessage(data.message, false);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                showCustomMessage("Er is een fout opgetreden.", false);
            });
    } else {
        showCustomMessage("Vul alstublieft een productcategorie in.", false);
    }
}

function changeDishPrice() {
    let dishprice = document.querySelector('[name="show_dish_price"]').value;
    let dishId = document.getElementById("show_dish_id").value; 

    if (dishId.startsWith("#")) {
        dishId = dishId.substring(1);
    }

    if (dishId.trim() === "") {
        showCustomMessage("Product niet gevonden", false);
        return;
    }

    if (dishprice.startsWith("€")) {
        dishprice = dishprice.substring(1).trim();
    }

    if (dishprice.trim() !== "") {
        const formData = new FormData();
        formData.append("dish_price", dishprice); 
        formData.append("dish_id", dishId); 

        fetch("./controllers/product_controller.php?type=changedishprice", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    showCustomMessage(data.message, true);
                    document.querySelector('[name="show_dish_price"]').value = dishprice;
                } else {
                    showCustomMessage(data.message, false);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                showCustomMessage("Er is een fout opgetreden.", false); 
            });
    } else {
        showCustomMessage("Vul alstublieft een prijs in.", false);
    }
}

function changeProductImage(event) {
    event.preventDefault();

    const formData = new FormData();
    const fileInput = document.querySelector('[name="product_image_change"]'); 
    const calender = document.querySelector(".productimagecontainer");
    let dishId = document.getElementById("show_dish_id").value; 

    if (dishId.startsWith("#")) {
        dishId = dishId.substring(1);
    }

    if (dishId.trim() === "") {
        showCustomMessage("Product niet gevonden", false);
        return false;
    }

    if (!fileInput.files.length) {
        showCustomMessage("Geen afbeelding gevonden.", false);
        return false;
    }

    formData.append("productimg", fileInput.files[0]);
    formData.append("dish_id", dishId); 

    fetch("./controllers/product_controller.php?type=changeproductimage", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json()) 
        .then((data) => {
            if (data.success) {
                calender.classList.remove("open");
                showCustomMessage(data.message, true); 
                document.getElementById("show_dish_img").src = URL.createObjectURL(fileInput.files[0]);
            } else {
                showCustomMessage(data.message, false);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            showCustomMessage("Er is iets misgegaan.", false);
        });

    calender.classList.remove("open");
    return false; 
}

function deleteAddress(event) {
    event.preventDefault();

    const addressId = document.getElementById("addressid").value;

    if (!addressId) {
        showCustomMessage("Geen adres gecelecteerd", false);
        return;
    }

    fetch("./controllers/account_controller.php?type=deleteaddress", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `address_id=${encodeURIComponent(addressId)}`,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showCustomMessage(data.message, true);

                setTimeout(() => location.reload(), 2000);
            } else {
                showCustomMessage(data.message, false);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            showCustomMessage("Er is een fout opgetreden.", false);
        });

    closePopup("usernamecontainer", "close-username"); 
}

// Filters functionality
document.addEventListener("DOMContentLoaded", function () {
    const filterSelect = document.getElementById("status-filter");
    const dishesList = document.getElementById("dishes-list");
    if (dishesList) {
        const noItemsMessage = document.createElement("p");
        noItemsMessage.textContent = "Geen items gevonden";
        noItemsMessage.style.display = "none";
        dishesList.appendChild(noItemsMessage);

        filterSelect.addEventListener("change", function () {
            const listItems = dishesList.querySelectorAll(".product-info-listitem");
            const selectedValue = filterSelect.value;
            let itemsFound = false;

            listItems.forEach((item) => {
                const statusText = item.querySelector("p:nth-child(8)").textContent.trim(); // Get status text (Actief/Non-actief)
                if (selectedValue === "all" || 
                    (selectedValue === "active" && statusText === "Actief") ||
                    (selectedValue === "notactive" && statusText === "Non-actief")) {
                    item.style.display = "grid"; // Show matching items
                    itemsFound = true;
                } else {
                    item.style.display = "none"; // Hide non-matching items
                }
            });

            noItemsMessage.style.display = itemsFound ? "none" : "block";
        });
    }
});


// Add to cart functionality:
document.addEventListener("DOMContentLoaded", function () {
    if (typeof renderCart === "function") {
        renderCart(); // Render cart if the function is available
    } else {
        console.warn("renderCart not available");
    }
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
        item.id == itemId ? { ...item, quantity: newQuantity } : item
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


// Cookie handling for ordering flow
// helper voor het ophalen van een cookienaam
function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}