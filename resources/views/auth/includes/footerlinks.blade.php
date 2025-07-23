<script src="{{asset('/assets/js/plugins/perfect-scrollbar.min.js')}}"></script>

{{-- start toggle password visibility --}}

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const passwordInput = document.getElementById("password");
        const togglePassword = document.getElementById("togglePassword");

        if (passwordInput && togglePassword) {
            togglePassword.addEventListener("click", function () {
                const isPassword = passwordInput.type === "password";
                passwordInput.type = isPassword ? "text" : "password";

                togglePassword.classList.toggle("fa-eye");
                togglePassword.classList.toggle("fa-eye-slash");
            });
        }
    });
</script>



{{-- end toggle password visibility --}}

<!-- main script file  -->
<script src="{{asset('/assets/js/soft-ui-dashboard-pro-tailwind.js?v=1.0.1')}}"></script>