
Array.from(document.querySelectorAll("form .auth-pass-inputgroup")).forEach(function(s){Array.from(s.querySelectorAll(".password-addon")).forEach(function(t){t.addEventListener("click",function(t){var e=s.querySelector(".password-input");"password"===e.type?e.type="text":e.type="password"})})});var password=document.getElementById("password-input"),confirm_password=document.getElementById("confirm-password-input");function validatePassword(){password.value!=confirm_password.value?confirm_password.setCustomValidity("Passwords Don't Match"):confirm_password.setCustomValidity("")}password.onchange=validatePassword;var myInput=document.getElementById("password-input"),letter=document.getElementById("pass-lower"),capital=document.getElementById("pass-upper"),number=document.getElementById("pass-number"),length=document.getElementById("pass-length");myInput.onfocus=function(){document.getElementById("password-contain").style.display="block"},myInput.onblur=function(){document.getElementById("password-contain").style.display="none"},myInput.onkeyup=function(){myInput.value.match(/[a-z]/g)?(letter.classList.remove("invalid"),letter.classList.add("valid")):(letter.classList.remove("valid"),letter.classList.add("invalid")),myInput.value.match(/[A-Z]/g)?(capital.classList.remove("invalid"),capital.classList.add("valid")):(capital.classList.remove("valid"),capital.classList.add("invalid"));myInput.value.match(/[0-9]/g)?(number.classList.remove("invalid"),number.classList.add("valid")):(number.classList.remove("valid"),number.classList.add("invalid")),8<=myInput.value.length?(length.classList.remove("invalid"),length.classList.add("valid")):(length.classList.remove("valid"),length.classList.add("invalid"))};

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

