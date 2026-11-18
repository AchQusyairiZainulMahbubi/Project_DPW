<?php
    // ==================================================================
    // expert/topik_direspon.php
    // Expert melihat (browse) topik yang sudah ia respon
    // ==================================================================

    session_start();

    include "../config/koneksi.php";
    include "../fungsi.php";
    include "../component/navbar.php";
    include "../component/tampil_topik.php";

    // Hanya expert yang boleh membuka halaman ini
    wajib_role("expert", "../");

    $id_User = (int)$_SESSION["id_User"];

    // Ambil topik yang pernah direspon oleh expert yang sedang login
    $daftar = daftar_topik("direspon", $id_User);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Topik yang Saya Respon</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/halaman.css">
</head>
<body>

    <header>
        <h1>Topik yang Saya Respon</h1>
    </header>

    <?php tampil_navbar("../"); ?>

    <main>

        <?php tampil_topik($daftar, "balas_expert"); ?>

    </main>

</body>
</html>
