<?php if (!isset($_SESSION['LOGGED_USER'])): ?>
<div id="user-sign-in-menu">
    <div id="user-sign-in-popup">
        <h1 class="user-sign-title-element">Login</h1>
        <form id="user-sign-in-form">
            <div id="user-sign-in-form-identifier" class="user-sign-form-element">
                <div class="user-sign-field-element popup-field-element">
                    <input type="text" id="user-sign-in-identifier" name="identifier" required placeholder=" ">
                    <label for="identifier">Identifier or Email</label>
                </div>
            </div>
            <div id="user-sign-in-form-password" class="user-sign-form-element">
                <div class="user-sign-field-element popup-field-element">
                    <input type="password" id="user-sign-in-password" name="password" required placeholder=" ">
                    <label for="password">Password</label>
                </div>
            </div>
            <button id="user-sign-in-forgot-password-button" type="button">Forgot password ?</button><br>
            <p id="user-sign-in-alert" class="popup-alert-element"></p>
            <button id="user-sign-in-log-in-button" type="submit">LOGIN</button>
        </form>
        <div id="user-sign-in-no-account-button">
            No account ? <button type="button">Create one</button>
        </div>
    </div>
</div>
<?php endif; ?>