import { createFileRoute } from "@tanstack/react-router";
import { useState, useEffect } from "react";
import { WaButton } from "@/components/Layout";
import { brands, brl, phones as defaultPhones, type Phone } from "@/lib/site";

export const Route = createFileRoute("/celulares")({
  head: () => ({
    meta: [
      { title: "Celulares novos e seminovos | MJG Imports" },
      { name: "description", content: "Compre celulares novos e seminovos Apple, Samsung, Motorola e Xiaomi em São Roque." },
      { property: "og:title", content: "Celulares à venda | MJG Imports" },
      { property: "og:description", content: "Aparelhos novos e seminovos com atendimento pelo WhatsApp." },
      { property: "og:type", content: "website" },
      { name: "twitter:card", content: "summary_large_image" },
    ],
  }),
  component: Celulares,
});

const chip = (on: boolean) =>
  `rounded-full border px-4 py-2 text-sm font-semibold transition ${on ? "border-primary bg-primary text-primary-foreground" : "bg-card text-foreground hover:border-primary"}`;

function Celulares() {
  const [items, setItems] = useState<Phone[]>(defaultPhones);
  const [cond, setCond] = useState("Todos");
  const [brand, setBrand] = useState("Todas");

  useEffect(() => {
    fetch("/api/celulares.php")
      .then((res) => res.json())
      .then((res) => {
        if (res?.ok && Array.isArray(res.dados) && res.dados.length > 0) {
          setItems(
            res.dados.map((d: any) => ({
              name: d.nome,
              brand: d.marca,
              condition: d.condicao as "Novo" | "Seminovo",
              storage: d.armazenamento,
              price: parseFloat(d.preco),
            }))
          );
        }
      })
      .catch(() => {});
  }, []);

  const list = items.filter((p) => (cond === "Todos" || p.condition === cond) && (brand === "Todas" || p.brand === brand));
  return (
    <section className="mx-auto max-w-6xl px-4 py-14">
      <h1 className="font-display text-6xl text-primary">Celulares à venda</h1>
      <div className="mt-6 flex flex-wrap gap-2">
        {["Todos", "Novo", "Seminovo"].map((c) => <button key={c} className={chip(cond === c)} onClick={() => setCond(c)}>{c}</button>)}
      </div>
      <div className="mt-3 flex flex-wrap gap-2">
        {["Todas", ...brands].map((b) => <button key={b} className={chip(brand === b)} onClick={() => setBrand(b)}>{b}</button>)}
      </div>
      <div className="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        {list.map((p) => (
          <div key={p.name + p.condition} className="flex flex-col rounded-2xl border bg-card p-5 shadow-sm">
            <div className="flex h-36 items-center justify-center rounded-xl bg-secondary text-6xl">📱</div>
            <span className={`mt-4 w-fit rounded-full px-3 py-1 text-xs font-bold ${p.condition === "Novo" ? "bg-accent text-accent-foreground" : "bg-secondary text-secondary-foreground"}`}>{p.condition}</span>
            <h2 className="mt-2 text-xl font-bold">{p.name}</h2>
            <p className="text-sm text-muted-foreground">{p.brand} · {p.storage}</p>
            <p className="mt-3 flex-1 text-2xl font-bold text-primary">{brl(p.price)}</p>
            <div className="mt-4"><WaButton variant="outline" msg={`Olá, vim pelo site! Tenho interesse no ${p.name} ${p.storage} (${p.condition}).`}>Tenho interesse</WaButton></div>
          </div>
        ))}
        {list.length === 0 && <p className="text-muted-foreground">Nenhum aparelho com esse filtro. Fale conosco no WhatsApp!</p>}
      </div>
    </section>
  );
}
