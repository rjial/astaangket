<?php
include 'config.php';
session_start();

if ($_GET['jenis'] == "guru") {
  if (isset($_SESSION['admin_angket'])) {
    if (isset($_GET['id'])) {
      $id_guru = $_GET['id'];
      $cek_ada = mysqli_query($connectdb, "SELECT * FROM guru2 WHERE id='$id_guru'");
      if (mysqli_num_rows($cek_ada) > 0) {
        $ada = mysqli_fetch_assoc($cek_ada);
        $nama_guru = $ada['nama'];
        $matpel_guru = $ada['matpel'];
        $hapus_data = mysqli_query($connectdb, "DELETE FROM guru2 WHERE id='$id_guru'");
        if ($hapus_data) {
          $hapus_data2 = mysqli_query($connectdb, "DELETE FROM guru WHERE matpel='$matpel_guru' AND nama='$nama_guru'");
          if ($hapus_data2) {
            $hapus_data3 = mysqli_query($connectdb, "DELETE FROM hasil WHERE id_guru='$id_guru'");
            if ($hapus_data3) {
              $_SESSION['warning'] = "Sukses hapus guru!";
              header ("Location: admin.php");
            }
          }
        }
      } else {
        $_SESSION['warning'] = "Guru tidak ada!";
        header ("Location: admin.php");
      }
    } else {
      $_SESSION['warning'] = "Guru tidak valid!";
      header ("Location: admin.php");
    }
  } else {
    header ("Location: admin.php");
  }
} elseif ($_GET['jenis'] == "matpel") {
  if (isset($_SESSION['admin_angket'])) {
    if (isset($_GET['id'])) {
      $id_matpel = $_GET['id'];
      $cek_ada = mysqli_query($connectdb, "SELECT * FROM matpel WHERE id='$id_matpel'");
      if (mysqli_num_rows($cek_ada) > 0) {
        $ada = mysqli_fetch_assoc($cek_ada);
        $matpel = $ada['matpel'];
        $hapus_data = mysqli_query($connectdb, "DELETE FROM matpel WHERE id='$id_matpel'");
        if ($hapus_data) {
          $hapus_guru = mysqli_query($connectdb, "DELETE FROM guru2 WHERE matpel='$matpel'");
          $hapus_guru2 = mysqli_query($connectdb, "DELETE FROM guru WHERE matpel='$matpel'");
          if ($hapus_guru && $hapus_guru2) {
            $_SESSION['warning'] = "Sukses hapus Mata Pelajaran!";
            header ("Location: admin.php");
          }
        }
      } else {
        $_SESSION['warning'] = "Mata Pelajaran tidak ada!";
        header ("Location: admin.php");
      }
    } else {
      $_SESSION['warning'] = "Mata Pelajaran tidak valid!";
      header ("Location: admin.php");
    }
  } else {
    header ("Location: admin.php");
  }

} elseif ($_GET['jenis'] == "siswa") {
  if (isset($_SESSION['admin_angket'])) {
    if (isset($_GET['id'])) {
      $id_siswa = $_GET['id'];
      $cek_ada = mysqli_query($connectdb, "SELECT * FROM siswa WHERE id='$id_siswa'");
      if (mysqli_num_rows($cek_ada) > 0) {
        $ada = mysqli_fetch_assoc($cek_ada);
        $hapus_hasil = mysqli_query($connectdb, "DELETE FROM hasil WHERE id_siswa='$id_siswa'");
        if ($hapus_hasil) {
          $hapus_siswa =  mysqli_query($connectdb, "DELETE FROM siswa WHERE id='$id_siswa'");
          if ($hapus_siswa) {
            $_SESSION['warning'] = "Sukses hapus siswa!";
            header ("Location: admin.php");
          }
        }
      }
    }
  }
} elseif ($_GET['jenis'] == "hasil") {
  if (isset($_SESSION['user_angket'])) {
    if (isset($_GET['id'])) {
        $id_guru = $_GET['id'];
        $id_saya = $_SESSION['user_angket'];
        $cek_ada = mysqli_query($connectdb, "SELECT * FROM hasil WHERE id_siswa='$id_saya' AND id_guru='$id_guru'");
        if (mysqli_num_rows($cek_ada) > 0) {
          $hapus_hasil = mysqli_query($connectdb, "DELETE FROM hasil WHERE id_siswa='$id_saya' AND id_guru='$id_guru'");
          if ($hapus_hasil) {
            $_SESSION['warning'] = "Sukses hapus angket!";
            header ("Location: cp.php");
          }
        } else {
          $_SESSION['warning'] = "Anda belum melakukan pengisian angket pada guru ini!";
          header ("Location: cp.php");
        }
    }
  } elseif (isset($_SESSION['admin_angket'])) {
    if (isset($_GET['id'])) {

    }
  }
} else {
  header ("Location: admin.php");
}

 ?>
