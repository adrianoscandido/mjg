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
          <div><p className="font-bold">WhatsApp</p><a href={waLink("Olá, vim pelo site!")} className="text-accent-bright">{PHONE_DISPLAY}</a></div>
          <div><p className="font-bold">Endereço</p><a href={MAPS_URL} target="_blank" rel="noopener noreferrer" className="text-primary-foreground/80 hover:text-accent-bright transition-colors">📍 {ADDRESS}</a></div>
        </div>
        <div className="bg-accent py-3 text-center text-sm text-accent-foreground flex items-center justify-center gap-3">
          <span>© {new Date().getFullYear()} MJG Assistech & Imports</span>
          <span>·</span>
          <a href="/admin" className="underline hover:opacity-80 font-medium">Área Administrativa</a>
        </div>
      </footer>
      <a
        href={waLink("Olá, vim pelo site!")}
        target="_blank"
        rel="noreferrer"
        aria-label="Falar no WhatsApp"
        title="Falar no WhatsApp"
        className="fixed bottom-5 right-5 z-50 flex h-12 w-12 items-center justify-center rounded-full bg-[#25D366] text-white shadow-xl transition-transform duration-200 hover:scale-110 hover:brightness-105"
      >
        <svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
          <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.174.086.275.072.376-.043.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564c.173.087.289.13.332.202.043.073.043.419-.101.824z" />
          <path d="M12 2C6.477 2 2 6.477 2 12c0 1.891.524 3.662 1.435 5.178L2 22l4.975-1.396A9.957 9.957 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18.062c-1.636 0-3.167-.487-4.453-1.326l-.319-.208-2.953.827.818-2.887-.227-.333C3.993 14.802 3.5 13.438 3.5 12c0-4.687 3.813-8.5 8.5-8.5s8.5 3.813 8.5 8.5-3.813 8.062-8.5 8.062z" />
        </svg>
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
