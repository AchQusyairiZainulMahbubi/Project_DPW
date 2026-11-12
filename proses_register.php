
<?php

    session_start();

    include "koneksi.php";
    include "fungsi.php";

    // Mengambil data dari form
    $username = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $role = $_POST["role"] ?? "";

    // Validasi data
    $error = [];

    validasi_username($error, $username);
    validasi_email($error, $email);
    validasi_pass($error, $password);
    validasi_role($error, $role);

    // Mengecek username dan email jika tidak ada error
    if (empty($error)) {

        $query = mysqli_query($koneksi,
            "SELECT * FROM user WHERE username = '$username' OR email = '$email'");

        while ($data = mysqli_fetch_assoc($query)) {

            if ($data["username"] == $username) {
                $error["username"] = "Username sudah dipakai";
            }

            if ($data["email"] == $email) {
                $error["email"] = "Email sudah terdaftar";
            }

        }

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
    $query = mysqli_query($koneksi,
        "INSERT INTO user (username, email, password, role)
        VALUES ('$username', '$email', '$password', '$role')");

    // Jika registrasi berhasil
    if ($query) {

        $_SESSION["sukses"] = "Registrasi berhasil, silakan login";

        header("Location: login.php");
        exit;

    }

?>
