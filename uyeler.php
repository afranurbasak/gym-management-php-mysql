<?php include "db.php"; ?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <title>Üyeler</title>
</head>
<body>

<h2>Üyeler</h2>
<a href="uye_ekle.php">+ Yeni Üye Ekle</a> | <a href="index.php">Ana Menü</a>
<br><br>

<table border="1" cellpadding="6">
  <tr>
    <th>ID</th>
    <th>Ad</th>
    <th>Soyad</th>
    <th>Telefon</th>
    <th>Email</th>
    <th>Paket</th>
    <th>Durum</th>
  </tr>

  <?php
  $sql = "
    SELECT u.uye_id, u.ad, u.soyad, u.telefon, u.email, u.durum,
           p.ad AS paket_adi
    FROM uyeler u
    LEFT JOIN uyelik_paketleri p ON u.paket_id = p.paket_id
    ORDER BY u.uye_id DESC
  ";
  $res = $conn->query($sql);

  if($res && $res->num_rows > 0){
    while($row = $res->fetch_assoc()){
      $paket = $row['paket_adi'] ? $row['paket_adi'] : '-';
      echo "<tr>
        <td>{$row['uye_id']}</td>
        <td>{$row['ad']}</td>
        <td>{$row['soyad']}</td>
        <td>{$row['telefon']}</td>
        <td>{$row['email']}</td>
        <td>{$paket}</td>
        <td>{$row['durum']}</td>
      </tr>";
    }
  } else {
    echo "<tr><td colspan='7'>Henüz üye yok.</td></tr>";
  }
  ?>
</table>

</body>
</html>
