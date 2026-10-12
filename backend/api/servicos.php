<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/db.php';

try {
    $pdo = getDb();
    $stmt = $pdo->query("SELECT id, titulo, descricao, icone, ordem, ativo FROM servicos_prestados WHERE ativo = 1 ORDER BY ordem ASC, id ASC");
    $servicos = $stmt->fetchAll();
    echo json_encode(['ok' => true, 'dados' => $servicos], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
