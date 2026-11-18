<?php
    // ==================================================================
    // expert/simpan_komentar.php
    // Memproses form respon dari komentar.php:
    // validasi -> simpan ke tabel comments -> kembali ke komentar.php
    // ==================================================================

    session_start();

    include "../config/koneksi.php";
    include "../fungsi.php";

    // Hanya expert yang boleh menyimpan respon
    wajib_role("expert", "../");

    // Halaman ini hanya menerima kiriman form (POST)
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header("Location: semua_topik.php");
        exit;
    }

    $id_User = (int)$_SESSION["id_User"];
    $id_post = $_POST["id_post"] ?? "";
    $isi     = ambil_post("isi");

    // Pastikan id topik valid dan topiknya ada
    if (!id_valid($id_post) || !ambil_topik((int)$id_post)) {
        header("Location: semua_topik.php");
        exit;
    }
    $id_post = (int)$id_post;

    // Validasi isi respon di server
    $error = validasi_balasan([], $isi);

    if (!empty($error)) {

        // Simpan error dan isian sementara di session, lalu kembali ke form
        $_SESSION["flash_error"] = $error;
        $_SESSION["flash_isi"]   = $isi;
        header("Location: komentar.php?id_post=" . $id_post);
        exit;
    }

    // Jika valid, simpan respon lalu kembali ke halaman topik
    tambah_balasan($id_User, $id_post, $isi);
    header("Location: komentar.php?id_post=" . $id_post . "&pesan=dibuat");
    exit;
?>
