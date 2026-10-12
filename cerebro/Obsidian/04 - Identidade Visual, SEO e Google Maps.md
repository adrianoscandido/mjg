# 📍 04 - Identidade Visual, SEO e Google Maps

## 🗺️ Integração com Google Meu Negócio e Google Maps

A integração foi configurada para apontar exatamente para o ponto físico oficial da loja em São Roque:

- **CID Oficial da Loja:** `8840866417741061658`
- **ID do Maps:** `16599107455903459186`
- **Link Fixo no Google Maps:** `https://www.google.com/maps?cid=8840866417741061658`
- **Link de Traçar Rota via GPS:**
  `https://www.google.com/maps/dir/?api=1&destination=MJG+Assist%C3%AAncia+T%C3%A9cnica+de+Celulares,+Av.+Jaboticabal,+347+-+Vila+Nova,+S%C3%A3o+Roque+-+SP`
- **Implementação no HeroBanner:** Botão destacado com ícone de pin do GPS (`Como Chegar (GPS)`) para direcionar clientes que chegam de carro ou a pé diretamente à loja.

---

## ⭐ Avaliações Reais no Google (5,0 Estrelas)

Em `src/components/GoogleReviews.tsx`, as avaliações foram sincronizadas com os depoimentos reais de clientes verificados:
- **Sol Santos:** *"Lugar com pessoas competentes e de muita confiança, entrega o serviço no dia marcado! Indico pra muitas pessoas! Podem confiar de olhos fechados!"*
- **Viviane Firmino Sala:** *"Trabalho excelente, atencioso, total respeito com o cliente, responsável, pontualidade, preço justo... super recomendo."*
- **Marciel Santos:** *"Ótimo profissional... Preço justo e rápido no serviço.... Recomendo."*
- **Patrícia Alves:** *"Excelente atendimento. Serviço honesto e preço justo."*
- **Evelin Santos:** *"A melhor, pessoas educadas, atendimento e serviço nota mil!!"*
- **Aline Silva:** *"Melhor assistência técnica de São Roque."*

---

## 💬 Padrão de Atendimento WhatsApp

- **Número Oficial:** `(11) 99803-7170` (DDI 55: `5511998037170`)
- **Frase de Ativação:** `"Olá, vim pelo site!"`
- **Design do Botão Flutuante:** Ícone oficial do WhatsApp compacto (48x48px com bordas arredondadas e sombra suave), posicionado no canto inferior direito sem poluição visual.

---

## 🎨 Logotipo e Brand Assets PWA

Os assets da marca foram criados com padrão visual sofisticado (fundo escuro azul-noite `#090d16`, monograma **MJG** em amarelo vibrante `#f59e0b` e subtítulo em ciano elétrico `#38bdf8`):

- `public/favicon.svg`: Vetor SVG oficial nítido em qualquer resolução.
- `public/favicon.ico`: Ícone clássico para compatibilidade total de navegadores.
- `public/apple-touch-icon.png`: Ícone 180x180 para dispositivos iOS/iPhone.
- `public/icon-192.png`: Ícone PWA de alta definição 192x192.
- `public/icon-512.png`: Ícone de inicialização PWA 512x512.
- `public/og-image.jpg`: Imagem oficial de compartilhamento no WhatsApp, Facebook e Twitter (1200x630px).
