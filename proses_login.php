
<?php

    session_start();

    include "koneksi.php";

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_prepare($koneksi,
        "SELECT * FROM user WHERE username = ?");

    mysqli_stmt_bind_param($query, "s", $username);

    mysqli_stmt_execute($query);

    $result = mysqli_stmt_get_result($query);

    $data = mysqli_fetch_assoc($result);

    if ($data && password_verify($password, $data['passwors'])) {

        $_SESSION['id_User'] = $data['id_User'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];

        header("Location: index.php");
        exit;

    } else {

        echo "Username atau password salah!";
        echo "<br><a href='login.php'>Kembali</a>";

    }

?>
