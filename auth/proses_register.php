
<?php

    session_start();

    include __DIR__ . "/../config/koneksi.php";
    include __DIR__ . "/../fungsi.php";   

    // Mengambil data dari form
    $username = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $role = $_POST["role"] ?? "";

    // Validasi data
    $error = [];

    $error = register($error, $username, $email, $password, $role);

    // Mengecek username dan email jika tidak ada error
    if (empty($error)) {

        $query = mysqli_prepare($koneksi,
            "SELECT username, email FROM `user` WHERE username = ? OR email = ?");

        if (!$query) {
            die("Terjadi kesalahan saat memproses registrasi.");
        }

        mysqli_stmt_bind_param($query, "ss", $username, $email);

        if (!mysqli_stmt_execute($query)) {
            die("Terjadi kesalahan saat memproses registrasi.");
        }

        mysqli_stmt_bind_result($query, $existing_username, $existing_email);

        while (mysqli_stmt_fetch($query)) {

            if ($existing_username == $username) {
                $error["username"] = "Username sudah dipakai";
            }

            if ($existing_email == $email) {
                $error["email"] = "Email sudah terdaftar";
            }

        }

        mysqli_stmt_close($query);

    }

    // Jika terdapat error, kembali ke register
    if (!empty($error)) {

        $_SESSION["error"] = $error;

        $_SESSION["old"] = [
            "username" => $username,
            "email" => $email,
            "role" => $role
        ];

        header("Location: register.php");
        exit;

    }

    // Mengubah password menjadi hash
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Menyimpan data ke database
    $query = mysqli_prepare($koneksi,
        "INSERT INTO `user` (username, email, password, role)
        VALUES (?, ?, ?, ?)");

    if (!$query) {
        die("Terjadi kesalahan saat memproses registrasi.");
    }

    mysqli_stmt_bind_param($query, "ssss", $username, $email, $password, $role);
    $registered = mysqli_stmt_execute($query);
    mysqli_stmt_close($query);

    // Jika registrasi berhasil
    if ($registered) {

        $_SESSION["sukses"] = "Registrasi berhasil, silakan login";

        header("Location: login.php");
        exit;

    }

    die("Registrasi gagal karena terjadi kesalahan database.");

?>
