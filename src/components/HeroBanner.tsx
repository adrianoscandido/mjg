import { useEffect, useState } from "react";
import { Link } from "@tanstack/react-router";
import { ArrowUpRight, ChevronLeft, ChevronRight, MapPin, MessageCircle, Pause, Play } from "lucide-react";
import { Button } from "@/components/ui/button";
import loja from "@/assets/loja-mjg.jpeg";
import acessorios from "@/assets/acessorios-mjg.jpeg";
import bannerTela from "@/assets/banner-tela.jpg";
import bannerBateria from "@/assets/banner-bateria.jpg";
import bannerConector from "@/assets/banner-conector.jpg";
import { WaButton } from "@/components/Layout";
import { MAPS_DIRECTIONS_URL } from "@/lib/site";

const slides = [
  {
    img: loja,
    tag: "Assistência técnica em São Roque",
    title: "Seu celular em boas mãos.",
    desc: "Conserto de celulares, aparelhos novos e seminovos e acessórios. Fale com a MJG e peça seu orçamento.",
    waMsg: "Olá, vim pelo site!",
  },
  {
    img: bannerTela,
    tag: "Troca de tela",
    title: "Tela trincada? Deixa com a gente.",
    desc: "Troca de tela com peça de qualidade e garantia. Seu celular como novo novamente.",
    waMsg: "Olá, vim pelo site! Minha tela quebrou, gostaria de um orçamento para a troca de tela.",
  },
  {
    img: bannerBateria,
    tag: "Troca de bateria",
    title: "Bateria não dura o dia todo?",
    desc: "Trocamos a bateria do seu celular e a carga volta a durar como no primeiro dia.",
    waMsg: "Olá, vim pelo site! A bateria do meu celular está acabando rápido, gostaria de um orçamento para a troca.",
  },
  {
    img: bannerConector,
    tag: "Troca de conector",
    title: "Só carrega de um jeitinho?",
    desc: "Conector de carga frouxo ou sem funcionar? Reparamos e trocamos o conector do seu aparelho.",
    waMsg: "Olá, vim pelo site! Meu celular não carrega direito, gostaria de um orçamento para o conserto do conector.",
  },
  {
    img: acessorios,
    tag: "Capinhas e acessórios",
    title: "Proteção com a sua cara.",
    desc: "Capinhas, películas, cabos e carregadores. Consulte as opções para o seu modelo pelo WhatsApp.",
    waMsg: "Olá, vim pelo site! Gostaria de conhecer os acessórios disponíveis para meu celular.",
  },
];

const INTERVAL = 5000;

export function HeroBanner() {
  const [current, setCurrent] = useState(0);
  const [paused, setPaused] = useState(false);

  useEffect(() => {
    if (paused || window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;
    const id = setInterval(() => setCurrent((c) => (c + 1) % slides.length), INTERVAL);
    return () => clearInterval(id);
  }, [paused]);

  const slide = slides[current % slides.length];
  if (!slide) return null;

  return (
    <section aria-roledescription="carrossel" aria-label="MJG: loja e serviços" className="relative isolate overflow-hidden bg-primary">
      {slides.map((s, i) => (
        <img
          key={s.tag}
          src={s.img}
          alt={i === 0 ? "Fachada da MJG Assistech & Imports" : s.tag}
          loading={i === 0 ? "eager" : "lazy"}
          className={
            "absolute inset-0 h-full w-full object-cover object-[center_35%] transition-opacity duration-700 motion-reduce:transition-none " +
            (i === current ? "opacity-100" : "opacity-0")
          }
        />
      ))}
      <div className="absolute inset-0 bg-hero-shade" />
      <div className="relative mx-auto max-w-6xl px-5 py-12 md:py-16">
        <p className="mb-6 font-display text-2xl text-primary-foreground">MJG <span className="text-accent-bright">Assistech & Imports</span></p>
        <p className="text-sm font-bold uppercase text-accent-bright">
          {slide.tag}
        </p>
        <h1 className="mt-3 min-h-[144px] max-w-xl font-display text-5xl leading-none text-primary-foreground sm:min-h-[144px] sm:text-7xl md:min-h-[160px] md:text-8xl">
          {slide.title}
        </h1>
        <p className="mt-4 min-h-[84px] max-w-md text-base leading-7 text-primary-foreground/90 sm:text-lg">
          {slide.desc}
        </p>
        <div className="mt-8 flex flex-col gap-3 sm:flex-row sm:flex-wrap">
          <WaButton msg={slide.waMsg}><MessageCircle className="mr-2 h-5 w-5 shrink-0" /> Pedir orçamento</WaButton>
          <a
            href={MAPS_DIRECTIONS_URL}
            target="_blank"
            rel="noopener noreferrer"
            className="inline-flex items-center justify-center gap-2 rounded-xl bg-accent px-5 py-4 text-base font-bold text-accent-foreground shadow-glow transition hover:brightness-110"
            title="Abrir GPS e traçar rota até a loja MJG"
          >
            <MapPin className="h-5 w-5 text-accent-foreground shrink-0" /> Como Chegar (GPS)
          </a>
          <Button asChild variant="outline" className="h-auto rounded-lg border-primary-foreground/40 bg-transparent px-5 py-4 text-base text-primary-foreground hover:bg-primary-foreground/10 hover:text-primary-foreground">
            <Link to="/celulares">Celulares à venda <ArrowUpRight className="ml-2 h-4 w-4" /></Link>
          </Button>
        </div>
        <div className="mt-8 flex items-center gap-2">
          <Button size="icon" variant="ghost" aria-label="Banner anterior" title="Banner anterior" onClick={() => setCurrent((c) => (c - 1 + slides.length) % slides.length)} className="text-primary-foreground hover:bg-primary-foreground/10 hover:text-primary-foreground"><ChevronLeft /></Button>
          {slides.map((s, i) => (
            <Button
              size="icon"
              variant="ghost"
              key={s.tag}
              aria-label={`Ver banner: ${s.tag}`}
              aria-pressed={i === current}
              title={s.tag}
              onClick={() => setCurrent(i)}
              className={
                "h-8 w-8 rounded-full hover:bg-primary-foreground/10 "
              }
            ><span className={"h-2 w-2 rounded-full " + (i === current ? "bg-accent-bright" : "bg-primary-foreground/40")} /></Button>
          ))}
          <Button size="icon" variant="ghost" aria-label="Próximo banner" title="Próximo banner" onClick={() => setCurrent((c) => (c + 1) % slides.length)} className="text-primary-foreground hover:bg-primary-foreground/10 hover:text-primary-foreground"><ChevronRight /></Button>
          <Button size="icon" variant="ghost" aria-label={paused ? "Retomar banners" : "Pausar banners"} title={paused ? "Retomar banners" : "Pausar banners"} onClick={() => setPaused((p) => !p)} className="ml-1 text-primary-foreground hover:bg-primary-foreground/10 hover:text-primary-foreground">{paused ? <Play className="h-4 w-4" /> : <Pause className="h-4 w-4" />}</Button>
        </div>
      </div>
    </section>
  );
}
