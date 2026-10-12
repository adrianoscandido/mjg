import { Link } from "@tanstack/react-router";
import { useState, type ReactNode } from "react";
import { ADDRESS, PHONE_DISPLAY, waLink, MAPS_URL } from "@/lib/site";

const nav = [
  { to: "/", label: "Início" },
  { to: "/servicos", label: "Serviços" },
  { to: "/celulares", label: "Celulares" },
  { to: "/orcamento", label: "Orçamento" },
  { to: "/contato", label: "Contato" },
] as const;

export function Logo() {
  return (
    <Link to="/" className="flex items-center gap-2">
      <span className="font-display text-3xl leading-none text-primary-foreground">MJG</span>
      <span className="text-xs font-bold uppercase leading-tight text-accent-bright">Assistech<br />& Imports</span>
    </Link>
  );
}

export function Layout({ children }: { children: ReactNode }) {
  const [open, setOpen] = useState(false);
  return (
    <div className="flex min-h-screen flex-col">
      <header className="sticky top-0 z-40 bg-primary shadow-lg">
        <div className="mx-auto flex max-w-6xl items-center justify-between px-4 py-3">
          <Logo />
          <nav className="hidden gap-6 md:flex">
            {nav.map((n) => (
              <Link key={n.to} to={n.to} className="font-semibold text-primary-foreground/80 hover:text-primary-foreground" activeProps={{ className: "text-accent-bright" }} activeOptions={{ exact: true }}>
                {n.label}
              </Link>
            ))}
          </nav>
          <button aria-label="Menu" onClick={() => setOpen(!open)} className="rounded-md p-2 text-2xl text-primary-foreground md:hidden">☰</button>
        </div>
        {open && (
          <nav className="flex flex-col border-t border-primary-foreground/10 px-4 pb-4 md:hidden">
            {nav.map((n) => (
              <Link key={n.to} to={n.to} onClick={() => setOpen(false)} className="py-3 text-lg font-semibold text-primary-foreground">{n.label}</Link>
            ))}
          </nav>
        )}
      </header>
      <main className="flex-1">{children}</main>
      <footer className="bg-primary text-primary-foreground">
        <div className="mx-auto grid max-w-6xl gap-6 px-4 py-10 md:grid-cols-3">
          <Logo />
          <div><p className="font-bold">WhatsApp</p><a href={waLink("Olá! Vim pelo site.")} className="text-accent-bright">{PHONE_DISPLAY}</a></div>
          <div><p className="font-bold">Endereço</p><a href={MAPS_URL} target="_blank" rel="noopener noreferrer" className="text-primary-foreground/80 hover:text-accent-bright transition-colors">📍 {ADDRESS}</a></div>
        </div>
        <div className="bg-accent py-3 text-center text-sm text-accent-foreground flex items-center justify-center gap-3">
          <span>© {new Date().getFullYear()} MJG Assistech & Imports</span>
          <span>·</span>
          <a href="/admin" className="underline hover:opacity-80 font-medium">Área Administrativa</a>
        </div>
      </footer>
      <a href={waLink("Olá! Gostaria de um orçamento.")} target="_blank" rel="noreferrer" aria-label="WhatsApp"
        className="fixed bottom-5 right-5 z-50 flex items-center gap-2 rounded-full bg-accent px-5 py-4 font-bold text-accent-foreground shadow-glow transition hover:scale-105">
        💬 <span className="hidden sm:inline">WhatsApp</span>
      </a>
    </div>
  );
}

export function WaButton({ msg, children, variant = "solid" }: { msg: string; children: ReactNode; variant?: "solid" | "outline" }) {
  return (
    <a href={waLink(msg)} target="_blank" rel="noreferrer"
      className={variant === "solid"
        ? "inline-flex items-center justify-center rounded-xl bg-accent px-6 py-4 text-lg font-bold text-accent-foreground shadow-glow transition hover:brightness-110"
        : "inline-flex items-center justify-center rounded-xl border-2 border-accent px-5 py-3 font-bold text-accent transition hover:bg-accent hover:text-accent-foreground"}>
      {children}
    </a>
  );
}
