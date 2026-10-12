import { createFileRoute, Link } from "@tanstack/react-router";
import { useState, useEffect } from "react";
import { HeroBanner } from "@/components/HeroBanner";
import { WaButton } from "@/components/Layout";
import { ADDRESS, brands, services as defaultServices, MAPS_DIRECTIONS_URL } from "@/lib/site";
import loja from "@/assets/loja-mjg.jpeg";
import acessorios from "@/assets/acessorios-mjg.jpeg";
import { GoogleReviews } from "@/components/GoogleReviews";

export const Route = createFileRoute("/")({
  head: () => ({
    meta: [
      { title: "MJG Assistech & Imports | Assistência Técnica de Celulares em São Roque" },
      {
        name: "description",
        content:
          "Conserto de celulares em São Roque: troca de tela, bateria, conector de carga e reparo de placa. Celulares novos e seminovos com garantia e acessórios. Peça seu orçamento pelo WhatsApp!",
      },
      { property: "og:site_name", content: "MJG Assistech & Imports" },
      { property: "og:type", content: "website" },
      { property: "og:url", content: "https://mjgimports.com.br/" },
      { property: "og:title", content: "MJG Assistech & Imports | Assistência Técnica de Celulares em São Roque" },
      {
        property: "og:description",
        content:
          "Conserto de celulares em São Roque: troca de tela, bateria, conector de carga e reparo de placa. Celulares novos e seminovos com garantia e acessórios. Peça seu orçamento pelo WhatsApp!",
      },
      { property: "og:image", content: "https://mjgimports.com.br/og-image.jpg" },
      { property: "og:image:secure_url", content: "https://mjgimports.com.br/og-image.jpg" },
      { property: "og:image:type", content: "image/jpeg" },
      { property: "og:image:width", content: "1200" },
      { property: "og:image:height", content: "630" },
      { property: "og:image:alt", content: "MJG Assistech & Imports - Conserto de Celular em São Roque" },
      { name: "twitter:card", content: "summary_large_image" },
      { name: "twitter:title", content: "MJG Assistech & Imports | Assistência Técnica de Celulares em São Roque" },
      {
        name: "twitter:description",
        content:
          "Conserto de celulares em São Roque: troca de tela, bateria, conector e placa. Celulares novos e seminovos e acessórios. Orçamento rápido pelo WhatsApp!",
      },
      { name: "twitter:image", content: "https://mjgimports.com.br/og-image.jpg" },
    ],
  }),
  component: Index,
});

type ServicoCard = {
  id?: number;
  title: string;
  desc: string;
  icon: string;
};

function Index() {
  const [serviceList, setServiceList] = useState<ServicoCard[]>(defaultServices);

  useEffect(() => {
    fetch("/api/servicos.php?t=" + Date.now(), { cache: "no-store" })
      .then((res) => res.json())
      .then((res) => {
        if (res?.ok && Array.isArray(res.dados) && res.dados.length > 0) {
          setServiceList(
            res.dados.map((d: any) => ({
              id: d.id,
              title: d.titulo,
              desc: d.descricao,
              icon: d.icone || "🛠️",
            }))
          );
        }
      })
      .catch(() => {});
  }, []);

  return (
    <>
      <HeroBanner />

      <section className="border-b bg-card">
        <div className="mx-auto flex max-w-6xl flex-wrap items-center justify-center gap-x-10 gap-y-3 px-4 py-6">
          <span className="text-sm font-semibold text-muted-foreground">Atendemos:</span>
          {brands.map((b) => <span key={b} className="font-display text-2xl text-primary">{b}</span>)}
        </div>
      </section>

      <section className="mx-auto max-w-6xl px-4 py-16">
        <h2 className="font-display text-5xl text-primary">Nossos serviços</h2>
        <div className="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
          {serviceList.slice(0, 8).map((s, idx) => (
            <div key={s.id || s.title || idx} className="rounded-2xl border bg-card p-6 shadow-sm">
              <div className="text-4xl">{s.icon}</div>
              <h3 className="mt-3 text-xl font-bold">{s.title}</h3>
              <p className="mt-2 text-muted-foreground">{s.desc}</p>
            </div>
          ))}
        </div>
        <Link to="/servicos" className="mt-6 inline-block font-bold text-accent">Ver todos os serviços →</Link>
      </section>

      <section className="bg-secondary">
        <div className="mx-auto grid max-w-6xl gap-6 px-4 py-16 md:grid-cols-3">
          {[["Orçamento rápido", "Mande uma mensagem e receba o valor pelo WhatsApp."], ["Peças de qualidade", "Trabalhamos com componentes confiáveis para cada modelo."], ["Atendimento local", ADDRESS]].map(([t, d]) => (
            <div key={t}><h3 className="font-display text-3xl text-primary">{t}</h3><p className="mt-1 text-muted-foreground">{d}</p></div>
          ))}
        </div>
      </section>

      <GoogleReviews />

      <section className="mx-auto max-w-6xl px-4 py-16">
        <p className="text-sm font-bold uppercase text-accent">Aqui em São Roque</p>
        <h2 className="mt-2 font-display text-5xl text-primary">Conheça a MJG</h2>
        <p className="mt-3 max-w-xl text-muted-foreground">Sua assistência técnica e loja de acessórios na {ADDRESS}. Venha conhecer a gente.</p>
        <div className="mt-3">
          <a
            href={MAPS_DIRECTIONS_URL}
            target="_blank"
            rel="noopener noreferrer"
            className="inline-flex items-center gap-2 font-bold text-accent hover:underline"
          >
            📍 Como Chegar via GPS (Google Maps) →
          </a>
        </div>
        <div className="mt-8 grid grid-cols-2 gap-3 md:gap-6">
          <figure>
            <img src={loja} alt="Entrada da loja MJG Assistech & Imports em São Roque" loading="lazy" width={768} height={1366} className="aspect-[3/4] w-full rounded-lg object-cover" />
            <figcaption className="mt-3 font-semibold">Nossa loja</figcaption>
          </figure>
          <figure>
            <img src={acessorios} alt="Capinhas de diferentes cores disponíveis na loja MJG" loading="lazy" width={768} height={1366} className="aspect-[3/4] w-full rounded-lg object-cover" />
            <figcaption className="mt-3 font-semibold">Capinhas e acessórios</figcaption>
          </figure>
        </div>
      </section>

      {/* BANNER DE PARCEIROS E SERVIÇOS */}
      <section className="mx-auto max-w-6xl px-4 py-8">
        <div className="relative overflow-hidden rounded-3xl border border-primary/30 bg-gradient-to-br from-card via-card/95 to-primary/10 p-8 sm:p-12 shadow-2xl">
          {/* Luz decorativa de fundo */}
          <div className="pointer-events-none absolute -right-20 -top-20 h-72 w-72 rounded-full bg-primary/15 blur-3xl" />
          <div className="pointer-events-none absolute -left-20 -bottom-20 h-72 w-72 rounded-full bg-accent/15 blur-3xl" />

          <div className="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-8">
            <div className="max-w-2xl space-y-3">
              <div className="inline-flex items-center gap-2 rounded-full bg-accent/15 px-3.5 py-1 text-xs font-bold uppercase tracking-wider text-accent border border-accent/30">
                <span>🤝</span> Rede de Confiança MJG
              </div>
              <h2 className="font-display text-4xl sm:text-5xl text-primary leading-tight">
                Conheça nossos parceiros e serviços
              </h2>
              <p className="text-base sm:text-lg text-muted-foreground leading-relaxed">
                Além de consertos especializados de smartphones, conectamos você a profissionais e empresas de total confiança em <strong>segurança eletrônica (CFTV)</strong>, <strong>películas e capinhas personalizadas</strong>, <strong>infraestrutura de redes</strong> e muito mais.
              </p>
              <div className="pt-2 flex flex-wrap gap-2.5">
                <span className="inline-flex items-center gap-1.5 rounded-lg bg-card/80 px-3 py-1.5 text-xs font-medium text-foreground border border-border shadow-sm">
                  📹 Câmeras de Monitoramento & Alarme
                </span>
                <span className="inline-flex items-center gap-1.5 rounded-lg bg-card/80 px-3 py-1.5 text-xs font-medium text-foreground border border-border shadow-sm">
                  🎨 Películas de Alta Proteção & Capas
                </span>
                <span className="inline-flex items-center gap-1.5 rounded-lg bg-card/80 px-3 py-1.5 text-xs font-medium text-foreground border border-border shadow-sm">
                  📶 Cabeamento & Redes Wi-Fi
                </span>
              </div>
            </div>

            <div className="shrink-0 flex flex-col sm:flex-row md:flex-col gap-3">
              <a
                href="/servicos#parceiros"
                className="inline-flex items-center justify-center gap-2 rounded-2xl bg-accent px-6 py-4 font-bold text-accent-foreground shadow-lg hover:brightness-110 active:scale-95 transition-all text-center"
              >
                <span>🤝</span> Ver Serviços de Parceiros →
              </a>
              <Link
                to="/servicos"
                className="inline-flex items-center justify-center gap-2 rounded-2xl border border-primary/40 bg-primary/10 px-6 py-3.5 text-sm font-bold text-primary hover:bg-primary/20 transition-all text-center"
              >
                🛠️ Todos os Serviços MJG
              </Link>
            </div>
          </div>
        </div>
      </section>

      <section className="mx-auto max-w-6xl px-4 py-16 text-center">
        <h2 className="font-display text-5xl text-primary">Celular com problema?</h2>
        <p className="mt-2 text-muted-foreground">Fale agora com a gente e resolva hoje mesmo.</p>
        <div className="mt-6"><WaButton msg="Olá, vim pelo site!">💬 Falar no WhatsApp</WaButton></div>
      </section>
    </>
  );
}
