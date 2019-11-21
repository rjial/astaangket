<?php
include('config.php');
session_start();

if (!isset($_SESSION['admin_angket'])) {
  header("Location: login.php");
}

if (isset($_POST['submit_matpel'])) {
  $cek_aaada = mysqli_query($connectdb, "SELECT * FROM matpel");
  while($matpel = mysqli_fetch_assoc($cek_aaada)) {
    $id_matpel = $matpel['id'];
    if (isset($_POST['matpel_' . $id_matpel])) {
      $isi_muncul = $_POST['matpel_' . $id_matpel];
      $ubah_muncul = mysqli_query($connectdb, "UPDATE matpel SET muncul='on' WHERE id='$id_matpel'");
    } else {
      $ubah_muncul = mysqli_query($connectdb, "UPDATE matpel SET muncul='' WHERE id='$id_matpel'");
    }
  }

  $_SESSION['warning'] = "Sukses edit muncul mata pelajaran";
}

// foreach ($_POST as $key => $value) {
//   if (isset($key)) {
//     echo $key . " : " . $value . "<br />";
//   }
// }

if (isset($_POST['edit-siswa-submit'])) {
  $kesalahan_edit_siswa = 0;
  $id_edit_siswa = $_POST['id_edit_siswa'];
  if (isset($_POST['nama_siswa']) && !empty($_POST['nama_siswa'])) {
    $nama_siswa = $_POST['nama_siswa'];
    if (isset($_POST['edit-siswa-absen']) && !empty($_POST['edit-siswa-absen'])) {
      $absen_siswa = $_POST['edit-siswa-absen'];
      if (isset($_POST['nis_siswa']) && !empty($_POST['nis_siswa'])) {
        $nis_siswa = $_POST['nis_siswa'];
        if (isset($_POST['edit-siswa-kelas']) && !empty($_POST['edit-siswa-kelas'])) {
          $kelas_siswa = $_POST['edit-siswa-kelas'];
          if (isset($_POST['pass_siswa']) && !empty($_POST['pass_siswa'])) {
            $pass_siswa = $_POST['pass_siswa'];
            $pass_siswa = md5($pass_siswa);
            $cek_siswa = mysqli_query($connectdb, "SELECT * FROM siswa WHERE absen='$absen_siswa' AND nis='$nis_siswa' AND nama='$nama_siswa' AND kelas='$kelas_siswa' AND pass='$pass_siswa'");
            if (mysqli_num_rows($cek_siswa) <= 0) {
              $perintah_sql = "UPDATE siswa SET absen='$absen_siswa', nis='$nis_siswa', nama='$nama_siswa', kelas='$kelas_siswa', pass='$pass_siswa' WHERE id='$id_edit_siswa'";
            } else {
              $kesalahan_edit_siswa = $kesalahan_edit_siswa + 1;
            }
          } else {
            $kesalahan_edit_siswa = $kesalahan_edit_siswa + 1;
          }
        } else {
          $kesalahan_edit_siswa = $kesalahan_edit_siswa + 1;
        }
      } else {
        $kesalahan_edit_siswa = $kesalahan_edit_siswa + 1;
      }
    } else {
      $kesalahan_edit_siswa = $kesalahan_edit_siswa + 1;
    }
  } else {
    $kesalahan_edit_siswa = $kesalahan_edit_siswa + 1;
  }


  if ($kesalahan_edit_siswa > 0) {
    $_SESSION['salah-edit-siswa'] = True;
  } else {
    $masukkan_siswa = mysqli_query($connectdb, $perintah_sql);
    if ($masukkan_siswa) {
      $_SESSION['warning'] = "Edit siswa sukses!";
    }
  }
}

if (isset($_POST['tambah-siswa-submit'])) {
  $kesalahan_tambah_siswa = 0;
  if (isset($_POST['nama_siswa']) && !empty($_POST['nama_siswa'])) {
    $nama_siswa = $_POST['nama_siswa'];
    $nama_siswa = strtoupper($nama_siswa);
    if (isset($_POST['tambah-select-absen']) && !empty($_POST['tambah-select-absen'])) {
      $absen_siswa = $_POST['tambah-select-absen'];
      if (isset($_POST['nis_siswa']) && !empty($_POST['nis_siswa'])) {
        $nis_siswa = $_POST['nis_siswa'];
        if (isset($_POST['tambah-select-siswa']) && !empty($_POST['tambah-select-siswa'])) {
          $kelas_siswa = $_POST['tambah-select-siswa'];
          if (isset($_POST['pass_siswa']) && !empty($_POST['pass_siswa'])) {
            $pass_siswa = $_POST['pass_siswa'];
            $pass_siswa = md5($pass_siswa);
            $cek_siswa = mysqli_query($connectdb, "SELECT * FROM siswa WHERE absen='$absen_siswa' AND nis='$nis_siswa' AND nama='$nama_siswa' AND kelas='$kelas_siswa' AND pass='$pass_siswa'");
            if (mysqli_num_rows($cek_siswa) <= 0) {
              $perintah_sql = "INSERT INTO siswa(absen, nis, nama, kelas, pass) VALUES('$absen_siswa', '$nis_siswa', '$nama_siswa', '$kelas_siswa', '$pass_siswa')";
            } else {
              $kesalahan_tambah_siswa = $kesalahan_tambah_siswa + 1;
            }
          } else {
            $kesalahan_tambah_siswa = $kesalahan_tambah_siswa + 1;
          }
        } else {
          $kesalahan_tambah_siswa = $kesalahan_tambah_siswa + 1;
        }
      } else {
        $kesalahan_tambah_siswa = $kesalahan_tambah_siswa + 1;
      }
    } else {
      $kesalahan_tambah_siswa = $kesalahan_tambah_siswa + 1;
    }
  } else {
    $kesalahan_tambah_siswa = $kesalahan_tambah_siswa + 1;
  }


  if ($kesalahan_tambah_siswa > 0) {
    $_SESSION['salah-tambah-siswa'] = True;
  } else {
    $masukkan_siswa = mysqli_query($connectdb, $perintah_sql);
    if ($masukkan_siswa) {
      $_SESSION['warning'] = "Tambah siswa sukses!";
    }
  }
}

if (isset($_POST['edit-matpel-submit'])) {
  $kesalahan_edit_matpel = 0;
  if (isset($_POST['name-edit-matpel']) && !empty($_POST['name-edit-matpel'])) {
    $id_matpel = $_POST['edit-id-matpel'];
    $nama_matpel = $_POST['name-edit-matpel'];
    $cek_ada = mysqli_query($connectdb, "SELECT * FROM matpel WHERE matpel='$nama_matpel'");
    if (mysqli_num_rows($cek_ada) <= 0 ) {
      if (isset($_POST['muncul-matpel'])) {
        $tambah_matpel = "UPDATE matpel SET matpel='$nama_matpel', muncul='on' WHERE id='$id_matpel'";
      } else {
        $tambah_matpel = "UPDATE matpel SET matpel='$nama_matpel' WHERE id='$id_matpel'";
      }
    } else {
      $kesalahan_edit_matpel = $kesalahan_edit_matpel + 1;
    }
  } else {
    $kesalahan_edit_matpel = $kesalahan_edit_matpel + 1;
  }

  if ($kesalahan_edit_matpel > 0) {
    $_SESSION['salah-edit-matpel'] = True;
  } else {
      $cek_id_matpel = mysqli_query($connectdb, "SELECT * FROM matpel WHERE id='$id_matpel'");
      if ($cek_id_matpel) {
        $cek_id_matpel2 = mysqli_fetch_assoc($cek_id_matpel);
        $cek_id_matpel3 = $cek_id_matpel2['matpel'];
        // echo $cek_id_matpel3 . "<br/>";
        // echo $nama_matpel;
        $hapus_guru_matpel = mysqli_query($connectdb, "UPDATE guru SET matpel = REPLACE(matpel, '$cek_id_matpel3', '$nama_matpel')");
        $hapus_guru_matpel2 = mysqli_query($connectdb, "UPDATE guru2 SET matpel = REPLACE(matpel, '$cek_id_matpel3', '$nama_matpel')");
        if ($hapus_guru_matpel && $hapus_guru_matpel2) {
          $nambah_matpel = mysqli_query($connectdb, $tambah_matpel);
          if ($nambah_matpel) {
            $_SESSION['warning'] = "Sukses edit Mata Pelajaran";
          } else {
            $_SESSION['warning'] = "Gagal edit Mata Pelajaran";
          }
        }
      }
  }
}

if (isset($_POST['tambah-matpel-submit'])) {
  $kesalahan_tambah_matpel = 0;
  if (isset($_POST['name-tambah-matpel']) && !empty($_POST['name-tambah-matpel'])) {
    $nama_matpel = $_POST['name-tambah-matpel'];
    $cek_ada = mysqli_query($connectdb, "SELECT * FROM matpel WHERE matpel='$nama_matpel'");
    if (mysqli_num_rows($cek_ada) <= 0 ) {
      if (isset($_POST['muncul-matpel'])) {
        $tambah_matpel = "INSERT INTO matpel(matpel, muncul) VALUES('$nama_matpel', 'on')";
      } else {
        $tambah_matpel = "INSERT INTO matpel(matpel) VALUES('$nama_matpel')";
      }
    } else {
      $kesalahan_tambah_matpel = $kesalahan_tambah_matpel + 1;
    }
  } else {
    $kesalahan_tambah_matpel = $kesalahan_tambah_matpel + 1;
  }

  if ($kesalahan_tambah_matpel > 0) {
    $_SESSION['salah-tambah-matpel'] = True;
  } else {
    $nambah_matpel = mysqli_query($connectdb, $tambah_matpel);
    if ($nambah_matpel) {
      $_SESSION['warning'] = "Sukses tambah Mata Pelajaran";
    } else {
      $_SESSION['warning'] = "Gagal tambah Mata Pelajaran";
    }
  }
}

if (isset($_POST['edit_guru_submit'])) {
  $kesalahan_edit_guru = 0;
  $id_gurru = $_POST['edit_guru_id'];
  $sementara = mysqli_query($connectdb, "SELECT * FROM guru2 WHERE id='$id_gurru'");
  $sementara2 = mysqli_fetch_assoc($sementara);
  $jeneng_guru = $sementara2['nama'];
  $matupel_guru = $sementara2['matpel'];

  if (isset($_POST['select-matpel-edit']) && $_POST['select-matpel-edit'] != "") {
    $id_matpel = $_POST['select-matpel-edit'];
    $cek_matpel = mysqli_query($connectdb, "SELECT * FROM matpel WHERE id='$id_matpel'");
    $ceek_matpel = mysqli_fetch_assoc($cek_matpel);
    $matpelnyaa = $ceek_matpel['matpel'];
  } else {
    $kesalahan_edit_guru = $kesalahan_edit_guru + 1;
    $matpelnyaa = '0';
  }

  if (isset($_POST['edit-guru-nama'])) {
    if (isset($_POST['edit-guru-nama']) && !empty($_POST['edit-guru-nama'])){
      $nama_gguruu = $_POST['edit-guru-nama'];
    } else {
      $kesalahan_edit_guru = $kesalahan_edit_guru + 1;
      $nama_gguruu = '0';
    }
    if (isset($matpelnyaa) && isset($nama_gguruu) && $kesalahan_edit_guru <= 0) {
      $cek_ada = mysqli_query($connectdb, "SELECT * FROM guru2 WHERE nama='$nama_gguruu' AND matpel='$matpelnyaa'");
    }
    if (isset($cek_ada)) {
      if (mysqli_num_rows($cek_ada) > 0) {
        $kesalahan_edit_guru = $kesalahan_edit_guru + 1;
      } else {
        $nama_gguru = $_POST['edit-guru-nama'];
      }
    }
  } else {
    $kesalahan_edit_guru = $kesalahan_edit_guru + 1;
  }

  if (empty($_POST['kelas-xii']) && empty($_POST['kelas-xi']) && empty($_POST['kelas-x'])) {
    $kesalahan_tambah_guru = $kesalahan_tambah_guru + 1;
  }

  if ($kesalahan_edit_guru > 0) {

  } else {
    $ubah_guru = mysqli_query($connectdb, "UPDATE guru2 SET nama='$nama_gguru', matpel='$matpelnyaa' WHERE id='$id_gurru'");
    if ($ubah_guru) {
      $hapus_kelas = mysqli_query($connectdb, "DELETE FROM guru WHERE nama='$jeneng_guru' AND matpel='$matupel_guru'");
      if ($hapus_kelas) {
        if (isset($_POST['kelas-xii']) && $_POST['kelas-xii'] == "on") {
          $nambah_kelas_xii = mysqli_query($connectdb, "INSERT INTO guru(matpel, nama, kelas) VALUES('$matpelnyaa', '$nama_gguru', 'XII')");
          if ($nambah_kelas_xii) {

          }
        }

        if (isset($_POST['kelas-xi']) && $_POST['kelas-xi'] == "on") {
          $nambah_kelas_xi = mysqli_query($connectdb, "INSERT INTO guru(matpel, nama, kelas) VALUES('$matpelnyaa', '$nama_gguru', 'XI')");
          if ($nambah_kelas_xi) {

          }
        }

        if (isset($_POST['kelas-x']) && $_POST['kelas-x'] == "on") {
          $nambah_kelas_x = mysqli_query($connectdb, "INSERT INTO guru(matpel, nama, kelas) VALUES('$matpelnyaa', '$nama_gguru', 'X')");
          if ($nambah_kelas_x) {

          }
        }

      }
    }

    $_SESSION['warning'] = "Sukses edit guru!";
  }
}

if (isset($_POST['tambah_guru_submit'])) {
  $kesalahan_tambah_guru = 0;
  if (isset($_POST['select-matpel-tambah']) && $_POST['select-matpel-tambah'] != "") {
    $id_matpel = $_POST['select-matpel-tambah'];
    $cek_matpel = mysqli_query($connectdb, "SELECT * FROM matpel WHERE id='$id_matpel'");
    $ceek_matpel = mysqli_fetch_assoc($cek_matpel);
    $matpelnyaa = $ceek_matpel['matpel'];
  } else {
    $kesalahan_tambah_guru = $kesalahan_tambah_guru + 1;
    $matpelnyaa = '0';
  }
  if (isset($_POST['tambah-guru-nama'])) {
    if (isset($_POST['tambah-guru-nama']) && !empty($_POST['tambah-guru-nama'])){
      $nama_gguruu = $_POST['tambah-guru-nama'];
    } else {
      $kesalahan_tambah_guru = $kesalahan_tambah_guru + 1;
      $nama_gguruu = '0';
    }
    if (isset($matpelnyaa) && isset($nama_gguruu) && $kesalahan_tambah_guru <= 0) {
      $cek_ada = mysqli_query($connectdb, "SELECT * FROM guru2 WHERE nama='$nama_gguruu' AND matpel='$matpelnyaa'");
    }
    if (isset($cek_ada)) {
      if (mysqli_num_rows($cek_ada) > 0) {
        $kesalahan_tambah_guru = $kesalahan_tambah_guru + 1;
      } else {
        $nama_gguru = $_POST['tambah-guru-nama'];
      }
    }
  } else {
    $kesalahan_tambah_guru = $kesalahan_tambah_guru + 1;
  }
  if (isset($_POST['kelas-xii'])) {
    $kelas_xii = $_POST['kelas-xii'];
  }
  if (isset($_POST['kelas-xi'])) {
    $kelas_xi = $_POST['kelas-xi'];
  }
  if (isset($_POST['kelas-x'])) {
    $kelas_x = $_POST['kelas-x'];
  }

  if (empty($_POST['kelas-xii']) && empty($_POST['kelas-xi']) && empty($_POST['kelas-x'])) {
    $kesalahan_tambah_guru = $kesalahan_tambah_guru + 1;
  }

  if ($kesalahan_tambah_guru > 0) {
    $_SESSION['salah_tambah_guru'] = True;
    // echo $kesalahan_tambah_guru;
  } else {
    if (isset($matpelnyaa)) {
      $masukkan_guru = mysqli_query($connectdb, "INSERT INTO guru2(matpel, nama) VALUES('$matpelnyaa', '$nama_gguru')");
      if ($masukkan_guru) {
        if (isset($_POST['kelas-xii']) && $_POST['kelas-xii'] == "on") {
          // $kelas_xii = $_POST['kelas-xii'];
          $masukkan_xii = mysqli_query($connectdb, "INSERT INTO guru(matpel, nama, kelas) VALUES('$matpelnyaa', '$nama_gguru', 'XII')");
          if ($masukkan_xii) {

          }
        }
        if (isset($_POST['kelas-xi']) && $_POST['kelas-xi'] == "on") {
          // $kelas_xii = $_POST['kelas-xii'];
          $masukkan_xi = mysqli_query($connectdb, "INSERT INTO guru(matpel, nama, kelas) VALUES('$matpelnyaa', '$nama_gguru', 'XI')");
          if ($masukkan_xi) {

          }
        }
        if (isset($_POST['kelas-x']) && $_POST['kelas-x'] == "on") {
          // $kelas_xii = $_POST['kelas-xii'];
          $masukkan_x = mysqli_query($connectdb, "INSERT INTO guru(matpel, nama, kelas) VALUES('$matpelnyaa', '$nama_gguru', 'X')");
          if ($masukkan_x) {

          }
        }

        $_SESSION['warning'] = "Sukses tambah guru!";

      }
    }
  }
}



$halaman = 10; //batasan halaman
$page = isset($_GET['halaman'])? (int)$_GET["halaman"]:1;
$mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
// $query = mysqli_query($connectdb, "select * from siswa LIMIT $mulai, $halaman");
// $query = mysqli_query($connectdb, "select * from siswa WHERE nama LIKE '%RIZAL%' LIMIT $mulai, $halaman");
// $sql = mysqli_query($connectdb, "select * from siswa WHERE nama LIKE '%RIZAL%'");
if (isset($_POST['submit_cari_siswa'])) {
  if (isset($_POST['cari_nama_siswa']) && !empty($_POST['cari_nama_siswa']) && $_POST['cari_nama_siswa'] != "") {
    $query_nama = $_POST['cari_nama_siswa'];
    $query_nama = strtoupper($query_nama);
    if (isset($_POST['cari_kelas_siswa'])) {
      $query_kelas = $_POST['cari_kelas_siswa'];
      $query = mysqli_query($connectdb, "select * from siswa WHERE UPPER(nama) LIKE UPPER('%" . $query_nama . "%') AND kelas='$query_kelas'");
      $sql = mysqli_query($connectdb, "select * from siswa WHERE UPPER(nama) LIKE UPPER('%" . $query_nama . "%') AND kelas='$query_kelas'");
    }elseif (isset($_POST['cari_nis_siswa']) && !empty($_POST['cari_nis_siswa'])) {
      $query_nis = $_POST['cari_nis_siswa'];
      $query = mysqli_query($connectdb, "select * from siswa WHERE UPPER(nama) LIKE UPPER('%" . $query_nama . "%') AND nis='$query_nis'");
      $sql = mysqli_query($connectdb, "select * from siswa WHERE UPPER(nama) LIKE UPPER('%" . $query_nama . "%') AND nis='$query_nis'");
    }elseif (isset($_POST['cari_nis_siswa']) && !empty($_POST['cari_nis_siswa']) && isset($_POST['cari_kelas_siswa'])) {
      $query_kelas = $_POST['cari_kelas_siswa'];
      $query_nis = $_POST['cari_nis_siswa'];
      $query = mysqli_query($connectdb, "select * from siswa WHERE UPPER(nama) LIKE UPPER('%" . $query_nama . "%') AND nis='$query_nis' AND kelas='$query_kelas'");
      $sql = mysqli_query($connectdb, "select * from siswa WHERE UPPER(nama) LIKE UPPER('%" . $query_nama . "%') AND nis='$query_nis' AND kelas='$query_kelas'");
    } else {
      $query = mysqli_query($connectdb, "select * from siswa WHERE UPPER(nama) LIKE UPPER('%" . $query_nama . "%')");
      $sql = mysqli_query($connectdb, "select * from siswa WHERE UPPER(nama) LIKE UPPER('%" . $query_nama . "%')");
    }
  }elseif (isset($_POST['cari_nis_siswa']) && !empty($_POST['cari_nis_siswa']) && $_POST['cari_nis_siswa'] != "") {
    $query_nis = $_POST['cari_nis_siswa'];
    // $query = mysqli_query($connectdb, "select * from siswa WHERE nis LIKE '%" . $query_nis . "%'");
    // $sql = mysqli_query($connectdb, "select * from siswa WHERE nis LIKE '%" . $query_nis . "%'");
    if (isset($_POST['cari_kelas_siswa'])) {
      $query_kelas = $_POST['cari_kelas_siswa'];
      $query = mysqli_query($connectdb, "select * from siswa WHERE nis='$query_nis' AND kelas='$query_kelas'");
      $sql = mysqli_query($connectdb, "select * from siswa WHERE nis='$query_nis' AND kelas='$query_kelas'");
    } else {
      $query = mysqli_query($connectdb, "select * from siswa WHERE nis='$query_nis'");
      $sql = mysqli_query($connectdb, "select * from siswa WHERE nis='$query_nis'");
    }
  }elseif (isset($_POST['cari_kelas_siswa'])) {
    $query_kelas = $_POST['cari_kelas_siswa'];
    $qquery = "select * from siswa where kelas='$query_kelas'";
    $query = mysqli_query($connectdb, $qquery);
    $sql = mysqli_query($connectdb, $qquery);
  }else {
    if (isset($_POST['cek_sudah']) && !empty($_POST['cek_sudah'])) {
      $query = mysqli_query($connectdb, "select * from siswa");
      $sql = mysqli_query($connectdb, "select * from siswa");
    }
  }
} else {
  $query = mysqli_query($connectdb, "select * from siswa LIMIT $mulai, $halaman");
  $sql = mysqli_query($connectdb, "select * from siswa");
}


$total = mysqli_num_rows($sql);
$pages = ceil($total/$halaman);

$kelas = array('XII TKJ A', 'XII TKJ B', 'XII TKJ C', 'XII TKJ D', 'XII RPL A', 'XII RPL B', 'XII RPL C', 'XII RPL D', 'XII METRO A', 'XII METRO B', 'XII METRO C', 'XII METRO D', 'XI TKJ A', 'XI TKJ B', 'XI TKJ C', 'XI TKJ D', 'XI RPL A', 'XI RPL B', 'XI RPL C', 'XI RPL D', 'XI METRO A', 'XI METRO B', 'XI METRO C', 'XI METRO D', 'X TKJ A', 'X TKJ B', 'X TKJ C', 'X TKJ D', 'X RPL A', 'X RPL B', 'X RPL C', 'X RPL D', 'X METRO A', 'X METRO B', 'X METRO C', 'X METRO D');

 ?>
 <html>
   <head>
     <title>Admin | Asta Angket</title>
     <link rel="stylesheet" href="fonts/fonts.css">
     <link rel="stylesheet" href="icon/fonts.css">
     <link rel="stylesheet" href="css/font-awesome.min.css">
     <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> -->
     <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
     <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
     <link rel="stylesheet" href="css/main.css">
     <script src="js/jquery-2.1.1.min.js"></script>
     <script type="text/javascript" src="js/materialize.min.js"></script>
     <script type="text/javascript" src="js/main.js"></script>
     <style>
     <?php
     // include 'bekgron.php';
      ?>
     </style>
     <script>

$(document).ready(function(){
   $('.modal').modal();
   $('select').material_select();
});
</script>
   </head>


   <body class="red">


  <nav class="z-depth-3">
    <div class="nav-wrapper grey darken-3">
      <a href="#!" class="brand-logo center">Asta Angket</a>
      <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
      <ul class="right hide-on-med-and-down">
        <li><a href="#" onclick="openFrame('siswa')">Siswa</a></li>
        <li><a href="#" onclick="openFrame('matpel')">Mata Pelajaran</a></li>
        <li><a href="#" onclick="openFrame('guru')">Guru</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </div>
  </nav>

  <ul class="sidenav" id="mobile-demo">
    <li><a href="#" onclick="openFrame('siswa')">Siswa</a></li>
    <li><a href="#" onclick="openFrame('matpel')">Mata Pelajaran</a></li>
    <li><a href="#" onclick="openFrame('guru')">Guru</a></li>
    <li><a href="logout.php">Logout</a></li>
  </ul>
  <div style="margin-bottom: 15px"></div>


     <main>


       <!-- <div style="margin-top: 50px"></div> -->

       <!-- <div class="col s12 m8 l8 offset-m2 offset-l2"> -->
         <div class="row" style="align: center">
           <!-- <div class="col l2 s12">
             <div class="card white z-depth-3">
               <div class="card-content">
                 <div class="sidenaav">
                   <a href="#" onclick="openFrame('siswa')">Siswa</a>
                   <a href="#" onclick="openFrame('matpel')">Mata Pelajaran</a>
                   <a href="#" onclick="openFrame('guru')">Guru</a>
                   <a href="logout.php">Logout</a>
                 </div>
               </div>
             </div>
           </div> -->
           <div class="col s12 m8 l8 offset-m2 offset-l2">
             <div class="card white z-depth-3">

               <div id="siswa" class="frame">
               <div class="card-content">
                 <h4>Siswa</h4>
                 <div style="float: right; padding-bottom:10px;">
                   <button data-target="tambah-siswa" class="btn modal-trigger blue"><i class="inline-icon material-icons">add</i> Tambah Siswa</button>
                   <button onclick="togel('cari-siswa');" class="btn green"><i class="inline-icon material-icons">search</i> Cari Siswa</button>
                   <?php
                   if (isset($_POST['submit_cari_siswa'])) {
                     ?>
                   <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn green"><i class="inline-icon material-icons">arrow_back</i> Back</a>
                   <?php
                 }
                  ?>
                 </div>
                 <br />
                 <div style="margin-bottom:10px"></div>
                 <div id='cari-siswa' style="display: none;">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="input-field col s12 l12">
                      <i class="material-icons prefix">account_circle</i>
                      <input id="cari_nama_siswa" type="text" name="cari_nama_siswa">
                      <label for="cari_nama_siswa">Nama</label>
                    </div>
                    <div class="input-field col s12 l6">
                      <i class="material-icons prefix">vpn_key</i>
                      <input id="cari_nama_siswa" type="text" name="cari_nis_siswa">
                      <label for="cari_nama_siswa">NIS</label>
                    </div>
                    <div class="input-field col s12 l6">
                      <select  name="cari_kelas_siswa">
                        <option value="" disabled selected>Pilih Kelas</option>
                        <?php
                        foreach ($kelas as $key) {
                            echo "<option value='" . $key . "' >" . $key . "</option>";
                        }
                        ?>
                      </select>
                      <label>Kelas</label>
                    </div>
                    <div align="right">
                    <label>
                      <input name="cek_sudah" value='on' type="radio"/>
                      <span>Sudah Mengisi</span>
                    </label>
                    <label>
                      <input name="cek_sudah" value='off' type="radio"/>
                      <span>Belum Mengisi</span>
                    </label>
                    </div>
                    <input type="submit" class="btn green" name="submit_cari_siswa" style="float: right" value="Cari" />
                  </form>
                 </div>
                 <div id="tambah-siswa" class="modal modal-fixed-footer">
                  <div class="modal-content">
                    <h4>Tambah Siswa</h4>
                    <div class="tambah_nama_guru">
                      <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                    <table>
                      <tr>
                        <td>Nama</td>
                        <td><input type="text" name="nama_siswa" /></td>
                      </tr>
                      <tr>
                        <td>Absen</td>
                        <td>
                          <select id="fix-select" name="tambah-select-absen">
                            <?php
                            for ($i=1; $i <= 40 ; $i++) {
                              echo "<option>" . $i . "</option>";
                            }
                             ?>
                            <!-- <option>XII TKJ A</option> -->
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>NIS</td>
                        <td><input type="text" name="nis_siswa" /></td>
                      </tr>
                      <tr>
                        <td>Kelas</td>
                        <td>
                          <select id="fix-select" name="tambah-select-siswa">
                            <?php
                            // $kelas = array('XII TKJ A', 'XII TKJ B', 'XII TKJ C', 'XII TKJ D', 'XII RPL A', 'XII RPL B', 'XII RPL C', 'XII RPL D', 'XII METRO A', 'XII METRO B', 'XII METRO C', 'XII METRO D', 'XI TKJ A', 'XI TKJ B', 'XI TKJ C', 'XI TKJ D', 'XI RPL A', 'XI RPL B', 'XI RPL C', 'XI RPL D', 'XI METRO A', 'XI METRO B', 'XI METRO C', 'XI METRO D', 'X TKJ A', 'X TKJ B', 'X TKJ C', 'X TKJ D', 'X RPL A', 'X RPL B', 'X RPL C', 'X RPL D', 'X METRO A', 'X METRO B', 'X METRO C', 'X METRO D');
                            foreach ($kelas as $key) {
                              echo "<option>" . $key . "</option>";
                            }
                            ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Password</td>
                        <td><input type="text" name="pass_siswa"/></td>
                      </tr>
                    </table>
                  </div>
                  </div>
                  <div class="modal-footer">
                    <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Tutup</a>
                    <input type="submit" name="tambah-siswa-submit" class="submit-rasa-a btn-flat" value="Submit" />
                  </div>
                </form>
                </div>
                 <table>
                   <tr>
                     <th>No</th>
                     <th>Nama</th>
                     <th>NIS</th>
                     <th>Kelas</th>
                     <th>Status</th>
                     <th>Aksi</th>
                   </tr>
                   <?php
                   // $cek_siswa = mysqli_query($connectdb, "SELECT * FROM siswa");
                   while ($siswa = mysqli_fetch_assoc($query)) {
                     $sudah = 0;
                     $belum = 0;
                     $iiddd = $siswa['id'];
                     if (isset($_POST['submit_cari_siswa'])) {
                       if (isset($_POST['cek_sudah'])) {
                         if ($_POST['cek_sudah'] == "on") {
                           $cecek_matpel = mysqli_query($connectdb, "SELECT * FROM matpel WHERE muncul='on'");
                           while ($mamamatpel = mysqli_fetch_assoc($cecek_matpel)) {
                             $mmmatpel = $mamamatpel['matpel'];
                             $cecek_guru = mysqli_query($connectdb, "SELECT * FROM guru2 WHERE matpel='$mmmatpel'");
                             while ($gggguru = mysqli_fetch_assoc($cecek_guru)) {
                               $guguguru = $gggguru['id'];
                               $cecek_hasil = mysqli_query($connectdb, "SELECT * FROM hasil WHERE id_guru='$guguguru' AND id_siswa='$iiddd' AND id_soal='1'");
                               if (mysqli_num_rows($cecek_hasil) > 0) {
                                 $hahahasil = mysqli_fetch_assoc($cecek_hasil);
                                 if ($hahahasil['id_siswa'] == $iiddd) {
                                   ?>
                                    <!-- SECTION -->
                                    <tr>
                                    <td><?php echo $siswa['id']; ?></td>
                                    <td><?php echo $siswa['nama']; ?></td>
                                    <td><?php echo $siswa['nis']; ?></td>
                                    <td><?php echo $siswa['kelas']; ?></td>
                                    <?php
                                    $cek_matpel = mysqli_query($connectdb, "SELECT * FROM matpel WHERE muncul='on'");
                                    while ($matpel = mysqli_fetch_assoc($cek_matpel)) {
                                      $matpeel = $matpel['matpel'];
                                      $cek_guru = mysqli_query($connectdb, "SELECT * FROM guru2 WHERE matpel='$matpeel'");
                                      while ($guru = mysqli_fetch_assoc($cek_guru)) {
                                        $guuru = $guru['id'];
                                        $cek_hasil = mysqli_query($connectdb, "SELECT * FROM hasil WHERE id_guru='$guuru' AND id_siswa='$iiddd'");
                                        if (mysqli_num_rows($cek_hasil) > 0) {
                                          $sudah = $sudah + 1;
                                          // echo "<td>Sudah | " . $sudah . "</td>";

                                        } else {
                                          $belum = $belum + 1;
                                        }
                                      }
                                    }
                                    if ($sudah > 0) {
                                      // echo "<td>Sudah | " . $sudah . "</td>";
                                      echo "<td><a class='waves-effect waves-light btn modal-trigger red' style='font-size: 9pt' href='#modal" . $iiddd . "'>Sudah (" . $sudah . ")</a></td>";
                                      ?>
                                      <div id="modal<?php echo $iiddd; ?>" class="modal">
                                        <div class="modal-content">
                                          <?php
                                          $cek_hasil = mysqli_query($connectdb, "SELECT * FROM hasil WHERE id_siswa='$iiddd' AND id_soal='1'");
                                          while ($haaasil = mysqli_fetch_assoc($cek_hasil)) {
                                            // echo $haaasil['id_guru'] . " ";
                                            $ggguuruu = $haaasil['id_guru'];
                                            $ck_matpel = mysqli_query($connectdb, "SELECT * FROM matpel WHERE muncul='on'");
                                            while ($ckk_matpel = mysqli_fetch_assoc($ck_matpel)) {
                                              $nm_matpel = $ckk_matpel['matpel'];
                                              $cek_guruu = mysqli_query($connectdb, "SELECT * FROM guru2 WHERE id='$ggguuruu' AND matpel='$nm_matpel'");
                                              while ($gguru = mysqli_fetch_assoc($cek_guruu)) {
                                                echo "<div class='blue rcorners1 white-text'>";
                                                echo $gguru['nama'] ." : " . $gguru['matpel'] . "<br />";
                                                echo "</div>";
                                              }
                                            }
                                          }
                                          ?>
                                        </div>
                                        <div class="modal-footer">
                                          <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Tutup</a>
                                        </div>
                                      </div>
                                      <?php

                                    } else {
                                      echo "<td>Belum</td>";
                                    }
                                     ?>
                                     <td>
                                       <!-- <a href="#" class="btn blue">Edit</a> -->
                                       <button data-target="edit-siswa-<?php echo $siswa['id']; ?>" class="btn modal-trigger blue">Edit</button>
                                       <div id="edit-siswa-<?php echo $siswa['id']; ?>" class="modal modal-fixed-footer">
                                         <div class="modal-content">
                                           <h4><?php echo $siswa['nama']; ?></h4>
                                           <h6><?php echo $siswa['kelas']; ?></h6>
                                           <div class="tambah_nama_guru">
                                             <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                                           <table>
                                             <tr>
                                               <td>Nama</td>
                                               <input type="hidden" name="id_edit_siswa" value="<?php echo $siswa['id']; ?>" />
                                               <td><input type="text" name="nama_siswa" value="<?php echo $siswa['nama']; ?>" /></td>
                                             </tr>
                                             <tr>
                                               <td>Absen</td>
                                               <td>
                                                 <select class="browser-default" name="edit-siswa-absen">
                                                   <?php
                                                   for ($i=1; $i <= 40 ; $i++) {
                                                     if ($i == $siswa['absen']) {
                                                       echo "<option value='" . $i . "' selected>" . $i . "</option>";
                                                     } else {
                                                       echo "<option value='" . $i . "' >" . $i . "</option>";
                                                     }
                                                   }
                                                    ?>
                                                 </select>
                                               </td>
                                             </tr>
                                             <tr>
                                               <td>NIS</td>
                                               <td><input type="text" name="nis_siswa" value="<?php  echo $siswa['nis'];  ?>" /></td>
                                             </tr>
                                             <tr>
                                               <td>Kelas</td>
                                               <td>
                                                 <!-- <label>Browser Select</label> -->
                                                 <select class="browser-default" name="edit-siswa-kelas">
                                                   <option value="" disabled selected>Choose your option</option>
                                                   <?php
                                                   foreach ($kelas as $key) {
                                                     if ($key == $siswa['kelas']) {
                                                       echo "<option value='" . $key . "' selected>" . $key . "</option>";
                                                     } else {
                                                       echo "<option value='" . $key . "' >" . $key . "</option>";
                                                     }
                                                   }
                                                   ?>
                                                 </select>

                                               </td>
                                             </tr>
                                             <tr>
                                               <td>Password</td>
                                               <td><input type="text" name="pass_siswa" value="123" /></td>
                                             </tr>
                                           </table>
                                         </div>
                                         </div>
                                         <div class="modal-footer">
                                           <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Tutup</a>
                                           <a href="hapus.php?jenis=siswa&id=<?php echo $siswa['id']; ?>" class="modal-action modal-close waves-effect waves-green btn-flat">Hapus</a>
                                           <input type="submit" name="edit-siswa-submit" class="submit-rasa-a btn-flat" value="Submit" />
                                         </div>
                                       </form>
                                       </div>
                                     </td>
                                    </tr>
                                    <!-- SECTION -->
                                    <?php
                                 }
                               }
                             }
                           }

                         }elseif ($_POST['cek_sudah'] == "off") {
                           
                         }
                       }
                     } else {

                       ?>
                        <!-- SECTION -->
                        <tr>
                        <td><?php echo $siswa['id']; ?></td>
                        <td><?php echo $siswa['nama']; ?></td>
                        <td><?php echo $siswa['nis']; ?></td>
                        <td><?php echo $siswa['kelas']; ?></td>
                        <?php
                        $cek_matpel = mysqli_query($connectdb, "SELECT * FROM matpel WHERE muncul='on'");
                        while ($matpel = mysqli_fetch_assoc($cek_matpel)) {
                          $matpeel = $matpel['matpel'];
                          $cek_guru = mysqli_query($connectdb, "SELECT * FROM guru2 WHERE matpel='$matpeel'");
                          while ($guru = mysqli_fetch_assoc($cek_guru)) {
                            $guuru = $guru['id'];
                            $cek_hasil = mysqli_query($connectdb, "SELECT * FROM hasil WHERE id_guru='$guuru' AND id_siswa='$iiddd'");
                            if (mysqli_num_rows($cek_hasil) > 0) {
                              $sudah = $sudah + 1;
                              // echo "<td>Sudah | " . $sudah . "</td>";

                            } else {
                              $belum = $belum + 1;
                            }
                          }
                        }
                        if ($sudah > 0) {
                          // echo "<td>Sudah | " . $sudah . "</td>";
                          echo "<td><a class='waves-effect waves-light btn modal-trigger red' style='font-size: 9pt' href='#modal" . $iiddd . "'>Sudah (" . $sudah . ")</a></td>";
                          ?>
                          <div id="modal<?php echo $iiddd; ?>" class="modal">
                            <div class="modal-content">
                              <?php
                              $cek_hasil = mysqli_query($connectdb, "SELECT * FROM hasil WHERE id_siswa='$iiddd' AND id_soal='1'");
                              while ($haaasil = mysqli_fetch_assoc($cek_hasil)) {
                                // echo $haaasil['id_guru'] . " ";
                                $ggguuruu = $haaasil['id_guru'];
                                $ck_matpel = mysqli_query($connectdb, "SELECT * FROM matpel WHERE muncul='on'");
                                while ($ckk_matpel = mysqli_fetch_assoc($ck_matpel)) {
                                  $nm_matpel = $ckk_matpel['matpel'];
                                  $cek_guruu = mysqli_query($connectdb, "SELECT * FROM guru2 WHERE id='$ggguuruu' AND matpel='$nm_matpel'");
                                  while ($gguru = mysqli_fetch_assoc($cek_guruu)) {
                                    echo "<div class='blue rcorners1 white-text'>";
                                    echo $gguru['nama'] ." : " . $gguru['matpel'] . "<br />";
                                    echo "</div>";
                                  }
                                }
                              }
                              ?>
                            </div>
                            <div class="modal-footer">
                              <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Tutup</a>
                            </div>
                          </div>
                          <?php

                        } else {
                          echo "<td>Belum</td>";
                        }
                         ?>
                         <td>
                           <!-- <a href="#" class="btn blue">Edit</a> -->
                           <button data-target="edit-siswa-<?php echo $siswa['id']; ?>" class="btn modal-trigger blue">Edit</button>
                           <div id="edit-siswa-<?php echo $siswa['id']; ?>" class="modal modal-fixed-footer">
                             <div class="modal-content">
                               <h4><?php echo $siswa['nama']; ?></h4>
                               <h6><?php echo $siswa['kelas']; ?></h6>
                               <div class="tambah_nama_guru">
                                 <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                               <table>
                                 <tr>
                                   <td>Nama</td>
                                   <input type="hidden" name="id_edit_siswa" value="<?php echo $siswa['id']; ?>" />
                                   <td><input type="text" name="nama_siswa" value="<?php echo $siswa['nama']; ?>" /></td>
                                 </tr>
                                 <tr>
                                   <td>Absen</td>
                                   <td>
                                     <select class="browser-default" name="edit-siswa-absen">
                                       <?php
                                       for ($i=1; $i <= 40 ; $i++) {
                                         if ($i == $siswa['absen']) {
                                           echo "<option value='" . $i . "' selected>" . $i . "</option>";
                                         } else {
                                           echo "<option value='" . $i . "' >" . $i . "</option>";
                                         }
                                       }
                                        ?>
                                     </select>
                                   </td>
                                 </tr>
                                 <tr>
                                   <td>NIS</td>
                                   <td><input type="text" name="nis_siswa" value="<?php  echo $siswa['nis'];  ?>" /></td>
                                 </tr>
                                 <tr>
                                   <td>Kelas</td>
                                   <td>
                                     <!-- <label>Browser Select</label> -->
                                     <select class="browser-default" name="edit-siswa-kelas">
                                       <option value="" disabled selected>Choose your option</option>
                                       <?php
                                       foreach ($kelas as $key) {
                                         if ($key == $siswa['kelas']) {
                                           echo "<option value='" . $key . "' selected>" . $key . "</option>";
                                         } else {
                                           echo "<option value='" . $key . "' >" . $key . "</option>";
                                         }
                                       }
                                       ?>
                                     </select>

                                   </td>
                                 </tr>
                                 <tr>
                                   <td>Password</td>
                                   <td><input type="text" name="pass_siswa" value="123" /></td>
                                 </tr>
                               </table>
                             </div>
                             </div>
                             <div class="modal-footer">
                               <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Tutup</a>
                               <a href="hapus.php?jenis=siswa&id=<?php echo $siswa['id']; ?>" class="modal-action modal-close waves-effect waves-green btn-flat">Hapus</a>
                               <input type="submit" name="edit-siswa-submit" class="submit-rasa-a btn-flat" value="Submit" />
                             </div>
                           </form>
                           </div>
                         </td>
                        </tr>
                        <!-- SECTION -->
                        <?php
                        }
                      }
                    ?>
                 </table>
                 <?php
                 if (!isset($_POST['cari_nama_siswa'])) {
                   ?>

                 <center>
                   <ul class="pagination">
                     <?php
                     if ($page == 1) {
                       ?>
                       <li class="disabled"><i class="material-icons">chevron_left</i></li>
                       <?php
                     } else {

                         $lanjut = $page - 1;
                         ?>
                         <li><a href="?halaman=<?php echo $lanjut; ?>"><i class="material-icons">chevron_left</i></a></li>
                         <?php

                     }

                   for ($i = max(1, $page - 5); $i <= min($page + 5, $pages) ; $i++) {
                     if ($i != $page) {
                       ?>
                        <li><a href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                      <?php
                    }
                       if ($i == $page) {
                         ?>
                          <li class=" active blue"><a class="disabled"><?php echo $i; ?></a></li>
                        <?php
                      }

                   }

                    if ($page == $pages) {
                      ?>
                      <li class="disabled"><i class="material-icons">chevron_right</i></li>
                      <?php
                    } else {
                      $lanjut = $page + 1;
                      ?>
                      <li class="waves-effect"><a href="?halaman=<?php echo $lanjut; ?>"><i class="material-icons">chevron_right</i></a></li>
                      <?php
                    }
                    ?>
                  </ul>
                </center>
                <?php
                }
                ?>
               </div>
             </div>

             <div class="frame" id="tambah-guru" style='display:none'>
                <div class="card-content">
                  <h4>Tambah Guru</h4>
                 <!-- <a href="#" class="btn blue" onclick="openFrame('guru')"><i class="inline-icon material-icons">add</i> Tambah Guru</a> -->
                 <div class="tambah_nama_guru">
                   <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" name="tambah_guru">
                     <input type="hidden" name="tambah_guru_iya" value="yes" />
                     <input type="hidden" name="terakhir_frame" value="tambah_guru" />
                  <table>
                    <tr>
                      <td>Nama</td>
                      <td><input type="text" name="tambah-guru-nama" /></td>
                    </tr>
                    <tr>
                      <td>Mata Pelajaran</td>
                      <td>
                        <select class="browser-default" name="select-matpel-tambah">
                          <option value="" disabled selected>Pilih Mata Pelajaran</option>
                          <?php
                          if (isset($_SESSION['salah_tambah_guru']) && $_SESSION['salah_tambah_guru'] == True) {
                            $show_matpel = mysqli_query($connectdb, "SELECT * FROM matpel");
                            while ($matpel = mysqli_fetch_assoc($show_matpel)) {
                              if ($matpel['id'] == $_POST['select-matpel-tambah']) {
                                echo "<option value='" . $matpel['id'] . "' selected>" . $matpel['matpel'] . "</option>";
                              } else {
                                echo "<option value='" . $matpel['id'] . "'>" . $matpel['matpel'] . "</option>";
                              }
                            }
                          } else {
                            $show_matpel = mysqli_query($connectdb, "SELECT * FROM matpel");
                            while ($matpel = mysqli_fetch_assoc($show_matpel)) {
                              echo "<option value='" . $matpel['id'] . "'>" . $matpel['matpel'] . "</option>";
                            }
                          }
                           ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td>Kelas</td>
                      <td>
                        <p class="line-height: 2pt">
                          <label>
                            <?php
                            if (isset($_SESSION['salah_tambah_guru']) && $_SESSION['salah_tambah_guru'] == True) {
                              if (isset($_POST['kelas-xii'])) {
                                ?>
                                <input type="checkbox" name="kelas-xii" checked="checked"/>
                                <?php
                              } else {
                                ?>
                                <input type="checkbox" name="kelas-xii" />
                                <?php
                              }
                            } else {
                              ?>
                              <input type="checkbox" name="kelas-xii" />
                              <?php
                            }
                            ?>
                            <span class="black-text">XII</span>
                          </label>
                        </p>
                        <p class="line-height: 2pt">
                          <label>
                            <?php
                            if (isset($_SESSION['salah_tambah_guru']) && $_SESSION['salah_tambah_guru'] == True) {
                              if (isset($_POST['kelas-xi'])) {
                                ?>
                                <input type="checkbox" name="kelas-xi" checked="checked"/>
                                <?php
                              } else {
                                ?>
                                <input type="checkbox" name="kelas-xi" />
                                <?php
                              }
                            } else {
                              ?>
                              <input type="checkbox" name="kelas-xi" />
                              <?php
                            }
                            ?>
                            <span class="black-text">XI</span>
                          </label>
                        </p>
                        <p class="line-height: 2pt">
                          <label>
                            <?php
                            if (isset($_SESSION['salah_tambah_guru']) && $_SESSION['salah_tambah_guru'] == True) {
                              if (isset($_POST['kelas-x'])) {
                                ?>
                                <input type="checkbox" name="kelas-x" checked="checked"/>
                                <?php
                              } else {
                                ?>
                                <input type="checkbox" name="kelas-x" />
                                <?php
                              }
                            } else {
                              ?>
                              <input type="checkbox" name="kelas-x" />
                              <?php
                            }
                            ?>
                            <span class="black-text">X</span>
                          </label>
                        </p>
                      </td>
                    </tr>
                  </table>
                </div>
                </div>
                <div class="card-action">
                  <a href="#" onclick="openFrame('guru')">Cancel</a>
                  <!-- <a href="#" onclick='document.forms["tambah_guru"].submit(); return false;'>Submit</a> -->
                  <input type="submit" name="tambah_guru_submit" class="submit-rasa-a btn-flat" value="Submit" />
                </div>
              </form>
             </div>
             <?php
             $id_guru = mysqli_query($connectdb, "SELECT * FROM guru2");
             while ($id_guru2 = mysqli_fetch_assoc($id_guru)) {
               $id_gurueuy = $id_guru2['id'];
               $nama_gurueuy = $id_guru2['nama'];
               $matpel_gurueuy = $id_guru2['matpel'];
               ?>
               <div id="edit-guru-<?php echo $id_guru2['id']; ?>" class="frame" style="display: none">
                 <div class="card-content">
                   <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                   <input type="hidden" name="terakhir_frame" value="edit-guru-<?php echo $id_gurueuy; ?>" />
                   <input type="hidden" name="edit_guru_id" value="<?php echo $id_gurueuy; ?>" />
                   <h4><?php echo $id_guru2['nama']; ?></h4>
                   <h6><?php echo $id_guru2['matpel']; ?></h6>
                   <div class="tambah_nama_guru">
                   <table>
                     <tr>
                       <td>Nama</td>

                       <td><input type="text" name="edit-guru-nama" value="<?php echo $id_guru2['nama']; ?>" /></td>
                     </tr>
                     <tr>
                       <td>Mata Pelajaran</td>
                       <td>
                         <select class="browser-default" name="select-matpel-edit">
                           <option value="" disabled>Choose your option</option>
                           <?php
                           $show_matpel = mysqli_query($connectdb, "SELECT * FROM matpel");
                           while ($matpel = mysqli_fetch_assoc($show_matpel)) {
                             if ($matpel['matpel'] == $id_guru2['matpel']) {
                               echo "<option value='" . $matpel['id'] . "' selected>" . $matpel['matpel'] . "</option>";
                             } else {
                               echo "<option value='" . $matpel['id'] . "'>" . $matpel['matpel'] . "</option>";
                             }
                           }
                            ?>
                         </select>
                       </td>
                     </tr>
                     <tr>
                       <td>Kelas</td>
                       <td>
                         <p class="line-height: 2pt">
                           <label>
                             <?php
                             $cek_keeelas = mysqli_query($connectdb, "SELECT * FROM guru WHERE nama='$nama_gurueuy' AND matpel='$matpel_gurueuy' AND kelas='XII'");
                             if ($cek_keeelas) {
                               $cek_keeelas2 = mysqli_fetch_assoc($cek_keeelas);
                               $cek_keeelas3 = $cek_keeelas2['kelas'];
                               if ($cek_keeelas3 == "XII") {
                                 ?>
                                  <input type="checkbox" name="kelas-xii" checked="checked" />
                                 <?php
                               } else {
                                 ?>
                                  <input type="checkbox" name="kelas-xii" />
                                 <?php
                               }
                             }
                              ?>
                             <span class="black-text">XII</span>
                           </label>
                         </p>
                         <p>
                           <label>
                             <?php
                             $cek_keeelas = mysqli_query($connectdb, "SELECT * FROM guru WHERE nama='$nama_gurueuy' AND matpel='$matpel_gurueuy' AND kelas='XI'");
                             if ($cek_keeelas) {
                               $cek_keeelas2 = mysqli_fetch_assoc($cek_keeelas);
                               $cek_keeelas3 = $cek_keeelas2['kelas'];
                               if ($cek_keeelas3 == "XI") {
                                 ?>
                                  <input type="checkbox" name="kelas-xi" checked="checked" />
                                 <?php
                               } else {
                                 ?>
                                  <input type="checkbox" name="kelas-xi" />
                                 <?php
                               }
                             }
                              ?>
                             <span class="black-text">XI</span>
                           </label>
                         </p>
                         <p>
                           <label>
                             <?php
                             $cek_keeelas = mysqli_query($connectdb, "SELECT * FROM guru WHERE nama='$nama_gurueuy' AND matpel='$matpel_gurueuy' AND kelas='X'");
                             if ($cek_keeelas) {
                               $cek_keeelas2 = mysqli_fetch_assoc($cek_keeelas);
                               $cek_keeelas3 = $cek_keeelas2['kelas'];
                               if ($cek_keeelas3 == "X") {
                                 ?>
                                  <input type="checkbox" name="kelas-x" checked="checked" />
                                 <?php
                               } else {
                                 ?>

                                  <input type="checkbox" name="kelas-x" />
                                 <?php
                               }
                             }
                              ?>
                             <span class="black-text">X</span>
                           </label>
                         </p>
                       </td>
                     </tr>
                   </table>
                 </div>

                 </div>
                 <div class="card-action">
                   <a href="#" onclick="openFrame('guru')">Cancel</a>
                   <a class="red-text bold" href="hapus.php?jenis=guru&id=<?php echo $id_gurueuy; ?>">Hapus</a>
                   <input type="submit" name="edit_guru_submit" class="submit-rasa-a btn-flat" value="Submit" />
                 </div>
                 </form>
               </div>
               <?php
             }
             ?>


             <div id="guru" class="frame" style='display:none'>
             <div class="card-content">
               <h4>Guru</h4>
               <div style="float: right; padding-bottom:10px;">
                 <a href="#" class="btn blue" onclick="openFrame('tambah-guru')"><i class="inline-icon material-icons">add</i> Tambah Guru</a>
                 <button onclick="togel('cari-guru');" class="btn green"><i class="inline-icon material-icons">search</i> Cari Guru</button>
                 <?php
                 if (isset($_POST['submit_cari_guru'])) {
                   ?>
                 <a href="<?php echo $_SERVER['PHP_SELF'] . "?mbalek_guru=True"; ?>" class="btn green"><i class="inline-icon material-icons">arrow_back</i> Back</a>
                 <?php
               }
                ?>
               </div>
               <div id='cari-guru'  style='display:none'>
                 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                 <div class="input-field col s12 l12">
                   <i class="material-icons prefix">account_circle</i>
                   <input id="cari_nama_siswa" type="text" name="cari_nama_guru">
                   <label for="cari_nama_siswa">Nama</label>
                 </div>
                 <div class="input-field col s12 l6">
                   <i class="material-icons prefix">assignment</i>
                  <select name="select-cari-guru">
                    <option value="" disabled selected>Choose your option</option>
                    <?php
                    $cekk_matpel = mysqli_query($connectdb, "SELECT * FROM matpel");
                    while ($mattpel = mysqli_fetch_assoc($cekk_matpel)) {
                      echo "<option>" . $mattpel['matpel'] . "</option>";
                    }
                     ?>
                  </select>
                  <label>Mata Pelajaran</label>
                 </div>
                 <div class="col s12 l12">
                   <input type="submit" class="btn green" name="submit_cari_guru" value="Cari Guru" style="float: right" />
                </div>
              </form>
               </div>

               <table>
                 <th>
                   <td>Nama</td>
                   <td>Mata Pelajaran</td>
                   <td>Aksi</td>
                 </th>
                 <?php
                 if (isset($_POST['submit_cari_guru'])) {
                   if (isset($_POST['cari_nama_guru']) && !empty($_POST['cari_nama_guru'])) {
                     $query_nama = $_POST['cari_nama_guru'];
                     $cek_gurrru = mysqli_query($connectdb, "SELECT * FROM guru2 WHERE UPPER(nama) LIKE UPPER('%" . $query_nama . "%')");
                   }
                   if (isset($_POST['select-cari-guru'])) {
                     $matpel_guru = $_POST['select-cari-guru'];
                     $cek_gurrru = mysqli_query($connectdb, "SELECT * FROM guru2 WHERE matpel='$matpel_guru'");
                   }
                   if (isset($_POST['cari_nama_guru']) && !empty($_POST['cari_nama_guru']) && isset($_POST['select-cari-guru'])) {
                     $query_nama = $_POST['cari_nama_guru'];
                     $matpel_guru = $_POST['select-cari-guru'];
                     $cek_gurrru = mysqli_query($connectdb, "SELECT * FROM guru2 WHERE UPPER(nama) LIKE UPPER('%" . $query_nama . "%') AND matpel='$matpel_guru'");
                   }
                 } else {
                   $cek_gurrru = mysqli_query($connectdb, "SELECT * FROM guru2");
                 }
                 while ($gurrru = mysqli_fetch_assoc($cek_gurrru)) {
                   $id_gguru = $gurrru['id'];
                   ?>
                   <tr>
                     <td><?php echo $gurrru['id']; ?></td>
                     <td><?php echo $gurrru['nama']; ?></td>
                     <td><?php echo $gurrru['matpel']; ?></td>
                     <td>
                       <a href="#" class="btn blue" style="margin-right: 5px" onclick="openFrame('edit-guru-<?php echo $id_gguru; ?>')">
                         <i class="inline-icon material-icons">edit</i> Edit
                       </a>
                       <a href="hasil.php?guru=<?php echo $gurrru['id']; ?>" target="_blank" class="btn blue-lighten-1">
                         <i class="inline-icon material-icons">file_download</i> Unduh
                       </a>
                     </td>
                   </tr>
                   <?php
                 }
                  ?>
               </table>
             </div>
           </div>
           <div id="matpel" class="frame" style='display:none'>
           <div class="card-content">
             <h4>Mata Pelajaran</h4>
             <div style="float: right; padding-bottom:10px;">
               <!-- <a href="#tambah-matpel" class="btn blue"><i class="inline-icon material-icons">add</i> Tambah Mata Pelajaran</a> -->
              <button data-target="tambah-matpel" class="btn blue modal-trigger"><i class="inline-icon material-icons">add</i> Tambah Mata Pelajaran</button>
              <button onclick="togel('cari-matpel');" class="btn green"><i class="inline-icon material-icons">search</i> Cari Mata Pelajaran</button>
              <?php
              if (isset($_POST['submit_cari_matpel'])) {
                ?>
              <a href="<?php echo $_SERVER['PHP_SELF'] . "?mbalek_matpel=True"; ?>" class="btn green"><i class="inline-icon material-icons">arrow_back</i> Back</a>
              <?php
            }
             ?>
             </div>
             <div id='cari-matpel' style="display: none">
               <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
               <div class="input-field col s12 l12">
                 <i class="material-icons prefix">account_circle</i>
                 <input id="cari_nama_siswa" type="text" name="cari_nama_matpel">
                 <label for="cari_nama_siswa">Nama</label>
               </div>
               <input type="submit" class="btn green" name="submit_cari_matpel" style="float: right" value="Cari Mata Pelajaran" />
             </form>
             </div>
             <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
             <table>
               <tr>
                 <th>No</th>
                 <th>Nama</th>
                 <th width="20%">Muncul</th>
                 <th width="20%">Aksi</th>
               </tr>
               <?php
               if (isset($_POST['submit_cari_matpel'])) {
                 if (isset($_POST['cari_nama_matpel']) && !empty($_POST['cari_nama_matpel'])) {
                   $query_nama = $_POST['cari_nama_matpel'];
                   $query_nama = strtoupper($_POST['cari_nama_matpel']);
                   $cek_matpel = mysqli_query($connectdb, "SELECT * FROM matpel WHERE matpel LIKE '%" . $query_nama . "%'");
                 }
               } else {
                 $cek_matpel = mysqli_query($connectdb, "SELECT * FROM matpel");
               }
               while ($matpel = mysqli_fetch_assoc($cek_matpel)) {
                 ?>
                 <tr>
                   <td width="1%"><?php echo $matpel['id']; ?></td>
                   <td><?php echo $matpel['matpel']; ?></td>
                   <td>
                     <?php
                     if (isset($matpel['muncul']) && $matpel['muncul'] == "on") {
                       ?>
                       <div class="switch">
                         <label>
                           Off
                           <input type="checkbox" class="blue" name='matpel_<?php echo $matpel['id']; ?>' checked="checked" >
                           <span class="lever "></span>
                           On
                         </label>
                       </div>
                       <td><button data-target="edit-matpel-<?php echo $matpel['id']; ?>" class="btn modal-trigger">Edit</button></td>
                     </td>
                   </tr>

                   <?php
                     } else {
                       ?>
                       <div class="switch">
                         <label>
                           Off
                           <input type="checkbox" class="blue" name="matpel_<?php echo $matpel['id']; ?>" >
                           <span class="lever "></span>
                           On
                         </label>
                       </div>
                     </td>
                     <td><button data-target="edit-matpel-<?php echo $matpel['id']; ?>" class="btn modal-trigger">Edit</button></td>
                   </tr>
                   <?php
                     }
               }
               ?>
             </table>
             <div style="margin-bottom: 20px"></div>
             <center>
               <input type="submit" name="submit_matpel" class="btn blue" value="Edit"/>
             </center>
           </form>
           </div>
         </div>

         <div id="guru" class="frame" style='display:none'>
         <div class="card-content">
           <!-- <h4>Guru</h4> -->

         </div>
       </div>

             </div>
           <!-- </div> -->
         </div>
       </div>
   </main>
   <?php
   $ambil_matpel = mysqli_query($connectdb, "SELECT * FROM matpel");
   while ($matpel = mysqli_fetch_assoc($ambil_matpel)) {
     ?>
     <div id="edit-matpel-<?php echo $matpel['id']; ?>" class="modal">
       <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
       <div class="modal-content">
         <input type="hidden" name="edit-id-matpel" value="<?php echo $matpel['id']; ?>"></input>
         <h4><?php echo $matpel['matpel']; ?></h4>
         <div class="tambah_nama_guru">
           <table>
             <tr>
               <td>Nama</td>
               <td><input type="text" name="name-edit-matpel" value="<?php echo $matpel['matpel']; ?>" /></td>
             </tr>
             <tr>
               <td>Muncul</td>
               <td>
                 <div class="switch">
                   <label>
                     Off
                     <?php
                     if ($matpel['muncul'] == "on") {
                       ?>
                       <input type="checkbox" class="blue" name="muncul-matpel" checked="checked">
                       <?php
                     } else {
                       ?>
                       <input type="checkbox" class="blue" name="muncul-matpel" >
                       <?php
                     }
                      ?>
                     <span class="lever "></span>
                     On
                   </label>
                 </div>
               </td>
             </tr>
           </table>
         </div>
       </div>
       <div class="modal-footer">
         <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Tutup</a>
         <a href="hapus.php?jenis=matpel&id=<?php echo $matpel['id']; ?>" class="waves-effect waves-green btn-flat">Hapus</a>
         <input type="submit" name="edit-matpel-submit" class="submit-rasa-a btn-flat" value="Submit" />
       </form>
       </div>
     </div>

     <?php
   }
    ?>
    <div id="tambah-matpel" class="modal">
      <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
      <div class="modal-content">
        <h4>Tambah Mata Pelajaran</h4>
        <div class="tambah_nama_guru">
          <table>
            <tr>
              <td>Nama</td>
              <td><input type="text" name="name-tambah-matpel" /></td>
            </tr>
            <tr>
              <td>Muncul</td>
              <td>
                <div class="switch">
                  <label>
                    Off
                    <input type="checkbox" class="blue" name="muncul-matpel" >
                    <span class="lever "></span>
                    On
                  </label>
                </div>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Tutup</a>
        <input type="submit" name="tambah-matpel-submit" class="submit-rasa-a btn-flat" value="Submit" />
      </form>
      </div>
    </div>
   <script>
   $(document).ready(function() {
     // $('.sidenav').sidenav();
     <?php
     $list_matpel = mysqli_query($connectdb, "SELECT * FROM matpel");
     while ($id_mattpel = mysqli_fetch_assoc($list_matpel)) {
       echo "$('.edit-matpel-" . $id_mattpel['id'] . "').modal();";
     }
      ?>
     $('.tambah-matpel').modal();
   });
   </script>
   <script>
   $(document).ready(function() {
     $('.tambah-matpel').modal();
   });
   <?php
     if (isset($_SESSION['salah_tambah_guru']) && $_SESSION['salah_tambah_guru'] == True) {
       echo "openFrame('tambah-guru');";
     }
    ?>
    <?php
      if (isset($_SESSION['salah_tambah_guru']) && $_SESSION['salah_tambah_guru'] == True) {
        echo "openFrame('tambah-guru');";
      }
     ?>
     <?php
     if (isset($_POST['submit_cari_matpel'])){
       echo "openFrame('matpel');";
     }
     ?>
     <?php
     if (isset($_GET['mbalek_matpel']) && $_GET['mbalek_matpel'] == True){
       echo "openFrame('matpel');";
     }
     ?>
     <?php
     if (isset($_POST['submit_cari_guru'])){
       echo "openFrame('guru');";
     }
     ?>
     <?php
     if (isset($_GET['mbalek_guru']) && $_GET['mbalek_guru'] == True){
       echo "openFrame('guru');";
     }
     ?>
    <?php
    if (isset($_POST['tambah-matpel-submit'])) {
      echo "openFrame('matpel');";
    }
     ?>
     <?php
     if (isset($_POST['tambah-matpel-submit'])) {
       echo "openFrame('matpel');";
     }
      ?>
      <?php
      if (isset($_POST['tambah-matpel-submit'])) {
        echo "openFrame('matpel');";
      }
       ?>
       <?php
       if(isset($_POST['submit_cari_siswa'])) {
         echo "openFrame('siswa');";
       }
        ?>
       <?php
       if (isset($_SESSION['salah-edit-siswa']) && $_SESSION['salah-edit-siswa'] == True) {
         if (isset($_POST['nama_siswa']) && !empty($_POST['nama_siswa'])) {
           $nama_siswa = $_POST['nama_siswa'];
           if (isset($_POST['edit-siswa-absen']) && !empty($_POST['edit-siswa-absen'])) {
             $absen_siswa = $_POST['edit-siswa-absen'];
             if (isset($_POST['nis_siswa']) && !empty($_POST['nis_siswa'])) {
               $nis_siswa = $_POST['nis_siswa'];
               if (isset($_POST['edit-siswa-kelas']) && !empty($_POST['edit-siswa-kelas'])) {
                 $kelas_siswa = $_POST['edit-siswa-kelas'];
                 if (isset($_POST['pass_siswa']) && !empty($_POST['pass_siswa'])) {
                   $pass_siswa = $_POST['pass_siswa'];
                   $pass_siswa = md5($pass_siswa);
                   $cek_siswa = mysqli_query($connectdb, "SELECT * FROM siswa WHERE absen='$absen_siswa' AND nis='$nis_siswa' AND nama='$nama_siswa' AND kelas='$kelas_siswa' AND pass='$pass_siswa'");
                   if (mysqli_num_rows($cek_siswa) <= 0) {
                     // $perintah_sql = "UPDATE siswa SET absen='$absen_siswa' AND nis='$nis_siswa' AND nama='$nama_siswa' AND kelas='$kelas_siswa' AND pass='$pass_siswa' WHERE id='$id_edit_siswa'";
                   } else {
                     // $kesalahan_tambah_siswa = $kesalahan_tambah_siswa + 1;
                     echo "M.toast({html: 'Siswa sudah ada!'});";
                   }
                 } else {
                   // $kesalahan_tambah_siswa = $kesalahan_tambah_siswa + 1;
                   echo "M.toast({html: 'Kolom password kosong!'});";
                 }
               } else {
                 // $kesalahan_tambah_siswa = $kesalahan_tambah_siswa + 1;
                 echo "M.toast({html: 'Pilih kelas yang disediakan!'});";
               }
             } else {
               // $kesalahan_tambah_siswa = $kesalahan_tambah_siswa + 1;
               echo "M.toast({html: 'Isikan NIS siswa!'});";
             }
           } else {
             // $kesalahan_tambah_siswa = $kesalahan_tambah_siswa + 1;
             echo "M.toast({html: 'Pilih absen yang disediakan!'});";
           }
         } else {
           // $kesalahan_tambah_siswa = $kesalahan_tambah_siswa + 1;
           echo "M.toast({html: 'Isikan nama siswa!'});";
         }
       }
       ?>
       <?php
       if (isset($_SESSION['salah-tambah-siswa']) && $_SESSION['salah-tambah-siswa'] == True) {
         if (isset($_POST['nama_siswa']) && !empty($_POST['nama_siswa'])) {
           // $nama_siswa = $_POST['nama_siswa'];
           if (isset($_POST['tambah-select-absen']) && !empty($_POST['tambah-select-absen'])) {
             // $absen_siswa = $_POST['tambah-select-absen'];
             if (isset($_POST['nis_siswa']) && !empty($_POST['nis_siswa'])) {
               // $nis_siswa = $_POST['nis_siswa'];
               if (isset($_POST['tambah-select-siswa']) && !empty($_POST['tambah-select-siswa'])) {
                 // $kelas_siswa = $_POST['tambah-select-siswa'];
                 if (isset($_POST['pass_siswa']) && !empty($_POST['pass_siswa'])) {
                   // $pass_siswa = $_POST['pass_siswa'];
                   // $pass_siswa = md5($pass_siswa);
                   // $perintah_sql = "INSERT INTO siswa(absen, nis, nama, kelas, pass) VALUES('$absen_siswa', '$nis_siswa', '$nama_siswa', '$kelas_siswa', '$pass_siswa')";
                   $cek_siswa = mysqli_query($connectdb, "SELECT * FROM siswa WHERE absen='$absen_siswa' AND nis='$nis_siswa' AND nama='$nama_siswa' AND kelas='$kelas_siswa' AND pass='$pass_siswa'");
                   if (mysqli_num_rows($cek_siswa) <= 0) {
                     // $perintah_sql = "INSERT INTO siswa(absen, nis, nama, kelas, pass) VALUES('$absen_siswa', '$nis_siswa', '$nama_siswa', '$kelas_siswa', '$pass_siswa')";
                   } else {
                     // $kesalahan_tambah_siswa = $kesalahan_tambah_siswa + 1;
                     echo "M.toast({html: 'Siswa sudah ada!'});";
                   }
                 } else {
                   // $kesalahan_tambah_siswa = $kesalahan_tambah_siswa + 1;
                   echo "M.toast({html: 'Kolom password kosong!'});";
                 }
               } else {
                 // $kesalahan_tambah_siswa = $kesalahan_tambah_siswa + 1;
                 echo "M.toast({html: 'Pilih kelas yang disediakan!'});";
               }
             } else {
               // $kesalahan_tambah_siswa = $kesalahan_tambah_siswa + 1;
               echo "M.toast({html: 'Isikan NIS siswa!'});";
             }
           } else {
             // $kesalahan_tambah_siswa = $kesalahan_tambah_siswa + 1;
             echo "M.toast({html: 'Pilih absen yang disediakan!'});";
           }
         } else {
           // $kesalahan_tambah_siswa = $kesalahan_tambah_siswa + 1;
           echo "M.toast({html: 'Isikan nama siswa!'});";
         }
       }
        ?>
     <?php
     if (isset($_SESSION['salah-edit-matpel']) && $_SESSION['salah-edit-matpel'] == True) {
       if (isset($_POST['name-edit-matpel']) && !empty($_POST['name-edit-matpel'])) {
         $id_matpel = $_POST['edit-id-matpel'];
         $nama_matpel = $_POST['name-edit-matpel'];
         $cek_ada = mysqli_query($connectdb, "SELECT * FROM matpel WHERE matpel='$nama_matpel'");
         if (mysqli_num_rows($cek_ada) <= 0 ) {
           if (isset($_POST['muncul-matpel'])) {
             // $tambah_matpel = "UPDATE matpel SET matpel='$nama_matpel', muncul='on' WHERE id='$id_matpel'";
           } else {
             // $tambah_matpel = "UPDATE matpel SET matpel='$nama_matpel' WHERE id='$id_matpel'";
           }
         } else {
           echo "M.toast({html: 'Mata Pelajaran sudah ada'});";
         }
       } else {
         echo "M.toast({html: 'Masukkan Nama Mata Pelajaran'});";
       }
     }

      ?>
     <?php
     if (isset($_SESSION['salah-tambah-matpel']) && $_SESSION['salah-tambah-matpel'] == True) {
       if (isset($_POST['name-tambah-matpel']) && !empty($_POST['name-tambah-matpel'])) {
         $nama_matpel = $_POST['name-tambah-matpel'];
         $cek_ada = mysqli_query($connectdb, "SELECT * FROM matpel WHERE matpel='$nama_matpel'");
         if (mysqli_num_rows($cek_ada) <= 0 ) {
           if (isset($_POST['muncul-matpel'])) {
             // $tambah_matpel = "INSERT INTO matpel(matpel, muncul) VALUES('$nama_matpel', 'on')";
           } else {
             // $tambah_matpel = "INSERT INTO matpel(matpel) VALUES('$nama_matpel')";
           }
         } else {
           echo "M.toast({html: 'Mata Pelajaran sudah ada'});";
         }
       } else {
         // $kesalahan_tambah_matpel = $kesalahan_tambah_matpel + 1;
         echo "M.toast({html: 'Masukkan Nama Mata Pelajaran'});";
       }
     }
      ?>
    <?php
    if (isset($_SESSION['warning'])) {
      echo "M.toast({html: '" . $_SESSION['warning'] . "'});";
      unset($_SESSION['warning']);
    }
     ?>
    // M.toast({html: 'I am a toast'});
    <?php
    if (isset($_SESSION['salah_edit_guru']) && $_SESSION['salah_edit_guru'] == True) {
      $kesalahan_edit_guru = 0;
      $id_gurru = $_POST['edit_guru_id'];
      $sementara = mysqli_query($connectdb, "SELECT * FROM guru2 WHERE id='$id_gurru'");
      $sementara2 = mysqli_fetch_assoc($sementara);
      $jeneng_guru = $sementara2['nama'];
      $matupel_guru = $sementara2['matpel'];

      if (isset($_POST['select-matpel-edit']) && $_POST['select-matpel-edit'] != "") {
        $id_matpel = $_POST['select-matpel-edit'];
        $cek_matpel = mysqli_query($connectdb, "SELECT * FROM matpel WHERE id='$id_matpel'");
        $ceek_matpel = mysqli_fetch_assoc($cek_matpel);
        $matpelnyaa = $ceek_matpel['matpel'];
      } else {
        // $kesalahan_edit_guru = $kesalahan_edit_guru + 1;
        echo "M.toast({html: 'Masukkan Mata Pelajaran'});";
      }

      if (isset($_POST['edit-guru-nama'])) {
        if (isset($_POST['edit-guru-nama']) && !empty($_POST['edit-guru-nama'])){
          // $nama_gguruu = $_POST['edit-guru-nama'];
        } else {
          // $kesalahan_edit_guru = $kesalahan_edit_guru + 1;
          // echo "M.toast({html: 'Masukkan Mata Pelajaran'});";
          // echo "M.toast({html: 'Guru telah ada!'});";
          echo "
          M.toast({html: 'Isikan Nama Guru!'});";

        }
        if (isset($matpelnyaa) && isset($nama_gguruu) && $kesalahan_edit_guru <= 0) {
          $cek_ada = mysqli_query($connectdb, "SELECT * FROM guru2 WHERE nama='$nama_gguruu' AND matpel='$matpelnyaa'");
        }
        if (isset($cek_ada)) {
          if (mysqli_num_rows($cek_ada) > 0) {
            // $kesalahan_edit_guru = $kesalahan_edit_guru + 1;
            echo "M.toast({html: 'Guru telah ada!'});";

          } else {
            // $nama_gguru = $_POST['edit-guru-nama'];
          }
        }
      } else {
        $kesalahan_edit_guru = $kesalahan_edit_guru + 1;
      }
    }

     ?>
    <?php
    if (isset($_SESSION['salah_tambah_guru']) && $_SESSION['salah_tambah_guru'] == True) {
      if (isset($_POST['select-matpel-tambah'])) {
        $id_matpel = $_POST['select-matpel-tambah'];
        $cek_matpel = mysqli_query($connectdb, "SELECT * FROM matpel WHERE id='$id_matpel'");
        $ceek_matpel = mysqli_fetch_assoc($cek_matpel);
        $matpelnyaa = $ceek_matpel['matpel'];
      } else {
        // $kesalahan_tambah_guru = $kesalahan_tambah_guru + 1;
        echo "M.toast({html: 'Masukkan Mata Pelajaran'});";
      }

      if (isset($_POST['tambah-guru-nama']) && !empty($_POST['tambah-guru-nama'])) {
        $nama_gguruu = $_POST['tambah-guru-nama'];
        $cek_ada = mysqli_query($connectdb, "SELECT * FROM guru2 WHERE nama='$nama_gguruu' AND matpel='$matpelnyaa'");
        if (mysqli_num_rows($cek_ada) > 0) {
          echo "M.toast({html: 'Guru telah ada!'});";
        } else {
          // $nama_gguru = $_POST['tambah-guru-nama'];
        }
      } else {
        echo "
        M.toast({html: 'Isikan Nama Guru!'});";
      }

      if (empty($_POST['kelas-xii']) && empty($_POST['kelas-xi']) && empty($_POST['kelas-x'])) {
        echo "
        M.toast({html: 'Isikan Kelas pengajarnya!'})";
      }
    }
     ?>

   </script>
   </body>
   <footer class="page-footer grey darken-3 z-depth-3" style="display:">
     <div class="footer-copyright">
       <div class="container">
       © 2018 Copyrekt - Powered By tuxsenpaai
       <!-- <a class="grey-text text-lighten-4 right " href="#!">More Links</a> -->
       </div>
     </div>
   </footer>
 </html>

 <?php
unset($_SESSION['salah_tambah_guru']);
unset($_SESSION['salah_edit_guru']);
unset($_SESSION['salah-tambah-matpel']);
unset($_SESSION['salah-edit-matpel']);
unset($_SESSION['salah-tambah-siswa']);
unset($_SESSION['salah-edit-siswa']);
  ?>
