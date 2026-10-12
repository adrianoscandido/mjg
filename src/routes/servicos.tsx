import { createFileRoute } from "@tanstack/react-router";
import { useState, useEffect } from "react";
import { WaButton } from "@/components/Layout";
import { services as defaultServices } from "@/lib/site";

export const Route = createFileRoute("/servicos")({
  head: () => ({
    meta: [
      { title: "Serviços de Conserto de Celular & Parceiros | MJG Assistech & Imports" },
      { name: "description", content: "Troca de tela, bateria, conector de carga, reparo avançado de placa, desbloqueios e serviços de parceiros recomendados em São Roque." },
      { property: "og:title", content: "Serviços de Conserto de Celular & Parceiros | MJG Assistech & Imports" },
      { property: "og:description", content: "Troca de tela, bateria, conector de carga, reparo de placa e serviços recomendados de nossos parceiros em São Roque." },
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

type ParceiroItem = {
  id: number;
  nome: string;
  logo: string;
  whatsapp?: string;
  site?: string;
  servicos: string;
  descricao?: string;
  ordem?: number;
};

const defaultParceiros: ParceiroItem[] = [
  {
    id: 1,
    nome: "Rede Tech & CFTV São Roque",
    logo: "📹",
    whatsapp: "11998037170",
    site: "https://redetechcftv.com.br",
    servicos: "Câmeras de Segurança (CFTV), Instalação de Redes Wi-Fi, Cabeamento Estruturado, Alarmes Residenciais e Comerciais",
    descricao: "Especialista em segurança eletrônica, monitoramento e infraestrutura de alta performance para residências e comércios.",
  },
  {
    id: 2,
    nome: "Gráfica & Películas Express",
    logo: "🎨",
    whatsapp: "11998037170",
    site: "https://graficaexpress.com.br",
    servicos: "Películas de Alta Proteção Personalizadas, Capinhas Customizadas com Foto, Adesivos Resinados, Brindes e Gráfica Rápida",
    descricao: "Personalização de ponta e impressões de alta fidelidade com acabamento profissional e durabilidade.",
  },
];

function Servicos() {
  const [items, setItems] = useState<ServicoItem[]>(defaultServices);
  const [parceiros, setParceiros] = useState<ParceiroItem[]>(defaultParceiros);

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
      .catch(() => {});

    fetch("/api/parceiros.php?t=" + Date.now(), { cache: "no-store" })
      .then((res) => res.json())
      .then((res) => {
        if (res?.ok && Array.isArray(res.dados) && res.dados.length > 0) {
          setParceiros(res.dados);
        }
      })
      .catch(() => {});
  }, []);

  return (
    <div className="space-y-16 py-14">
      {/* SEÇÃO 1: SERVIÇOS MJG */}
      <section className="mx-auto max-w-6xl px-4">
        <div className="flex flex-col gap-2">
          <span className="w-fit rounded-full bg-primary/10 px-3 py-1 text-xs font-bold uppercase tracking-wider text-primary border border-primary/20">
            Nossos Serviços MJG
          </span>
          <h1 className="font-display text-5xl sm:text-6xl text-primary">Serviços Especializados</h1>
          <p className="text-muted-foreground max-w-2xl">
            Soluções ágeis em conserto de smartphones, tablets e acessórios com peças de qualidade e garantia comprovada.
          </p>
        </div>

        <div className="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
          {items.map((s, idx) => (
            <div key={s.id || s.title || idx} className="flex flex-col rounded-2xl border bg-card p-6 shadow-sm hover:border-primary/40 transition-colors">
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

      {/* SEÇÃO 2: SERVIÇOS DE PARCEIROS RECOMENDADOS */}
      <section id="parceiros" className="scroll-mt-24 border-t bg-secondary/40 py-16">
        <div className="mx-auto max-w-6xl px-4">
          <div className="flex flex-col items-start gap-2">
            <span className="inline-flex items-center gap-1.5 rounded-full bg-accent/15 px-3 py-1 text-xs font-bold uppercase tracking-wider text-accent border border-accent/30">
              🤝 Rede de Confiança MJG
            </span>
            <h2 className="font-display text-4xl sm:text-5xl text-primary">
              Serviços de Parceiros Recomendados
            </h2>
            <p className="max-w-3xl text-muted-foreground">
              Profissionais e empresas parceiras selecionadas a dedo pela MJG. Garantia de seriedade, atendimento de qualidade e suporte para você e sua empresa.
            </p>
          </div>

          <div className="mt-10 grid gap-6 sm:grid-cols-2">
            {parceiros.map((p) => {
              const servicosArray = p.servicos
                ? p.servicos.split(",").map((s) => s.trim()).filter(Boolean)
                : [];

              const cleanPhone = (p.whatsapp || "11998037170").replace(/\D/g, "");
              const formattedPhone = cleanPhone.length === 10 || cleanPhone.length === 11 ? `55${cleanPhone}` : cleanPhone;
              const waText = encodeURIComponent(
                `Olá! Vim pelo site da MJG Assistech e gostaria de informações sobre os serviços de ${p.nome}!`
              );
              const waLink = `https://wa.me/${formattedPhone}?text=${waText}`;

              return (
                <div
                  key={p.id}
                  className="flex flex-col justify-between rounded-3xl border border-border/80 bg-card p-7 shadow-md transition-all hover:border-primary/50 hover:shadow-lg"
                >
                  <div>
                    {/* Cabeçalho do Parceiro */}
                    <div className="flex items-start gap-4">
                      <div className="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-primary/10 text-3xl border border-primary/20 shadow-inner overflow-hidden">
                        {p.logo && (p.logo.startsWith("http") || p.logo.startsWith("/")) ? (
                          <img src={p.logo} alt={p.nome} className="h-full w-full object-contain p-1" />
                        ) : (
                          <span>{p.logo || "🤝"}</span>
                        )}
                      </div>
                      <div className="flex-1">
                        <h3 className="font-display text-2xl sm:text-3xl text-foreground">
                          {p.nome}
                        </h3>
                        {p.descricao && (
                          <p className="mt-1 text-sm text-muted-foreground leading-relaxed">
                            {p.descricao}
                          </p>
                        )}
                      </div>
                    </div>

                    {/* Lista de Serviços do Parceiro */}
                    <div className="mt-5 border-t border-border/60 pt-4">
                      <h4 className="text-xs font-bold uppercase tracking-wider text-muted-foreground">
                        Serviços Disponíveis:
                      </h4>
                      <div className="mt-2.5 flex flex-wrap gap-2">
                        {servicosArray.map((serv, sIdx) => (
                          <span
                            key={sIdx}
                            className="inline-flex items-center gap-1 rounded-lg bg-primary/10 px-2.5 py-1 text-xs font-semibold text-primary border border-primary/25"
                          >
                            <span className="text-[10px] text-accent">✔</span> {serv}
                          </span>
                        ))}
                      </div>
                    </div>
                  </div>

                  {/* Botões de Ação: Site do Parceiro e WhatsApp */}
                  <div className="mt-6 border-t border-border/60 pt-4 flex flex-wrap items-center justify-between gap-3">
                    <span className="text-xs text-muted-foreground">
                      Parceria com indicação MJG
                    </span>
                    <div className="flex flex-wrap items-center gap-2">
                      {p.site && (
                        <a
                          href={p.site.startsWith("http") ? p.site : `https://${p.site}`}
                          target="_blank"
                          rel="noopener noreferrer"
                          className="inline-flex items-center gap-1.5 rounded-xl border border-primary/40 bg-primary/10 px-3.5 py-2 text-sm font-bold text-primary hover:bg-primary/20 active:scale-95 transition-all"
                          title={`Visitar site oficial de ${p.nome}`}
                        >
                          <span>🌐</span> Acessar Site
                        </a>
                      )}
                      <a
                        href={waLink}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="inline-flex items-center gap-2 rounded-xl bg-green-600 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-green-700 active:scale-95 transition-all"
                      >
                        <span>💬</span> WhatsApp
                      </a>
                    </div>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      </section>
    </div>
  );
}

