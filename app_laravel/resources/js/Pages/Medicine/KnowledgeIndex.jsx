import React, { useState, useEffect } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router, useForm, usePage } from "@inertiajs/react";
import { useDebounce } from "use-debounce";
import {
    BookOpen,
    Search,
    CheckCircle2,
    AlertCircle,
    Edit3,
    ExternalLink,
    X,
    ShieldCheck,
    FileText,
    ArrowLeft,
} from "lucide-react";
import TextAreaAAutosize from 'react-textarea-autosize';

export default function KnowledgeIndex({ medicines, filters }) {
    const [searchQuery, setSearchQuery] = useState(filters?.search || "");
    const [selectedStatus, setSelectedStatus] = useState(
        filters?.status || "all",
    );
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [activeMedicine, setActiveMedicine] = useState(null);

    const [debouncedSearch] = useDebounce(searchQuery, 500);
    const { flash } = usePage().props;

    // Form Inertia untuk Knowledge
    const { data, setData, post, processing, reset, errors, clearErrors } =
        useForm({
            indications: "",
            contraindications: "",
            warnings: "",
            side_effects: "",
            source_name: "",
            source_url: "",
            status: "draft",
        });

    // Live search & filter otomatis
    useEffect(() => {
        router.get(
            route("knowledge.index"),
            { search: debouncedSearch, status: selectedStatus },
            { preserveState: true, replace: true, preserveScroll: true },
        );
    }, [debouncedSearch, selectedStatus]);

    const handleOpenEditModal = (med) => {
        setActiveMedicine(med);
        clearErrors();
        setData({
            indications: med.knowledge?.indications || "",
            contraindications: med.knowledge?.contraindications || "",
            warnings: med.knowledge?.warnings || "",
            side_effects: med.knowledge?.side_effects || "",
            source_name: med.knowledge?.source_name || "",
            source_url: med.knowledge?.source_url || "",
            status: med.knowledge?.status || "draft",
        });
        setIsModalOpen(true);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        if (!activeMedicine) return;

        post(route("knowledge.storeOrUpdate", activeMedicine.id), {
            onSuccess: () => {
                setIsModalOpen(false);
                reset();
            },
        });
    };

    // Fungsi untuk langsung mengubah status saat badge diklik
    const handleToggleStatus = (med) => {
        const currentStatus = med.knowledge?.status || "draft";
        const newStatus = currentStatus === "reviewed" ? "draft" : "reviewed";

        router.patch(
            route("knowledge.updateStatus", med.id),
            { status: newStatus },
            {
                preserveScroll: true,
                preserveState: true,
            },
        );
    };

    const dataMedicines = medicines.data || [];

    return (
        <AuthenticatedLayout>
            <Head title="Manajemen Knowledge Base Chatbot" />

            <div className="space-y-6">
                {/* Flash Message */}
                {flash.success && (
                    <div className="p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center space-x-3 text-emerald-800 shadow-xs">
                        <CheckCircle2 className="w-5 h-5 text-emerald-600 shrink-0" />
                        <div className="text-xs font-semibold">
                            {flash.success}
                        </div>
                    </div>
                )}

                {/* Page Header */}
                <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <div className="flex items-center space-x-2 mb-1">
                            <Link
                                href={route("obat.index")}
                                className="text-xs font-semibold text-emerald-700 hover:text-emerald-800 inline-flex items-center space-x-1"
                            >
                                <ArrowLeft className="w-3.5 h-3.5" />
                                <span>Kembali ke Katalog Obat</span>
                            </Link>
                        </div>
                        <h1 className="text-xl font-bold text-slate-800 tracking-tight">
                            Manajemen Knowledge Base Chatbot
                        </h1>
                        <p className="text-xs text-slate-500 mt-0.5">
                            Kelola informasi klinis, indikasi, peringatan, dan
                            referensi medis yang menjadi acuan utama respon AI
                            Chatbot.
                        </p>
                    </div>
                </div>

                {/* Toolbar Filter & Search */}
                <div className="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div className="relative w-full sm:w-96">
                        <span className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <Search className="w-4 h-4 text-emerald-600" />
                        </span>
                        <input
                            type="text"
                            value={searchQuery}
                            onChange={(e) => setSearchQuery(e.target.value)}
                            placeholder="Cari berdasarkan nama obat atau merek..."
                            className="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs placeholder-slate-400"
                        />
                    </div>

                    <div className="flex items-center space-x-3 w-full sm:w-auto">
                        <span className="text-xs font-semibold text-slate-600 shrink-0">
                            Status:
                        </span>
                        <select
                            value={selectedStatus}
                            onChange={(e) => setSelectedStatus(e.target.value)}
                            className="w-full sm:w-44 px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 font-medium"
                        >
                            <option value="all">Semua Status</option>
                            <option value="draft">Draft</option>
                            <option value="reviewed">Reviewed (Valid)</option>
                        </select>
                    </div>
                </div>

                {/* Tabel Data Knowledge Obat */}
                <div className="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left border-collapse">
                            <thead>
                                <tr className="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-600 uppercase tracking-wider">
                                    <th className="py-3.5 px-6">
                                        Nama Obat & Kategori
                                    </th>
                                    <th className="py-3.5 px-6">
                                        Indikasi Utama
                                    </th>
                                    <th className="py-3.5 px-6">
                                        Sumber Referensi
                                    </th>
                                    <th className="py-3.5 px-6 text-center">
                                        Status Validasi
                                    </th>
                                    <th className="py-3.5 px-6 text-right">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100 text-xs text-slate-700">
                                {dataMedicines.length > 0 ? (
                                    dataMedicines.map((med) => (
                                        <tr
                                            key={med.id}
                                            className="hover:bg-slate-50/80 transition-colors"
                                        >
                                            <td className="py-4 px-6">
                                                <div className="font-bold text-slate-900">
                                                    {med.name}
                                                </div>
                                                <div className="text-[11px] text-emerald-700 font-medium">
                                                    {med.category?.name ||
                                                        "Umum"}{" "}
                                                    &bull; {med.dosage_form}
                                                </div>
                                            </td>
                                            <td className="py-4 px-6">
                                                <div
                                                    className="max-w-xs truncate text-slate-600"
                                                    title={
                                                        med.knowledge
                                                            ?.indications
                                                    }
                                                >
                                                    {med.knowledge
                                                        ?.indications || (
                                                        <span className="text-slate-400 italic">
                                                            Belum diisi...
                                                        </span>
                                                    )}
                                                </div>
                                            </td>
                                            <td className="py-4 px-6">
                                                {med.knowledge?.source_name ? (
                                                    <div className="flex items-center space-x-1 text-slate-700 font-medium">
                                                        <span>
                                                            {
                                                                med.knowledge
                                                                    .source_name
                                                            }
                                                        </span>
                                                        {med.knowledge
                                                            .source_url && (
                                                            <a
                                                                href={
                                                                    med
                                                                        .knowledge
                                                                        .source_url
                                                                }
                                                                target="_blank"
                                                                rel="noreferrer"
                                                                className="text-emerald-600 hover:text-emerald-800"
                                                            >
                                                                <ExternalLink className="w-3.5 h-3.5" />
                                                            </a>
                                                        )}
                                                    </div>
                                                ) : (
                                                    <span className="text-slate-400 italic">
                                                        Tidak ada sumber
                                                    </span>
                                                )}
                                            </td>
                                            <td className="py-4 px-6 text-center">
                                                <button
                                                    onClick={() =>
                                                        handleToggleStatus(med)
                                                    }
                                                    title="Klik untuk mengubah status validasi"
                                                    className="group transition-transform active:scale-95 focus:outline-none"
                                                >
                                                    {med.knowledge?.status ===
                                                    "reviewed" ? (
                                                        <span className="inline-flex items-center space-x-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase transition-colors shadow-2xs">
                                                            <ShieldCheck className="w-3 h-3" />
                                                            <span>
                                                                Reviewed
                                                            </span>
                                                        </span>
                                                    ) : (
                                                        <span className="inline-flex items-center space-x-1 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase transition-colors shadow-2xs">
                                                            <FileText className="w-3 h-3" />
                                                            <span>Draft</span>
                                                        </span>
                                                    )}
                                                </button>
                                            </td>
                                            <td className="py-4 px-6 text-right">
                                                <button
                                                    onClick={() =>
                                                        handleOpenEditModal(med)
                                                    }
                                                    className="inline-flex items-center space-x-1 bg-emerald-50 hover:bg-emerald-100 text-emerald-700 px-3 py-1.5 rounded-lg font-semibold transition-colors"
                                                >
                                                    <Edit3 className="w-3.5 h-3.5" />
                                                    <span>
                                                        {med.knowledge
                                                            ? "Edit Knowledge"
                                                            : "Tambah Knowledge"}
                                                    </span>
                                                </button>
                                            </td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td
                                            colSpan="5"
                                            className="py-12 text-center text-slate-400"
                                        >
                                            <BookOpen className="w-8 h-8 mx-auto text-slate-300 mb-2" />
                                            <p className="font-medium">
                                                Tidak ada data obat atau
                                                knowledge yang ditemukan.
                                            </p>
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>

                    {/* Paginasi */}
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
                                data
                            </div>
                            <div className="flex flex-wrap gap-1">
                                {medicines.links.map((link, idx) => (
                                    <Link
                                        key={idx}
                                        href={link.url || "#"}
                                        preserveScroll
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

                {/* MODAL EDIT / TAMBAH KNOWLEDGE */}
                {isModalOpen && activeMedicine && (
                    <div className="fixed inset-0 bg-slate-900/50 z-50 flex items-center justify-center p-4 overflow-y-auto">
                        <div className="bg-white rounded-2xl shadow-xl border border-slate-200 max-w-2xl w-full overflow-hidden animate-in fade-in zoom-in-95 duration-150 my-8">
                            {/* Modal Header */}
                            <div className="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                                <div>
                                    <h3 className="font-bold text-sm text-slate-800">
                                        Konfigurasi Knowledge Chatbot
                                    </h3>
                                    <p className="text-xs text-emerald-700 font-medium">
                                        Obat: {activeMedicine.name} (
                                        {activeMedicine.brand || "Generik"})
                                    </p>
                                </div>
                                <button
                                    onClick={() => setIsModalOpen(false)}
                                    className="text-slate-400 hover:text-slate-600 p-1 rounded-lg"
                                >
                                    <X className="w-5 h-5" />
                                </button>
                            </div>

                            {/* Modal Form */}
                            <form
                                onSubmit={handleSubmit}
                                className="p-6 space-y-4 max-h-[75vh] overflow-y-auto"
                            >
                                <div>
                                    <label className="block text-xs font-semibold text-slate-700 mb-1">
                                        Indikasi (Kegunaan Obat)
                                    </label>
                                    <TextAreaAAutosize
                                        minRows="2"
                                        maxRows="6"
                                        value={data.indications}
                                        onChange={(e) =>
                                            setData(
                                                "indications",
                                                e.target.value,
                                            )
                                        }
                                        placeholder="Cth: Meredakan demam dan nyeri ringan sampai sedang..."
                                        className="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500"
                                    ></TextAreaAAutosize>
                                    {errors.indications && (
                                        <span className="text-rose-500 text-[10px] mt-1 block">
                                            {errors.indications}
                                        </span>
                                    )}
                                </div>

                                <div>
                                    <label className="block text-xs font-semibold text-slate-700 mb-1">
                                        Kontraindikasi (Larangan Penggunaan)
                                    </label>
                                    <TextAreaAAutosize
                                        minRows="2"
                                        maxRows="6"
                                        value={data.contraindications}
                                        onChange={(e) =>
                                            setData(
                                                "contraindications",
                                                e.target.value,
                                            )
                                        }
                                        placeholder="Cth: Tidak boleh diberikan pada pasien dengan gangguan hati berat..."
                                        className="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500"
                                    ></TextAreaAAutosize>
                                    {errors.contraindications && (
                                        <span className="text-rose-500 text-[10px] mt-1 block">
                                            {errors.contraindications}
                                        </span>
                                    )}
                                </div>

                                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label className="block text-xs font-semibold text-slate-700 mb-1">
                                            Peringatan (Warnings)
                                        </label>
                                        <TextAreaAAutosize
                                            minRows="2"
                                            maxRows="6"
                                            value={data.warnings}
                                            onChange={(e) =>
                                                setData(
                                                    "warnings",
                                                    e.target.value,
                                                )
                                            }
                                            placeholder="Cth: Hati-hati penggunaan pada penderita alkoholisme..."
                                            className="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500"
                                        ></TextAreaAAutosize>
                                        {errors.warnings && (
                                            <span className="text-rose-500 text-[10px] mt-1 block">
                                                {errors.warnings}
                                            </span>
                                        )}
                                    </div>
                                    <div>
                                        <label className="block text-xs font-semibold text-slate-700 mb-1">
                                            Efek Samping
                                        </label>
                                        <TextAreaAAutosize
                                            minRows="2"
                                            maxRows="6"
                                            value={data.side_effects}
                                            onChange={(e) =>
                                                setData(
                                                    "side_effects",
                                                    e.target.value,
                                                )
                                            }
                                            placeholder="Cth: Mual, muntah, reaksi alergi ringan..."
                                            className="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500"
                                        ></TextAreaAAutosize>
                                        {errors.side_effects && (
                                            <span className="text-rose-500 text-[10px] mt-1 block">
                                                {errors.side_effects}
                                            </span>
                                        )}
                                    </div>
                                </div>

                                <div className="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                                    <div>
                                        <label className="block text-xs font-semibold text-slate-700 mb-1">
                                            Nama Sumber Referensi
                                        </label>
                                        <input
                                            type="text"
                                            value={data.source_name}
                                            onChange={(e) =>
                                                setData(
                                                    "source_name",
                                                    e.target.value,
                                                )
                                            }
                                            placeholder="Cth: ISO Farmakoterapi / BPOM"
                                            className="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500"
                                        />
                                        {errors.source_name && (
                                            <span className="text-rose-500 text-[10px] mt-1 block">
                                                {errors.source_name}
                                            </span>
                                        )}
                                    </div>
                                    <div>
                                        <label className="block text-xs font-semibold text-slate-700 mb-1">
                                            URL Sumber Referensi
                                        </label>
                                        <input
                                            type="url"
                                            value={data.source_url}
                                            onChange={(e) =>
                                                setData(
                                                    "source_url",
                                                    e.target.value,
                                                )
                                            }
                                            placeholder="Cth: https://cekbpom.pom.go.id/..."
                                            className="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500"
                                        />
                                        {errors.source_url && (
                                            <span className="text-rose-500 text-[10px] mt-1 block">
                                                {errors.source_url}
                                            </span>
                                        )}
                                    </div>
                                </div>

                                <div>
                                    <label className="block text-xs font-semibold text-slate-700 mb-1">
                                        Status Validasi Knowledge *
                                    </label>
                                    <select
                                        value={data.status}
                                        onChange={(e) =>
                                            setData("status", e.target.value)
                                        }
                                        className="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 font-medium"
                                    >
                                        <option value="draft">
                                            Draft (Belum divalidasi penuh)
                                        </option>
                                        <option value="reviewed">
                                            Reviewed (Valid, siap diacu chatbot)
                                        </option>
                                    </select>
                                    {errors.status && (
                                        <span className="text-rose-500 text-[10px] mt-1 block">
                                            {errors.status}
                                        </span>
                                    )}
                                </div>

                                <div className="flex justify-end space-x-2 pt-4 border-t border-slate-100">
                                    <button
                                        type="button"
                                        onClick={() => setIsModalOpen(false)}
                                        className="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100"
                                    >
                                        Batal
                                    </button>
                                    <button
                                        type="submit"
                                        disabled={processing}
                                        className="bg-emerald-700 hover:bg-emerald-800 text-white px-4 py-2 rounded-xl text-xs font-semibold shadow-xs transition-colors disabled:opacity-50"
                                    >
                                        {processing
                                            ? "Menyimpan..."
                                            : "Simpan Knowledge"}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                )}
            </div>
        </AuthenticatedLayout>
    );
}
