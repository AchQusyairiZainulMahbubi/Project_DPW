<?php
    session_start();

    include "../config/koneksi.php";
    include "../fungsi.php";
    include "../component/navbar.php";
    include "../component/tampil_topik.php";

    // Hanya client yang boleh membuka halaman ini
    wajib_role("client", "../");

    $id_User = (int)$_SESSION["id_User"];

    // Ambil topik milik client lain (bukan milik yang sedang login)
    $daftar = daftar_topik("lain", $id_User);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Topik Client Lain</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <header>
        <h1>Topik Client Lain</h1>
    </header>

    <?php tampil_navbar("../"); ?>

    <main>

        <?php tampil_topik($daftar, ""); ?>

    </main>

</body>
</html>
