<?php
    function createDatabase(){
    $sql = "CREATE DATABASE IF NOT EXISTS loginInfo";
    $pdo = new pdo('mysql:host=localhost;', 'newuser', 'password');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $pdo->query($sql);
    }

    function createTable(){
        $sql = "CREATE TABLE IF NOT EXISTS users (
            userID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(30) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            background VARCHAR(200) NOT NULL,
            profilePicture VARCHAR(200) NOT NULL)";
    
        $pdo = new pdo('mysql:host=localhost; dbname=loginInfo', 'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $pdo->query($sql);
    }
    

    function dropUsersTable(){
        $sql = "DROP TABLE users";
        $pdo = new pdo('mysql:host=localhost; dbname=loginInfo', 'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $pdo->query($sql);
    }

    function dropTracksTable(){
        $sql = "DROP TABLE tracks";
        $pdo = new pdo('mysql:host=localhost; dbname=loginInfo', 'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $pdo->query($sql);
    }

    function addUser($username, $password){
        $sql = "SELECT * FROM users WHERE username=?";
        $pdo = new pdo('mysql:host=localhost; dbname=loginInfo', 'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);
        $emailExists = $stmt->fetch();
        if ($emailExists) {

        } else {
            $sql = "INSERT INTO users (username, password, background, profilePicture)
                    VALUES (:username, :password, :background, :profilePicture)";
            $pdo = new pdo('mysql:host=localhost; dbname=loginInfo', 'newuser', 'password');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            
            $stmt = $pdo->prepare($sql);
            $password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->execute([
                'username' => $username,
                'password' => $password,
                'background' => "assets/images/desert.jpg",
                'profilePicture' => "assets/images/aurora.jpg"
            ]);
            // session_start();
            $_SESSION['username'] = $username;
            $_SESSION['background'] = "assets/images/desert.jpg";
            $_SESSION['profilePicture'] = "assets/images/aurora.jpg";
            
            getTracks($username);
            getAlbums($username);
            getArtists($username);

            header("location: home.php");
        }

    }

    function getUser($id){
        $sql = "SELECT username, password
                FROM users
                WHERE userID=:id";
        $pdo = new pdo("mysql:host=localhost; dbname=loginInfo", 'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
    }

    function authenticateUser($username, $password) {
        $sql = "SELECT password, background, profilePicture
                FROM users
                WHERE username = :username";
        $pdo = new pdo("mysql:host=localhost; dbname=loginInfo", 'newuser', 'password');
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
                // session_start();
                $_SESSION['username'] = $username;
                
                $background = $row['background'];
                $_SESSION['background'] = $background;

                $profilePicture = $row['profilePicture'];
                $_SESSION['profilePicture'] = $profilePicture;

                getTracks($username);
                getAlbums($username);
                getArtists($username);
                
                header("location: home.php");
            }
        }        
    }


    function changePassword($username, $oldPassword, $newPassword) {
        $sql = "SELECT password
                FROM users
                WHERE username=:username";

        $pdo = new pdo("mysql:host=localhost; dbname=loginInfo", 'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $username
        ]);

        $row = $stmt->fetch();
        
        if ($row) {

            if (password_verify($oldPassword, $row[0])) {
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $sql2 = "UPDATE users
                        SET password = :password
                        WHERE username = :username";

                $pdo2 = new pdo("mysql:host=localhost; dbname=loginInfo", 'newuser', 'password');
                $pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    
                $stmt2 = $pdo2->prepare($sql2);
                $stmt2->execute([
                    'password' => $hashedNewPassword,
                    'username' => $username
                ]);
            } else {
                $changePasswordError = true;
                $_SESSION['changePasswordError'] = $changePasswordError;
            }

        }
    }


    // STORING TRACKS

    function createTracksTable() {
        $sql = "CREATE TABLE IF NOT EXISTS tracks (
            dataID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(30) NOT NULL,
            title VARCHAR(100),
            artist VARCHAR(100),
            image VARCHAR(100))";
        
        $pdo = new pdo('mysql:host=localhost; dbname=loginInfo', 'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $pdo->query($sql);
    }

    function addTrack($username, $title, $artist, $image) {
        $sql = "INSERT INTO tracks (username, title, artist, image)
                VALUES (:username, :title, :artist, :image)";

        $pdo = new pdo('mysql:host=localhost; dbname=loginInfo', 'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $username,
            'title' => $title,
            'artist' => $artist,
            'image' => $image
        ]);
    }

    function removeTrack($username, $title, $artist) {
        $sql = "DELETE FROM tracks
                WHERE username=:username AND title=:title AND artist=:artist";

        $pdo = new pdo('mysql:host=localhost; dbname=loginInfo', 'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $username,
            'title' => $title,
            'artist' => $artist
        ]);
    }


    function getTracks($username) {
        $sql = "SELECT title, artist, image
                FROM tracks
                WHERE username=:username";

        // $sql = "SELECT title, image, username FROM music";

        $pdo = new pdo("mysql:host=localhost; dbname=loginInfo", 'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $username
        ]);

        // $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmt->fetchAll();

        $_SESSION['tracks'] = $row;
    }


    // STORING ALBUMS


    function createAlbumsTable() {
        $sql = "CREATE TABLE IF NOT EXISTS albums (
            dataID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(30) NOT NULL,
            title VARCHAR(100),
            artist VARCHAR(100),
            trackName VARCHAR(100),
            image VARCHAR(100))";
        
        $pdo = new pdo('mysql:host=localhost; dbname=loginInfo', 'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $pdo->query($sql);
    }

    function addAlbum($username, $title, $artist, $trackList, $image) {

        foreach ($trackList as $trackName) {

            $sql = "INSERT INTO albums (username, title, trackName, artist, image)
                VALUES (:username, :title, :trackName, :artist, :image)";

            $pdo = new pdo('mysql:host=localhost; dbname=loginInfo', 'newuser', 'password');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'username' => $username,
                'title' => $title,
                'trackName' => $trackName,
                'artist' => $artist,
                'image' => $image
            ]);
        }
        
    }

    function removeAlbum($username, $title, $artist) {
        $sql = "DELETE FROM albums
                WHERE username=:username AND title=:title AND artist=:artist";
                
        $pdo = new pdo('mysql:host=localhost; dbname=loginInfo', 'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $username,
            'title' => $title,
            'artist' => $artist
        ]);
    }

    function getAlbums($username) {
        $sql = "SELECT title, trackName, artist, image
                FROM albums
                WHERE username=:username";

        // $sql = "SELECT title, image, username FROM music";

        $pdo = new pdo("mysql:host=localhost; dbname=loginInfo", 'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $username
        ]);

        // $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmt->fetchAll();

        $albumImages = [];
        $albums = [];
        foreach($row as $track) {
            if (in_array($track[3], $albumImages)) {
                
            } else {
                array_push($albumImages, $track[3]);
                $albumTracks = [];
                foreach($row as $tempTrack) {
                    if ($track[3] == $tempTrack[3]) {
                        array_push($albumTracks, $track[1]);
                    }
                }
                $albumInfo = [$track[0], $albumTracks, $track[2], $track[3]];
                array_push($albums, $albumInfo);
            }
        }
        $_SESSION['albums'] = $albums;
    }

    // STORING ARTISTS

    
    function createArtistsTable() {
        $sql = "CREATE TABLE IF NOT EXISTS artists (
            dataID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(30) NOT NULL,
            artist VARCHAR(100),
            image VARCHAR(100))";
        
        $pdo = new pdo('mysql:host=localhost; dbname=loginInfo', 'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $pdo->query($sql);
    }

    function addArtist($username, $artist, $image) {
        $sql = "INSERT INTO artists (username, artist, image)
                VALUES (:username, :artist, :image)";

        $pdo = new pdo('mysql:host=localhost; dbname=loginInfo', 'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $username,
            'artist' => $artist,
            'image' => $image
        ]);
    }

    function removeArtist($username, $artist) {
        $sql = "DELETE FROM albums
                WHERE username=:username AND artist=:artist";
                
        $pdo = new pdo('mysql:host=localhost; dbname=loginInfo', 'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $username,
            'artist' => $artist
        ]);
    }

    function getArtists($username) {
        $sql = "SELECT artist, image
                FROM artists
                WHERE username=:username";

        // $sql = "SELECT title, image, username FROM music";

        $pdo = new pdo("mysql:host=localhost; dbname=loginInfo", 'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $username
        ]);

        // $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmt->fetchAll();

        $_SESSION['artists'] = $row;
    }


    // STORING ALBUMS


    function createPlaylistsTable() {
        $sql = "CREATE TABLE IF NOT EXISTS playlists (
            dataID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(30) NOT NULL,
            title VARCHAR(100),
            trackName VARCHAR(100),
            image VARCHAR(100))";
        
        $pdo = new pdo('mysql:host=localhost; dbname=loginInfo', 'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $pdo->query($sql);
    }

    function addPlaylist($username, $title, $trackList, $image) {

        foreach ($trackList as $trackName) {

            $sql = "INSERT INTO albums (username, title, trackName, image)
                VALUES (:username, :title, :trackName, :image)";

            $pdo = new pdo('mysql:host=localhost; dbname=loginInfo', 'newuser', 'password');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'username' => $username,
                'title' => $title,
                'trackName' => $trackName,
                'image' => $image
            ]);
        }
        
    }

    function removePlaylist($username, $title) {
        $sql = "DELETE FROM playlists
                WHERE username=:username AND title=:title";
                
        $pdo = new pdo('mysql:host=localhost; dbname=loginInfo', 'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $username,
            'title' => $title,
        ]);
    }

    function getPlaylists($username) {
        $sql = "SELECT title, trackName, image
                FROM playlists
                WHERE username=:username";

        // $sql = "SELECT title, image, username FROM music";

        $pdo = new pdo("mysql:host=localhost; dbname=loginInfo", 'newuser', 'password');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $username
        ]);

        // $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmt->fetchAll();

        $playlistTrackNames = [];
        $playlists = [];
        foreach($row as $track) {
            if (in_array($track[1], $playlistsTrackNames)) {
                
            } else {
                array_push($playlistTrackNames, $track[1]);
                $playlistTracks = [];
                foreach($row as $tempTrack) {
                    if ($track[1] == $tempTrack[1]) {
                        array_push($playlistTracks, $track[1]);
                    }
                }
                $playlistInfo = [$track[0], $playlistTracks, $track[2]];
                array_push($playlists, $playlistInfo);
            }
        }
        $_SESSION['playlists'] = $playlists;
    }

?>