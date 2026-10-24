import React from "react";
import { Pill, Building2, ChevronLeft, ChevronRight, X } from "lucide-react";
import { PHARMACY_NAV_ITEMS } from "./navItems";
import { Link } from "@inertiajs/react";

export default function Sidebar({
    sidebarOpen,
    setSidebarOpen,
    sidebarCollapsed,
    setSidebarCollapsed,
    activeShift,
    setActiveShift,
}) {
    return (
        <>
            {/* Mobile Overlay */}
            {sidebarOpen && (
                <div
                    className="fixed inset-0 bg-emerald-950/50 z-40 lg:hidden transition-opacity"
                    onClick={() => setSidebarOpen(false)}
                />
            )}

            <aside
                className={`
          fixed inset-y-0 left-0 z-50 bg-emerald-950 text-slate-200 flex flex-col transition-all duration-300 ease-in-out lg:top-0 lg:h-screen lg:sticky border-r border-emerald-900
          ${sidebarOpen ? "translate-x-0" : "-translate-x-full lg:translate-x-0"}
          ${sidebarCollapsed ? "lg:w-20" : "lg:w-72"}
          w-72
        `}
            >
                {/* Brand Header */}
                <div className="h-16 flex items-center justify-between px-4 bg-emerald-900 border-b border-emerald-800">
                    {!sidebarCollapsed && (
                        <div className="flex items-center space-x-3 overflow-hidden">
                            <div className="h-10 w-10 min-w-10 rounded-lg bg-emerald-700 flex items-center justify-center text-white font-bold">
                                <Pill className="w-5 h-5" />
                            </div>
                            {!sidebarCollapsed && (
                                <div className="truncate">
                                    <span className="font-bold text-white tracking-wide text-base block leading-tight">
                                        Apotek Care
                                    </span>
                                    <span className="text-[10px] text-emerald-300 font-medium tracking-wider uppercase">
                                        Sistem Informasi Farmasi
                                    </span>
                                </div>
                            )}
                        </div>
                    )}

                    {/* Desktop Collapse Toggle */}
                    <button
                        onClick={() => setSidebarCollapsed(!sidebarCollapsed)}
                        className="hidden lg:flex p-1.5 rounded-lg text-emerald-300 hover:text-white hover:bg-emerald-800 transition-colors"
                        title={
                            sidebarCollapsed
                                ? "Perluas Sidebar"
                                : "Penyetkan Sidebar"
                        }
                    >
                        {sidebarCollapsed ? (
                            <ChevronRight className="w-5 h-5" />
                        ) : (
                            <ChevronLeft className="w-5 h-5" />
                        )}
                    </button>

                    {/* Mobile Close Button */}
                    <button
                        onClick={() => setSidebarOpen(false)}
                        className="lg:hidden text-emerald-300 hover:text-white p-1 rounded-lg hover:bg-emerald-800 transition-colors"
                    >
                        <X className="w-5 h-5" />
                    </button>
                </div>

                {/* Status Shift Banner */}
                {!sidebarCollapsed ? (
                    <div className="mx-4 mt-4 p-3 rounded-lg bg-emerald-900/50 border border-emerald-800 flex items-center justify-between">
                        <div className="flex items-center space-x-2.5">
                            <span className="relative flex h-2.5 w-2.5">
                                <span
                                    className={`absolute inline-flex h-full w-full rounded-full ${activeShift ? "bg-emerald-400" : "bg-amber-400"} opacity-75`}
                                ></span>
                                <span
                                    className={`relative inline-flex rounded-full h-2.5 w-2.5 ${activeShift ? "bg-emerald-500" : "bg-amber-500"}`}
                                ></span>
                            </span>
                            <div>
                                <p className="text-xs font-semibold text-white">
                                    Status Shift
                                </p>
                                <p className="text-[11px] text-emerald-300">
                                    {activeShift
                                        ? "Petugas Aktif (Shift 1)"
                                        : "Shift Non-Aktif"}
                                </p>
                            </div>
                        </div>
                        <button
                            onClick={() => setActiveShift(!activeShift)}
                            className="text-[10px] bg-emerald-800 hover:bg-emerald-700 text-emerald-100 px-2.5 py-1 rounded-md transition-colors font-medium"
                        >
                            Ubah
                        </button>
                    </div>
                ) : (
                    <div
                        className="mx-auto mt-4 flex justify-center"
                        title="Status Shift Aktif"
                    >
                        <span className="relative flex h-3 w-3">
                            <span className="absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span className="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                        </span>
                    </div>
                )}

                {/* Navigation Items */}
                <div className="flex-1 py-4 px-3 space-y-6 overflow-y-auto">
                    {PHARMACY_NAV_ITEMS.map((group, gIdx) => (
                        <div key={gIdx} className="space-y-1">
                            {!sidebarCollapsed ? (
                                <div className="px-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-emerald-400/70">
                                    {group.title}
                                </div>
                            ) : (
                                <div className="h-px bg-emerald-800/40 my-2 mx-2" />
                            )}
                            {group.items.map((item) => {
                                const Icon = item.icon;
                                return (
                                    <Link
                                        href={route(item.target)}
                                        key={item.name}
                                        className={`
                      w-full flex items-center space-x-3 px-3 py-2.5 rounded-lg font-medium text-sm transition-colors group relative
                      ${
                          route().current() == item.target
                              ? "bg-emerald-700 text-white font-semibold"
                              : "text-emerald-200/80 hover:text-white hover:bg-emerald-900"
                      }
                      ${sidebarCollapsed ? "justify-center px-0" : ""}
                    `}
                                        title={
                                            sidebarCollapsed
                                                ? item.name
                                                : undefined
                                        }
                                    >
                                        <Icon
                                            className={`w-5 h-5 shrink-0 ${route().current() == item.target ? "text-white" : "text-emerald-300 group-hover:text-emerald-200"}`}
                                        />

                                        {!sidebarCollapsed && (
                                            <>
                                                <span className="truncate">
                                                    {item.name}
                                                </span>
                                                {item.badge && (
                                                    <span
                                                        className={`ml-auto text-[10px] font-bold px-2 py-0.5 rounded ${
                                                            route().current() ==
                                                            item.target
                                                                ? "bg-emerald-800 text-white"
                                                                : "bg-emerald-900 text-emerald-300"
                                                        }`}
                                                    >
                                                        {item.badge}
                                                    </span>
                                                )}
                                            </>
                                        )}

                                        {route().current() == item.target && (
                                            <div className="absolute left-0 top-2 bottom-2 w-1 bg-emerald-400 rounded-r" />
                                        )}
                                    </Link>
                                );
                            })}
                        </div>
                    ))}
                </div>

                {/* Sidebar Footer */}
                <div className="p-3 bg-emerald-950 border-t border-emerald-900">
                    {!sidebarCollapsed ? (
                        <div className="flex items-center justify-between p-2 rounded-lg bg-emerald-900/40">
                            <div className="flex items-center space-x-2.5 min-w-0">
                                <div className="p-2 rounded bg-emerald-800 text-emerald-200">
                                    <Building2 className="w-4 h-4" />
                                </div>
                                <div className="truncate">
                                    <p className="text-xs font-semibold text-white truncate">
                                        Apotek Sehat Utama
                                    </p>
                                    <p className="text-[10px] text-emerald-300 truncate">
                                        SIA: 449/012/SIA/2026
                                    </p>
                                </div>
                            </div>
                        </div>
                    ) : (
                        <div
                            className="flex justify-center p-2 text-emerald-300"
                            title="Apotek Sehat Utama - SIA: 449/012/SIA/2026"
                        >
                            <Building2 className="w-5 h-5" />
                        </div>
                    )}
                </div>
            </aside>
        </>
    );
}
