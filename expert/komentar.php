<?php
    // ==================================================================
    // expert/komentar.php
    // Expert melihat satu topik dan merespon (reply) topik tersebut
    // URL: komentar.php?id_post=<id topik>
    // ==================================================================

    session_start();

    include "../config/koneksi.php";
    include "../fungsi.php";
    include "../component/navbar.php";
    include "../component/tampil_topik.php";

    // Hanya expert yang boleh membuka halaman ini
    wajib_role("expert", "../");

    // Ambil id topik dari URL dan pastikan formatnya angka
    $id_post = $_GET["id_post"] ?? "";
    if (!id_valid($id_post)) {
        header("Location: semua_topik.php");
        exit;
    }
    $id_post = (int)$id_post;

    // Pastikan topik yang dituju memang ada
    $topik = ambil_topik($id_post);
    if (!$topik) {
        header("Location: semua_topik.php");
        exit;
    }

    // Ambil error dan isian lama dari simpan_komentar.php (jika validasi gagal)
    $error = $_SESSION["flash_error"] ?? [];
    $isi   = $_SESSION["flash_isi"] ?? "";
    unset($_SESSION["flash_error"], $_SESSION["flash_isi"]);

    // Pesan sukses setelah menambah / mengedit respon (hanya nilai yang dikenal)
    $daftar_pesan = [
        "dibuat" => "Respon berhasil dikirim.",
        "diubah" => "Respon berhasil diperbarui."
    ];
    $kunci_pesan = $_GET["pesan"] ?? "";
    $pesan = (is_string($kunci_pesan) && isset($daftar_pesan[$kunci_pesan])) ? $daftar_pesan[$kunci_pesan] : "";

    // Ambil seluruh respon pada topik ini
    $balasan = ambil_balasan($id_post);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respon Topik</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/halaman.css">
</head>
<body>

    <header>
        <h1>Respon Topik</h1>
    </header>

    <?php tampil_navbar("../"); ?>

    <main>

        <?php if ($pesan !== "") { ?>
            <div class="pesan"><?= $pesan ?></div>
        <?php } ?>

        <!-- Detail topik dari client -->
        <article class="topik">
            <h3><?= htmlspecialchars($topik["title"]) ?></h3>
            <small>
                Oleh <?= htmlspecialchars($topik["username"]) ?>
                | Kategori: <?= htmlspecialchars($topik["nama_kategori"] ?? "-") ?>
                | <?= htmlspecialchars($topik["created_time"]) ?>
            </small>
            <p><?= nl2br(htmlspecialchars($topik["content"])) ?></p>
        </article>

        <!-- Daftar respon expert yang sudah ada -->
        <h2>Respon Expert (<?= count($balasan) ?>)</h2>
        <?php tampil_balasan($balasan, true); ?>

        <!-- Form respon baru -->
        <h2>Tambahkan Respon</h2>
        <form action="simpan_komentar.php" method="post">

            <input type="hidden" name="id_post" value="<?= $id_post ?>">

            <div class="form-grup">
                <label for="isi">Isi Respon</label>
                <textarea id="isi" name="isi"><?= htmlspecialchars($isi) ?></textarea>
                <?php if (isset($error["isi"])) { ?>
                    <small class="error"><?= $error["isi"] ?></small>
                <?php } ?>
            </div>

            <button type="submit">Kirim Respon</button>
            <a href="semua_topik.php">Kembali</a>
        </form>

    </main>

</body>
</html>
