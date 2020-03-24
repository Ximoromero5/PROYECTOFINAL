$(function () {
    /* ************************** -VALIDAR FORMULARIO REGISTRO -************************** */

    //Validar email
    function isEmail(email) {
        let regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        return regex.test(email);
    }

    //Validar contraseña
    function validPassword(password) {
        let regex = /^(?=.*\d.*\d)[0-9A-Za-z!@#$%*]{8,}$/;
        return regex.test(password);
    }

    let username = $('#username'), email = $('#email'), password = $('#password'), gender = $('#gender');
    let errores = new Array();

    $('#registerForm').submit(function (e) {
        if (username.val() == '' || email.val() == '' || password.val() == '') {
            errores.push('You must fill all fields!');
        } else {

            //Validar username
            if (username.val().length < 6 && username.val().length > 15) {
                errores.push('The username length must be between 6 and 15 characters!');
            }

            //Validar email
            if (!isEmail(email.val())) {
                errores.push('Wrong email format!');
            }

            //Validar contarseña
            if (!validPassword(password.val())) {
                errores.push('Wrong password format!');
            }
        }

        //Validamos si el array no está vacío
        if (errores.length > 0) {
            errores.forEach(function (e) {
                $('.errores').after(`<div class="alert alert-danger" id="error" role="alert">${e}</div>`);
            });
            e.preventDefault();
            errores = [];
            setInterval(() => {
                $('#error').fadeOut(function () {
                    $(this).remove();
                });
            }, 5000);
        }
    });

    /* ************************** -VALIDAR FORMULARIO LOGIN -************************** */

    let usernameLogin = $('#usernameLogin'), passwordLogin = $('#passwordLogin');
    let errores2 = new Array();


    $('#loginForm').submit(function (e) {
        if (usernameLogin.val() == '' || passwordLogin.val() == '') {
            errores2.push('You must fill all fields!');
        }

        //Validamos si el array está vacío
        if (errores2.length > 0) {
            errores2.forEach(function (e) {
                $('.errores').after(`<div class="alert alert-danger" id="error" role="alert">${e}</div>`);
            });
            e.preventDefault();
            errores2 = [];
            setInterval(() => {
                $('#error').fadeOut(function () {
                    $(this).remove();
                });
            }, 5000);
        }
    });
});