<?php
require "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $full  = trim($_POST["full_name"] ?? "");
  $phone = trim($_POST["phone"] ?? "");
  $card  = trim($_POST["card_number"] ?? "");

  if ($full && $phone && $card) {
    $stmt = $pdo->prepare("INSERT INTO passengers(full_name, phone, card_number) VALUES(?,?,?)");
    $stmt->execute([$full, $phone, $card]);
    header("Location: index.php");
    exit;
  }
}
?>
<!doctype html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Додати пасажира</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container">
    <div class="card card-pad">
      <div class="header" style="margin-bottom:0">
        <div class="title">
          <h1>Додати пасажира</h1>
          <p>Заповни дані та збережи у базу</p>
        </div>
        <span class="badge">Форма • passengers</span>
      </div>

      <hr class="sep">

      <form method="post" class="form">
        <div class="field">
          <label for="full_name">ПІБ</label>
          <input id="full_name" name="full_name" required placeholder="Напр.: Турло Костянтин Євгенійович">
        </div>

        <div class="field">
          <label for="phone">Телефон</label>
          <input id="phone" name="phone" required placeholder="Напр.: +380XXXXXXXXX">
        </div>

        <div class="field">
          <label for="card_number">Номер картки</label>
          <input id="card_number" name="card_number" required placeholder="Напр.: 250890">
        </div>

        <div class="actions">
          <button class="btn btn-primary" type="submit">Зберегти</button>
          <a class="btn" href="index.php">Назад</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
