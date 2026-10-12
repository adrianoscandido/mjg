import { createFileRoute } from "@tanstack/react-router";
import { HeroBanner } from "@/components/HeroBanner";
import { WaButton } from "@/components/Layout";
import { ADDRESS, brands, services } from "@/lib/site";

export const Route = createFileRoute("/")({
  head: () => ({
    meta: [
      { title: "MJG Assistech & Imports | Conserto de celular em São Roque" },
      { name: "description", content: "Troca de tela, bateria, conector, reparo de placa, desbloqueio e venda de celulares novos e seminovos em São Roque." },
      { property: "og:title", content: "MJG Assistech & Imports | Conserto de celular" },
      { property: "og:description", content: "Assistência técnica de celulares e venda de aparelhos em Vila Nova – São Roque." },
    ],
  }),
  component: Index,
});

function Index() {
  return (
    <>
      <section className="relative overflow-hidden bg-primary">
        <img src={hero} alt="Técnico consertando celular" width={1280} height={960} className="absolute inset-0 h-full w-full object-cover opacity-30" />
        <div className="relative mx-auto max-w-6xl px-4 py-20 md:py-32">
          <p className="font-bold uppercase tracking-widest text-accent-bright">Assistência técnica de celulares</p>
          <h1 className="mt-3 max-w-2xl font-display text-6xl leading-none text-primary-foreground md:text-8xl">Seu celular de volta em perfeitas condições</h1>
          <p className="mt-5 max-w-xl text-lg text-primary-foreground/85">Tela, bateria, conector, placa e desbloqueio. Também vendemos celulares novos e seminovos.</p>
          <div className="mt-8 flex flex-col gap-3 sm:flex-row">
            <WaButton msg="Olá! Gostaria de um orçamento para meu celular.">💬 Pedir orçamento no WhatsApp</WaButton>
            <Link to="/celulares" className="inline-flex items-center justify-center rounded-xl border-2 border-primary-foreground/40 px-6 py-4 text-lg font-bold text-primary-foreground hover:bg-primary-foreground/10">Ver celulares à venda</Link>
          </div>
        </div>
      </section>

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

      <section className="mx-auto max-w-6xl px-4 py-16 text-center">
        <h2 className="font-display text-5xl text-primary">Celular com problema?</h2>
        <p className="mt-2 text-muted-foreground">Fale agora com a gente e resolva hoje mesmo.</p>
        <div className="mt-6"><WaButton msg="Olá! Meu celular está com problema.">💬 Falar no WhatsApp</WaButton></div>
      </section>
    </>
  );
}
