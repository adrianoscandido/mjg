# 💻 01 - Arquitetura e Stack Frontend

## 🏗️ Visão Geral da Stack

O frontend da MJG foi desenvolvido com uma arquitetura moderna e ultra veloz, focada em alta taxa de conversão, carregamento instantâneo no celular e excelente indexação no Google:

- **Linguagem:** TypeScript 5+
- **Biblioteca Base:** React 18
- **Roteamento & SSR/SSG:** TanStack Router + TanStack Start
- **Bundler:** Vite 8 com suporte a `resolve.tsconfigPaths` e pré-renderização estática (`[prerender]`)
- **Estilização:** Tailwind CSS + Variáveis CSS personalizadas para paleta de alta definição
- **Ícones:** Lucide React e Emojis renderizados em fontes nativas
- **Tipografia:** Google Fonts (`Bebas Neue` para títulos imponentes e `Archivo` para leitura limpa)

---

## 🗺️ Mapa de Rotas do Frontend

| Rota | Arquivo Fonte | Finalidade |
|---|---|---|
| `/` | `src/routes/index.tsx` | Página inicial completa com HeroBanner carrossel, Marcas atendidas, Resumo de Serviços, Avaliações reais do Google, Fotos da loja, Banner de Parceiros e CTA WhatsApp. |
| `/servicos` | `src/routes/servicos.tsx` | Catálogo completo dos serviços da MJG e seção exclusiva de **Serviços de Parceiros Recomendados** (`#parceiros`). |
| `/celulares` | `src/routes/celulares.tsx` | Vitrine de smartphones novos e seminovos em estoque com filtros e botão de interesse via WhatsApp. |
| `/orcamento` | `src/routes/orcamento.tsx` | Formulário para envio de pedido de conserto com salvamento direto no MySQL e opção de envio por WhatsApp. |
| `/contato` | `src/routes/contato.tsx` | Dados de contato, endereço, horários de funcionamento e mapa interativo do Google. |

---

## 📱 Componentes Estruturais e Destaques

### 1. HeroBanner (`src/components/HeroBanner.tsx`)
- Carrossel automático com transição suave a cada 5 segundos;
- Imagens reais e otimizadas da loja física (`loja-mjg.jpeg`, `acessorios-mjg.jpeg`, banners de tela, bateria e conector);
- Botão primário com chamada para WhatsApp e mensagem personalizada (*"Olá, vim pelo site!"*);
- **Botão GPS de Alta Conversão:** Link direto para o Google Maps que abre o aplicativo do celular do cliente e já traça a rota até a loja.

### 2. Avaliações Reais do Google (`src/components/GoogleReviews.tsx`)
- Destaque da nota máxima **5,0 de 5,0 estrelas**;
- Depoimentos reais de clientes verificados de São Roque;
- Selo de *Perfil Verificado no Google Meu Negócio*;
- Link direto para a ficha oficial da MJG no Google Maps.

### 3. Layout Padrão e Botão Flutuante (`src/components/Layout.tsx`)
- Barra superior sticky com navegação rápida;
- Rodapé com endereço completo, horários e link discreto para a área administrativa (`/admin`);
- **Botão flutuante do WhatsApp:** Ícone oficial do WhatsApp compacto, fixado no canto inferior direito, com animação de hover e mensagem padrão pré-configurada.

---

## 🚀 Integração de Dados e Cache Busting

Para garantir que novos serviços, parceiros e celulares cadastrados no painel administrativo apareçam imediatamente no site para qualquer usuário sem cache antigo:

```typescript
// Padrão adotado em todos os fetches do frontend
fetch("/api/servicos.php?t=" + Date.now(), { cache: "no-store" })
fetch("/api/parceiros.php?t=" + Date.now(), { cache: "no-store" })
fetch("/api/celulares.php?t=" + Date.now(), { cache: "no-store" })
```

Todos os endpoints possuem fallback com dados estáticos para garantir exibição impecável mesmo durante manutenções ou build local offline.
