<?php
include_once('Config.php');

class Model extends PDO
{
    protected $conexion;

    public function __construct()
    {
        $this->conexion = new PDO('mysql:host=' . Config::$dbHost . ';dbname=' . Config::$dbName . '', Config::$dbUser, Config::$dbPassword);
        $this->conexion->exec("SET NAMES UTF-8");
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    //Funciones del modelo
    public function register($username, $email, $password, $gender, $photo, $photoCover, $joinDate)
    {
        $consulta = "INSERT INTO users (username, email, password, gender, photo, coverPhoto, joinDate) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->bindParam(1, $username);
        $resultado->bindParam(2, $email);
        $resultado->bindParam(3, $password);
        $resultado->bindParam(4, $gender);
        $resultado->bindParam(5, $photo);
        $resultado->bindParam(6, $photoCover);
        $resultado->bindParam(7, $joinDate);

        $resultado->execute();
        $contador = $resultado->rowCount();
        return $contador == 1 ? true : false;
    }

    //Función para el inicio de sesión
    public function login($username, $password)
    {
        $consulta = "SELECT * FROM users WHERE username = :username AND password = :password";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->bindParam(':username', $username);
        $resultado->bindParam(':password', $password);
        $resultado->execute();

        return $resultado->fetchAll();
    }

    //Función para comprobar si existe el usuario
    public function userExists($username)
    {
        $consulta = "SELECT * FROM users WHERE username = '$username'";
        $resultado = $this->conexion->query($consulta);

        return count($resultado->fetchAll()) == 1 ? true : false;
    }

    //Función para comprobar si existe el email
    public function emailExists($email)
    {
        $consulta = "SELECT * FROM users WHERE email = '$email'";
        $resultado = $this->conexion->query($consulta);

        return count($resultado->fetchAll()) == 1 ? true : false;
    }

    //Borrar función ya está arriba ^^^^^^^
    public function checkEmail($email)
    {
        $consulta = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->bindParam(':email', $email);
        $resultado->execute();

        return $resultado->fetchAll();
    }

    //Función que inserta el token para recuperar la contraseña
    public function insertPasswordRecovery($id, $email, $token)
    {
        $consulta = "INSERT INTO passwordrecovery (id, email, token) VALUES ('$id', '$email', '$token')";
        $resultado = $this->conexion->query($consulta);

        return count($resultado->fetchAll()) == 1 ? true : false;
    }

    //Función que valida que exista el token
    public function checkToken($token)
    {
        $consulta = "SELECT * FROM passwordrecovery WHERE token = '$token'";
        $resultado = $this->conexion->query($consulta);

        return $resultado->fetchAll();
    }

    //Función que actualiza la contraseña
    public function updatePassword($email, $password)
    {
        $consulta = "UPDATE users SET password = '$password' WHERE email = '$email'";
        $resultado = $this->conexion->query($consulta);

        return count($resultado->fetchAll()) == 1 ? true : false;
    }

    //Función que elimina el token
    public function deleteToken($email)
    {
        $consulta = "DELETE FROM passwordrecovery WHERE email = '$email'";
        $resultado = $this->conexion->query($consulta);

        return count($resultado->fetchAll()) == 1 ? true : false;
    }

    //Función que actualiza el perfil del usuario
    public function updateProfile($id, $city, $gender, $birthday, $firstName, $lastName, $description)
    {
        $consulta = "UPDATE users SET city = '$city', gender = '$gender', birthday = '$birthday', firstName = '$firstName', lastName = '$lastName', description = '$description' WHERE id = '$id'";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();

        return $resultado->rowCount() == 1 ? true : false;
    }

    //Función que actualiza la foto de perfil
    public function updatePhoto($id, $photo)
    {
        $consulta = "UPDATE users SET photo = '$photo' WHERE id = '$id'";
        $resultado = $this->conexion->query($consulta);

        return $resultado->rowCount() == 1 ? true : false;
    }

    //Función que actualiza la foto de fondo
    public function updatePhotoCover($id, $photo)
    {
        $consulta = "UPDATE users SET coverPhoto = '$photo' WHERE id = '$id'";
        $resultado = $this->conexion->query($consulta);

        return $resultado->rowCount() == 1 ? true : false;
    }

    //Función que obtiene los datos de un usuario especifico mediante el id
    public function getDataUser($id)
    {
        $consulta = "SELECT * FROM users WHERE id = '$id'";
        $resultado = $this->conexion->query($consulta);

        return $resultado->fetchAll();
    }

    //Función para añadir un post //MEJORAR
    public function addPostMix($data)
    {
        $consulta = "INSERT INTO posts (id_user, photoPost, text, datePost) VALUES (:id_user, :photoPost, :text, :datePost)";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute($data);
    }

    //Función para obtener los post de las personas que sigues
    public function getPost($idSesion)
    {
        $consulta = "SELECT * FROM posts INNER JOIN users ON users.id = posts.id_user LEFT JOIN follower ON follower.sender_id = posts.id_user WHERE follower.receiver_id = '$idSesion' OR posts.id_user = '$idSesion' GROUP BY posts.id ORDER BY posts.id DESC";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();

        return $resultado->fetchAll();
    }

    //Función que obtiene los datos de un usuario especifico mediante el username
    public function getInfoUser($username)
    {
        $consulta = "SELECT * FROM users WHERE username = '$username'";
        $resultado = $this->conexion->query($consulta);

        return $resultado->fetchAll();
    }

    //MEJORAR
    public function followButton($sender_id, $receiver_id)
    {
        $consulta = "SELECT * FROM follower WHERE sender_id = '$sender_id' AND receiver_id = '$receiver_id'";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        $count = $resultado->rowCount();

        return $count;
    }

    //MEJORAR
    public function follow($sender, $receiver)
    {
        $consulta = "INSERT INTO follower (sender_id, receiver_id) VALUES ('$sender', '$receiver')";
        $resultado = $this->conexion->prepare($consulta);
        if ($resultado->execute()) {

            //Sumar uno seguidor
            $subConsulta = "UPDATE users SET numberFollowers = numberFollowers + 1 WHERE id = '$sender'";
            $resultado = $this->conexion->prepare($subConsulta);
            $resultado->execute();

            //Sumar uno a siguiendo
            $subConsultaDos = "UPDATE users SET numberFollowing = numberFollowing + 1 WHERE id = '$receiver'";
            $resultado = $this->conexion->prepare($subConsultaDos);
            $resultado->execute();
        }
    }

    //MEJORAR
    public function unfollow($sender, $receiver)
    {
        $consulta = "DELETE FROM follower WHERE sender_id = '$sender' AND receiver_id = '$receiver'";
        $resultado = $this->conexion->prepare($consulta);
        if ($resultado->execute()) {

            //Restar uno seguidor
            $subConsulta = "UPDATE users SET numberFollowers = numberFollowers - 1 WHERE id = '$sender'";
            $resultado = $this->conexion->prepare($subConsulta);
            $resultado->execute();

            //Restar uno a siguiendo
            $subConsultaDos = "UPDATE users SET numberFollowing = numberFollowing - 1 WHERE id = '$receiver'";
            $resultado = $this->conexion->prepare($subConsultaDos);
            $resultado->execute();
        }
    }

    //Función para buscar usuarios
    public function searchUser($username)
    {
        $consulta = "SELECT * FROM users WHERE username LIKE '%" . $username . "%'";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();

        return $resultado->fetchAll();
    }
}
