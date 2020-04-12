$(document).ready(function () {

    //Obtenemos todos los post nada más cargue la página
    getPost();
    setInterval(function () {
        getPost();
    }, 5000);

    //Iniciar los tooltips
    $('[data-toggle="tooltip"]').tooltip();

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
            url: 'profile',
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

    //Validación de lado cliente para que no se envie el campo vacío
    $('#addPostButton').attr('disabled', true);
    $('#addPostButton').css('cursor', 'not-allowed');

    //Cuando se escribe algo en el textarea de los post
    $('#textPost').keyup(function () {
        if ($.trim($(this).val()) == '') {
            $('#addPostButton').attr('disabled', true);
            $('#addPostButton').css('cursor', 'not-allowed');
            $('#addPostButton').css('background-color', '#0a52a3');
        } else {
            $('#addPostButton').attr('disabled', false);
            $('#addPostButton').css('cursor', 'pointer');
            $('#addPostButton').css('background-color', '#0a74ec');
        }
    });

    //Iconos del textarea
    /*  new EmojiPicker(); */

    //Si se selecciona alguna foto se ejecuta lo siguiente:
    $('#photoPost').on('change', function () {

        //Obtenemos el nombre de la foto
        let name = document.getElementById("photoPost").files[0].name;

        //Si el usuario selecciona una imagen se habilita el botón de publicar foto
        if (name !== '') {
            $('#addPostButton').attr('disabled', false);
            $('#addPostButton').css('cursor', 'pointer');
        }

        //Se comprueba la extensión de la imágen
        let extension = name.split('.').pop().toLowerCase();
        if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
            $(document.body).append($(`
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <b>Image extension not supported</b>, please select another.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>`));
        }

        //Se comprueba el tamaño de la imágen
        let file = document.getElementById("photoPost").files[0];
        let fileSize = file.size || file.fileSize;

        if (fileSize > 4000000) { //4MB
            $(document.body).append($(`
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <b>Image is so big</b>, please select another.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>`));
        }
    });

    //Función para añadir post
    $('#addPostButton').click(function () {
        $('#formularioPost').submit(function (e) { e.preventDefault() })
        let formularioData = new FormData();
        let photoPost = $('#photoPost')[0].files[0];
        let textPost = $('#textPost').val();

        formularioData.append('textPost', textPost);
        formularioData.append('photoPost', photoPost);
        $.ajax({
            url: "addPost",
            method: "POST",
            data: formularioData,
            cache: false,
            contentType: false,
            processData: false
        }).done(function (data) {
            $('#formularioPost')[0].reset();
            $('#postList').empty();
            getPost();
        });
    });

    //Función para obtener los post de las personas a las que sigues y de ti mismo.
    function getPost() {

        $.ajax({
            url: 'index.php',
            method: "GET",
            data: {
                action: 'getPost'
            }
        }).done(function (data) {

            //Mostramos la información de los post a través de jumbotron
            let datos = JSON.parse(data);
            let contenedorPost = $('#postList');
            let contenedor = $('<div></div>');
            if (datos != '') {
                let verified, photo, texto;

                //Fecha del post con formato
                let newDate = "";
                $.each(datos, function (e, item) {

                    //Asignamos verificado y la foto si hay
                    verified = item.verified == 1 ? "<img src='web/images/check.png'>" : "";
                    photo = item.photoPost !== '' ? `<img src="${item.photoPost}" class="w-100" data-toggle="modal" data-target="#modalProfilePhoto">` : '';
                    texto = item.text != '' ? `<p>${item.text}</p>` : '';
                    newDate = new Date(item.datePost);
                    let dateTimeFormat = new Intl.DateTimeFormat('en', { year: 'numeric', month: 'short', day: '2-digit', hour: '2-digit', minute: '2-digit' });
                    let [{ value: month }, , { value: day }, , { value: year }, , { value: hour }, , { value: minute }] = dateTimeFormat.formatToParts(newDate);

                    //Añadimos cada uno de los post que haya con formato html
                    $(contenedor).append($(`
                <div class="jumbotron" id="postContainer">
                    <div id="infoUser">
                        <div id="userData">
                                <a href="index.php?action=user&person=${item.username}" id="linkProfilePerson">
                                <div id="userInfoPost">
                                    <img src="${item.photo}" alt="">
                                    <div>
                                        <h5>${item.firstName} ${item.lastName} ${verified}</h5>
                                        <small class="ml-3">Web Developer Front End</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div id="containerDate">
                            <a tabindex="0" role="button" data-trigger="focus" data-toggle="popover" id="popoverOptions"><i class="fas fa-ellipsis-h icono"></i></a>
                            <small>${day} of ${month} ${hour}:${minute}</small>
                        </div>
                    </div>
                    <div id="parrafoTexto">
                        ${texto}
                    </div>
                    <div id="postImageContainer">
                            ${photo}
                        <div class="modal fade" id="modalProfilePhoto" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <img src="${$(photo).attr('src')}" alt="" class="w-100 h-100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="shareIcons">
                        <div id="shareIconsContainer">
                            <div id="shareIcon">
                                <a href="#0" id="shareButton">
                                    <i class="fas fa-share icono"></i>
                                    <span>Share</span>
                                </a>
                            </div>
                            <div id="commentIcon" class="commentIcon">
                                <button id="commentButton" class='commentButton'>
                                    <i class="far fa-comment icono"></i>
                                    <span>358</span>
                                </button>
                            </div>
                            <div id="likeIcon">
                                <button id="${item.id_post}" class="botonDarLike noLiked">
                                    <i class='far fa-heart icono'></i><span>Like</span>
                                </button>
                            </div>  
                        </div>
                        <div id="likesCount" class="likesCount" data-toggle="modal" data-target="#modalViewPersonsLiked">
                            <span><i class='fas fa-heart icono' id='iconLikeRed'></i><h6><i class="numeroLikes animate" id="numeroLikeCount"></i> likes</h6></span>
                        </div>
                    </div>
                    <div id='commentBox' class="commentBox">
                        <div class='top'>
                            <img src='${item.photo}' alt=''>
                            <div id='commentaryField'>
                                <input type='text' placeholder='Write a commentary...'>
                                <div>
                                    <i class="fas fa-smile-wink"></i>
                                    <i class="fas fa-camera"></i>
                                </div>
                            </div>
                        </div>
                        <div class='bottom'>
                    
                        </div>
                    </div>
                    <div class="modal fade" id="modalViewPersonsLiked" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content p-5">
                                <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times"></i></button>
                                <input type="text" placeholder="Search user" class="form-control">
                                <hr>
                                <ul class="list-group likedUsersList"></ul>
                            </div>
                        </div>
                    </div>
                </div>
                `));
                });
            } else {
                $(contenedor).append(`<div class="text-center"><h5>Oh, wow! <br>It seems you still don't follow anyone, discover new people.</h5><a href="#0" class="btn btn-primary rounded-pill">Discover People</a></div>`);
            }
            $(contenedorPost).html($(contenedor));
            //Añadimos la función para poder dar like
            giveLike();
        });
    }

    //Popover opciones post
    $('.popoverOptions').popover({ content: "<li class='list-group-item'><i class='fas fa-pencil-alt mr-2'></i>Edit</li><li class='list-group-item'><i class='far fa-trash-alt mr-2'></i>Delete</li>", html: true });

    //Buscar usuarios
    $('#searchUser').keyup(function () {
        let datosBusqueda = $(this).val();

        if (datosBusqueda != '') {
            $('#searchBarContainerList').addClass('show');
            $('#formularioPost #top').css('z-index', '-1');

            let output = $("<div id='usersContainer'></div>");
            $.ajax({
                url: 'header',
                method: 'POST',
                data: { searchUser: datosBusqueda },
                cache: false,
            }).done(function (data) {
                let datos = JSON.parse(data);
                if (datos != '') {
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
                    $('#searchBarContainerList').html(output);
                } else {
                    let output = $("<div id='emptyContainer'></div>");
                    output.append($(`<p title='${datosBusqueda}'><i class="fas fa-search" id="searchIcon"></i> ${datosBusqueda}</p>`));
                    $('#searchBarContainerList').html(output);
                }
            });
        } else {
            $('#searchBarContainerList').removeClass('show');
            $('#formularioPost #top').css('z-index', '0');
        }
    });

    //Cuando el usuario hace click en el input y hay algo
    $('#searchUser').click(function () {
        if ($(this).val() != '') {
            $('#searchBarContainerList').addClass('show');
            $('#formularioPost #top').css('z-index', '-1');
        }
    });

    //Ocultar lista usuarios, al hace click fuera del contenedor, simulando lo del modal
    $(document).mouseup(function (e) {
        let container = $('#searchBarContainerList');

        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $(container).removeClass('show');
            $('#formularioPost #top').css('z-index', '0');
        }
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
        }, 500);
    }
    /*  FIN IMPLEMENTACIÓN DEL TEMA OSCURO */

    //Cambiar color links menú
    $('#horizontalMenu li a').each(function () {
        if ((window.location.pathname.indexOf($(this).attr('href'))) > -1) {
            $(this).addClass('activeLink');
        }
    });

    /* Función para dar like a un post via ajax  */
    function giveLike() {
        $('.botonDarLike').each(function (e, item) {

            $.ajax({
                url: 'checkLike',
                method: 'POST',
                data: { id_post: $(this).attr('id') },
                success: function (data) {
                    let datos = JSON.parse(data);
                    let nameLiked = datos[1][e][2];
                    let nameLikedPost = String(nameLiked).split("|");

                    /*  if (datos[1][e][0] == $(item).attr('id')) {
                         console.log(`ID: ${datos[1][e][0]} ID2: ${$(item).attr('id')}`);
                         $('.likedUsersList').html($(`<a href="index.php?action=user&person=${nameLikedPost}"><li class="list-group-item">${nameLikedPost.reverse()}</li></a>`));
                     } */

                    console.log(`Id de cada post: ${$(item).attr('id')}`);
                    console.log(`Id devuelto de ajax: ${datos[1][e]['id_post']} NÚMERO: ${datos[1][e][1]}`);

                    //Asignamos el número de likes al post (Esta parte funciona al revés, pero bien)
                    if ($(datos[1][e][0]).eq($(item).attr('id'))) {
                        $('.numeroLikes').each(function (f, item) {
                            $(item).html(datos[1][f][1]);
                        })
                    } else {
                        console.log(false);
                    }

                    if (datos[0] == "true") {
                        $(item).removeClass('noLiked');
                        $(item).addClass('liked');
                        $(item).html("<i class='fas fa-heart icono' id='iconLikeRed'></i><span>Like</span>");
                    } else {
                        $(item).removeClass('liked');
                        $(item).addClass('noLiked');
                        $(item).html("<i class='far fa-heart icono' id='iconLike'></i><span>Like</span>");
                    }
                }
            });

            //Parte dar like
            $(item).click(function (e) {
                if ($(this).hasClass('noLiked')) {

                    //Sumamos uno al contador de likes
                    let nLike = Number($(this).parent().parent().next().find('#numeroLikeCount').text());
                    nLike++;
                    $(this).parent().parent().next().find('#numeroLikeCount').text(nLike);
                    $(this).removeClass('noLiked');
                    $(this).addClass('liked');
                    $.ajax({
                        url: 'giveLike',
                        method: 'POST',
                        data: { id_post: $(this).attr("id") }
                    }).done(function (e) {
                        if (e == "exito") {
                            $(item).html("<i class='fas fa-heart icono' id='iconLikeRed'></i><span>Like</span>");
                        }
                    });
                } else if ($(this).hasClass('liked')) {

                    //Restamos uno al contador de likes
                    let nLike = Number($(this).parent().parent().next().find('#numeroLikeCount').text());
                    nLike--;
                    $(this).parent().parent().next().find('#numeroLikeCount').text(nLike);
                    $(this).removeClass('liked');
                    $(this).addClass('noLiked');
                    $.ajax({
                        url: 'removeLike',
                        method: 'POST',
                        data: { id_post: $(this).attr("id") }
                    }).done(function (e) {
                        if (e == "exito") {
                            $(item).html("<i class='far fa-heart icono' id='iconLike'></i><span>Like</span>");
                        }
                    });
                }
            });
        });
    }

    function checkFollow() {

        //Función para obtener un valor especifico de la URL
        function getUrlVars() {
            let vars = {};
            let parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (m, key, value) {
                vars[key] = value;
            });
            return vars;
        }

        $.ajax({
            url: 'checkFollow',
            method: 'POST',
            dataType: 'json',
            data: {
                person: getUrlVars()['person']
            }
        }).done(function (data) {

            //Asignamos los seguidores
            $(data.nFollowers).each(function (e, item) {
                if (item[0] === data.id) {
                    $('.numeroSeguidores').html(item.nFollowers);
                }
            });

            //Asignamos las personas seguidas
            $(data.nFollowing).each(function (e, item) {
                if (item[0] === data.id) {
                    $('.numeroSiguiendo').html(item.nFollowing);
                }
            });

            if (data.success == '1') {
                console.log('UNFOLLOW BUTTON');
                $('#containerFollowButton').append($(`<button class="unfollowButton" id="${data.id}">Unfollow <i class="fas fa-user-slash"></i></button>`));
            } else {
                console.log('FOLLOW BUTTON');
                $('#containerFollowButton').append($(`<button class="followButton" id="${data.id}">Follow <i class="fas fa-user-plus"></i></button>`));
            }
            follow();
            unfollow();
        });
    }
    checkFollow();

    //Follow users
    function follow() {
        $('.followButton').each(function () {
            $(this).click(function () {
                let id_user = $(this).attr('id');
                $.ajax({
                    url: 'follow',
                    method: 'POST',
                    data: {
                        id_user: id_user
                    }
                }).done(function (data) {
                    $('#containerFollowButton').html($(`<button class="unfollowButton" id="${id_user}">Unfollow <i class="fas fa-user-slash"></i></button>`));
                    unfollow();
                });
            });
        });
    }


    //Unfollow users
    function unfollow() {
        $('.unfollowButton').each(function () {
            $(this).click(function () {
                let id_user = $(this).attr('id');
                $.ajax({
                    url: 'unfollow',
                    method: 'POST',
                    data: {
                        id_user: id_user
                    }
                }).done(function (data) {
                    $('#containerFollowButton').html($(`<button class="followButton" id="${id_user}">Follow <i class="fas fa-user-plus"></i></button>`));
                    follow();
                });
            });
        });
    }


    function showCommentBox() {
        console.log('showCommentBox');
        //Mostrar caja de comentarios en los post
        $('.commentIcon').each(function () {
            $(this).click(function () {
                $(this).parent().parent().parent().find('.commentBox').each(function () {
                    $(this).toggleClass('show');
                });
            });
        });

        /*  $('.commentButton').each(function () {
             $(this).clik(function () {
                 alert('f');
             })
         }) */
    }
    showCommentBox();


    function loadUnseenNotification(view = '') {
        $.ajax({
            url: 'checkNotification',
            method: 'POST',
            data: { view: view },
            dataType: 'json'
        }).done(function (data) {
            $('#listaNotificaciones').html(data.notificacion);
            if (data.unseen > 0) {
                $('#pildoraNotificacion').html(data.unseen);
            }
        });
    }

    loadUnseenNotification();

    $('#notificationLink').click(function () {
        $('#pildoraNotificacion').hide();
        loadUnseenNotification('yes');
    });

    setInterval(function () {
        loadUnseenNotification();
    }, 5000);
}); //Fin document.ready