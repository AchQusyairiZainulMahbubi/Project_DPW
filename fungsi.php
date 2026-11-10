<?php
function is_required($vara) {
    $vara = trim($vara);
    return empty($vara);
}

function validasi_nama(&$error, $nama) {
    $regex = "/^[a-zA-Z\s]+$/"; // Ditambahkan titik koma (;)

    if (is_required($nama)) {
        $error["nama"] = "Nama tidak boleh kosong";
    } else if (!preg_match($regex   , $nama)) {
        $error["nama"] = "Nama hanya boleh berisi huruf dan spasi";
    }
}


// fungsi untuk memvalidasi no hp apakah 2 nomor awalanya 08/62 dan jumlahnya harus 11/12
function validasi_no($variabel) {
    $regex = '/^(08|62)\d{9,10}$/';
    return preg_match($regex, $variabel) === 1;
}

// fungsi untuk memvalidasi jumlah huruf 
function validasi_jumlah_huruf($variabel) {
    $regex = '/^[\w ]{60,}$/';
    // menggunakan operator ! untuk membalikkan nilai boolean
    return preg_match($regex, $variabel) === 0;
} 

// validasi alamat



?>