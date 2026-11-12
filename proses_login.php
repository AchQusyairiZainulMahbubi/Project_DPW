
<?php

    session_start();

    include "koneksi.php";
    include "fungsi.php";

    $username = $_POST["username"];
    $password = $_POST["password"];

    $error = login($username, $password);

    if (!empty($error)) {

        $_SESSION["error"] = implode(", ", $error);
        $_SESSION["username"] = $username;

        header("Location: login.php");
        exit;

    }

    // Mencari username di database
    $query = mysqli_query($koneksi,
        "SELECT * FROM user WHERE username = '$username'");

    $data = mysqli_fetch_assoc($query);

    // Memeriksa username dan password
    if ($data && password_verify($password, $data["password"])) {

        $_SESSION["id_User"] = $data["id_User"];
        $_SESSION["username"] = $data["username"];
        $_SESSION["role"] = $data["role"];

        header("Location: index.php");
        exit;

    } else {

        $_SESSION["error"] = "Username atau password salah";
        $_SESSION["username"] = $username;

        header("Location: login.php");
        exit;

    }

?>
