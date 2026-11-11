<?php
session_start();
require "koneksi.php";
require "fungsi.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: register.php");
    exit;
}

$error    = [];
$username = trim($_POST["username"] ?? "");
$email    = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";
$role     = $_POST["role"] ?? "";

// 1. Validasi memakai fungsi dari fungsi.php
validasi_username($error, $username);
validasi_email($error, $email);
validasi_pass($error, $password);
validasi_role($error, $role);

// 2. Cek duplikat (hanya kalau format sudah benar)
if (empty($error)) {
    $cek = mysqli_prepare($koneksi,
        "SELECT username, email FROM user WHERE username = ? OR email = ?");
    mysqli_stmt_bind_param($cek, "ss", $username, $email);
    mysqli_stmt_execute($cek);
    $hasil = mysqli_stmt_get_result($cek);

    while ($row = mysqli_fetch_assoc($hasil)) {
        if ($row["username"] === $username) $error["username"] = "Username sudah dipakai";
        if ($row["email"] === $email)       $error["email"]    = "Email sudah terdaftar";
    }
}

// 3. Ada error: kembali ke form
if (!empty($error)) {
    $_SESSION["error"] = $error;
    $_SESSION["old"]   = ["username" => $username, "email" => $email, "role" => $role];
    header("Location: register.php");
    exit;
}

// 4. Simpan ke database
$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = mysqli_prepare($koneksi,
    "INSERT INTO user (username, email, password, role) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hash, $role);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION["sukses"] = "Registrasi berhasil, silakan login";
    header("Location: login.php");
    exit;
}

$_SESSION["error"] = ["username" => "Registrasi gagal, coba lagi"];
$_SESSION["old"]   = ["username" => $username, "email" => $email, "role" => $role];
header("Location: register.php");
exit;