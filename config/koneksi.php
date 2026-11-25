<?php

    $koneksi = mysqli_connect("localhost", "root", "", "forum");

    if (!$koneksi) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

?>