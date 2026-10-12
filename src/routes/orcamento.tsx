import { createFileRoute } from "@tanstack/react-router";
import { useState } from "react";
import { brands, services, waLink } from "@/lib/site";

export const Route = createFileRoute("/orcamento")({
  head: () => ({
    meta: [
      { title: "Orçamento grátis | MJG Assistech & Imports" },
      { name: "description", content: "Peça orçamento de conserto do seu celular pelo WhatsApp em poucos segundos." },
      { property: "og:title", content: "Orçamento de conserto de celular | MJG" },
      { property: "og:description", content: "Informe marca, modelo e problema e receba o valor pelo WhatsApp." },
    ],
  }),
  component: Orcamento,
});

const field = "mt-1 w-full rounded-xl border bg-card px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-ring";

function Orcamento() {
  const [f, setF] = useState({ nome: "", marca: brands[0], modelo: "", servico: services[0].title, problema: "" });
  const set = (k: keyof typeof f) => (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement>) => setF({ ...f, [k]: e.target.value });
  const submit = (e: React.FormEvent) => {
    e.preventDefault();
    const msg = `Olá! Meu nome é ${f.nome}.\nGostaria de um orçamento:\nAparelho: ${f.marca} ${f.modelo}\nServiço: ${f.servico}\nProblema: ${f.problema}`;
    window.open(waLink(msg), "_blank");
  };
  return (
    <section className="mx-auto max-w-xl px-4 py-14">
      <h1 className="font-display text-6xl text-primary">Orçamento</h1>
      <p className="mt-2 text-muted-foreground">Preencha e envie direto pelo WhatsApp.</p>
      <form onSubmit={submit} className="mt-8 space-y-4">
        <label className="block font-semibold">Seu nome<input required className={field} value={f.nome} onChange={set("nome")} /></label>
        <label className="block font-semibold">Marca<select className={field} value={f.marca} onChange={set("marca")}>{[...brands, "Outra"].map((b) => <option key={b}>{b}</option>)}</select></label>
        <label className="block font-semibold">Modelo<input required placeholder="Ex: Galaxy A32, iPhone 11" className={field} value={f.modelo} onChange={set("modelo")} /></label>
        <label className="block font-semibold">Serviço<select className={field} value={f.servico} onChange={set("servico")}>{[...services.map((s) => s.title), "Não sei"].map((s) => <option key={s}>{s}</option>)}</select></label>
        <label className="block font-semibold">Descreva o problema<textarea rows={4} className={field} value={f.problema} onChange={set("problema")} /></label>
        <button type="submit" className="w-full rounded-xl bg-accent py-4 text-lg font-bold text-accent-foreground shadow-glow hover:brightness-110">💬 Enviar pelo WhatsApp</button>
      </form>
    </section>
  );
}
