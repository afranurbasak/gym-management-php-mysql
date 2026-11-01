<?php
include "db.php";

// Paketleri çek (dropdown)
$paketler = $conn->query("SELECT paket_id, ad FROM uyelik_paketleri WHERE aktif=1 ORDER BY paket_id");

// Form gönderildiyse kaydet
$mesaj = "";
if(isset($_POST["kaydet"])){

  $ad     = trim($_POST["ad"]);
  $soyad  = trim($_POST["soyad"]);
  $telefon= trim($_POST["telefon"]);
  $email  = trim($_POST["email"]);
  $paket  = $_POST["paket_id"] !== "" ? (int)$_POST["paket_id"] : null;

  if($ad=="" || $soyad==""){
    $mesaj = "Ad ve Soyad zorunlu!";
  } else {

    // Prepared statement (güvenli)
    $stmt = $conn->prepare("INSERT INTO uyeler (ad, soyad, telefon, email, paket_id) VALUES (?,?,?,?,?)");
    $stmt->bind_param("ssssi", $ad, $soyad, $telefon, $email, $paket);

    if($stmt->execute()){
      header("Location: uyeler.php");
      exit;
    } else {
      $mesaj = "Kayıt hatası: " . $conn->error;
    }
  }
}
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <title>Üye Ekle</title>
</head>
<body>

<h2>Üye Ekle</h2>
<a href="uyeler.php">← Üyelere Dön</a> | <a href="index.php">Ana Menü</a>
<br><br>

<?php if($mesaj!="") echo "<p style='color:red;'>$mesaj</p>"; ?>

<form method="post">
  <label>Ad:</label><br>
  <input type="text" name="ad"><br><br>

  <label>Soyad:</label><br>
  <input type="text" name="soyad"><br><br>

  <label>Telefon:</label><br>
  <input type="text" name="telefon"><br><br>

  <label>Email:</label><br>
  <input type="email" name="email"><br><br>

  <label>Üyelik Paketi:</label><br>
  <select name="paket_id">
    <option value="">Seçiniz</option>
    <?php
    if($paketler){
      while($p = $paketler->fetch_assoc()){
        echo "<option value='{$p['paket_id']}'>{$p['ad']}</option>";
      }
    }
    ?>
  </select>
  <br><br>

  <button type="submit" name="kaydet">Kaydet</button>
</form>

</body>
</html>
