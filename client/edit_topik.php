<?php
    // ==================================================================
    // client/edit_topik.php
    // Client mengedit topik diskusi yang ia buat sendiri
    // ==================================================================

    session_start();

    include "../config/koneksi.php";
    include "../fungsi.php";
    include "../component/navbar.php";

    // Hanya client yang boleh membuka halaman ini
    wajib_role("client", "../");

    $error = [];
    $id_User = (int)$_SESSION["id_User"];

    // Ambil id topik dari URL dan pastikan formatnya angka
    $id_post = $_GET["id_post"] ?? "";
    if (!id_valid($id_post)) {
        header("Location: topik_saya.php");
        exit;
    }
    $id_post = (int)$id_post;

    // Topik hanya boleh diedit oleh pemiliknya
    $topik = ambil_topik_milik($id_post, $id_User);
    if (!$topik) {
        header("Location: topik_saya.php");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        // Ambil masukan dari form
        $title       = ambil_post("title");
        $content     = ambil_post("content");
        $id_categori = ambil_post("id_categori");

        // Validasi masukan di server
        $error = validasi_topik($error, $title, $content, $id_categori);

        // Jika valid, simpan perubahan
        if (empty($error)) {
            update_topik($id_post, $id_User, (int)$id_categori, $title, $content);
            header("Location: topik_saya.php?pesan=diubah");
            exit;
        }
    } else {

        // Pertama kali dibuka: isi form dengan data topik saat ini
        $title       = $topik["title"];
        $content     = $topik["content"];
        $id_categori = (string)$topik["id_categori"];
    }

    // Daftar kategori untuk pilihan di form
    $daftar_kategori = ambil_kategori();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Topik Diskusi</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/halaman.css">
</head>
<body>

    <header>
        <h1>Edit Topik Diskusi</h1>
    </header>

    <?php tampil_navbar("../"); ?>

    <main>

        <form action="edit_topik.php?id_post=<?= $id_post ?>" method="post">

            <!-- Judul topik -->
            <div class="form-grup">
                <label for="title">Judul Topik</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars($title) ?>">
                <?php if (isset($error["title"])) { ?>
                    <small class="error"><?= $error["title"] ?></small>
                <?php } ?>
            </div>

            <!-- Kategori topik -->
            <div class="form-grup">
                <label for="id_categori">Kategori</label>
                <select id="id_categori" name="id_categori">
                    <option value="">-- Pilih kategori --</option>
                    <?php foreach ($daftar_kategori as $k) { ?>
                        <option value="<?= (int)$k["id_categori"] ?>"
                            <?= ((string)$k["id_categori"] === $id_categori) ? "selected" : "" ?>>
                            <?= htmlspecialchars($k["nama_kategori"]) ?>
                        </option>
                    <?php } ?>
                </select>
                <?php if (isset($error["id_categori"])) { ?>
                    <small class="error"><?= $error["id_categori"] ?></small>
                <?php } ?>
            </div>

            <!-- Isi topik -->
            <div class="form-grup">
                <label for="content">Isi Topik</label>
                <textarea id="content" name="content"><?= htmlspecialchars($content) ?></textarea>
                <?php if (isset($error["content"])) { ?>
                    <small class="error"><?= $error["content"] ?></small>
                <?php } ?>
            </div>

            <button type="submit">Simpan Perubahan</button>
            <a href="topik_saya.php">Batal</a>
        </form>

    </main>

</body>
</html>
