<?php
include "db.php";

// Üyeleri çek
$uyeler = $conn->query("SELECT uye_id, ad, soyad FROM uyeler WHERE durum='aktif' ORDER BY ad");

// Oturumları çek (kapasite > 0 olanlar)
$oturumlar = $conn->query("
  SELECT 
    o.oturum_id,
    d.ad AS ders,
    o.baslangic,
    o.kapasite,
    COUNT(r.rezervasyon_id) AS kayit_sayisi,
    (o.kapasite - COUNT(r.rezervasyon_id)) AS kalan
  FROM ders_oturumlari o
  JOIN dersler d ON o.ders_id = d.ders_id
  LEFT JOIN rezervasyonlar r ON o.oturum_id = r.oturum_id
  GROUP BY o.oturum_id, d.ad, o.baslangic, o.kapasite
  HAVING kalan > 0
  ORDER BY o.baslangic
");

$mesaj = "";

// Form gönderildiyse
if(isset($_POST["kaydet"])){
  $uye_id    = (int)$_POST["uye_id"];
  $oturum_id = (int)$_POST["oturum_id"];

  // Kapasite kontrolü
  $kontrol = $conn->query("
    SELECT kapasite - COUNT(r.rezervasyon_id) AS kalan
    FROM ders_oturumlari o
    LEFT JOIN rezervasyonlar r ON o.oturum_id = r.oturum_id
    WHERE o.oturum_id = $oturum_id
    GROUP BY o.oturum_id
  ");
  $row = $kontrol->fetch_assoc();

  if($row["kalan"] <= 0){
    $mesaj = "Bu ders oturumu dolu!";
  } else {
    // Aynı üye aynı oturuma tekrar yazılmasın
    $stmt = $conn->prepare("
      INSERT INTO rezervasyonlar (uye_id, oturum_id)
      VALUES (?,?)
    ");
    $stmt->bind_param("ii", $uye_id, $oturum_id);

    if($stmt->execute()){
      header("Location: ders_oturumlari.php");
      exit;
    } else {
      $mesaj = "Bu üye zaten bu oturuma kayıtlı olabilir.";
    }
  }
}
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <title>Rezervasyon Yap</title>
</head>
<body>

<h2>Rezervasyon Yap</h2>
<a href="index.php">Ana Menü</a> | <a href="ders_oturumlari.php">Oturumlara Dön</a>
<br><br>

<?php if($mesaj!="") echo "<p style='color:red;'>$mesaj</p>"; ?>

<form method="post">

  <label>Üye:</label><br>
  <select name="uye_id" required>
    <option value="">Üye Seçiniz</option>
    <?php
    while($u = $uyeler->fetch_assoc()){
      echo "<option value='{$u['uye_id']}'>{$u['ad']} {$u['soyad']}</option>";
    }
    ?>
  </select>
  <br><br>

  <label>Ders Oturumu:</label><br>
  <select name="oturum_id" required>
    <option value="">Oturum Seçiniz</option>
    <?php
    while($o = $oturumlar->fetch_assoc()){
      echo "<option value='{$o['oturum_id']}'>
        {$o['ders']} | {$o['baslangic']} | Kalan: {$o['kalan']}
      </option>";
    }
    ?>
  </select>
  <br><br>

  <button type="submit" name="kaydet">Rezervasyon Yap</button>
</form>

</body>
</html>
