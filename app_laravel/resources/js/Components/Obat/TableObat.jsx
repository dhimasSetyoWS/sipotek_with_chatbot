import React from "react";
import { Edit, Trash2 } from "lucide-react";
import Swal from "sweetalert2";
import { router } from "@inertiajs/react";
const TableObat = ({ obats, openEditModal }) => {
    const handleDelete = (id) => {
        Swal.fire({
            icon: "error",
            title: "Yakin Hapus Data?",
            text: "Data tidak akan di pulihkan!",
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonText: "Hapus!",
            cancelButtonText: "Cancel!",
        }).then((result) => {
            if (result.isConfirmed) {
                router.delete(route("obat.delete", id));
            }
        });
    };

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
                    <span className="bg-slate-100 text-slate-700 px-2 py-0.5 rounded text-[10px] font-bold uppercase">
                        {classification}
                    </span>
                );
        }
    };
    return (
        <div className="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
            <div className="overflow-x-auto">
                <table className="w-full text-left border-collapse">
                    <thead>
                        <tr className="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-600 uppercase tracking-wider">
                            <th className="py-3 px-4">Nama & Merek</th>
                            <th className="py-3 px-4">Kategori & Bentuk</th>
                            <th className="py-3 px-4">Zat Aktif & Kekuatan</th>
                            <th className="py-3 px-4">No. Registrasi (BPOM)</th>
                            <th className="py-3 px-4 text-center">
                                Klasifikasi
                            </th>
                            <th className="py-3 px-4 text-center">Status</th>
                            <th className="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-slate-100 text-xs text-slate-700">
                        {obats.length > 0 ? (
                            obats.map((med) => (
                                <tr
                                    key={med.id}
                                    className="hover:bg-slate-50/80 transition-colors"
                                >
                                    <td className="py-3 px-4">
                                        <div className="font-bold text-slate-800">
                                            {med.name}
                                        </div>
                                        <div className="text-[11px] text-slate-400">
                                            Merk: {med.brand || "-"}
                                        </div>
                                    </td>
                                    <td className="py-3 px-4">
                                        <div className="font-medium text-slate-700">
                                            {med.category.name}
                                        </div>
                                        <div className="text-[11px] text-emerald-700 capitalize font-medium">
                                            {med.dosage_form}
                                        </div>
                                    </td>
                                    <td className="py-3 px-4">
                                        <div
                                            className="text-slate-800 max-w-xs truncate"
                                            title={med.active_ingredients}
                                        >
                                            {med.active_ingredients || "-"}
                                        </div>
                                        <div className="text-[11px] text-slate-400 font-mono">
                                            Str: {med.strength || "-"}
                                        </div>
                                    </td>
                                    <td className="py-3 px-4 font-mono text-[11px] text-slate-600">
                                        {med.registration_number}
                                    </td>
                                    <td className="py-3 px-4 text-center w-sm">
                                        {getClassificationBadge(
                                            med.classification,
                                        )}
                                    </td>
                                    <td className="py-3 px-4 text-center">
                                        {med.is_active ? (
                                            <span className="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700">
                                                Aktif
                                            </span>
                                        ) : (
                                            <span className="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-500">
                                                Non-Aktif
                                            </span>
                                        )}
                                    </td>
                                    <td className="py-3 px-4 text-right">
                                        <div className="flex items-center justify-end space-x-1">
                                            <button
                                                onClick={() =>
                                                    openEditModal(med)
                                                }
                                                className="p-1.5 rounded text-slate-400 hover:text-emerald-700 hover:bg-emerald-50 transition-colors"
                                                title="Edit Obat"
                                            >
                                                <Edit className="w-4 h-4" />
                                            </button>
                                            <button
                                                className="p-1.5 rounded text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition-colors"
                                                title="Hapus Obat"
                                                onClick={() =>
                                                    handleDelete(med.id)
                                                }
                                            >
                                                <Trash2 className="w-4 h-4" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            ))
                        ) : (
                            <tr>
                                <td
                                    colSpan="7"
                                    className="py-8 text-center text-slate-400"
                                >
                                    Tidak ada data obat yang ditemukan.
                                </td>
                            </tr>
                        )}
                    </tbody>
                </table>
            </div>
        </div>
    );
};

export default TableObat;
