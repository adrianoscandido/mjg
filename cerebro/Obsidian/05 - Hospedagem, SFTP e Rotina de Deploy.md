# 🚀 05 - Hospedagem, SFTP e Rotina de Deploy

## 🌐 Informações do Servidor Hostinger

- **Endereço do Servidor (Host):** `77.37.127.215`
- **Porta SSH / SFTP:** `65002`
- **Usuário SSH / SFTP:** `u683004893`
- **Diretório Remoto Oficial:** `/home/u683004893/domains/mjgimports.com.br/public_html`
- **Domínio Ativo:** `https://mjgimports.com.br`

---

## 🤖 Automação de Deploy (`deploy.py`)

O projeto utiliza um script Python (`deploy.py`) baseado na biblioteca `paramiko` que cuida de todo o fluxo de sincronização e envio:

1. **Sincronização Local:**
   Copia automaticamente as pastas `backend/admin` e `backend/api` para a pasta de distribuição `dist/client/admin` e `dist/client/api`.
2. **Conexão Segura:**
   Estabelece sessão SSH/SFTP autenticada na porta `65002`.
3. **Backup de Arquivos Padrão:**
   Se existir `default.php` criado pela Hostinger, ele é renomeado para `default.php.bak`.
4. **Envio Recursivo dos Arquivos:**
   Cria pastas remotas necessárias com permissão `755` e transfere todos os arquivos (HTML, CSS, JS, imagens, PHP, `.htaccess`, favicons) com permissão `644`.

---

## 📄 Configuração do `.htaccess`

O arquivo `public/.htaccess` é enviado diretamente para a raiz do servidor para permitir:
1. **Roteamento SPA/SSR:** Redireciona requisições de páginas que não são arquivos físicos para `index.html`.
2. **Execução de PHP:** Permite que chamadas para `/admin/*` e `/api/*` executem scripts PHP normalmente sem interferência do roteador frontend.
3. **Cache de Assets:** Define cache estático longo para bundles JS, CSS e imagens com hash.

---

## ⚡ Comandos para Publicação de Atualizações

Para publicar qualquer melhoria ou alteração no site, execute no terminal do projeto (usando `;` no PowerShell):

```powershell
# 1. Compilar a aplicação para produção
npm run build

# 2. Enviar arquivos atualizados via SFTP
python deploy.py

# 3. Versionar no Git e sincronizar no GitHub
git add . ; git commit -m "feat: descricao das melhorias" ; git push origin main
```
