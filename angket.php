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
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style>
      <?php
      // include 'bekgron.php';
       ?>
      body {
        font-family: "Roboto", sans-serif;
      }
      .tengah {
        margin:auto;
      }
      .ben-apik {
        margin-top: 15px;
      }
      p {
        margin: 10px 10px 10px 10px;
      }
      .warning {
        padding-top: 10px;
        color: #ff0000;
      }
      .soal {
        font-size: 22px;
      }
      .soooall {
        width: 100%;
        margin-top: 15px;
        margin-bottom: 25px;
      }
      td {
        text-align:center;
        padding: 10 10 10 10;
      }
      .w3-container {
        margin-left: 16px;
        margin-right: 16px;
      }
      .dump {
        display: flex;
        height: 30px;

      }
    </style>
  </head>

  <body style="background-color: #f44336">
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
      <input type="hidden" name="detto" value="<?php echo $detto; ?>" />
    <div class="w3-card w3-white tengah ben-apik w3-mobile" style="width: 60%">
      <div class="w3-container" style="margin-bottom: 10px;">
        <div class="dump"></div>
        <h1>Isi Angket</h1>
        <br />
        <div class="warning">Kerjakan dengan teliti</div>
        <div class="warning">*Wajib</div>
        <br />
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
         <div style="margin-bottom: 25px;" align="center">
           <input type="submit" name="submit_angket" value="Submit Angket" class="w3-btn w3-black" style="border-radius: 3px" />
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
<div style="background-color: #424242">
 <!-- <h5>Footer</h5> -->
 <div class="w3-container">
 <p><font color='white'>© 2018 Copyrekt - Powered By tuxsenpaai</font></p>
</div>
</div>
  </body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</html>
<?php
if (isset($_SESSION)) {
  unset($_SESSION['salah']);
}
 ?>
