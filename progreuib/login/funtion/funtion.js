function togglePassword() {
    const passwordInput = document.getElementById("password");
    const icon = document.getElementById("togglePasswordIcon");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove("bx-show");
        icon.classList.add("bx-hide");
    } else {
        passwordInput.type = "password";
        icon.classList.remove("bx-hide");
        icon.classList.add("bx-show");
    }
}
