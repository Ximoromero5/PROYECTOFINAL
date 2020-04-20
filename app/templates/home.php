<?php ob_start(); ?>

<main id="mainContainer">
    <aside id="leftContainer" class="d-none d-xl-block">
        <h1>Title of sidebar</h1>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsum omnis sapiente nemo dolorem animi facilis reprehenderit fugiat molestiae dolore debitis. Cupiditate placeat odit blanditiis et praesentium eaque a sint sed.</p>
        <a href="#" data-toggle="popover" title="Popover Header" data-content="Some content inside the popover">Toggle popover</a>
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