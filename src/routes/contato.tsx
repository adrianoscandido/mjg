import { createFileRoute } from "@tanstack/react-router";
import { WaButton } from "@/components/Layout";
import { ADDRESS, PHONE_DISPLAY } from "@/lib/site";

export const Route = createFileRoute("/contato")({
  head: () => ({
    meta: [
      { title: "Contato | MJG Assistech & Imports" },
      { name: "description", content: "WhatsApp (11) 99803-7170 · Vila Nova – São Roque. Fale com a MJG Assistech & Imports." },
      { property: "og:title", content: "Contato | MJG Assistech & Imports" },
      { property: "og:description", content: "Fale conosco pelo WhatsApp ou visite nossa loja em São Roque." },
    ],
  }),
  component: Contato,
});

function Contato() {
  return (
    <section className="mx-auto grid max-w-6xl gap-8 px-4 py-14 md:grid-cols-2">
      <div>
        <h1 className="font-display text-6xl text-primary">Contato</h1>
        <div className="mt-6 space-y-4 text-lg">
          <p><strong>WhatsApp:</strong> {PHONE_DISPLAY}</p>
          <p><strong>Endereço:</strong> {ADDRESS}</p>
          <p><strong>Horário:</strong> Segunda a sábado (confirme pelo WhatsApp)</p>
        </div>
        <div className="mt-8"><WaButton msg="Olá! Vim pelo site.">💬 Chamar no WhatsApp</WaButton></div>
      </div>
      <iframe title="Mapa" className="h-80 w-full rounded-2xl border md:h-full" loading="lazy"
        src="https://www.google.com/maps?q=Vila+Nova,+S%C3%A3o+Roque,+SP&output=embed" />
    </section>
  );
}
