<?php

    session_start();

    include "koneksi.php";
    include "fungsi.php";

    
    if(!isset($_SESSION["id_User"])) {
        header("Location: login.php");
        exit;
    }

    $error = [];
    $id_User = (int)$_SESSION["id_User"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $email    = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    $error = validasi_profil($error, $username, $email, $password);

    if (empty($error)) {
        update_profil($id_User, $username, $email, $password);
        $_SESSION["username"] = $username;
        header("Location: index.php");
        exit;
    }
} else {
    $data = select_id($id_User);

    if (!$data) {
        header("Location: index.php");
        exit;
    }

    $username = $data["username"];
    $email    = $data["email"];
    $role     = $data["role"];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <h1>Edit Profil</h1>
    </header>

    <main>

        <p><a href="index.php">&larr; Kembali ke Homepage</a></p>


        <form action="" method="post">

            <div>
                <label for="username">Username</label>
                <input type="text" id="username" name="username"
                       value="<?= htmlspecialchars($username) ?>">
                <?php if (isset($error["username"])): ?>
                    <small style="color:red"><?= $error["username"] ?></small>
                <?php endif; ?>
            </div>

            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                       value="<?= htmlspecialchars($email) ?>">
                <?php if (isset($error["email"])): ?>
                    <small style="color:red"><?= $error["email"] ?></small>
                <?php endif; ?>
            </div>

            <div>
                <label for="password">Password baru (kosongkan jika tidak diganti)</label>
                <input type="password" id="password" name="password">
                <?php if (isset($error["password"])): ?>
                    <small style="color:red"><?= $error["password"] ?></small>
                <?php endif; ?>
            </div>

            <button type="submit">Simpan Profil</button>
        </form>
    </main>

</body>
</html>