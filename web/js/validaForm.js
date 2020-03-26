$(function () {

    /* VALIDACIÓN DEL FORMULARIO DE REGISTRO */
    $("form#registerForm").validate({
        rules: {
            username: {
                required: true,
                minlength: 4
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            },
            gender: "required"
        },
        messages: {
            username: {
                required: "Please provide a username.",
                minlength: "Username must have at least 4 characters."
            },
            email: "Please enter a valid email address (example@example.com).",
            password: {
                required: "Please provide a password.",
                minlength: "Your password must have at least 6 characters",
            },
            gender: "Please enter your gender."
        },
        submitHandler: function (form) {
            form.submit();
        }
    });

    //Validación visual (si al enviar el formulario algún input tiene la clase error, se añade una clase)
    $("form#registerForm").submit(function () {
        $('#username').hasClass('error') ? $('#username').addClass('invalid') : $('#username').removeClass('invalid');
        $('#email').hasClass('error') ? $('#email').addClass('invalid') : $('#email').removeClass('invalid');
        $('#password').hasClass('error') ? $('#password').addClass('invalid') : $('#password').removeClass('invalid');
        $('#gender').hasClass('error') ? $('#gender').addClass('invalid') : $('#gender').removeClass('invalid');
    });

    /* VALIDACIÓN DEL FORMULARIO DE REGISTRO */

    /* VALIDACIÓN DEL FORMULARIO DE LOGIN */
    let usernameLogin = $('#usernameLogin'), passwordLogin = $('#passwordLogin');
    let forms = document.getElementsByClassName('needs-validation');
    /*  $(passwordLogin).keyup(function () { $(this).val() != '' ? $('#passwordEye').css('bottom', '15px') : $('#passwordEye').css('bottom', '38px'); }) */

    Array.prototype.filter.call(forms, function (formulario) {
        formulario.addEventListener('submit', function (e) {
            if (formulario.checkValidity() === false) {
                e.preventDefault();
                if (usernameLogin.val() === '') {
                    e.preventDefault();
                    $(usernameLogin).addClass('invalid');
                }
                if (passwordLogin.val() === '') {
                    e.preventDefault();
                    $(passwordLogin).addClass('invalid');
                }
            }

            formulario.classList.add('was-validated');
        });
    });

    /* VALIDACIÓN DEL FORMULARIO DE LOGIN */

    //Funcionalidad de ver la contraseña en el login
    $('#passwordEye').click(function () {
        $(this).toggleClass('fa-eye-slash');
        if (passwordLogin.attr('type') === 'password') {
            passwordLogin.attr('type', 'text');
        } else {
            passwordLogin.attr('type', 'password');
        }
    });

}); //Main key