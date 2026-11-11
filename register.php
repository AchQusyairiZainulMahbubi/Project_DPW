
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <h2>Registrasi Akun</h2>

    <form action="proses_register.php" method="POST">

        <label>Username</label><br>
        <input type="text" name="username">
        <br><br>

        <label>Email</label><br>
        <input type="text" name="email">
        <br><br>

        <label>Password</label><br>
        <input type="password" name="password">
        <br><br>

        <label>Daftar Sebagai</label><br>

        <select name="role">
            <option value="client">Client</option>
            <option value="expert">Expert</option>
        </select>

        <br><br>

        <button type="submit" name="register">Register</button>

    </form>

    <p>Sudah punya akun? <a href="login.php">Login</a></p>

</body>
</html>
