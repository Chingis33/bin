<?php

    define("DRIVER", "mysql");
    define("HOST", "127.0.0.1");
    define("PORT", "3306");
    define("DBNAME", "mydb");
    define("CHARSET", "utf8");
    define("USERNAME", "root");
    define("USERPASSWORD", "");

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];
