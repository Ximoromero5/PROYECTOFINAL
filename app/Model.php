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

    //Función para recuperar contraseña
    public function checkEmail($email)
    {
        $consulta = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->bindParam(':email', $email);
        $resultado->execute();
        $count = $resultado->rowCount();

        return $count == 1 ? $resultado->fetchAll() : false;
    }


    //Función que inserta el token para recuperar la contraseña
    public function insertPasswordRecovery($id, $email, $token)
    {
        $consulta = "INSERT INTO passwordrecovery (id, email, token) VALUES (?, ?, ?)";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->bindParam(1, $id);
        $resultado->bindParam(2, $email);
        $resultado->bindParam(3, $token);
        $resultado->execute();
        $count = $resultado->rowCount();

        return $count == 1 ? true : false;
    }

    //Función que valida que exista el token
    public function checkToken($token)
    {
        $consulta = "SELECT * FROM passwordrecovery WHERE token = '$token'";
        $resultado = $this->conexion->query($consulta);
        $resultado->execute();
        $count = $resultado->rowCount();

        return $count == 1 ? $resultado->fetchAll() : false;
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
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        $count = $resultado->rowCount();

        return $count == 1 ? true : false;
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

    //Función que obtiene los datos de un usuario especifico mediante el username
    public function getUserData($id_user)
    {
        $consulta = "SELECT * FROM posts INNER JOIN users ON users.id = posts.id_user WHERE users.id = '$id_user'";
        $resultado = $this->conexion->query($consulta);

        return $resultado->fetchAll();
    }

    //Función para añadir un post
    public function addPost($id_user, $postText, $photoPost, $datePost)
    {
        $consulta = "INSERT INTO posts (id_user, photoPost, text, datePost) VALUES (:id_user, :photoPost, :text, :datePost)";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->bindParam(':id_user', $id_user);
        $resultado->bindParam(':photoPost', $photoPost);
        $resultado->bindParam(':text', $postText);
        $resultado->bindParam(':datePost', $datePost);

        $resultado->execute();
        return count($resultado->fetchAll()) == 1 ? true : false;
    }

    //Función para obtener los post de las personas que sigues
    public function getPost($idSesion, $start, $limit)
    {
        $consulta = "SELECT * FROM posts INNER JOIN users ON users.id = posts.id_user LEFT JOIN follower ON follower.sender_id = posts.id_user WHERE follower.receiver_id = '$idSesion' OR posts.id_user = '$idSesion' GROUP BY posts.datePost ORDER BY posts.datePost DESC LIMIT $start, $limit";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();

        return $resultado->fetchAll();
    }

    //Función que obtiene los datos de un usuario especifico mediante el id
    public function getPostUser($id_user, $start = 0, $limit = 5)
    {
        $consulta = "SELECT * FROM posts INNER JOIN users ON posts.id_user = '$id_user' AND users.id = '$id_user' ORDER BY datePost DESC LIMIT $start, $limit";
        $resultado = $this->conexion->query($consulta);

        return $resultado->fetchAll();
    }
    //Función que obtiene los datos de un usuario especifico mediante el username
    public function getInfoUser($username)
    {
        $consulta = "SELECT * FROM users WHERE username = '$username'";
        $resultado = $this->conexion->query($consulta);

        return $resultado->fetchAll();
    }

    //Función que comprueba si se está siguiendo a la persona, para poner un botón u otro
    public function checkFollow($sender_id, $receiver_id)
    {
        $consulta = "SELECT * FROM follower WHERE sender_id = '$sender_id' AND receiver_id = '$receiver_id'";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        $count = $resultado->rowCount();

        return $count == 1 ? true : false;
    }

    //Función para seguir a alguien
    public function follow($sender, $receiver)
    {
        $consulta = "INSERT INTO follower (sender_id, receiver_id) VALUES ('$sender', '$receiver')";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        $count = $resultado->rowCount();

        return $count == 1 ? true : false;
    }

    //Función para dejar de seguir a alguien
    public function unfollow($sender, $receiver)
    {
        $consulta = "DELETE FROM follower WHERE sender_id = '$sender' AND receiver_id = '$receiver'";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        $count = $resultado->rowCount();

        return $count == 1 ? true : false;
    }

    //Función para contar el número de seguidos
    public function countFollowing()
    {
        $consulta = "SELECT users.id, COUNT(follower.id_follower) AS nFollowing, GROUP_CONCAT(users.username SEPARATOR '|') AS nameFollower FROM users LEFT JOIN follower ON follower.receiver_id = users.id GROUP BY users.id DESC";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();

        return $resultado->fetchAll();
    }
    //Función para contar el número de seguidores 
    public function countFollowers()
    {
        $consulta = "SELECT users.id, COUNT(follower.id_follower) AS nFollowers, GROUP_CONCAT(users.username SEPARATOR '|') AS nameFollower FROM users LEFT JOIN follower ON follower.sender_id = users.id GROUP BY users.id DESC";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();

        return $resultado->fetchAll();
    }

    //Función para buscar usuarios
    public function searchUser($text)
    {
        $consulta = "SELECT * FROM users WHERE username LIKE '%" . $text . "%' OR firstName LIKE '%" . $text . "%' OR lastName LIKE '%" . $text . "%'";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();

        return $resultado->fetchAll();
    }

    //Función para dar like a un post
    public function giveLike($id_post, $id_user)
    {
        //Esta consulta permite insertar un like en la tabla de like post sin que se repita
        $consulta = "INSERT INTO postlike (id_user, id_post) SELECT $id_user, $id_post FROM posts WHERE EXISTS (SELECT id_post FROM posts WHERE id_post = $id_post) AND NOT EXISTS (SELECT id FROM postlike WHERE id_user = $id_user AND id_post = $id_post) LIMIT 1";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        $count = $resultado->rowCount();

        return $count == 1 ? true : false;
    }

    //Función para asignar los likes a cada post
    public function checkLike($id_post, $id_user)
    {
        $consulta = "SELECT id FROM postlike WHERE id_user = $id_user AND id_post = $id_post";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        $count = $resultado->rowCount();

        return $count == 1 ? true : false;
    }

    //Función para quitar un like
    public function removeLike($id_post, $id_user)
    {
        $consulta = "DELETE FROM postlike WHERE id_user = $id_user AND id_post = $id_post";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();
        $count = $resultado->rowCount();

        return $count == 1 ? true : false;
    }

    //Función para contar el número de likes
    public function countLikes()
    {
        $consulta = "SELECT posts.id_post, COUNT(postlike.id) AS nLikes, GROUP_CONCAT(users.username SEPARATOR '|') AS nameLiked FROM posts LEFT JOIN postlike ON postlike.id_post = posts.id_post LEFT JOIN users ON postlike.id_user = users.id GROUP BY posts.id_post ASC";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->execute();

        return $resultado->fetchAll();
    }

    //Función para
    public function checkNotification($id_sesion)
    {
        $consulta = "SELECT * FROM follower WHERE sender_id = '$id_sesion' ORDER BY id_follower DESC LIMIT 5";
        $resultado = $this->conexion->query($consulta);
        $count = $resultado->rowCount();

        if ($count > 0) {
            return $resultado->fetchAll();
        } else {
            return false;
        }
    }

    public function checkUnseen($id_sesion)
    {
        $consulta = "SELECT * FROM follower WHERE follow_status = 0 AND sender_id = '$id_sesion'";
        $resultado = $this->conexion->query($consulta);
        $count = $resultado->rowCount();

        return $count;
    }

    public function seeNotification($id_sesion)
    {
        $consulta = "UPDATE follower SET follow_status = 1 WHERE sender_id = '$id_sesion'";
        $resultado = $this->conexion->query($consulta);
    }

    public function unSeeNotification($id_sesion)
    {
        $consulta = "UPDATE follower SET follow_status = 0 WHERE sender_id = '$id_sesion'";
        $resultado = $this->conexion->query($consulta);
    }

    //Función para insertar un comentario de un post
    public function insertComment($id_user, $id_post, $text)
    {
        $consulta = "INSERT INTO comments (id_user, id_post, text) VALUES (?, ?, ?)";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->bindParam(1, $id_user);
        $resultado->bindParam(2, $id_post);
        $resultado->bindParam(3, $text);
        $resultado->execute();
        $count = $resultado->rowCount();

        return $count > 0 ? true : false;
    }

    public function getComments($id_post)
    {
        $consulta = "SELECT * FROM comments INNER JOIN users ON comments.id_post = '$id_post' AND comments.id_user = users.id";
        $resultado = $this->conexion->query($consulta);

        return $resultado->fetchAll();
    }

    //Función para borrar post 
    public function deletePost($id_post, $idSesion)
    {
        $consulta = "DELETE FROM posts WHERE id_post = '$id_post' AND id_user = '$idSesion'";
        $resultado = $this->conexion->query($consulta);

        return $resultado->rowCount() == 1 ? true : false;
    }

    public function details($id_user, $position, $link, $status)
    {
        $consulta = "UPDATE users SET position = ?, link = ?, status= ? WHERE id = '$id_user'";
        $resultado = $this->conexion->prepare($consulta);
        $resultado->bindParam(1, $position);
        $resultado->bindParam(2, $link);
        $resultado->bindParam(3, $status);
        $resultado->execute();

        return $resultado->rowCount() == 1 ? true : false;
    }
}
