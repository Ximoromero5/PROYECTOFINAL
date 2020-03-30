<?php ob_start();
if (count($parametros['datos']) == 1) {
    foreach ($parametros['datos'] as $datos) {

        //Convertimos la fecha de formato (2020-02-20) a (20 of Feb)
        $birthday = date('d \of M', strtotime($datos['birthday']));
        $joined  = date('M \of yy', strtotime($datos['joinDate']));
        $verified = $datos['verified'] == '1' ? '<img src="web/images/check.png" id="verifiedCheck">' : '';

        //Si el usuario buscado no es el usuario que tiene la sesión
        if ($datos['username'] != $_SESSION['username']) { ?>

            <div id="containerProfile">
                <header>
                    <!-- Aquí va la imágen de cover del usuario visitado -->
                    <img src="<?php echo $datos['coverPhoto']; ?>" alt="" data-toggle="modal" data-target="#modalImageCover">

                    <!-- Este es una ventana modal, cuando haces click sobre ella la imagen se hace más grande -->
                    <div class="modal fade" id="modalImageCover" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <img src="<?php echo $datos['coverPhoto'] ?>" alt="" class="w-100 h-100">
                            </div>
                        </div>
                    </div>
                </header>
                <div id="main">
                    <div id="left">
                        <!-- Aquí va la información del usuario visitado -->
                        <div id="carta">
                            <div id="profilePhoto">
                                <img src="<?php echo $datos['photo']; ?>" alt="" data-toggle="modal" data-target="#modalImageProfile">
                            </div>
                            <!-- Este es una ventana modal, cuando haces click sobre ella la imagen se hace más grande -->
                            <div class="modal fade" id="modalImageProfile" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <img src="<?php echo $datos['photo'] ?>" alt="" class="w-100 h-100">
                                    </div>
                                </div>
                            </div>
                            <div id="namePart">
                                <h3><?php echo $datos['firstName'] . " " . $datos['lastName'] . $verified ?></h3>
                                <p>@<?php echo $datos['username']; ?></p>
                                <h6>Web Developer Back-end</h6>
                            </div>
                            <div id="information">
                                <div class="place">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <p><b><?php echo $datos['city']; ?></b></p>
                                </div>
                                <div class="joined">
                                    <i class="fas fa-calendar-alt"></i>
                                    <p>Joined on: <b><?php echo $joined; ?></b></p>
                                </div>
                                <div class="birthday">
                                    <i class="fas fa-birthday-cake"></i>
                                    <p>Date of birth: <b><?php echo $birthday; ?></b></p>
                                </div>
                                <div id="followers">
                                    <div class="following">
                                        <p>
                                            <h6><?php echo $datos['numberFollowing']; ?></h6>
                                            following
                                        </p>
                                    </div>
                                    <div class="followers">
                                        <p>
                                            <h6><?php echo $datos['numberFollowers']; ?></h6>
                                            followers
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="center">

                        <!-- Aquí van los post del usuario del que estamos viendo el perfil -->
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div id="postList">
                                    <?php
                                    if (count($parametros['userPosts']) > 0) {
                                        foreach ($parametros['userPosts'] as $datos) {
                                    ?>
                                            <div class="jumbotron" id="postContainer">
                                                <div id="infoUser">
                                                    <div id="userData">
                                                        <a href="#" id="linkProfilePerson">
                                                            <div id="userInfoPost">
                                                                <img src='<?php echo $datos['photo'] ?>' alt=''>
                                                                <div>
                                                                    <h5><?php echo $datos['firstName'] . " " . $datos['lastName'] ?></h5>
                                                                    <small class="ml-3">Web Developer Front End</small>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div id="containerDate">
                                                        <a tabindex="0" role="button" data-toggle="popover" data-trigger="focus" data-content="And here's some amazing content. It's very engaging. Right?" title="Options" id="popoverOptions"><i class="fas fa-ellipsis-h icono" title="Options"></i></a>
                                                        <?php
                                                        $date = new DateTime($datos['datePost']);
                                                        echo "<small>" . $date->format('G:ia d-m') . "</small>";
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="mt-2" id="parrafoTexto">
                                                    <p><?php echo $datos['text'] ?></p>
                                                </div>
                                                <div id="postImageContainer">
                                                    <?php $foto = explode('.', $datos['photoPost']);
                                                    if (end($foto) != '') { ?>
                                                        <img src='<?php echo $datos['photoPost'] ?>' class="w-100" data-toggle="modal" data-target="#modalImagePost">
                                                    <?php } ?>
                                                    <div class="modal fade" id="modalImagePost" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <img src="<?php echo $datos['photoPost'] ?>" alt="" class="w-100 h-100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="shareIcons">
                                                    <i class="far fa-heart m-3 icono"></i>
                                                    <i class="far fa-comment m-3 icono"></i>
                                                    <i class="flaticon-share m-3 icono"></i>
                                                </div>
                                            </div>
                                    <?php

                                        }
                                    } else {
                                        echo "<div class='text-center mt-4' id='noPostDisplay'><h3>Oh, wow! There seem to be no posts to display</h3></div>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!-- MOSTRAR POST -->
                    </div>
                    <div id="right" class="d-none d-xl-block">
                        <!-- Aquí va la una carta que de momento no hace nada -->
                        <div class="card">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus cum, id distinctio autem nesciunt perferendis culpa, quae perspiciatis, voluptate nemo ad vitae quia voluptatum ratione veniam itaque natus nam eius.
                        </div>
                    </div>
                </div>
            </div>

<?php } else {
            header('Location: profile');
        }
    } //Cierre foreach

} else {
    echo "<div class='text-center mt-4'><h3>The user doesn't exists!</h3><p>Try to search another...</p></div>";
}

/* Recogemos contenido para mostrarlo con el header */
$contenido = ob_get_clean();
include 'header.php' ?>