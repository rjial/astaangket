<?php
include('config.php');
session_start();

$cek_mmatppel = mysqli_query($connectdb, "SELECT * FROM matpel where muncul='on'");
echo mysqli_num_rows($cek_mmatppel);

 ?>
