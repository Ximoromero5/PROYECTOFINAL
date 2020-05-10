<title><?php echo $_SESSION['datos'][0]['firstName'] . ' ' . $_SESSION['datos'][0]['lastName'] . ' | Profile' ?></title>
<?php ob_start();
$row = $_SESSION['datos'][0];
?>

<div class="errores">
    <?php echo $parametros['mensaje'] != '' ? "<div class='alert alert-danger' role='danger'>" . $parametros['mensaje'] . "</div>" : '' ?>
    <?php echo $parametros['exito'] != '' ? '<div id="mensajeExito" class="alert alert-success alert-dismissible fade show" role="alert">' . $parametros['exito'] . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>' : '' ?>
</div>


<div style="background: url('<?php echo $row['coverPhoto'] ?>');" id="profileContainer" data-toggle="modal" data-target="#modalCoverProfile">
    <!--  Modal foto cover -->

    <div class="profilePhoto">
        <img src="<?php echo $row['photo'] ?>" alt="" data-toggle="modal" data-target="#modalProfilePhoto">
        <!--  Modal foto perfil -->
        <div title="Upload your profile photo" class="cameraIcon">
            <i class="fas fa-camera text-light" data-toggle="modal" data-target="#modalProfile"></i>
        </div>
    </div>

    <!-- Este es una ventana modal, cuando haces click sobre ella la imagen se hace más grande -->
    <div class="modal fade" id="modalProfilePhoto" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <img src="<?php echo $row['photo'] ?>" alt="" class="w-100 h-100">
            </div>
        </div>
    </div>

    <!-- Modal Foto de perfil-->
    <div class="modal fade" id="modalProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title" id="exampleModalLabel">Select profile photo</h5>
                    <form action="index.php?action=profilePhoto" method="POST" enctype="multipart/form-data" id="photoForm">
                        <div class="custom-file my-4">
                            <input type="file" class="custom-file-input" id="customFile" name="photo">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                        <div class="text-right">
                            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                            <button type="submit" class="btn btn-primary" name="upload">Update photo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Foto de perfil-->

    <!--  Modal foto de fondo -->
    <button class="changeCoverButton" data-toggle="modal" data-target="#modalCover"><i class="fas fa-camera text-light"></i>Change cover photo</button>
    <div class="modal fade" id="modalCover" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modal-title" id="exampleModalLabel">Select cover photo</h5>
                    <form action="index.php?action=profilePhoto" method="POST" enctype="multipart/form-data" id="photoForm">
                        <div class="custom-file my-4">
                            <input type="file" class="custom-file-input" id="customFile" name="cover">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                        <div class="text-right">
                            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                            <button type="submit" class="btn btn-primary" name="uploadCover">Update photo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--  Modal foto de fondo -->

</div>

<div id="informationProfile">
    <div class="contenedorNombre">
        <h1><?php echo $row['firstName'] . ' ' . $row['lastName'] ?></h1>
        <h6>@<?php echo $row['username'] ?></h6>
        <hr>
        <ul id="menuProfile">
            <li class="active" id="informationButton">
                <button>Information</button>
            </li>
            <li id="friendsButton">
                <button>Followers</button>
            </li>
            <li id="imagesButton">
                <button>Images</button>
            </li>
            <li data-toggle="modal" data-target="#modalEditProfile">
                <button><i class="fas fa-pencil-alt"></i>Edit profile</a>
            </li>
        </ul>

        <!-- Modal con el formulario para editar -->
        <div class="modal fade" id="modalEditProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="" id="formulario">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Email</label>
                                    <input type="text" class="form-control" value="<?php echo $row['email'] ?>" readonly>
                                    <small id="advert">This field cannot be modified</small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Username</label>
                                    <input type="text" class="form-control" value="<?php echo $row['username'] ?>" readonly>
                                    <small id="advert">This field cannot be modified</small>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="inputCity">City</label>
                                    <input type="text" class="form-control" id="inputCity" placeholder="City" name="city" value="<?php echo $row['city'] ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="gender">Gender</label>
                                    <select class="custom-select mr-sm-2" name="gender" id="gender">
                                        <option value="<?php echo $row['gender'] ?>" selected><?php echo $row['gender'] ?></option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="datepicker">Birthday</label>
                                    <input id="datepicker" name="birthday" value="<?php echo $row['birthday'] ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="firstName">First Name</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="First Name" name="firstName" value="<?php echo $row['firstName'] ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lastName">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" placeholder="Last Name" name="lastName" value="<?php echo $row['lastName'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" rows="3" class="form-control" placeholder="Describe yourself..."><?php echo $row['description'] ?></textarea>
                            </div>
                            <input type="hidden" name="id" id="id" value="<?php echo $row['id'] ?>">
                            <div class="modal-footer">
                                <p data-dismiss="modal">Cancel</p>
                                <button type="submit" class="btn btn-success" title="Update" name="update">Update profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal con el formulario para editar -->
        <div class="modal fade" id="editDetails" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" id="formulario">
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label>Position</label>
                                    <input type="text" class="form-control" value="<?php echo $row['position'] ?>" name="position">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label>Link</label>
                                    <input type="text" class="form-control" value="<?php echo $row['link'] ?>" name="link">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label>Status</label>
                                    <select class="custom-select mr-sm-2" name="gender" id="gender">
                                        <option value="<?php echo $row['status'] ?>" selected><?php echo $row['status'] ?></option>
                                        <option value="Single">Single</option>
                                        <option value="Relationship">Relationship</option>
                                        <option value="Divorced">Divorced</option>
                                        <option value="It's complicated">It's complicated</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <p data-dismiss="modal">Cancel</p>
                                <button type="submit" class="btn btn-success" title="Save" name="update">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contenedores de las tabs -->
        <div id="containerInformation" class="activeContainer">
            <div id="information" class="shadow-sm">
                <div class="top">
                    <h5>Details</h5>
                    <button class="editDetails" data-toggle="modal" data-target="#editDetails"><i class="fas fa-edit"></i>Details</button>
                </div>
                <ul id="infoProfile">
                    <?php if ($row['city'] != '') { ?>
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <p><b><?php echo $row['city']; ?></b></p>
                        </li>
                    <?php } ?>
                    <li>
                        <?php if ($row['birthday'] != '') { ?>
                            <i class="fas fa-birthday-cake"></i>
                            <p>Birthday: <b><?php echo $row['birthday'] != '' ? date('d \of M', strtotime($row['birthday'])) : ''; ?></b></p>
                        <?php } ?>
                    </li>
                    <li>
                        <i class="fas fa-envelope-open-text"></i>
                        <a href="mailto:<?php echo $row['email']; ?>" target="_blank"><?php echo $row['email']; ?></a>
                    </li>
                    <?php if ($row['position'] != '') { ?>
                        <li>
                            <i class="fas fa-briefcase"></i>
                            <p><?php echo $row['position'] ?></p>
                        </li>
                    <?php } ?>
                    <li>
                        <i class="fas fa-calendar-alt"></i>
                        <p><b>joined on </b><?php echo date('M \of yy', strtotime($row['joinDate'])); ?></p>
                    </li>
                    <?php if ($row['link'] != '') { ?>
                        <li>
                            <i class="fas fa-link"></i>
                            <a href="<?php echo $row['link'] ?>" target="_blank"><?php echo $row['link'] ?></a>
                        </li>
                    <?php } ?>
                    <?php if ($row['status'] != '') { ?>
                        <li>
                            <i class="fas fa-heart"></i>
                            <p><?php echo $row['status'] ?></p>
                        </li>
                    <?php } ?>
                    <?php if ($row['description'] != '') { ?>
                        <li class="description">
                            <h6>Description</h6>
                            <p>
                                <?php echo $row['description']; ?>
                            </p>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div id="postProfile" class="shadow-sm">
                <h5>Publications</h5>
                <div id="postListPerfil">
                    <?php
                    if ($parametros['datos'] != '') {
                        foreach ($parametros['datos'] as $key) {
                            $texto = $key['text'] != '' ? "<p>" . $key['text'] . "</p>" : '';
                            $foto = $key['photoPost'] != '' ? "<img src='$key[photoPost]'>" : '';
                            $date  = date('M \of yy h:m:s', strtotime($key['datePost']));
                    ?>
                            <div class="jumbotron" id="postContainer">
                                <div id="infoUser">
                                    <div id="userData">
                                        <a href="index.php?action=user&person=<?php echo $key['username'] ?>" id="linkProfilePerson">
                                            <div id="userInfoPost">
                                                <img src="<?php echo $key['photo'] ?>" class="lazyload" alt="">
                                                <div>
                                                    <?php echo "<h5>" . $key['firstName'] . ' ' . $key['lastName'] . "</h5>" ?>
                                                    <?php echo "<small>" . $key['position'] . "</small>" ?>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div id="containerDate">
                                        <span id="popoverOptions" data-toggle="popover" data-html="true" data-content="<li class='list-group-item bg-danger text-light deletePostButton' data-id='hola'><i class='fas fa-trash-alt mr-2'></i>Delete post</li>"><i class="fas fa-ellipsis-h"></i></span>
                                        <small><?php echo $date ?></small>
                                    </div>
                                </div>
                                <div id="parrafoTexto">
                                    <p><?php echo $texto; ?></p>
                                </div>
                                <div id="postImageContainer">
                                    <?php echo $foto; ?>
                                    <div class="modal fade" id="modalProfilePhoto" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <?php echo $foto; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="shareIcons">
                                    <div id="shareIconsContainer">
                                        <div id="likeIcon">
                                            <button id="<?php echo $key['id_post'] ?>" class="botonDarLike noLiked">
                                                <i class='far fa-heart icono'></i><span>
                                                    <div id="likesCount" class="likesCount" data-toggle="modal" data-target="#modalViewPersonsLiked">
                                                        <span>57</span>
                                            </button>
                                        </div>
                                        <div id="commentIcon" class="commentIcon">
                                            <button id="commentButton" class='commentButton'>
                                                <i class="far fa-comment-alt"></i>
                                                <span>32</span>
                                            </button>
                                        </div>
                                        <div id="shareIcon">
                                            <a href="#0" id="shareButton">
                                                <i class="far fa-share-square"></i>
                                                <span>18</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div id='commentBox' class="commentBox">
                                    <div class='top'>
                                        <img src='<?php echo $key['photo'] ?>' alt=''>
                                        <div id='commentaryField'>
                                            <input type='text' placeholder='Write a commentary...' class='cajaComentarios' id='<?php echo $key['id'] ?>'>
                                            <div id='commentIcons'>
                                                <i class="fas fa-smile-wink"></i>
                                                <i class="fas fa-camera"></i>
                                                <button class='addCommentaryButton'><i class="fas fa-arrow-right"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='bottom' id='<?php echo $key['id'] ?>'>

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
                    <?php
                        }
                    } else {
                        echo "<p>No content to display...</p>";
                    } ?>
                </div>
            </div>
        </div>
        <div id="containerFriends">
            <h5>Followers</h5>
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
        <div id="containerImages">
            <h5>Images</h5>
            <div id="lightgallery">
                <?php foreach ($parametros['datos'] as $key) {
                    if ($key['photoPost'] != '') { ?>
                        <a href="<?php print_r($key['photoPost']) ?>"><img src="<?php print_r($key['photoPost']) ?>"></a>
                <?php }
                } ?>
            </div>
        </div>
    </div>
</div>


<?php $contenido = ob_get_clean(); ?>
<?php include 'header.php' ?>