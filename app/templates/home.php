<?php ob_start(); ?>
<main id="mainContainer">
    <aside id="leftContainer" class="d-none d-md-block">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam ab repellendus illo corrupti tempore? Aspernatur, nostrum labore porro inventore, et quaerat impedit consequatur eum illum blanditiis architecto! Qui, quos numquam!</p>
    </aside>
    <!-- Contenedor para escribir un post -->
    <div id="containerWrite">

        <!-- Aquí se recogen los datos que escriba el usuario (texto del post, imágen del post, y se controla cuando hace click en publicar) -->
        <div id="top">
            <textarea placeholder="Write here, Add images or a video for visual impact." maxlength="250" name="postText" id="postText"></textarea>
            <input type="file" id="photoPost" name="photoPost" class="d-none">
        </div>
        <div id="bottom" class="mb-4">
            <div id="containerIconsWrite">
                <div class="iconsWrite" title="Emoji">
                    <img src="web/images/smile.png" alt="">
                    <h6>Emoji</h6>
                </div>
                <label for="photoPost">
                    <div class="iconsWrite" title="Image">
                        <img src="web/images/camera.png" alt="">
                        <h6>Image</h6>
                    </div>
                </label>
                <div class="iconsWrite" title="Video">
                    <img src="web/images/video.png" alt="">
                    <h6>Video</h6>
                </div>
            </div>
            <div id="publishPostContainer">
                <button id="addPostButton" title="Publish"><img src="web/images/right-arrow.png" alt=""></button>
            </div>
        </div>

        <!-- MOSTRAR POST -->
        <div class="panel panel-default">
            <div class="panel-body">
                <div id="postList">
                    <?php
                    if (count($parametros['datos']) > 0) {
                        foreach ($parametros['datos'] as $datos) {
                    ?>
                            <div class="jumbotron" id="postContainer">
                                <div id="infoUser">
                                    <div>
                                        <a href="index.php?action=peopleProfile&person=<?php echo $datos['username'] ?>" id="linkProfilePerson">
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
                                        <a tabindex="0" role="button" data-toggle="popover" data-trigger="focus" data-content="And here's some amazing content. It's very engaging. Right?" title="Options"><i class="fas fa-ellipsis-h" title="Options"></i></a>
                                        <?php
                                        $date = new DateTime($datos['datePost']);
                                        echo "<small>" . $date->format('G:ia d-m') . "</small>";
                                        ?>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <p><?php echo $datos['text'] ?></p>
                                </div>
                                <div>
                                    <?php $foto = explode('.', $datos['photoPost']);
                                    if (end($foto) != '') { ?>
                                        <img src='<?php echo $datos['photoPost'] ?>' class="w-100 rounded">
                                    <?php } ?>
                                </div>
                                <div id="shareIcons">
                                    <i class="far fa-heart m-3" style="cursor: pointer;" title="Like"></i>
                                    <i class="far fa-comment m-3" style="cursor: pointer" title="Comment"></i>
                                    <img src="web/images/share.png" class="m-3" alt="" title="Share">
                                </div>
                            </div>
                    <?php

                        }
                    } else {
                        echo "<div class='text-center mt-4'><h3>Welcome to my web</h3><p>This is the best place to see what’s happening in your world. Find some people and topics to follow now.</p></div>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- MOSTRAR POST -->
    </div>
    <aside id="rightContainer" class="d-none d-xl-block">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos amet quia necessitatibus consequatur doloremque qui fuga deleniti aperiam ducimus beatae quas excepturi voluptates a nam, magnam dolorem omnis consequuntur inventore!</p>
    </aside>
</main>

<!--   Recogemos contenido para mostrarlo con el header -->
<?php $contenido = ob_get_clean(); ?>

<?php include 'header.php' ?>