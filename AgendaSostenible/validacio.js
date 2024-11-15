function validateForm() {
    const password = document.getElementById('contrasenya').value;
    const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[.,:;_-]).{8,}$/;

    if (!passwordRegex.test(password)) {
        alert("La contrasenya ha de tenir almenys 8 caràcters, incloent majúscules, un número i un caràcter especial.");
        return false;
    }
    return true;
}
