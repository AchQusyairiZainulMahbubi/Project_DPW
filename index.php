
<?php

    session_start();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Diskusi</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <h1>FORUM DISKUSI</h1>
        <h2>Selamat Datang di Forum Diskusi</h2>
        <p>Tempat berbagi informasi dan pengetahuan.</p>
    </header>

    <main>

        <?php if (isset($_SESSION['username'])) { ?>

            <h3>Halo, <?php echo $_SESSION['username']; ?></h3>

            <p>Role: <?php echo $_SESSION['role']; ?></p>

            <?php if ($_SESSION['role'] == 'client') { ?>

                <p>Anda login sebagai Client.</p>

            <?php } else if ($_SESSION['role'] == 'expert') { ?>

                <p>Anda login sebagai Expert.</p>

            <?php } ?>

            <a href="logout.php">Logout</a>

        <?php } else { ?>

            <a href="login.php">Login</a>
            <a href="register.php">Register</a>

        <?php } ?>

    </main>

</body>
</html>
