// password addon
var password = document.querySelector(".password-input");
var passwordToggleBtn = document.querySelector(".password-addon");

if (passwordToggleBtn) {
    passwordToggleBtn.addEventListener("click", function () {
        if (password.type === "password") {
            password.type = "text";
        } else {
            password.type = "password";
        }
    });
}

// password strength
var passwordInput = document.querySelector("#password-input");
var confirmPasswordInput = document.querySelector("#confirm-password-input");
var passwordLength = document.querySelector("#pass-length");
var passLower = document.querySelector("#pass-lower");
var passUpper = document.querySelector("#pass-upper");
var passNumber = document.querySelector("#pass-number");

if (passwordInput) {
    passwordInput.addEventListener("keyup", function () {
        var val = passwordInput.value;
        var result = checkStrength(val);
        if (result == 0) {
            passwordLength.classList.add("invalid");
            passLower.classList.add("invalid");
            passUpper.classList.add("invalid");
            passNumber.classList.add("invalid");
        } else if (result == 1) {
            passwordLength.classList.remove("invalid");
            passLower.classList.add("invalid");
            passUpper.classList.add("invalid");
            passNumber.classList.add("invalid");
        } else if (result == 2) {
            passwordLength.classList.remove("invalid");
            passLower.classList.remove("invalid");
            passUpper.classList.add("invalid");
            passNumber.classList.add("invalid");
        } else if (result == 3) {
            passwordLength.classList.remove("invalid");
            passLower.classList.remove("invalid");
            passUpper.classList.remove("invalid");
            passNumber.classList.add("invalid");
        } else if (result == 4) {
            passwordLength.classList.remove("invalid");
            passLower.classList.remove("invalid");
            passUpper.classList.remove("invalid");
            passNumber.classList.remove("invalid");
        }
    });
}

if (confirmPasswordInput) {
    confirmPasswordInput.addEventListener("keyup", function () {
        if (passwordInput.value != confirmPasswordInput.value) {
            confirmPasswordInput.setCustomValidity("Passwords do not match");
        } else {
            confirmPasswordInput.setCustomValidity("");
        }
    });
}

function checkStrength(password) {
    var strength = 0;
    if (password.length < 8) {
        return 0;
    }
    if (password.match(/[a-z]+/)) {
        strength += 1;
    }
    if (password.match(/[A-Z]+/)) {
        strength += 1;
    }
    if (password.match(/[0-9]+/)) {
        strength += 1;
    }
    if (password.match(/[$@#&!]+/)) {
        strength += 1;
    }
    return strength;
}
