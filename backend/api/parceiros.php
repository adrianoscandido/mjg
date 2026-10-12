<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

require_once __DIR__ . '/db.php';

try {
    $pdo = getDb();
    $stmt = $pdo->query("SELECT id, nome, logo, whatsapp, site, servicos, descricao, ordem, ativo FROM parceiros WHERE ativo = 1 ORDER BY ordem ASC, id ASC");
    $parceiros = $stmt->fetchAll();
    echo json_encode(['ok' => true, 'dados' => $parceiros], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
