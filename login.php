<?php
session_start();
$error    = $_SESSION["error"] ?? [];
$username = $_SESSION["username"] ?? "";
unset($_SESSION["error"], $_SESSION["username"]);
?>



<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <h2>Login Akun</h2>

    <form action="proses_login.php" method="POST">

        <label>Username</label><br>
        <input type="text" id="username" name="username" value="<?php echo($username) ?>">
        <?php if (isset($error["username"])): ?>
            <span class="error"><?= $error["username"] ?></span>
        <?php endif; ?>
        <br><br>

        <label>Password</label><br>
        <input type="password" id="password" name="password">
        <?php if (isset($error["password"])): ?>
            <span class="error"><?= $error["password"] ?></span>
        <?php endif; ?>
        <br><br>

        <?php if (isset($error["login"])): ?>
        <p class="error"><?= htmlspecialchars($error["login"]) ?></p>
        <?php endif; ?>

        <button type="submit" name="login">Login</button>

    </form>

    <p>Belum punya akun? <a href="register.php">Register</a></p>

    <a href="index.php">Kembali ke Homepage</a>

</body>
</html>
