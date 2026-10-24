import {
    LayoutDashboard,
    Pill,
    FileText,
    Truck,
    Receipt,
    Activity,
    Settings,
    TrashOff
} from "lucide-react";

export const PHARMACY_NAV_ITEMS = [
    {
        title: "UTAMA",
        items: [
            {
                name: "Dashboard",
                icon: LayoutDashboard,
                badge: null,
                activeKey: "dashboard",
				target : "dashboard"
            },
            {
                name: "Kasir & POS",
                icon: Receipt,
                badge: "Shift Aktif",
                activeKey: "pos",
				target : "dashboard"

            },
        ],
    },
    {
        title: "MANAJEMEN FARMASI",
        items: [
            {
                name: "Stok & Obat",
                icon: Pill,
                badge: "12 Expiring",
                activeKey: "inventory",
				target : "obat.index"

            },
            {
                name: "Batch & Kadaluwarsa",
                icon: TrashOff,
                // badge: "12 Expiring",
                activeKey: "inventory",
				target : "obat.batches.index"

            },
            {
                name: "Resep Doktor",
                icon: FileText,
                badge: "5 Baru",
                activeKey: "prescriptions",
				target : "dashboard"

            },
            {
                name: "Supplier & Pembelian",
                icon: Truck,
                badge: null,
                activeKey: "suppliers",
				target : "dashboard"

            },
        ],
    },
    {
        title: "LAPORAN & PENGATURAN",
        items: [
            {
                name: "Laporan Penjualan",
                icon: Activity,
                badge: null,
                activeKey: "reports",
				target : "dashboard"

            },
            {
                name: "Pengaturan Apotek",
                icon: Settings,
                badge: null,
                activeKey: "settings",
				target : "dashboard"

            },
        ],
    },
];