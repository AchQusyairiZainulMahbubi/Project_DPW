<?php
    // ==================================================================
    // auth/proses_login.php
    // Memproses form login: validasi -> cek database -> buat session
    // ==================================================================

    session_start();

    include __DIR__ . "/../config/koneksi.php";
    include __DIR__ . "/../fungsi.php";

    // Ambil masukan dari form
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    // Validasi masukan (wajib diisi)
    $error = login($username, $password);

    if (!empty($error)) {
        $_SESSION["error"] = implode(", ", $error);
        $_SESSION["login_username"] = $username;

        header("Location: login.php");
        exit;
    }

    // Mencari username di database
    $query = mysqli_prepare($koneksi,
        "SELECT id_User, username, password, role FROM `user` WHERE username = ?");

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
    if ($data_found && is_string($password_hash) && password_verify($password, $password_hash)) {

        // Ganti session id supaya aman dari session fixation
        session_regenerate_id(true);

        $_SESSION["id_User"]  = $id_User;
        $_SESSION["username"] = $db_username;
        $_SESSION["role"]     = $role;

        // Setelah login, semua role menuju homepage
        header("Location: ../index.php");
        exit;

    } else {

        $_SESSION["error"] = "Username atau password salah";
        $_SESSION["login_username"] = $username;

        header("Location: login.php");
        exit;
    }
?>