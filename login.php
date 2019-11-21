<?php
include('config.php');
session_start();
if (isset($_SESSION['user_angket'])) {
    header ("Location: cp.php");
}

if (isset($_SESSION['admin_angket'])) {
    header ("Location: admin.php");
}

if (isset($_POST['submit_login'])) {
  $user_login = $_POST['user_angket'];
  $pass_login = $_POST['pass_angket'];
  $salah = 0;

  if (isset($user_login) && isset($pass_login)) {
    $pass_login = md5($pass_login);
    $user_login = addslashes($user_login);


    $cek_ada = mysqli_query($connectdb, "SELECT * FROM siswa WHERE nis='$user_login' AND pass='$pass_login'");
    if (mysqli_num_rows($cek_ada) > 0) {
      while ($id = mysqli_fetch_assoc($cek_ada)) {
        $id_login = $id['id'];
        $bagi_kelas = explode(" ", $id['kelas']);
      }
      $ke_cp = True;
      $_SESSION['user_angket'] = $id_login;
      $_SESSION['kelas_angket'] = $bagi_kelas[0];
      $_SESSION['jurusan_angket'] = $bagi_kelas[1];
    } else {
      $cek_ada2 = mysqli_query($connectdb, "SELECT * FROM admin WHERE user='$user_login' AND pass='$pass_login'");
      if (mysqli_num_rows($cek_ada2) > 0) {
        while ($id = mysqli_fetch_assoc($cek_ada2)) {
          $id_login = $id['id'];
        }
        $ke_cp = False;
        $_SESSION['admin_angket'] = $id_login;
      } else {
        $salah = $salah + 0;
      }
    }
  } else {
    $salah = $salah + 0;
  }

  if (isset($salah) && $salah == True) {
    $_SESSION['salah'] = True;
  } else {
    if (isset($ke_cp) && $ke_cp == True) {
      header ("Location: cp.php");
    } elseif (isset($ke_cp) && $ke_cp == False) {
      header ("Location: admin.php");
    }
  }
}

?>


<html>
  <head>
<title>Login | Asta Angket</title>
    <link rel="stylesheet" href="fonts/fonts.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="css/main.css">
    <style>
    <?php
    // include 'bekgron.php';
     ?>
    </style>
  </head>

  
   <body class="red darken-2">
    <main>
    <div class="row">
      <div class="col m8 l4 s12" id="senta">
        <div class="card white z-depth-3">
          <div class="card-content" align="center">

            <h5>Login</h5>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>"
            <div class="row">
              <div class="input-field col s12  l12">
                <input name="user_angket" type="text" id="user_angket">
                <label class="active" for="user_angket">Username</label>
              </div>
              <div class="input-field col s12 l12">
                <input name="pass_angket" type="password" id="pass_angket">
                <label class="active" for="pass_angket">Password</label>
              </div>
              <div align="center col  s12 l12">
                <input type="submit" name="submit_login" class="btn blue waves-effect waves-light" value="Login"/>
              </div>
            </div>

          </form>
          </div>
        </div>
      </div>
    </div>
  </main>

<footer class="page-footer grey darken-3 z-depth-3" style="display:">
  <div class="footer-copyright">
    <div class="container">
    © 2018 Copyrekt - Powered By tuxsenpaai
    <!-- <a class="grey-text text-lighten-4 right " href="#!">More Links</a> -->
    </div>
  </div>
</footer>
  </body>
</html>
