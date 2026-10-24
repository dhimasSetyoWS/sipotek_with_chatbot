import React, { useState } from "react";
import { useEffect } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Plus, CheckCircle2 } from "lucide-react";
import { Head, useForm, usePage, router } from "@inertiajs/react";
import TableObat from "@/Components/Obat/TableObat";
import FilterSearch from "@/Components/Obat/FilterSearch";
import ModalObat from "@/Components/Obat/ModalObat";
import Paginate from "@/Components/Paginate";
import { useDebounce } from "use-debounce";

export default function Index({ medicines, categories, filters }) {
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [searchQuery, setSearchQuery] = useState(filters?.search || "");
    const [selectedClassification, setSelectedClassification] = useState(
        filters?.classification || "all",
    );

    const [modalMode, setModalMode] = useState("add");
    const [debouncedSearch] = useDebounce(searchQuery, 500);

    const handleSearchChange = (e) => {
        setSearchQuery(e.target.value);
    };

    // Trigger request ke backend saat pencarian (dengan debounce) atau klasifikasi berubah
    useEffect(() => {
        router.get(
            route("obat.index"),
            {
                search: debouncedSearch,
                classification: selectedClassification,
            },
            { preserveState: true, replace: true, preserveScroll: true },
        );
    }, [debouncedSearch, selectedClassification]);
    const { flash } = usePage().props;
    const { data, setData, post, processing, errors, clearErrors, reset } =
        useForm({
            category_id: "",
            name: "",
            brand: "",
            active_ingredients: "",
            strength: "",
            dosage_form: "tablet",
            registration_number: "",
            classification: "bebas",
        });
    const handleOpenAddModal = () => {
        reset();
        clearErrors();
        setModalMode("add");
        setIsModalOpen(true);
    };

    const handleOpenEditModal = (med) => {
        clearErrors();
        setData({
            id: med.id,
            category_id: med.category_id,
            name: med.name,
            brand: med.brand || "",
            active_ingredients: med.active_ingredients || "",
            strength: med.strength || "",
            dosage_form: med.dosage_form,
            registration_number: med.registration_number,
            classification: med.classification,
            is_active: med.is_active,
        });
        setModalMode("edit");
        setIsModalOpen(true);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        if (modalMode === "edit") {
            post(route("obat.update", data.id), {
                onSuccess: () => {
                    setIsModalOpen(false);
                    reset();
                },
            });
        } else {
            post(route("obat.store"), {
                onSuccess: () => {
                    setIsModalOpen(false);
                    reset();
                },
            });
        }
    };
    // console.log(JSON.stringify(medicines));

    return (
        <AuthenticatedLayout>
            <Head title="Obat" />
            <div className="space-y-6">
                {flash.success && (
                    <div className="p-4 rounded-xl bg-emerald-50 border border-emerald-200 flex items-center space-x-3 text-emerald-800 shadow-xs animate-in fade-in duration-200">
                        <CheckCircle2 className="w-5 h-5 text-emerald-600 shrink-0" />
                        <div className="text-xs font-semibold">
                            {flash.success}
                        </div>
                    </div>
                )}
                {/* Page Header */}
                <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 className="text-xl font-bold text-slate-800 tracking-tight">
                            Manajemen Katalog Obat
                        </h1>
                        <p className="text-xs text-slate-500 mt-0.5">
                            Kelola data master obat, kandungan zat aktif, nomor
                            izin edar, dan klasifikasi.
                        </p>
                    </div>
                    <button
                        onClick={() => handleOpenAddModal(true)}
                        className="inline-flex items-center justify-center space-x-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-semibold px-4 py-2.5 rounded-lg transition-colors shadow-sm"
                    >
                        <Plus className="w-4 h-4" />
                        <span>Tambah Obat Baru</span>
                    </button>
                </div>

                {/* Filter & Search Toolbar */}
                <FilterSearch
                    searchQuery={searchQuery}
                    setSearchQuery={handleSearchChange}
                    selectedClassification={selectedClassification}
                    setSelectedClassification={setSelectedClassification}
                />

                {/* Table Section */}
                <TableObat
                    obats={medicines.data}
                    openEditModal={handleOpenEditModal}
                />
                {/* Paginate */}
                <Paginate
                    currentPage={medicines.current_page}
                    lastPage={medicines.last_page}
                    from={medicines.from}
                    to={medicines.to}
                    total={medicines.total}
                    prevPageUrl={medicines.prev_page_url}
                    nextPageUrl={medicines.next_page_url}
                    links={medicines.links}
                />

                {/* MODAL TAMBAH OBAT */}
                {isModalOpen && (
                    <ModalObat
                        setIsModalOpen={setIsModalOpen}
                        handleSubmit={handleSubmit}
                        data={data}
                        errors={errors}
                        categories={categories}
                        processing={processing}
                        setData={setData}
                        mode={modalMode}
                    />
                )}
            </div>
        </AuthenticatedLayout>
    );
}
