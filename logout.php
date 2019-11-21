<?php
session_start();
if(isset($_SESSION['user_angket'])) {
  session_unset();
  session_destroy();

  header ("Location: login.php");
} elseif(isset($_SESSION['admin_angket'])) {
  session_unset();
  session_destroy();

  header ("Location: login.php");
} else {
  header ("Location: login.php");
}

 ?>
