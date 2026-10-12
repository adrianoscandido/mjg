<?php
declare(strict_types=1);

// Configurações do Banco de Dados MySQL MJG
define('DB_HOST', 'localhost');
define('DB_NAME', 'u683004893_mjg');
define('DB_USER', 'u683004893_mjg');
define('DB_PASS', '@193945+Lara@');

function getDb(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            initDatabase($pdo);
        } catch (PDOException $e) {
            http_response_code(500);
            die(json_encode(['error' => 'Falha na conexão com o banco de dados: ' . $e->getMessage()]));
        }
    }
    return $pdo;
}

function initDatabase(PDO $pdo): void {
    // 1. Tabela de usuários para login
    $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        usuario VARCHAR(100) NOT NULL UNIQUE,
        email VARCHAR(150) NOT NULL UNIQUE,
        senha_hash VARCHAR(255) NOT NULL,
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

    // 2. Tabela de orçamentos e serviços
    $pdo->exec("CREATE TABLE IF NOT EXISTS pedidos_orcamento (
        id INT AUTO_INCREMENT PRIMARY KEY,
        cliente_nome VARCHAR(150) NOT NULL,
        cliente_telefone VARCHAR(50) DEFAULT NULL,
        marca VARCHAR(50) NOT NULL,
        modelo VARCHAR(100) NOT NULL,
        servico VARCHAR(100) NOT NULL,
        problema TEXT DEFAULT NULL,
        status VARCHAR(30) DEFAULT 'Pendente',
        valor_estimado DECIMAL(10,2) DEFAULT NULL,
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

    // 3. Tabela de estoque de celulares à venda
    $pdo->exec("CREATE TABLE IF NOT EXISTS aparelhos_estoque (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        marca VARCHAR(50) NOT NULL,
        condicao VARCHAR(30) NOT NULL DEFAULT 'Seminovo',
        armazenamento VARCHAR(50) NOT NULL DEFAULT '128 GB',
        preco DECIMAL(10,2) NOT NULL,
        status VARCHAR(30) DEFAULT 'Disponível',
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

    // 4. Inserir usuários administradores padrão se não existirem
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario = :u OR email = :e");
    $stmt->execute([':u' => 'sandro', ':e' => 'admin@mjgimports.com.br']);
    if ((int)$stmt->fetchColumn() === 0) {
        $hash = password_hash('grazi2027', PASSWORD_BCRYPT);
        $ins = $pdo->prepare("INSERT INTO usuarios (nome, usuario, email, senha_hash) VALUES (:nome, :u, :e, :h)");
        $ins->execute([
            ':nome' => 'Sandro',
            ':u'    => 'sandro',
            ':e'    => 'admin@mjgimports.com.br',
            ':h'    => $hash
        ]);
    }

    $stmtAdr = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE usuario = :u OR email = :e");
    $stmtAdr->execute([':u' => 'adriano', ':e' => 'adriano@mjgimports.com.br']);
    if ((int)$stmtAdr->fetchColumn() === 0) {
        $hashAdr = password_hash('May@2027', PASSWORD_BCRYPT);
        $insAdr = $pdo->prepare("INSERT INTO usuarios (nome, usuario, email, senha_hash) VALUES (:nome, :u, :e, :h)");
        $insAdr->execute([
            ':nome' => 'Adriano',
            ':u'    => 'adriano',
            ':e'    => 'adriano@mjgimports.com.br',
            ':h'    => $hashAdr
        ]);
    }

    // 5. Popular estoque padrão se estiver vazio
    $stmtEstoque = $pdo->query("SELECT COUNT(*) FROM aparelhos_estoque");
    if ((int)$stmtEstoque->fetchColumn() === 0) {
        $sample = [
            ['iPhone 13', 'Apple', 'Seminovo', '128 GB', 2799.00],
            ['iPhone 15', 'Apple', 'Novo', '128 GB', 4999.00],
            ['Galaxy A55', 'Samsung', 'Novo', '256 GB', 2199.00],
            ['Galaxy S23', 'Samsung', 'Seminovo', '256 GB', 2899.00],
            ['Moto G84', 'Motorola', 'Novo', '256 GB', 1399.00],
            ['Redmi Note 13', 'Xiaomi', 'Novo', '256 GB', 1499.00],
            ['Moto Edge 40', 'Motorola', 'Seminovo', '256 GB', 1799.00],
            ['Poco X6', 'Xiaomi', 'Seminovo', '256 GB', 1599.00],
        ];
        $insP = $pdo->prepare("INSERT INTO aparelhos_estoque (nome, marca, condicao, armazenamento, preco) VALUES (?, ?, ?, ?, ?)");
        foreach ($sample as $p) {
            $insP->execute($p);
        }
    }

    // 6. Tabela de serviços prestados (CRUD)
    $pdo->exec("CREATE TABLE IF NOT EXISTS servicos_prestados (
        id INT AUTO_INCREMENT PRIMARY KEY,
        titulo VARCHAR(100) NOT NULL,
        descricao TEXT NOT NULL,
        icone VARCHAR(50) NOT NULL DEFAULT '📱',
        ordem INT DEFAULT 0,
        ativo TINYINT(1) DEFAULT 1,
        criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

    // Popular serviços padrão se a tabela estiver vazia
    $stmtServicos = $pdo->query("SELECT COUNT(*) FROM servicos_prestados");
    if ((int)$stmtServicos->fetchColumn() === 0) {
        $sampleServicos = [
            ['Troca de tela', 'Tela trincada, manchada ou sem toque? Trocamos com peças de qualidade e garantia.', '📱', 1],
            ['Troca de bateria', 'Celular descarregando rápido ou desligando sozinho? Bateria nova com alta durabilidade.', '🔋', 2],
            ['Troca de conector', 'Não carrega ou só carrega em uma posição? Trocamos o conector de carga.', '🔌', 3],
            ['Reparo na placa', 'Celular não liga, molhou ou sofreu queda? Diagnóstico avançado e reparo de placa.', '🛠️', 4],
            ['Desbloqueios', 'Desbloqueio de aparelhos com segurança, agilidade e total sigilo.', '🔓', 5],
            ['Manutenção geral', 'Alto-falante, microfone, câmera, botões e limpeza interna detalhada.', '⚙️', 6],
            ['Cabos e carregadores', 'Cabos reforçados, carregadores rápidos, fontes e películas para todas as marcas.', '🔌', 7],
        ];
        $insS = $pdo->prepare("INSERT INTO servicos_prestados (titulo, descricao, icone, ordem, ativo) VALUES (?, ?, ?, ?, 1)");
        foreach ($sampleServicos as $s) {
            $insS->execute($s);
        }
    }
}
