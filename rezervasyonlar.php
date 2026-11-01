<?php include "db.php"; ?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <title>Rezervasyonlar</title>
</head>
<body>

<h2>Rezervasyonlar</h2>
<a href="index.php">Ana Menü</a> | <a href="rezervasyon_yap.php">+ Yeni Rezervasyon</a>
<br><br>

<table border="1" cellpadding="6">
  <tr>
    <th>Rezervasyon ID</th>
    <th>Üye</th>
    <th>Ders</th>
    <th>Başlangıç</th>
    <th>Salon</th>
    <th>Durum</th>
    <th>Kayıt Zamanı</th>
  </tr>

<?php
$sql = "
  SELECT 
    r.rezervasyon_id,
    CONCAT(u.ad, ' ', u.soyad) AS uye,
    d.ad AS ders,
    o.baslangic,
    o.salon,
    r.durum,
    r.kayit_zamani
  FROM rezervasyonlar r
  JOIN uyeler u ON r.uye_id = u.uye_id
  JOIN ders_oturumlari o ON r.oturum_id = o.oturum_id
  JOIN dersler d ON o.ders_id = d.ders_id
  ORDER BY r.rezervasyon_id DESC
";

$res = $conn->query($sql);

if($res && $res->num_rows > 0){
  while($row = $res->fetch_assoc()){
    echo "<tr>
      <td>{$row['rezervasyon_id']}</td>
      <td>{$row['uye']}</td>
      <td>{$row['ders']}</td>
      <td>{$row['baslangic']}</td>
      <td>{$row['salon']}</td>
      <td>{$row['durum']}</td>
      <td>{$row['kayit_zamani']}</td>
    </tr>";
  }
} else {
  echo "<tr><td colspan='7'>Henüz rezervasyon yok.</td></tr>";
}
?>
</table>

</body>
</html>
