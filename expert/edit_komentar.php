<?php
    session_start();

    include "../config/koneksi.php";
    include "../fungsi.php";
    include "../component/navbar.php";

    // Hanya expert yang boleh membuka halaman ini
    wajib_role("expert", "../");

    $error = [];
    $id_User = (int)$_SESSION["id_User"];

    // Ambil id respon dari URL dan pastikan formatnya angka
    $id_komen = $_GET["id_komen"] ?? "";
    if (!id_valid($id_komen)) {
        header("Location: topik_direspon.php");
        exit;
    }
    $id_komen = (int)$id_komen;

    // Respon hanya boleh diedit oleh penulisnya
    $komentar = ambil_balasan_milik($id_komen, $id_User);
    if (!$komentar) {
        header("Location: topik_direspon.php");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        // Ambil masukan dari form
        $isi = ambil_post("isi");

        // Validasi isi respon di server
        $error = validasi_balasan($error, $isi);

        // Jika valid, simpan perubahan lalu kembali ke halaman topik
        if (empty($error)) {
            update_balasan($id_komen, $id_User, $isi);
            header("Location: komentar.php?id_post=" . (int)$komentar["id_post"] . "&pesan=diubah");
            exit;
        }
    } else {

        // Pertama kali dibuka: isi form dengan respon saat ini
        $isi = $komentar["isi"];
    }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Respon</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/halaman.css">
</head>
<body>

    <header>
        <h1>Edit Respon</h1>
    </header>

    <?php tampil_navbar("../"); ?>

    <main>

        <p>Topik: <strong><?= htmlspecialchars($komentar["title"]) ?></strong></p>

        <form action="edit_komentar.php?id_komen=<?= $id_komen ?>" method="post">

            <div class="form-grup">
                <label for="isi">Isi Respon</label>
                <textarea id="isi" name="isi"><?= htmlspecialchars($isi) ?></textarea>
                <?php if (isset($error["isi"])) { ?>
                    <small class="error"><?= $error["isi"] ?></small>
                <?php } ?>
            </div>

            <button type="submit">Simpan Perubahan</button>
            <a href="komentar.php?id_post=<?= (int)$komentar["id_post"] ?>">Batal</a>
        </form>

    </main>

</body>
</html>
