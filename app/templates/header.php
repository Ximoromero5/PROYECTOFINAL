<?php

foreach ($_SESSION['datos'] as $datos) { ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="web/css/font/flaticon.css">
        <link rel="stylesheet" type="text/css" href="<?php echo 'web/css/' . Config::$dbCss ?>">
        <title>Home</title>
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-light">

            <!-- Icono para mostrar el menú en vista móvil -->
            <a class="navbar-toggler border-0" id="navbarToggle" data-toggle="collapse" data-target="#hiddenNavbar" aria-controls="hiddenNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars icono"></i>
            </a>

            <!-- Icono principal -->
            <div class="ml-4" id="logoContainer">
                <a class="navbar-brand" href="home">
                    <!-- <img src="web/images/linkedin.png" alt="" width="35" height="35"> -->
                    <h4>logo.</h4>
                </a>
            </div>

            <div id="searcherMobileOpen">
                <i class="flaticon-magnifying-glass"></i>
            </div>
            <!-- Buscador de usuarios -->
            <div id="searcher" class="my-3 my-lg-0">
                <i class="flaticon-magnifying-glass"></i>
                <input class="nav-item" id="searchUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" placeholder="Searcher...">
                <div class="dropdown" id="dropdownSearchUsers"></div>
                <i class="flaticon-close" id="searcherMobileClose"></i>
            </div>

            <!--  Menú horizontal -->
            <div class="collapse navbar-collapse" id="hiddenNavbar">


                <ul class="navbar-nav" id="horizontalMenu">
                    <li class="nav-item mb-2 mb-lg-0">
                        <a class="nav-link" href="home">
                            <i class="flaticon-home icono mr-2"></i>Home</a>
                    </li>
                    <li class="nav-item mb-2 mb-lg-0">
                        <a class="nav-link" href="#0"> <i class="flaticon-user icono mr-2"></i> People</a>
                    </li>
                    <li class="nav-item mb-2 mb-lg-0">
                        <a class="nav-link" href="#0"> <i class="flaticon-speech-bubble icono mr-2"></i> Messaging</a>
                    </li>
                    <li class="nav-item mb-2 mb-lg-0">
                        <a class="nav-link" href="#0"> <i class="flaticon-alarm icono mr-2"></i> Notifications</a>
                    </li>
                    <!--  <li class="nav-item mb-2 mb-lg-0">
                        <a class="nav-link" href="#0"> <i class="flaticon-tools icono mr-2"></i> Work</a>
                    </li> -->
                </ul>
                <div class="mr-4" id="headerPhoto">
                    <a href="profile">
                        <?php echo "<img src=" . $datos['photo'] . " class='profilePhoto mr-2 rounded-circle'>" ?>
                    </a>
                    <div class="btn-group">
                        <i class="fas fa-chevron-down dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                        <div class="dropdown-menu dropdown-menu-right" id="optionsMenu">
                            <a href="profile" class="dropdown-item" title="View Profile" id="viewProfile">
                                <?php echo "<img src=" . $datos['photo'] . " class='mr-2 rounded-circle' width='40' height='40'> " ?>
                                <div>
                                    <h6><?php echo $datos['firstName'] ?></h6>
                                    <small>View your Profile</small>
                                </div>
                            </a>
                            <a href="" class="dropdown-item" title="Configuration" id="containerDropdown"> <i class="flaticon-gear"></i>
                                <h6>Configuration</h6>
                            </a>
                            <label for="checkDarkTheme" id="checkDarkThemeContainer">
                                <div class="dropdown-item" id="containerDropdown">
                                    <i class="fas fa-moon"></i>
                                    <h6>Dark Mode</h6>
                                    <label class="switch ml-3">
                                        <input type="checkbox" id="checkDarkTheme">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </label>
                            <a href="closeSesion" class="dropdown-item" title="Log Out" id="containerDropdown"> <i class="flaticon-logout"></i>
                                <h6>Log Out</h6>
                            </a>
                        </div>
                    </div>
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