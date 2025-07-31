<?php
require_once '../app/db.php';

$user_id = 1;

$stmt = $pdo->prepare("SELECT balance FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$saldo = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Fortune Theg</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="slot-machine">
    <div class="header">Fortune Theg</div>

    <div class="reels" id="reels">
      <?php for ($row = 0; $row < 3; $row++): ?>
        <div class="reel-row">
          <?php for ($col = 0; $col < 3; $col++): ?>
            <div class="slot-icon">
              <img/>
            </div>
          <?php endfor; ?>
        </div>
      <?php endfor; ?>
    </div>

    <div class="controls">
      <button id="spinBtn">🎰 GIRAR</button>
      <p id="result"></p>
      <span id="balance" data-balance="<?= $saldo['balance'] ?>">R$ <?= number_format($saldo['balance'], 2, ',', '.') ?></span>
    </div>
  </div>



  
  <script src="script.js"></script>
</body>
</html>
