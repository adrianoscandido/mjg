<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';
requireAuth();

$user = getLoggedUser();
$pdo = getDb();
$msg = '';
$msgType = 'success';

// Tratamento de ações POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'novo_celular') {
        $nome = trim($_POST['nome'] ?? '');
        $marca = trim($_POST['marca'] ?? '');
        $condicao = trim($_POST['condicao'] ?? 'Seminovo');
        $armazenamento = trim($_POST['armazenamento'] ?? '128 GB');
        $preco = (float)str_replace(['.', ','], ['', '.'], $_POST['preco'] ?? '0');

        if (!empty($nome) && !empty($marca) && $preco > 0) {
            $stmt = $pdo->prepare("INSERT INTO aparelhos_estoque (nome, marca, condicao, armazenamento, preco, status) VALUES (?, ?, ?, ?, ?, 'Disponível')");
            $stmt->execute([$nome, $marca, $condicao, $armazenamento, $preco]);
            $msg = 'Aparelho adicionado com sucesso ao estoque!';
        } else {
            $msg = 'Preencha todos os campos do aparelho corretamente.';
            $msgType = 'error';
        }
    } elseif ($action === 'excluir_celular') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("DELETE FROM aparelhos_estoque WHERE id = ?");
            $stmt->execute([$id]);
            $msg = 'Aparelho removido do estoque.';
        }
    } elseif ($action === 'toggle_status_celular') {
        $id = (int)($_POST['id'] ?? 0);
        $novoStatus = $_POST['status'] ?? 'Disponível';
        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE aparelhos_estoque SET status = ? WHERE id = ?");
            $stmt->execute([$novoStatus, $id]);
            $msg = 'Status do aparelho atualizado!';
        }
    } elseif ($action === 'novo_orcamento') {
        $nome = trim($_POST['cliente_nome'] ?? '');
        $telefone = trim($_POST['cliente_telefone'] ?? '');
        $marca = trim($_POST['marca'] ?? '');
        $modelo = trim($_POST['modelo'] ?? '');
        $servico = trim($_POST['servico'] ?? '');
        $problema = trim($_POST['problema'] ?? '');

        if (!empty($nome) && !empty($modelo)) {
            $stmt = $pdo->prepare("INSERT INTO pedidos_orcamento (cliente_nome, cliente_telefone, marca, modelo, servico, problema, status) VALUES (?, ?, ?, ?, ?, ?, 'Pendente')");
            $stmt->execute([$nome, $telefone, $marca, $modelo, $servico, $problema]);
            $msg = 'Ordem de orçamento registrada!';
        }
    } elseif ($action === 'atualizar_status_orcamento') {
        $id = (int)($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? 'Pendente';
        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE pedidos_orcamento SET status = ? WHERE id = ?");
            $stmt->execute([$status, $id]);
            $msg = 'Status do orçamento atualizado com sucesso.';
        }
    } elseif ($action === 'alterar_senha') {
        $novaSenha = trim($_POST['nova_senha'] ?? '');
        if (strlen($novaSenha) >= 6) {
            $hash = password_hash($novaSenha, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("UPDATE usuarios SET senha_hash = ? WHERE id = ?");
            $stmt->execute([$hash, $user['id']]);
            $msg = 'Senha alterada com sucesso!';
        } else {
            $msg = 'A nova senha deve ter no mínimo 6 caracteres.';
            $msgType = 'error';
        }
    } elseif ($action === 'novo_servico') {
        $titulo = trim($_POST['titulo'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $icone = trim($_POST['icone'] ?? '📱');
        $ordem = (int)($_POST['ordem'] ?? 0);

        if (!empty($titulo) && !empty($descricao)) {
            $stmt = $pdo->prepare("INSERT INTO servicos_prestados (titulo, descricao, icone, ordem, ativo) VALUES (?, ?, ?, ?, 1)");
            $stmt->execute([$titulo, $descricao, $icone, $ordem]);
            $msg = 'Serviço cadastrado com sucesso!';
        } else {
            $msg = 'Preencha o título e a descrição do serviço.';
            $msgType = 'error';
        }
    } elseif ($action === 'editar_servico') {
        $id = (int)($_POST['id'] ?? 0);
        $titulo = trim($_POST['titulo'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $icone = trim($_POST['icone'] ?? '📱');
        $ordem = (int)($_POST['ordem'] ?? 0);

        if ($id > 0 && !empty($titulo) && !empty($descricao)) {
            $stmt = $pdo->prepare("UPDATE servicos_prestados SET titulo = ?, descricao = ?, icone = ?, ordem = ? WHERE id = ?");
            $stmt->execute([$titulo, $descricao, $icone, $ordem, $id]);
            $msg = 'Serviço atualizado com sucesso!';
        } else {
            $msg = 'Preencha todos os campos do serviço.';
            $msgType = 'error';
        }
    } elseif ($action === 'toggle_status_servico') {
        $id = (int)($_POST['id'] ?? 0);
        $novoStatus = (int)($_POST['ativo'] ?? 1);
        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE servicos_prestados SET ativo = ? WHERE id = ?");
            $stmt->execute([$novoStatus, $id]);
            $msg = 'Status do serviço atualizado!';
        }
    } elseif ($action === 'excluir_servico') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("DELETE FROM servicos_prestados WHERE id = ?");
            $stmt->execute([$id]);
            $msg = 'Serviço removido com sucesso!';
        }
    } elseif ($action === 'novo_parceiro') {
        $nome = trim($_POST['nome'] ?? '');
        $logo = trim($_POST['logo'] ?? '🤝');
        $whatsapp = trim($_POST['whatsapp'] ?? '');
        $site = trim($_POST['site'] ?? '');
        $servicosTxt = trim($_POST['servicos'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $ordem = (int)($_POST['ordem'] ?? 0);

        if (!empty($nome) && !empty($servicosTxt)) {
            $stmt = $pdo->prepare("INSERT INTO parceiros (nome, logo, whatsapp, site, servicos, descricao, ordem, ativo) VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
            $stmt->execute([$nome, $logo, $whatsapp, $site, $servicosTxt, $descricao, $ordem]);
            $msg = 'Parceiro cadastrado com sucesso!';
        } else {
            $msg = 'Preencha o nome e a lista de serviços do parceiro.';
            $msgType = 'error';
        }
    } elseif ($action === 'editar_parceiro') {
        $id = (int)($_POST['id'] ?? 0);
        $nome = trim($_POST['nome'] ?? '');
        $logo = trim($_POST['logo'] ?? '🤝');
        $whatsapp = trim($_POST['whatsapp'] ?? '');
        $site = trim($_POST['site'] ?? '');
        $servicosTxt = trim($_POST['servicos'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $ordem = (int)($_POST['ordem'] ?? 0);

        if ($id > 0 && !empty($nome) && !empty($servicosTxt)) {
            $stmt = $pdo->prepare("UPDATE parceiros SET nome = ?, logo = ?, whatsapp = ?, site = ?, servicos = ?, descricao = ?, ordem = ? WHERE id = ?");
            $stmt->execute([$nome, $logo, $whatsapp, $site, $servicosTxt, $descricao, $ordem, $id]);
            $msg = 'Parceiro atualizado com sucesso!';
        } else {
            $msg = 'Preencha os campos obrigatórios do parceiro.';
            $msgType = 'error';
        }
    } elseif ($action === 'toggle_status_parceiro') {
        $id = (int)($_POST['id'] ?? 0);
        $novoStatus = (int)($_POST['ativo'] ?? 1);
        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE parceiros SET ativo = ? WHERE id = ?");
            $stmt->execute([$novoStatus, $id]);
            $msg = 'Status do parceiro atualizado!';
        }
    } elseif ($action === 'excluir_parceiro') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("DELETE FROM parceiros WHERE id = ?");
            $stmt->execute([$id]);
            $msg = 'Parceiro removido com sucesso!';
        }
    }
}

// Consultas
$celulares = $pdo->query("SELECT * FROM aparelhos_estoque ORDER BY id DESC")->fetchAll();
$orcamentos = $pdo->query("SELECT * FROM pedidos_orcamento ORDER BY id DESC")->fetchAll();
$servicos = $pdo->query("SELECT * FROM servicos_prestados ORDER BY ordem ASC, id ASC")->fetchAll();
$parceiros = $pdo->query("SELECT * FROM parceiros ORDER BY ordem ASC, id ASC")->fetchAll();

$totalEstoque = count($celulares);
$disponiveis = count(array_filter($celulares, fn($c) => $c['status'] === 'Disponível'));
$totalOrcamentos = count($orcamentos);
$pendentes = count(array_filter($orcamentos, fn($o) => $o['status'] === 'Pendente'));
$totalServicos = count($servicos);
$servicosAtivos = count(array_filter($servicos, fn($s) => (int)$s['ativo'] === 1));
$totalParceiros = count($parceiros);
$parceirosAtivos = count(array_filter($parceiros, fn($p) => (int)$p['ativo'] === 1));

$activeTab = 'estoque';
if (isset($_POST['action'])) {
    if (strpos($_POST['action'], 'servico') !== false) {
        $activeTab = 'servicos';
    } elseif (strpos($_POST['action'], 'parceiro') !== false) {
        $activeTab = 'parceiros';
    } elseif (strpos($_POST['action'], 'orcamento') !== false) {
        $activeTab = 'orcamentos';
    } elseif (strpos($_POST['action'], 'senha') !== false) {
        $activeTab = 'sistema';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel MJG Assistech & Imports</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;600;700;800&family=Bebas+Neue&display=swap" rel="stylesheet">
  <link rel="icon" type="image/svg+xml" href="/favicon.svg">
  <link rel="alternate icon" href="/favicon.ico" type="image/x-icon">
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <style>
    :root {
      --bg: #090d16;
      --card-bg: #111827;
      --card-border: rgba(255, 255, 255, 0.08);
      --primary: #38bdf8;
      --primary-hover: #0284c7;
      --text: #f1f5f9;
      --text-muted: #94a3b8;
      --accent: #f59e0b;
      --success: #10b981;
      --danger: #ef4444;
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Archivo', sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    header {
      background: #0f172a;
      border-bottom: 1px solid var(--card-border);
      position: sticky;
      top: 0;
      z-index: 50;
    }
    .header-inner {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0.85rem 1.25rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .logo-badge {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      text-decoration: none;
    }
    .logo-badge h1 {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 2rem;
      color: var(--primary);
      line-height: 1;
    }
    .logo-badge span {
      font-size: 0.75rem;
      color: var(--text-muted);
      text-transform: uppercase;
      font-weight: 700;
      letter-spacing: 1px;
    }
    .user-actions {
      display: flex;
      align-items: center;
      gap: 1rem;
    }
    .user-pill {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.85rem;
      color: var(--text-muted);
      background: rgba(255, 255, 255, 0.05);
      padding: 0.35rem 0.85rem;
      border-radius: 9999px;
      border: 1px solid var(--card-border);
    }
    .user-pill strong { color: var(--text); }
    .btn-site {
      color: var(--primary);
      text-decoration: none;
      font-size: 0.85rem;
      font-weight: 700;
      padding: 0.35rem 0.75rem;
      border-radius: 0.5rem;
      border: 1px solid rgba(56, 189, 248, 0.3);
      transition: all 0.2s;
    }
    .btn-site:hover {
      background: rgba(56, 189, 248, 0.1);
    }
    .btn-logout {
      color: #fca5a5;
      text-decoration: none;
      font-size: 0.85rem;
      font-weight: 700;
      padding: 0.35rem 0.75rem;
      border-radius: 0.5rem;
      border: 1px solid rgba(239, 68, 68, 0.3);
      transition: all 0.2s;
    }
    .btn-logout:hover {
      background: rgba(239, 68, 68, 0.15);
    }
    main {
      flex: 1;
      max-width: 1200px;
      width: 100%;
      margin: 0 auto;
      padding: 2rem 1.25rem;
    }
    .alert {
      padding: 1rem 1.25rem;
      border-radius: 0.75rem;
      margin-bottom: 1.5rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .alert.success {
      background: rgba(16, 185, 129, 0.15);
      border: 1px solid rgba(16, 185, 129, 0.3);
      color: #6ee7b7;
    }
    .alert.error {
      background: rgba(239, 68, 68, 0.15);
      border: 1px solid rgba(239, 68, 68, 0.3);
      color: #fca5a5;
    }
    .kpis {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 1rem;
      margin-bottom: 2rem;
    }
    .kpi-card {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 1rem;
      padding: 1.25rem;
      position: relative;
      overflow: hidden;
    }
    .kpi-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 3px;
      background: linear-gradient(90deg, var(--primary), transparent);
    }
    .kpi-title {
      font-size: 0.8rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--text-muted);
    }
    .kpi-value {
      font-size: 2.25rem;
      font-weight: 800;
      color: var(--text);
      margin-top: 0.35rem;
    }
    .tabs {
      display: flex;
      gap: 0.5rem;
      border-bottom: 1px solid var(--card-border);
      margin-bottom: 1.5rem;
    }
    .tab-btn {
      background: none;
      border: none;
      color: var(--text-muted);
      font-size: 0.95rem;
      font-weight: 700;
      padding: 0.75rem 1.25rem;
      cursor: pointer;
      border-bottom: 2px solid transparent;
      transition: all 0.2s;
    }
    .tab-btn:hover { color: var(--text); }
    .tab-btn.active {
      color: var(--primary);
      border-bottom-color: var(--primary);
    }
    .tab-content { display: none; }
    .tab-content.active { display: block; }
    .section-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 1.25rem;
      flex-wrap: wrap;
      gap: 1rem;
    }
    .section-title {
      font-size: 1.35rem;
      font-weight: 800;
    }
    .btn-add {
      background: var(--primary-hover);
      color: #fff;
      border: none;
      padding: 0.6rem 1.2rem;
      border-radius: 0.5rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.2s;
    }
    .btn-add:hover { background: var(--primary); }
    .data-table-container {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 1rem;
      overflow-x: auto;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      text-align: left;
    }
    th, td {
      padding: 1rem 1.25rem;
      border-bottom: 1px solid var(--card-border);
      font-size: 0.9rem;
    }
    th {
      background: rgba(255, 255, 255, 0.02);
      color: var(--text-muted);
      font-weight: 700;
      text-transform: uppercase;
      font-size: 0.75rem;
      letter-spacing: 0.5px;
    }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: rgba(255, 255, 255, 0.015); }
    .badge {
      display: inline-block;
      padding: 0.25rem 0.6rem;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 700;
    }
    .badge.novo { background: rgba(56, 189, 248, 0.15); color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.3); }
    .badge.seminovo { background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.3); }
    .badge.disponivel { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
    .badge.vendido { background: rgba(148, 163, 184, 0.15); color: #94a3b8; border: 1px solid rgba(148, 163, 184, 0.3); }
    .badge.pendente { background: rgba(239, 68, 68, 0.15); color: #f87171; border: 1px solid rgba(239, 68, 68, 0.3); }
    .badge.pronto { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
    .badge.reparo { background: rgba(245, 158, 11, 0.15); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.3); }
    .actions-cell {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    .btn-action {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid var(--card-border);
      color: var(--text);
      padding: 0.35rem 0.65rem;
      border-radius: 0.4rem;
      font-size: 0.8rem;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.2s;
    }
    .btn-action:hover { background: rgba(255, 255, 255, 0.1); }
    .btn-action.wa {
      background: rgba(16, 185, 129, 0.2);
      border-color: rgba(16, 185, 129, 0.4);
      color: #34d399;
    }
    .btn-action.wa:hover { background: rgba(16, 185, 129, 0.3); }
    .btn-action.del {
      background: rgba(239, 68, 68, 0.15);
      border-color: rgba(239, 68, 68, 0.3);
      color: #f87171;
    }
    .btn-action.del:hover { background: rgba(239, 68, 68, 0.25); }
    .card {
      background: var(--card-bg);
      border: 1px solid var(--card-border);
      border-radius: 1rem;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
    }
    .form-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1rem;
    }
    .form-group {
      display: flex;
      flex-direction: column;
      gap: 0.4rem;
    }
    label {
      font-size: 0.8rem;
      font-weight: 700;
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    input, select, textarea {
      background: rgba(15, 23, 42, 0.8);
      border: 1px solid rgba(148, 163, 184, 0.2);
      border-radius: 0.5rem;
      padding: 0.75rem;
      color: #fff;
      font-family: inherit;
      font-size: 0.9rem;
    }
    input:focus, select:focus, textarea:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 2px rgba(56, 189, 248, 0.2);
    }
    /* Icon Picker Styles */
    .icon-picker-box {
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
      background: rgba(15, 23, 42, 0.7);
      border: 1px solid rgba(148, 163, 184, 0.25);
      border-radius: 0.75rem;
      padding: 1rem;
    }
    .icon-picker-top {
      display: flex;
      align-items: center;
      gap: 0.85rem;
      flex-wrap: wrap;
    }
    .icon-preview {
      width: 52px;
      height: 52px;
      font-size: 2rem;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(56, 189, 248, 0.15);
      border: 2px solid var(--primary);
      border-radius: 0.75rem;
      flex-shrink: 0;
      box-shadow: 0 0 12px rgba(56, 189, 248, 0.3);
      transition: all 0.2s ease;
    }
    .icon-palette {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(46px, 1fr));
      gap: 0.45rem;
      max-height: 190px;
      overflow-y: auto;
      padding: 0.4rem;
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 0.6rem;
      background: rgba(0, 0, 0, 0.25);
    }
    .icon-opt {
      font-size: 1.5rem;
      height: 44px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(255, 255, 255, 0.04);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 0.5rem;
      cursor: pointer;
      transition: all 0.15s ease;
      user-select: none;
    }
    .icon-opt:hover {
      background: rgba(56, 189, 248, 0.2);
      border-color: var(--primary);
      transform: scale(1.15);
    }
    .icon-opt.selected {
      background: rgba(56, 189, 248, 0.35);
      border-color: var(--primary);
      box-shadow: 0 0 10px rgba(56, 189, 248, 0.5);
      transform: scale(1.08);
    }
    .icon-category-label {
      font-size: 0.75rem;
      color: var(--text-muted);
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
  </style>
</head>
<body>
  <header>
    <div class="header-inner">
      <a href="index.php" class="logo-badge">
        <h1>MJG</h1>
        <span>Painel de Controle</span>
      </a>
      <div class="user-actions">
        <a href="/" target="_blank" class="btn-site">🌐 Ver Site</a>
        <div class="user-pill">
          <span>Usuário:</span>
          <strong><?php echo htmlspecialchars($user['usuario'] ?? 'Admin'); ?></strong>
        </div>
        <a href="logout.php" class="btn-logout">Sair</a>
      </div>
    </div>
  </header>

  <main>
    <?php if (!empty($msg)): ?>
      <div class="alert <?php echo $msgType; ?>">
        <?php echo $msgType === 'success' ? '✅' : '⚠️'; ?> <?php echo htmlspecialchars($msg); ?>
      </div>
    <?php endif; ?>

    <div class="kpis">
      <div class="kpi-card">
        <div class="kpi-title">Aparelhos em Estoque</div>
        <div class="kpi-value"><?php echo $totalEstoque; ?></div>
      </div>
      <div class="kpi-card">
        <div class="kpi-title">Disponíveis para Venda</div>
        <div class="kpi-value"><?php echo $disponiveis; ?></div>
      </div>
      <div class="kpi-card">
        <div class="kpi-title">Serviços Ativos</div>
        <div class="kpi-value"><?php echo $servicosAtivos; ?> <span style="font-size:1.1rem; color:var(--text-muted); font-weight:600;">/ <?php echo $totalServicos; ?></span></div>
      </div>
      <div class="kpi-card">
        <div class="kpi-title">Parceiros Ativos</div>
        <div class="kpi-value"><?php echo $parceirosAtivos; ?> <span style="font-size:1.1rem; color:var(--text-muted); font-weight:600;">/ <?php echo $totalParceiros; ?></span></div>
      </div>
      <div class="kpi-card">
        <div class="kpi-title">Orçamentos Pendentes</div>
        <div class="kpi-value"><?php echo $pendentes; ?></div>
      </div>
      <div class="kpi-card">
        <div class="kpi-title">Total de Chamados</div>
        <div class="kpi-value"><?php echo $totalOrcamentos; ?></div>
      </div>
    </div>

    <div class="tabs">
      <button class="tab-btn <?php echo $activeTab === 'estoque' ? 'active' : ''; ?>" data-tab="estoque" onclick="switchTab('estoque')">📱 Celulares &amp; Estoque</button>
      <button class="tab-btn <?php echo $activeTab === 'servicos' ? 'active' : ''; ?>" data-tab="servicos" onclick="switchTab('servicos')">🛠️ Serviços MJG</button>
      <button class="tab-btn <?php echo $activeTab === 'parceiros' ? 'active' : ''; ?>" data-tab="parceiros" onclick="switchTab('parceiros')">🤝 Serviços de Parceiros</button>
      <button class="tab-btn <?php echo $activeTab === 'orcamentos' ? 'active' : ''; ?>" data-tab="orcamentos" onclick="switchTab('orcamentos')">📋 Orçamentos &amp; Chamados</button>
      <button class="tab-btn <?php echo $activeTab === 'sistema' ? 'active' : ''; ?>" data-tab="sistema" onclick="switchTab('sistema')">⚙️ Configurações / Senha</button>
    </div>

    <!-- ABA 1: CELULARES EM ESTOQUE -->
    <div id="tab-estoque" class="tab-content <?php echo $activeTab === 'estoque' ? 'active' : ''; ?>">
      <div class="card">
        <h3 class="section-title" style="margin-bottom: 1rem;">Cadastrar Novo Aparelho</h3>
        <form method="POST" action="index.php">
          <input type="hidden" name="action" value="novo_celular">
          <div class="form-grid">
            <div class="form-group">
              <label>Nome do Aparelho</label>
              <input type="text" name="nome" placeholder="Ex: iPhone 14 Pro Max" required>
            </div>
            <div class="form-group">
              <label>Marca</label>
              <select name="marca" required>
                <option value="Apple">Apple</option>
                <option value="Samsung">Samsung</option>
                <option value="Motorola">Motorola</option>
                <option value="Xiaomi">Xiaomi</option>
                <option value="LG">LG</option>
                <option value="Outra">Outra</option>
              </select>
            </div>
            <div class="form-group">
              <label>Condição</label>
              <select name="condicao">
                <option value="Seminovo">Seminovo</option>
                <option value="Novo">Novo</option>
              </select>
            </div>
            <div class="form-group">
              <label>Armazenamento</label>
              <input type="text" name="armazenamento" placeholder="Ex: 128 GB" value="128 GB" required>
            </div>
            <div class="form-group">
              <label>Preço (R$)</label>
              <input type="text" name="preco" placeholder="Ex: 2799,00" required>
            </div>
          </div>
          <button type="submit" class="btn-add" style="margin-top: 1rem;">+ Adicionar ao Estoque</button>
        </form>
      </div>

      <div class="section-header">
        <h3 class="section-title">Aparelhos Cadastrados (<?php echo count($celulares); ?>)</h3>
      </div>
      <div class="data-table-container">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Aparelho</th>
              <th>Marca</th>
              <th>Armazenamento</th>
              <th>Condição</th>
              <th>Preço</th>
              <th>Status</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($celulares)): ?>
              <tr><td colspan="8" style="text-align:center; color:var(--text-muted); padding: 2rem;">Nenhum aparelho cadastrado no momento.</td></tr>
            <?php else: ?>
              <?php foreach ($celulares as $cel): ?>
                <tr>
                  <td>#<?php echo $cel['id']; ?></td>
                  <td><strong><?php echo htmlspecialchars($cel['nome']); ?></strong></td>
                  <td><?php echo htmlspecialchars($cel['marca']); ?></td>
                  <td><?php echo htmlspecialchars($cel['armazenamento']); ?></td>
                  <td>
                    <span class="badge <?php echo strtolower($cel['condicao']) === 'novo' ? 'novo' : 'seminovo'; ?>">
                      <?php echo htmlspecialchars($cel['condicao']); ?>
                    </span>
                  </td>
                  <td><strong>R$ <?php echo number_format((float)$cel['preco'], 2, ',', '.'); ?></strong></td>
                  <td>
                    <span class="badge <?php echo strtolower($cel['status']) === 'disponível' ? 'disponivel' : 'vendido'; ?>">
                      <?php echo htmlspecialchars($cel['status']); ?>
                    </span>
                  </td>
                  <td>
                    <div class="actions-cell">
                      <form method="POST" action="index.php" style="display:inline;">
                        <input type="hidden" name="action" value="toggle_status_celular">
                        <input type="hidden" name="id" value="<?php echo $cel['id']; ?>">
                        <input type="hidden" name="status" value="<?php echo $cel['status'] === 'Disponível' ? 'Vendido' : 'Disponível'; ?>">
                        <button type="submit" class="btn-action" title="Alternar status">
                          <?php echo $cel['status'] === 'Disponível' ? 'Marcar Vendido' : 'Marcar Disponível'; ?>
                        </button>
                      </form>
                      <form method="POST" action="index.php" style="display:inline;" onsubmit="return confirm('Deseja realmente excluir este aparelho?');">
                        <input type="hidden" name="action" value="excluir_celular">
                        <input type="hidden" name="id" value="<?php echo $cel['id']; ?>">
                        <button type="submit" class="btn-action del" title="Excluir">🗑️</button>
                      </form>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- ABA 2: SERVIÇOS PRESTADOS -->
    <div id="tab-servicos" class="tab-content <?php echo $activeTab === 'servicos' ? 'active' : ''; ?>">
      <div class="card">
        <h3 class="section-title" id="form-servico-title" style="margin-bottom: 1rem;">Cadastrar Novo Serviço</h3>
        <form method="POST" action="index.php" id="form-servico">
          <input type="hidden" name="action" id="servico-action" value="novo_servico">
          <input type="hidden" name="id" id="servico-id" value="">
          <div class="form-grid">
            <div class="form-group" style="grid-column: span 2;">
              <label>Título do Serviço</label>
              <input type="text" name="titulo" id="servico-titulo" placeholder="Ex: Troca de Tela, Reparo de Placa" required>
            </div>
            <div class="form-group">
              <label>Ordem de Exibição</label>
              <input type="number" name="ordem" id="servico-ordem" value="10" min="0" required>
            </div>
          </div>

          <div class="form-group" style="margin-top: 1rem;">
            <label>Escolher Ícone do Serviço (Clique no ícone desejado)</label>
            <div class="icon-picker-box">
              <div class="icon-picker-top">
                <div class="icon-preview" id="icon-preview-display">📱</div>
                <div style="flex: 1; min-width: 200px;">
                  <div style="font-size: 0.95rem; font-weight: 700; color: #fff;">
                    Ícone Selecionado: <span id="icon-name-display" style="color: var(--primary);">Smartphone / Celular</span>
                  </div>
                  <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 3px;">
                    Clique em um dos ícones pré-carregados abaixo para selecioná-lo imediatamente:
                  </div>
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem; background: rgba(0,0,0,0.3); padding: 0.35rem 0.65rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.06);">
                  <span style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Manual:</span>
                  <input type="text" name="icone" id="servico-icone" value="📱" style="width: 55px; text-align: center; font-size: 1.3rem; padding: 0.35rem; background: rgba(15,23,42,0.9);" oninput="atualizarIconeManualmente(this.value)" required>
                </div>
              </div>

              <div class="icon-category-label">Galeria de Ícones Pré-carregados (Assistência Técnica, Acessórios e Celulares):</div>
              <div class="icon-palette" id="icon-palette-container">
                <!-- Populado automaticamente pelo JavaScript -->
              </div>
            </div>
          </div>

          <div class="form-group" style="margin-top: 1rem;">
            <label>Descrição Detalhada</label>
            <textarea name="descricao" id="servico-descricao" rows="3" placeholder="Descreva o serviço oferecido aos clientes..." required></textarea>
          </div>
          <div style="margin-top: 1rem; display: flex; gap: 0.75rem; align-items: center;">
            <button type="submit" class="btn-add" id="btn-servico-submit">+ Salvar Serviço</button>
            <button type="button" class="btn-action" id="btn-servico-cancel" onclick="cancelarEdicaoServico()" style="display: none;">Cancelar Edição</button>
          </div>
        </form>
      </div>

      <div class="section-header">
        <h3 class="section-title">Serviços Prestados Cadastrados (<?php echo count($servicos); ?>)</h3>
      </div>
      <div class="data-table-container">
        <table>
          <thead>
            <tr>
              <th style="width: 50px;">ID</th>
              <th style="width: 60px;">Ícone</th>
              <th>Título</th>
              <th>Descrição</th>
              <th style="width: 80px;">Ordem</th>
              <th style="width: 100px;">Status</th>
              <th style="width: 190px;">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($servicos)): ?>
              <tr><td colspan="7" style="text-align:center; color:var(--text-muted); padding:2rem;">Nenhum serviço cadastrado ainda.</td></tr>
            <?php else: ?>
              <?php foreach ($servicos as $s): ?>
                <tr>
                  <td>#<?php echo $s['id']; ?></td>
                  <td style="font-size: 1.5rem; text-align: center;"><?php echo htmlspecialchars($s['icone'] ?: '🛠️'); ?></td>
                  <td><strong><?php echo htmlspecialchars($s['titulo']); ?></strong></td>
                  <td style="color:var(--text-muted); font-size:0.875rem; max-width: 340px;"><?php echo htmlspecialchars($s['descricao']); ?></td>
                  <td><?php echo (int)$s['ordem']; ?></td>
                  <td>
                    <?php if ((int)$s['ativo'] === 1): ?>
                      <span class="badge disponivel">Ativo</span>
                    <?php else: ?>
                      <span class="badge vendido">Inativo</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <div class="actions-cell">
                      <button type="button" class="btn-action" onclick='prepararEdicaoServico(<?php echo htmlspecialchars(json_encode($s), ENT_QUOTES, 'UTF-8'); ?>)'>✏️ Editar</button>
                      <form method="POST" action="index.php" style="display:inline;">
                        <input type="hidden" name="action" value="toggle_status_servico">
                        <input type="hidden" name="id" value="<?php echo $s['id']; ?>">
                        <input type="hidden" name="ativo" value="<?php echo (int)$s['ativo'] === 1 ? '0' : '1'; ?>">
                        <button type="submit" class="btn-action" title="Alternar status"><?php echo (int)$s['ativo'] === 1 ? '⏸️ Pausar' : '▶️ Ativar'; ?></button>
                      </form>
                      <form method="POST" action="index.php" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir o serviço <?php echo addslashes($s['titulo']); ?>?');">
                        <input type="hidden" name="action" value="excluir_servico">
                        <input type="hidden" name="id" value="<?php echo $s['id']; ?>">
                        <button type="submit" class="btn-action del" title="Excluir serviço">🗑️</button>
                      </form>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- ABA 3: SERVIÇOS DE PARCEIROS (CRUD) -->
    <div id="tab-parceiros" class="tab-content <?php echo $activeTab === 'parceiros' ? 'active' : ''; ?>">
      <div class="card">
        <h3 class="section-title" id="form-parceiro-title" style="margin-bottom: 1rem;">Cadastrar Novo Parceiro</h3>
        <p style="color:var(--text-muted); font-size:0.875rem; margin-bottom: 1.25rem;">
          Cadastre empresas e prestadores de serviços parceiros recomendados pela MJG. Esses serviços são exibidos logo abaixo dos serviços MJG na página de serviços e divulgados no banner especial da página inicial.
        </p>
        <form method="POST" action="index.php" id="form-parceiro">
          <input type="hidden" name="action" id="parceiro-action" value="novo_parceiro">
          <input type="hidden" name="id" id="parceiro-id" value="">
          <div class="form-grid">
            <div class="form-group">
              <label>Nome do Parceiro / Empresa</label>
              <input type="text" name="nome" id="parceiro-nome" placeholder="Ex: Rede Tech &amp; CFTV São Roque" required>
            </div>
            <div class="form-group">
              <label>Logo ou Ícone do Parceiro</label>
              <input type="text" name="logo" id="parceiro-logo" placeholder="Emoji (📹, 🎨, 🤝) ou URL da Logo" value="🤝" required>
            </div>
            <div class="form-group">
              <label>WhatsApp / Contato</label>
              <input type="text" name="whatsapp" id="parceiro-whatsapp" placeholder="Ex: 11998037170 ou (11) 99803-7170">
            </div>
            <div class="form-group">
              <label>Site do Parceiro (Link / URL)</label>
              <input type="url" name="site" id="parceiro-site" placeholder="Ex: https://seusite.com.br">
            </div>
            <div class="form-group">
              <label>Ordem de Exibição</label>
              <input type="number" name="ordem" id="parceiro-ordem" value="10" min="0" required>
            </div>
          </div>

          <div class="form-group" style="margin-top: 1rem;">
            <label>Lista de Serviços do Parceiro (Separados por vírgula ou tópicos)</label>
            <textarea name="servicos" id="parceiro-servicos" rows="2" placeholder="Ex: Câmeras de Monitoramento (CFTV), Instalação de Wi-Fi, Cabeamento Estruturado, Alarmes Residenciais" required></textarea>
            <small style="color:var(--text-muted); font-size:0.75rem;">Dica: Digite os serviços separados por vírgula para serem exibidos como tags visuais destacadas no site.</small>
          </div>

          <div class="form-group" style="margin-top: 1rem;">
            <label>Descrição / Apresentação do Parceiro</label>
            <textarea name="descricao" id="parceiro-descricao" rows="2" placeholder="Ex: Especialistas em segurança eletrônica e infraestrutura de alta velocidade em São Roque e região..."></textarea>
          </div>

          <div style="margin-top: 1rem; display: flex; gap: 0.75rem; align-items: center;">
            <button type="submit" class="btn-add" id="btn-parceiro-submit">+ Salvar Parceiro</button>
            <button type="button" class="btn-action" id="btn-parceiro-cancel" onclick="cancelarEdicaoParceiro()" style="display: none;">Cancelar Edição</button>
          </div>
        </form>
      </div>

      <div class="section-header">
        <h3 class="section-title">Parceiros Cadastrados (<?php echo count($parceiros); ?>)</h3>
      </div>
      <div class="data-table-container">
        <table>
          <thead>
            <tr>
              <th style="width: 50px;">ID</th>
              <th style="width: 70px;">Logo</th>
              <th>Parceiro</th>
              <th>Serviços Oferecidos</th>
              <th style="width: 170px;">Contato / Site</th>
              <th style="width: 70px;">Ordem</th>
              <th style="width: 90px;">Status</th>
              <th style="width: 190px;">Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($parceiros)): ?>
              <tr><td colspan="8" style="text-align:center; color:var(--text-muted); padding:2rem;">Nenhum parceiro cadastrado ainda.</td></tr>
            <?php else: ?>
              <?php foreach ($parceiros as $p): ?>
                <tr>
                  <td>#<?php echo $p['id']; ?></td>
                  <td style="font-size: 1.5rem; text-align: center;">
                    <?php if (str_starts_with($p['logo'] ?? '', 'http') || str_starts_with($p['logo'] ?? '', '/')): ?>
                      <img src="<?php echo htmlspecialchars($p['logo']); ?>" alt="Logo" style="width:36px; height:36px; object-fit:contain; border-radius:4px;">
                    <?php else: ?>
                      <?php echo htmlspecialchars($p['logo'] ?: '🤝'); ?>
                    <?php endif; ?>
                  </td>
                  <td>
                    <strong><?php echo htmlspecialchars($p['nome']); ?></strong>
                    <?php if (!empty($p['descricao'])): ?>
                      <br><small style="color:var(--text-muted); font-size:0.8rem;"><?php echo htmlspecialchars($p['descricao']); ?></small>
                    <?php endif; ?>
                  </td>
                  <td>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.35rem;">
                      <?php 
                        $itens = array_filter(array_map('trim', explode(',', $p['servicos'] ?? '')));
                        foreach ($itens as $it):
                      ?>
                        <span style="display:inline-block; font-size:0.75rem; background:rgba(56,189,248,0.12); color:var(--primary); padding:2px 8px; border-radius:4px; border:1px solid rgba(56,189,248,0.25);">
                          <?php echo htmlspecialchars($it); ?>
                        </span>
                      <?php endforeach; ?>
                    </div>
                  </td>
                  <td>
                    <?php if (!empty($p['whatsapp'])): 
                      $cleanWa = preg_replace('/\D/', '', $p['whatsapp']);
                      if (strlen($cleanWa) === 10 || strlen($cleanWa) === 11) {
                          $cleanWa = '55' . $cleanWa;
                      }
                    ?>
                      <a href="https://wa.me/<?php echo $cleanWa; ?>" target="_blank" style="color:var(--success); font-weight:700; font-size:0.85rem; text-decoration:none; display:inline-flex; align-items:center; gap:3px;">
                        🟢 <?php echo htmlspecialchars($p['whatsapp']); ?>
                      </a>
                    <?php endif; ?>
                    <?php if (!empty($p['site'])): ?>
                      <br><a href="<?php echo htmlspecialchars($p['site']); ?>" target="_blank" rel="noopener noreferrer" style="color:var(--primary); font-size:0.8rem; text-decoration:none; display:inline-flex; align-items:center; gap:3px; margin-top:3px;">
                        🌐 <?php echo htmlspecialchars(preg_replace('#^https?://#', '', rtrim($p['site'], '/'))); ?>
                      </a>
                    <?php endif; ?>
                    <?php if (empty($p['whatsapp']) && empty($p['site'])): ?>
                      <span style="color:var(--text-muted); font-size:0.8rem;">-</span>
                    <?php endif; ?>
                  </td>
                  <td><?php echo (int)$p['ordem']; ?></td>
                  <td>
                    <?php if ((int)$p['ativo'] === 1): ?>
                      <span class="badge disponivel">Ativo</span>
                    <?php else: ?>
                      <span class="badge vendido">Inativo</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <div class="actions-cell">
                      <button type="button" class="btn-action" onclick='prepararEdicaoParceiro(<?php echo htmlspecialchars(json_encode($p), ENT_QUOTES, 'UTF-8'); ?>)'>✏️ Editar</button>
                      <form method="POST" action="index.php" style="display:inline;">
                        <input type="hidden" name="action" value="toggle_status_parceiro">
                        <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                        <input type="hidden" name="ativo" value="<?php echo (int)$p['ativo'] === 1 ? '0' : '1'; ?>">
                        <button type="submit" class="btn-action" title="Alternar status"><?php echo (int)$p['ativo'] === 1 ? '⏸️ Pausar' : '▶️ Ativar'; ?></button>
                      </form>
                      <form method="POST" action="index.php" style="display:inline;" onsubmit="return confirm('Tem certeza que deseja excluir o parceiro <?php echo addslashes($p['nome']); ?>?');">
                        <input type="hidden" name="action" value="excluir_parceiro">
                        <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                        <button type="submit" class="btn-action del" title="Excluir parceiro">🗑️</button>
                      </form>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- ABA 4: ORÇAMENTOS E CHAMADOS -->
    <div id="tab-orcamentos" class="tab-content <?php echo $activeTab === 'orcamentos' ? 'active' : ''; ?>">
      <div class="card">
        <h3 class="section-title" style="margin-bottom: 1rem;">Registrar Novo Orçamento Manual</h3>
        <form method="POST" action="index.php">
          <input type="hidden" name="action" value="novo_orcamento">
          <div class="form-grid">
            <div class="form-group">
              <label>Nome do Cliente</label>
              <input type="text" name="cliente_nome" placeholder="Ex: João da Silva" required>
            </div>
            <div class="form-group">
              <label>WhatsApp / Telefone</label>
              <input type="text" name="cliente_telefone" placeholder="Ex: (11) 99999-9999">
            </div>
            <div class="form-group">
              <label>Marca</label>
              <input type="text" name="marca" placeholder="Ex: Samsung" required>
            </div>
            <div class="form-group">
              <label>Modelo</label>
              <input type="text" name="modelo" placeholder="Ex: Galaxy A54" required>
            </div>
            <div class="form-group">
              <label>Serviço Pretendido</label>
              <input type="text" name="servico" placeholder="Ex: Troca de Tela" required>
            </div>
            <div class="form-group" style="grid-column: 1 / -1;">
              <label>Descrição do Problema</label>
              <textarea name="problema" rows="2" placeholder="Detalhes do relato do cliente..."></textarea>
            </div>
          </div>
          <button type="submit" class="btn-add" style="margin-top: 1rem;">+ Registrar Orçamento</button>
        </form>
      </div>

      <div class="section-header">
        <h3 class="section-title">Chamados &amp; Orçamentos (<?php echo count($orcamentos); ?>)</h3>
      </div>
      <div class="data-table-container">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Data</th>
              <th>Cliente</th>
              <th>Aparelho</th>
              <th>Serviço / Problema</th>
              <th>Status</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($orcamentos)): ?>
              <tr><td colspan="7" style="text-align:center; color:var(--text-muted); padding: 2rem;">Nenhum chamado de orçamento registrado ainda.</td></tr>
            <?php else: ?>
              <?php foreach ($orcamentos as $orc): ?>
                <tr>
                  <td>#<?php echo $orc['id']; ?></td>
                  <td style="white-space:nowrap;"><?php echo date('d/m/Y H:i', strtotime($orc['criado_em'])); ?></td>
                  <td>
                    <strong><?php echo htmlspecialchars($orc['cliente_nome']); ?></strong><br>
                    <small style="color:var(--text-muted);"><?php echo htmlspecialchars($orc['cliente_telefone'] ?? ''); ?></small>
                  </td>
                  <td>
                    <strong><?php echo htmlspecialchars($orc['marca']); ?></strong> <?php echo htmlspecialchars($orc['modelo']); ?>
                  </td>
                  <td>
                    <strong><?php echo htmlspecialchars($orc['servico']); ?></strong>
                    <?php if (!empty($orc['problema'])): ?>
                      <br><small style="color:var(--text-muted);"><?php echo htmlspecialchars($orc['problema']); ?></small>
                    <?php endif; ?>
                  </td>
                  <td>
                    <form method="POST" action="index.php" style="display:inline;">
                      <input type="hidden" name="action" value="atualizar_status_orcamento">
                      <input type="hidden" name="id" value="<?php echo $orc['id']; ?>">
                      <select name="status" onchange="this.form.submit()" style="padding:0.3rem 0.5rem; font-size:0.8rem;">
                        <?php foreach (['Pendente', 'Em Análise', 'Aprovado', 'Em Reparo', 'Pronto', 'Entregue', 'Cancelado'] as $st): ?>
                          <option value="<?php echo $st; ?>" <?php echo $orc['status'] === $st ? 'selected' : ''; ?>><?php echo $st; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </form>
                  </td>
                  <td>
                    <?php if (!empty($orc['cliente_telefone'])): 
                      $cleanTel = preg_replace('/\D/', '', $orc['cliente_telefone']);
                      if (strlen($cleanTel) === 10 || strlen($cleanTel) === 11) {
                          $cleanTel = '55' . $cleanTel;
                      }
                      $msgWa = "Olá " . $orc['cliente_nome'] . "! Aqui é da MJG Assistech & Imports referente ao seu orçamento do " . $orc['marca'] . " " . $orc['modelo'] . ".";
                      $waLink = "https://wa.me/" . $cleanTel . "?text=" . urlencode($msgWa);
                    ?>
                      <a href="<?php echo $waLink; ?>" target="_blank" class="btn-action wa" title="Falar no WhatsApp">💬 WhatsApp</a>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- ABA 4: SISTEMA / SEGURANÇA -->
    <div id="tab-sistema" class="tab-content <?php echo $activeTab === 'sistema' ? 'active' : ''; ?>">
      <div class="card" style="max-width: 600px;">
        <h3 class="section-title" style="margin-bottom: 1rem;">Alterar Senha do Administrador</h3>
        <form method="POST" action="index.php">
          <input type="hidden" name="action" value="alterar_senha">
          <div class="form-group" style="margin-bottom: 1rem;">
            <label>Usuário Ativo</label>
            <input type="text" value="<?php echo htmlspecialchars($user['usuario']); ?>" disabled>
          </div>
          <div class="form-group" style="margin-bottom: 1rem;">
            <label>Nova Senha</label>
            <input type="password" name="nova_senha" required placeholder="Digite a nova senha (mínimo 6 dígitos)">
          </div>
          <button type="submit" class="btn-add">Salvar Nova Senha</button>
        </form>
      </div>

      <div class="card" style="max-width: 600px;">
        <h3 class="section-title" style="margin-bottom: 1rem;">Conexão com Banco de Dados</h3>
        <p style="color:var(--text-muted); font-size:0.9rem; line-height: 1.6;">
          <strong>Host:</strong> localhost<br>
          <strong>Base de Dados:</strong> u683004893_mjg<br>
          <strong>Usuário MySQL:</strong> u683004893_mjg<br>
          <strong>Status:</strong> Conectado via PDO UTF-8 com migração automática ativa.
        </p>
      </div>
    </div>
  </main>

  <script>
    function switchTab(tab) {
      document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
      document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
      const activeBtn = document.querySelector(`.tab-btn[data-tab="${tab}"]`);
      if (activeBtn) activeBtn.classList.add('active');
      const activeContent = document.getElementById(`tab-${tab}`);
      if (activeContent) activeContent.classList.add('active');
    }

    const PRELOADED_ICONS = [
      { icon: '📱', name: 'Smartphone / Celular' },
      { icon: '📲', name: 'Tela / Chamada' },
      { icon: '🔋', name: 'Bateria / Carga' },
      { icon: '⚡', name: 'Carregador Rápido' },
      { icon: '🔌', name: 'Conector de Carga / Cabo' },
      { icon: '🪫', name: 'Bateria Baixa' },
      { icon: '🛠️', name: 'Ferramentas / Manutenção' },
      { icon: '🔧', name: 'Reparo / Chave' },
      { icon: '⚙️', name: 'Engrenagem / Ajustes' },
      { icon: '🪛', name: 'Técnico / Chave de Fenda' },
      { icon: '🔨', name: 'Reforma / Martelo' },
      { icon: '🔓', name: 'Desbloqueio' },
      { icon: '🔒', name: 'Bloqueio / Segurança' },
      { icon: '🛡️', name: 'Película / Proteção' },
      { icon: '🔑', name: 'Chave / Acesso' },
      { icon: '💧', name: 'Água / Banho Químico' },
      { icon: '🧼', name: 'Limpeza Interna' },
      { icon: '📷', name: 'Câmera Traseira' },
      { icon: '📸', name: 'Câmera Frontal / Foto' },
      { icon: '🔊', name: 'Alto-Falante / Som' },
      { icon: '🎙️', name: 'Microfone' },
      { icon: '🎧', name: 'Fone de Ouvido' },
      { icon: '💻', name: 'Reparo de Placa / Notebook' },
      { icon: '🖥️', name: 'Display / Monitor' },
      { icon: '💾', name: 'Memória / Backup' },
      { icon: '🔍', name: 'Diagnóstico Técnico' },
      { icon: '💎', name: 'Peças Premium / Originais' },
      { icon: '🏷️', name: 'Oferta / Promoção' },
      { icon: '🛍️', name: 'Acessórios / Compras' },
      { icon: '📦', name: 'Envio / Aparelhos' },
      { icon: '💼', name: 'Capinhas / Executivo' },
      { icon: '✨', name: 'Celular Novo / Cristalino' },
      { icon: '🚀', name: 'Conserto Rápido / Express' },
      { icon: '⏱️', name: 'Pontualidade' },
      { icon: '💬', name: 'Atendimento WhatsApp' },
      { icon: '📍', name: 'Loja Física São Roque' }
    ];

    function renderizarIconPalette() {
      const container = document.getElementById('icon-palette-container');
      if (!container) return;
      container.innerHTML = '';
      const iconeAtual = (document.getElementById('servico-icone')?.value || '📱').trim();

      PRELOADED_ICONS.forEach(item => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'icon-opt' + (item.icon === iconeAtual ? ' selected' : '');
        btn.title = item.name + ' (' + item.icon + ')';
        btn.textContent = item.icon;
        btn.onclick = () => selecionarIcone(item.icon, item.name);
        container.appendChild(btn);
      });
    }

    function selecionarIcone(icone, nome) {
      icone = (icone || '📱').trim();
      const input = document.getElementById('servico-icone');
      const preview = document.getElementById('icon-preview-display');
      const nameDisplay = document.getElementById('icon-name-display');
      if (input) input.value = icone;
      if (preview) preview.textContent = icone;
      if (nameDisplay) {
        if (!nome) {
          const match = PRELOADED_ICONS.find(i => i.icon === icone);
          nome = match ? match.name : 'Personalizado';
        }
        nameDisplay.textContent = nome;
      }

      document.querySelectorAll('.icon-opt').forEach(opt => {
        if (opt.textContent.trim() === icone) {
          opt.classList.add('selected');
        } else {
          opt.classList.remove('selected');
        }
      });
    }

    function atualizarIconeManualmente(icone) {
      icone = (icone || '📱').trim();
      const preview = document.getElementById('icon-preview-display');
      const nameDisplay = document.getElementById('icon-name-display');
      if (preview) preview.textContent = icone;
      if (nameDisplay) {
        const match = PRELOADED_ICONS.find(i => i.icon === icone);
        nameDisplay.textContent = match ? match.name : 'Personalizado';
      }
      document.querySelectorAll('.icon-opt').forEach(opt => {
        opt.classList.toggle('selected', opt.textContent.trim() === icone);
      });
    }

    function prepararEdicaoServico(servico) {
      document.getElementById('form-servico-title').textContent = 'Editar Serviço: ' + servico.titulo;
      document.getElementById('servico-action').value = 'editar_servico';
      document.getElementById('servico-id').value = servico.id;
      document.getElementById('servico-titulo').value = servico.titulo;
      document.getElementById('servico-ordem').value = servico.ordem;
      document.getElementById('servico-descricao').value = servico.descricao;
      selecionarIcone(servico.icone || '📱');
      document.getElementById('btn-servico-submit').textContent = '💾 Atualizar Serviço';
      document.getElementById('btn-servico-cancel').style.display = 'inline-block';
      document.getElementById('form-servico').scrollIntoView({ behavior: 'smooth' });
    }

    function cancelarEdicaoServico() {
      document.getElementById('form-servico-title').textContent = 'Cadastrar Novo Serviço';
      document.getElementById('servico-action').value = 'novo_servico';
      document.getElementById('servico-id').value = '';
      document.getElementById('servico-titulo').value = '';
      document.getElementById('servico-ordem').value = '10';
      document.getElementById('servico-descricao').value = '';
      selecionarIcone('📱', 'Smartphone / Celular');
      document.getElementById('btn-servico-submit').textContent = '+ Salvar Serviço';
      document.getElementById('btn-servico-cancel').style.display = 'none';
    }

    function prepararEdicaoParceiro(parceiro) {
      document.getElementById('form-parceiro-title').textContent = 'Editar Parceiro: ' + parceiro.nome;
      document.getElementById('parceiro-action').value = 'editar_parceiro';
      document.getElementById('parceiro-id').value = parceiro.id;
      document.getElementById('parceiro-nome').value = parceiro.nome;
      document.getElementById('parceiro-logo').value = parceiro.logo || '🤝';
      document.getElementById('parceiro-whatsapp').value = parceiro.whatsapp || '';
      document.getElementById('parceiro-site').value = parceiro.site || '';
      document.getElementById('parceiro-ordem').value = parceiro.ordem || '10';
      document.getElementById('parceiro-servicos').value = parceiro.servicos || '';
      document.getElementById('parceiro-descricao').value = parceiro.descricao || '';
      document.getElementById('btn-parceiro-submit').textContent = '💾 Atualizar Parceiro';
      document.getElementById('btn-parceiro-cancel').style.display = 'inline-block';
      document.getElementById('form-parceiro').scrollIntoView({ behavior: 'smooth' });
    }

    function cancelarEdicaoParceiro() {
      document.getElementById('form-parceiro-title').textContent = 'Cadastrar Novo Parceiro';
      document.getElementById('parceiro-action').value = 'novo_parceiro';
      document.getElementById('parceiro-id').value = '';
      document.getElementById('parceiro-nome').value = '';
      document.getElementById('parceiro-logo').value = '🤝';
      document.getElementById('parceiro-whatsapp').value = '';
      document.getElementById('parceiro-site').value = '';
      document.getElementById('parceiro-ordem').value = '10';
      document.getElementById('parceiro-servicos').value = '';
      document.getElementById('parceiro-descricao').value = '';
      document.getElementById('btn-parceiro-submit').textContent = '+ Salvar Parceiro';
      document.getElementById('btn-parceiro-cancel').style.display = 'none';
    }

    // Inicializa a galeria de ícones pré-carregados ao abrir a página
    renderizarIconPalette();
  </script>
</body>
</html>
