<?php
    function is_required($variabel) {
        $variabel = trim($variabel);
        return $variabel === "";
    }

    function panjang_valid($teks, $min, $max) {
        $panjang = mb_strlen(trim($teks));
        return $panjang >= $min && $panjang <= $max;
    }

    // minimal 8 karakter, wajib ada huruf, angka, dan simbol
    function format_password_valid($password) {
        $regex_pass = '/^(?=.*[A-Za-z])(?=.*[0-9])(?=.*[!@#$%^&*()_+])[0-9A-Za-z!@#$%^&*()_+]{8,}$/';
        return preg_match($regex_pass, $password) === 1;
    }

    // Mengecek apakah nilai berupa angka bulat positif (untuk id dari URL/form)
    function id_valid($nilai) {
        return is_string($nilai) && ctype_digit($nilai) && (int)$nilai > 0;
    }

    // Mengambil nilai teks dari $_POST dan membuang spasi di awal/akhir
    function ambil_post($nama) {
        $nilai = $_POST[$nama] ?? "";
        return is_string($nilai) ? trim($nilai) : "";
    }

    // Validasi form login
    function login($username, $password) {

        $error = [];

        if (is_required($username)) {
            $error["username"] = "Username tidak boleh kosong";
        }

        if (is_required($password)) {
            $error["password"] = "Password tidak boleh kosong";
        }

        return $error;
    }

    // Validasi form register
    function register($error, $username, $email, $password, $role) {
        $regex_us = "/^[a-zA-Z0-9_]+$/";
        $regex_email = "/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,6}$/";

        // Username: wajib dan alfanumerik (boleh underscore)
        if (is_required($username)) {
            $error["username"] = "Username tidak boleh kosong";
        } else if (!preg_match($regex_us, $username)) {
            $error["username"] = "Username hanya boleh berisi huruf, angka, dan underscore";
        }

        // Email: wajib dan format email valid
        if (is_required($email)) {
            $error["email"] = "Email tidak boleh kosong";
        } else if (!preg_match($regex_email, $email)) {
            $error["email"] = "Format email tidak valid";
        }

        // Password: wajib dan sesuai format password
        if (is_required($password)) {
            $error["password"] = "Password tidak boleh kosong";
        } else if (!format_password_valid($password)) {
            $error["password"] = "Password harus terdiri dari minimal 8 karakter dan mengandung huruf, angka, serta simbol";
        }

        // Role: wajib dan hanya boleh client / expert
        if (is_required($role)) {
            $error["role"] = "Role tidak boleh kosong";
        } else if (!in_array($role, ["client", "expert"], true)) {
            $error["role"] = "Role tidak valid";
        }

        return $error;
    }

    // Validasi form edit profil
    function validasi_profil($error, $username, $email, $password) {
        $regex_us = "/^[a-zA-Z0-9_]+$/";
        $regex_email = "/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,6}$/";

        if (is_required($username)) {
            $error["username"] = "Username tidak boleh kosong";
        } else if (!preg_match($regex_us, $username)) {
            $error["username"] = "Username hanya boleh berisi huruf, angka, dan underscore";
        }

        if (is_required($email)) {
            $error["email"] = "Email tidak boleh kosong";
        } else if (!preg_match($regex_email, $email)) {
            $error["email"] = "Format email tidak valid";
        }

        // Password opsional saat edit: hanya divalidasi jika diisi
        if (!is_required($password) && !format_password_valid($password)) {
            $error["password"] = "Password harus terdiri dari minimal 8 karakter dan mengandung huruf, angka, serta simbol";
        }

        return $error;
    }

    // Validasi form topik diskusi (compose dan edit) oleh client
    function validasi_topik($error, $title, $content, $id_categori) {

        // Judul: wajib dan panjang 5 - 100 karakter
        if (is_required($title)) {
            $error["title"] = "Judul topik tidak boleh kosong";
        } else if (!panjang_valid($title, 5, 100)) {
            $error["title"] = "Judul topik harus 5 sampai 100 karakter";
        }

        // Isi topik: wajib dan panjang 10 - 2000 karakter
        if (is_required($content)) {
            $error["content"] = "Isi topik tidak boleh kosong";
        } else if (!panjang_valid($content, 10, 2000)) {
            $error["content"] = "Isi topik harus 10 sampai 2000 karakter";
        }

        // Kategori: wajib, berupa angka, dan harus ada di tabel category
        if (is_required($id_categori)) {
            $error["id_categori"] = "Kategori harus dipilih";
        } else if (!id_valid($id_categori)) {
            $error["id_categori"] = "Kategori tidak valid";
        } else if (!kategori_ada((int)$id_categori)) {
            $error["id_categori"] = "Kategori tidak ditemukan";
        }

        return $error;
    }

    // Validasi form respon (komentar) oleh expert
    function validasi_balasan($error, $isi) {

        // Isi respon: wajib dan panjang 5 - 1000 karakter
        if (is_required($isi)) {
            $error["isi"] = "Isi respon tidak boleh kosong";
        } else if (!panjang_valid($isi, 5, 1000)) {
            $error["isi"] = "Isi respon harus 5 sampai 1000 karakter";
        }

        return $error;
    }
    
    // Mengambil data satu user berdasarkan id
    function select_id($id) {
        global $koneksi;
        $stmt = mysqli_prepare($koneksi, "SELECT * FROM `user` WHERE id_User = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }

    // Mengecek apakah username sudah dipakai user lain
    function username_dipakai($username, $id) {
        global $koneksi;
        $stmt = mysqli_prepare($koneksi, "SELECT id_User FROM `user` WHERE username = ? AND id_User <> ?");
        mysqli_stmt_bind_param($stmt, "si", $username, $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_num_rows($result) > 0;
    }

    // Memperbarui profil user. Password hanya diganti jika diisi.
    function update_profil($id, $username, $email, $password) {
        global $koneksi;

        if (!is_required($password)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($koneksi,
                "UPDATE `user` SET username = ?, email = ?, password = ? WHERE id_User = ?");
            mysqli_stmt_bind_param($stmt, "sssi", $username, $email, $hash, $id);
        } else {
            $stmt = mysqli_prepare($koneksi,
                "UPDATE `user` SET username = ?, email = ? WHERE id_User = ?");
            mysqli_stmt_bind_param($stmt, "ssi", $username, $email, $id);
        }

        return mysqli_stmt_execute($stmt);
    }

    // Mengambil seluruh kategori
    function ambil_kategori() {
        global $koneksi;
        $result = mysqli_query($koneksi, "SELECT id_categori, nama_kategori FROM category ORDER BY nama_kategori ASC");
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // Mengecek apakah kategori dengan id tertentu ada
    function kategori_ada($id_categori) {
        global $koneksi;
        $stmt = mysqli_prepare($koneksi, "SELECT id_categori FROM category WHERE id_categori = ?");
        mysqli_stmt_bind_param($stmt, "i", $id_categori);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_num_rows($result) > 0;
    }

    // Menyimpan topik diskusi baru
    function tambah_topik($id_user, $id_categori, $title, $content) {
        global $koneksi;
        $stmt = mysqli_prepare($koneksi,
            "INSERT INTO post (id_User, id_categori, title, content) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "iiss", $id_user, $id_categori, $title, $content);
        return mysqli_stmt_execute($stmt);
    }

    // Mengambil satu topik beserta nama pembuat dan nama kategorinya
    function ambil_topik($id_post) {
        global $koneksi;
        $stmt = mysqli_prepare($koneksi,
            "SELECT post.*, `user`.username, category.nama_kategori
             FROM post
             JOIN `user` ON post.id_User = `user`.id_User
             LEFT JOIN category ON post.id_categori = category.id_categori
             WHERE post.id_post = ?");
        mysqli_stmt_bind_param($stmt, "i", $id_post);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }

    // Mengambil satu topik HANYA jika dimiliki oleh user tersebut
    function ambil_topik_milik($id_post, $id_user) {
        global $koneksi;
        $stmt = mysqli_prepare($koneksi, "SELECT * FROM post WHERE id_post = ? AND id_User = ?");
        mysqli_stmt_bind_param($stmt, "ii", $id_post, $id_user);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }

    // Memperbarui topik (hanya jika milik user yang bersangkutan)
    function update_topik($id_post, $id_user, $id_categori, $title, $content) {
        global $koneksi;
        $stmt = mysqli_prepare($koneksi,
            "UPDATE post SET id_categori = ?, title = ?, content = ? WHERE id_post = ? AND id_User = ?");
        mysqli_stmt_bind_param($stmt, "issii", $id_categori, $title, $content, $id_post, $id_user);
        return mysqli_stmt_execute($stmt);
    }

    function daftar_topik($mode, $id_user) {
        global $koneksi;

        // Query dasar: topik + nama pembuat + nama kategori
        $dasar = "SELECT post.id_post, post.id_User, post.title, post.content, post.created_time,
                         `user`.username, category.nama_kategori
                  FROM post
                  JOIN `user` ON post.id_User = `user`.id_User
                  LEFT JOIN category ON post.id_categori = category.id_categori";
        $urut = " ORDER BY post.created_time DESC, post.id_post DESC";

        if ($mode === "semua") {
            $stmt = mysqli_prepare($koneksi, $dasar . $urut);
        } else {
            if ($mode === "milik") {
                $where = " WHERE post.id_User = ?";
            } else if ($mode === "lain") {
                $where = " WHERE post.id_User <> ?";
            } else {
                $where = " WHERE post.id_post IN (SELECT id_post FROM comments WHERE id_User = ?)";
            }
            $stmt = mysqli_prepare($koneksi, $dasar . $where . $urut);
            mysqli_stmt_bind_param($stmt, "i", $id_user);
        }

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    function ambil_balasan($id_post) {
        global $koneksi;
        $stmt = mysqli_prepare($koneksi,
            "SELECT comments.id_komen, comments.id_User, comments.isi, comments.waktu_buat, `user`.username
             FROM comments
             JOIN `user` ON comments.id_User = `user`.id_User
             WHERE comments.id_post = ?
             ORDER BY comments.waktu_buat ASC, comments.id_komen ASC");
        mysqli_stmt_bind_param($stmt, "i", $id_post);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // Menyimpan respon baru dari expert
    function tambah_balasan($id_user, $id_post, $isi) {
        global $koneksi;
        $stmt = mysqli_prepare($koneksi,
            "INSERT INTO comments (id_User, id_post, isi) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "iis", $id_user, $id_post, $isi);
        return mysqli_stmt_execute($stmt);
    }

    // Mengambil satu respon HANYA jika dimiliki oleh user tersebut (beserta judul topiknya)
    function ambil_balasan_milik($id_komen, $id_user) {
        global $koneksi;
        $stmt = mysqli_prepare($koneksi,
            "SELECT comments.*, post.title
             FROM comments
             JOIN post ON comments.id_post = post.id_post
             WHERE comments.id_komen = ? AND comments.id_User = ?");
        mysqli_stmt_bind_param($stmt, "ii", $id_komen, $id_user);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }

    // Memperbarui respon (hanya jika milik expert yang bersangkutan)
    function update_balasan($id_komen, $id_user, $isi) {
        global $koneksi;
        $stmt = mysqli_prepare($koneksi,
            "UPDATE comments SET isi = ? WHERE id_komen = ? AND id_User = ?");
        mysqli_stmt_bind_param($stmt, "sii", $isi, $id_komen, $id_user);
        return mysqli_stmt_execute($stmt);
    }

    function wajib_role($role, $base) {
        if (!isset($_SESSION["id_User"]) || ($_SESSION["role"] ?? "") !== $role) {
            header("Location: " . $base . "auth/login.php");
            exit;
        }
    }
?>
