
<?php

    session_start();

    include "koneksi.php";
    include "fungsi.php";

    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    $error = login($username, $password);

    if (!empty($error)) {

        $_SESSION["error"] = implode(", ", $error);
        $_SESSION["username"] = $username;

        header("Location: login.php");
        exit;

    }

    // Mencari username di database
    $query = mysqli_prepare($koneksi,
        "SELECT id_User, username, passwors, role FROM `user` WHERE username = ?");

    if (!$query) {
        die("Terjadi kesalahan saat memproses login.");
    }

    mysqli_stmt_bind_param($query, "s", $username);

    if (!mysqli_stmt_execute($query)) {
        die("Terjadi kesalahan saat memproses login.");
    }

    mysqli_stmt_bind_result($query, $id_User, $db_username, $password_hash, $role);
    $data_found = mysqli_stmt_fetch($query);
    mysqli_stmt_close($query);

    // Memeriksa username dan password
    if ($data_found && password_verify($password, $password_hash)) {

        $_SESSION["id_User"] = $id_User;
        $_SESSION["username"] = $db_username;
        $_SESSION["role"] = $role;

        header("Location: komentar.php");
        exit;

    } else {

        $_SESSION["error"] = "Username atau password salah";
        $_SESSION["username"] = $username;

        header("Location: login.php");
        exit;

    }

?>
