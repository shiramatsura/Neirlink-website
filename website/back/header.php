<nav>
    <div>
        <a href="/">
            <img src="data/img/logo_placeholder.jpg" alt="logo_website">
        </a>
        <a class="navbar-button-element" href="explore">Explore</a>
        <a class="navbar-button-element" href="explore">Explore</a>
    </div>   
    <div>
        <?php if (isset($_SESSION['LOGGED_USER'])): ?>
            <button id="navbar-notif-button" class="navbar-button-element" type="button">    
                <img src="data/img/notif_icon.png" alt="notif-icon" id="notif-bell-header-icon">
            </button>
            <button id="navbar-logged-user-tab" class="navbar-button-element" type="button">
                <?php //If profile image available, display it. Else, display profile image placeholder ?>
                <img src="data/users/<?php echo $_SESSION['LOGGED_USER']['account_name']?>/profile-img.webp"
                    onerror="this.onerror=null; this.src='data/img/profile_img_placeholder.webp';">

                <p><?php echo $_SESSION["LOGGED_USER"]["username"]; ?></p>
            </button>
        <?php else: ?>
            <button id="navbar-sign-in-button" class="navbar-button-element" type="button">Log in</button>
            <button id="navbar-sign-up-button" class="navbar-button-element" type="button">Register</button>
            <button id="navbar-anon-user-tab" class="navbar-button-element" type="button">
                <img src="data/img/profile_img_placeholder.webp" alt="placeholder">
            </button>
        <?php endif; ?>
    <div>
</nav>


<?php //user_sign_menu available if user not logged
if (!isset($_SESSION['LOGGED_USER'])) {
    require_once(__DIR__ . '/user_sign_in_menu.php');
    require_once(__DIR__ . '/user_sign_up_menu.php');
}