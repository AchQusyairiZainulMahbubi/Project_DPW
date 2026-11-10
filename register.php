<?php
require "fungsi.php";

$error = [];
if($_SERVER['REQUEST_METHOD']=== "POST"){
	$nama = $_POST['no'];
	$pass = $_POST['password'];
	$nim = $_POST['username'];

	validasi_nama($error, $nama);
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>DAFTAR DULU</h1><p></p>
    <form action="register.php" method="post" >
        <label for="username">masukan nama</label>
        <input type="text" name="username"><span style="color: red;"><?php echo $error['nama']??"" ?></span>
        <p></p>
        <label for="password">masukan password</label>
        <input type="text" name="password">
        <br>
        <label for="no" >masukan no hp</label>
        <input type="text" name="no">
        <br><br>
        <button type="register" name="register">register</button>
    </form>
</body>
</html>