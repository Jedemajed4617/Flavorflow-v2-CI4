<script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
<div id="message-container" class="message-container"></div>

<script>
    function submitChangeProfileImage(event) {
        event.preventDefault();

        let fileInput = $("#profile_img")[0];
        let $loadingOverlay = $('#loading-overlay');

        // --- Add Console Log ---
        console.log("submitChangeProfileImage called. Loader selected:", $loadingOverlay.length > 0);

        if (fileInput.files.length === 0) {
            showCustomMessage("Geen afbeelding geselecteerd.", false);
            return;
        }

        if (fileInput.files.length > 1) {
            showCustomMessage("U kunt slechts één foto uploaden.", false);
            return;
        }

        let formData = new FormData();
        formData.append('profileimg', fileInput.files[0]);


        $.ajax({
            url: "<?= site_url('account/changeprofileimage') ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",

            beforeSend: function() {
                // --- Add Console Log ---
                console.log("AJAX beforeSend: Attempting to show loader.");
                $loadingOverlay.css('display', 'flex').fadeTo(200, 1);
            },

            success: function(response) {
                // --- Add Console Log ---
                console.log("AJAX Success:", response);
                if (response.status == 'success') {
                    showCustomMessage("Profiel afbeelding veranderd.", true);
                    closePopup('profileimgcontainer', 'close-profileimg');
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showCustomMessage(response.message || "Er is een fout opgetreden", false);
                }
            },

            error: function(xhr, status, error) {
                // --- Add Console Log ---
                console.error("AJAX Error:", status, error);
                showCustomMessage("Er is een fout opgetreden, probeer later opnieuw", false);
            },

            complete: function(jqXHR, textStatus) {
                // --- Add Console Log ---
                console.log("AJAX Complete. Status:", textStatus);
                $loadingOverlay.fadeTo(200, 0, function() {
                    console.log("AJAX Complete (fadeTo callback): Hiding loader."); // Log inside callback too
                    $(this).css('display', 'none');
                });
            }
        });
    }
</script>

<?php
$session = session();
$profileimg = $session->get('profile_img_src') ? base_url($session->get('profile_img_src')) : base_url('img/default.png');
?>

<style>
#loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    display: flex; /* Keep this for centering */
    justify-content: center;
    align-items: center;
    z-index: 1000000000000; /* Reduced z-index slightly, still very high */
    cursor: wait;
    opacity: 0; /* Start fully transparent */
    display: none; /* Start hidden - JS will handle showing */
}

#loading-overlay .fa-spinner {
    color: #fff;
    font-size: 4rem;
}
</style>

<div id="loading-overlay">
    <i class="fas fa-spinner fa-spin"></i>
</div>

<div class="profileimgcontainer">
    <div class="profileimg popup">
        <header class="calenderheader">
            <i class="fas fa-times close-profileimg"></i>
        </header>
        <form onsubmit="return submitChangeProfileImage(event);" class="gender-form">
            <?php if (!empty($profileimg)): ?>
                <img src="<?php echo $profileimg; ?>" alt="Profielfoto" style="max-width: 100%; height: auto; margin-bottom: 10px;">
            <?php else: ?>
                <img src="<?= base_url('img/default.png') ?>" alt="Profielfoto placeholder" style="max-width: 100%; height: auto; margin-bottom: 10px;">
            <?php endif; ?>
            <label for="" class="order-phone seper">
                <input class="order-input" style="padding-top: 1rem;" type="file" name="profile_img" id="profile_img" accept="image/*" required>
                <p class="label">Verander profielfoto</p>
            </label>
            <button type="submit">Update</button>
        </form>
    </div>
</div>

<header class="header">
    <div class="navbar-container">
        <nav class="navbar">
            <div onclick="window.location.href = '<?= site_url('/') ?>'" class="logo">
                <i class="fas fa-chevron-left"></i>
                <h1>Flavorflow.</h1>
            </div>
            <div class="navbar-logoutcontainer">
                <a href="<?= site_url('account/logout') ?>" class="navbar-logoutbutton">Uitloggen</a>
            </div>
        </nav>
        <div class="profile-imgcontainer">
            <?php if (empty($_SESSION['profile_img_src'])): ?>
                <div class="profile-img profile-edit-icon">
                    <i class="fas fa-user "></i>
                    <i onclick="openPopup('profileimgcontainer', 'close-profileimg');" class="fas fa-camera edit-profile-button"></i>
                </div>
            <?php else: ?>
                <figure class="profile-img">
                    <img src="<?php echo $profileimg; ?>" alt="Profile image">
                    <i onclick="openPopup('profileimgcontainer', 'close-profileimg');" class="fas fa-camera edit-profile-button"></i>
                </figure>
            <?php endif; ?>
        </div>
    </div>
    <div class="navbar-underlinecontainer">
        <figure class="navbar-underline" style="width: 100%;"></figure>
    </div>
</header>