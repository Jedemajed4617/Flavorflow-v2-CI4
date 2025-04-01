<script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script>
<div id="message-container" class="message-container"></div>

<div class="profileimgcontainer">
    <div class="profileimg popup">
        <header class="calenderheader">
            <i class="fas fa-times close-profileimg"></i>
        </header>
        <form onsubmit="return changeOrAddProfileImg(event);" class="gender-form">
            <?php if (!empty($_SESSION['profile_img_src'])): ?>
                <img src="<?php echo $profileimg; ?>" alt="Profielfoto" style="max-width: 100%; height: auto; margin-bottom: 10px;">
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
            <div onclick="window.location.href = '<?= site_url('/') ?>'"  class="logo">
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
                    <img src="<?php echo $profileimg;; ?>" alt="Profile image">
                    <i onclick="openPopup('profileimgcontainer', 'close-profileimg');" class="fas fa-camera edit-profile-button"></i>
                </figure>
            <?php endif; ?>
        </div>
    </div>
    <div class="navbar-underlinecontainer">
        <figure class="navbar-underline" style="width: 100%;"></figure>
    </div>
</header>