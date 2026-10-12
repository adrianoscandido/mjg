<?php
declare(strict_types=1);

require_once __DIR__ . '/auth.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($login) || empty($senha)) {
        $error = 'Por favor, preencha todos os campos.';
    } else {
        $res = loginUser($login, $senha);
        if ($res['ok']) {
            header('Location: index.php');
            exit;
        } else {
            $error = $res['error'] ?? 'Credenciais inválidas.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Administrativo | MJG Assistech & Imports</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;600;700;800&family=Bebas+Neue&display=swap" rel="stylesheet">
  <link rel="icon" type="image/svg+xml" href="/favicon.svg">
  <link rel="alternate icon" href="/favicon.ico" type="image/x-icon">
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Archivo', sans-serif;
      background: radial-gradient(circle at 50% 0%, #1e293b 0%, #0f172a 60%, #020617 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1.5rem;
      color: #f8fafc;
    }
    .login-box {
      width: 100%;
      max-width: 440px;
      background: rgba(30, 41, 59, 0.7);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 1.25rem;
      padding: 2.5rem 2rem;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), 0 0 40px rgba(56, 189, 248, 0.1);
    }
    .logo-area {
      text-align: center;
      margin-bottom: 2rem;
    }
    .brand-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 3rem;
      letter-spacing: 2px;
      color: #38bdf8;
      line-height: 1;
      text-shadow: 0 0 20px rgba(56, 189, 248, 0.4);
    }
    .brand-sub {
      font-size: 0.75rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 3px;
      color: #94a3b8;
      margin-top: 0.25rem;
    }
    .panel-tag {
      display: inline-block;
      margin-top: 0.75rem;
      background: rgba(56, 189, 248, 0.1);
      color: #38bdf8;
      border: 1px solid rgba(56, 189, 248, 0.3);
      padding: 0.25rem 0.75rem;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 700;
    }
    .alert-error {
      background: rgba(239, 68, 68, 0.15);
      border: 1px solid rgba(239, 68, 68, 0.3);
      color: #fca5a5;
      padding: 0.85rem 1rem;
      border-radius: 0.75rem;
      font-size: 0.875rem;
      font-weight: 600;
      margin-bottom: 1.5rem;
    }
    .form-group {
      margin-bottom: 1.25rem;
    }
    label {
      display: block;
      font-size: 0.875rem;
      font-weight: 700;
      color: #cbd5e1;
      margin-bottom: 0.5rem;
    }
    .input-wrapper {
      position: relative;
    }
    input[type="text"], input[type="password"] {
      width: 100%;
      background: rgba(15, 23, 42, 0.8);
      border: 1px solid rgba(148, 163, 184, 0.25);
      border-radius: 0.75rem;
      padding: 0.85rem 1rem;
      color: #ffffff;
      font-size: 1rem;
      font-family: inherit;
      transition: all 0.2s;
    }
    input:focus {
      outline: none;
      border-color: #38bdf8;
      box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.25);
      background: rgba(15, 23, 42, 0.95);
    }
    .btn-toggle-pwd {
      position: absolute;
      right: 0.85rem;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #94a3b8;
      cursor: pointer;
      font-size: 1.1rem;
      padding: 0.2rem;
    }
    .btn-toggle-pwd:hover {
      color: #ffffff;
    }
    .btn-submit {
      width: 100%;
      margin-top: 1rem;
      background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
      color: #ffffff;
      border: none;
      border-radius: 0.75rem;
      padding: 1rem;
      font-size: 1rem;
      font-weight: 700;
      cursor: pointer;
      box-shadow: 0 10px 20px -5px rgba(2, 132, 199, 0.5);
      transition: all 0.2s;
    }
    .btn-submit:hover {
      background: linear-gradient(135deg, #0369a1 0%, #075985 100%);
      transform: translateY(-1px);
      box-shadow: 0 12px 24px -5px rgba(2, 132, 199, 0.6);
    }
    .footer-link {
      margin-top: 1.75rem;
      text-align: center;
      font-size: 0.875rem;
    }
    .footer-link a {
      color: #94a3b8;
      text-decoration: none;
      transition: color 0.2s;
    }
    .footer-link a:hover {
      color: #38bdf8;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <div class="logo-area">
      <div class="brand-title">MJG</div>
      <div class="brand-sub">Assistech &amp; Imports</div>
      <div class="panel-tag">PAINEL ADMINISTRATIVO</div>
    </div>

    <?php if (!empty($error)): ?>
      <div class="alert-error">
        ⚠️ <?php echo htmlspecialchars($error); ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="login.php">
      <div class="form-group">
        <label for="login">Usuário ou E-mail</label>
        <div class="input-wrapper">
          <input type="text" id="login" name="login" required placeholder="sandro" autofocus value="<?php echo htmlspecialchars($_POST['login'] ?? ''); ?>">
        </div>
      </div>

      <div class="form-group">
        <label for="senha">Senha</label>
        <div class="input-wrapper">
          <input type="password" id="senha" name="senha" required placeholder="••••••••">
          <button type="button" class="btn-toggle-pwd" onclick="togglePassword()" title="Mostrar senha">👁️</button>
        </div>
      </div>

      <button type="submit" class="btn-submit">Entrar no Painel</button>
    </form>

    <div class="footer-link">
      <a href="/">← Voltar para o site</a>
    </div>
  </div>

  <script>
    function togglePassword() {
      const input = document.getElementById('senha');
      if (input.type === 'password') {
        input.type = 'text';
      } else {
        input.type = 'password';
      }
    }
  </script>
</body>
</html>
