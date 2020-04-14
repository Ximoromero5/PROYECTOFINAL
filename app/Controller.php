<?php
include('libs/functions.php');
include('Validar.php');
include('Sesion.php');

class Controller
{

    public function home()
    {
        if (isset($_SESSION['username'])) {
            try {
                $model = new Model();
                $parametros = array(
                    'datos' => array()
                );
            } catch (Exception $e) {
                error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logException.txt");
                header('Location: error');
            } catch (Error $e) {
                error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
                header('Location: error');
            }
            require __DIR__ . '/templates/home.php';
        } else {
            header('Location: login');
        }
    }

    public function error()
    {
        require __DIR__ . '/templates/error.php';
    }

    public function login()
    {
        include('googleConfig.php');
        if (!isset($_SESSION['username'])) {

            try {
                $parametros = array(
                    'username' => '',
                    'password' => '',
                    'datos' => array(),
                    'mensaje' => '',
                    'loginButton' => ''
                );

                $model = new Model();
                $validate = new Validation();

                if (isset($_POST['loginButton'])) {

                    //Obtenemos los datos del formulario
                    $username = getData('username');
                    $password = getData('password');
                    $finalPassword = crypt($password, '$2a$09$anexamplestringforsaleLouKejcjRlExmf1671qw3Khl49R3dfu');
                    $data = $_POST;

                    //Botón de recordar datos
                    if (!empty($_POST["rememberButton"])) {
                        setcookie("userCookie", $username, time() + (10 * 365 * 24 * 60 * 60));
                        setcookie("passwordCookie", $password, time() + (10 * 365 * 24 * 60 * 60));
                    } else {
                        isset($_COOKIE["userCookie"]) ? setcookie('userCookie', '') : '';
                        isset($_COOKIE["passwordCookie"]) ? setcookie('passwordCookie', '') : '';
                    }

                    $rule = array(
                        array(
                            'name' => 'username',
                            'regla' => 'no-empty'
                        ),
                        array(
                            'name' => 'password',
                            'regla' => 'no-empty'
                        )
                    );

                    $validations = $validate->rules($rule, $data);

                    if ($validations === true) {
                        $parametros['datos'] = $model->login($username, $finalPassword);

                        if ($parametros['datos']) {
                            $Sesion = new Sesion();
                            $Sesion->setSesion('username', $username);
                            $Sesion->setSesion('datos', $parametros['datos']);
                            $_SESSION['permissions'] = 1;
                            header('Location: home');
                        } else {
                            $parametros['mensaje'] = 'That was an invalid email address or password.';
                        }
                    } else {
                        $parametros['mensaje'] = 'You must fill all the fields.';
                    }
                } else {

                    if (isset($_GET['code'])) {
                        $token = $googleClient->fetchAccessTokenWithAuthCode($_GET['code']);

                        if (!isset($token['error'])) {
                            $Sesion = new Sesion();
                            $googleClient->setAccessToken($token['access_token']);
                            $Sesion->setSesion('access_token', $token['access_token']);

                            //Obtener información del cliente
                            $googleService = new Google_Service_Oauth2($googleClient);
                            $parametros['datos'] = $googleService->userinfo->get();

                            //Iniciar variables sesión
                            $Sesion->setSesion('datos', $parametros['datos']);
                            $_SESSION['permissions'] = 1;
                        }
                    }
                    if (!isset($_SESSION['access_token'])) {
                        $parametros['loginButton'] = $googleClient->createAuthUrl();
                    }
                }
            } catch (Exception $e) {
                error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logException.txt");
                header('Location: error');
            } catch (Error $e) {
                error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
                header('Location: error');
            }
        } else {
            header('Location: home');
        }
        require __DIR__ . '/templates/loginForm.php';
    }

    public function register()
    {
        try {
            $parametros = array(
                'username' => '',
                'email' => '',
                'password' => '',
                'resultado' => array(),
                'mensaje' => '',
                'exito' => ''
            );

            $model = new Model();
            $validate = new Validation();

            if (isset($_POST['registerButton'])) {

                //recogemos los datos del formulario
                $gender = $_POST['gender'];
                $username = getData('username');
                $email = getData('email');
                $password = getData('password');
                $finalPassword = crypt($password, '$2a$09$anexamplestringforsaleLouKejcjRlExmf1671qw3Khl49R3dfu');
                $data = $_POST;

                $rules = array(
                    array(
                        'name' => 'username',
                        'regla' => 'no-empty'
                    ),
                    array(
                        'name' => 'email',
                        'regla' => 'no-empty, email'
                    ),
                    array(
                        'name' => 'password',
                        'regla' => 'no-empty, password'
                    )
                );

                $validations = $validate->rules($rules, $data);

                if ($validations === true) {
                    //Comprobamos si existe el usuario o email
                    if ($model->userExists($username)) {
                        $parametros['mensaje'] = 'The user already exists!';
                    } else if ($model->emailExists($email)) {
                        $parametros['mensaje'] = 'The email already exists!';
                    } else {
                        $profilePhoto = Config::$defaultImage;
                        $coverPhoto = Config::$defaultCoverImage;
                        if ($model->register($username, $email, $finalPassword, $gender, $profilePhoto, $coverPhoto, date('Y-m-d'))) {
                            $parametros['exito'] = 'User registered successfully.';
                            header('Refresh: 2; login');
                        } else {
                            $parametros['mensaje'] = 'An error has occurred while registering, please check the data.';
                        }
                    }
                } else {
                    foreach ($validations as $key => $errors) {
                        foreach ($errors as $error => $key2) {
                            foreach ($key2 as $end) {
                                $parametros['mensaje'] .= $end . "<br>";
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logException.txt");
            header('Location: error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: error');
        }
        require __DIR__ . '/templates/registerForm.php';
    }

    public function closeSesion()
    {
        $Sesion = new Sesion();
        $Sesion->closeSesion();
        header('Location: login');
    }

    public function forgotPassword()
    {
        try {
            $parametros = array(
                'mensaje' => '',
                'exito' => ''
            );

            $model = new Model();
            $validate = new Validation();

            if (isset($_POST['send'])) {
                $email = getData('email');
                $data = $_POST;

                $rules = array(
                    array(
                        'name' => 'email',
                        'regla' => 'no-empty, email'
                    )
                );

                $validations = $validate->rules($rules, $data);

                if ($validations === true) {
                    if (count($userData = $model->checkEmail($email)) == 1) {
                        foreach ($userData as $row) {
                            //Si existe el email introducido
                            $id = $row['id'];
                            $email = $row['email'];
                            $token = uniqid(md5(time()));

                            //Inserto los datos en la tabla passwordrecovery
                            if ($model->insertPasswordRecovery($id, $email, $token)) {

                                //Enviamos el correo para restablecer la contraseña
                                $from = "admin@admin.com";
                                $to = $email;
                                $subject = "Reset your password";
                                $message = " <!DOCTYPE html>
                                            <html>
                                            <head>
                                             <title></title>
                                            </head>
                                            <body>
                                            <h2>Click the link below to reset your password: </h2><br>
                                            <a href='http://localhost/web/index.php?action=resetPassword&token=" . $token . "'>Click here to reset your password</a>
                                            </body>
                                            </html>";

                                $headers  = "MIME-Version: 1.0\r\n";
                                $headers .= "Content-type: text/html; charset=utf-8\r\n";
                                $headers .= "From:" . $from;
                                mail($to, $subject, $message, $headers) ? $parametros['exito'] = "Message sent successfully!" : $parametros['mensaje'] = "Error to send email!";
                            }
                        }
                    } else {
                        $parametros['mensaje'] = "The email entered does not exist!";
                    }
                } else {
                    foreach ($validations as $key => $errors) {
                        foreach ($errors as $error => $key2) {
                            foreach ($key2 as $end) {
                                $parametros['mensaje'] .= $end . "<br>";
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logException.txt");
            header('Location: error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: error');
        }
        require __DIR__ . '/templates/forgotPassword.php';
    }

    public function resetPassword()
    {
        try {
            $parametros = array(
                'mensaje' => '',
                'exito' => '',
                'token' => ''
            );

            $model = new Model();
            $validate = new Validation();

            //Verificamos que existe el token en la url
            if (isset($_GET['token'])) {
                $token = $_GET['token'];

                if (count($userData = $model->checkToken($token)) == 1) {
                    foreach ($userData as $row) {
                        $token = $row['token'];
                        $email = $row['email'];
                        $parametros['token'] = $token; //Pasamos el token por mensaje para pasarlo a la url de resetPassword

                        //Recojemos la nueva contraseña, actualizamos la contraseña y borramos el token
                        if (isset($_POST['reset'])) {
                            $password = getData('password');
                            $passwordRepeat = getData('passwordRepeat');
                            $data = $_POST;

                            //Validación de los datos
                            $rules = array(
                                array(
                                    'name' => 'password',
                                    'regla' => 'no-empty'
                                ),
                                array(
                                    'name' => 'passwordRepeat',
                                    'regla' => 'no-empty'
                                )
                            );

                            $validations = $validate->rules($rules, $data);
                            if ($validations === true) {
                                if ($password != $passwordRepeat) {
                                    $parametros['mensaje'] = "The passwords doesn't match!";
                                } else {
                                    $encryptedPassword = crypt($password, '$2a$09$anexamplestringforsaleLouKejcjRlExmf1671qw3Khl49R3dfu');
                                    $model->updatePassword($email, $encryptedPassword);

                                    //Ejecutamos el metodo para actualizar contraseña y borrar token
                                    if ($model->deleteToken($email)) {
                                        $parametros['exito'] = 'The password has been updated successfully!';
                                        header('Refresh: 2; login');
                                    } else {
                                        $parametros['mensaje'] = "Error updating password!";
                                    }
                                }
                            } else {
                                foreach ($validations as $key => $errors) {
                                    foreach ($errors as $error => $key2) {
                                        foreach ($key2 as $end) {
                                            $parametros['mensaje'] .= $end . "<br>";
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $parametros['mensaje'] = "The token is incorrect!";
                }
            } else {
                header('Location: login');
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logException.txt");
            header('Location: error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: error');
        }
        require __DIR__ . '/templates/resetPassword.php';
    }

    public function profile()
    {
        try {
            $parametros = array(
                'mensaje' => '',
                'exito' => '',
                'errores' => array()
            );

            $model = new Model();

            //Actualizar datos de usuarios
            $id = $_REQUEST['id'];
            $city = $_REQUEST['city'];
            $gender = $_REQUEST['gender'];
            $birthday = $_REQUEST['birthday'];
            $firstName = $_REQUEST['firstName'];
            $lastName = $_REQUEST['lastName'];
            $description = $_REQUEST['description'];

            if ($model->updateProfile($id, $city, $gender, $birthday, $firstName, $lastName, $description)) {
                echo json_encode(array('success' => 1));
                $Sesion = new Sesion();
                $Sesion->setSesion('datos', $model->getDataUser($id));
            } else {
                echo json_encode(array('success' => 0));
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logException.txt");
            header('Location: error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: error');
        }
        require __DIR__ . '/templates/profile.php';
    }

    public function profilePhoto()
    {
        try {
            $model = new Model();

            $parametros = array(
                'mensaje' => '',
                'exito' => '',
                'errores' => array()
            );

            //Al enviar el formulario foto perfil
            if (isset($_REQUEST['upload'])) {

                //Actualizar foto de perfil
                $id = $_REQUEST['id'];
                $photoName = devuelveImagen('photo', Config::$imgPath, $parametros['errores'], Config::$validExtensions);
                if ($model->updatePhoto($id, $photoName)) {
                    $Sesion = new Sesion();
                    $Sesion->setSesion('datos', $model->getDataUser($id));
                    $parametros['exito'] = 'Profile photo updated successfully!';
                } else {
                    $parametros['mensaje'] = 'Error updating profile picture!';
                }
            }


            //Al enviar el formulario foto cover
            if (isset($_REQUEST['uploadCover'])) {

                //Actualizar foto de perfil
                $id = $_REQUEST['id'];
                $photoName = devuelveImagen('cover', Config::$imgPath, $parametros['errores'], Config::$validExtensions);
                if ($model->updatePhotoCover($id, $photoName)) {
                    $Sesion = new Sesion();
                    $Sesion->setSesion('datos', $model->getDataUser($id));
                    $parametros['exito'] = 'Profile cover photo updated successfully!';
                } else {
                    $parametros['mensaje'] = 'Error updating cover photo picture!';
                }
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logException.txt");
            header('Location: error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: error');
        }
        require __DIR__ . '/templates/profile.php';
    }

    //Parte de los post, añadir un post
    public function addPost()
    {
        try {
            $parametros = array(
                'errores' => array()
            );
            //Instanciamos clases necesariass
            $model = new Model();
            $id = $_SESSION['datos'][0]['id'];
            $postText = $_REQUEST['textPost'];
            $photoPost = "";
            $datePost = date("Y-m-d H:i:s");

            /* Getting file name */
            $photoPost = devuelveImagen('photoPost', Config::$imgPath, $parametros['errores'], Config::$validExtensions);

            if ($photoPost == '' && $postText != '') {
                $photoPost = "";
            }

            //Añadimos el post
            if ($model->addPost($id, $postText, $photoPost, $datePost)) {
                echo 'true';
            } else {
                echo 'false';
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logException.txt");
            header('Location: error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: error');
        }
    }

    //Visitar el perfil de alguien
    public function user()
    {
        try {
            $model = new Model();
            $datosUser = []; //Recojo los datos del usuario mediante el username en un array

            //Obtenemos el username del usuario que estamos visitando
            if (isset($_GET['person'])) {
                if ($model->userExists($_GET['person'])) {
                    $username = $_GET['person'];
                    $datosUser = $model->getInfoUser($username);
                } else {
                    $datosUser = "The user doesn't exist";
                }
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logException.txt");
            header('Location: error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: error');
        }
        require __DIR__ . '/templates/user.php';
    }

    public function getPostUser()
    {
        try {
            $model = new Model();
            $datosUser = array();
            $postsUser = array();

            //Obtenemos el username del usuario que estamos visitando
            if (isset($_REQUEST['person'])) {
                if ($model->userExists($_REQUEST['person'])) {
                    $username = $_REQUEST['person'];
                    $datosUser = $model->getInfoUser($username);
                    $postsUser = $model->getPostUser($datosUser[0]['id']);
                } else {
                    $datosUser = "The user doesn't exist";
                    $postsUser = "No post";
                }
            }

            echo json_encode($postsUser);
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logException.txt");
            header('Location: error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: error');
        }
    }

    //Función que comprueba el botón de follow que poner
    public function checkFollow()
    {
        $model = new Model();
        $sesionId = null;
        $idUserProfile = null;
        $username = null;
        $datosUser = []; //Recojo los datos del usuario mediante el username en un array

        //Obtenemos el username del usuario que estamos visitando
        if (isset($_REQUEST['person'])) {
            $username = $_REQUEST['person'];
        }
        $datosUser = $model->getInfoUser($username);
        $sesionId = $_SESSION['datos'][0]['id']; //Id usuario sesión
        $idUserProfile = $datosUser[0]['id']; //Id persona a la que estamos visitando
        echo json_encode($model->checkFollow($idUserProfile, $sesionId) ? array('success' => 1, 'id' => $idUserProfile, 'nFollowing' => $model->countFollowing(), 'nFollowers' => $model->countFollowers()) : array('success' => 0, 'id' => $idUserProfile, 'nFollowing' => $model->countFollowing(), 'nFollowers' => $model->countFollowers()));
    }

    //Función para seguir a alguien
    public function follow()
    {
        $model = new Model();
        $id_user = $_REQUEST['id_user'];
        $sesionId = $_SESSION['datos'][0]['id']; //Id usuario sesión
        echo $model->follow($id_user, $sesionId) ? 'exito' : 'fallo';
    }

    //Función para dejar de seguir a alguien
    public function unfollow()
    {
        $model = new Model();
        $id_user = $_REQUEST['id_user'];
        $sesionId = $_SESSION['datos'][0]['id']; //Id usuario sesión
        $model->unSeeNotification($sesionId);
        echo $model->unfollow($id_user, $sesionId) ? 'exito' : 'fallo';
    }

    //Buscar en usuario
    public function header()
    {
        try {
            if (isset($_REQUEST['searchUser'])) {
                $username = $_REQUEST['searchUser'];

                //Ejecutamos la función que devuelve los usuarios
                $model = new Model();
                $resultado = $model->searchUser($username);

                echo json_encode($resultado);
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logException.txt");
            header('Location: error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: error');
        }
    }

    //Función para recibir los post con Ajax
    public function getPost()
    {
        try {
            $model = new Model();
            $resultado = $model->getPost($_SESSION['datos'][0]['id']);

            echo json_encode($resultado);
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logException.txt");
            header('Location: error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: error');
        }
    }

    //Función para dar like
    public function giveLike()
    {
        $model = new Model();
        $id = $_SESSION['datos'][0]['id'];
        $id_post = $_REQUEST['id_post'];

        if ($model->giveLike($id_post, $id)) {
            echo "exito";
        } else {
            echo "fallo";
        }
    }

    public function checkLike()
    {
        $model = new Model();
        $id = $_SESSION['datos'][0]['id'];
        $id_post = $_REQUEST['id_post'];

        if ($model->checkLike($id_post, $id) == true) {
            echo json_encode(array('true', $model->countLikes()));
        } else {
            echo json_encode(array('false', $model->countLikes()));
        }
    }

    public function removeLike()
    {
        $model = new Model();
        $id = $_SESSION['datos'][0]['id'];
        $id_post = $_REQUEST['id_post'];

        if ($model->removeLike($id_post, $id)) {
            echo "exito";
        } else {
            echo "fallo";
        }
    }

    public function checkNotification()
    {
        $model = new Model();

        if (isset($_REQUEST['view'])) {
            if ($_REQUEST['view'] != '') {
                $model->seeNotification($_SESSION['datos'][0]['id']);
            }

            $output = '';
            if ($model->checkNotification($_SESSION['datos'][0]['id']) === false) {
                $output .= '
                <li>
                    <a href="#0" class="text-bold text-italic">No notification found!</a>
                </li>
            ';
            } else {
                foreach ($model->checkNotification($_SESSION['datos'][0]['id']) as $data) {
                    $userData = $model->getDataUser($data['receiver_id']);
                    foreach ($userData as $userData) {
                        $output .= '
                    <li class="dropdown-item">
                        <a href="index.php?action=user&person=' . $userData['username'] . '">
                            <img src="' . $userData['photo'] . '"><strong>@' . $userData['username'] . '</strong><small> has started to follow you.</small>
                        </a>
                    </li>
                    ';
                    }
                }
            }
            $count = $model->checkUnseen($_SESSION['datos'][0]['id']);

            $data = array(
                'notificacion' => $output,
                'unseen' => $count
            );

            echo json_encode($data);
        }
    }
}
