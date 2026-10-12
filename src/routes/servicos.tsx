import { createFileRoute } from "@tanstack/react-router";
import { WaButton } from "@/components/Layout";
import { services } from "@/lib/site";

export const Route = createFileRoute("/servicos")({
  head: () => ({
    meta: [
      { title: "Serviços | MJG Assistech & Imports" },
      { name: "description", content: "Troca de tela, bateria e conector, reparo de placa, desbloqueio e manutenção de celulares em São Roque." },
      { property: "og:title", content: "Serviços de conserto de celular | MJG" },
      { property: "og:description", content: "Todos os serviços de assistência técnica para Samsung, Apple, Motorola, Xiaomi e LG." },
    ],
  }),
  component: Servicos,
});

function Servicos() {
  return (
    <section className="mx-auto max-w-6xl px-4 py-14">
      <h1 className="font-display text-6xl text-primary">Serviços</h1>
      <p className="mt-2 text-muted-foreground">Toque no serviço para pedir orçamento pelo WhatsApp.</p>
      <div className="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        {services.map((s) => (
          <div key={s.title} className="flex flex-col rounded-2xl border bg-card p-6 shadow-sm">
            <div className="text-4xl">{s.icon}</div>
            <h2 className="mt-3 text-2xl font-bold">{s.title}</h2>
            <p className="mt-2 flex-1 text-muted-foreground">{s.desc}</p>
            <div className="mt-5"><WaButton variant="outline" msg={`Olá! Gostaria de um orçamento de ${s.title.toLowerCase()}.`}>Pedir orçamento</WaButton></div>
          </div>
        ))}
      </div>
    </section>
  );
}
