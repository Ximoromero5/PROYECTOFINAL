<?php ob_start();

$datos = [];

if (isset($datosUser[0])) {
    $datos = $datosUser[0];
}

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
                        <?php if ($datos['city'] != '') { ?>
                            <div class="place">
                                <i class="fas fa-map-marker-alt"></i>
                                <p><b><?php echo $datos['city']; ?></b></p>
                            </div>
                        <?php } ?>
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
                        <a href="#0">
                            <h5>Photos</h5>
                        </a>
                        <a href="#0">
                            <h6>View all</h6>
                        </a>
                    </div>
                    <div class="bottom">
                        <?php /* for ($i = 0; $i < 10; $i++) {
                            if (isset($postsUser[$i])) {
                                $data = $postsUser[$i];
                                if ($data['photoPost'] !== '') {
                                    echo "<img src='$data[photoPost]' alt=''>";
                                }
                            }
                        }  */ ?>
                    </div>
                </div>
            </div>
            <div id="center">
                <div id="top">
                    <ul id="options">
                        <li>
                            <i class="fas fa-id-badge"></i>
                            <h6>about</h6>
                        </li>
                        <li>
                            <i class="fas fa-user-friends"></i>
                            <h6>friends</h6>
                        </li>
                        <li>
                            <i class="fas fa-images"></i>
                            <h6>photos</h6>
                        </li>
                        <li>
                            <i class="fas fa-ellipsis-v"></i>
                        </li>
                    </ul>
                    <div id="containerFollowButton"></div>
                </div>

                <!-- Aquí van los post del usuario del que estamos viendo el perfil -->
                <div class="panel panel-default" id="panelPrivateUsers">
                    <div class="panel-body">
                        <div id="postList"></div>
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
?>

<!-- Recogemos contenido para mostrarlo con el header -->
<?php $contenido = ob_get_clean(); ?>
<?php include 'header.php'; ?>