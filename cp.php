<?php
include('config.php');
session_start();
$id_siswa = $_SESSION['user_angket'];
$kelas =  $_SESSION['kelas_angket'];
?>

<html>
  <head>
    <!-- <link rel="stylesheet" href="css/w3.css"> -->
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="fonts/fonts.css">
    <link rel="stylesheet" href="icon/fonts.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
      <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <script src="js/jquery-2.1.1.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script type="text/javascript" src="js/main.js"></script>
    <style>
      body {
        font-family: "Roboto", sans-serif;
      }
      <?php
      // include 'bekgron.php';
       ?>
    </style>
  </head>

    <body class="grey">

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <nav>
  <div class="nav-wrapper grey darken-4">
    <a href="#" class="brand-logo center">Asta Angket</a>
    <ul class="left">
        <li><a href="#" data-target="slide-out" class="sidenav-trigger  show-on-large"><i class="material-icons">menu</i></a></li>
      </ul>
  </div>
</nav>
<ul id="slide-out" class="sidenav grey darken-3 white-text">
    <li><div class="user-view">

      <?php
      $cek_nama = mysqli_query($connectdb, "SELECT * FROM siswa WHERE id='$id_siswa'");
      while ($nama = mysqli_fetch_assoc($cek_nama)) {
        ?>
        <span class="name"><?php echo $nama['nama']; ?></span>
        <span class="name"><?php echo $nama['kelas']; ?></span>
        <span class="name"><?php echo $nama['nis']; ?></span>
        <br />
        <?php
      }
      ?>
      <li><div class="divider"></div></li>
      <li><a href="logout.php" class="white-text btn"><i class="material-icons white-text">arrow_back</i>Log Out</a></li>
      <!-- <a href="#user"><img class="circle" src="images/yuna.jpg"></a> -->

    </div></li>

  </ul>
    <div class="row">
      <div class="col s12 m8 l8 offset-m2 offset-l2">

        <div class="card white">
          <div class="card-content">
            <h3 align="center">Angket</h3>


            <?php
            $cek_matpel = mysqli_query($connectdb, "SELECT * FROM matpel WHERE muncul='on'");
            while($matpel = mysqli_fetch_assoc($cek_matpel)) {
              ?>
              <div style="padding-bottom: 30px;"></div>
              <div style="padding-bottom: 10px;">
                <?php
                echo $matpel['matpel'];
                 ?>
              </div>
              <div class="soal">
                <?php
                $maatpel = $matpel['matpel'];
                $cek_guru = mysqli_query($connectdb, "SELECT * FROM guru WHERE matpel='$maatpel' AND kelas='$kelas'");
                while ($guruu = mysqli_fetch_assoc($cek_guru)) {
                  $nama_guru = $guruu['nama'];
                  $nama_guru = addslashes($nama_guru);
                  $cek_guru2 = mysqli_query($connectdb, "SELECT * FROM guru2 WHERE nama='$nama_guru' AND matpel='$maatpel'");
                  while($guru = mysqli_fetch_assoc($cek_guru2)) {
                    $idguru = $guru['id'];
                    $cek_ada = mysqli_query($connectdb, "SELECT * FROM hasil WHERE id_siswa='$id_siswa' AND id_guru='$idguru'");
                    if (mysqli_num_rows($cek_ada) > 0) {
                      ?>
                      <strike><?php echo $guru['nama'] ?></strike>

                        <a href="hapus.php?jenis=hasil&id=<?php echo $guru['id']; ?>" class="btn black right">Hapus</a>


                      <!-- <a href="#" class="btn blue">Edit</a> -->
                      <div style="padding-bottom: 10px;"></div>
                      <?php
                    } else {
                      $proses = "angket.php?id=" . $guru['id'];
                      ?>
                      <a href="<?php echo $proses; ?>"><?php echo $guru['nama'] ?></a>
                      <div style="padding-bottom: 10px;"></div>
                      <?php
                    }
                  }
                }
                 ?>

              </div>
               <hr size='1'/>
              <?php
            }
            ?>
          </div>
        </div>
      </div>
    </div>
</form>
<footer class="page-footer  grey darken-3 z-depth-3" style="display:">
  <div class="footer-copyright">
    <div class="container">
    © 2018 Copyrekt - Powered By tuxsenpaai
    <!-- <a class="grey-text text-lighten-4 right " href="#!">More Links</a> -->
    </div>
  </div>
</footer>
<script>
$(document).ready(function(){
    $('.sidenav').sidenav();
  });
<?php
if (isset($_SESSION['warning'])) {
  echo "M.toast({html: '" . $_SESSION['warning'] . "'});";
  unset($_SESSION['warning']);
}
 ?>
</script>
  </body>
</html>
