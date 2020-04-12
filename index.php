<?php

require_once __DIR__ . '/app/Config.php';
require_once __DIR__ . '/app/Model.php';
require_once __DIR__ . '/app/Controller.php';

$Sesion = new Sesion();
!isset($_SESSION['permissions']) ? ($_SESSION['permissions'] = 0) : '';

$map = array(
    'home' => array('controller' => 'Controller', 'action' => 'home', 'acceso' => 1),
    'login' => array('controller' => 'Controller', 'action' => 'login', 'acceso' => 0),
    'register' => array('controller' => 'Controller', 'action' => 'register', 'acceso' => 0),
    'closeSesion' => array('controller' => 'Controller', 'action' => 'closeSesion', 'acceso' => 1),
    'forgotPassword' => array('controller' => 'Controller', 'action' => 'forgotPassword', 'acceso' => 0),
    'resetPassword' => array('controller' => 'Controller', 'action' => 'resetPassword', 'acceso' => 0),
    'profile' => array('controller' => 'Controller', 'action' => 'profile', 'acceso' => 1),
    'profilePhoto' => array('controller' => 'Controller', 'action' => 'profilePhoto', 'acceso' => 1),
    'addPost' => array('controller' => 'Controller', 'action' => 'addPost', 'acceso' => 1),
    'getPost' => array('controller' => 'Controller', 'action' => 'getPost', 'acceso' => 1),
    'user' => array('controller' => 'Controller', 'action' => 'user', 'acceso' => 1),
    'header' => array('controller' => 'Controller', 'action' => 'header', 'acceso' => 1),
    'giveLike' => array('controller' => 'Controller', 'action' => 'giveLike', 'acceso' => 1),
    'removeLike' => array('controller' => 'Controller', 'action' => 'removeLike', 'acceso' => 1),
    'checkLike' => array('controller' => 'Controller', 'action' => 'checkLike', 'acceso' => 1),
    'checkFollow' => array('controller' => 'Controller', 'action' => 'checkFollow', 'acceso' => 1),
    'follow' => array('controller' => 'Controller', 'action' => 'follow', 'acceso' => 1),
    'unfollow' => array('controller' => 'Controller', 'action' => 'unfollow', 'acceso' => 1),
    'checkNotification' => array('controller' => 'Controller', 'action' => 'checkNotification', 'acceso' => 1)
);

if (isset($_GET['action'])) {
    if (isset($map[$_GET['action']])) {
        $ruta = $_GET['action'];
    } else {
        header('Location: app/templates/404.php');
    }
} else {
    $ruta = 'login';
}
$controlador = $map[$ruta];

if (method_exists($controlador['controller'], $controlador['action'])) {
    if ($controlador['acceso'] <= intval($_SESSION['permissions'])) {
        call_user_func(array(
            new $controlador['controller'],
            $controlador['action']
        ));
    } else {
        header('Location: login');
    }
} else {
    header('Location: app/templates/404.php');
}
