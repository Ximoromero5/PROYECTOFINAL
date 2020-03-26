$(document).ready(function () {

    //Popover opciones post
    $('[data-toggle="popover"]').popover();

    //Los mensajes desaparecen a los 3s | MEJORAR
    setInterval(() => {
        $('#success').fadeOut(function () {
            $(this).remove();
        });
    }, 3000);

    //Calendario fecha cumpleaños | EN DUDA SI DEJARLO
    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
    });

    //Formulario para actualizar los datos del usuario | MEJORAR CON EL SERIALIZE
    $('#formulario').submit(function (e) {
        e.preventDefault();
        let id = $('#id').val(),
            city = $('#inputCity').val(),
            gender = $('#gender').val(),
            birthday = $('#datepicker').val(),
            firstName = $('#firstName').val(),
            lastName = $('#lastName').val(),
            description = $('#description').val();

        $.ajax({
            type: 'POST',
            url: 'index.php?action=profile',
            data: {
                id: id,
                city: city,
                gender: gender,
                birthday: birthday,
                firstName: firstName,
                lastName: lastName,
                description: description
            },
            success: function (data) {
                $('#parrafoDescripcion').text(description);
                $('#names').text(`${firstName} ${lastName}`);
                $('.errores').after("<div class='alert alert-success' id='success'>Your profile has been updated successfully!</div>");
                setInterval(() => {
                    $('#success').fadeOut(function () {
                        $(this).remove();
                    });
                }, 3000);
            },
            error: function () {
                console.log('Error al enviar los datos!');
            }
        });
    });

    //Cambiar el alto del textarea del post automáticamente
    /* $("textarea").keyup(function (e) {
        while ($(this).outerHeight() < this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth"))) {
            $(this).height($(this).height() + 1);
        };
    }); */

    //Validación de lado cliente para que no se envie el campo vacío
    //Desabilitar el botón por defecto
    $('#addPostButton').attr('disabled', true);
    $('#addPostButton').css('cursor', 'not-allowed');

    //Cuando se escribe algo
    $('#postText').keyup(function () {
        if ($.trim($(this).val()) == '') {
            $('#addPostButton').attr('disabled', true);
            $('#addPostButton').css('cursor', 'not-allowed');
        } else {
            $('#addPostButton').attr('disabled', false);
            $('#addPostButton').css('cursor', 'pointer');
        }
    });
    let formularioData = new FormData($('#formularioPost')[0]);
    //Si se selecciona alguna foto se ejecuta lo siguiente:
    $('#photoPost').on('change', function () {
        let name = document.getElementById("photoPost").files[0].name;

        //Si el usuario selecciona una imagen se habilita el botón de publicar foto
        if (name != '') {
            $('#addPostButton').attr('disabled', false);
            $('#addPostButton').css('cursor', 'pointer');
        }

        let extension = name.split('.').pop().toLowerCase();
        if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
            alert("Invalid Image File");
        }
        let fileReader = new FileReader();
        fileReader.readAsDataURL(document.getElementById("photoPost").files[0]);
        let file = document.getElementById("photoPost").files[0];
        let fileSize = file.size || file.fileSize;

        if (fileSize > 400000) { //4MB
            alert("Image File Size is very big");
        } else {
            if (name != '') {
                formularioData.append("photoPost", document.getElementById("photoPost").files[0]);
            }
        }
    });

    //Al enviar el formulario
    $('#formularioPost').submit(function (event) {
        event.preventDefault();
        formularioData.append('postText', $('#postText').val());
        $.ajax({
            url: "index.php?action=addPost",
            method: "POST",
            data: formularioData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $('#formularioPost')[0].reset();
                location.reload();
                /* showPost(); */
            }
        });
    });

    /*  showPost(); */

    function showPost() {
        $.ajax({
            url: 'index.php',
            method: "GET",
            data: {
                action: 'getPost'
            },
            success: function (data) {

                $('#postList').html(data);

            }
        });
    }
    /*  setInterval(function () { showPost(); }, 30000); */

    //Follow
    $('#buttonFollow').on('click', function () {
        let sender_id = $(this).data('sender_id');
        let action = $(this).data('action');
        $.ajax({
            url: 'index.php?action=peopleProfile',
            method: 'POST',
            data: { sender_id: sender_id, action: action },
            success: function (data) {
                let nFollowers = Number($('#followers').text());
                nFollowers++;
                $('#followers').text(nFollowers);
                $('#buttonFollow').replaceWith('<button name="unfollowButton" class="btn btn-danger" data-action="unfollow" data-sender_id="' + sender_id + '" id="buttonUnfollow">Unfollow <i class="fas fa-user-minus ml-1"></i></button>');
            }
        });
    });

    //Unfollow
    $('#buttonUnfollow').on('click', function () {
        let sender_id = $(this).data('sender_id');
        let action = $(this).data('action');
        $.ajax({
            url: 'index.php?action=peopleProfile',
            method: 'POST',
            data: { sender_id: sender_id, action: action },
            success: function (data) {
                let nFollowers = Number($('#followers').text());
                nFollowers--;
                $('#followers').text(nFollowers);
                $('#buttonUnfollow').replaceWith('<button name="followButton" class="btn btn-primary" data-action="follow" data-sender_id="' + sender_id + '" id="buttonFollow">Follow <i class="fas fa-user-plus ml-1"></i></button>');
            }
        });
    });

    //Buscar usuarios
    $('#searchUser').keyup(function () {
        let datos = $(this).val();

        if (datos != '') {
            $.ajax({
                url: 'header',
                method: 'POST',
                data: { searchUser: datos },
                cache: false,
            }).done(function (data) {
                if (data != '') {
                    let datos = JSON.parse(data);
                    $('#showUsers').append($('<li class="list-group-item"></li>').append('<a href="#">' + datos.d + '</a>'));
                } else {
                    $('#showUsers').text('No data found!');
                }

            });
        }
    });


    //Dropdown quitar evento
    $('.dropdown-item').click(function (e) {
        e.stopPropagation();
    });

    /*  IMPLEMENTACIÓN DEL TEMA OSCURO */
    let checkbox = $('#checkDarkTheme');

    $(checkbox).change(function () {
        if ($(this)[0].checked) {
            transition();
            $(document.documentElement).attr('data-theme', 'dark');
        } else {
            transition();
            $(document.documentElement).attr('data-theme', 'light');
        }

        //Guardamos la configuración en localStorage de momento
        if ($(document.documentElement).attr("data-theme") === 'dark') {
            localStorage.setItem('dark-theme', 'true');
        } else {
            localStorage.setItem('dark-theme', 'false');
        }
    });

    //Comprobamos el localStorage para ver el modo en el que está el usuario
    if (localStorage.getItem('dark-theme') === 'true') {
        $(document.documentElement).attr('data-theme', 'dark');
        $(checkbox).prop('checked', true);
    } else {
        $(document.documentElement).attr('data-theme', 'light');
        $(checkbox).prop('checked', false);
    }

    let transition = () => {
        $(document.documentElement).addClass('transition');
        window.setTimeout(() => {
            $(document.documentElement).removeClass('transition');
        }, 1000);
    }
    /*  IMPLEMENTACIÓN DEL TEMA OSCURO */
});
