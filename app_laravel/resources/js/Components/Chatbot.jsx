
import { useState } from "react";
import axios from "axios";

export default function Chatbot() {
    const [message, setMessage] = useState("");
    const [messages, setMessages] = useState([]);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState("");

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
            console.log(result);
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
        <div className="mx-auto max-w-2xl space-y-4">
            <div className="space-y-4">
                {messages.map((item, index) => (
                    <div
                        key={index}
                        className="rounded-lg border p-4"
                    >
                        <p className="mb-2 text-sm font-semibold">
                            {item.role === "user"
                                ? "Anda"
                                : "Chatbot Apotek"}
                        </p>

                        <p>{item.content}</p>

                        {item.role === "assistant" &&
                            item.data?.map((result) => (
                                <div
                                    key={result.medicine.id}
                                    className="mt-3 rounded-md bg-gray-50 p-3"
                                >
                                    <p className="font-semibold">
                                        {result.medicine.name}
                                    </p>

                                    <p>
                                        Kekuatan:{" "}
                                        {result.medicine.strength ?? "-"}
                                    </p>

                                    <p>
                                        Bentuk:{" "}
                                        {result.medicine.dosage_form ?? "-"}
                                    </p>

                                    <p>
                                        Stok tersedia:{" "}
                                        {result.medicine.available_stock}
                                    </p>

                                    <p className="mt-2 text-sm">
                                        Indikasi: {result.indications}
                                    </p>

                                    {result.warnings && (
                                        <p className="mt-2 text-sm">
                                            Peringatan: {result.warnings}
                                        </p>
                                    )}

                                    {result.source_url && (
                                        <a
                                            href={result.source_url}
                                            target="_blank"
                                            rel="noreferrer"
                                            className="mt-2 inline-block text-blue-600 underline"
                                        >
                                            Lihat sumber informasi
                                        </a>
                                    )}
                                </div>
                            ))}
                    </div>
                ))}
            </div>

            {error && (
                <p role="alert" className="text-sm text-red-600">
                    {error}
                </p>
            )}

            <form onSubmit={sendMessage} className="flex gap-2">
                <input
                    value={message}
                    onChange={(event) => setMessage(event.target.value)}
                    placeholder="Ceritakan keluhan Anda..."
                    maxLength={1000}
                    className="min-w-0 flex-1 rounded-lg border px-3 py-2"
                    disabled={loading}
                />

                <button
                    type="submit"
                    disabled={loading || !message.trim()}
                    className="rounded-lg bg-violet-600 px-4 py-2 text-white disabled:opacity-50"
                >
                    {loading ? "Memproses..." : "Kirim"}
                </button>
            </form>
        </div>
    );
}
