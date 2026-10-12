# 🗄️ 02 - Backend PHP e Banco de Dados MySQL

## 🔌 Conexão PDO e Configuração do Banco

O backend da MJG utiliza PHP 8+ com PDO conectado à base MySQL fornecida na Hostinger:

- **Arquivo de Conexão:** `backend/api/db.php`
- **Host:** `localhost`
- **Nome da Base de Dados:** `u683004893_mjg`
- **Usuário MySQL:** `u683004893_mjg`
- **Charset:** `utf8mb4` com collation `utf8mb4_unicode_ci`
- **Tratamento de Erros:** `PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION`

---

## ⚡ Sistema de Migração Automática Idempotente

Ao invés de depender de scripts SQL executados manualmente via phpMyAdmin, o arquivo `db.php` executa automaticamente verificações ao inicializar (`CREATE TABLE IF NOT EXISTS` e `ALTER TABLE ADD COLUMN`):

1. Cria tabelas faltantes automaticamente.
2. Verifica se colunas novas existem (ex: `site` na tabela `parceiros`) e adiciona via `ALTER TABLE` caso necessário.
3. Garante que os usuários administradores padrão existam com senhas criptografadas com `password_hash($senha, PASSWORD_BCRYPT)`.
4. Popula dados de amostra caso as tabelas estejam vazias.

---

## 📊 Estrutura e Schemas das Tabelas

### 1. `usuarios` (Administradores do Painel)
```sql
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 2. `aparelhos_estoque` (Celulares à Venda)
```sql
CREATE TABLE IF NOT EXISTS aparelhos_estoque (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    marca VARCHAR(50) NOT NULL,
    condicao VARCHAR(30) NOT NULL DEFAULT 'Seminovo',
    armazenamento VARCHAR(50) NOT NULL DEFAULT '128 GB',
    preco DECIMAL(10,2) NOT NULL,
    status VARCHAR(30) DEFAULT 'Disponível',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 3. `servicos_prestados` (Serviços Oferecidos pela MJG)
```sql
CREATE TABLE IF NOT EXISTS servicos_prestados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(120) NOT NULL,
    descricao TEXT NOT NULL,
    icone VARCHAR(50) DEFAULT '📱',
    ordem INT DEFAULT 0,
    ativo TINYINT(1) DEFAULT 1,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 4. `parceiros` (Serviços e Empresas Parceiras)
```sql
CREATE TABLE IF NOT EXISTS parceiros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    logo VARCHAR(255) DEFAULT '🤝',
    whatsapp VARCHAR(50) DEFAULT NULL,
    site VARCHAR(255) DEFAULT NULL,
    servicos TEXT NOT NULL,
    descricao TEXT DEFAULT NULL,
    ordem INT DEFAULT 0,
    ativo TINYINT(1) DEFAULT 1,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 5. `pedidos_orcamento` (Chamados e Contatos de Clientes)
```sql
CREATE TABLE IF NOT EXISTS pedidos_orcamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_nome VARCHAR(100) NOT NULL,
    cliente_telefone VARCHAR(30) DEFAULT NULL,
    cliente_email VARCHAR(100) DEFAULT NULL,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(100) NOT NULL,
    servico VARCHAR(100) NOT NULL,
    problema TEXT DEFAULT NULL,
    status VARCHAR(30) DEFAULT 'Pendente',
    valor_estimado DECIMAL(10,2) DEFAULT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 🌐 APIs REST Públicas em JSON

Todas as APIs enviam cabeçalhos desabilitando cache (`no-store, no-cache, must-revalidate`) e retornam `{"ok": true, "dados": [...]}`:

| Endpoint | Método | Descrição |
|---|---|---|
| `/api/servicos.php` | GET | Retorna lista de serviços ativos da MJG ordenados por `ordem ASC, id ASC`. |
| `/api/parceiros.php` | GET | Retorna parceiros ativos com nome, logo, whatsapp, site, lista de serviços e descrição. |
| `/api/celulares.php` | GET | Retorna aparelhos disponíveis para venda em estoque. |
| `/api/orcamento.php` | POST | Recebe pedidos de orçamento enviados pelo formulário da página `/orcamento`. |
