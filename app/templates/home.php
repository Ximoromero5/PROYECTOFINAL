<?php ob_start(); ?>
<!-- Preloader de la página -->
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
        <!-- <p id="pruebaXimo">Session ID: <?php echo $_SESSION['datos'][0]['id']; ?></p>
        <p> <a tabindex="0" role="button" data-trigger="focus" data-toggle="popover" id="popoverOptions"><i class="fas fa-ellipsis-h icono"></i></a></p> -->
        <!-- AddToAny BEGIN -->
        <!--       <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
            <a class="a2a_dd" href="https://www.addtoany.com/share"></a>
        </div>
        <script async src="https://static.addtoany.com/menu/page.js"></script> -->
        <!-- AddToAny END -->
        <h1>Title of sidebar</h1>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsum omnis sapiente nemo dolorem animi facilis reprehenderit fugiat molestiae dolore debitis. Cupiditate placeat odit blanditiis et praesentium eaque a sint sed.</p>
    </aside>
    <!-- Contenedor para escribir un post -->
    <div id="containerWrite">

        <!-- Aquí se recogen los datos que escriba el usuario (texto del post, imágen del post, y se controla cuando hace click en publicar) -->
        <form method="POST" enctype="multipart/form-data" id="formularioPost" name="formularioPost">
            <div id="top">
                <img src="<?php echo $_SESSION['datos'][0]['photo']; ?>" alt="">
                <textarea placeholder="What are you thinking about?" maxlength="250" name="textPost" id="textPost" data-emoji-picker="true"></textarea>
                <input type="file" id="photoPost" name="photoPost" class="d-none">
            </div>
            <div id="bottom" class="mb-4">
                <div id="containerIconsWrite">
                    <div class="iconsWrite" id="iconSelector">
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
                    <button id="addPostButton" name="addPostButton">
                        <!-- <i class="flaticon-right-arrow"></i> --> Publish</button>
                </div>
            </div>
        </form>

        <!-- MOSTRAR POST -->
        <div class="panel panel-default">
            <div class="panel-body">
                <div id="postList"></div>
            </div>
        </div>
        <!-- MOSTRAR POST -->
    </div>
    <aside id="rightContainer" class="d-none d-xl-block">
        <h1>Title of sidebar</h1>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos amet quia necessitatibus consequatur doloremque qui fuga deleniti aperiam ducimus beatae quas excepturi voluptates a nam, magnam dolorem omnis consequuntur inventore!</p>
    </aside>
</main>

<!--   Recogemos contenido para mostrarlo con el header -->
<?php $contenido = ob_get_clean(); ?>

<?php include 'header.php' ?>