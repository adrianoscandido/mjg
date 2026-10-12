<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__DIR__) . '/api/db.php';

function isLoggedIn(): bool {
    return !empty($_SESSION['mjg_admin_user']);
}

function getLoggedUser(): ?array {
    return $_SESSION['mjg_admin_user'] ?? null;
}

function requireAuth(): void {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

function loginUser(string $login, string $senha): array {
    $pdo = getDb();
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :login OR email = :login LIMIT 1");
    $stmt->execute([':login' => $login]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($senha, $user['senha_hash'])) {
        return ['ok' => false, 'error' => 'Usuário/E-mail ou senha incorretos.'];
    }

    $_SESSION['mjg_admin_user'] = [
        'id'      => $user['id'],
        'nome'    => $user['nome'],
        'usuario' => $user['usuario'],
        'email'   => $user['email'],
    ];

    return ['ok' => true];
}

function logoutUser(): void {
    $_SESSION['mjg_admin_user'] = null;
    unset($_SESSION['mjg_admin_user']);
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }
}
