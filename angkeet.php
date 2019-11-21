<?php
include('config.php');

date_default_timezone_set('Asia/Jakarta');
$detto = strftime( "%A, %d %B %Y %H:%M", time());

session_start();
$id_guru = $_GET['id'];
$id_guru = addslashes($id_guru);
$id_siswa = $_SESSION['user_angket'];
if (!isset($id_siswa)) {
  header ("Location: login.php");
}


$cek_ada = mysqli_query($connectdb, "SELECT * FROM hasil WHERE id_siswa='$id_siswa' AND id_guru='$id_guru'");
if (mysqli_num_rows($cek_ada) > 0) {
  header ("Location: cp.php");
}

if (isset($_POST['submit_angket'])) {
  $jumlah_kesalahan = 0;

    $cek_soal = mysqli_query($connectdb, "SELECT * FROM soal");
    while($soal = mysqli_fetch_assoc($cek_soal)){
      $id_soal = $soal['id'];

      if (isset($_POST[$id_soal])) {
          $jawab = $_POST[$id_soal];
        $cek_aada = mysqli_query($connectdb, "SELECT * FROM hasil WHERE id_siswa='$id_siswa' AND id_guru='$id_guru' AND id_soal='$id_soal' AND hasil='$jawab'");
        if (mysqli_num_rows($cek_aada) > 0) {

        } else {
          if (isset($jawab)) {
            $waktu = $_POST['detto'];
            $masuk_jawab = mysqli_query($connectdb, "INSERT INTO hasil(id_siswa, id_guru, id_soal, hasil, waktu) VALUES('$id_siswa', '$id_guru', '$id_soal', '$jawab', '$waktu')");
            if ($masuk_jawab) {

            } else {
              $jumlah_kesalahan = $jumlah_kesalahan + 1;
            }
          } else {
            $jumlah_kesalahan = $jumlah_kesalahan + 1;
          }
        }
      } else {
        $jumlah_kesalahan = $jumlah_kesalahan + 1;
      }
    }

  if ($jumlah_kesalahan > 0) {
    $_SESSION['salah'] = True;
    $hapus_semua = mysqli_query($connectdb, "DELETE FROM hasil WHERE id_siswa='$id_siswa' AND id_guru='$id_guru'");
    if ($hapus_semua) {

    }
  } else {
    header ("Location: cp.php");
    // echo "Sukses";
  }

}

 ?>

 <html>
   <head>
     <link rel="stylesheet" href="css/w3.css">
     <link rel="stylesheet" href="css/main.css">
       <link rel="stylesheet" href="fonts/fonts.css">
 <link rel="stylesheet" href="css/font-awesome.min.css">


 <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
 <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
 <script src="js/jquery-2.1.1.min.js"></script>
 <script type="text/javascript" src="js/materialize.min.js"></script>
 <script type="text/javascript" src="js/main.js"></script>
 <style>
 body {
   font-family: "Roboto", sans-serif;
 }
 .warning {
   padding-top: 10px;
   color: #ff0000;
 }
 .w3-container {
   margin-left: 16px;
   margin-right: 16px;
 }
 .soal {
   font-size: 22px;
 }
 .soooall {
   width: 100%;
   margin-top: 15px;
   margin-bottom: 25px;
 }
 <?php
 // include 'bekgron.php';
  ?>
 </style>


   <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

       <?php
       // include 'bekgron.php';
        ?>
        <body class="red">
          <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <input type="hidden" name="detto" value="<?php echo $detto; ?>" />
            <div class="row">
              <div class="col s12 m8 l8 offset-m2 offset-l2">
                <div class="card white z-depth-4">
                  <div class="card-content w3-container">
                    <!-- <h4>AAAAA</h4> -->
                    <h4>Isi Angket</h4>
                    <br />
                    <div class="warning">Kerjakan dengan teliti</div>
                    <div class="warning">*Wajib</div>
                    <br />
                    <div class="tambah_nama_guru">
                    <?php
                    $cek_guru = mysqli_query($connectdb, "SELECT * FROM guru2 WHERE id='$id_guru'");
                    while ($guru = mysqli_fetch_assoc($cek_guru)) {
                      echo "Guru : " . $guru['nama'];
                      echo "<div style='padding-bottom: 10px;'></div>";

                      echo "Mata Pelajaran : " . $guru['matpel'];
                    }
                     ?>

                     <?php
                     if (isset($_SESSION['salah']) && $_SESSION['salah'] = True) {
                       $cari_soal = mysqli_query($connectdb, "SELECT * from soal");
                       while($soal = mysqli_fetch_assoc($cari_soal)) {
                         ?>
                         <div class="soooall">
                           <div class="soal">
                             <?php echo $soal['id'] . ". " . $soal['soal']; ?> <font color="red">*</font>
                             <?php
                             if (empty($_POST[$soal['id']])) {
                               echo "<font color='red'> Tolong Diisi</font>";
                             }
                              ?>
                           </div>
                           <table>
                             <tr>
                               <td width="150px"></td>
                               <td width="130px">1</td>
                               <td width="130px">2</td>
                               <td width="130px">3</td>
                               <td width="130px">4</td>
                               <td width="150px"></td>
                             </tr>
                             <tr>
                               <?php
                               $idddd = $soal['id'];
                               if (empty($_POST[$idddd])) {
                                ?>
                               <td>Tidak Pernah</td>
                               <td><input type="radio" name="<?php echo $soal['id']; ?>" value="1" /></td>
                               <td><input type="radio" name="<?php echo $soal['id']; ?>" value="2" /></td>
                               <td><input type="radio" name="<?php echo $soal['id']; ?>" value="3" /></td>
                               <td><input type="radio" name="<?php echo $soal['id']; ?>" value="4" /></td>
                               <td>Sangat Sering</td>
                               <?php
                              }
                               if (isset($_POST[$idddd]) && $_POST[$idddd] == "1") {
                                 ?>
                                 <td>Tidak Pernah</td>
                                 <td><input type="radio" name="<?php echo $soal['id']; ?>" value="1" checked /></td>
                                 <td><input type="radio" name="<?php echo $soal['id']; ?>" value="2" /></td>
                                 <td><input type="radio" name="<?php echo $soal['id']; ?>" value="3" /></td>
                                 <td><input type="radio" name="<?php echo $soal['id']; ?>" value="4" /></td>
                                 <td>Sangat Sering</td>
                                 <?php
                               } elseif (isset($_POST[$idddd]) && $_POST[$idddd] == "2") {
                                 ?>
                                 <td>Tidak Pernah</td>
                                 <td><input type="radio" name="<?php echo $soal['id']; ?>" value="1"/></td>
                                 <td><input type="radio" name="<?php echo $soal['id']; ?>" value="2" checked /></td>
                                 <td><input type="radio" name="<?php echo $soal['id']; ?>" value="3" /></td>
                                 <td><input type="radio" name="<?php echo $soal['id']; ?>" value="4" /></td>
                                 <td>Sangat Sering</td>
                                 <?php
                               } elseif (isset($_POST[$idddd]) && $_POST[$idddd] == "3") {
                                 ?>
                                 <td>Tidak Pernah</td>
                                 <td><input type="radio" name="<?php echo $soal['id']; ?>" value="1"/></td>
                                 <td><input type="radio" name="<?php echo $soal['id']; ?>" value="2"/></td>
                                 <td><input type="radio" name="<?php echo $soal['id']; ?>" value="3" checked  /></td>
                                 <td><input type="radio" name="<?php echo $soal['id']; ?>" value="4" /></td>
                                 <td>Sangat Sering</td>
                                 <?php
                               } elseif (isset($_POST[$idddd]) && $_POST[$idddd] == "4") {
                                 ?>
                                 <td>Tidak Pernah</td>
                                 <td><input type="radio" name="<?php echo $soal['id']; ?>" value="1"/></td>
                                 <td><input type="radio" name="<?php echo $soal['id']; ?>" value="2"/></td>
                                 <td><input type="radio" name="<?php echo $soal['id']; ?>" value="3" /></td>
                                 <td><input type="radio" name="<?php echo $soal['id']; ?>" value="4" checked  /></td>
                                 <td>Sangat Sering</td>
                                 <?php
                               }
                                ?>
                             </tr>
                           </table>

                         </div>
                         <?php
                       }
                     } else {
                       $cari_soal = mysqli_query($connectdb, "SELECT * from soal");
                       while($soal = mysqli_fetch_assoc($cari_soal)) {
                         ?>
                         <div class="soooall">
                           <div class="soal">
                             <?php echo $soal['id'] . ". " . $soal['soal']; ?> <font color="red">*</font>
                           </div>
                           <table border=1>
                             <tr>
                               <td width="150px"></td>
                               <td width="130px">1</td>
                               <td width="130px">2</td>
                               <td width="130px">3</td>
                               <td width="130px">4</td>
                               <td width="150px"></td>
                             </tr>
                             <tr>
                               <td>Tidak Pernah</td>
                               <td><input type="radio" name="<?php echo $soal['id']; ?>" value="1" /></td>
                               <td><input type="radio" name="<?php echo $soal['id']; ?>" value="2" /></td>
                               <td><input type="radio" name="<?php echo $soal['id']; ?>" value="3" /></td>
                               <td><input type="radio" name="<?php echo $soal['id']; ?>" value="4" /></td>
                               <td>Sangat Sering</td>
                             </tr>
                           </table>

                         </div>
                         <?php
                       }
                     }
                     ?>
                     <div style="padding-bottom: 10px;"></div>
                     <div style="margin-bottom: 25px;" align="center">
                       <input type="submit" name="submit_angket" value="Submit Angket" class="btn black" />
                     </div>
                  </div>
                </div>
                </div>
        </div>
        </div>
        </form>
        <!-- <footer class="page-footer blue" style="display:">
        <div class="footer-copyright">
          <div class="container">
          © 2018 Copyrekt - Powered By tuxsenpaai -->
          <!-- <a class="grey-text text-lighten-4 right " href="#!">More Links</a> -->
          <!-- </div>
        </div>
        </footer> -->
        <footer class="page-footer  grey darken-3 z-depth-3" style="display:">
          <div class="footer-copyright">
            <div class="container">
            © 2018 Copyrekt - Powered By tuxsenpaai
            <!-- <a class="grey-text text-lighten-4 right " href="#!">More Links</a> -->
            </div>
          </div>
        </footer>
        </body>
     </style>
   </head>
