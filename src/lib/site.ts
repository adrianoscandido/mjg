export const WHATSAPP = "5511998037170";
export const PHONE_DISPLAY = "(11) 99803-7170";
export const ADDRESS = "Av. Jaboticabal, 347 – Vila Nova, São Roque - SP, 18131-225";
export const ADDRESS_SHORT = "Av. Jaboticabal, 347 – Vila Nova, São Roque";
export const MAPS_CID = "8840866417741061658";
export const MAPS_URL = `https://www.google.com/maps?cid=${MAPS_CID}`;
export const MAPS_DIRECTIONS_URL = `https://www.google.com/maps/dir/?api=1&destination=MJG+Assist%C3%AAncia+T%C3%A9cnica+de+Celulares,+Av.+Jaboticabal,+347+-+Vila+Nova,+S%C3%A3o+Roque+-+SP`;
export const MAPS_EMBED_URL = `https://maps.google.com/maps?cid=${MAPS_CID}&output=embed`;

export const waLink = (msg: string = "Olá, vim pelo site!") =>
  `https://wa.me/${WHATSAPP}?text=${encodeURIComponent(msg)}`;

export const services = [
  { title: "Troca de tela", desc: "Tela trincada, manchada ou sem toque? Trocamos com peças de qualidade.", icon: "📱" },
  { title: "Troca de bateria", desc: "Celular descarregando rápido ou desligando sozinho? Bateria nova.", icon: "🔋" },
  { title: "Troca de conector", desc: "Não carrega ou só carrega em uma posição? Trocamos o conector de carga.", icon: "🔌" },
  { title: "Reparo na placa", desc: "Celular não liga, molhou ou sofreu queda? Diagnóstico e reparo de placa.", icon: "🛠️" },
  { title: "Desbloqueios", desc: "Desbloqueio de aparelhos com segurança e agilidade.", icon: "🔓" },
  { title: "Manutenção geral", desc: "Alto-falante, microfone, câmera, botões e limpeza interna.", icon: "⚙️" },
  { title: "Cabos e carregadores", desc: "Acessórios de qualidade para todas as marcas.", icon: "🔋" },
];

export const brands = ["Samsung", "Apple", "Motorola", "Xiaomi", "LG"];

export type Phone = { name: string; brand: string; condition: "Novo" | "Seminovo"; storage: string; price: number };

// Aparelhos de exemplo — substituir pela lista real
export const phones: Phone[] = [
  { name: "iPhone 13", brand: "Apple", condition: "Seminovo", storage: "128 GB", price: 2799 },
  { name: "iPhone 15", brand: "Apple", condition: "Novo", storage: "128 GB", price: 4999 },
  { name: "Galaxy A55", brand: "Samsung", condition: "Novo", storage: "256 GB", price: 2199 },
  { name: "Galaxy S23", brand: "Samsung", condition: "Seminovo", storage: "256 GB", price: 2899 },
  { name: "Moto G84", brand: "Motorola", condition: "Novo", storage: "256 GB", price: 1399 },
  { name: "Redmi Note 13", brand: "Xiaomi", condition: "Novo", storage: "256 GB", price: 1499 },
  { name: "Moto Edge 40", brand: "Motorola", condition: "Seminovo", storage: "256 GB", price: 1799 },
  { name: "Poco X6", brand: "Xiaomi", condition: "Seminovo", storage: "256 GB", price: 1599 },
];

export const brl = (n: number) => n.toLocaleString("pt-BR", { style: "currency", currency: "BRL" });
