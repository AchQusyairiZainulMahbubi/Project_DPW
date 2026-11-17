
<?php

session_start();
include "koneksi.php";

// Mengambil ID pengguna
$id_User = $_SESSION['id_User'] ?? null;

// Mengambil isi komentar
$isi = trim($_POST['isi'] ?? '');

// Memeriksa pengguna
if (!$id_User) {
    die("Silakan login terlebih dahulu.");
}

// Memeriksa komentar
if ($isi === '') {
    die("Komentar tidak boleh kosong.");
}

// Menyimpan komentar forum
$query = mysqli_prepare($koneksi, "
    INSERT INTO comments (id_User, id_post, isi)
    VALUES (?, NULL, ?)
");

mysqli_stmt_bind_param($query, "is", $id_User, $isi);

if (mysqli_stmt_execute($query)) {

    header("Location: komentar.php");
    exit;

} else {

    echo "Gagal menambahkan komentar.";

}

?>
