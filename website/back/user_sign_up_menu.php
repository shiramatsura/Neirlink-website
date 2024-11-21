<?php if (!isset($_SESSION['LOGGED_USER'])): ?>
<div id="user-sign-up-menu">
    <div id="user-sign-up-popup">
        <h1 class="user-sign-title-element">Create account</h1>
        <form id="user-sign-up-form">
            <div id="user-sign-up-form-identifier" class="user-sign-form-element">
                <div class="user-sign-field-element popup-field-element">
                    <input type="text" id="user-sign-up-identifier" name="identifier" required placeholder=" ">
                    <label for="identifier">Identifier</label>
                </div>
                <p id="user-sign-up-identifier-info" class="popup-info-element">
                    Identifier is unique and helps finding you on Lelol. You will always be able to change it later.
                </p>
            </div>
            <div id="user-sign-up-form-email" class="user-sign-form-element">
                <div class="user-sign-field-element popup-field-element">
                    <input type="email" id="user-sign-up-email" name="email" required placeholder=" ">
                    <label for="email">Email</label>
                </div>
            </div>
            <div id="user-sign-up-form-password" class="user-sign-form-element">
                <div class="user-sign-field-element popup-field-element">
                    <input type="password" id="user-sign-up-password" name="password" required placeholder=" ">
                    <label for="password">Password</label>
                </div>
                <p id="user-sign-up-password-info-deploy" class="popup-info-element popup-deploy-element">
                    Use at least 6 characters. Do not use empty spaces.
                </p>
            </div>
            <button id="user-sign-up-register-button" type="submit">REGISTER</button>
        </form>
        <div id="user-sign-up-already-have-account-button">
            Already have an account ? <button type="button">Log in</button>
        </div>
    </div>    
</div>
<?php endif; ?>