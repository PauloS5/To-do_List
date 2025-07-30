<?php
    $dsn = "mysql:host=localhost;dbname=dbMyDataBase;charset=utf8";
    $user = "root";
    $password = "";
    $options = "";

    try {
        $dbh = new PDO($dsn, $user, $password);
    }
    catch (PDOException $e) {
        header("Location: ../src/pages/erro.html");
    }