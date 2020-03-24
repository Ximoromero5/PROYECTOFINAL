<?php foreach ($_SESSION['datos'] as $datos) { ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="<?php echo 'web/css/' . Config::$dbCss ?>">
        <title>Home</title>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-light p-3">

            <!-- Icono para mostrar el menú en vista móvil -->
            <a class="navbar-toggler border-0" data-toggle="collapse" data-target="#hiddenNavbar" aria-controls="hiddenNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <img src="web/images/menu1.png" alt="" width="30" height="30">
            </a>

            <!--  Menú horizontal -->
            <div class="collapse navbar-collapse" id="hiddenNavbar">
                <div class="ml-4">
                    <a class="navbar-brand d-none d-lg-block" href="home"><img src="web/images/linkedin.png" alt="" width="35" height="35"></a>
                </div>
                <ul class="navbar-nav">
                    <div id="searcher" class="my-3 my-lg-0">
                        <img src="web/images/search.png" alt="" width="17" height="17">
                        <input class="nav-item" type="search" placeholder="Search" aria-label="Search" id="searchUser">
                    </div>
                    <ul class="list-group" id="showUsers"></ul>

                    <li class="nav-item mb-2 mb-lg-0">
                        <a class="nav-link" href="home"><img src="web/images/home.png" width="20" height="20" alt="" class="mr-2"> Home</a>
                    </li>
                    <li class="nav-item mb-2 mb-lg-0">
                        <a class="nav-link" href="#"><i class="far fa-user mr-2"></i>People</a>
                    </li>
                    <li class="nav-item mb-2 mb-lg-0">
                        <a class="nav-link" href="#"><i class="far fa-comment mr-2"></i>Messaging</a>
                    </li>
                    <li class="nav-item mb-2 mb-lg-0">
                        <a class="nav-link" href="#"><i class="far fa-bell mr-2"></i>Notifications</a>
                    </li>
                    <li class="nav-item mb-2 mb-lg-0">
                        <a class="nav-link" href="#"><i class="fas fa-code-branch mr-2"></i>Work</a>
                    </li>
                </ul>
                <div class="mr-4" id="headerPhoto">
                    <a href="profile">
                        <?php echo "<img src=" . $datos['photo'] . " class='profilePhoto mr-2 rounded-circle'>" ?>
                    </a>
                </div>
            </div>
        </nav>

        <!--   Aquí va el contenido de la página -->
    <?php }
echo isset($contenido) ? $contenido : '' ?>

    <!-- SCRIPTS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <script src="https://kit.fontawesome.com/f32dfec8d8.js" crossorigin="anonymous"></script>
    <script src="web/js/app.js"></script>
    <!-- SCRIPTS -->

    </body>

    </html>