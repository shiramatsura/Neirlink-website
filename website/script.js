function showPopup(prefix) {
    document.getElementById(`${prefix}-menu`).classList.add("active");
}

function hidePopup(prefix) {
    let valid_elements = document.querySelectorAll(`#${prefix}-popup .popup-valid-element`);
    for (let valid_element of valid_elements) {
        valid_element.innerText = "";
        valid_element.classList.remove("active");
    }

    let alert_elements = document.querySelectorAll(`#${prefix}-popup .popup-alert-element`);
    for (let alert_element of alert_elements) {
        alert_element.innerText = "";
        alert_element.classList.remove("active");
    }

    let info_elements = document.querySelectorAll(`#${prefix}-popup .popup-info-element`);
    for (let info_element of info_elements) {
        info_element.innerText = info_element.default_message;
        info_element.classList.remove("popup-valid-element");
        info_element.classList.remove("popup-alert-element");
        info_element.classList.remove("active");
    }

    let field_elements = document.querySelectorAll(`#${prefix}-popup .popup-field-element input`);
    for (let field_element of field_elements) field_element.value = "";

    document.getElementById(`${prefix}-menu`).classList.remove("active");
}

function configPopupInfo(parent_id, default_message) {
    let parent_element = document.getElementById(parent_id);
    let field_element = parent_element.querySelector(".popup-field-element input");
    let info_element = parent_element.querySelector(".popup-info-element");

    if (info_element) {
        info_element.default_message = default_message;
    
        //active only affects deploy elements. deploy elements are intended to always be info elements
    
        //when field input element gets focus => show deploy element
        field_element.addEventListener("focus", (event) => {
            if (event.target == event.currentTarget && !info_element.classList.contains("popup-valid-element") &&
            !info_element.classList.contains("popup-alert-element")) {
                info_element.innerText = info_element.default_message;
                info_element.classList.add("active");
            }
        });
    
        //when field input element loses focus => hide deploy element
        field_element.addEventListener("blur", (event) => {
            if (event.target == event.currentTarget && !info_element.classList.contains("popup-valid-element") &&
            !info_element.classList.contains("popup-alert-element")) {
                info_element.classList.remove("active");
            }
        });
    }

}


let identifier_available = false;
let password_valid = false;
function verifyUserSignUpIdentifier() {
    let info_element = document.getElementById("user-sign-up-identifier-info");
    
    document.getElementById("user-sign-up-identifier").addEventListener('input', (event) => {
        const identifier = event.currentTarget.value;
        fetch('verify_new_identifier_available.php', {
            method: 'POST',
            header: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({identifier})
        })
        .then(response => response.json())
        .then(data => {
            info_element.innerText = data.message;
            if (data.success) {
                info_element.classList.remove("popup-alert-element");
                info_element.classList.add("popup-valid-element");
                identifier_available = true;
            }
            else {
                info_element.classList.remove("popup-valid-element");
                info_element.classList.add("popup-alert-element");
                identifier_available = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            info_element.innerText = "Something went wrong. Please try again later";
            info_element.classList.remove("popup-valid-element");
            info_element.classList.add("popup-alert-element");
            identifier_available = false;
        });

        if (identifier_available && password_valid) {
            document.getElementById("user-sign-up-register-button").disabled = false;
        } else document.getElementById("user-sign-up-register-button").disabled = true;
    });
}

function verifyUserSignUpPassword() {
    let info_element = document.getElementById("user-sign-up-password-info-deploy");

    document.getElementById("user-sign-up-password").addEventListener('input', (event) => {
        let password = event.currentTarget.value;

        if (password.length < 6) {
            info_element.innerText = "Use at least 6 characters. Do not use empty spaces";
            info_element.classList.add("popup-alert-element");
        }
        else if (password.length > 64) {
            info_element.innerText = "Password too long. Limit: 64 characters";
            info_element.classList.add("popup-alert-element");
        }
        else {
            info_element.classList.remove("popup-alert-element");
            info_element.classList.add("popup-valid-element");
        }
    });
}


function configUserSignInPopup() {
    //show popup from buttons in navbar
    document.getElementById("navbar-sign-in-button").addEventListener("click", () => {
        showPopup("user-sign-in");
    });
    
    //hide popup when click outside
    document.getElementById(`user-sign-in-menu`).addEventListener("click", (event) => {
        if (event.target === event.currentTarget) {
            hidePopup("user-sign-in");
        }
    });

    //switch popup when "no account" button is clicked
    document.querySelector("#user-sign-in-no-account-button button").addEventListener("click", () => {
        document.getElementById("user-sign-up-identifier").value = document.getElementById("user-sign-in-identifier").value;
        document.getElementById("user-sign-up-password").value = document.getElementById("user-sign-in-password").value;
        hidePopup("user-sign-in");
        showPopup("user-sign-up");
    });
}

function configUserSignUpPopup() {
    //show popup from buttons in navbar
    document.getElementById("navbar-sign-up-button").addEventListener("click", () => {
        showPopup("user-sign-up");
    });

    //hide popup when click outside
    document.getElementById(`user-sign-up-menu`).addEventListener("click", (event) => {
        if (event.target === event.currentTarget) {
            hidePopup("user-sign-up");
        }
    });

    //switch popup when "already has account" button is clicked
    document.querySelector("#user-sign-up-already-have-account-button button").addEventListener("click", () => {
        document.getElementById("user-sign-in-identifier").value = document.getElementById("user-sign-up-identifier").value;
        document.getElementById("user-sign-in-password").value = document.getElementById("user-sign-up-password").value;
        hidePopup("user-sign-up");
        showPopup("user-sign-in"); 
    });

    //popup info elements config
    configPopupInfo("user-sign-up-form-identifier", "Identifier is unique and helps finding you on Lelol. You will always be able to change it later.");
    configPopupInfo("user-sign-up-form-password", "Use at least 6 characters. Do not use empty spaces.");
    
    //verify identifier isn't already taken
    verifyUserSignUpIdentifier();
    verifyUserSignUpPassword();


}

function configUserSignInSubmission() {
    document.getElementById("user-sign-in-form").addEventListener("submit", (event) => {
        event.preventDefault();
        const identifier = document.getElementById("user-sign-in-identifier").value;
        const password = document.getElementById("user-sign-in-password").value;

        let alert_element = document.getElementById("user-sign-in-alert");

        // AJAX request with fetch()
        fetch('user_sign_in_request.php', {
            method: 'POST',
            header: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({identifier, password})
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect_url;
            } else {
                alert_element.innerText = data.error;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert_element.innerText = "Something went wrong. Please try again later";
        });
    });
}

function configUserSignUpSubmission() {

}


function initUserSignListener() {
    configUserSignInPopup();
    configUserSignUpPopup();
    configUserSignInSubmission();
    configUserSignUpSubmission();
}

initUserSignListener();