import { createFileRoute, Link } from "@tanstack/react-router";
import { HeroBanner } from "@/components/HeroBanner";
import { WaButton } from "@/components/Layout";
import { ADDRESS, brands, services } from "@/lib/site";
import loja from "@/assets/loja-mjg.jpeg.asset.json";
import acessorios from "@/assets/acessorios-mjg.jpeg.asset.json";

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

function Index() {
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
          {services.slice(0, 4).map((s) => (
            <div key={s.title} className="rounded-2xl border bg-card p-6 shadow-sm">
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

      <section className="mx-auto max-w-6xl px-4 py-16">
        <p className="text-sm font-bold uppercase text-accent">Aqui em São Roque</p>
        <h2 className="mt-2 font-display text-5xl text-primary">Conheça a MJG</h2>
        <p className="mt-3 max-w-xl text-muted-foreground">Sua assistência técnica e loja de acessórios em {ADDRESS}. Venha conhecer a gente.</p>
        <div className="mt-8 grid grid-cols-2 gap-3 md:gap-6">
          <figure>
            <img src={loja.url} alt="Entrada da loja MJG Assistech & Imports em São Roque" loading="lazy" width={768} height={1366} className="aspect-[3/4] w-full rounded-lg object-cover" />
            <figcaption className="mt-3 font-semibold">Nossa loja</figcaption>
          </figure>
          <figure>
            <img src={acessorios.url} alt="Capinhas de diferentes cores disponíveis na loja MJG" loading="lazy" width={768} height={1366} className="aspect-[3/4] w-full rounded-lg object-cover" />
            <figcaption className="mt-3 font-semibold">Capinhas e acessórios</figcaption>
          </figure>
        </div>
      </section>

      <section className="mx-auto max-w-6xl px-4 py-16 text-center">
        <h2 className="font-display text-5xl text-primary">Celular com problema?</h2>
        <p className="mt-2 text-muted-foreground">Fale agora com a gente e resolva hoje mesmo.</p>
        <div className="mt-6"><WaButton msg="Olá! Meu celular está com problema.">💬 Falar no WhatsApp</WaButton></div>
      </section>
    </>
  );
}
