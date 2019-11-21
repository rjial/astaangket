<?php
$bekgroon = scandir("img/");
$bekgron = array_diff($bekgroon, array('.', '..'));
$array_bekgron = array_rand($bekgron,1);

 ?>

    body {
      background-image: url('img/<?php print_r($bekgron[$array_bekgron]); ?>') !important;
      <!-- background-repeat: no-repeat; -->
      background-attachment: fixed;
      <!-- background-position: center;  -->
      <!-- background-size: cover; -->
      <!-- background-position: 0 0; -->
      <!-- background-repeat: no-repeat; -->
      <!-- background-size: auto; -->
      background-size: cover;
    }
