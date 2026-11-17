
<?php

session_start();
include "koneksi.php";

// Mengambil seluruh komentar forum
$query = mysqli_query($koneksi, "
    SELECT
        comments.id_komen,
        comments.isi,
        comments.waktu_buat,
        user.username,
        user.avatar
    FROM comments
    JOIN user ON comments.id_User = user.id_User
    WHERE comments.id_post IS NULL
    ORDER BY comments.waktu_buat DESC
");

?>

<h1>Forum Diskusi</h1>

<hr>

<h2>Daftar Komentar</h2>

<?php if (mysqli_num_rows($query) > 0) { ?>

    <?php while ($komentar = mysqli_fetch_assoc($query)) { ?>

        <div>

            <h3>
                <?= htmlspecialchars($komentar['username']) ?>
            </h3>

            <p>
                <?= nl2br(htmlspecialchars($komentar['isi'])) ?>
            </p>

            <small>
                <?= htmlspecialchars($komentar['waktu_buat']) ?>
            </small>

        </div>

        <hr>

    <?php } ?>

<?php } else { ?>

    <p>Belum ada komentar. Jadilah yang pertama berkomentar!</p>

<?php } ?>


<h2>Tambahkan Komentar</h2>

<?php if (isset($_SESSION['id_User'])) { ?>

    <form action="simpan_komentar.php" method="POST">

        <textarea name="isi"    ></textarea>

        <br>

        <button type="submit">Kirim Komentar</button>

    </form>

<?php } else { ?>

    <p>Silakan login untuk memberikan komentar.</p>

<?php } ?>
