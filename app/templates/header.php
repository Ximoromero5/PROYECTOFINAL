    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css">
        <link type="text/css" rel="stylesheet" href="web/css/lightGallery.css">
        <link rel="stylesheet" type="text/css" href="<?php echo 'web/css/' . Config::$dbCss ?>">
        <title>Home</title>
    </head>

    <body>
        <nav id="menu">

            <!-- Icono principal -->
            <div id="logoContainer">
                <a href="home">
                    <h4>facebook.</h4>
                </a>
            </div>

            <!-- Buscador de usuarios -->
            <div id="searchBarContainer">
                <div id="searchBar">
                    <i class="fas fa-search" id="searchIcon"></i>
                    <input type="text" id="searchUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" placeholder="Searcher...">
                    <div class="dropdown" id="dropdownSearchUsers"></div>
                </div>
                <div id="searchBarContainerList"></div>
            </div>

            <!--  Menú horizontal -->
            <div id="mainMenu">
                <ul id="horizontalMenu">
                    <li id="home">
                        <!-- Este icono solo está visible en modo móvil -->
                        <a href="home"><i class="fas fa-home"></i></a>
                    </li>
                    <li id="friends">
                        <a href="#0" data-toggle="tooltip" data-placement="bottom" title="Followers"><i class="fas fa-user-friends"></i></a>
                    </li>
                    <li>
                        <a href="chat" data-toggle="tooltip" data-placement="bottom" title="Messages"><i class="fas fa-envelope"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="#0" data-toggle="dropdown" data-placement="bottom" title="Notifications" class="dropdown-toggle" id="notificationLink"><i class="fas fa-bell"></i><span class="badge badge-primary badge-pill" id="pildoraNotificacion"></span></a>
                        <ul class="dropdown-menu pull-left" id="listaNotificaciones">
                            <li>
                                <p>Notifications</p>
                            </li>
                        </ul>
                    </li>
                    <li id="profileSection">
                        <div class="dropdown">
                            <a href="#0" class="dropdown-toggle" id="profile" data-toggle="dropdown">
                                <img src="<?php echo $_SESSION['datos'][0]['photo']; ?>" alt="">
                            </a>

                            <!-- Menú de opciones -->
                            <div class="dropdown-menu" aria-labelledby="profile">
                                <a href="profile" class="dropdown-item" id="dropdownProfile">
                                    <div class="dropdownProfile_interior">
                                        <img src="<?php echo $_SESSION['datos'][0]['photo']; ?>" alt="">
                                        <div>
                                            <h6><?php echo $_SESSION['datos'][0]['firstName'] . " " . $_SESSION['datos'][0]['lastName']; ?></h6>
                                            <small>View your Profile</small>
                                        </div>
                                    </div>
                                </a>
                                <a href="#0" class="dropdown-item">
                                    <i class="fas fa-cog"></i>
                                    <h6>Configuration</h6>
                                </a>
                                <label for="checkDarkTheme" id="checkDarkThemeContainer" class="dropdown-item">
                                    <i class="fas fa-moon"></i>
                                    <h6>Dark Mode</h6>
                                    <label class="switch">
                                        <input type="checkbox" id="checkDarkTheme">
                                        <span class="slider round"></span>
                                    </label>
                                </label>
                                <a href="closeSesion" class="dropdown-item"><i class="fas fa-sign-out-alt"></i>
                                    <h6>Log Out</h6>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <!--   Aquí va el contenido de la página -->
        <?php echo isset($contenido) ? $contenido : '' ?>

        <!-- SCRIPTS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.4/clipboard.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
        <script src="https://kit.fontawesome.com/f32dfec8d8.js" crossorigin="anonymous"></script>
        <script src="web/js/jquery.mousewheel.min.js"></script>
        <script src="web/js/picturefill.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.14/js/lightgallery-all.min.js" integrity="sha256-0q70xbZ3GMwdiseCj/wfChJhq/3wzpNdgZinlSxSw14=" crossorigin="anonymous"></script>
        <script src="web/js/app.js"></script>
        <script src="https://unpkg.com/lazysizes@4.0.1/lazysizes.js"></script>
        <!-- SCRIPTS -->

    </body>

    </html>