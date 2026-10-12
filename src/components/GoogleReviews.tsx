import { ArrowUpRight, CheckCircle2, Star } from "lucide-react";
import { Button } from "@/components/ui/button";
import { MAPS_URL } from "@/lib/site";

const reviews = [
  {
    author: "Sol Santos",
    text: "Lugar com pessoas competentes e de muita confiança, entrega o serviço no dia marcado! Indico pra muitas pessoas! Podem confiar de olhos fechados!",
    date: "Avaliação no Google",
  },
  {
    author: "Viviane Firmino Sala",
    text: "Trabalho excelente, atencioso, total respeito com o cliente, responsável, pontualidade, preço justo... super recomendo.",
    date: "Avaliação no Google",
  },
  {
    author: "Marciel Santos",
    text: "Ótimo profissional... Preço justo e rápido no serviço.... Recomendo.",
    date: "Avaliação no Google",
  },
  {
    author: "Patrícia Alves",
    text: "Excelente atendimento. Serviço honesto e preço justo.",
    date: "Avaliação no Google",
  },
  {
    author: "Evelin Santos",
    text: "A melhor, pessoas educadas, atendimento e serviço nota mil!!",
    date: "Avaliação no Google",
  },
  {
    author: "Aline Silva",
    text: "Melhor assistência técnica de São Roque.",
    date: "Avaliação no Google",
  },
];

export function GoogleReviews() {
  return (
    <section className="border-y bg-secondary/50">
      <div className="mx-auto max-w-6xl px-4 py-16">
        <div className="flex flex-wrap items-end justify-between gap-6">
          <div>
            <p className="text-sm font-bold uppercase tracking-wider text-accent">Avaliações Reais no Google</p>
            <h2 className="mt-2 font-display text-5xl text-primary">Quem conhece, recomenda</h2>
            <div className="mt-4 flex flex-wrap items-center gap-3">
              <strong className="text-4xl font-extrabold text-primary">5,0 <span className="text-base font-normal text-muted-foreground">/ 5.0</span></strong>
              <div className="flex flex-col gap-0.5">
                <span aria-label="5 estrelas" className="flex gap-1 text-accent">
                  {Array.from({ length: 5 }, (_, i) => <Star key={i} className="h-5 w-5 fill-current" />)}
                </span>
                <span className="text-xs font-semibold text-muted-foreground flex items-center gap-1">
                  <CheckCircle2 className="h-3.5 w-3.5 text-emerald-500 inline" /> Perfil Verificado no Google Meu Negócio
                </span>
              </div>
            </div>
          </div>
          <div className="flex flex-wrap gap-3">
            <Button asChild variant="outline" className="h-auto whitespace-normal rounded-xl border-primary/30 px-5 py-3 hover:bg-primary/5">
              <a href={MAPS_URL} target="_blank" rel="noopener noreferrer">
                Ver avaliações no Google <ArrowUpRight className="ml-1 h-4 w-4" />
              </a>
            </Button>
          </div>
        </div>

        <div className="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
          {reviews.map((review) => (
            <figure key={review.author} className="flex flex-col justify-between rounded-2xl border bg-card p-6 shadow-sm transition hover:shadow-md">
              <div>
                <div className="flex items-center justify-between gap-2">
                  <div className="flex items-center gap-3">
                    <div className="flex h-10 w-10 items-center justify-center rounded-full bg-primary/10 font-bold text-primary">
                      {review.author.charAt(0)}
                    </div>
                    <div>
                      <figcaption className="text-sm font-bold text-foreground">{review.author}</figcaption>
                      <span className="text-xs text-muted-foreground">{review.date}</span>
                    </div>
                  </div>
                  <span aria-label="5 estrelas" className="flex gap-0.5 text-accent">
                    {Array.from({ length: 5 }, (_, i) => <Star key={i} className="h-4 w-4 fill-current" />)}
                  </span>
                </div>
                <blockquote className="mt-4 text-sm leading-6 text-muted-foreground">
                  “{review.text}”
                </blockquote>
              </div>
            </figure>
          ))}
        </div>

        <div className="mt-8 flex flex-wrap items-center justify-between gap-4 rounded-xl border border-primary/20 bg-primary/5 p-4 text-sm text-muted-foreground">
          <p>
            Todas as avaliações acima são de clientes reais registradas publicamente no perfil da <strong>MJG Assistência Técnica</strong> no Google.
          </p>
          <a
            href={MAPS_URL}
            target="_blank"
            rel="noopener noreferrer"
            className="font-bold text-accent hover:underline inline-flex items-center gap-1 shrink-0"
          >
            Conferir perfil no Google Maps →
          </a>
        </div>
      </div>
    </section>
  );
}