<?php
include 'config.php';
$guru = isset($_GET['guru'])? (int)$_GET["guru"]:1;
header("Content-type: application/vnd-ms-excel");
$nama_guruu = mysqli_query($connectdb, "SELECT * FROM guru2 WHERE id='$guru'");
$nama_guruu2 = mysqli_fetch_assoc($nama_guruu);
$nnama_guru = $nama_guruu2['nama'];
$nnama_guru = str_replace(' ', '_', $nnama_guru);
$matpel_guru = $nama_guruu2['matpel'];
$matpel_guru = str_replace(' ', '_', $matpel_guru);
// $isi_header = "Content-Disposition: attachment; filename=" . $nnama_guru . ".xls";
header("Content-Disposition: attachment; filename=" . $nnama_guru . "_" . $matpel_guru . ".xls");

 ?>
 <table border=1>
   <tr>
     <td>Nama</td>
     <?php
     $nama_guru = mysqli_query($connectdb, "SELECT nama FROM guru2 WHERE id='$guru'");
     $nama_guru2 = mysqli_fetch_assoc($nama_guru);
     echo "<td>" . $nama_guru2['nama'] . "</td>";
      ?>

   </tr>
   <tr>
     <td>Mata Pelajaran</td>
     <?php
     $nama_guru = mysqli_query($connectdb, "SELECT matpel FROM guru2 WHERE id='$guru'");
     $nama_guru2 = mysqli_fetch_assoc($nama_guru);
     echo "<td>" . $nama_guru2['matpel'] . "</td>";
      ?>

   </tr>
 </table>
 <table>
   <tr></tr>
   <tr></tr>
   <tr></tr>
   <tr></tr>
   <tr></tr>
 </table>
 <table border=1>
   <tr width="100%" style="100%">
     <td width="15%" style="15%">Nama</td>
     <td>Kelas</td>
     <td>NIS</td>
     <td>Waktu</td>
     <?php
     $soaal = mysqli_query($connectdb, "SELECT * FROM soal");
     while ($soal = mysqli_fetch_assoc($soaal)) {
       $iddddd = $soal['id'];
       echo "<td>" . $soal['soal'] . "</td>";
     }
      ?>
   </tr>
   <?php
   $siswa = mysqli_query($connectdb, "SELECT * FROM siswa");
   while ($ssiswa = mysqli_fetch_assoc($siswa)) {
     echo "<tr>";
     echo "<td>" . $ssiswa['nama'] . "</td>";
     echo "<td>" . $ssiswa['kelas'] . "</td>";
     echo "<td>" . $ssiswa['nis'] . "</td>";
     $iddd = $ssiswa['id'];
     // $hasil = mysqli_query($connectdb, "SELECT * FROM hasil WHERE id_siswa='$iddd' AND id_guru='$guru' AND id_soal='$iddddd'");
     // while ($hasill = mysqli_fetch_assoc($hasil)) {
     //   echo "<td>" . $hasill['hasil'] . "</td>";
     // }
       $hasil = mysqli_query($connectdb, "SELECT * FROM hasil WHERE id_siswa='$iddd' AND id_guru='$guru' AND id_soal='1'");
       while ($hasill = mysqli_fetch_assoc($hasil)) {
         if (isset($hasill['waktu'])) {
           echo "<td>" . $hasill['waktu'] . "</td>";
         } else {
           echo "<td>-</td>";
         }
       }


     $soaaal = mysqli_query($connectdb, "SELECT * FROM soal");
     while ($soa4l = mysqli_fetch_assoc($soaaal)) {
       $iddddddd = $soa4l['id'];
       $hasil = mysqli_query($connectdb, "SELECT * FROM hasil WHERE id_siswa='$iddd' AND id_guru='$guru' AND id_soal='$iddddddd'");
       while ($hasill = mysqli_fetch_assoc($hasil)) {
         if (isset($hasill['hasil'])) {
           echo "<td>" . $hasill['hasil'] . "</td>";
         } else {
           echo "<td>-</td>";
         }
       }
     }
   }

    ?>
   <tr>
   </tr>
 </table>
