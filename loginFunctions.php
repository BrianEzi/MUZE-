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
            username VARCHAR(30) NOT NULL UNIQUE,
            password VARCHAR(120) NOT NULL,
            background VARCHAR(200) NOT NULL)";
    
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

    function addUser($username, $password){
        $sql = "SELECT * FROM users WHERE username=?";
        $pdo = new pdo('mysql:host=localhost:8889; dbname=loginInfo', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);
        $emailExists = $stmt->fetch();
        if ($emailExists) {

        } else {
            $sql = "INSERT INTO users (username, password, background)
                    VALUES (:username, :password, :background)";
            $pdo = new pdo('mysql:host=localhost:8889; dbname=loginInfo', 'root', 'root');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            
            $stmt = $pdo->prepare($sql);
            $password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->execute([
                'username' => $username,
                'password' => $password,
                'background' => "assets/images/desert.jpg"
            ]);
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['background'] = "assets/images/desert.jpg";
            header("location: home.php");
        }

    }

    function getUser($id){
        $sql = "SELECT username, password
                FROM users
                WHERE userID=:id";
        $pdo = new pdo("mysql:host=localhost:8889; dbname=loginInfo", 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
    }

    function authenticateUser($username, $password) {
        $sql = "SELECT password, background
                FROM users
                WHERE username = :username";
        $pdo = new pdo("mysql:host=localhost:8889; dbname=loginInfo", 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $username
        ]);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmt->fetch();

        echo "<br>";

        if ($stmt->rowCount() > 0) {
            if (password_verify($password, $row['password'])) {
                session_start();
                $_SESSION['username'] = $username;
                $background = $row['background'];
                $_SESSION['background'] = $background;
                header("location: home.php");
            }
        }        
    }
?>