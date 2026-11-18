<?php
    function tampil_balasan($balasan, $boleh_edit) {

        if (count($balasan) === 0) {
            echo "<p><em>Belum ada respon dari expert.</em></p>";
            return;
        }

        $id_login = (int)($_SESSION["id_User"] ?? 0);

        foreach ($balasan as $b) {
            ?>
            <div class="balasan">
                <strong><?= htmlspecialchars($b["username"]) ?></strong>
                <small>(<?= htmlspecialchars($b["waktu_buat"]) ?>)</small>
                <p><?= nl2br(htmlspecialchars($b["isi"])) ?></p>

                <?php if ($boleh_edit && (int)$b["id_User"] === $id_login) { ?>
                    <a href="edit_komentar.php?id_komen=<?= (int)$b["id_komen"] ?>">Edit Respon</a>
                <?php } ?>
            </div>
            <?php
        }
    }

    function tampil_topik($daftar, $aksi) {

        if (count($daftar) === 0) {
            echo "<p>Belum ada topik diskusi.</p>";
            return;
        }

        foreach ($daftar as $t) {

            // Ambil respon expert untuk topik ini
            $balasan = ambil_balasan((int)$t["id_post"]);
            ?>
            <article class="topik">
                <h3><?= htmlspecialchars($t["title"]) ?></h3>
                <small>
                    Oleh <?= htmlspecialchars($t["username"]) ?>
                    | Kategori: <?= htmlspecialchars($t["nama_kategori"] ?? "-") ?>
                    | <?= htmlspecialchars($t["created_time"]) ?>
                </small>

                <p><?= nl2br(htmlspecialchars($t["content"])) ?></p>

                <?php if ($aksi === "edit_client") { ?>
                    <a href="edit_topik.php?id_post=<?= (int)$t["id_post"] ?>">Edit Topik</a>
                <?php } else if ($aksi === "balas_expert") { ?>
                    <a href="komentar.php?id_post=<?= (int)$t["id_post"] ?>">Balas Topik</a>
                <?php } ?>

                <h4>Respon Expert (<?= count($balasan) ?>)</h4>
                <?php tampil_balasan($balasan, $aksi === "balas_expert"); ?>
            </article>
            <?php
        }
    }
?>
