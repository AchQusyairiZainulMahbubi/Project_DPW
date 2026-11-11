<?php
session_start();

$error = $_SESSION["error"] ?? [];
$old   = $_SESSION["old"] ?? [];
unset($_SESSION["error"], $_SESSION["old"]);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <h2>Registrasi Akun</h2>

    <form action="proses_register.php" method="POST">

        <label for="username">Username</label><br>
        <input type="text" id="username" name="username"
               value="<?= htmlspecialchars($old["username"] ?? "") ?>">
        <?php if (isset($error["username"])): ?>
            <span class="error"><?= htmlspecialchars($error["username"]) ?></span>
        <?php endif; ?>
        <br><br>

        <label for="email">Email</label><br>
        <input type="text" id="email" name="email"
               value="<?= htmlspecialchars($old["email"] ?? "") ?>">
        <?php if (isset($error["email"])): ?>
            <span class="error"><?= htmlspecialchars($error["email"]) ?></span>
        <?php endif; ?>
        <br><br>

        <label for="password">Password</label><br>
        <input type="password" id="password" name="password">
        <?php if (isset($error["password"])): ?>
            <span class="error"><?= htmlspecialchars($error["password"]) ?></span>
        <?php endif; ?>
        <br><br>

        <label for="role">Daftar Sebagai</label><br>
        <select id="role" name="role">
            <option value="client" <?= ($old["role"] ?? "") === "client" ? "selected" : "" ?>>Client</option>
            <option value="expert" <?= ($old["role"] ?? "") === "expert" ? "selected" : "" ?>>Expert</option>
        </select>
        <?php if (isset($error["role"])): ?>
            <span class="error"><?= htmlspecialchars($error["role"]) ?></span>
        <?php endif; ?>
        <br><br>

        <button type="submit" name="register">Register</button>

    </form>

    <p>Sudah punya akun? <a href="login.php">Login</a></p>

</body>
</html>