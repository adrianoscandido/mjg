import { createFileRoute } from "@tanstack/react-router";
import { useState, useEffect } from "react";
import { WaButton } from "@/components/Layout";
import { services as defaultServices } from "@/lib/site";

export const Route = createFileRoute("/servicos")({
  head: () => ({
    meta: [
      { title: "Serviços de Conserto de Celular | MJG Assistech & Imports" },
      { name: "description", content: "Troca de tela, bateria, conector de carga, reparo avançado de placa e desbloqueios em São Roque com garantia e agilidade." },
      { property: "og:title", content: "Serviços de Conserto de Celular | MJG Assistech & Imports" },
      { property: "og:description", content: "Troca de tela, bateria, conector de carga, reparo de placa e desbloqueios para Apple, Samsung, Motorola e Xiaomi em São Roque." },
      { property: "og:image", content: "https://mjgimports.com.br/og-image.jpg" },
      { property: "og:image:secure_url", content: "https://mjgimports.com.br/og-image.jpg" },
      { property: "og:url", content: "https://mjgimports.com.br/servicos" },
      { property: "og:type", content: "website" },
      { name: "twitter:card", content: "summary_large_image" },
      { name: "twitter:image", content: "https://mjgimports.com.br/og-image.jpg" },
    ],
  }),
  component: Servicos,
});

type ServicoItem = {
  id?: number;
  title: string;
  desc: string;
  icon: string;
};

function Servicos() {
  const [items, setItems] = useState<ServicoItem[]>(defaultServices);

  useEffect(() => {
    fetch("/api/servicos.php?t=" + Date.now(), { cache: "no-store" })
      .then((res) => res.json())
      .then((res) => {
        if (res?.ok && Array.isArray(res.dados) && res.dados.length > 0) {
          setItems(
            res.dados.map((d: any) => ({
              id: d.id,
              title: d.titulo,
              desc: d.descricao,
              icon: d.icone || "🛠️",
            }))
          );
        }
      })
      .catch(() => {
        // Fallback para lista padrão caso API esteja offline
      });
  }, []);

  return (
    <section className="mx-auto max-w-6xl px-4 py-14">
      <h1 className="font-display text-6xl text-primary">Serviços</h1>
      <p className="mt-2 text-muted-foreground">Toque no serviço para pedir orçamento pelo WhatsApp.</p>
      <div className="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        {items.map((s, idx) => (
          <div key={s.id || s.title || idx} className="flex flex-col rounded-2xl border bg-card p-6 shadow-sm">
            <div className="text-4xl">{s.icon}</div>
            <h2 className="mt-3 text-2xl font-bold">{s.title}</h2>
            <p className="mt-2 flex-1 text-muted-foreground">{s.desc}</p>
            <div className="mt-5">
              <WaButton
                variant="outline"
                msg={`Olá, vim pelo site! Gostaria de um orçamento para ${s.title.toLowerCase()}.`}
              >
                Pedir orçamento
              </WaButton>
            </div>
          </div>
        ))}
      </div>
    </section>
  );
}
