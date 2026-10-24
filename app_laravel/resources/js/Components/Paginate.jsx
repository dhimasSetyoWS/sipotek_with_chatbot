// resources/js/Components/Obat/Pagination.jsx
import { Link } from "@inertiajs/react";

export default function Paginate({ links }) {
    // Kalau cuma 1 halaman, gak usah tampil
    if (links.length <= 3) return null;

    return (
        <div className="flex items-center justify-center gap-1 mt-6">
            {links.map((link, index) => (
                <Link
                    key={index}
                    href={link.url || "#"}
                    preserveState
                    className={`px-3 py-1.5 text-xs font-medium rounded-md border transition-colors ${
                        link.active
                            ? "bg-emerald-700 text-white border-emerald-700"
                            : link.url
                            ? "bg-white text-slate-700 border-slate-200 hover:bg-slate-50"
                            : "bg-slate-100 text-slate-400 border-slate-200 cursor-not-allowed pointer-events-none"
                    }`}
                    dangerouslySetInnerHTML={{ __html: link.label }}
                />
            ))}
        </div>
    );
}