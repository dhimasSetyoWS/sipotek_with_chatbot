import React, { useState } from "react";
import {
    Menu,
    Search,
    Clock,
    Bell,
    ChevronDown,
    ShieldCheck,
    User,
    Sliders,
    LogOut,
    Pill,
    FileText,
} from "lucide-react";

export default function Header({
    setSidebarOpen,
    formattedTime,
    formattedDate,
}) {
    const [notificationsOpen, setNotificationsOpen] = useState(false);
    const [profileDropdownOpen, setProfileDropdownOpen] = useState(false);

    return (
        <header className="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 sticky top-0 z-30">
            {/* Left: Mobile Toggle & Quick Search */}
            <div className="flex items-center space-x-3">
                <button
                    onClick={() => setSidebarOpen(true)}
                    className="lg:hidden text-slate-600 hover:text-slate-900 p-2 rounded-lg hover:bg-slate-100 transition-colors"
                >
                    <Menu className="w-5 h-5" />
                </button>

                {/* Quick Search */}
                <div className="relative hidden sm:block w-64 md:w-80">
                    <span className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <Search className="w-4 h-4" />
                    </span>
                    <input
                        type="text"
                        placeholder="Cari obat (Barangkode, Nama, Generik)..."
                        className="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-1 focus:ring-emerald-600 focus:bg-white focus:border-emerald-600 transition-colors text-slate-800 placeholder-slate-400"
                    />
                </div>
            </div>

            {/* Right: Date/Time, Notifications & Profile */}
            <div className="flex items-center space-x-2 sm:space-x-4">
                {/* Live Clock */}
                <div className="hidden lg:flex items-center space-x-2 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-lg text-xs text-emerald-900">
                    <Clock className="w-3.5 h-3.5 text-emerald-700" />
                    <span className="font-semibold">{formattedTime}</span>
                    <span className="text-emerald-300">|</span>
                    <span className="text-emerald-800">{formattedDate}</span>
                </div>

                {/* Notifications Dropdown */}
                <div className="relative">
                    <button
                        onClick={() => {
                            setNotificationsOpen(!notificationsOpen);
                            setProfileDropdownOpen(false);
                        }}
                        className="relative p-2 text-slate-600 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg transition-colors"
                        title="Pemberitahuan"
                    >
                        <Bell className="w-5 h-5" />
                        <span className="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white" />
                    </button>

                    {notificationsOpen && (
                        <div className="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-slate-200 py-3 z-50">
                            <div className="px-4 pb-2 border-b border-slate-100 flex items-center justify-between">
                                <span className="font-bold text-xs text-slate-800 uppercase tracking-wider">
                                    Pemberitahuan Farmasi
                                </span>
                                <span className="text-[10px] bg-rose-50 text-rose-600 font-bold px-2 py-0.5 rounded">
                                    3 Penting
                                </span>
                            </div>
                            <div className="divide-y divide-slate-100 max-h-72 overflow-y-auto">
                                <div className="p-3 hover:bg-slate-50 transition-colors cursor-pointer flex space-x-3">
                                    <div className="p-2 rounded bg-rose-50 text-rose-600 shrink-0 h-fit">
                                        <Pill className="w-4 h-4" />
                                    </div>
                                    <div>
                                        <p className="text-xs font-semibold text-slate-800">
                                            Peringatan Kadaluarsa Obat
                                        </p>
                                        <p className="text-xs text-slate-500 mt-0.5">
                                            Paracetamol 500mg Batch #B204
                                            kedaluwarsa dalam 14 hari.
                                        </p>
                                        <span className="text-[10px] text-slate-400 mt-1 block">
                                            10 Menit lalu
                                        </span>
                                    </div>
                                </div>
                                <div className="p-3 hover:bg-slate-50 transition-colors cursor-pointer flex space-x-3">
                                    <div className="p-2 rounded bg-amber-50 text-amber-600 shrink-0 h-fit">
                                        <FileText className="w-4 h-4" />
                                    </div>
                                    <div>
                                        <p className="text-xs font-semibold text-slate-800">
                                            Resep Digital Masuk
                                        </p>
                                        <p className="text-xs text-slate-500 mt-0.5">
                                            Resep baru dari Dr. Aris Pratama,
                                            Sp.PD belum terproses.
                                        </p>
                                        <span className="text-[10px] text-slate-400 mt-1 block">
                                            35 Menit lalu
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div className="pt-2 px-4 border-t border-slate-100 text-center">
                                <button className="text-xs text-emerald-700 font-semibold hover:underline">
                                    Lihat Semua Pemberitahuan
                                </button>
                            </div>
                        </div>
                    )}
                </div>

                <div className="h-6 w-px bg-slate-200 hidden sm:block" />

                {/* Pharmacist Profile Dropdown */}
                <div className="relative">
                    <button
                        onClick={() => {
                            setProfileDropdownOpen(!profileDropdownOpen);
                            setNotificationsOpen(false);
                        }}
                        className="flex items-center space-x-3 p-1.5 rounded-lg hover:bg-slate-100 transition-colors"
                    >
                        <div className="relative">
                            <div className="w-9 h-9 rounded-lg bg-emerald-700 flex items-center justify-center text-white font-bold text-xs">
                                AP
                            </div>
                            <span className="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-500 border-2 border-white rounded-full"></span>
                        </div>
                        <div className="hidden md:block text-left">
                            <span className="block text-xs font-bold text-slate-800 leading-tight">
                                Apt. Budi Santoso, S.Farm
                            </span>
                            <span className="block text-[10px] text-emerald-700 font-medium">
                                SIPA: 19920815/SIPA/2024
                            </span>
                        </div>
                        <ChevronDown className="w-4 h-4 text-slate-400 hidden sm:block" />
                    </button>

                    {profileDropdownOpen && (
                        <div className="absolute right-0 mt-2 w-60 bg-white rounded-xl shadow-lg border border-slate-200 py-2 z-50">
                            <div className="px-4 py-2.5 border-b border-slate-100">
                                <p className="text-xs font-bold text-slate-800">
                                    Apt. Budi Santoso, S.Farm
                                </p>
                                <p className="text-[11px] text-slate-500 truncate">
                                    Apoteker Penanggung Jawab (APJ)
                                </p>
                                <div className="mt-1.5 inline-flex items-center space-x-1 text-[10px] bg-emerald-50 text-emerald-800 font-semibold px-2 py-0.5 rounded border border-emerald-200">
                                    <ShieldCheck className="w-3 h-3 text-emerald-700" />
                                    <span>STR Valid s/d 2028</span>
                                </div>
                            </div>
                            <div className="py-1">
                                <button className="w-full text-left px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 flex items-center space-x-2.5">
                                    <User className="w-4 h-4 text-slate-400" />
                                    <span>Profil Apoteker</span>
                                </button>
                                <button className="w-full text-left px-4 py-2 text-xs text-slate-700 hover:bg-slate-50 flex items-center space-x-2.5">
                                    <Sliders className="w-4 h-4 text-slate-400" />
                                    <span>Pengaturan Akun</span>
                                </button>
                            </div>
                            <div className="border-t border-slate-100 pt-1">
                                <button className="w-full text-left px-4 py-2 text-xs text-rose-600 hover:bg-rose-50 flex items-center space-x-2.5 font-medium">
                                    <LogOut className="w-4 h-4 text-rose-500" />
                                    <span>Keluar (Logout)</span>
                                </button>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </header>
    );
}