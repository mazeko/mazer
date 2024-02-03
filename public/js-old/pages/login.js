import '../axios.min.js'
import { setCookie } from '../function.js';

document.getElementById("togglePassword").addEventListener("click", function () {
    const passwordInput = document.getElementById("password");
    const showPasswordCheckbox = document.getElementById("togglePassword");

    passwordInput.type = showPasswordCheckbox.checked ? "text" : "password";
})

const loginForm = document.getElementById("loginForm");
loginForm.addEventListener("submit", function(event) {
    event.preventDefault();
    document.getElementById("loginBtn").disabled = true
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    if (email && password) {
        axios.post('/api/v1/auth/login', {
            email: email,
            password: password
        }, { headers: { "MEZER-KEY" : "ZW5rdWRhdmlAZ21haWwuY29tOkthcmFuOXN1d3VuOSM=" }}).then(response => {
            const user = response.data
            console.log(user)
            setCookie("authToken", user.data.access_token, user.data.expires_in)
            Swal.fire({
                width:"24em",
                position: "center",
                icon: "success",
                text: "Authentication Succesful",
                showConfirmButton: false,
                timer: 800
            });

            setTimeout(() => {
                window.location.href = '/main/dashboard'; // Sesuaikan dengan path halaman home Anda
            }, 600);
        }).catch(error => {
            const message = error.response.data.message
            Swal.fire({
                width:"24em",
                position: "center",
                icon: "error",
                text: message,
                showConfirmButton: false,
                timer: 800
            });
        }).finally(() => {
            document.getElementById("loginBtn").disabled = false;
        });
    } else {
        console.log("Email and password must be filled");
        document.getElementById("loginBtn").disabled = false;
    }
});