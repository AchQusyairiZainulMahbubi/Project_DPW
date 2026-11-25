<?php
    session_start();

    include "config/koneksi.php";
    include "fungsi.php";
    include "component/navbar.php";

    // Status login: true jika user sudah login
    $sudah_login = isset($_SESSION["id_User"]);

    // Ambil seluruh topik (hanya topik, tanpa komentar)
    $daftar = daftar_topik("semua", 0);
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

    <!-- Bagian judul halaman -->
    <header>
        <?php if (!$sudah_login) { ?>
            <div class="card">
                <a href="auth/login.php">Login</a>
                <a href="auth/register.php">Register</a>
            </div>
        <?php } ?>
        <h1>FORUM DISKUSI</h1>
        <h2>Selamat Datang di Forum Diskusi</h2>
        <p>Tempat berbagi informasi dan pengetahuan.</p>
    </header>
    
    <!-- Menu navigasi (hanya tampil jika sudah login) -->
    <?php tampil_navbar(""); ?>

    <main>

        <!-- Bagian sapaan: berbeda untuk user login dan pengunjung -->
        <?php if ($sudah_login) { ?>

            <h3>Halo, <?= htmlspecialchars($_SESSION["username"]) ?></h3>

            <p>Role: <?= htmlspecialchars($_SESSION["role"]) ?></p>

            <?php if ($_SESSION["role"] === "client") { ?>

                <p>Anda login sebagai Client. Anda dapat membuat topik diskusi, mengedit topik Anda, dan melihat topik client lain.</p>

            <?php } else if ($_SESSION["role"] === "expert") { ?>

                <p>Anda login sebagai Expert. Anda dapat merespon topik client, mengedit respon Anda, dan melihat seluruh topik diskusi.</p>

            <?php } ?>

        <?php } else { ?>
            <p><em>Login untuk melihat komentar pada setiap topik.</em></p>

        <?php } ?>

        <!-- Bagian daftar topik diskusi -->
        <h2>Daftar Topik Diskusi</h2>

        <?php if (count($daftar) === 0) { ?>

            <p>Belum ada topik diskusi.</p>

        <?php } else { ?>

            <?php foreach ($daftar as $t) { ?>

                <?php
                    // Tujuan link: halaman detail jika sudah login, halaman login jika belum
                    if ($sudah_login) {
                        $role = $_SESSION["role"] ?? "";
                        if ($role === "expert") {
                            $link = "expert/komentar.php?id_post=" . (int)$t["id_post"];
                        } else if ((int)$t["id_User"] === (int)$_SESSION["id_User"]) {
                            $link = "client/topik_saya.php";
                        } else {
                            $link = "client/topik_lain.php";
                        }
                    } else {
                        $link = "auth/login.php";
                    }

                    // Ringkasan isi topik (maksimal 200 karakter)
                    $ringkas = mb_strimwidth($t["content"], 0, 200, "...");
                ?>

                <article class="topik">
                    <h3><a href="<?= $link ?>"><?= htmlspecialchars($t["title"]) ?></a></h3>

                    <small>
                        Oleh <?= htmlspecialchars($t["username"]) ?>
                        | Kategori: <?= htmlspecialchars($t["nama_kategori"] ?? "-") ?>
                        | <?= htmlspecialchars($t["created_time"]) ?>
                    </small>

                    <p><?= nl2br(htmlspecialchars($ringkas)) ?></p>

                    <a href="<?= $link ?>">Lihat Komentar</a>
                </article>

            <?php } ?>

        <?php } ?>

    </main>

</body>
</html>