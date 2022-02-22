<?php
    function createDatabase(){
    $sql = "CREATE DATABASE IF NOT EXISTS loginInfo";
    $pdo = new pdo('mysql:host=localhost:8889;', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $pdo->query($sql);
    }

    function createTable(){
        $sql = "CREATE TABLE IF NOT EXISTS users (
            userID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(30) NOT NULL,
            password VARCHAR(128) NOT NULL,
            email VARCHAR(30) NOT NULL UNIQUE)";

        $pdo = new pdo('mysql:host=localhost:8889; dbname=loginInfo', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $pdo->query($sql);
    }

    function dropTable(){
        $sql = "DROP TABLE users";
        $pdo = new pdo('mysql:host=localhost:8889; dbname=loginInfo', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $pdo->query($sql);
    }


    function addUser($username, $password, $email){
        $sql = "SELECT * FROM users WHERE email=?";
        $pdo = new pdo('mysql:host=localhost:8889; dbname=loginInfo', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $emailExists = $stmt->fetch();
        if ($emailExists) {

        } else {
            $sql = "INSERT INTO users (username, password, email)
                    VALUES (:username, :password, :email)";
            $pdo = new pdo('mysql:host=localhost:8889; dbname=loginInfo', 'root', 'root');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            
            $stmt = $pdo->prepare($sql);
            $password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->execute([
                'username' => $username,
                'password' => $password,
                'email' => $email
            ]);
            session_start();
                $_SESSION['username'] = $username;
                header("location: home.php");
        }

    }

    function POSTUser($id){
        $sql = "SELECT username, password, email
                FROM users
                WHERE userID=:id";
        $pdo = new pdo("mysql:host=localhost:8889; dbname=loginInfo", 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
    }

    function authenticateUser($email, $password) {
        $sql = "SELECT password, username
                FROM users
                WHERE email = :email";
        $pdo = new pdo("mysql:host=localhost:8889; dbname=loginInfo", 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'email' => $email
        ]);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmt->fetch();

        echo "<br>";

        if ($stmt->rowCount() > 0) {
            if (password_verify($password, $row['password'])) {
                session_start();
                $username = $row['username'];
                $_SESSION['username'] = $username;
                header("location: home.php");
            }
        }
        
    }
?>