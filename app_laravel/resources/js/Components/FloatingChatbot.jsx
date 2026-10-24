import React, { useState, useRef, useEffect } from "react";
import axios from "axios";
import { MessageSquare, X, Send, Pill, Bot, User, AlertCircle } from "lucide-react";

export default function FloatingChatbot() {
    const [isOpen, setIsOpen] = useState(false);
    const [message, setMessage] = useState("");
    const [messages, setMessages] = useState([
        {
            role: "assistant",
            content: "Halo! Saya Asisten Apotek Care. Ada keluhan kesehatan atau informasi obat yang ingin Anda cari?",
        }
    ]);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState("");

    const messagesEndRef = useRef(null);

    // Auto scroll ke pesan paling bawah
    const scrollToBottom = () => {
        messagesEndRef.current?.scrollIntoView({ behavior: "smooth" });
    };

    useEffect(() => {
        if (isOpen) {
            scrollToBottom();
        }
    }, [messages, isOpen]);

    async function sendMessage(event) {
        event.preventDefault();

        const text = message.trim();
        if (!text || loading) return;

        setMessages((previous) => [
            ...previous,
            { role: "user", content: text },
        ]);

        setMessage("");
        setError("");
        setLoading(true);

        try {
            const response = await axios.post("/api/chatbot/chat", {
                message: text,
            });

            const result = response.data;
            setMessages((previous) => [
                ...previous,
                {
                    role: "assistant",
                    content: result.message,
                    status: result.status,
                    data: result.data ?? [],
                },
            ]);
        } catch (err) {
            const errorMessage =
                err.response?.data?.message ??
                "Chatbot tidak dapat dihubungi. Silakan coba kembali.";

            setError(errorMessage);
        } finally {
            setLoading(false);
        }
    }

    return (
        <div className="fixed bottom-6 right-6 z-50 font-sans">
            {/* TOMBOL TOGGLE (FLOATING BUTTON) */}
            {!isOpen && (
                <button
                    onClick={() => setIsOpen(true)}
                    className="relative group bg-emerald-700 hover:bg-emerald-800 text-white p-4 rounded-full shadow-2xl transition-all duration-300 flex items-center justify-center focus:outline-none focus:ring-4 focus:ring-emerald-500/50"
                    title="Buka Konsultasi Chatbot"
                >
                    <MessageSquare className="w-6 h-6" />
                    {/* Badge Notifikasi Kecil */}
                    <span className="absolute -top-1 -right-1 flex h-3 w-3">
                        <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span className="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                    </span>
                </button>
            )}

            {/* POPUP CHAT WINDOW */}
            {isOpen && (
                <div className="bg-white rounded-2xl shadow-2xl border border-slate-200 w-[90vw] sm:w-[380px] h-[520px] flex flex-col overflow-hidden animate-in fade-in zoom-in-95 duration-200">
                    
                    {/* HEADER CHAT */}
                    <div className="bg-emerald-950 text-white px-4 py-3.5 flex items-center justify-between border-b border-emerald-900">
                        <div className="flex items-center space-x-3">
                            <div className="h-9 w-9 rounded-xl bg-emerald-700 flex items-center justify-center text-white shadow-sm">
                                <Bot className="w-5 h-5" />
                            </div>
                            <div>
                                <h3 className="font-bold text-xs sm:text-sm tracking-wide">Asisten Apotek Care</h3>
                                <p className="text-[10px] text-emerald-300 flex items-center space-x-1">
                                    <span className="h-1.5 w-1.5 rounded-full bg-emerald-400 inline-block"></span>
                                    <span>Online siap membantu</span>
                                </p>
                            </div>
                        </div>
                        <button
                            onClick={() => setIsOpen(false)}
                            className="text-slate-300 hover:text-white p-1.5 rounded-lg hover:bg-emerald-900/60 transition-colors"
                        >
                            <X className="w-5 h-5" />
                        </button>
                    </div>

                    {/* BODY AREA PESAN */}
                    <div className="flex-1 p-4 overflow-y-auto space-y-3 bg-slate-50 text-xs">
                        {messages.map((item, index) => (
                            <div
                                key={index}
                                className={`flex flex-col ${item.role === "user" ? "items-end" : "items-start"}`}
                            >
                                <div className="flex items-center space-x-1 mb-1 px-1">
                                    <span className="text-[10px] font-semibold text-slate-500">
                                        {item.role === "user" ? "Anda" : "Apotek Care"}
                                    </span>
                                </div>
                                
                                <div
                                    className={`max-w-[85%] rounded-2xl px-4 py-2.5 shadow-2xs leading-relaxed ${
                                        item.role === "user"
                                            ? "bg-emerald-700 text-white rounded-br-xs"
                                            : "bg-white text-slate-800 border border-slate-200 rounded-bl-xs"
                                    }`}
                                >
                                    <p className="whitespace-pre-wrap">{item.content}</p>

                                    {/* JIKA ADA DATA OBAT REKOMENDASI DARI BACKEND */}
                                    {item.role === "assistant" &&
                                        item.data?.map((result) => (
                                            <div
                                                key={result.medicine.id}
                                                className="mt-3 rounded-xl bg-emerald-50/70 border border-emerald-100 p-3 space-y-1.5 text-[11px] text-slate-700"
                                            >
                                                <div className="flex items-center space-x-1.5 font-bold text-emerald-900">
                                                    <Pill className="w-3.5 h-3.5 text-emerald-700 shrink-0" />
                                                    <span>{result.medicine.name}</span>
                                                </div>

                                                <div className="grid grid-cols-2 gap-1 text-slate-600">
                                                    <p>Kekuatan: <span className="font-medium">{result.medicine.strength ?? "-"}</span></p>
                                                    <p>Bentuk: <span className="font-medium">{result.medicine.dosage_form ?? "-"}</span></p>
                                                </div>

                                                <p className="text-emerald-700 font-semibold">
                                                    Stok tersedia: {result.medicine.available_stock} Unit
                                                </p>

                                                {result.indications && (
                                                    <p className="text-slate-600 pt-1 border-t border-emerald-100">
                                                        <strong className="text-slate-700">Indikasi:</strong> {result.indications}
                                                    </p>
                                                )}

                                                {result.warnings && (
                                                    <p className="text-amber-700 bg-amber-50 p-1.5 rounded-lg border border-amber-200/60 mt-1">
                                                        <strong>Peringatan:</strong> {result.warnings}
                                                    </p>
                                                )}

                                                {result.source_url && (
                                                    <a
                                                        href={result.source_url}
                                                        target="_blank"
                                                        rel="noreferrer"
                                                        className="mt-1 inline-block text-emerald-700 hover:underline font-semibold"
                                                    >
                                                        Lihat sumber informasi &rarr;
                                                    </a>
                                                )}
                                            </div>
                                        ))}
                                </div>
                            </div>
                        ))}

                        {loading && (
                            <div className="flex items-center space-x-2 text-slate-400 bg-white border border-slate-200 px-4 py-2.5 rounded-2xl w-fit">
                                <span className="w-2 h-2 bg-emerald-600 rounded-full animate-bounce"></span>
                                <span className="w-2 h-2 bg-emerald-600 rounded-full animate-bounce [animation-delay:0.2s]"></span>
                                <span className="w-2 h-2 bg-emerald-600 rounded-full animate-bounce [animation-delay:0.4s]"></span>
                                <span className="text-[11px] font-medium text-slate-500 ml-1">Sedang mencari informasi...</span>
                            </div>
                        )}

                        <div ref={messagesEndRef} />
                    </div>

                    {/* ERROR ALERT */}
                    {error && (
                        <div className="px-4 py-2 bg-rose-50 border-t border-rose-100 text-rose-600 text-[11px] flex items-center space-x-1.5">
                            <AlertCircle className="w-4 h-4 shrink-0" />
                            <span>{error}</span>
                        </div>
                    )}

                    {/* FOOTER FORM INPUT */}
                    <form onSubmit={sendMessage} className="p-3 bg-white border-t border-slate-200 flex items-center gap-2">
                        <input
                            value={message}
                            onChange={(event) => setMessage(event.target.value)}
                            placeholder="Ceritakan keluhan atau cari obat..."
                            maxLength={1000}
                            className="min-w-0 flex-1 rounded-xl border border-slate-200 px-3.5 py-2.5 text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-slate-50"
                            disabled={loading}
                        />

                        <button
                            type="submit"
                            disabled={loading || !message.trim()}
                            className="rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white p-2.5 disabled:opacity-50 transition-colors shadow-xs flex items-center justify-center shrink-0"
                            title="Kirim Pesan"
                        >
                            <Send className="w-4 h-4" />
                        </button>
                    </form>

                </div>
            )}
        </div>
    );
}