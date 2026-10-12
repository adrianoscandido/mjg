<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}

require_once __DIR__ . '/db.php';

$raw = file_get_contents('php://input');
$data = json_decode($raw, true) ?? $_POST;

$nome = trim($data['nome'] ?? '');
$telefone = trim($data['telefone'] ?? '');
$marca = trim($data['marca'] ?? '');
$modelo = trim($data['modelo'] ?? '');
$servico = trim($data['servico'] ?? '');
$problema = trim($data['problema'] ?? '');

if (empty($nome) || empty($modelo)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Nome e modelo são obrigatórios.']);
    exit;
}

try {
    $pdo = getDb();
    $stmt = $pdo->prepare("INSERT INTO pedidos_orcamento (cliente_nome, cliente_telefone, marca, modelo, servico, problema, status) VALUES (?, ?, ?, ?, ?, ?, 'Pendente')");
    $stmt->execute([$nome, $telefone, $marca, $modelo, $servico, $problema]);
    $id = (int)$pdo->lastInsertId();

    echo json_encode(['ok' => true, 'id' => $id, 'mensagem' => 'Orçamento registrado com sucesso!']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
