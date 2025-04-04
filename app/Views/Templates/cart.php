<div class="cartcontainer">
    <div class="cart popup">
        <header class="cart-title">
            <h1 style="user-select: none;">Flavorflow.</h1>
            <p style="color: lightgrey; font-size: 1.5rem;">Winkelwagen</p>
        </header>
        <div class="cart-closecontainer">
            <i class="fas fa-xmark close-cart"></i>
        </div>
        <div class="cart-content">
            <ul class="cart-list"></ul>
            <footer class="cart-footercontainer">
                <div class="cart-footer">
                    <div class="cart-footercontainer">
                        <p>Subtotaal</p>
                        <p id="subtotal">€ 0.00</p>
                    </div>
                    <div class="cart-footercontainer">
                        <p>Bezorgkosten</p>
                        <p id="deliverycost">€ 0.00</p>
                    </div>
                    <figure></figure>
                    <div class="cart-footercontainer">
                        <p>Totaal</p>
                        <p id="total">€ 0.00</p>
                    </div>
                    <br>
                    <div class="cart-footerbutton">
                        <a href="javascript:void(0)" id="checkout-button"
                            class="checkout disabled"
                            title="Uw winkelwagen is leeg."
                            data-order-url="<?= site_url('order') ?>"> Afrekenen <p>(€ 0.00)</p>
                        </a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>