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
      { title: "MJG Assistech & Imports | Conserto de celular em São Roque" },
      { name: "description", content: "Troca de tela, bateria, conector, reparo de placa, desbloqueio e venda de celulares novos e seminovos em São Roque." },
      { property: "og:title", content: "MJG Assistech & Imports | Conserto de celular" },
      { property: "og:description", content: "Assistência técnica de celulares e venda de aparelhos em Vila Nova – São Roque." },
      { property: "og:type", content: "website" },
      { name: "twitter:card", content: "summary_large_image" },
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

      <section className="mx-auto max-w-6xl px-4 py-16 text-center">
        <h2 className="font-display text-5xl text-primary">Celular com problema?</h2>
        <p className="mt-2 text-muted-foreground">Fale agora com a gente e resolva hoje mesmo.</p>
        <div className="mt-6"><WaButton msg="Olá, vim pelo site!">💬 Falar no WhatsApp</WaButton></div>
      </section>
    </>
  );
}
