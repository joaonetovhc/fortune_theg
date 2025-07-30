<?php
// backend/spin.php

header('Content-Type: application/json');

require_once 'db.php';

// Simulando usuário logado (id = 1)
$user_id = 1;

// Consulta saldo atual
$stmt = $pdo->prepare("SELECT balance FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$saldo = $stmt->fetch();

if($saldo['balance'] <= 0){
    echo json_encode(["erro" => "Adicione mais saldo para jogar."]);
    exit;
}

$balance = $saldo['balance'];
$bet = 0.50; // Valor fixo por giro

if ($balance < $bet) {
    echo json_encode(["error" => "Saldo insuficiente"]);
    exit;
}

// Atualiza saldo com a aposta
$pdo->prepare("UPDATE users SET balance = balance - ? WHERE id = ?")
    ->execute([$bet, $user_id]);

// Lógica do slot (ícones de 0 a 2)
$reels = [rand(0,5), rand(0,5), rand(0,5)];
$win = 0.00;

// Se os 3 forem iguais, ganha pelo multiplicador
$multi = 4.5;
if ($reels[0] === $reels[1] && $reels[1] === $reels[2]) {
    $win = $bet * $multi;
    $pdo->prepare("UPDATE users SET balance = balance + ? WHERE id = ?")
    ->execute([$win, $user_id]);
}

// Atualiza saldo final
$stmt = $pdo->prepare("SELECT balance FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$newBalance = $stmt->fetchColumn();

// Registra a jogada
$pdo->prepare("INSERT INTO spins (user_id, result, win_amount) VALUES (?, ?, ?)")
    ->execute([$user_id, json_encode($reels), $win]);

// Retorna JSON
echo json_encode([
    "result" => $reels,
    "win" => $win,
    "balance" => $newBalance
]);
