
<?php

    session_start();

    require "fungsi.php";
    include "koneksi.php";

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header("Location: login.php");
        exit;
    }

    $error = [];
    $username = trim($_POST['username'] ?? "");
    $password = $_POST['password'] ?? "";

    $error = login($error, $username, $password);

    if (!empty($error)) {
    $_SESSION["error"]    = $error;
    $_SESSION["username"] = $username;
    header("Location: login.php");
    exit;
}

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
