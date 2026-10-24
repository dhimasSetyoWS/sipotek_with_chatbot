import React from "react";
import { Search, Filter } from "lucide-react";
const FilterSearch = ({searchQuery, setSearchQuery, selectedClassification, setSelectedClassification}) => {
    return (
        <div className="bg-white p-4 rounded-xl border border-slate-200 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-3">
            <div className="relative w-full sm:w-80">
                <span className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <Search className="w-4 h-4" />
                </span>
                <input
                    type="text"
                    value={searchQuery}
                    onChange={setSearchQuery}
                    placeholder="Cari nama obat, merk, atau No BPOM..."
                    className="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:bg-white transition-colors text-slate-800"
                />
            </div>

            <div className="flex items-center space-x-3 w-full sm:w-auto">
                <div className="flex items-center space-x-1.5 text-xs text-slate-500">
                    <Filter className="w-3.5 h-3.5" />
                    <span>Klasifikasi:</span>
                </div>
                <select
                    value={selectedClassification}
                    onChange={(e) => setSelectedClassification(e.target.value)}
                    className="bg-slate-50 border border-slate-200 rounded-lg text-xs px-3 py-2 text-slate-700 focus:outline-none focus:ring-1 focus:ring-emerald-600 pe-14"
                >
                    <option value="all">Semua Klasifikasi</option>
                    <option value="bebas">Bebas</option>
                    <option value="bebas_terbatas">Bebas Terbatas</option>
                    <option value="keras">Keras</option>
                    <option value="psikotropika">Psikotropika</option>
                    <option value="narkotika">Narkotika</option>
                </select>
            </div>
        </div>
    );
};

export default FilterSearch;
