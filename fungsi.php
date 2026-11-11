<?php
function is_required($vara) {
    $vara = trim($vara);
    return empty($vara);
}

function validasi_username(&$error, $username) {
    $regex = "/^[a-zA-Z0-9_]+$/"; // Ditambahkan titik koma (;)

    if (is_required($username)) {
        $error["username"] = "Username tidak boleh kosong";
    } else if (!preg_match($regex, $username)) {
        $error["username"] = "Username hanya boleh berisi huruf, angka, dan underscore";
    }
}

function validasi_email(&$error, $email) {
    $regex = "/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,6}$/";

    if (is_required($email)) {
        $error["email"] = "Email tidak boleh kosong";
    } else if (!preg_match($regex, $email)) {
        $error["email"] = "Format email tidak valid";
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

// validasi password
function validasi_pass(&$error, $password) {
    $regex = "/^[0-9A-Za-z!@#$%^&*()_+]{8,}$/";

    if (is_required($password)) {
        $error["password"] = "Password tidak boleh kosong";
    } else if (!preg_match($regex, $password)) {
        $error["password"] = "Password harus terdiri dari minimal 8 karakter dan mengandung huruf, angka, serta simbol";
    }   
}


function validasi_role(&$error, $role) {
    if (!in_array($role, ["client", "expert"], true)) {
        $error["role"] = "Role tidak valid";
    }
}


// validasi tanggal
function tanggal($error, $tanggal) {
    $regex = "/^(0[1-9]|[12][0-9]|3[01])[- /.](0[1-9]|1[0-2])[- /.](19|20)\d\d$/";

    if (is_required($tanggal)) {
        $error["tanggal"] = "Tanggal tidak boleh kosong";
    } else if (!preg_match($regex, $tanggal)) {
        $error["tanggal"] = "Format tanggal tidak valid";
    }
}



function login($error, $username, $password) {
    // Lakukan validasi login
    if (is_required($username)) {
        $error["username"] = "Username tidak boleh kosong";
    }
    if (is_required($password)) {
        $error["password"] = "Password tidak boleh kosong";
    }

    return $error;
}


?>