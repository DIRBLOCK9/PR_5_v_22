<?php
require "db.php";
$id = (int)($_GET["id"] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM passengers WHERE id=?");
$stmt->execute([$id]);
$p = $stmt->fetch();
if (!$p) die("Не знайдено");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $amount = (float)($_POST["trip_amount"] ?? 0);
  $rate   = (float)($_POST["rate_percent"] ?? 5);
  $note   = trim($_POST["note"] ?? "");

  if ($amount > 0 && $rate > 0) {
    $bonus = (int)floor($amount * ($rate / 100.0));

    $pdo->beginTransaction();

    $ins = $pdo->prepare(
      "INSERT INTO accruals(passenger_id, trip_amount, rate_percent, bonus_earned, note)
       VALUES(?,?,?,?,?)"
    );
    $ins->execute([$id, $amount, $rate, $bonus, $note]);

    $upd = $pdo->prepare("UPDATE passengers SET bonus_balance = bonus_balance + ? WHERE id=?");
    $upd->execute([$bonus, $id]);

    $pdo->commit();

    header("Location: history.php?id=".$id);
    exit;
  }
}
?>
<!doctype html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Нарахування бонусів</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
  <div class="card card-pad">

    <div class="header">
      <div class="title">
        <h1>Нарахувати бонуси</h1>
        <p><?= htmlspecialchars($p["full_name"]) ?></p>
      </div>
    </div>

    <hr class="sep">

    <form method="post" class="form">

      <div class="field">
        <label>Сума поїздки (грн)</label>
        <input type="number" step="0.01" name="trip_amount" required placeholder="Напр.: 350.00">
      </div>

      <div class="field">
        <label>Відсоток бонусів (%)</label>
        <input type="number" step="0.01" name="rate_percent" value="5" required>
      </div>

      <div class="field">
        <label>Примітка</label>
        <input name="note" placeholder="Необовʼязково">
      </div>

      <div class="actions">
        <button type="submit" class="btn btn-primary">
          Нарахувати
        </button>
        <a href="history.php?id=<?= $id ?>" class="btn">
          Назад
        </a>
      </div>

    </form>

  </div>
</div>

</body>
</html>

