<?php

class Config
{
    static public $dbHost = "localhost";
    static public $dbName = "proyectofinal";
    static public $dbUser = "root";
    static public $dbPassword = "";
    static public $dbCss = "styles.css";
    static public $defaultImage = "web/images/user.png";
    static public $validExtensions = ["image/jpeg", "image/gif", "image/png", "image/jpg"];
    static public $imgPath = 'web/images/';

    //Google login
    static public $googleClientID = "974296783605-5lg52q02jqi2oevfvbb1htch2dla0l7u.apps.googleusercontent.com";
    static public $googleClientSecretKey = "oTzgYeTFJBKPv3ayqVuyggXW";
    static public $googleRedirect = "http://localhost/web/index.php?action=inicio";
}
