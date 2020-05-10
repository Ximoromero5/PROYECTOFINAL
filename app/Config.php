<?php

class Config
{
    static public $dbHost = "localhost";
    static public $dbName = "proyectofinal";
    static public $dbUser = "root";
    static public $dbPassword = "";
    static public $dbCss = "styles.css";
    static public $defaultImage = "web/images/web/0.png";
    static public $defaultCoverImage = "web/images/web/defaultCover.jpg";
    static public $validExtensions = ["image/jpeg", "image/gif", "image/png", "image/jpg", "video/mp4"];
    static public $imgPath = 'web/images/';

    //Google login
    static public $googleClientID = "468146607582-olr4gfqtrqfbv38am5cg6ppsnvirf8oc.apps.googleusercontent.com";
    static public $googleClientSecretKey = "nU36y2AZzABkD9WDtI3ZXl1l";
    static public $googleRedirect = "http://localhost/proyectofinal/home";
}
