import { createFileRoute } from "@tanstack/react-router";
import { WaButton } from "@/components/Layout";
import { ADDRESS, PHONE_DISPLAY, MAPS_URL, MAPS_EMBED_URL } from "@/lib/site";
import { MapPin, Navigation } from "lucide-react";

export const Route = createFileRoute("/contato")({
  head: () => ({
    meta: [
      { title: "Fale Conosco | MJG Assistech & Imports São Roque" },
      { name: "description", content: "WhatsApp (11) 99803-7170 · Av. Jaboticabal, 347 – Vila Nova, São Roque. Fale com a equipe da MJG Assistech & Imports." },
      { property: "og:title", content: "Fale Conosco | MJG Assistech & Imports" },
      { property: "og:description", content: "Atendimento no WhatsApp (11) 99803-7170 ou venha visitar nossa loja física em São Roque." },
      { property: "og:image", content: "https://mjgimports.com.br/og-image.jpg" },
      { property: "og:image:secure_url", content: "https://mjgimports.com.br/og-image.jpg" },
      { property: "og:url", content: "https://mjgimports.com.br/contato" },
      { property: "og:type", content: "website" },
      { name: "twitter:card", content: "summary_large_image" },
      { name: "twitter:image", content: "https://mjgimports.com.br/og-image.jpg" },
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
        <div className="mt-8 flex flex-wrap gap-4">
          <WaButton msg="Olá, vim pelo site!">💬 Chamar no WhatsApp</WaButton>
          <a
            href={MAPS_URL}
            target="_blank"
            rel="noopener noreferrer"
            className="inline-flex items-center justify-center gap-2 rounded-xl border-2 border-primary px-5 py-4 font-bold text-primary transition hover:bg-primary hover:text-primary-foreground"
          >
            <Navigation className="h-5 w-5" /> Abrir no Google Maps
          </a>
        </div>
      </div>
      <div className="flex flex-col gap-2">
        <iframe
          title="Localização MJG Assistência Técnica no Google Maps"
          className="h-80 w-full rounded-2xl border md:h-full min-h-[350px]"
          loading="lazy"
          src={MAPS_EMBED_URL}
        />
        <a
          href={MAPS_URL}
          target="_blank"
          rel="noopener noreferrer"
          className="inline-flex items-center gap-1 text-sm font-semibold text-accent hover:underline"
        >
          <MapPin className="h-4 w-4" /> Ver perfil da MJG no Google Maps (ID: 16599107455903459186)
        </a>
      </div>
    </section>
  );
}
