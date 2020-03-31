<?php ob_start(); ?>
<!-- Preloader de la página -->
<!-- <div class="a" style="--n: 5;" id="preloaderPage">
    <div class="dot" style="--i: 0;"></div>
    <div class="dot" style="--i: 1;"></div>
    <div class="dot" style="--i: 2;"></div>
    <div class="dot" style="--i: 3;"></div>
    <div class="dot" style="--i: 4;"></div>
</div> -->
<!-- <div class="loader loader--style1" title="0" id="preloaderPage">
    <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="40px" height="40px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
        <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
    s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634
    c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z" />
        <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0
    C22.32,8.481,24.301,9.057,26.013,10.047z">
            <animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite" />
        </path>
    </svg>
</div> -->
<!-- Preloader de la página -->
<main id="mainContainer">
    <aside id="leftContainer" class="d-none d-xl-block">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam ab repellendus illo corrupti tempore? Aspernatur, nostrum labore porro inventore, et quaerat impedit consequatur eum illum blanditiis architecto! Qui, quos numquam!</p>
    </aside>
    <!-- Contenedor para escribir un post -->
    <div id="containerWrite">

        <!-- Aquí se recogen los datos que escriba el usuario (texto del post, imágen del post, y se controla cuando hace click en publicar) -->
        <div id="top">
            <img src="<?php echo $_SESSION['datos'][0]['photo']; ?>" alt="">
            <textarea placeholder="What are you thinking about?" maxlength="250" name="postText" id="postText" onkeyup="this.style.height=this.scrollHeight+'px';"></textarea>
            <input type="file" id="photoPost" name="photoPost" class="d-none">
        </div>
        <div id="bottom" class="mb-4">
            <div id="containerIconsWrite">
                <div class="iconsWrite">
                    <i class="fas fa-smile m-2 icono"></i>
                    <h6>Emoji</h6>
                </div>
                <label for="photoPost">
                    <div class="iconsWrite">
                        <i class="fas fa-camera m-2 icono"></i>
                        <h6>Photo</h6>
                    </div>
                </label>
                <div class="iconsWrite">
                    <i class="fas fa-video m-2 icono"></i>
                    <h6>Video</h6>
                </div>
            </div>
            <div id="publishPostContainer">
                <button id="addPostButton">
                    <!-- <i class="flaticon-right-arrow"></i> --> Publish</button>
            </div>
        </div>

        <!-- MOSTRAR POST -->
        <div class="panel panel-default">
            <div class="panel-body">
                <div id="postList">
                    <?php
                    if (count($parametros['datos']) > 0) {
                        foreach ($parametros['datos'] as $datos) {
                            $verified = $datos['verified'] == '1' ? '<img src="web/images/check.png" id="verifiedCheck">' : '';
                    ?>
                            <div class="jumbotron" id="postContainer">
                                <div id="infoUser">
                                    <div id="userData">
                                        <a href="index.php?action=user&person=<?php echo $datos['username'] ?>" id="linkProfilePerson">
                                            <div id="userInfoPost">
                                                <img src='<?php echo $datos['photo'] ?>' alt=''>
                                                <div>
                                                    <h5><?php echo $datos['firstName'] . " " . $datos['lastName'] . $verified ?></h5>
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
                                        <img src='<?php echo $datos['photoPost'] ?>' class="w-100" data-toggle="modal" data-target="#modalProfilePhoto">
                                    <?php } ?>
                                    <div class="modal fade" id="modalProfilePhoto" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <img src="<?php echo $datos['photoPost'] ?>" alt="" class="w-100 h-100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="shareIcons">
                                    <div id="shareIcon">
                                        <i class="fas fa-share icono"></i>
                                        <span>Share</span>
                                    </div>
                                    <div id="commentIcon">
                                        <i class="far fa-comment icono"></i>
                                        <span>358</span>
                                    </div>
                                    <div id="likeIcon">
                                        <i class="far fa-heart icono"></i>
                                        <span>9,453 likes</span>
                                    </div>
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