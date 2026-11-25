<?php
    session_start();

    include __DIR__ . "/../config/koneksi.php";
    include __DIR__ . "/../fungsi.php";
    include __DIR__ . "/navbar.php";

    if (!isset($_SESSION["id_User"])) {
        header("Location: ../auth/login.php");
        exit;
    }

    $error = [];
    $id_User = (int)$_SESSION["id_User"];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $username = ambil_post("username");
        $email    = ambil_post("email");
        $password = $_POST["password"] ?? "";
        if (!is_string($password)) {
            $password = "";
        }

        $error = validasi_profil($error, $username, $email, $password);

        if (!isset($error["username"]) && username_dipakai($username, $id_User)) {
            $error["username"] = "Username sudah dipakai user lain";
        }

        if (empty($error)) {
            update_profil($id_User, $username, $email, $password);
            $_SESSION["username"] = $username;
            header("Location: ../index.php");
            exit;
        }
    } else {

        $data = select_id($id_User);

        if (!$data) {
            header("Location: ../index.php");
            exit;
        }

        $username = $data["username"];
        $email    = $data["email"];
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <header>
        <h1>Edit Profil</h1>
    </header>

    <?php tampil_navbar(""); ?>

    <main>

        <form action="" method="post">

            <div class="form-grup">
                <label for="username">Username</label>
                <input type="text" id="username" name="username"
                       value="<?= htmlspecialchars($username) ?>">
                <?php if (isset($error["username"])) { ?>
                    <small class="error"><?= $error["username"] ?></small>
                <?php } ?>
            </div>

            <div class="form-grup">
                <label for="email">Email</label>
                <input type="text" id="email" name="email"
                       value="<?= htmlspecialchars($email) ?>">
                <?php if (isset($error["email"])) { ?>
                    <small class="error"><?= $error["email"] ?></small>
                <?php } ?>
            </div>

            <div class="form-grup">
                <label for="password">Password baru (kosongkan jika tidak diganti)</label>
                <input type="password" id="password" name="password">
                <?php if (isset($error["password"])) { ?>
                    <small class="error"><?= $error["password"] ?></small>
                <?php } ?>
            </div>

            <button type="submit">Simpan Profil</button>
        </form>
    </main>

</body>
</html>
