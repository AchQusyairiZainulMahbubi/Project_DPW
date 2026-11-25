<?php

    $koneksi = mysqli_connect("localhost", "root", "", "forumbaru");

    if (!$koneksi) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

?>