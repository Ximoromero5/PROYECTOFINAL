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
                foreach ($_SESSION['datos'] as $key) {
                }
                //GET POSTS
                $parametros['datos'] =  $model->getPost($key['id']);
            } catch (Exception $e) {
                error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logException.txt");
                header('Location: index.php?action=error');
            } catch (Error $e) {
                error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
                header('Location: index.php?action=error');
            }
            require __DIR__ . '/templates/home.php';
        } else {
            header('Location: index.php?action=login');
        }
    }

    public function error()
    {
        require __DIR__ . '/templates/error.php';
    }

    public function login()
    {
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
                        isset($_COOKIE["password"]) ? setcookie('password', '') : '';
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
                        $parametros['mensaje'] = 'You must fill all the fields!';
                    }
                }

                require_once 'google-api-php-client/vendor/autoload.php';

                $googleClient = new Google_Client();

                $googleClient->setClientId(Config::$googleClientID);
                $googleClient->setClientSecret(Config::$googleClientSecretKey);
                $googleClient->setRedirectUri(Config::$googleRedirect);
                $googleClient->addScope("email");
                $googleClient->addScope("profile");

                if (isset($_GET['code'])) {
                    $token = $googleClient->fetchAccessTokenWithAuthCode($_GET['code']);
                    $googleClient->setAccessToken($token['access_token']);

                    //Obtener información del cliente
                    $googleService = new Google_Service($googleClient);
                    $parametros['datos'] = $googleService->userinfo->get();

                    //Iniciar variables sesión
                    $Sesion = new Sesion();
                    $Sesion->setSesion('username', $name);
                    $Sesion->setSesion('datos', $parametros['datos']);
                    /*   header('Location: index.php?action=home'); */
                } else {
                    $parametros['loginButton'] = "<a href='" . $googleClient->createAuthUrl() . "'>LOGIN WITH GOOGLE</a>";
                }
            } catch (Exception $e) {
                error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logException.txt");
                header('Location: index.php?action=error');
            } catch (Error $e) {
                error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
                header('Location: index.php?action=error');
            }
        } else {
            header('Location: index.php?action=home');
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
            header('Location: index.php?action=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: index.php?action=error');
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
                                        header('Refresh: 2; index.php?action=login');
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
                header('Location: index.php?action=login');
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logException.txt");
            header('Location: index.php?action=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: index.php?action=error');
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
            header('Location: index.php?action=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: index.php?action=error');
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
            header('Location: index.php?action=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: index.php?action=error');
        }
        require __DIR__ . '/templates/profile.php';
    }

    //Parte de los post, añadir un post
    public function addPost()
    {
        try {
            //Instanciamos clases necesariass
            $model = new Model();
            $name = ' ';
            //Comprobamos que exista el campo oculto action
            if (isset($_FILES['photoPost']) && $_FILES["photoPost"] != '') {

                //Recojo foto si hay
                $test = explode('.', $_FILES["photoPost"]["name"]);
                $extension = end($test);
                $name = rand(100, 9999) . '.' . $extension;
                $location = Config::$imgPath . $name;
                move_uploaded_file($_FILES["photoPost"]["tmp_name"], $location);
            }

            //ADD POST

            $id = '';
            foreach ($_SESSION['datos'] as $row) {
                $id = $row['id'];
            }
            $data = array(
                ':id_user' => $id,
                ':text' => $_POST['postText'],
                ':photoPost' => $location,
                ':datePost' => date('Y-m-d') . ' ' . date("H:i:s", strtotime(date('h:i:sa')))
            );
            $model->addPostMix($data);
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logException.txt");
            header('Location: index.php?action=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: index.php?action=error');
        }
        require __DIR__ . '/templates/home.php';
    }

    //Visitar el perfil de alguien
    public function peopleProfile()
    {
        try {
            if (isset($_GET['person'])) {
                $username = $_GET['person'];
            }

            if (isset($_REQUEST['sender_id'])) {
                $sender_id = $_REQUEST['sender_id'];
            }

            //Recojemos el idSender y el reciver ENVIADOS POR AJAX
            foreach ($_SESSION['datos'] as $datoSesion) {
                $receiver_id = $datoSesion['id'];
            }

            $parametros = array(
                'datos' => array(),
                'botonFollow' => '',
                'error' => ''
            );

            $model = new Model();

            if (count($model->getInfoUser($username)) == 1) {
                $parametros['datos'] = $model->getInfoUser($username);
            }
            foreach ($parametros['datos'] as $dato) {
                if ($model->followButton($dato['id'], $receiver_id) > 0) {
                    $parametros['botonFollow'] = '
                    <button name="followButton" class="btn btn-danger" data-action="unfollow" data-sender_id="' . $dato['id'] . '" id="buttonUnfollow">Unfollow <i class="fas fa-user-minus ml-1"></i></button>
                ';
                } else {
                    $parametros['botonFollow'] = '
                <button name="followButton" class="btn btn-primary" data-action="follow" data-sender_id="' . $dato['id'] . '" id="buttonFollow">Follow <i class="fas fa-user-plus ml-1"></i></button>
                ';
                }
            }

            if ($_REQUEST['action'] == 'follow') {
                $model->follow($sender_id, $receiver_id);
            }
            if ($_REQUEST['action'] == 'unfollow') {
                $model->unfollow($sender_id, $receiver_id);
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logException.txt");
            header('Location: index.php?action=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: index.php?action=error');
        }
        require __DIR__ . '/templates/peopleProfile.php';
    }

    //Buscar en usuario
    public function header()
    {
        try {
            $model = new Model();
            $datos = '';
            if (isset($_REQUEST['searchUser'])) {
                $username = $_REQUEST['searchUser'];
            }

            $resultado = $model->searchUser($username);
            foreach ($resultado as $dato) {
                echo json_encode(array('d' => $dato['username']));
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logException.txt");
            header('Location: index.php?action=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: index.php?action=error');
        }
        /* require __DIR__ . '/templates/header.php'; */
    }
}
