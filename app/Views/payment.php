<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://kit.fontawesome.com/5a883bd754.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/restaurant.css">
    <link rel="stylesheet" href="./css/cart.css">
    <link rel="stylesheet" href="./css/order.css">
    <link rel="stylesheet" href="./css/payment.css">
    <link rel="stylesheet" href="./css/password-change.css">
    <script src="./js/functions.js" defer></script>
    <script src="./js/main.js" defer></script>
    <title>Flavorflow - De beste online bestel-app</title>
    <link rel="shortcut icon" href="./img/F-logo.png" type="image/x-icon">
</head>
<body>
    <main class="paymentcontainer">
        <header class="payment-header">
            <h1>Betaalmethode</h1>
            <p>Selecteer een betaalmethode om door te gaan</p>
        </header>
        <ul class="payment-list">
            <div class="payment-methods">
                <li class="paymentmethod" data-method="iDeal">
                    <div class="payment-iconcontainer">
                        <i class="fas fa-brands fa-ideal"></i>
                    </div>
                    <div class="payment-content">
                        <h1>IDEAL</h1>
                        <i class="fas fa-circle-check"></i>
                    </div>
                </li>
                <li class="paymentmethod" data-method="PayPal">
                    <div class="payment-iconcontainer">
                        <i class="fas fa-brands fa-paypal"></i>
                    </div>
                    <div class="payment-content">
                        <h1>PayPal</h1>
                        <i class="fas fa-circle-check"></i>
                    </div>
                </li>
            </div>
            <div class="payment-methods">
                <li class="paymentmethod" data-method="Creditcard">
                    <div class="payment-iconcontainer">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="payment-content">
                        <h1>Creditcard</h1>
                        <i class="fas fa-circle-check"></i>
                    </div>
                </li>
                <li class="paymentmethod" data-method="Contant">
                    <div class="payment-iconcontainer">
                        <i class="fas fa-money-bill"></i>
                    </div>
                    <div class="payment-content">
                        <h1>Contant</h1>
                        <i class="fas fa-circle-check"></i>
                    </div>
                </li>
            </div>
        </ul>
        <footer class="payment-buttoncontainer">
            <p>Betaal veilig via ons platform <i class="fas fa-circle-check"></i></p>
            <button class="payment-button">Afronden</button>
        </footer>
    </main>
    <script>
        function saveOrderToDatabase() {
            // Retrieve data from cookies or other sources
            const orderData = getCookie("orderData");
            const selectedPaymentMethod = getCookie("selectedPaymentMethod");
            const cartData = getCartFromCookies(); 

            // Check if necessary data exists
            if (!orderData || !selectedPaymentMethod || !cartData) {
                showCustomMessage("Orderdata ontbreekt.", false); 
                return;
            }

            // Prepare the order data for sending
            const orderPayload = {
                orderData: JSON.parse(orderData),
                selectedPaymentMethod: selectedPaymentMethod,
                cart: cartData
            };

            console.log(orderPayload); // debuglog payload

            // Make the POST request to process the order
            $.ajax({
                url: '<?= site_url('order/processorder') ?>',
                type: "POST",
                dataType: "json",
                data: orderPayload,
                success: function(response) {
                    if(response['status'] == 'success') {
                        showCustomMessage("Bestelling succesvol geplaatst!", true); 
                        console.log('helemaal piema')
                        document.cookie = `orderID=${response['orderid']}; path=/;`;
                        setTimeout(() => {
                            window.location.href = "<?= site_url('/ordersummary') ?>"; 
                        }, 2000);
                    } else {
                        showCustomMessage(response['message'], false);
                    }
                },
                error: function() {
                    showCustomMessage("Er is een probleem met het plaatsen van de bestelling.", false);
                }
            });
        }
    </script>
</body>
</html>