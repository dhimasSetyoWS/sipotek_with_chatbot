<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\MedicineKnowledge;
use App\Models\Medicine;

class MedicineKnowledgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $search = $request->input('search');
        $status = $request->input('status');

        // Ambil daftar obat beserta knowledge-nya (jika sudah ada)
        $medicines = Medicine::with(['category', 'knowledge'])
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('active_ingredients', 'like', "%{$search}%");
            })
            ->when($status && $status !== 'all', function ($query) use ($status) {
                $query->whereHas('knowledge', function ($q) use ($status) {
                    $q->where('status', $status);
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Medicine/KnowledgeIndex', [
            'medicines' => $medicines,
            'filters' => $request->only(['search', 'status']),
        ]);
    }
    // Untuk badge update status di page
    public function updateStatus(Request $request, Medicine $medicine)
    {
        $request->validate([
            'status' => 'required|in:draft,reviewed',
        ]);

        // Cari atau buat record knowledge jika belum ada
        $knowledge = MedicineKnowledge::firstOrNew(['medicine_id' => $medicine->id]);

        $knowledge->status = $request->status;
        $knowledge->reviewed_at = $request->status === 'reviewed' ? now() : null;
        $knowledge->save();

        return redirect()->back()->with('success', 'Status validasi knowledge berhasil diperbarui.');
    }

    public function storeOrUpdate(Request $request, Medicine $medicine)
    {
        $request->validate([
            'indications' => 'nullable|string',
            'contraindications' => 'nullable|string',
            'warnings' => 'nullable|string',
            'side_effects' => 'nullable|string',
            'source_name' => 'nullable|string|max:255',
            'source_url' => 'nullable|url',
            'status' => 'required|in:draft,reviewed',
        ]);

        MedicineKnowledge::updateOrCreate(
            ['medicine_id' => $medicine->id],
            [
                'indications' => $request->indications,
                'contraindications' => $request->contraindications,
                'warnings' => $request->warnings,
                'side_effects' => $request->side_effects,
                'source_name' => $request->source_name,
                'source_url' => $request->source_url,
                'status' => $request->status,
                'reviewed_at' => $request->status === 'reviewed' ? now() : null,
            ]
        );

        return redirect()->back()->with('success', 'Knowledge base obat berhasil diperbarui.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
