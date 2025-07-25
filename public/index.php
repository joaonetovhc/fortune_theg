<?php
  require_once '../app/db.php';

  $user_id = 1;


  $stmt = $pdo->prepare("SELECT balance FROM users WHERE id = ?");
  $stmt->execute([$user_id]);
  $saldo = $stmt->fetch();

  echo "\nSALDO AQUI {$saldo['balance']}\n";
 

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
    <div class="header">🏍️ Fortune Theg 🏍️</div>

    <div class="reels">
      <div class="reel"><img src="../assets/img/xre190.png" alt="Reel 1" /></div>
      <div class="reel"><img src="../assets/img/bros.png" alt="Reel 2" /></div>
      <div class="reel"><img src="../assets/img/titan160.png" alt="Reel 3" /></div>
    </div>

    <div class="controls">
      <button id="spinBtn">GIRAR</button>
      <p id="result"></p>
      <span id="balance" data-balance="<?= $saldo['balance'] ?>">R$ <?= number_format($saldo['balance'], 2, ',', '.') ?></span>

    </div>
  </div>

  <script src="script.js"></script>
</body>
</html>
