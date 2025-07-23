<?php
// backend/spin.php

header('Content-Type: application/json');

require_once 'db.php';

// Simulando usuário logado (id = 1)
$user_id = 1;

// Consulta saldo atual
$stmt = $pdo->prepare("SELECT balance FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    echo json_encode(["error" => "Usuário não encontrado"]);
    exit;
}

$balance = $user['balance'];
$bet = 1.00; // Valor fixo por giro

if ($balance < $bet) {
    echo json_encode(["error" => "Saldo insuficiente"]);
    exit;
}

// Atualiza saldo com a aposta
$pdo->prepare("UPDATE users SET balance = balance - ? WHERE id = ?")
    ->execute([$bet, $user_id]);

// Lógica do slot (ícones de 0 a 2)
$reels = [rand(0,2), rand(0,2), rand(0,2)];
$win = 0.00;

// Se os 3 forem iguais, ganha 5x a aposta
if ($reels[0] === $reels[1] && $reels[1] === $reels[2]) {
    $win = $bet * 5;
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
