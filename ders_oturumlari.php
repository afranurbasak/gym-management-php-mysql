<?php include "db.php"; ?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <title>Ders Oturumları</title>
</head>
<body>

<h2>Ders Oturumları</h2>
<a href="index.php">Ana Menü</a>
<br><br>

<table border="1" cellpadding="6">
  <tr>
    <th>Oturum ID</th>
    <th>Ders</th>
    <th>Seviye</th>
    <th>Eğitmen</th>
    <th>Başlangıç</th>
    <th>Salon</th>
    <th>Kapasite</th>
    <th>Kayıt Sayısı</th>
    <th>Kalan</th>
  </tr>

<?php
$sql = "
  SELECT 
    o.oturum_id,
    d.ad AS ders_adi,
    d.seviye,
    e.ad_soyad AS egitmen,
    o.baslangic,
    o.salon,
    o.kapasite,
    COUNT(r.rezervasyon_id) AS kayit_sayisi,
    (o.kapasite - COUNT(r.rezervasyon_id)) AS kalan
  FROM ders_oturumlari o
  JOIN dersler d ON o.ders_id = d.ders_id
  LEFT JOIN egitmenler e ON d.egitmen_id = e.egitmen_id
  LEFT JOIN rezervasyonlar r ON o.oturum_id = r.oturum_id
  GROUP BY o.oturum_id, d.ad, d.seviye, e.ad_soyad, o.baslangic, o.salon, o.kapasite
  ORDER BY o.baslangic ASC
";

$res = $conn->query($sql);

if($res && $res->num_rows > 0){
  while($row = $res->fetch_assoc()){
    echo "<tr>
      <td>{$row['oturum_id']}</td>
      <td>{$row['ders_adi']}</td>
      <td>{$row['seviye']}</td>
      <td>".($row['egitmen'] ?? '-')."</td>
      <td>{$row['baslangic']}</td>
      <td>{$row['salon']}</td>
      <td>{$row['kapasite']}</td>
      <td>{$row['kayit_sayisi']}</td>
      <td>{$row['kalan']}</td>
    </tr>";
  }
} else {
  echo "<tr><td colspan='9'>Henüz oturum yok.</td></tr>";
}
?>
</table>

</body>
</html>
