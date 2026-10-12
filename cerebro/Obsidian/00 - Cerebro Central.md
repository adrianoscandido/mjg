# 🧠 Cérebro MJG Assistech & Imports — Índice Central (MOC)

> **Documentação de Referência e Base de Verdade do Projeto:** Este diretório reúne toda a infraestrutura, regras de negócio, integrações, credenciais e rotinas de manutenção do site e sistema administrativo da **MJG Assistech & Imports** (`mjgimports.com.br`). Consulte estes arquivos antes e após qualquer modificação no projeto.

---

## 📌 Identificação do Negócio & Dados Oficiais
- **Nome da Empresa:** MJG Assistech & Imports
- **Ramo:** Assistência Técnica Especializada de Celulares, Venda de Smartphones Novos e Seminovos, Acessórios e Soluções Tecnológicas.
- **Endereço Físico:** Av. Jaboticabal, 347 – Vila Nova, São Roque - SP, CEP: 18131-225
- **WhatsApp Oficial:** (11) 99803-7170
- **Google Maps CID Oficial:** `8840866417741061658` (ID Maps: `16599107455903459186`)
- **Domínio Ativo:** [https://mjgimports.com.br](https://mjgimports.com.br)
- **Painel Administrativo:** [https://mjgimports.com.br/admin/login.php](https://mjgimports.com.br/admin/login.php)

---

## 🗺️ Mapa de Conteúdos da Documentação

Acesse os documentos detalhados de cada setor do projeto:

### 1. [[01 - Arquitetura e Stack Frontend]]
- Stack tecnológica (React 18, TypeScript, Vite, TanStack Router, TanStack Start, Tailwind CSS, Lucide Icons).
- Estrutura de rotas (`/`, `/servicos`, `/celulares`, `/orcamento`, `/contato`).
- Carrossel Hero com fotos da loja e botões de conversão.
- Seção de parceiros na página de serviços e banner dedicado na home.
- SEO avançado, meta tags para redes sociais (WhatsApp/Facebook/Twitter) e favicon oficial PWA.

### 2. [[02 - Backend PHP e Banco de Dados MySQL]]
- Conexão PDO segura com UTF-8 (`backend/api/db.php`).
- Migração automática de schemas sem necessidade de scripts manuais.
- Dicionário de dados das tabelas: `usuarios`, `aparelhos_estoque`, `servicos_prestados`, `parceiros`, `pedidos_orcamento`.
- APIs REST públicas em JSON (`/api/celulares.php`, `/api/servicos.php`, `/api/parceiros.php`, `/api/orcamento.php`).

### 3. [[03 - Painel Administrativo e Gestao de Servicos]]
- Funcionamento do painel administrativo em `/admin` com autenticação por sessão.
- Módulos CRUD:
  - 📱 **Aparelhos em Estoque:** Gestão de seminovos e novos com valores e status.
  - 🛠️ **Serviços Próprios:** Títulos, descrições, ordenação e seletor visual de ícones pré-carregados.
  - 🤝 **Serviços de Parceiros:** Cadastro de empresas recomendadas com Logo, Nome, WhatsApp, Site oficial e lista de serviços em tags.
  - 📋 **Chamados e Orçamentos:** Acompanhamento de solicitações enviadas pelo site com link rápido para WhatsApp do cliente.
  - ⚙️ **Configuração e Troca de Senha.**

### 4. [[04 - Identidade Visual, SEO e Google Maps]]
- Integração profunda com Google Meu Negócio e Google Maps (botão de traçar rota via GPS).
- Avaliações reais 5 estrelas do Google com depoimentos verificados.
- Padronização do botão flutuante e chamadas do WhatsApp (*"Olá, vim pelo site!"*).
- Brand assets oficiais: logotipo vetorizado MJG em SVG, Favicon ICO, Apple Touch Icon e Web App Manifest.

### 5. [[05 - Hospedagem, SFTP e Rotina de Deploy]]
- Detalhes do servidor Hostinger (Host SSH/SFTP, portas, usuário e diretórios).
- Script de deploy automatizado (`deploy.py`) com sincronização de assets estáticos e backend PHP.
- Regras de roteamento e reescrita do `.htaccess`.
- Comandos padrão para compilação e deploy em produção.

### 6. [[06 - Credenciais, Senhas e Acessos Administrativos]]
- Usuários autorizados no painel (`sandro` e `adriano`).
- Configurações do banco de dados MySQL na Hostinger.
- Política de segurança e armazenamento seguro de chaves.
