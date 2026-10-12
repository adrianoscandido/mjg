import { ArrowUpRight, Star } from "lucide-react";
import { Button } from "@/components/ui/button";

// Public listing matched by business name and phone; snapshot dated 2026-09-14.
// Source: https://exa.ai/library/place/wvgbtyflhlv. Author names were not supplied.
const reviews = [
  { text: "Trabalho excelente, atensioso, total respeito com o cliente, responsável, pontualidade, preço justo...super recomendo 🙏", date: "25/09/2025" },
  { text: "Lugar com pessoas competentes e de muita confiança, entrega o serviço no dia marcado! Indico pra muitas pessoas! Podem confiar de olhos fechados!", date: "24/09/2025" },
  { text: "Otimo atendimento e produtos de qualidade!", date: "24/09/2025" },
];

export function GoogleReviews() {
  return (
    <section className="border-y bg-secondary">
      <div className="mx-auto max-w-6xl px-4 py-14">
        <div className="flex flex-wrap items-end justify-between gap-6">
          <div>
            <p className="text-sm font-bold uppercase text-accent">Avaliações no Google</p>
            <h2 className="mt-2 font-display text-5xl text-primary">Quem conhece, recomenda</h2>
            <div className="mt-4 flex flex-wrap items-center gap-3">
              <strong className="text-3xl text-primary">5,0 <span className="text-base font-normal text-muted-foreground">/ 5</span></strong>
              <span aria-label="5 estrelas" className="flex gap-1 text-accent">{Array.from({ length: 5 }, (_, i) => <Star key={i} className="h-5 w-5 fill-current" />)}</span>
              <span className="text-sm text-muted-foreground">34 avaliações</span>
            </div>
          </div>
          <Button asChild variant="outline" className="h-auto whitespace-normal px-5 py-3">
            <a href="https://share.google/R6z10tczepXL3CE9o" target="_blank" rel="noopener noreferrer">Ver avaliações no Google <ArrowUpRight /></a>
          </Button>
        </div>
        <div className="mt-8 grid gap-4 md:grid-cols-3">
          {reviews.map((review) => (
            <figure key={review.text} className="flex flex-col rounded-lg border bg-card p-6">
              <span aria-label="5 estrelas" className="flex gap-1 text-accent">{Array.from({ length: 5 }, (_, i) => <Star key={i} className="h-4 w-4 fill-current" />)}</span>
              <blockquote className="mt-4 flex-1 text-base leading-7">“{review.text}”</blockquote>
              <figcaption className="mt-5 border-t pt-4 text-xs text-muted-foreground">Avaliação pública · {review.date}</figcaption>
            </figure>
          ))}
        </div>
        <p className="mt-5 text-xs text-muted-foreground">Nota e comentários do registro público de setembro de 2026. Consulte as avaliações mais recentes no Google.</p>
      </div>
    </section>
  );
}