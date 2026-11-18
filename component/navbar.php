<?php
    function tampil_navbar($base) {

        if (!isset($_SESSION["id_User"])) {
            return;
        }

        $role = $_SESSION["role"] ?? "";
        ?>
        <nav class="navbar">
            <a href="<?= $base ?>index.php">Beranda</a>

            <?php if ($role === "client") { ?>
                <a href="<?= $base ?>client/buat_topik.php">Buat Topik</a>
                <a href="<?= $base ?>client/topik_saya.php">Topik Saya</a>
                <a href="<?= $base ?>client/topik_lain.php">Topik Client Lain</a>
            <?php } else if ($role === "expert") { ?>
                <a href="<?= $base ?>expert/semua_topik.php">Semua Topik</a>
                <a href="<?= $base ?>expert/topik_direspon.php">Topik yang Saya Respon</a>
            <?php } ?>

            <a href="<?= $base ?>component/profil.php">Profil</a>
            <a href="<?= $base ?>auth/logout.php">Logout</a>
        </nav>
        <?php
    }
?>
