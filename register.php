
<?php

    session_start();

    // Mengambil pesan error dan data sebelumnya
    $error = $_SESSION["error"] ?? [];
    $old = $_SESSION["old"] ?? [];

    unset($_SESSION["error"]);
    unset($_SESSION["old"]);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <h1>Registrasi Akun</h1>
    </header>

    <main>
        <form action="proses_register.php" method="POST">

            <label>Username</label><br>
            <input type="text" name="username"
            value="<?php echo htmlspecialchars($old["username"] ?? ""); ?>">

            <?php
            if (isset($error["username"])) {
                echo "<span class='error'>" . htmlspecialchars($error["username"]) . "</span>";
            }
            ?>

            <br><br>

            <label>Email</label><br>
            <input type="text" name="email"
            value="<?php echo htmlspecialchars($old["email"] ?? ""); ?>">

            <?php
            if (isset($error["email"])) {
                echo "<span class='error'>" . htmlspecialchars($error["email"]) . "</span>";
            }
            ?>

            <br><br>

            <label>Password</label><br>
            <input type="password" name="password">

            <?php
            if (isset($error["password"])) {
                echo "<span class='error'>" . htmlspecialchars($error["password"]) . "</span>";
            }
            ?>

            <br><br>

            <label>Daftar Sebagai</label><br>

            <select name="role">

                <option value="client"
                <?php if (($old["role"] ?? "") == "client") echo "selected"; ?>>
                    Client
                </option>

                <option value="expert"
                <?php if (($old["role"] ?? "") == "expert") echo "selected"; ?>>
                    Expert
                </option>

            </select>

            <?php
            if (isset($error["role"])) {
                echo "<span class='error'>" . htmlspecialchars($error["role"]) . "</span>";
            }
            ?>

            <br><br>

            <button type="submit" name="register">Register</button>

        </form>

        <p>Sudah punya akun? <a href="login.php">Login</a></p>
    </main>

</body>
</html>
