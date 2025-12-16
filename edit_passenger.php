<?php
require "db.php";
$id = (int)($_GET["id"] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM passengers WHERE id=?");
$stmt->execute([$id]);
$p = $stmt->fetch();
if (!$p) die("Не знайдено");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $full = trim($_POST["full_name"] ?? "");
  $phone = trim($_POST["phone"] ?? "");
  $card = trim($_POST["card_number"] ?? "");

  $upd = $pdo->prepare("UPDATE passengers SET full_name=?, phone=?, card_number=? WHERE id=?");
  $upd->execute([$full, $phone, $card, $id]);
  header("Location: index.php"); exit;
}
?>
<!doctype html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Редагувати пасажира</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
  <div class="card card-pad">

    <div class="header">
      <div class="title">
        <h1>Редагувати пасажира</h1>
        <p>Онови дані та збережи зміни</p>
      </div>
    </div>

    <hr class="sep">

    <form method="post" class="form">
      <div class="field">
        <label>ПІБ</label>
        <input name="full_name"
               value="<?= htmlspecialchars($p["full_name"]) ?>"
               required>
      </div>

      <div class="field">
        <label>Телефон</label>
        <input name="phone"
               value="<?= htmlspecialchars($p["phone"]) ?>"
               required>
      </div>

      <div class="field">
        <label>Номер картки</label>
        <input name="card_number"
               value="<?= htmlspecialchars($p["card_number"]) ?>"
               required>
      </div>

      <div class="actions">
        <button type="submit" class="btn btn-primary">Зберегти</button>
        <a href="index.php" class="btn">Назад</a>
      </div>
    </form>

  </div>
</div>

</body>
</html>

