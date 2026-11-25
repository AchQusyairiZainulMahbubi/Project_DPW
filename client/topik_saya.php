<?php
    session_start();

    include "../config/koneksi.php";
    include "../fungsi.php";
    include "../component/navbar.php";
    include "../component/tampil_topik.php";

    // Hanya client yang boleh membuka halaman ini
    wajib_role("client", "../");

    $id_User = (int)$_SESSION["id_User"];

    // Pesan sukses setelah membuat / mengedit topik (hanya nilai yang dikenal)
    $daftar_pesan = [
        "dibuat" => "Topik berhasil dibuat.",
        "diubah" => "Topik berhasil diperbarui."
    ];
    $kunci_pesan = $_GET["pesan"] ?? "";
    $pesan = (is_string($kunci_pesan) && isset($daftar_pesan[$kunci_pesan])) ? $daftar_pesan[$kunci_pesan] : "";

    // Ambil topik milik client yang sedang login
    $daftar = daftar_topik("milik", $id_User);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Topik Saya</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <header>
        <h1>Topik Saya</h1>
    </header>

    <?php tampil_navbar("../"); ?>

    <main>

        <?php if ($pesan !== "") { ?>
            <div class="pesan"><?= $pesan ?></div>
        <?php } ?>

        <?php tampil_topik($daftar, "edit_client"); ?>

    </main>

</body>
</html>
