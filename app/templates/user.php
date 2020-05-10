<title><?php echo $datosUser[0]['username'] . ' | Profile' ?></title>
<?php ob_start();

$datos = [];

if (isset($datosUser[0])) {
    $datos = $datosUser[0];
}

?>

<?php

//Si el usuario existe
if ($datosUser[0] != 0) {

    //Convertimos la fecha de formato (2020-02-20) a (20 of Feb)
    $birthday = date('d \of M', strtotime($datos['birthday']));
    $joined  = date('M \of yy', strtotime($datos['joinDate']));
    $verified = $datos['verified'] == '1' ? '<img src="web/images/check.png" id="verifiedCheck">' : '';

    //Si el usuario buscado no es el usuario que tiene la sesión
    if ($datos['username'] != $_SESSION['datos'][0]['username']) { ?>

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
                        </div>
                        <div id="information">
                            <?php if ($datos['city'] != '') { ?>
                                <div class="place">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <p><b><?php echo $datos['city']; ?></b></p>
                                </div>
                            <?php } ?>
                            <div class="birthday">
                                <i class="fas fa-birthday-cake"></i>
                                <p>Date of birth: <b><?php echo $birthday; ?></b></p>
                            </div>
                            <div class="joined">
                                <i class="fas fa-envelope-open-text"></i>
                                <a href="mailto:<?php echo $datos['email']; ?>" target="_blank"><?php echo $datos['email']; ?></a>
                            </div>
                            <div id="followers">
                                <div class="following">
                                    <p>
                                        <h6 class="numeroSiguiendo"></h6>
                                        following
                                    </p>
                                </div>
                                <div class="followers">
                                    <p>
                                        <h6 class="numeroSeguidores"></h6>
                                        followers
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="containerProfilePhotos">
                        <div class="top">
                            <h5>Photos</h5>
                        </div>
                        <div class="bottom">
                            <div id="lightgallery">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="center">
                    <div id="top">
                        <ul id="options" class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li title="Posts">
                                <a href="#pills-post" id="postPill" class="active">Posts</i></a>
                            </li>
                            <li title="About">
                                <a href="#pills-information" id="aboutPill">Information</i></a>
                            </li>
                            <li title="Followers">
                                <a href="#pills-followers" id="friendsPill">Followers</a>
                            </li>
                            <li title="Message">
                                <a href="#0"><i class="fas fa-envelope"></i>Message</a>
                            </li>
                            <li title="Settings">
                                <a href="#0"><i class="fas fa-ellipsis-v"></i></a>
                            </li>
                        </ul>
                        <div id="containerFollowButton"></div>
                    </div>

                    <div class="tab-content" id="tablaPrivateUsers">
                        <div class="tab-pane fade show active" id="pills-post" role="tabpanel" aria-labelledby="postPill">

                            <!-- Aquí se muestran los post -->
                            <div class="panel panel-default" id="panelPrivateUsers">
                                <div class="panel-body">
                                    <h3>Publications</h3>
                                    <div id="postList"></div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-information" role="tabpanel" aria-labelledby="aboutPill">
                            <h3>Information</h3>
                            <ul>
                                <?php if ($datos['position'] != '') { ?>
                                    <li>
                                        <i class="fas fa-briefcase"></i>
                                        <p> <?php echo $datos['position']; ?></p>
                                    </li>
                                <?php } ?>
                                <li>
                                    <i class="fas fa-calendar-alt"></i>
                                    <p><b>joined</b> <?php echo $joined; ?></p>
                                </li>
                                <?php if ($datos['status'] != '') { ?>
                                    <li>
                                        <i class="fas fa-heart"></i>
                                        <p><?php echo $datos['status'] ?></p>
                                    </li>
                                <?php } ?>
                                <?php if ($datos['link'] != '') { ?>
                                    <li>
                                        <i class="fas fa-link"></i>
                                        <a href="<?php echo $datos['link'] ?>" target="_blank"><?php echo $datos['link'] ?></a>
                                    </li>
                                <?php } ?>
                                <?php if ($datos['description'] != '') { ?>
                                    <li class="description">
                                        <h6>Description</h6>
                                        <p>
                                            <?php echo $datos['description']; ?>
                                        </p>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="tab-pane fade" id="pills-followers" role="tabpanel" aria-labelledby="friendsPill">
                            <h3>Followers</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php } else {
        header('Location: profile');
    }
} else {
    echo "<div class='container-fluid mt-5 text-center'><h3>This account does not exist!</h3><p>Please try another search.</p><a href='home' class='btn btn-primary rounded-pill'>Go home</a></div>";
} ?>

<!-- Recogemos contenido para mostrarlo con el header -->
<?php $contenido = ob_get_clean(); ?>
<?php include 'header.php'; ?>