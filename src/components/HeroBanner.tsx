import { useEffect, useState } from "react";
import { Link } from "@tanstack/react-router";
import bannerTela from "@/assets/banner-tela.jpg";
import bannerBateria from "@/assets/banner-bateria.jpg";
import bannerConector from "@/assets/banner-conector.jpg";
import { WaButton } from "@/components/Layout";

const slides = [
  {
    img: bannerTela,
    tag: "Troca de tela",
    title: "Tela trincada? Deixa com a gente.",
    desc: "Troca de tela com peça de qualidade e garantia. Seu celular como novo novamente.",
    waMsg: "Olá! Minha tela quebrou, gostaria de um orçamento para a troca de tela.",
  },
  {
    img: bannerBateria,
    tag: "Troca de bateria",
    title: "Bateria não dura o dia todo?",
    desc: "Trocamos a bateria do seu celular e a carga volta a durar como no primeiro dia.",
    waMsg: "Olá! A bateria do meu celular está acabando rápido, gostaria de um orçamento para a troca.",
  },
  {
    img: bannerConector,
    tag: "Troca de conector",
    title: "Só carrega de um jeitinho?",
    desc: "Conector de carga frouxo ou sem funcionar? Reparamos e trocamos o conector do seu aparelho.",
    waMsg: "Olá! Meu celular não carrega direito, gostaria de um orçamento para o conserto do conector.",
  },
];

const INTERVAL = 5000;

export function HeroBanner() {
  const [current, setCurrent] = useState(0);

  useEffect(() => {
    const id = setInterval(() => setCurrent((c) => (c + 1) % slides.length), INTERVAL);
    return () => clearInterval(id);
  }, []);

  const slide = slides[current % slides.length]!;

  return (
    <section className="relative overflow-hidden bg-primary">
      {slides.map((s, i) => (
        <img
          key={s.tag}
          src={s.img}
          alt={s.tag}
          width={1600}
          height={912}
          loading={i === 0 ? "eager" : "lazy"}
          className={
            "absolute inset-0 h-full w-full object-cover transition-opacity duration-700 " +
            (i === current ? "opacity-40" : "opacity-0")
          }
        />
      ))}
      <div className="relative mx-auto max-w-6xl px-4 py-20 md:py-32">
        <p className="font-bold uppercase tracking-widest text-accent-bright">
          {slide.tag}
        </p>
        <h1 key={slide.tag} className="mt-3 max-w-2xl font-display text-6xl leading-none text-primary-foreground md:text-8xl animate-in fade-in slide-in-from-bottom-4 duration-700">
          {slide.title}
        </h1>
        <p key={slide.desc} className="mt-5 max-w-xl text-lg text-primary-foreground/85 animate-in fade-in duration-700">
          {slide.desc}
        </p>
        <div className="mt-8 flex flex-col gap-3 sm:flex-row">
          <WaButton msg={slide.waMsg}>💬 Pedir orçamento no WhatsApp</WaButton>
          <Link to="/celulares" className="inline-flex items-center justify-center rounded-xl border-2 border-primary-foreground/40 px-6 py-4 text-lg font-bold text-primary-foreground hover:bg-primary-foreground/10">
            Ver celulares à venda
          </Link>
        </div>
        <div className="mt-10 flex gap-2">
          {slides.map((s, i) => (
            <button
              key={s.tag}
              aria-label={`Ver banner: ${s.tag}`}
              onClick={() => setCurrent(i)}
              className={
                "h-2.5 rounded-full transition-all duration-300 " +
                (i === current ? "w-10 bg-accent-bright" : "w-3 bg-primary-foreground/40 hover:bg-primary-foreground/60")
              }
            />
          ))}
        </div>
      </div>
    </section>
  );
}
