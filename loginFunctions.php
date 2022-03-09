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
            password VARCHAR(255) NOT NULL,
            background VARCHAR(200) NOT NULL)";
    
        $pdo = new pdo('mysql:host=localhost:8889; dbname=loginInfo', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $pdo->query($sql);
    }
    

    function dropUsersTable(){
        $sql = "DROP TABLE users";
        $pdo = new pdo('mysql:host=localhost:8889; dbname=loginInfo', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $pdo->query($sql);
    }

    function dropTracksTable(){
        $sql = "DROP TABLE tracks";
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
            // session_start();
            $_SESSION['username'] = $username;
            $_SESSION['background'] = "assets/images/desert.jpg";

            addTrack($username, "God's Plan", "Drake", "https://i.scdn.co/image/ab67616d0000b273f907de96b9a4fbc04accc0d5", 'track');
            addTrack($username, "Reminder", "The Weeknd", "https://i.scdn.co/image/ab67616d0000b2734718e2b124f79258be7bc452", 'track');
            addTrack($username, "Blood On The Leaves", "Kanye West", "https://i.scdn.co/image/ab67616d0000b2731dacfbc31cc873d132958af9", 'track');
            addTrack($username, "God's Plan", "Drake", "https://i.scdn.co/image/ab67616d0000b273f907de96b9a4fbc04accc0d5", 'track');
            addTrack($username, "Reminder", "The Weeknd", "https://i.scdn.co/image/ab67616d0000b2734718e2b124f79258be7bc452", 'track');
            addTrack($username, "Blood On The Leaves", "Kanye West", "https://i.scdn.co/image/ab67616d0000b2731dacfbc31cc873d132958af9", 'track');
            addTrack($username, "God's Plan", "Drake", "https://i.scdn.co/image/ab67616d0000b273f907de96b9a4fbc04accc0d5", 'track');
            addTrack($username, "Reminder", "The Weeknd", "https://i.scdn.co/image/ab67616d0000b2734718e2b124f79258be7bc452", 'track');
            addTrack($username, "Blood On The Leaves", "Kanye West", "https://i.scdn.co/image/ab67616d0000b2731dacfbc31cc873d132958af9", 'track');

            addAlbum($username, "SEPT 5TH", "dvsn", ["With Me", "Too Deep", "Try/Effortless", "Do It Well", "In + Out", "SEPT 5TH", "Hallucinations"], "https://i.scdn.co/image/ab67616d0000b273f525f4a1bd3acdc0631ce362");
            addAlbum($username, "Sail Out", "Jhene Aiko", ["The Vapors", "Bed Peace", "Stay Ready (What A Life)", "WTH", "The Worst", "3:16AM", "Comfort Inn Ending"], "https://i.scdn.co/image/ab67616d0000b273a0fa057b8ad3f3c4969f0c97");
            
            addArtist($username, "PARTYNEXTDOOR", "https://i.scdn.co/image/ab6761610000e5eb4e3dee8baac75dad1fea791e");
            addArtist($username, 'A$AP Rocky', "https://i.scdn.co/image/ab6761610000e5eb6d5529e3962a16bd267bfeb2");
            addArtist($username, "J. Cole", "https://i.scdn.co/image/ab6761610000e5ebadd503b411a712e277895c8a");
            addArtist($username, "PARTYNEXTDOOR", "https://i.scdn.co/image/ab6761610000e5eb4e3dee8baac75dad1fea791e");
            addArtist($username, 'A$AP Rocky', "https://i.scdn.co/image/ab6761610000e5eb6d5529e3962a16bd267bfeb2");
            addArtist($username, "J. Cole", "https://i.scdn.co/image/ab6761610000e5ebadd503b411a712e277895c8a");
            addArtist($username, "PARTYNEXTDOOR", "https://i.scdn.co/image/ab6761610000e5eb4e3dee8baac75dad1fea791e");
            addArtist($username, 'A$AP Rocky', "https://i.scdn.co/image/ab6761610000e5eb6d5529e3962a16bd267bfeb2");
            addArtist($username, "J. Cole", "https://i.scdn.co/image/ab6761610000e5ebadd503b411a712e277895c8a");
            addArtist($username, "PARTYNEXTDOOR", "https://i.scdn.co/image/ab6761610000e5eb4e3dee8baac75dad1fea791e");
            addArtist($username, 'A$AP Rocky', "https://i.scdn.co/image/ab6761610000e5eb6d5529e3962a16bd267bfeb2");
            addArtist($username, "J. Cole", "https://i.scdn.co/image/ab6761610000e5ebadd503b411a712e277895c8a");
            
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
                // session_start();
                $_SESSION['username'] = $username;
                $background = $row['background'];
                $_SESSION['background'] = $background;
                getTracks($username);
                
                header("location: home.php");
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
            image VARCHAR(100),
            contentType VARCHAR(30))";
        
        $pdo = new pdo('mysql:host=localhost:8889; dbname=loginInfo', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $pdo->query($sql);
    }

    function addTrack($username, $title, $artist, $image) {
        $sql = "INSERT INTO tracks (username, title, artist, image)
                VALUES (:username, :title, :artist, :image)";

        $pdo = new pdo('mysql:host=localhost:8889; dbname=loginInfo', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $username,
            'title' => $title,
            'artist' => $artist,
            'image' => $image
        ]);
    }

    function getTracks($username) {
        $sql = "SELECT title, artist, image
                FROM tracks
                WHERE username=:username";

        // $sql = "SELECT title, image, username FROM music";

        $pdo = new pdo("mysql:host=localhost:8889; dbname=loginInfo", 'root', 'root');
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
            image VARCHAR(100),
            contentType VARCHAR(30))";
        
        $pdo = new pdo('mysql:host=localhost:8889; dbname=loginInfo', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $pdo->query($sql);
    }

    function addAlbum($username, $title, $artist, $trackList, $image) {

        foreach ($trackList as $trackName) {

            $sql = "INSERT INTO albums (username, title, trackName, artist, image)
                VALUES (:username, :title, :trackName, :artist, :image)";

            $pdo = new pdo('mysql:host=localhost:8889; dbname=loginInfo', 'root', 'root');
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

    function getAlbums($username) {
        $sql = "SELECT title, trackName, artist, image
                FROM albums
                WHERE username=:username";

        // $sql = "SELECT title, image, username FROM music";

        $pdo = new pdo("mysql:host=localhost:8889; dbname=loginInfo", 'root', 'root');
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
            image VARCHAR(100),
            contentType VARCHAR(30))";
        
        $pdo = new pdo('mysql:host=localhost:8889; dbname=loginInfo', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $pdo->query($sql);
    }

    function addArtist($username, $artist, $image) {
        $sql = "INSERT INTO artists (username, artist, image)
                VALUES (:username, :artist, :image)";

        $pdo = new pdo('mysql:host=localhost:8889; dbname=loginInfo', 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $username,
            'artist' => $artist,
            'image' => $image
        ]);
    }

    function getArtists($username) {
        $sql = "SELECT artist, image
                FROM artists
                WHERE username=:username";

        // $sql = "SELECT title, image, username FROM music";

        $pdo = new pdo("mysql:host=localhost:8889; dbname=loginInfo", 'root', 'root');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'username' => $username
        ]);

        // $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $row = $stmt->fetchAll();

        $_SESSION['artists'] = $row;
    }

?>