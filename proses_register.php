
<?php

    include "koneksi.php";

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($username == "" || $email == "" || $password == "") {
        echo "Semua data harus diisi!";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Format email tidak valid!";
        exit;
    }

    if (strlen($password) < 6) {
        echo "Password minimal 6 karakter!";
        exit;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = mysqli_prepare($koneksi,
        "INSERT INTO user (username, email, passwors, role)
        VALUES (?, ?, ?, ?)");

    mysqli_stmt_bind_param($query, "ssss",
        $username, $email, $password, $role);

    if (mysqli_stmt_execute($query)) {
        echo "Registrasi berhasil!";
        echo "<br><a href='login.php'>Login Sekarang</a>";
    } else {
        echo "Registrasi gagal! Username atau email mungkin sudah digunakan.";
    }

?>
