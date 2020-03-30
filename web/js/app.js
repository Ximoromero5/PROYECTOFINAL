$(document).ready(function () {
    //Preloader de la página
    setTimeout(() => {
        $('#preloaderPage').fadeOut();
    }, 1000);

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
            let output = $("<div class='dropdown-menu' aria-labelledby='searchUser' id='listaUsuarios' data-toggle='modal'></div>");
            $('#dropdownSearchUsers').html(output);
            $.ajax({
                url: 'header',
                method: 'POST',
                data: { searchUser: datos },
                cache: false,
            }).done(function (data) {
                output.append('<div id="preloaderAjax" class="loader loader--style1" title="0"><svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"width="40px" height="40px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve"><path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/><path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0C22.32,8.481,24.301,9.057,26.013,10.047z"><animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite"/></path></svg></div>');
                setTimeout(() => {
                    $('#preloaderAjax').hide();
                }, 1000);
                let datos = JSON.parse(data);

                let verified = '';
                $.each(datos, function (e, item) {
                    if (item.verified == 1) {
                        verified = '<img src="web/images/check.png" id="verifiedCheck">';
                    }
                    if (item.username != '') {
                        output.append($(`<a href='index.php?action=user&person=${item.username}' class='dropdown-item'><div id='dropImage'><img src='${item.photo}' alt=''></div><div id='dropName'><h6>${item.firstName}${verified}</h6><p>@${item.username}</p></div></a>`));
                    } else {
                        output.append($("<li class='dropdown-item'>User not found!</li>"));
                    }
                });
                $('#dropdownSearchUsers').html(output);
            });
        }
    });

    //Ocultar lista usuarios, al hace click fuera del contenedor, simulando lo del modal
    $(document).mouseup(function (e) {
        let container = $('#listaUsuarios');
        /* let hiddenNavbar = $('#hiddenNavbar'); */

        if (!container.is(e.target) && container.has(e.target).length === 0) {
            container.hide();
        }
        /*  if (!hiddenNavbar.is(e.target) && hiddenNavbar.has(e.target).length === 0 && $('#navbarToggle').is(e.target)) {
             hiddenNavbar.hide();
         } */
    })

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


    //Funcionalidad Mostrar/Ocultar buscador usuarios
    $('#searcherMobileOpen').click(function () {
        $('#searcher').addClass('openSearcherClass');
    });
    $('#searcherMobileClose').click(function () {
        $('#searcher').removeClass('openSearcherClass');
    });
});
