<?php
    session_start();

    include "../config/koneksi.php";
    include "../fungsi.php";
    include "../component/navbar.php";
    include "../component/tampil_topik.php";

    // Hanya expert yang boleh membuka halaman ini
    wajib_role("expert", "../");

    $id_User = (int)$_SESSION["id_User"];

    // Ambil seluruh topik
    $daftar = daftar_topik("semua", $id_User);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Topik Diskusi</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <header>
        <h1>Semua Topik Diskusi</h1>
    </header>

    <?php tampil_navbar("../"); ?>

    <main>

        <?php tampil_topik($daftar, "balas_expert"); ?>

    </main>

</body>
</html>
