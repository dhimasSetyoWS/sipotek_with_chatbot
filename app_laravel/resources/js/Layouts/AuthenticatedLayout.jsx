import React, { useState, useEffect } from "react";
import Sidebar from "./Sidebar";
import Header from "./Header";
import { Sparkles } from "lucide-react";
import FloatingChatbot from "@/Components/FloatingChatbot";
export default function PharmacyLayout({
    children,
}) {
    const [sidebarOpen, setSidebarOpen] = useState(false);
    const [sidebarCollapsed, setSidebarCollapsed] = useState(false);
    const [activeShift, setActiveShift] = useState(true);
    const [currentTime, setCurrentTime] = useState(new Date());

    useEffect(() => {
        const timer = setInterval(() => setCurrentTime(new Date()), 1000);
        return () => clearInterval(timer);
    }, []);

    const formattedDate = currentTime.toLocaleDateString("id-ID", {
        weekday: "long",
        day: "numeric",
        month: "short",
        year: "numeric",
    });

    const formattedTime = currentTime.toLocaleTimeString("id-ID", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
    });

    return (
        <div className="min-h-screen bg-slate-50 flex font-sans antialiased text-slate-800">
            {/* Modular Sidebar Component */}
            <Sidebar
                sidebarOpen={sidebarOpen}
                setSidebarOpen={setSidebarOpen}
                sidebarCollapsed={sidebarCollapsed}
                setSidebarCollapsed={setSidebarCollapsed}
                activeShift={activeShift}
                setActiveShift={setActiveShift}
            />

            {/* Main Wrapper */}
            <div className="flex-1 flex flex-col min-w-0 overflow-hidden">
                {/* Modular Header Component */}
                <Header
                    setSidebarOpen={setSidebarOpen}
                    formattedTime={formattedTime}
                    formattedDate={formattedDate}
                />

                {/* Main View Container */}
                <main className="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                    <div className="max-w-7xl mx-auto h-full flex flex-col">
                        {children ? (
                            children
                        ) : (
                            <div className="flex-1 min-h-[500px] border border-slate-300 rounded-xl bg-white flex flex-col items-center justify-center p-8 text-center">
                                <div className="w-16 h-16 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center justify-center text-emerald-700 mb-4">
                                    <Sparkles className="w-8 h-8" />
                                </div>
                                <h3 className="text-lg font-bold text-slate-800">
                                    Wadah Konten Utama Dashboard (Inertia Slot)
                                </h3>
                                <p className="text-xs text-slate-500 max-w-md mt-1.5 leading-relaxed">
                                    Tata letak modular sistem apotek siap
                                    digunakan. Komponen halaman Laravel Inertia
                                    React Anda akan dirender secara otomatis di
                                    area ini.
                                </p>
                            </div>
                        )}
                    </div>
                </main>
                <FloatingChatbot/>
            </div>
        </div>
    );
}