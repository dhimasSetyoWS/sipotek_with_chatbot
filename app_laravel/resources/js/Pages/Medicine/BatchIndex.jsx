import React, { useState, useEffect } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import { useDebounce } from "use-debounce";
import { useForm } from "@inertiajs/react";
import { Plus, X } from "lucide-react";
import {
    Package,
    Search,
    Calendar,
    AlertTriangle,
    CheckCircle2,
    ArrowLeft,
} from "lucide-react";
import formatDate from "@/utils/formatDate";

export default function BatchIndex({ batches, filters, medicines }) {
    const [searchQuery, setSearchQuery] = useState(filters?.search || "");
    const [debouncedSearch] = useDebounce(searchQuery, 500);
    const [isModalOpen, setIsModalOpen] = useState(false);
    // Form Inertia untuk Tambah Batch
    const { data, setData, post, processing, reset, errors, clearErrors } =
        useForm({
            medicine_id: "",
            batch_number: "",
            stock_quantity: "",
            expiry_date: "",
        });

    const handleOpenModal = () => {
        reset();
        clearErrors();
        setIsModalOpen(true);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route("obat.batches.store"), {
            onSuccess: () => {
                setIsModalOpen(false);
                reset();
            },
        });
    };

    // Live search dengan debounce
    useEffect(() => {
        if (debouncedSearch === (filters?.search || "")) return;

        router.get(
            route("obat.batches.index"),
            { search: debouncedSearch },
            { preserveState: true, replace: true, preserveScroll: true },
        );
    }, [debouncedSearch]);

    // Helper status kedaluwarsa (FEFO & Warning)
    const getExpiryStatusBadge = (dateStr) => {
        const expDate = new Date(dateStr);
        const today = new Date();
        const diffMonths =
            (expDate.getFullYear() - today.getFullYear()) * 12 +
            (expDate.getMonth() - today.getMonth());

        if (expDate < today) {
            return (
                <span className="inline-flex items-center space-x-1 bg-rose-50 text-rose-700 border border-rose-200 px-2.5 py-1 rounded-lg text-[10px] font-bold">
                    <AlertTriangle className="w-3 h-3" />
                    <span>Sudah Expired</span>
                </span>
            );
        } else if (diffMonths <= 3) {
            return (
                <span className="inline-flex items-center space-x-1 bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-1 rounded-lg text-[10px] font-bold">
                    <AlertTriangle className="w-3 h-3" />
                    <span>Segera ED (&le; 3 Bulan)</span>
                </span>
            );
        }
        return (
            <span className="inline-flex items-center space-x-1 bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-lg text-[10px] font-bold">
                <CheckCircle2 className="w-3 h-3" />
                <span>Aman</span>
            </span>
        );
    };

    const dataBatches = batches.data || [];

    return (
        <AuthenticatedLayout>
            <Head title="Monitoring Batch & Kedaluwarsa Obat" />

            <div className="space-y-6">
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
                            Monitoring Batch & Kedaluwarsa Obat
                        </h1>
                        <p className="text-xs text-slate-500 mt-0.5 mb-2">
                            Pantau seluruh nomor batch, sisa stok, dan tanggal
                            kedaluwarsa berbasis metode FEFO (First Expired,
                            First Out).
                        </p>
                        {/* Tombol Tambah Batch Baru */}
                        <button
                            onClick={handleOpenModal}
                            className="inline-flex items-center justify-center space-x-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold px-4 py-2.5 rounded-lg transition-colors shadow-sm"
                        >
                            <Plus className="w-4 h-4" />
                            <span>Tambah Batch Baru</span>
                        </button>
                    </div>
                </div>

                {/* Toolbar Pencarian */}
                <div className="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div className="relative w-full sm:w-96">
                        <span className="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <Search className="w-4 h-4 text-emerald-600" />
                        </span>
                        <input
                            type="text"
                            value={searchQuery}
                            onChange={(e) => setSearchQuery(e.target.value)}
                            placeholder="Cari nomor batch atau nama obat..."
                            className="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-2xs placeholder-slate-400"
                        />
                    </div>
                    <div className="text-xs text-slate-500">
                        Total Batch Terdaftar:{" "}
                        <span className="font-bold text-slate-800">
                            {batches.total || 0} Batch
                        </span>
                    </div>
                </div>

                {/* Tabel Data Batch */}
                <div className="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
                    <div className="overflow-x-auto">
                        <table className="w-full text-left border-collapse">
                            <thead>
                                <tr className="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-600 uppercase tracking-wider">
                                    <th className="py-3.5 px-6">Nomor Batch</th>
                                    <th className="py-3.5 px-6">
                                        Nama Obat & Merek
                                    </th>
                                    <th className="py-3.5 px-6">Kategori</th>
                                    <th className="py-3.5 px-6">Sisa Stok</th>
                                    <th className="py-3.5 px-6">
                                        Tanggal Kedaluwarsa (ED)
                                    </th>
                                    <th className="py-3.5 px-6 text-center">
                                        Status ED
                                    </th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-slate-100 text-xs text-slate-700">
                                {dataBatches.length > 0 ? (
                                    dataBatches.map((batch) => (
                                        <tr
                                            key={batch.id}
                                            className="hover:bg-slate-50/80 transition-colors"
                                        >
                                            <td className="py-4 px-6 font-mono font-bold text-slate-800">
                                                {batch.batch_number}
                                            </td>
                                            <td className="py-4 px-6">
                                                <div className="font-bold text-slate-900">
                                                    {batch.medicine?.name}
                                                </div>
                                                <div className="text-[11px] text-slate-400">
                                                    Merk:{" "}
                                                    {batch.medicine?.brand ||
                                                        "-"}
                                                </div>
                                            </td>
                                            <td className="py-4 px-6 font-medium text-slate-600">
                                                {batch.medicine?.category
                                                    ?.name || "Umum"}
                                            </td>
                                            <td className="py-4 px-6">
                                                <span className="font-extrabold text-emerald-700 text-sm">
                                                    {batch.stock_quantity}
                                                </span>
                                                <span className="text-slate-400 text-[11px] ml-1">
                                                    Unit
                                                </span>
                                            </td>
                                            <td className="py-4 px-6 font-medium text-slate-700 flex items-center space-x-2 pt-5">
                                                <Calendar className="w-4 h-4 text-slate-400" />
                                                <span>
                                                    {formatDate(
                                                        batch.expiry_date,
                                                    )}
                                                </span>
                                            </td>
                                            <td className="py-4 px-6 text-center">
                                                {getExpiryStatusBadge(
                                                    batch.expiry_date,
                                                )}
                                            </td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td
                                            colSpan="6"
                                            className="py-12 text-center text-slate-400"
                                        >
                                            <Package className="w-8 h-8 mx-auto text-slate-300 mb-2" />
                                            <p className="font-medium">
                                                Tidak ada data batch obat yang
                                                ditemukan.
                                            </p>
                                        </td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>

                    {/* Navigasi Paginasi */}
                    {batches.links && batches.links.length > 3 && (
                        <div className="px-6 py-4 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                            <div className="text-xs text-slate-500">
                                Menampilkan{" "}
                                <span className="font-semibold">
                                    {batches.from || 0}
                                </span>{" "}
                                sampai{" "}
                                <span className="font-semibold">
                                    {batches.to || 0}
                                </span>{" "}
                                dari{" "}
                                <span className="font-semibold">
                                    {batches.total}
                                </span>{" "}
                                data batch
                            </div>
                            <div className="flex flex-wrap gap-1">
                                {batches.links.map((link, idx) => (
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
                {isModalOpen && (
                    <div className="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-50 flex items-center justify-center p-4">
                        <div className="bg-white rounded-2xl shadow-xl border border-slate-200 max-w-lg w-full overflow-hidden animate-in fade-in zoom-in-95 duration-150">
                            {/* Modal Header */}
                            <div className="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                                <h3 className="font-bold text-sm text-slate-800">
                                    Tambah Batch Obat Baru
                                </h3>
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
                                className="p-6 space-y-4"
                            >
                                <div>
                                    <label className="block text-xs font-semibold text-slate-700 mb-1">
                                        Pilih Obat *
                                    </label>
                                    <select
                                        value={data.medicine_id}
                                        onChange={(e) =>
                                            setData(
                                                "medicine_id",
                                                e.target.value,
                                            )
                                        }
                                        className="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500"
                                    >
                                        <option value="">
                                            -- Pilih Nama Obat --
                                        </option>
                                        {medicines.map((med) => (
                                            <option key={med.id} value={med.id}>
                                                {med.name}{" "}
                                                {med.brand
                                                    ? `(${med.brand})`
                                                    : ""}{" "}
                                                - {med.strength}
                                            </option>
                                        ))}
                                    </select>
                                    {errors.medicine_id && (
                                        <span className="text-rose-500 text-[10px] mt-1 block">
                                            {errors.medicine_id}
                                        </span>
                                    )}
                                </div>

                                <div>
                                    <label className="block text-xs font-semibold text-slate-700 mb-1">
                                        Nomor Batch *
                                    </label>
                                    <input
                                        type="text"
                                        value={data.batch_number}
                                        onChange={(e) =>
                                            setData(
                                                "batch_number",
                                                e.target.value,
                                            )
                                        }
                                        placeholder="Cth: B2026-XYZ"
                                        className="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 font-mono"
                                    />
                                    {errors.batch_number && (
                                        <span className="text-rose-500 text-[10px] mt-1 block">
                                            {errors.batch_number}
                                        </span>
                                    )}
                                </div>

                                <div className="grid grid-cols-2 gap-4">
                                    <div>
                                        <label className="block text-xs font-semibold text-slate-700 mb-1">
                                            Jumlah Stok Masuk *
                                        </label>
                                        <input
                                            type="number"
                                            min="1"
                                            value={data.stock_quantity}
                                            onChange={(e) =>
                                                setData(
                                                    "stock_quantity",
                                                    e.target.value,
                                                )
                                            }
                                            placeholder="Cth: 100"
                                            className="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500"
                                        />
                                        {errors.stock_quantity && (
                                            <span className="text-rose-500 text-[10px] mt-1 block">
                                                {errors.stock_quantity}
                                            </span>
                                        )}
                                    </div>
                                    <div>
                                        <label className="block text-xs font-semibold text-slate-700 mb-1">
                                            Tanggal Kedaluwarsa (ED) *
                                        </label>
                                        <input
                                            type="date"
                                            value={data.expiry_date}
                                            onChange={(e) =>
                                                setData(
                                                    "expiry_date",
                                                    e.target.value,
                                                )
                                            }
                                            className="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500"
                                        />
                                        {errors.expiry_date && (
                                            <span className="text-rose-500 text-[10px] mt-1 block">
                                                {errors.expiry_date}
                                            </span>
                                        )}
                                    </div>
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
                                            : "Simpan Batch"}
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
