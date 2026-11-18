<?php
    // ==================================================================
    // index.php
    // Homepage forum diskusi
    // ==================================================================

    session_start();
    include "component/navbar.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Diskusi</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/halaman.css">
</head>
<body>

    <header>
        <h1>FORUM DISKUSI</h1>
        <h2>Selamat Datang di Forum Diskusi</h2>
        <p>Tempat berbagi informasi dan pengetahuan.</p>
    </header>

    <?php tampil_navbar(""); ?>

    <main>

        <?php if (isset($_SESSION["username"])) { ?>

            <h3>Halo, <?= htmlspecialchars($_SESSION["username"]) ?></h3>

            <p>Role: <?= htmlspecialchars($_SESSION["role"]) ?></p>

            <?php if ($_SESSION["role"] === "client") { ?>

                <p>Anda login sebagai Client. Anda dapat membuat topik diskusi, mengedit topik Anda, dan melihat topik client lain.</p>

            <?php } else if ($_SESSION["role"] === "expert") { ?>

                <p>Anda login sebagai Expert. Anda dapat merespon topik client, mengedit respon Anda, dan melihat seluruh topik diskusi.</p>

            <?php } ?>

        <?php } else { ?>

            <a href="auth/login.php">Login</a>
            <a href="auth/register.php">Register</a>

        <?php } ?>

    </main>

</body>
</html>
