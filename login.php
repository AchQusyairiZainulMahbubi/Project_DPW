
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
        <input type="text" name="username">
        <br><br>

        <label>Password</label><br>
        <input type="password" name="password">
        <br><br>

        <button type="submit" name="login">Login</button>

    </form>

    <p>Belum punya akun? <a href="register.php">Register</a></p>

    <a href="index.php">Kembali ke Homepage</a>

</body>
</html>
