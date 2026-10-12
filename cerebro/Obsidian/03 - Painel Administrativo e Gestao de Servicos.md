# 🛠️ 03 - Painel Administrativo e Gestão de Serviços

## 🔐 Autenticação e Controle de Sessão

- **Localização dos Arquivos:** `backend/admin/`
- **Página de Entrada / Login:** `/admin/login.php`
- **Painel Principal:** `/admin/index.php`
- **Verificador de Sessão:** `backend/admin/auth.php` (inicia `session_start()`, checa `$_SESSION['user_id']` e expulsa sessões inválidas para `login.php`).
- **Logout:** `/admin/logout.php` (destrói cookies e encerra sessão de forma segura).

---

## 🎨 Interface e Experiência do Administrador

O painel foi construído com design dark premium, responsivo para celulares e desktops:
- **Barra de topo:** Identificação do usuário logado, atalho *"🌐 Ver Site"* e botão de saída.
- **Cards de KPIs no Topo:**
  - Aparelhos em Estoque;
  - Celulares Disponíveis para Venda;
  - Serviços MJG Ativos (Total cadastrado);
  - **Parceiros Ativos (Total cadastrado);**
  - Orçamentos Pendentes;
  - Total de Chamados Recebidos.

---

## 📑 Módulos CRUD do Painel

### 1. 📱 Celulares & Estoque
- **Formulário:** Cadastra nome, marca (Apple, Samsung, Motorola, Xiaomi, LG, etc.), condição (Novo / Seminovo), armazenamento e preço em R$.
- **Tabela:** Listagem completa com opção de alternar status para *Disponível* ou *Vendido*, além de exclusão com confirmação.

### 2. 🛠️ Serviços Prestados MJG
- **Campos:** Título do serviço, ordem de exibição, ícone e descrição detalhada.
- **Galeria Visual de Ícones Pré-carregados:**
  - Interface interativa onde o usuário **clica no ícone desejado** e ele é selecionado instantaneamente com pré-visualização e identificação por texto.
  - Ícones selecionáveis: 📱 Smartphone, 📲 Tela, 🔋 Bateria, ⚡ Carregador Rápido, 🔌 Conector, 🪫 Bateria Baixa, 🛠️ Manutenção, 🔧 Reparo, ⚙️ Ajustes, 🪛 Ferramenta, 🔨 Reforma, 🔓 Desbloqueio, 🔒 Bloqueio, 🛡️ Película, 💧 Banho Químico, 🧼 Limpeza, 📷 Câmera Traseira, 📸 Câmera Frontal, 🔊 Alto-Falante, 🎙️ Microfone, 🎧 Fone, 💻 Reparo de Placa, 🖥️ Display, 💾 Backup, 🔍 Diagnóstico, 💎 Peças Originais, 🚀 Conserto Express, ⏱️ Pontualidade, etc.
  - Opção de inserção manual de qualquer outro emoji/ícone.
- **Ações:** Editar (carrega dados no formulário e rola a tela), Pausar/Ativar e Excluir.

### 3. 🤝 Serviços de Parceiros
- **Campos:**
  - **Nome do Parceiro / Empresa;**
  - **Logo ou Ícone:** Aceita emojis (`📹`, `🎨`, `🤝`) ou URLs de imagens externas/internas;
  - **WhatsApp / Telefone de Contato Direto;**
  - **Site do Parceiro (Link / URL Oficial):** Ex: `https://adrinformatica.com.br/`;
  - **Ordem de Exibição;**
  - **Lista de Serviços Oferecidos:** Separados por vírgula para serem convertidos automaticamente em tags visuais destacadas no site;
  - **Descrição / Apresentação do Parceiro.**
- **Tabela com Visualização Rápida:**
  - Mostra logo renderizada;
  - Mostra badges de serviços oferecidos;
  - Links clicáveis com ícone verde para WhatsApp e ícone de globo para o site oficial;
  - Botões para **Editar**, **Pausar/Ativar** e **Excluir**.

### 4. 📋 Orçamentos & Chamados
- Registros manuais ou automáticos recebidos via formulário da página `/orcamento`.
- Atualização do status do reparo: *Pendente*, *Em Análise*, *Aprovado*, *Em Reparo*, *Pronto*, *Entregue*, *Cancelado*.
- **Botão Direto de WhatsApp:** Abre conversa com o cliente já com mensagem preenchida citando o aparelho e a MJG.

### 5. ⚙️ Configurações / Senha
- Permite que o administrador ativo altere sua própria senha com validação de força mínima e criptografia BCRYPT em tempo real.
