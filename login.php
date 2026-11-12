
<?php
session_start();

$error = $_SESSION["error"] ?? "";
$username = $_SESSION["username"] ?? "";

unset($_SESSION["error"]);
unset($_SESSION["username"]);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <h1>Login Akun</h1>
    </header>

    <main>
        <form action="proses_login.php" method="POST">

            <label>Username</label><br>
            <input type="text" name="username"
                   value="<?php echo htmlspecialchars($username); ?>">
            <br><br>

            <label>Password</label><br>
            <input type="password" name="password">
            <br><br>

            <?php if ($error != "") { ?>
                <p class="error"><?php echo $error; ?></p>
            <?php } ?>

            <button type="submit" name="login">Login</button>

        </form>

        <p>Belum punya akun? <a href="register.php">Register</a></p>

        <a href="index.php">Kembali ke Homepage</a>
    </main>

</body>
</html>
