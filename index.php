<?php
require "db.php";
$passengers = $pdo->query("SELECT * FROM passengers ORDER BY id DESC")->fetchAll();
?>
<!doctype html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Лояльність пасажирів</title>
  <meta charset="UTF-8">
  <title>Лояльність пасажирів</title>
  <link rel="stylesheet" href="style.css">

</head>
<body>
  <div class="container">

    <div class="header">
      <div class="title">
        <h1>Програма лояльності (варіант 22)</h1>
        <p>Управління пасажирами • бонуси • історія нарахувань</p>
      </div>

      <div class="actions">
        <a class="btn btn-primary" href="add_passenger.php">+ Додати пасажира</a>
        <span class="badge">PHP + MySQL</span>
      </div>
    </div>

    <div class="card">
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>ID</th><th>ПІБ</th><th>Телефон</th><th>Картка</th><th>Бонуси</th><th>Дії</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($passengers as $p): ?>
            <tr>
              <td class="money"><?= (int)$p["id"] ?></td>
              <td><?= htmlspecialchars($p["full_name"]) ?></td>
              <td><?= htmlspecialchars($p["phone"]) ?></td>
              <td class="money"><?= htmlspecialchars($p["card_number"]) ?></td>
              <td class="money bold good"><?= (int)$p["bonus_balance"] ?></td>
              <td>
                <div class="actions">
                  <a class="btn" href="add_accrual.php?id=<?= (int)$p["id"] ?>">Нарахувати</a>
                  <a class="btn" href="history.php?id=<?= (int)$p["id"] ?>">Історія</a>
                  <a class="btn" href="edit_passenger.php?id=<?= (int)$p["id"] ?>">Редагувати</a>
                  <a class="btn btn-danger" href="delete_passenger.php?id=<?= (int)$p["id"] ?>"
                     onclick="return confirm('Видалити?')">Видалити</a>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</body>

</html>
