<?php
$koneksi = mysqli_connect("localhost", "root", "", "data_tubes");

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
