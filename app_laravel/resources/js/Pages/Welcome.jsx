import React, { useState, useEffect } from "react";
import { Head, Link, router } from "@inertiajs/react";
import { useDebounce } from "use-debounce";
import {
    Pill,
    Search,
    ShieldCheck,
    Clock,
    Activity,
    ArrowRight,
    Phone,
    MapPin,
    Mail,
} from "lucide-react";
import Chatbot from "@/Components/Chatbot";
import FloatingChatbot from "@/Components/FloatingChatbot";

export default function Welcome({ auth, medicines = [], filters }) {
    const [searchQuery, setSearchQuery] = useState(filters?.search || "");
    const [isScrolled, setIsScrolled] = useState(false);
    // Menggunakan useDebounce dengan jeda 500ms
    const [debouncedSearch] = useDebounce(searchQuery, 500);

    useEffect(() => {
        // Deteksi posisi scroll untuk efek transisi / memunculkan search bar di navbar
        const handleScroll = () => {
            if (window.scrollY > 300) {
                setIsScrolled(true);
            } else {
                setIsScrolled(false);
            }
        };

        window.addEventListener("scroll", handleScroll);
        return () => window.removeEventListener("scroll", handleScroll);
    }, []);

    useEffect(() => {
        if (debouncedSearch === (filters?.search || "")) return;

        router.get(
            route("welcome"),
            { search: debouncedSearch },
            { preserveState: true, replace: true, preserveScroll: true },
        );
    }, [debouncedSearch]);

    const handleSearchChange = (e) => {
        setSearchQuery(e.target.value);
    };

    // Helper Badge Klasifikasi Obat
    const getClassificationBadge = (classification) => {
        switch (classification) {
            case "bebas":
                return (
                    <span className="bg-emerald-50 text-emerald-700 border border-emerald-200 px-2 py-0.5 rounded text-[10px] font-bold">
                        Bebas (Hijau)
                    </span>
                );
            case "bebas_terbatas":
                return (
                    <span className="bg-blue-50 text-blue-700 border border-blue-200 px-2 py-0.5 rounded text-[10px] font-bold">
                        Bebas Terbatas (Biru)
                    </span>
                );
            case "keras":
                return (
                    <span className="bg-rose-50 text-rose-700 border border-rose-200 px-2 py-0.5 rounded text-[10px] font-bold">
                        Keras (Merah / K)
                    </span>
                );
            case "psikotropika":
            case "narkotika":
                return (
                    <span className="bg-amber-50 text-amber-700 border border-amber-200 px-2 py-0.5 rounded text-[10px] font-bold uppercase">
                        {classification}
                    </span>
                );
            default:
                return (
                    <span className="bg-slate-100 text-slate-700 px-2 py-0.5 rounded text-[10px] font-bold">
                        {classification}
                    </span>
                );
        }
    };

    const dataObat = medicines.data || [];

    return (
        <>
            <Head title="Apotek Care - Sistem Informasi & Layanan Farmasi" />

            <div className="min-h-screen bg-slate-50 font-sans text-slate-800 antialiased selection:bg-emerald-600 selection:text-white">
                {/* NAVBAR */}
                <header className="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-xs transition-all duration-200">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
                        {/* Logo */}
                        <div className="flex items-center space-x-3 shrink-0">
                            <div className="h-10 w-10 rounded-xl bg-emerald-700 flex items-center justify-center text-white font-bold shadow-sm">
                                <Pill className="w-6 h-6" />
                            </div>
                            <div>
                                <span className="font-extrabold text-slate-900 text-lg block leading-tight">
                                    Apotek Care
                                </span>
                                <span className="text-[10px] text-emerald-700 font-semibold tracking-wider uppercase">
                                    Layanan Farmasi Terpercaya
                                </span>
                            </div>
                        </div>

                        {/* Search Bar yang akan MUNCUL DI NAVBAR saat di-scroll ke bawah */}
                        <div
                            className={`flex-1 max-w-md transition-all duration-300 ${isScrolled ? "opacity-100 scale-100" : "opacity-0 scale-95 pointer-events-none hidden md:block"}`}
                        >
                            <div className="relative">
                                <span className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                    <Search className="w-4 h-4 text-emerald-600" />
                                </span>
                                <input
                                    type="text"
                                    value={searchQuery}
                                    onChange={handleSearchChange}
                                    placeholder="Cari nama obat, merek..."
                                    className="w-full pl-9 pr-4 py-2 bg-slate-100 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white shadow-2xl placeholder-slate-400 transition-colors"
                                />
                            </div>
                        </div>

                        {/* Auth Nav Links */}
                        <nav className="flex items-center space-x-3 shrink-0">
                            {auth.user ? (
                                <Link
                                    href={route("dashboard")}
                                    className="inline-flex items-center space-x-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm"
                                >
                                    <span>Masuk Dashboard</span>
                                    <ArrowRight className="w-4 h-4" />
                                </Link>
                            ) : (
                                <div className="flex items-center space-x-2">
                                    <Link
                                        href={route("login")}
                                        className="text-xs font-semibold text-slate-700 hover:text-emerald-700 px-4 py-2.5 rounded-xl transition-colors"
                                    >
                                        Log in
                                    </Link>
                                    <Link
                                        href={route("register")}
                                        className="bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm"
                                    >
                                        Register
                                    </Link>
                                </div>
                            )}
                        </nav>
                    </div>
                </header>

                {/* HERO SECTION */}
                <section className="relative bg-emerald-950 text-white py-20 lg:py-28 overflow-hidden">
                    <div className="absolute inset-0 opacity-10 bg-[radial-gradient(#10b981_1px,transparent_1px)] [background-size:16px_16px]"></div>
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
                        <span className="inline-flex items-center space-x-1.5 bg-emerald-900/80 border border-emerald-700 text-emerald-300 text-xs font-semibold px-3 py-1 rounded-full mb-6">
                            <ShieldCheck className="w-4 h-4" />
                            <span>
                                Resmi, Aman, dan Diawasi Apoteker Penanggung
                                Jawab
                            </span>
                        </span>
                        <h1 className="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                            Solusi Kesehatan & Ketersediaan Obat Terlengkap
                        </h1>
                        <p className="mt-4 text-sm sm:text-base text-slate-300 leading-relaxed">
                            Cari informasi ketersediaan obat, cek kandungan zat
                            aktif, klasifikasi keamanan, hingga konsultasi resep
                            dokter dengan mudah dan cepat.
                        </p>

                        <div className="mt-8 relative max-w-xl mx-auto">
                            <span className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <Search className="w-5 h-5 text-emerald-500" />
                            </span>
                            <input
                                type="text"
                                value={searchQuery}
                                onChange={handleSearchChange}
                                placeholder="Cari nama obat, merek (cth: Sanmol, Paracetamol)..."
                                className="w-full pl-12 pr-4 py-3.5 bg-white text-slate-800 rounded-2xl text-xs sm:text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-xl placeholder-slate-400"
                            />
                        </div>
                    </div>
                </section>

                {/* KATALOG OBAT DENGAN TABEL & PAGINASI */}
                <section className="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex flex-col md:flex-row md:items-end justify-between mb-8">
                        <div>
                            <span className="text-xs font-bold text-emerald-700 uppercase tracking-wider">
                                Katalog Digital
                            </span>
                            <h2 className="text-2xl font-bold text-slate-900 mt-1">
                                Daftar Ketersediaan Obat
                            </h2>
                            <p className="text-xs text-slate-500 mt-1">
                                Cek daftar obat dan klasifikasi keamanan yang
                                tersedia di apotek kami.
                            </p>
                        </div>
                    </div>

                    <div className="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                        {/* Header Tabel Normal (Tanpa Sticky) */}
                        <div className="px-6 py-4 bg-slate-50 border-b border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div className="text-xs font-semibold text-slate-600">
                                Total Data:{" "}
                                <span className="text-emerald-700 font-bold">
                                    {medicines.total || 0} Obat
                                </span>
                            </div>
                            <div className="text-xs text-slate-500">
                                {filters?.search && (
                                    <span>
                                        Hasil pencarian untuk:{" "}
                                        <strong className="text-slate-800">
                                            "{filters.search}"
                                        </strong>
                                    </span>
                                )}
                            </div>
                        </div>

                        <div className="overflow-x-auto">
                            <table className="w-full text-left border-collapse">
                                <thead>
                                    <tr className="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-600 uppercase tracking-wider">
                                        <th className="py-3.5 px-6">
                                            Nama & Merek Obat
                                        </th>
                                        <th className="py-3.5 px-6">
                                            Kategori & Bentuk
                                        </th>
                                        <th className="py-3.5 px-6">
                                            Kandungan Zat Aktif
                                        </th>
                                        <th className="py-3.5 px-6">
                                            No. Registrasi (BPOM)
                                        </th>
                                        <th className="py-3.5 px-6">
                                            Klasifikasi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-slate-100 text-xs text-slate-700">
                                    {dataObat.length > 0 ? (
                                        dataObat.map((med) => (
                                            <tr
                                                key={med.id}
                                                className="hover:bg-slate-50/80 transition-colors"
                                            >
                                                <td className="py-4 px-6">
                                                    <div className="font-bold text-slate-800 text-sm">
                                                        {med.name}
                                                    </div>
                                                    <div className="text-[11px] text-slate-400">
                                                        Merk: {med.brand || "-"}
                                                    </div>
                                                </td>
                                                <td className="py-4 px-6">
                                                    <div className="font-medium text-slate-700">
                                                        {med.category?.name ||
                                                            "Umum"}
                                                    </div>
                                                    <div className="text-[11px] text-emerald-700 capitalize font-medium">
                                                        {med.dosage_form} (
                                                        {med.strength || "-"})
                                                    </div>
                                                </td>
                                                <td className="py-4 px-6">
                                                    <div
                                                        className="text-slate-800 max-w-xs truncate"
                                                        title={
                                                            med.active_ingredients
                                                        }
                                                    >
                                                        {med.active_ingredients ||
                                                            "-"}
                                                    </div>
                                                </td>
                                                <td className="py-4 px-6 font-mono text-[11px] text-slate-600">
                                                    {med.registration_number}
                                                </td>
                                                <td className="py-4 px-6">
                                                    {getClassificationBadge(
                                                        med.classification,
                                                    )}
                                                </td>
                                            </tr>
                                        ))
                                    ) : (
                                        <tr>
                                            <td
                                                colSpan="5"
                                                className="py-12 text-center text-slate-400"
                                            >
                                                <Pill className="w-8 h-8 mx-auto text-slate-300 mb-2" />
                                                <p className="font-medium">
                                                    Tidak ada obat yang
                                                    ditemukan sesuai dengan kata
                                                    kunci.
                                                </p>
                                            </td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>
                        </div>

                        {/* TOMBOL NAVIGASI PAGINASI */}
                        {medicines.links && medicines.links.length > 3 && (
                            <div className="px-6 py-4 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                                <div className="text-xs text-slate-500">
                                    Menampilkan{" "}
                                    <span className="font-semibold">
                                        {medicines.from || 0}
                                    </span>{" "}
                                    sampai{" "}
                                    <span className="font-semibold">
                                        {medicines.to || 0}
                                    </span>{" "}
                                    dari{" "}
                                    <span className="font-semibold">
                                        {medicines.total}
                                    </span>{" "}
                                    data obat
                                </div>
                                <div className="flex flex-wrap gap-1">
                                    {medicines.links.map((link, idx) => (
                                        <Link
                                            key={idx}
                                            href={link.url || "#"}
                                            preserveScroll
                                            preserveState
                                            dangerouslySetInnerHTML={{
                                                __html: link.label,
                                            }}
                                            className={`px-3 py-1.5 rounded-lg text-xs font-medium transition-colors ${
                                                link.active
                                                    ? "bg-emerald-700 text-white shadow-xs"
                                                    : link.url
                                                      ? "bg-white border border-slate-200 text-slate-700 hover:bg-slate-100"
                                                      : "bg-slate-100 text-slate-400 cursor-not-allowed"
                                            }`}
                                        />
                                    ))}
                                </div>
                            </div>
                        )}
                    </div>
                </section>

                {/* FOOTER */}
                <footer className="bg-slate-900 text-slate-400 py-12 border-t border-slate-800">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div>
                            <div className="flex items-center space-x-3 mb-4">
                                <div className="h-8 w-8 rounded-lg bg-emerald-700 flex items-center justify-center text-white font-bold">
                                    <Pill className="w-5 h-5" />
                                </div>
                                <span className="font-bold text-white text-base">
                                    Apotek Care
                                </span>
                            </div>
                            <p className="text-xs text-slate-400 leading-relaxed">
                                Sistem Informasi Farmasi & Manajemen Apotek
                                terpadu untuk pelayanan kesehatan masyarakat
                                yang lebih optimal.
                            </p>
                        </div>
                        <div>
                            <h4 className="font-bold text-white text-xs uppercase tracking-wider mb-4">
                                Kontak Kami
                            </h4>
                            <ul className="space-y-2.5 text-xs">
                                <li className="flex items-center space-x-2">
                                    <MapPin className="w-4 h-4 text-emerald-500 shrink-0" />
                                    <span>
                                        Jl. Kesehatan Raya No. 12, Kota Palu
                                    </span>
                                </li>
                                <li className="flex items-center space-x-2">
                                    <Phone className="w-4 h-4 text-emerald-500 shrink-0" />
                                    <span>(0451) 123456 / 0812-3456-7890</span>
                                </li>
                                <li className="flex items-center space-x-2">
                                    <Mail className="w-4 h-4 text-emerald-500 shrink-0" />
                                    <span>support@apotekcare.com</span>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h4 className="font-bold text-white text-xs uppercase tracking-wider mb-4">
                                Jam Operasional
                            </h4>
                            <p className="text-xs leading-relaxed">
                                Senin - Minggu: 07.00 - 22.00 WITA
                                <br />
                                Layanan Instalasi Farmasi & Konsultasi Apoteker
                                buka setiap hari.
                            </p>
                        </div>
                    </div>
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 pt-6 border-t border-slate-800 text-center text-[11px]">
                        &copy; {new Date().getFullYear()} Apotek Care. SIK / SIA
                        Terdaftar Resmi.
                    </div>
                </footer>
                <FloatingChatbot/>
            </div>
        </>
    );
}
