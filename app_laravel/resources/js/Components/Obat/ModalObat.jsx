import React from "react";
import { Pill, X } from "lucide-react";
export default function ModalObat({
    setIsModalOpen,
    handleSubmit,
    data,
    errors,
    categories,
    processing,
    setData,
    mode = "add",
}) {
    const isEdit = mode === "edit";
    return (
        <div className="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-50 flex items-center justify-center p-4">
            <div className="bg-white rounded-2xl shadow-xl border border-slate-200 max-w-2xl w-full overflow-hidden animate-in fade-in zoom-in-95 duration-150">
                <div className="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                    <h3 className="font-bold text-sm text-slate-800 flex items-center space-x-2">
                        <Pill className="w-4 h-4 text-emerald-700" />
                        {isEdit ? (
                            <span>Form Edit Master Obat </span>
                        ) : (
                            <span>Form Tambah Master Obat Baru</span>
                        )}
                    </h3>
                    <button
                        onClick={() => setIsModalOpen(false)}
                        className="text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-200/50 transition-colors"
                    >
                        <X className="w-5 h-5" />
                    </button>
                </div>

                <form onSubmit={handleSubmit}>
                    <div className="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label className="block text-xs font-semibold text-slate-700 mb-1">
                                    Nama Generik Obat *
                                </label>
                                <input
                                    type="text"
                                    value={data.name}
                                    onChange={(e) =>
                                        setData("name", e.target.value)
                                    }
                                    placeholder="Contoh: Paracetamol 500 mg"
                                    className="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-1 focus:ring-emerald-600"
                                />
                                {errors.name && (
                                    <span className="text-rose-500 text-[10px] mt-0.5 block">
                                        {errors.name}
                                    </span>
                                )}
                            </div>
                            <div>
                                <label className="block text-xs font-semibold text-slate-700 mb-1">
                                    Nama Dagang / Merek
                                </label>
                                <input
                                    type="text"
                                    value={data.brand}
                                    onChange={(e) =>
                                        setData("brand", e.target.value)
                                    }
                                    placeholder="Contoh: Sanmol"
                                    className="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-1 focus:ring-emerald-600"
                                />
                                {errors.brand && (
                                    <span className="text-rose-500 text-[10px] mt-0.5 block">
                                        {errors.brand}
                                    </span>
                                )}
                            </div>
                        </div>

                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label className="block text-xs font-semibold text-slate-700 mb-1">
                                    Kategori Obat *
                                </label>
                                <select
                                    value={data.category_id}
                                    onChange={(e) =>
                                        setData("category_id", e.target.value)
                                    }
                                    className="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-1 focus:ring-emerald-600"
                                >
                                    <option value="">Pilih Kategori</option>
                                    {categories.map((cat) => (
                                        <option key={cat.id} value={cat.id}>
                                            {cat.name}
                                        </option>
                                    ))}
                                </select>
                                {errors.category_id && (
                                    <span className="text-rose-500 text-[10px] mt-0.5 block">
                                        {errors.category_id}
                                    </span>
                                )}
                            </div>
                            <div>
                                <label className="block text-xs font-semibold text-slate-700 mb-1">
                                    Bentuk Sediaan (Dosage Form) *
                                </label>
                                <select
                                    value={data.dosage_form}
                                    onChange={(e) =>
                                        setData("dosage_form", e.target.value)
                                    }
                                    className="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-1 focus:ring-emerald-600"
                                >
                                    <option value="tablet">Tablet</option>
                                    <option value="kapsul">Kapsul</option>
                                    <option value="sirup">Sirup</option>
                                    <option value="injeksi">Injeksi</option>
                                    <option value="salep">Salep / Krim</option>
                                </select>
                                {errors.dosage_form && (
                                    <span className="text-rose-500 text-[10px] mt-0.5 block">
                                        {errors.dosage_form}
                                    </span>
                                )}
                            </div>
                        </div>

                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label className="block text-xs font-semibold text-slate-700 mb-1">
                                    Kekuatan (Strength)
                                </label>
                                <input
                                    type="text"
                                    value={data.strength}
                                    onChange={(e) =>
                                        setData("strength", e.target.value)
                                    }
                                    placeholder="Contoh: 500mg, 250mg/5ml"
                                    className="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-1 focus:ring-emerald-600"
                                />
                                {errors.strength && (
                                    <span className="text-rose-500 text-[10px] mt-0.5 block">
                                        {errors.strength}
                                    </span>
                                )}
                            </div>
                            <div>
                                <label className="block text-xs font-semibold text-slate-700 mb-1">
                                    Nomor Registrasi / BPOM *
                                </label>
                                <input
                                    type="text"
                                    value={data.registration_number}
                                    onChange={(e) =>
                                        setData(
                                            "registration_number",
                                            e.target.value,
                                        )
                                    }
                                    placeholder="Contoh: DBL8914704010A1"
                                    className="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-1 focus:ring-emerald-600 font-mono"
                                />
                                {errors.registration_number && (
                                    <span className="text-rose-500 text-[10px] mt-0.5 block">
                                        {errors.registration_number}
                                    </span>
                                )}
                            </div>
                        </div>

                        <div>
                            <label className="block text-xs font-semibold text-slate-700 mb-1">
                                Kandungan Zat Aktif
                            </label>
                            <textarea
                                rows="2"
                                value={data.active_ingredients}
                                onChange={(e) =>
                                    setData(
                                        "active_ingredients",
                                        e.target.value,
                                    )
                                }
                                placeholder="Tuliskan komposisi kandungan zat aktif..."
                                className="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-1 focus:ring-emerald-600"
                            ></textarea>
                            {errors.active_ingredients && (
                                <span className="text-rose-500 text-[10px] mt-0.5 block">
                                    {errors.active_ingredients}
                                </span>
                            )}
                        </div>

                        <div>
                            <label className="block text-xs font-semibold text-slate-700 mb-1">
                                Klasifikasi Keamanan Obat *
                            </label>
                            <select
                                value={data.classification}
                                onChange={(e) =>
                                    setData("classification", e.target.value)
                                }
                                className="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-1 focus:ring-emerald-600"
                            >
                                <option value="bebas">
                                    Obat Bebas (Lingkaran Hijau)
                                </option>
                                <option value="bebas_terbatas">
                                    Obat Bebas Terbatas (Lingkaran Biru)
                                </option>
                                <option value="keras">
                                    Obat Keras (Lingkaran Merah Huruf K)
                                </option>
                                <option value="psikotropika">
                                    Psikotropika
                                </option>
                                <option value="narkotika">Narkotika</option>
                                <option value="jamu">Jamu / Herbal</option>
                            </select>
                            {errors.classification && (
                                <span className="text-rose-500 text-[10px] mt-0.5 block">
                                    {errors.classification}
                                </span>
                            )}
                        </div>
                    </div>

                    <div className="px-6 py-3 border-t border-slate-100 bg-slate-50 flex items-center justify-end space-x-3">
                        <button
                            type="button"
                            onClick={() => setIsModalOpen(false)}
                            className="px-4 py-2 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-200/60 transition-colors"
                        >
                            Batal
                        </button>
                        <button
                            type="submit"
                            disabled={processing}
                            className="px-4 py-2 rounded-lg text-xs font-semibold bg-emerald-700 text-white hover:bg-emerald-800 transition-colors shadow-sm disabled:opacity-50"
                        >
                            {processing ? "Menyimpan..." : "Simpan Obat"}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}
