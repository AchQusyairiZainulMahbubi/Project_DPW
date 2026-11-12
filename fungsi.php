<?php
    function is_required($variabel) {
        $variabel = trim($variabel);
        return empty($variabel);
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

function register($error, $username, $email, $password, $role) {
    $regex_us = "/^[a-zA-Z0-9_]+$/";
    $regex_email = "/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,6}$/";
    $regex_pass = "/^[0-9A-Za-z!@#$%^&*()_+]{8,}$/";

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

    if (is_required($password)) {
        $error["password"] = "Password tidak boleh kosong";
    } else if (!preg_match($regex_pass, $password)) {
        $error["password"] = "Password harus terdiri dari minimal 8 karakter dan mengandung huruf, angka, serta simbol";
    }

    if (is_required($role)) {
        $error["role"] = "Role tidak boleh kosong";
    } else if (!in_array($role, ["client", "expert"], true)) {
        $error["role"] = "Role tidak valid";
    }

    return $error;
}

?>