<?php
require "db.php";
$id = (int)($_GET["id"] ?? 0);

$p = $pdo->prepare("SELECT * FROM passengers WHERE id=?");
$p->execute([$id]);
$passenger = $p->fetch();
if (!$passenger) die("Не знайдено");

$stmt = $pdo->prepare("SELECT * FROM accruals WHERE passenger_id=? ORDER BY id DESC");
$stmt->execute([$id]);
$items = $stmt->fetchAll();
?>
<!doctype html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Історія нарахувань</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
  <div class="card card-pad">

    <div class="header">
      <div class="title">
        <h1>Історія нарахувань</h1>
        <p><?= htmlspecialchars($passenger["full_name"]) ?></p>
      </div>
      <span class="badge">ID #<?= $id ?></span>
    </div>

    <hr class="sep">

    <p class="info">
      <b>Баланс бонусів:</b>
      <span style="color:#2563eb;font-weight:600">
        <?= (int)$passenger["bonus_balance"] ?>
      </span>
    </p>

    <div class="actions" style="margin-bottom:20px">
      <a href="add_accrual.php?id=<?= $id ?>" class="btn btn-primary">
        + Нарахувати
      </a>
      <a href="index.php" class="btn">
        Назад
      </a>
    </div>

    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Дата</th>
            <th>Сума поїздки</th>
            <th>%</th>
            <th>Бонуси</th>
            <th>Примітка</th>
          </tr>
        </thead>
        <tbody>
        <?php if (!$items): ?>
          <tr>
            <td colspan="5" style="text-align:center;color:#6b7280">
              Історія порожня
            </td>
          </tr>
        <?php endif; ?>

        <?php foreach ($items as $it): ?>
          <tr>
            <td><?= htmlspecialchars($it["created_at"]) ?></td>
            <td><?= htmlspecialchars($it["trip_amount"]) ?></td>
            <td><?= htmlspecialchars($it["rate_percent"]) ?>%</td>
            <td><b><?= (int)$it["bonus_earned"] ?></b></td>
            <td><?= htmlspecialchars($it["note"] ?? "") ?></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  </div>
</div>

</body>
</html>

